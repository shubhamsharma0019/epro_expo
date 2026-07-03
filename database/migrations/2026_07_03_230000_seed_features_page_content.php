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

        $this->upsertSingleton('features', 'hero', [
            'subtitle' => 'Platform features',
            'title' => 'Everything you need to run events & exhibitions',
            'body' => 'From self-serve event creation to large-scale virtual expos, eproexpo gives organisers, exhibitors, and visitors one connected platform for building, publishing, and growing live experiences.',
            'meta' => json_encode([
                'button_1_label' => 'Explore Events',
                'button_1_url' => '/events',
                'button_2_label' => 'Browse Exhibitions',
                'button_2_url' => '/exhibitions',
                'cta_title' => 'Ready to explore the platform?',
                'cta_subtitle' => 'Start with events, exhibitions, or a program that grows with your ambition.',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $this->upsertSingleton('features', 'section_headings', [
            'meta' => json_encode([
                'audience_eyebrow' => 'Built for every audience',
                'audience_title' => 'Tools tuned to real event experiences',
                'audience_subtitle' => 'Powerful tools for event organisers, exhibition companies, and visitors — all in one seamless experience.',
                'steps_eyebrow' => 'How it works',
                'steps_title' => 'From setup to a live event, in four steps',
                'flows_eyebrow' => 'User flows',
                'flows_title' => 'Built for every role in the room',
                'cta_eyebrow' => 'Get started',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $flowHeadlines = [
            'Event User Flow' => [
                'headline' => 'Discover, register, and attend',
                'body' => 'Browse events, secure a ticket, and join live sessions — all from one visitor dashboard.',
                'link_label' => 'Open Guide',
            ],
            'Exhibition Visitor Flow' => [
                'headline' => 'Explore halls and connect with booths',
                'body' => 'Walk virtual halls, chat with exhibitors, and collect brochures in one visit.',
                'link_label' => 'Open Guide',
            ],
            'Exhibition Company Flow' => [
                'headline' => 'Design your booth and manage leads',
                'body' => 'Set up your booth, upload assets, and manage incoming visitor leads live.',
                'link_label' => 'Book Booth',
            ],
            'Event Company Flow' => [
                'headline' => 'Publish, sell, and support attendees',
                'body' => 'Create your event, sell tickets, and support attendees end-to-end.',
                'link_label' => 'Get Started',
            ],
        ];

        foreach ($flowHeadlines as $title => $patch) {
            $row = DB::table('website_content_items')
                ->where('page', 'home')
                ->where('section_key', 'flow_card')
                ->where('title', $title)
                ->first();

            if (! $row) {
                continue;
            }

            $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
            $meta['headline'] = $patch['headline'];

            DB::table('website_content_items')
                ->where('id', $row->id)
                ->update([
                    'body' => $patch['body'],
                    'link_label' => $patch['link_label'],
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
            ->where('page', 'features')
            ->whereIn('section_key', ['hero', 'section_headings'])
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
