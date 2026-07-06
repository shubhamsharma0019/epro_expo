<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const PAGES = ['features', 'pricing', 'about'];

    private const URL_META_KEYS = [
        'button_1_url',
        'button_2_url',
        'button_3_url',
        'button_4_url',
        'cta_button_1_url',
        'cta_button_2_url',
        'route',
        'url',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();

        DB::table('website_content_items')
            ->whereIn('page', self::PAGES)
            ->update([
                'link_url' => null,
                'updated_at' => $now,
            ]);

        DB::table('website_content_items')
            ->where('page', 'home')
            ->where('section_key', 'flow_card')
            ->update([
                'link_url' => null,
                'updated_at' => $now,
            ]);

        $rows = DB::table('website_content_items')
            ->where(function ($query) {
                $query->whereIn('page', self::PAGES)
                    ->orWhere(function ($sub) {
                        $sub->where('page', 'home')
                            ->where('section_key', 'flow_card');
                    });
            })
            ->whereNotNull('meta')
            ->get(['id', 'meta']);

        foreach ($rows as $row) {
            $meta = json_decode((string) ($row->meta ?? '{}'), true);

            if (! is_array($meta) || $meta === []) {
                continue;
            }

            foreach (self::URL_META_KEYS as $key) {
                unset($meta[$key]);
            }

            DB::table('website_content_items')
                ->where('id', $row->id)
                ->update([
                    'meta' => json_encode($meta),
                    'updated_at' => $now,
                ]);
        }
    }

    public function down(): void
    {
        // Content display migration — no safe automatic rollback.
    }
};
