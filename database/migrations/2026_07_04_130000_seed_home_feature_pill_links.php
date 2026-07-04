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
        $pills = [
            ['title' => 'Live Chat', 'icon' => 'far fa-comment-dots', 'link_url' => '/user/browse', 'sort_order' => 1],
            ['title' => 'Video Call', 'icon' => 'fas fa-video', 'link_url' => '/user/meetings', 'sort_order' => 2],
            ['title' => 'Brochures', 'icon' => 'far fa-file-alt', 'link_url' => '/user/browse', 'sort_order' => 3],
            ['title' => 'Enquiries', 'icon' => 'far fa-question-circle', 'link_url' => '/user/browse', 'sort_order' => 4],
            ['title' => 'Appointments', 'icon' => 'far fa-calendar-alt', 'link_url' => '/user/meetings', 'sort_order' => 5],
            ['title' => 'Leaderboard', 'icon' => 'fas fa-trophy', 'link_url' => '/user/dashboard', 'sort_order' => 6],
        ];

        foreach ($pills as $pill) {
            $existing = DB::table('website_content_items')
                ->where('page', 'home')
                ->where('section_key', 'feature_pill')
                ->where('title', $pill['title'])
                ->first();

            if ($existing) {
                DB::table('website_content_items')
                    ->where('id', $existing->id)
                    ->update([
                        'icon' => $pill['icon'],
                        'link_url' => $pill['link_url'],
                        'sort_order' => $pill['sort_order'],
                        'status' => 'published',
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('website_content_items')->insert([
                'page' => 'home',
                'section_key' => 'feature_pill',
                'title' => $pill['title'],
                'icon' => $pill['icon'],
                'link_url' => $pill['link_url'],
                'status' => 'published',
                'sort_order' => $pill['sort_order'],
                'created_at' => $now,
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
            ->where('page', 'home')
            ->where('section_key', 'feature_pill')
            ->whereIn('title', [
                'Live Chat',
                'Video Call',
                'Brochures',
                'Enquiries',
                'Appointments',
                'Leaderboard',
            ])
            ->update([
                'link_url' => null,
                'updated_at' => now(),
            ]);
    }
};
