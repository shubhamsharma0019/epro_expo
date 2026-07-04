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

        $this->upsertSingleton('events', 'hero', [
            'subtitle' => 'Live events, near you',
            'title' => 'Discover Events. Book Tickets. Join Live.',
            'body' => 'Explore events across categories and countries. Book your tickets and get access to live sessions as per available slots.',
            'meta' => json_encode([
                'title_line_1' => 'Discover',
                'title_accent_1' => 'Events.',
                'title_line_2' => 'Book',
                'title_accent_2' => 'Tickets.',
                'title_line_3' => 'Join Live.',
                'subtitle_template' => 'Explore {event_count} live events across {category_count} categories and {country_count} countries. Book your tickets and get access to live sessions as per available slots.',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $steps = [
            ['title' => 'Find Your Event', 'body' => 'Browse events by category, location, or specific topics.'],
            ['title' => 'Choose Your Slot', 'body' => 'Select your preferred time slot for available dates.'],
            ['title' => 'Book & Pay', 'body' => 'Secure your spot with a quick and safe checkout.'],
            ['title' => 'Get Your Ticket', 'body' => 'Receive your e-ticket instantly and enjoy the show.'],
        ];

        foreach ($steps as $index => $step) {
            $this->upsertItem('events', 'step', [
                'title' => $step['title'],
                'body' => $step['body'],
                'sort_order' => $index,
                'status' => 'published',
                'updated_at' => $now,
            ], $now);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'events')
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

    private function upsertItem(string $page, string $sectionKey, array $data, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', $sectionKey)
            ->where('title', $data['title'] ?? null)
            ->first();

        $row = array_merge([
            'page' => $page,
            'section_key' => $sectionKey,
            'subtitle' => null,
            'image_url' => null,
            'link_url' => null,
            'link_label' => null,
            'icon' => null,
            'color' => null,
            'meta' => null,
            'status' => 'published',
            'created_at' => $now,
            'updated_at' => $now,
        ], $data);

        if ($existing) {
            unset($row['created_at']);
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert($row);
    }
};
