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

        $existing = DB::table('website_content_items')
            ->where('page', 'events')
            ->where('section_key', 'hero')
            ->first();

        $row = [
            'page' => 'events',
            'section_key' => 'hero',
            'subtitle' => 'Live events, near you',
            'title' => 'Discover Events. Book Tickets. Join Live.',
            'body' => 'Explore live events across categories and countries. Book tickets and get access to live sessions in one seamless platform.',
            'meta' => json_encode([
                'title_line_1' => 'Discover',
                'title_accent_1' => 'Events.',
                'title_line_2' => 'Book',
                'title_accent_2' => 'Tickets.',
                'title_line_3' => 'Join Live.',
                'subtitle_template' => 'Explore {event_count} live events across {category_count} categories and {country_count} countries. Book tickets and get access to live sessions in one seamless platform.',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => now(),
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert($row + [
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep seeded events page content on rollback.
    }
};
