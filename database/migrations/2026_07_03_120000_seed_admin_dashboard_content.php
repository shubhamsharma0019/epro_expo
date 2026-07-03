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
        $rows = [
            [
                'page' => 'admin_dashboard',
                'section_key' => 'welcome_clear',
                'title' => 'Welcome subtitle',
                'body' => 'All queues are clear. Here is your live platform snapshot.',
                'status' => 'published',
                'sort_order' => 1,
            ],
            [
                'page' => 'admin_dashboard',
                'section_key' => 'visitor_signups_label',
                'title' => 'Visitor chart label',
                'body' => 'Last 7 days',
                'status' => 'published',
                'sort_order' => 2,
            ],
            [
                'page' => 'admin_dashboard',
                'section_key' => 'revenue_mix_label',
                'title' => 'Revenue chart label',
                'body' => 'Live split across platform revenue streams',
                'status' => 'published',
                'sort_order' => 3,
            ],
        ];

        foreach ($rows as $row) {
            $exists = DB::table('website_content_items')
                ->where('page', $row['page'])
                ->where('section_key', $row['section_key'])
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('website_content_items')->insert($row + [
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
            ->where('page', 'admin_dashboard')
            ->whereIn('section_key', ['welcome_clear', 'visitor_signups_label', 'revenue_mix_label'])
            ->delete();
    }
};
