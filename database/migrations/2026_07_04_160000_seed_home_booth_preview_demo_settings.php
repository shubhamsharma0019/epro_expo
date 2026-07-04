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
        $existing = DB::table('website_content_items')
            ->where('page', 'home')
            ->where('section_key', 'booth_preview')
            ->first();

        $payload = [
            'page' => 'home',
            'section_key' => 'booth_preview',
            'title' => 'Home exhibitor preview',
            'subtitle' => 'Virtual exhibition demo card',
            'body' => 'Display-only preview on the home page. Buttons do not navigate.',
            'meta' => json_encode([
                'demo_only' => true,
                'label' => 'Demo preview',
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($payload);

            return;
        }

        DB::table('website_content_items')->insert(array_merge($payload, [
            'created_at' => $now,
        ]));
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'home')
            ->where('section_key', 'booth_preview')
            ->delete();
    }
};
