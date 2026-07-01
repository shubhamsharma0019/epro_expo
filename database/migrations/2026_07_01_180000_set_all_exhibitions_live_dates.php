<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        $start = Carbon::today()->subDays(5)->toDateString();
        $end = Carbon::today()->addDays(45)->toDateString();
        $now = now();

        $payload = [
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'active',
            'updated_at' => $now,
        ];

        if (Schema::hasColumn('exhibitions', 'approval_status')) {
            $payload['approval_status'] = 'approved';
        }

        if (Schema::hasColumn('exhibitions', 'publish_status')) {
            $payload['publish_status'] = 'published';
        }

        if (Schema::hasColumn('exhibitions', 'approved_at')) {
            $payload['approved_at'] = $now;
        }

        if (Schema::hasColumn('exhibitions', 'published_at')) {
            $payload['published_at'] = $now;
        }

        DB::table('exhibitions')->update($payload);
    }

    public function down(): void
    {
        // Date backfill is not reversed — original ranges varied per exhibition.
    }
};
