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
                'section_key' => 'duration_days_help',
                'title' => 'Duration help text',
                'body' => 'Set how many days this exhibition will run. The end date is calculated automatically.',
            ],
            [
                'section_key' => 'duration_days_placeholder',
                'title' => 'Duration placeholder',
                'body' => 'e.g. 3',
            ],
            [
                'section_key' => 'banner_image_help',
                'title' => 'Banner help text',
                'body' => 'Recommended size 1920x600px. PNG, JPG or WebP. Max 2MB.',
            ],
        ];

        foreach ($rows as $row) {
            $existing = DB::table('website_content_items')
                ->where('page', 'admin_exhibition_form')
                ->where('section_key', $row['section_key'])
                ->first();

            if ($existing) {
                DB::table('website_content_items')
                    ->where('id', $existing->id)
                    ->update([
                        'body' => $row['body'],
                        'title' => $row['title'],
                        'status' => 'published',
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('website_content_items')->insert([
                'page' => 'admin_exhibition_form',
                'section_key' => $row['section_key'],
                'title' => $row['title'],
                'body' => $row['body'],
                'status' => 'published',
                'sort_order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Replace any legacy Hinglish copy on this form only.
        DB::table('website_content_items')
            ->where('page', 'admin_exhibition_form')
            ->where(function ($query) {
                $query->where('body', 'like', '%karega%')
                    ->orWhere('body', 'like', '%chlegi%')
                    ->orWhere('body', 'like', '%hogi%')
                    ->orWhere('body', 'like', '%yahan%');
            })
            ->update([
                'body' => 'Set how many days this exhibition will run. The end date is calculated automatically.',
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'admin_exhibition_form')
            ->whereIn('section_key', ['duration_days_help', 'duration_days_placeholder', 'banner_image_help'])
            ->delete();
    }
};
