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

        $planLinks = [
            'Starter Plan' => null,
            'Professional Plan' => null,
            'Enterprise Plan' => '/about-us#contact',
        ];

        foreach ($planLinks as $title => $linkUrl) {
            DB::table('website_content_items')
                ->where('page', 'pricing')
                ->where('section_key', 'pricing_plan')
                ->where('title', $title)
                ->update([
                    'link_url' => $linkUrl,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // No rollback needed.
    }
};
