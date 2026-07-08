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

        $meta = [
            'events_url' => '/events',
            'exhibitions_url' => '/exhibitions',
            'features_url' => '/features',
            'pricing_url' => '/pricing',
            'about_url' => '/about-us',
        ];

        $row = DB::table('website_content_items')
            ->where('page', 'exhibitions')
            ->where('section_key', 'navbar')
            ->first();

        if ($row) {
            $existing = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
            DB::table('website_content_items')->where('id', $row->id)->update([
                'meta' => json_encode(array_merge($existing, $meta)),
                'status' => 'published',
                'updated_at' => now(),
            ]);

            return;
        }

        DB::table('website_content_items')->insert([
            'page' => 'exhibitions',
            'section_key' => 'navbar',
            'title' => 'Exhibitions page navigation',
            'meta' => json_encode($meta),
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

        DB::table('website_content_items')
            ->where('page', 'exhibitions')
            ->where('section_key', 'navbar')
            ->delete();
    }
};
