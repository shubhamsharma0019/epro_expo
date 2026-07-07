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

        $row = DB::table('website_content_items')
            ->where('page', 'events')
            ->where('section_key', 'hero')
            ->first();

        if (! $row) {
            return;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
        $meta = array_merge($meta, [
            'page_font_family' => 'Inter, sans-serif',
            'heading_font_family' => 'Inter, sans-serif',
            'nav_font_family' => 'Inter, sans-serif',
            'nav_font_size' => '14px',
            'nav_font_weight' => '600',
        ]);

        DB::table('website_content_items')->where('id', $row->id)->update([
            'meta' => json_encode($meta),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $row = DB::table('website_content_items')
            ->where('page', 'events')
            ->where('section_key', 'hero')
            ->first();

        if (! $row) {
            return;
        }

        $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
        foreach (['page_font_family', 'heading_font_family'] as $key) {
            unset($meta[$key]);
        }

        DB::table('website_content_items')->where('id', $row->id)->update([
            'meta' => json_encode($meta),
            'updated_at' => now(),
        ]);
    }
};
