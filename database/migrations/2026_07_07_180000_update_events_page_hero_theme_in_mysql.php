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

        $row = DB::table('website_content_items')
            ->where('page', 'events')
            ->where('section_key', 'hero')
            ->first();

        $theme = [
            'hero_gradient' => 'linear-gradient(135deg, #F6F3FF 0%, #EFE9FE 30%, #F8FAFF 68%, #FFFFFF 100%)',
            'nav_font_family' => "Inter, sans-serif",
            'nav_font_size' => '14px',
            'nav_font_weight' => '600',
            'hero_heading_color' => '#071044',
            'hero_accent_color' => '#6D28D9',
            'hero_body_color' => '#1F2B55',
            'hero_eyebrow_bg' => 'rgba(109, 40, 217, 0.08)',
            'hero_eyebrow_color' => '#6D28D9',
            'hero_eyebrow_border' => 'rgba(109, 40, 217, 0.18)',
        ];

        if ($row) {
            $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
            $meta = array_merge($meta, $theme);

            DB::table('website_content_items')->where('id', $row->id)->update([
                'meta' => json_encode($meta),
                'updated_at' => now(),
            ]);

            return;
        }

        DB::table('website_content_items')->insert([
            'page' => 'events',
            'section_key' => 'hero',
            'subtitle' => 'Live events, near you',
            'title' => 'Discover Events. Book Tickets. Join Live.',
            'body' => 'Explore events across categories and countries. Book tickets and get access to live sessions in one seamless platform.',
            'meta' => json_encode(array_merge([
                'title_line_1' => 'Discover',
                'title_accent_1' => 'Events.',
                'title_line_2' => 'Book',
                'title_accent_2' => 'Tickets.',
                'title_line_3' => 'Join Live.',
                'subtitle_template' => 'Explore {event_count} live events across {category_count} categories and {country_count} countries. Book tickets and get access to live sessions in one seamless platform.',
            ], $theme)),
            'status' => 'published',
            'sort_order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $row = DB::table('website_content_items')
            ->where('page', 'events')
            ->where('section_key', 'hero')
            ->first();

        if (! $row) {
            return;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
        foreach ([
            'hero_gradient',
            'nav_font_family',
            'nav_font_size',
            'nav_font_weight',
            'hero_heading_color',
            'hero_accent_color',
            'hero_body_color',
            'hero_eyebrow_bg',
            'hero_eyebrow_color',
            'hero_eyebrow_border',
        ] as $key) {
            unset($meta[$key]);
        }

        DB::table('website_content_items')->where('id', $row->id)->update([
            'meta' => json_encode($meta),
            'updated_at' => now(),
        ]);
    }
};
