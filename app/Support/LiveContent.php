<?php

namespace App\Support;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LiveContent
{
    public static function exhibitionQuery(): Builder
    {
        return Exhibition::query()->liveForVisitors();
    }

    public static function exhibitionPageQuery(): Builder
    {
        return static::databaseExhibitionsQuery()
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->liveForVisitors();
                })->orWhereHas('boothBookings', function (Builder $query) {
                    $query->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->whereIn('admin_status', ['approved', 'pending']);
                });
            });
    }

    public static function databaseExhibitionsQuery(): Builder
    {
        return Exhibition::query()
            ->where(function (Builder $query) {
                $query->whereNull('status')
                    ->orWhereNotIn('status', ['cancelled', 'archived', 'rejected', 'inactive']);
            });
    }

    public static function databaseCompanyEventsQuery(): Builder
    {
        return CompanyEvent::query()
            ->where(function (Builder $query) {
                $query->whereNull('status')
                    ->orWhereNotIn('status', ['cancelled', 'archived', 'rejected', 'inactive']);
            });
    }

    public static function companyEventQuery(): Builder
    {
        return CompanyEvent::query()->liveForVisitors();
    }

    public static function companyEventPageQuery(): Builder
    {
        return static::companyEventQuery();
    }

    public static function boothBookingQuery(): Builder
    {
        return BoothBooking::query()->publiclyVisible();
    }

    /** @return list<int> */
    public static function liveExhibitionIds(): array
    {
        return DbGuard::whenAvailable(
            fn () => static::databaseExhibitionsQuery()->pluck('id')->all(),
            []
        );
    }

    public static function exhibitionsForListing(): Collection
    {
        return static::exhibitionsForVisitorIndex();
    }

    public static function exhibitionsForVisitorIndex(): Collection
    {
        return DbGuard::whenAvailable(function () {
            return static::visitorIndexExhibitionQuery()
                ->get()
                ->unique(fn ($exhibition) => strtolower(trim((string) ($exhibition->title ?: $exhibition->name))))
                ->values();
        }, collect());
    }

    public static function visitorIndexExhibitionQuery(): Builder
    {
        return static::exhibitionPageQuery()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothProducts', 'boothCatalogues', 'boothSessions', 'company'])
                    ->registeredExhibitor(),
            ])
            ->orderBy('start_date')
            ->orderBy('id');
    }

    /** @return array<string, mixed> */
    public static function mapExhibitionForListingCard(Exhibition $item): array
    {
        $publishedBookings = $item->boothBookings ?? collect();
        $image = $item->banner_image ?: ($item->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png');
        $companyNames = $publishedBookings
            ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
            ->filter()
            ->unique(fn ($name) => strtolower(trim((string) $name)))
            ->values();
        $companyCount = $companyNames->count();
        $productsCount = $publishedBookings->sum(fn ($booking) => $booking->boothProducts?->where('status', 'published')->count() ?? 0);
        $cataloguesCount = $publishedBookings->sum(fn ($booking) => $booking->boothCatalogues?->where('status', 'active')->where('visibility', 'public')->count() ?? 0);
        $hallCount = DbGuard::whenAvailable(function () use ($item, $publishedBookings) {
            $fromBookings = $publishedBookings->pluck('hall_id')->filter()->unique()->count();
            $fromDb = \App\Domain\Event\Models\Hall::query()
                ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $item->id))
                ->where('status', 'active')
                ->count();

            return max($fromBookings, $fromDb);
        }, 0);
        $sessionsCount = (int) $publishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0);
        $pavilionsCount = DbGuard::whenAvailable(
            fn () => \App\Domain\Event\Models\Pavilion::query()
                ->where('exhibition_id', $item->id)
                ->where('status', 'active')
                ->count(),
            0
        );
        $boothsCount = DbGuard::whenAvailable(
            fn () => \App\Domain\Booth\Models\Booth::query()
                ->whereHas('hall.pavilion', fn ($query) => $query->where('exhibition_id', $item->id))
                ->count(),
            0
        );
        $title = $item->title ?: $item->name;

        return [
            'slug' => $item->slug,
            'title' => $title,
            'date' => $item->start_date
                ? $item->start_date->format('F j') . ($item->end_date ? ' - ' . $item->end_date->format('j, Y') : ', ' . $item->start_date->format('Y'))
                : 'Date TBD',
            'time' => static::resolveExhibitionTime($item),
            'location' => $item->venue ?: ($item->location ?: 'Virtual'),
            'category' => static::resolveExhibitionCategory($item),
            'status' => static::resolveExhibitionStatus($item),
            'visitors' => (string) max($companyCount, (int) ($item->companies_count ?? 0)),
            'companies' => (string) $companyCount,
            'pavilions' => (string) $pavilionsCount,
            'halls' => (string) $hallCount,
            'booths' => (string) $boothsCount,
            'sessions' => (string) $sessionsCount,
            'pass' => 'Free visitor pass available',
            'image' => $image,
            'image_url' => static::resolvePublicAssetUrl($image),
            'accent' => '#5b2eff',
            'meta' => trim($productsCount . ' products / ' . $cataloguesCount . ' catalogues'),
            'company_names' => $companyNames->take(3)->all(),
            'search_text' => strtolower(collect([
                $title,
                $item->venue,
                $item->location,
                $item->description,
            ])->merge($companyNames)->filter()->implode(' ')),
        ];
    }

    /** @return list<array<string, mixed>> */
    public static function exhibitionListingCards(): array
    {
        return static::exhibitionsForListing()
            ->map(fn (Exhibition $item) => static::mapExhibitionForListingCard($item))
            ->values()
            ->all();
    }

    /** @return array{pavilions: int, halls: int, booths: int, companies: int, sessions: int, status: string, image: string} */
    public static function exhibitionHeroMetrics(?Exhibition $exhibition): array
    {
        if (! $exhibition || ! DbGuard::available()) {
            return [
                'pavilions' => 0,
                'halls' => 0,
                'booths' => 0,
                'companies' => 0,
                'sessions' => 0,
                'status' => 'Database offline',
                'image' => 'images/exhibitions/hero-pavilion-scene.png',
            ];
        }

        $publishedBookings = $exhibition->boothBookings ?? collect();
        $pavilionsCount = \App\Domain\Event\Models\Pavilion::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('status', 'active')
            ->count();
        $hallsCount = \App\Domain\Event\Models\Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->where('status', 'active')
            ->count();
        $boothsCount = \App\Domain\Booth\Models\Booth::query()
            ->whereHas('hall.pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->count();
        $companyCount = $publishedBookings
            ->map(fn ($booking) => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
            ->filter()
            ->unique(fn ($name) => strtolower(trim((string) $name)))
            ->count();
        $sessionsCount = (int) $publishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0);

        return [
            'pavilions' => $pavilionsCount,
            'halls' => $hallsCount,
            'booths' => $boothsCount,
            'companies' => $companyCount,
            'sessions' => $sessionsCount,
            'status' => static::resolveExhibitionStatus($exhibition),
            'image' => $exhibition->banner_image ?: ($exhibition->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png'),
        ];
    }

    public static function formatExhibitionDateRange(?\Illuminate\Support\Carbon $start, ?\Illuminate\Support\Carbon $end): string
    {
        if (! $start && ! $end) {
            return 'Date TBD';
        }

        if ($start && $end) {
            if ($start->isSameDay($end)) {
                return $start->format('M d, Y');
            }

            if ($start->year === $end->year) {
                return $start->format('M d') . ' – ' . $end->format('M d, Y');
            }

            return $start->format('M d, Y') . ' – ' . $end->format('M d, Y');
        }

        return ($start ?? $end)->format('M d, Y');
    }

    public static function resolveExhibitionTime(Exhibition $exhibition): string
    {
        if (filled($exhibition->show_start_time)) {
            $start = \Illuminate\Support\Carbon::parse($exhibition->show_start_time)->format('g:i A');
            $end = filled($exhibition->show_end_time)
                ? \Illuminate\Support\Carbon::parse($exhibition->show_end_time)->format('g:i A')
                : null;

            return $end ? $start . ' - ' . $end : $start;
        }

        $session = \App\Domain\Event\Models\AgendaSession::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('start_time')
            ->first();

        if ($session?->start_time) {
            return trim($session->start_time . ($session->end_time ? ' - ' . $session->end_time : ''));
        }

        return 'Time TBD';
    }

    public static function resolveExhibitionStatus(Exhibition $exhibition): string
    {
        if ($exhibition->end_date && $exhibition->end_date->isPast()) {
            return 'Completed';
        }

        if ($exhibition->start_date && $exhibition->start_date->isFuture()) {
            return 'Upcoming';
        }

        if ($exhibition->start_date && $exhibition->start_date->isPast() && (! $exhibition->end_date || $exhibition->end_date->isFuture())) {
            return 'Live now';
        }

        return 'Live registration';
    }

    public static function resolveExhibitionCategory(Exhibition $exhibition): string
    {
        $location = strtolower((string) ($exhibition->location ?: $exhibition->venue ?: ''));

        if (str_contains($location, 'virtual') || str_contains($location, 'online')) {
            return 'Virtual';
        }

        if (str_contains($location, 'hybrid')) {
            return 'Hybrid';
        }

        return 'On-site';
    }

    public static function resolvePublicAssetUrl(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/exhibitions/hero-pavilion-scene.png');
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['images/', 'assets/', 'storage/'])) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public static function resolveCompanyEventBannerUrl(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['images/', 'assets/'])) {
            return file_exists(public_path($path)) ? asset($path) : null;
        }

        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            return file_exists(public_path($path)) ? asset($path) : null;
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return asset('storage/' . ltrim($path, '/'));
        }

        return null;
    }

    public static function resolveCompanyEventBrandingImageUrl(?object $branding, ?string $fallback = null): ?string
    {
        foreach ([$branding?->banner_path, $branding?->logo_path] as $path) {
            $resolved = static::resolveCompanyEventBannerUrl($path);

            if ($resolved) {
                return $resolved;
            }
        }

        return $fallback;
    }

    public static function formatCompanyEventVenue(object|array|null $event, string $fallback = 'Venue TBD'): string
    {
        if ($event === null) {
            return $fallback;
        }

        $value = fn (string $key): string => trim((string) (is_array($event) ? ($event[$key] ?? '') : ($event->{$key} ?? '')));

        $parts = collect([$value('venue_name')])
            ->merge(collect(explode(',', $value('venue_address')))->map(fn ($part) => trim($part))->filter())
            ->push($value('city'), static::normalizeCountryLabel($value('country')))
            ->map(fn ($part) => static::normalizeLocationPart($part))
            ->filter(fn ($part) => $part !== '')
            ->unique(fn ($part) => strtolower(preg_replace('/\s+/', ' ', $part)))
            ->values();

        $formatted = $parts->join(', ');

        return $formatted !== '' ? $formatted : $fallback;
    }

    public static function formatEventLocation(object|array|null $event, string $fallback = 'India'): string
    {
        if ($event === null) {
            return $fallback;
        }

        $value = fn (string $key): string => trim((string) (is_array($event) ? ($event[$key] ?? '') : ($event->{$key} ?? '')));
        $city = static::normalizeLocationPart($value('city'));
        $country = static::normalizeCountryLabel($value('country'));

        if ($city !== '' && $country !== '') {
            return $city . ', ' . $country;
        }

        if ($city !== '') {
            return $city;
        }

        if ($country !== '') {
            return $country;
        }

        return static::resolveEventCardLocation($event, $fallback);
    }

    public static function resolveEventCardLocation(object|array|null $event, string $fallback = 'India'): string
    {
        if ($event === null) {
            return $fallback;
        }

        $value = fn (string $key): string => trim((string) (is_array($event) ? ($event[$key] ?? '') : ($event->{$key} ?? '')));

        foreach ([$value('city'), static::normalizeCountryLabel($value('country'))] as $part) {
            $normalized = static::normalizeLocationPart($part);

            if ($normalized !== '') {
                return $normalized;
            }
        }

        foreach (explode(',', $value('venue_address')) as $part) {
            $normalized = static::normalizeLocationPart(trim($part));

            if ($normalized !== '') {
                return $normalized;
            }
        }

        return $fallback;
    }

    public static function normalizeCountryLabel(string $country): string
    {
        return static::isForeignLocationLabel($country) ? 'India' : $country;
    }

    public static function normalizeLocationPart(string $part): string
    {
        $part = trim($part);

        if ($part === '' || static::isForeignLocationLabel($part)) {
            return '';
        }

        return $part;
    }

    public static function isForeignLocationLabel(string $value): bool
    {
        $normalized = strtolower(trim($value));

        if ($normalized === '') {
            return false;
        }

        $exact = [
            'usa', 'u.s.a.', 'u.s.', 'united states', 'us',
            'uk', 'united kingdom', 'great britain',
            'canada', 'germany', 'australia', 'france', 'singapore',
            'uae', 'united arab emirates',
        ];

        if (in_array($normalized, $exact, true)) {
            return true;
        }

        $contains = [
            'new york', 'chicago', 'london', 'toronto', 'berlin', 'sydney',
            'san francisco', 'san jose', 'los angeles', 'america',
        ];

        foreach ($contains as $needle) {
            if (str_contains($normalized, $needle)) {
                return true;
            }
        }

        return (bool) preg_match('/\b(ny|ca|il|tx)\b,\s*usa\b/i', $value);
    }

    public static function formatExhibitionVenue(object|array|null $exhibition, string $fallback = 'Virtual'): string
    {
        if ($exhibition === null) {
            return $fallback;
        }

        $value = fn (string $key): string => trim((string) (is_array($exhibition) ? ($exhibition[$key] ?? '') : ($exhibition->{$key} ?? '')));

        $venue = $value('venue');
        $locationParts = collect(explode(',', $value('location')))
            ->map(fn ($part) => trim($part))
            ->filter();

        $parts = collect();
        if ($venue !== '') {
            $parts->push($venue);
        }

        foreach ($locationParts as $part) {
            if ($venue !== '' && stripos($venue, $part) !== false) {
                continue;
            }

            $parts->push($part);
        }

        $parts = $parts
            ->filter(fn ($part) => $part !== '')
            ->unique(fn ($part) => strtolower(preg_replace('/\s+/', ' ', $part)))
            ->values();

        $formatted = $parts->join(', ');

        return $formatted !== '' ? $formatted : $fallback;
    }

    public static function homeFeaturedBooths(int $limit = 6): Collection
    {
        return DbGuard::whenAvailable(function () use ($limit) {
            $query = static::boothBookingQuery()
                ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile', 'boothBranding', 'boothCatalogues', 'boothSessions'])
                ->withCount([
                    'boothProducts as published_products_count' => fn ($query) => $query->where('status', 'published'),
                    'boothCatalogues as public_catalogues_count' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
                ]);

            if (DbGuard::hasColumn('booth_bookings', 'is_home_featured')) {
                $query->orderByDesc('is_home_featured');
            }

            return $query
                ->latest()
                ->take($limit)
                ->get()
                ->filter(fn ($booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
                ->values();
        }, collect());
    }

    public static function firstLiveExhibition(): ?Exhibition
    {
        return DbGuard::whenAvailable(
            fn () => static::databaseExhibitionsQuery()->orderBy('start_date')->first(),
            null
        );
    }

    public static function findLiveExhibitionBySlug(string $slug): ?Exhibition
    {
        return DbGuard::whenAvailable(
            fn () => static::databaseExhibitionsQuery()->where('slug', $slug)->first(),
            null
        );
    }

    public static function firstLiveExhibitionSlug(): ?string
    {
        return DbGuard::whenAvailable(
            fn () => static::databaseExhibitionsQuery()->orderBy('start_date')->value('slug'),
            null
        );
    }

    /** @return array<string, mixed>|null */
    public static function exhibitionShowContext(string $slug): ?array
    {
        return DbGuard::whenAvailable(function () use ($slug) {
            $exhibition = static::exhibitionPageQuery()
                ->with([
                    'boothBookings' => fn ($query) => $query
                        ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions', 'boothTeamMembers', 'hall', 'booth'])
                        ->registeredExhibitor(),
                ])
                ->where('slug', $slug)
                ->first();

            if (! $exhibition) {
                return null;
            }

            $speakers = \App\Domain\Event\Models\Speaker::query()
                ->where('exhibition_id', $exhibition->id)
                ->orderBy('name')
                ->get();

            $agenda = \App\Domain\Event\Models\AgendaSession::query()
                ->where('exhibition_id', $exhibition->id)
                ->orderBy('start_time')
                ->get();

            $sponsors = \App\Domain\Event\Models\Sponsor::query()
                ->where('exhibition_id', $exhibition->id)
                ->orderBy('name')
                ->get();

            $faqs = \App\Domain\Event\Models\Faq::query()
                ->where('exhibition_id', $exhibition->id)
                ->orderBy('id')
                ->get();

            if ($faqs->isEmpty()) {
                $title = $exhibition->title ?: $exhibition->name;
                $date = $exhibition->start_date && $exhibition->end_date
                    ? $exhibition->start_date->format('M d') . ' - ' . $exhibition->end_date->format('d, Y')
                    : 'The event date will be updated soon.';
                $venue = static::formatExhibitionVenue($exhibition, 'The venue will be updated soon.');
                $exhibitorCount = $exhibition->boothBookings
                    ->map(fn ($booking) => $booking->company_id ?: $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
                    ->filter()
                    ->unique()
                    ->count();

                $faqs = collect([
                    (object) ['question' => 'When is ' . $title . '?', 'answer' => $date, 'icon' => 'ph-calendar-blank'],
                    (object) ['question' => 'Where is the exhibition hosted?', 'answer' => $venue, 'icon' => 'ph-map-pin'],
                    (object) ['question' => 'How can visitors attend?', 'answer' => 'Visitors can get a visitor pass from this exhibition page and then follow the visitor flow to explore companies, floor map, sessions, meetings and booth details.', 'icon' => 'ph-ticket'],
                    (object) ['question' => 'How many companies are participating?', 'answer' => $exhibitorCount > 0 ? $exhibitorCount . ' companies are currently visible for visitors.' : 'Participating companies will appear here once approved booths are published.', 'icon' => 'ph-buildings'],
                ]);
            }

            $halls = \App\Domain\Event\Models\Hall::whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('status', 'active')
                ->get();

            return compact('exhibition', 'speakers', 'agenda', 'sponsors', 'faqs', 'halls');
        }, null);
    }

    public static function findExhibitionForVisitorFlow(string $slug): ?Exhibition
    {
        return DbGuard::whenAvailable(function () use ($slug) {
            $with = [
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
            ];

            return Exhibition::query()->with($with)->where('slug', $slug)->first()
                ?: Exhibition::query()->with($with)->find($slug);
        }, null);
    }

    public static function agendaSessionForExhibition(?Exhibition $exhibition): ?\App\Domain\Event\Models\AgendaSession
    {
        if (! $exhibition) {
            return null;
        }

        return DbGuard::whenAvailable(
            fn () => \App\Domain\Event\Models\AgendaSession::query()
                ->where('exhibition_id', $exhibition->id)
                ->orderBy('start_time')
                ->first(),
            null
        );
    }
}
