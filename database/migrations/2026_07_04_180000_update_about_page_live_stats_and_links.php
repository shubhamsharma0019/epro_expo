<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();

        $hero = DB::table('website_content_items')
            ->where('page', 'about')
            ->where('section_key', 'hero')
            ->first();

        if ($hero) {
            $meta = json_decode((string) ($hero->meta ?? '{}'), true) ?: [];
            $meta = array_merge($meta, [
                'button_1_label' => $meta['button_1_label'] ?? 'Explore Events',
                'button_1_url' => $meta['button_1_url'] ?? '/events',
                'button_2_label' => $meta['button_2_label'] ?? 'View Features',
                'button_2_url' => $meta['button_2_url'] ?? '/features',
                'cta_button_1_label' => $meta['cta_button_1_label'] ?? ($meta['button_1_label'] ?? 'Explore Events'),
                'cta_button_1_url' => $meta['cta_button_1_url'] ?? ($meta['button_1_url'] ?? '/events'),
                'cta_button_2_label' => $meta['cta_button_2_label'] ?? ($meta['button_2_label'] ?? 'View Features'),
                'cta_button_2_url' => $meta['cta_button_2_url'] ?? ($meta['button_2_url'] ?? '/features'),
                'contact_email' => $meta['contact_email'] ?? 'hello@eproexpo.com',
            ]);

            DB::table('website_content_items')
                ->where('id', $hero->id)
                ->update([
                    'meta' => json_encode($meta),
                    'updated_at' => $now,
                ]);
        }

        $statMeta = [
            'Events Hosted' => ['count_key' => 'events', 'use_live_count' => true],
            'Organisers' => ['count_key' => 'companies', 'use_live_count' => true],
            'Tickets Sold' => ['count_key' => 'tickets', 'use_live_count' => true],
            'Countries' => ['count_key' => 'countries', 'use_live_count' => true],
        ];

        foreach ($statMeta as $subtitle => $meta) {
            DB::table('website_content_items')
                ->where('page', 'about')
                ->where('section_key', 'about_stat')
                ->where('subtitle', $subtitle)
                ->update([
                    'meta' => json_encode($meta),
                    'updated_at' => $now,
                ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'about')
            ->where('section_key', 'about_stat')
            ->update([
                'meta' => null,
                'updated_at' => now(),
            ]);
    }
};
