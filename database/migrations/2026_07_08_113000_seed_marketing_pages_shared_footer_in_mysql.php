<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var list<string> */
    private array $pages = ['events', 'exhibitions', 'features', 'pricing', 'about'];

    public function up(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        $now = now();
        $copyright = '© ' . date('Y') . ' eproexpo. All rights reserved.';

        foreach ($this->pages as $page) {
            $this->upsertFooter($page, $copyright, $now);
            $this->replaceFooterLinks($page, $now);
            $this->replaceSocialLinks($page, $now);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_content_items')) {
            return;
        }

        foreach ($this->pages as $page) {
            DB::table('website_content_items')
                ->where('page', $page)
                ->whereIn('section_key', ['footer', 'footer_link', 'social'])
                ->delete();
        }
    }

    private function upsertFooter(string $page, string $copyright, $now): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', 'footer')
            ->first();

        $row = [
            'page' => $page,
            'section_key' => 'footer',
            'title' => 'Marketing footer',
            'body' => $copyright,
            'meta' => json_encode([
                'contact_email' => null,
                'contact_phone' => null,
            ]),
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);

            return;
        }

        DB::table('website_content_items')->insert($row + [
            'created_at' => $now,
        ]);
    }

    private function replaceFooterLinks(string $page, $now): void
    {
        DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', 'footer_link')
            ->delete();

        $links = [
            ['title' => 'Privacy Policy', 'link_url' => '#', 'sort_order' => 1],
            ['title' => 'Terms of Service', 'link_url' => '#', 'sort_order' => 2],
            ['title' => 'Contact Us', 'link_url' => '#', 'sort_order' => 3],
        ];

        foreach ($links as $link) {
            DB::table('website_content_items')->insert([
                'page' => $page,
                'section_key' => 'footer_link',
                'title' => $link['title'],
                'link_url' => $link['link_url'],
                'status' => 'published',
                'sort_order' => $link['sort_order'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function replaceSocialLinks(string $page, $now): void
    {
        DB::table('website_content_items')
            ->where('page', $page)
            ->where('section_key', 'social')
            ->delete();

        $social = [
            ['icon' => 'fab fa-linkedin-in', 'link_url' => '#', 'sort_order' => 1],
            ['icon' => 'fab fa-twitter', 'link_url' => '#', 'sort_order' => 2],
            ['icon' => 'fab fa-facebook-f', 'link_url' => '#', 'sort_order' => 3],
            ['icon' => 'fab fa-youtube', 'link_url' => '#', 'sort_order' => 4],
        ];

        foreach ($social as $item) {
            DB::table('website_content_items')->insert([
                'page' => $page,
                'section_key' => 'social',
                'icon' => $item['icon'],
                'link_url' => $item['link_url'],
                'status' => 'published',
                'sort_order' => $item['sort_order'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
};
