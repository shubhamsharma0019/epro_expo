<?php

namespace App\Domain\Shared\Services;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Support\DbGuard;
use App\Support\LiveContent;
use App\Domain\Visitor\Models\Visitor;
use App\Support\WebsiteContent;

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

    private function resolveFeaturePills(): array
    {
        $pills = WebsiteContent::sectionOrDefaults('home', 'feature_pill', WebsiteContent::defaultFeaturePills());
        $slug = $this->primaryExhibitionSlug();

        $routes = [
            'live chat' => $slug ? route('exhibitions.visitor.chat', ['slug' => $slug]) : route('exhibitions.index'),
            'video call' => $slug ? route('exhibitions.visitor.meetings', ['slug' => $slug]) : route('exhibitions.index'),
            'brochures' => $slug ? route('exhibitions.visitor.companies', ['slug' => $slug]) : route('exhibitions.index'),
            'enquiries' => $slug ? route('exhibitions.visitor.companies', ['slug' => $slug]) : route('exhibitions.index'),
            'appointments' => $slug ? route('exhibitions.visitor.meetings', ['slug' => $slug]) : route('exhibitions.index'),
            'leaderboard' => $slug ? route('exhibitions.visitor.dashboard', ['slug' => $slug]) : route('exhibitions.index'),
        ];

        return array_map(function (array $pill) use ($routes) {
            if (! empty($pill['link_url'])) {
                return $pill;
            }

            $key = strtolower(trim((string) ($pill['title'] ?? '')));
            if (isset($routes[$key])) {
                $pill['link_url'] = $routes[$key];
            }

            return $pill;
        }, $pills);
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
            $name = $booking->boothProfile?->company_name
                ?: $booking->company?->company_name
                ?: $booking->company?->name
                ?: 'Exhibitor';

            return [
                'initials' => $this->initials($name),
                'company_name' => $name,
                'tagline' => $booking->boothProfile?->tagline ?: 'Innovating the Future Together',
                'description' => $booking->boothProfile?->about
                    ?: $booking->boothProfile?->description
                    ?: 'We deliver smart solutions that empower businesses to grow faster and smarter.',
                'image_url' => $booking->boothProfile?->banner_image
                    ? asset('storage/' . ltrim($booking->boothProfile->banner_image, '/'))
                    : asset('images/home/booth-preview-new.png'),
                'status' => 'ONLINE',
                'link_url' => $booking->exhibition?->slug && $booking->company?->slug
                    ? route('exhibitions.visitor.companies.show', ['slug' => $booking->exhibition->slug, 'companySlug' => $booking->company->slug])
                    : ($booking->exhibition?->slug ? url('/exhibitions/' . $booking->exhibition->slug) : url('/exhibitions')),
            ];
        }

        $cms = WebsiteContent::publishedItems('home', 'booth_highlight')->first();
        if ($cms) {
            return [
                'initials' => $cms->subtitle ?: 'T/C',
                'company_name' => $cms->title ?: 'TechNova Solutions',
                'tagline' => $cms->link_label ?: 'Innovating the Future Together',
                'description' => $cms->body ?: '',
                'image_url' => $cms->image_url ?: asset('images/home/booth-preview-new.png'),
                'status' => 'ONLINE',
                'link_url' => $cms->link_url ?: url('/exhibitions'),
            ];
        }

        return [
            'initials' => 'T/C',
            'company_name' => 'TechNova Solutions',
            'tagline' => 'Innovating the Future Together',
            'description' => 'We deliver smart solutions that empower businesses to grow faster and smarter.',
            'image_url' => asset('images/home/booth-preview-new.png'),
            'status' => 'ONLINE',
            'link_url' => url('/exhibitions'),
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
        return DbGuard::whenAvailable(fn () => BoothBooking::query()
            ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
            ->latest()
            ->take(6)
            ->get()
            ->filter(fn ($booking) => filled(
                $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name
            ))
            ->values(), collect());
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
}
