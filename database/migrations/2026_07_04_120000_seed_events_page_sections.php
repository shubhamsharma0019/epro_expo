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

        $this->upsertSingleton('events', 'sections', [
            'title' => 'Events page sections',
            'meta' => json_encode([
                'page_title' => 'eproexpo — Discover Events. Book Tickets. Join Live.',
                'search_tab_events' => 'Events',
                'search_tab_exhibitions' => 'Exhibitions',
                'search_label' => 'Search Events',
                'search_placeholder' => 'Search events, organisers...',
                'category_label' => 'Category',
                'category_all' => 'All Categories',
                'country_label' => 'Country',
                'country_all' => 'All Countries',
                'date_label' => 'Date',
                'date_placeholder' => 'mm/dd/yyyy',
                'search_button' => 'Search Events',
                'categories_title' => 'Browse Events by Category',
                'categories_link' => 'View All Categories →',
                'trending_title' => 'Trending Events',
                'trending_link' => 'View All Events →',
                'how_it_works_title' => 'How It Works',
                'slots_title' => 'Ticket Booking & Slots',
                'slots_fallback_event' => 'Upcoming Events',
                'slots_cta' => 'View More Slots',
                'empty_categories_title' => 'No categories yet',
                'empty_categories_body' => 'Published events will populate categories automatically.',
                'empty_events_title' => 'No published events yet',
                'empty_events_body' => 'Published company events will appear here automatically.',
                'empty_slots_title' => 'No ticket slots available yet',
                'empty_slots_body' => 'Published events with dates will appear here.',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $this->upsertSingleton('events', 'footer', [
            'body' => '© ' . date('Y') . ' eproexpo. All rights reserved.',
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'events')
            ->whereIn('section_key', ['sections', 'footer'])
            ->delete();
    }

    private function upsertSingleton(string $page, string $sectionKey, array $data): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->first();

        $row = array_merge([
            'page' => $page,
            'section_key' => $sectionKey,
            'title' => null,
            'subtitle' => null,
            'body' => null,
            'image_url' => null,
            'link_url' => null,
            'link_label' => null,
            'icon' => null,
            'color' => null,
            'meta' => null,
            'sort_order' => 0,
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
        ], $data);

        if ($existing) {
            unset($row['created_at']);
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert($row);
    }
};
