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

        $this->upsertSingleton('about', 'hero', [
            'subtitle' => 'About eproexpo',
            'title' => 'Connecting the world through events & exhibitions',
            'body' => 'eproexpo is an all-in-one platform for virtual events and exhibitions. We help organisers publish events, sell tickets, and engage audiences — while enabling companies to showcase products in immersive booth experiences.',
            'meta' => json_encode([
                'button_1_label' => 'Explore Events',
                'button_1_url' => '/events',
                'button_2_label' => 'View Features',
                'button_2_url' => '/features',
                'cta_title' => 'Connect. Explore. Engage.',
                'cta_subtitle' => 'Ready to learn more or partner with us? Start exploring events and exhibitions today.',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $this->upsertSingleton('about', 'section_headings', [
            'meta' => json_encode([
                'stats_eyebrow' => 'By the Numbers',
                'stats_title' => 'Platform at a glance',
                'journey_eyebrow' => 'Our Journey',
                'journey_title' => 'Building the future of connected events',
                'partners_title' => 'Trusted by organisations worldwide',
                'cta_eyebrow' => 'Get connected',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ]);

        $values = [
            ['title' => 'Our Mission', 'body' => 'To connect people, companies, and communities through seamless virtual events and exhibitions that bring real value to every interaction.', 'icon' => 'fas fa-bullseye', 'color' => '#6D28D9', 'sort_order' => 1],
            ['title' => 'Our Vision', 'body' => 'A world where every event — big or small — can host its most impactful audience, without the barriers of distance or infrastructure.', 'icon' => 'fas fa-rocket', 'color' => '#6D28D9', 'sort_order' => 2],
            ['title' => 'Our Values', 'body' => 'Innovation, accountability, trust, and authentic connection — everything we build is engineered around forming lasting engagement.', 'icon' => 'fas fa-gem', 'color' => '#6D28D9', 'sort_order' => 3],
        ];

        foreach ($values as $value) {
            $this->upsertItem('about', 'about_value', $value, $now);
        }

        $stats = [
            ['title' => '3.2M+', 'subtitle' => 'Events Hosted', 'sort_order' => 1],
            ['title' => '18K+', 'subtitle' => 'Organisers', 'sort_order' => 2],
            ['title' => '7.4M+', 'subtitle' => 'Tickets Sold', 'sort_order' => 3],
            ['title' => '120+', 'subtitle' => 'Countries', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            $this->upsertStat($stat, $now);
        }

        $milestones = [
            ['subtitle' => '2021', 'title' => 'Platform Launch', 'body' => 'Standard events with a lean toolkit meant for scaling organisers of every size.', 'sort_order' => 1],
            ['subtitle' => '2022', 'title' => 'Virtual Exhibitions', 'body' => 'Immersive pavilions, halls, and interactive booths for global exhibitors.', 'sort_order' => 2],
            ['subtitle' => '2023', 'title' => 'Global Growth', 'body' => 'Expansion to enterprise organisers, exhibitors, and visitors across 120+ countries.', 'sort_order' => 3],
            ['subtitle' => '2024', 'title' => 'All-in-One Platform', 'body' => 'Unified events, exhibitions, ticketing, networking, and analytics under one roof.', 'sort_order' => 4],
        ];

        foreach ($milestones as $milestone) {
            $this->upsertMilestone($milestone, $now);
        }

        $partners = [
            ['title' => 'Google', 'sort_order' => 1],
            ['title' => 'Microsoft', 'sort_order' => 2],
            ['title' => 'Deloitte', 'sort_order' => 3],
            ['title' => 'P&G', 'sort_order' => 4],
            ['title' => 'UBS', 'sort_order' => 5],
            ['title' => 'IBM', 'sort_order' => 6],
            ['title' => 'Infosys', 'sort_order' => 7],
            ['title' => 'SIEMENS', 'sort_order' => 8],
            ['title' => 'accenture', 'sort_order' => 9],
        ];

        foreach ($partners as $partner) {
            $this->upsertPartner($partner, $now);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'about')
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
            ->where('title', $data['title'])
            ->first();

        $row = [
            'page' => $page,
            'section_key' => $sectionKey,
            'title' => $data['title'],
            'body' => $data['body'],
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'sort_order' => $data['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }

    private function upsertStat(array $stat, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'about')
            ->where('section_key', 'about_stat')
            ->where('title', $stat['title'])
            ->first();

        $row = [
            'page' => 'about',
            'section_key' => 'about_stat',
            'title' => $stat['title'],
            'subtitle' => $stat['subtitle'],
            'sort_order' => $stat['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }

    private function upsertMilestone(array $milestone, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'about')
            ->where('section_key', 'about_milestone')
            ->where('title', $milestone['title'])
            ->first();

        $row = [
            'page' => 'about',
            'section_key' => 'about_milestone',
            'title' => $milestone['title'],
            'subtitle' => $milestone['subtitle'],
            'body' => $milestone['body'],
            'sort_order' => $milestone['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }

    private function upsertPartner(array $partner, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'about')
            ->where('section_key', 'about_partner')
            ->where('title', $partner['title'])
            ->first();

        $row = [
            'page' => 'about',
            'section_key' => 'about_partner',
            'title' => $partner['title'],
            'sort_order' => $partner['sort_order'],
            'status' => 'published',
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($row, [
            'created_at' => $now,
        ]));
    }
};
