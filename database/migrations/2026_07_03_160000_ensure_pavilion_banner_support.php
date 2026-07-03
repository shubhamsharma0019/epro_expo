<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pavilions') && ! Schema::hasColumn('pavilions', 'image')) {
            Schema::table('pavilions', function (Blueprint $table) {
                $table->string('image')->nullable()->after('description');
            });
        }

        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();

        $existing = DB::table('website_content_items')
            ->where('page', 'admin_pavilion_form')
            ->where('section_key', 'banner_image_help')
            ->first();

        if ($existing) {
            DB::table('website_content_items')
                ->where('id', $existing->id)
                ->update([
                    'body' => 'Recommended size 1600x600px. PNG, JPG or WebP. Max 2MB.',
                    'title' => 'Banner help text',
                    'status' => 'published',
                    'updated_at' => $now,
                ]);

            return;
        }

        DB::table('website_content_items')->insert([
            'page' => 'admin_pavilion_form',
            'section_key' => 'banner_image_help',
            'title' => 'Banner help text',
            'body' => 'Recommended size 1600x600px. PNG, JPG or WebP. Max 2MB.',
            'status' => 'published',
            'sort_order' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        if (Schema::hasTable('website_content_items')) {
            DB::table('website_content_items')
                ->where('page', 'admin_pavilion_form')
                ->where('section_key', 'banner_image_help')
                ->delete();
        }
    }
};
