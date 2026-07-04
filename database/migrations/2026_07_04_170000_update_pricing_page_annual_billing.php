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

        $annualPricing = [
            'Starter Plan' => ['annual_price' => '$0', 'annual_period' => '/year'],
            'Professional Plan' => ['annual_price' => 'Custom', 'annual_period' => '/year'],
            'Enterprise Plan' => ['annual_price' => 'Custom', 'annual_period' => '/year'],
        ];

        foreach ($annualPricing as $title => $annual) {
            $row = DB::table('website_content_items')
                ->where('page', 'pricing')
                ->where('section_key', 'pricing_plan')
                ->where('title', $title)
                ->first();

            if (! $row) {
                continue;
            }

            $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
            $meta['annual_price'] = $annual['annual_price'];
            $meta['annual_period'] = $annual['annual_period'];

            if ($title === 'Enterprise Plan' && empty($meta['route'])) {
                $meta['route'] = 'frontend.about';
            }

            DB::table('website_content_items')
                ->where('id', $row->id)
                ->update([
                    'meta' => json_encode($meta),
                    'updated_at' => now(),
                ]);
        }

        DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'pricing_plan')
            ->where('title', 'Enterprise Plan')
            ->update([
                'link_url' => '/about-us#contact',
                'updated_at' => now(),
            ]);

        $hero = DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'hero')
            ->first();

        if ($hero) {
            $meta = json_decode((string) ($hero->meta ?? '{}'), true) ?: [];
            $meta['button_1_url'] = $meta['button_1_url'] ?? '/company/event-company/login';
            $meta['button_2_url'] = $meta['button_2_url'] ?? '/company';
            $meta['contact_email'] = $meta['contact_email'] ?? 'hello@eproexpo.com';

            DB::table('website_content_items')
                ->where('id', $hero->id)
                ->update([
                    'meta' => json_encode($meta),
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        DB::table('website_content_items')
            ->where('page', 'pricing')
            ->where('section_key', 'pricing_plan')
            ->orderBy('id')
            ->each(function ($row) {
                $meta = json_decode((string) ($row->meta ?? '{}'), true) ?: [];
                unset($meta['annual_price'], $meta['annual_period']);

                DB::table('website_content_items')
                    ->where('id', $row->id)
                    ->update([
                        'meta' => json_encode($meta),
                        'updated_at' => now(),
                    ]);
            });
    }
};
