<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_events')) {
            return;
        }

        $eventId = DB::table('company_events')
            ->where('slug', 'elite-founders-investors-mixer')
            ->value('id');

        if (! $eventId) {
            return;
        }

        $eventUpdates = [];

        if (Schema::hasColumn('company_events', 'capacity')) {
            $eventUpdates['capacity'] = 10;
        }

        if (Schema::hasColumn('company_events', 'venue_address')) {
            $eventUpdates['venue_address'] = 'Bandra Kurla Complex, Mumbai, India';
        }

        if (Schema::hasColumn('company_events', 'summary')) {
            $eventUpdates['summary'] = 'A premium physical networking dinner and pitch mixer.';
        }

        if (Schema::hasColumn('company_events', 'description')) {
            $eventUpdates['description'] = 'Connect with top-tier venture capitalists, angel investors, and high-growth startup founders during a premium physical networking dinner and pitch mixer.';
        }

        if ($eventUpdates !== []) {
            $eventUpdates['updated_at'] = now();

            DB::table('company_events')
                ->where('id', $eventId)
                ->update($eventUpdates);
        }

        if (! Schema::hasTable('company_event_brandings')) {
            return;
        }

        $branding = DB::table('company_event_brandings')
            ->where('company_event_id', $eventId)
            ->first();

        $brandingPayload = [
            'tagline' => 'A premium physical networking dinner and pitch mixer.',
            'updated_at' => now(),
        ];

        if ($branding) {
            if (empty($branding->headline)) {
                $brandingPayload['headline'] = 'Elite Founders & Investors Mixer';
            }

            DB::table('company_event_brandings')
                ->where('id', $branding->id)
                ->update($brandingPayload);
        } elseif (Schema::hasColumn('company_event_brandings', 'company_event_id')) {
            DB::table('company_event_brandings')->insert(array_merge($brandingPayload, [
                'company_event_id' => $eventId,
                'headline' => 'Elite Founders & Investors Mixer',
                'created_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        // Data normalization migration — no safe automatic rollback.
    }
};
