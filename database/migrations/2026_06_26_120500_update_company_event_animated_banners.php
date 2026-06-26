<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const BANNER_BASE = 'images/events-home/banners/animated/';

    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('company_events') || ! DB::getSchemaBuilder()->hasTable('company_event_brandings')) {
            return;
        }

        $events = DB::table('company_events')
            ->where('publish_status', 'published')
            ->select('id', 'slug', 'title', 'category')
            ->get();

        foreach ($events as $event) {
            $bannerPath = $this->resolveBannerPath($event->slug, $event->title, $event->category);

            DB::table('company_event_brandings')
                ->where('company_event_id', $event->id)
                ->update([
                    'banner_path' => $bannerPath,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Banner paths are content data; no automatic rollback.
    }

    private function resolveBannerPath(?string $slug, ?string $title, ?string $category): string
    {
        $slug = Str::lower((string) $slug);
        $title = Str::lower((string) $title);
        $category = Str::lower((string) $category);
        $haystack = $slug . ' ' . $title . ' ' . $category;

        if (Str::contains($haystack, ['ui-ux', 'ui/ux', 'design', 'boot-camp', 'bootcamp'])) {
            return self::BANNER_BASE . 'design-bootcamp.svg';
        }

        if (Str::contains($haystack, ['manufacturing', 'trade-expo', 'trade expo', 'industrial'])) {
            return self::BANNER_BASE . 'manufacturing-trade-expo.svg';
        }

        if (Str::contains($haystack, ['founder', 'investor', 'mixer', 'networking'])) {
            return self::BANNER_BASE . 'founders-investors-mixer.svg';
        }

        if (Str::contains($haystack, ['innovation', 'summit', 'tech', 'ai', 'digital leadership', 'leadership forum'])) {
            return self::BANNER_BASE . 'innovation-tech-summit.svg';
        }

        return self::BANNER_BASE . 'business-enterprise.svg';
    }
};
