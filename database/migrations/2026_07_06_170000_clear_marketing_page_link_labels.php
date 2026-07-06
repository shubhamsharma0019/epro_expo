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

        DB::table('website_content_items')
            ->whereIn('page', ['features', 'pricing', 'about'])
            ->update([
                'link_label' => null,
                'updated_at' => $now,
            ]);

        DB::table('website_content_items')
            ->where('page', 'home')
            ->where('section_key', 'flow_card')
            ->update([
                'link_label' => null,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        // Display-only cleanup — no safe automatic rollback.
    }
};
