<?php

namespace App\Console\Commands;

use App\Domain\Company\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncProjectDataCommand extends Command
{
    protected $signature = 'db:sync-project-data
                            {--migrate : Run pending migrations before syncing}
                            {--seed-base : Seed base admin/company accounts only (optional)}';

    protected $description = 'Sync all application data from MySQL: normalize publish fields, booth counts, booking statuses, and report row counts. No demo seeders.';

    public function handle(): int
    {
        if (config('database.default') !== 'mysql') {
            $this->error('Set DB_CONNECTION=mysql in .env before running this command.');

            return self::FAILURE;
        }

        try {
            DB::connection('mysql')->getPdo();
        } catch (\Throwable $exception) {
            $this->error('MySQL connection failed: ' . $exception->getMessage());
            $this->line('Start MySQL80, then rerun: php artisan db:sync-project-data');

            return self::FAILURE;
        }

        if ($this->option('migrate') || ! Schema::hasTable('migrations')) {
            $this->info('Running migrations...');
            Artisan::call('migrate', ['--force' => true]);
            $this->line(Artisan::output());
        }

        $this->info('Syncing data from MySQL...');

        $this->normalizeExhibitionPublishFields();
        $this->normalizeCompanyEventPublishFields();

        Service::syncDefaultCatalog();

        $syncSummary = \App\Support\DatabaseProjectSync::run();
        foreach ($syncSummary as $task => $count) {
            $this->line(sprintf('  • %s: %d updated', str_replace('_', ' ', $task), $count));
        }

        if ($this->option('seed-base')) {
            $this->info('Seeding base accounts only (--seed-base)...');
            putenv('APP_SEED_DEMO=false');
            putenv('APP_SEED_BASE=true');
            Artisan::call('db:seed', ['--force' => true]);
            $this->line(Artisan::output());
        }

        Artisan::call('storage:link');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        \App\Support\DbGuard::reset();

        $this->newLine();
        $this->info('MySQL sync complete. Row counts:');
        $this->table(['Table', 'Rows'], $this->rowCounts());

        return self::SUCCESS;
    }

    private function normalizeExhibitionPublishFields(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        foreach (DB::table('exhibitions')->orderBy('id')->get() as $row) {
            $status = (string) ($row->status ?? 'active');
            $publishStatus = in_array($status, ['active', 'published', 'live'], true) ? 'published' : (string) ($row->publish_status ?? 'draft');

            DB::table('exhibitions')->where('id', $row->id)->update([
                'approval_status' => $row->approval_status ?: 'approved',
                'publish_status' => $row->publish_status ?: $publishStatus,
                'approved_at' => $row->approved_at ?: now(),
                'published_at' => ($row->published_at ?: ($publishStatus === 'published' ? now() : null)),
            ]);
        }

        $this->line('Normalized exhibition approval/publish fields.');
    }

    private function normalizeCompanyEventPublishFields(): void
    {
        if (! Schema::hasTable('company_events')) {
            return;
        }

        foreach (DB::table('company_events')->orderBy('id')->get() as $row) {
            $status = (string) ($row->status ?? '');
            $publishStatus = in_array($status, ['published', 'live'], true)
                ? 'published'
                : (string) ($row->publish_status ?? 'unpublished');

            DB::table('company_events')->where('id', $row->id)->update([
                'publish_status' => $row->publish_status ?: $publishStatus,
                'visibility' => $row->visibility ?: 'public',
            ]);
        }

        $this->line('Normalized company event publish fields.');
    }

    /** @return list<array{0: string, 1: int|string}> */
    private function rowCounts(): array
    {
        $tables = [
            'admins', 'companies', 'exhibitions', 'pavilions', 'halls', 'booths', 'booth_sizes',
            'booth_bookings', 'booth_profiles', 'booth_products', 'booth_documents', 'booth_catalogues',
            'booth_media', 'company_events', 'company_event_ticket_types', 'visitors', 'visitor_tickets',
            'ticket_tiers', 'speakers', 'sponsors', 'faqs', 'agenda_sessions', 'enquiries', 'services',
            'website_content_items',
        ];

        $rows = [];

        foreach ($tables as $table) {
            $rows[] = [$table, Schema::hasTable($table) ? (int) DB::table($table)->count() : 'missing'];
        }

        return $rows;
    }
}
