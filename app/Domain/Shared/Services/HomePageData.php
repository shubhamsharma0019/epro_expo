<?php

namespace App\Domain\Shared\Services;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMedia;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Support\DbGuard;
use App\Support\LiveContent;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Support\WebsiteContent;
use Illuminate\Support\Facades\DB;

class HomePageData
{
    public function build(): array
    {
        $stats = $this->resolveStats();
        $boothHighlight = $this->resolveBoothHighlight();

        return [
            'hero' => WebsiteContent::hero(),
            'stats' => $stats,
            'experience_tabs' => $this->resolveExperienceTabs(),
            'feature_pills' => $this->resolveFeaturePills(),
            'features' => WebsiteContent::sectionOrDefaults('home', 'feature', WebsiteContent::defaultFeatures()),
            'steps' => WebsiteContent::sectionOrDefaults('home', 'step', WebsiteContent::defaultSteps()),
            'booth_highlight' => $boothHighlight,
            'partners' => WebsiteContent::sectionOrDefaults('home', 'partner', WebsiteContent::defaultPartners()),
            'cta' => WebsiteContent::cta(),
            'cta_benefits' => WebsiteContent::sectionOrDefaults('home', 'cta_benefit', WebsiteContent::defaultCtaBenefits()),
            'footer' => WebsiteContent::footer(),
        ];
    }

    private function resolveStats(): array
    {
        $counts = $this->platformCounts();

        $defaults = [
            ['icon' => 'fa-solid fa-store', 'color' => '#6325E6', 'title' => $this->formatCount($counts['companies']), 'subtitle' => 'Companies'],
            ['icon' => 'fa-regular fa-map', 'color' => '#FF9B41', 'title' => $this->formatCount($counts['halls']), 'subtitle' => 'Halls'],
            ['icon' => 'fa-regular fa-circle-play', 'color' => '#3478E5', 'title' => $this->formatCount($counts['sessions']), 'subtitle' => 'Sessions'],
            [
                'icon' => 'fa-solid fa-qrcode',
                'color' => '#48C4AE',
                'title' => ($counts['visitor_passes'] ?? 0) > 0 ? $this->formatCount($counts['visitor_passes']) : 'QR',
                'subtitle' => 'Visitor Pass',
                'link_url' => $this->visitorPassUrl(),
            ],
        ];

        $cmsStats = WebsiteContent::sectionOrDefaults('home', 'stat', []);
        if (empty($cmsStats)) {
            return $defaults;
        }

        return $this->mergeStatsWithLiveCounts($cmsStats, $counts, $defaults);
    }

    public function featurePills(): array
    {
        return $this->resolveFeaturePills();
    }

    private function resolveFeaturePills(): array
    {
        $pills = WebsiteContent::sectionOrDefaults('home', 'feature_pill', WebsiteContent::defaultFeaturePills());
        $routes = $this->featurePillRoutes();
        $counts = $this->featurePillCounts();

        return array_map(function (array $pill) use ($routes, $counts) {
            $key = strtolower(trim((string) ($pill['title'] ?? '')));

            if (isset($routes[$key])) {
                $pill['link_url'] = $routes[$key];
            } elseif (empty($pill['link_url'])) {
                $pill['link_url'] = route('frontend.user.login');
            }

            if (isset($counts[$key]) && $counts[$key] > 0) {
                $pill['meta'] = array_merge($pill['meta'] ?? [], ['live_count' => $counts[$key]]);
            }

            return $pill;
        }, $pills);
    }

    /** @return array<string, string> */
    private function featurePillRoutes(): array
    {
        return [
            'live chat' => route('frontend.user.browse'),
            'video call' => route('frontend.user.meetings'),
            'brochures' => route('frontend.user.browse'),
            'enquiries' => route('frontend.user.browse'),
            'appointments' => route('frontend.user.meetings'),
            'leaderboard' => route('frontend.user.dashboard'),
        ];
    }

    /** @return array<string, int> */
    private function featurePillCounts(): array
    {
        return DbGuard::whenAvailable(function () {
            $meetings = VisitorMeetingBooking::query()
                ->whereIn('status', ['pending', 'confirmed', 'accepted'])
                ->count();

            $brochures = DbGuard::hasTable('booth_catalogues')
                ? \App\Domain\Booth\Models\BoothCatalogue::query()->count()
                : 0;

            $enquiries = DbGuard::hasTable('enquiries')
                ? DB::table('enquiries')->count()
                : 0;

            $liveSessions = DbGuard::hasTable('booth_sessions')
                ? \App\Domain\Booth\Models\BoothSession::query()->where('status', 'live')->count()
                : 0;

            return [
                'live chat' => $liveSessions,
                'video call' => $meetings,
                'brochures' => $brochures,
                'enquiries' => $enquiries,
                'appointments' => $meetings,
                'leaderboard' => DbGuard::hasTable('visitors')
                    ? Visitor::query()->where('payment_status', 'completed')->count()
                    : 0,
            ];
        }, []);
    }

    private function resolveFlowCards(): array
    {
        $cards = WebsiteContent::sectionOrDefaults('home', 'flow_card', WebsiteContent::defaultFlowCards());

        return array_map(function (array $card) {
            if (! empty($card['link_url'])) {
                return $card;
            }

            if (! empty($card['meta']['route'] ?? null)) {
                try {
                    $card['link_url'] = route($card['meta']['route']);
                } catch (\Throwable) {
                    $card['link_url'] = url('/');
                }
            } elseif (! empty($card['route'] ?? null)) {
                try {
                    $card['link_url'] = route($card['route']);
                } catch (\Throwable) {
                    $card['link_url'] = url('/');
                }
            }

            return $card;
        }, $cards);
    }

    private function resolveBoothHighlight(): array
    {
        $booking = $this->boothHighlights()->first();

        if ($booking) {
            return $this->withBoothPreviewSettings($this->formatBoothHighlight($booking));
        }

        $cms = WebsiteContent::publishedItems('home', 'booth_highlight')->first();
        if ($cms) {
            return $this->withBoothPreviewSettings([
                'initials' => $cms->subtitle ?: 'EX',
                'company_name' => $cms->title ?: 'Featured Exhibitor',
                'industry' => $cms->link_label ?: '',
                'tagline' => $cms->link_label ?: '',
                'description' => $cms->body ?: '',
                'image_url' => $cms->image_url ?: asset('images/home/booth-preview-new.png'),
                'status' => 'ONLINE',
                'has_brochure' => false,
            ]);
        }

        return $this->withBoothPreviewSettings([
            'initials' => 'EX',
            'company_name' => 'Featured Exhibitor',
            'industry' => '',
            'tagline' => '',
            'description' => 'Explore live exhibitor booths, brochures and meetings from the home page preview.',
            'image_url' => asset('images/home/booth-preview-new.png'),
            'status' => 'ONLINE',
            'has_brochure' => false,
        ]);
    }

    /** @param array<string, mixed> $data */
    private function withBoothPreviewSettings(array $data): array
    {
        $settings = WebsiteContent::homeBoothPreviewSettings();

        $data['demo_only'] = (bool) ($settings['demo_only'] ?? true);
        $data['demo_label'] = (string) ($settings['label'] ?? 'Demo preview');

        return $data;
    }

    /** @return array<string, mixed> */
    private function formatBoothHighlight(BoothBooking $booking): array
    {
        $profile = $booking->boothProfile;
        $branding = $booking->boothBranding;
        $company = $booking->company;

        $name = $profile?->company_name
            ?: $company?->company_name
            ?: $company?->name
            ?: 'Exhibitor';

        $industry = $profile?->industry ?: $company?->industry ?: '';
        $description = filled($profile?->about_company)
            ? trim(strip_tags((string) $profile->about_company))
            : trim((string) ($profile?->welcome_text ?: ''));

        if ($description === '') {
            $description = 'Discover products, brochures and live sessions from this exhibitor booth.';
        }

        $bannerPath = $branding?->booth_banner ?: $profile?->booth_banner;
        $imageUrl = $this->resolveBoothHighlightImage($booking, $bannerPath);

        $brochure = $booking->boothCatalogues
            ->first(fn ($item) => ($item->visibility ?? 'public') === 'public' && ($item->status ?? 'active') === 'active');

        $hasLiveSession = $booking->boothSessions->contains(fn ($session) => $session->status === 'live');
        $isLiveBooth = in_array($booking->booth_setup_status, ['live'], true);

        return [
            'initials' => $this->initials($name),
            'company_name' => $name,
            'industry' => $industry,
            'tagline' => $profile?->tagline ?: $industry,
            'description' => $description,
            'image_url' => $imageUrl,
            'status' => ($hasLiveSession || $isLiveBooth) ? 'LIVE' : 'ONLINE',
            'has_brochure' => (bool) $brochure?->file_path,
        ];
    }

    private function featuredExhibitions()
    {
        return DbGuard::whenAvailable(function () {
            $query = LiveContent::databaseExhibitionsQuery()->latest();

            if (DbGuard::hasColumn('exhibitions', 'is_home_featured')) {
                $featured = (clone $query)->where('is_home_featured', true)->take(6)->get();
                if ($featured->isNotEmpty()) {
                    return $featured;
                }
            }

            return $query->take(6)->get();
        }, collect());
    }

    private function featuredEvents()
    {
        return DbGuard::whenAvailable(function () {
            $query = LiveContent::databaseCompanyEventsQuery()->with('branding')->latest('starts_at');

            if (DbGuard::hasColumn('company_events', 'is_home_featured')) {
                $featured = (clone $query)->where('is_home_featured', true)->take(6)->get();
                if ($featured->isNotEmpty()) {
                    return $featured;
                }
            }

            return $query->take(6)->get();
        }, collect());
    }

    private function upcomingEvents()
    {
        return DbGuard::whenAvailable(fn () => LiveContent::databaseCompanyEventsQuery()
            ->with('branding')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->take(6)
            ->get(), collect());
    }

    private function exhibitionCategories(): array
    {
        if (! DbGuard::hasTable('exhibitions')) {
            return [];
        }

        $fromEvents = DbGuard::whenAvailable(fn () => LiveContent::databaseCompanyEventsQuery()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->all(), []);

        $fromCms = WebsiteContent::sectionOrDefaults('home', 'exhibition_category', []);

        if (! empty($fromCms)) {
            return array_map(fn ($item) => $item['title'] ?? $item['subtitle'] ?? '', $fromCms);
        }

        return $fromEvents;
    }

    private function featuredCompanies()
    {
        return DbGuard::whenAvailable(function () {
            $query = Company::query()->where('status', 'approved');

            if (DbGuard::hasColumn('companies', 'is_home_featured')) {
                $featured = (clone $query)->where('is_home_featured', true)->take(8)->get();
                if ($featured->isNotEmpty()) {
                    return $featured;
                }
            }

            return $query->latest()->take(8)->get();
        }, collect());
    }

    private function boothHighlights()
    {
        return DbGuard::whenAvailable(function () {
            $query = BoothBooking::query()
                ->with([
                    'company',
                    'exhibition',
                    'hall',
                    'booth',
                    'boothProfile',
                    'boothBranding',
                    'boothCatalogues',
                    'boothSessions',
                    'boothMedia',
                ])
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->whereIn('booth_setup_status', ['published', 'approved', 'live']);

            if (DbGuard::hasColumn('booth_bookings', 'is_home_featured')) {
                $query->orderByDesc('is_home_featured');
            }

            return $query
                ->latest()
                ->take(6)
                ->get()
                ->filter(fn ($booking) => filled(
                    $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name
                ))
                ->values();
        }, collect());
    }

    public function platformCounts(): array
    {
        return DbGuard::whenAvailable(fn () => [
            'exhibitions' => DbGuard::hasTable('exhibitions')
                ? LiveContent::databaseExhibitionsQuery()->count()
                : 0,
            'companies' => DbGuard::hasTable('companies')
                ? Company::where('status', 'approved')->count()
                : 0,
            'events' => DbGuard::hasTable('company_events')
                ? LiveContent::databaseCompanyEventsQuery()->count()
                : 0,
            'booths' => DbGuard::hasTable('booth_bookings')
                ? BoothBooking::query()
                    ->where('payment_status', 'paid')
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
                    ->count()
                : 0,
            'halls' => DbGuard::hasTable('halls')
                ? \App\Domain\Event\Models\Hall::where('status', 'active')->count()
                : 0,
            'sessions' => $this->sessionCount(),
            'visitor_passes' => DbGuard::hasTable('visitors')
                ? Visitor::query()->where('payment_status', 'completed')->count()
                : 0,
        ], [
            'events' => 0,
            'exhibitions' => 0,
            'companies' => 0,
            'booths' => 0,
            'halls' => 0,
            'sessions' => 0,
            'visitor_passes' => 0,
        ]);
    }

    private function mergeStatsWithLiveCounts(array $cmsStats, array $counts, array $defaults): array
    {
        return array_map(function (array $stat, int $index) use ($counts, $defaults) {
            $fallback = $defaults[$index] ?? [];
            $subtitle = strtolower(trim((string) ($stat['subtitle'] ?? $fallback['subtitle'] ?? '')));

            $liveTitle = match ($subtitle) {
                'companies' => $this->formatCount($counts['companies'] ?? 0),
                'halls' => $this->formatCount($counts['halls'] ?? 0),
                'sessions' => $this->formatCount($counts['sessions'] ?? 0),
                'visitor pass' => ($counts['visitor_passes'] ?? 0) > 0
                    ? $this->formatCount($counts['visitor_passes'])
                    : 'QR',
                default => $stat['title'] ?? $fallback['title'] ?? '',
            };

            return array_merge($fallback, $stat, [
                'title' => $liveTitle,
                'link_url' => $stat['link_url'] ?? $fallback['link_url'] ?? null,
            ]);
        }, $cmsStats, array_keys($cmsStats));
    }

    private function primaryExhibitionSlug(): ?string
    {
        return DbGuard::whenAvailable(
            fn () => LiveContent::exhibitionQuery()->value('slug'),
            null
        );
    }

    private function visitorPassUrl(): string
    {
        $slug = $this->primaryExhibitionSlug();

        if ($slug) {
            try {
                return route('exhibitions.tickets.visitor-details', ['slug' => $slug]);
            } catch (\Throwable) {
                return route('exhibitions.index');
            }
        }

        return route('exhibitions.index');
    }

    private function formatCount(int $count): string
    {
        return number_format($count) . '+';
    }

    private function sessionCount(): int
    {
        $total = 0;

        if (DbGuard::hasTable('agenda_sessions')) {
            $total += \App\Domain\Event\Models\AgendaSession::count();
        }

        if (DbGuard::hasTable('booth_sessions')) {
            $total += \App\Domain\Booth\Models\BoothSession::count();
        }

        if (DbGuard::hasTable('company_event_sessions')) {
            $total += \App\Domain\Event\Models\CompanyEvent\CompanyEventSession::count();
        }

        return $total;
    }

    private function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $letters = collect($parts)->take(2)->map(fn ($p) => strtoupper(substr($p, 0, 1)))->implode('');

        return $letters ?: 'EX';
    }

    private function resolveExperienceTabs(): array
    {
        return WebsiteContent::sectionOrDefaults('home', 'experience_tab', [
            ['title' => 'Pavilions', 'image_url' => asset('images/exhibitions/hero-pavilion-scene.png')],
            ['title' => 'Halls', 'image_url' => asset('images/exhibitions/info-hall-floorplan.png')],
            ['title' => 'Booths', 'image_url' => asset('images/exhibitions/info-custom-booth.png')],
        ]);
    }

    private function resolveBoothHighlightImage(BoothBooking $booking, ?string $bannerPath): string
    {
        foreach ($this->boothHighlightImageCandidates($booking, $bannerPath) as $candidate) {
            $url = $this->resolvePublicAssetUrl($candidate);

            if ($url !== null) {
                return $url;
            }
        }

        return $this->defaultBoothPreviewImage();
    }

    /** @return list<string> */
    private function boothHighlightImageCandidates(BoothBooking $booking, ?string $bannerPath): array
    {
        $candidates = array_filter([
            $bannerPath,
            $booking->boothProfile?->company_logo,
        ]);

        foreach ($booking->boothMedia as $media) {
            if (! $media instanceof BoothMedia) {
                continue;
            }

            if ($media->resolvedType() === 'image' && filled($media->file_path)) {
                $candidates[] = $media->file_path;
            }

            if (filled($media->video_url)) {
                $candidates[] = $media->video_url;
            }
        }

        $candidates[] = $booking->exhibition?->banner_url;
        $candidates[] = $booking->exhibition?->banner_image;

        return array_values(array_filter($candidates, fn ($value) => filled($value)));
    }

    private function resolvePublicAssetUrl(string $path): ?string
    {
        return \App\Support\MediaUrl::url($path);
    }

    private function storageAssetExists(string $path): bool
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return true;
        }

        return file_exists(storage_path('app/public/' . ltrim($path, '/')));
    }

    private function defaultBoothPreviewImage(): string
    {
        foreach (['images/home/booth-preview-new.png', 'images/home/booth-preview.svg'] as $relative) {
            if (file_exists(public_path($relative))) {
                return asset($relative);
            }
        }

        return asset('images/home/booth-preview.svg');
    }
}

