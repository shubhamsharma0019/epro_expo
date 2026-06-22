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
                    ->publiclyVisible(),
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

        return [
            'slug' => $item->slug,
            'title' => $item->title ?: $item->name,
            'date' => optional($item->start_date)->format('F j') . ' - ' . optional($item->end_date)->format('j, Y'),
            'time' => '10:00 AM - 7:00 PM IST',
            'location' => $item->venue ?: ($item->location ?: 'Virtual'),
            'category' => str_contains(strtolower((string) ($item->location ?: $item->venue ?: '')), 'virtual') ? 'Virtual' : 'On-site / Hybrid',
            'status' => $item->start_date && $item->start_date->isFuture() ? 'Upcoming' : 'Live registration',
            'visitors' => (string) ($item->companies_count ?: max($companyCount, 0)),
            'companies' => (string) $companyCount,
            'halls' => (string) max($hallCount, 1),
            'sessions' => (string) max($publishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0), 1),
            'pass' => 'Free visitor pass available',
            'image' => $image,
            'accent' => '#5b2eff',
            'meta' => trim($productsCount . ' products / ' . $cataloguesCount . ' catalogues'),
            'company_names' => $companyNames->take(3)->all(),
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
        $pavilionsCount = max(
            (int) ($exhibition->active_pavilions_count ?? 0),
            \App\Domain\Event\Models\Pavilion::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('status', 'active')
                ->count(),
            1
        );
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
        $sessionsCount = max($publishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0), 1);

        return [
            'pavilions' => $pavilionsCount,
            'halls' => $hallsCount,
            'booths' => max($boothsCount, 1),
            'companies' => $companyCount,
            'sessions' => $sessionsCount,
            'status' => $exhibition->start_date && $exhibition->start_date->isFuture() ? 'Upcoming' : 'Live registration',
            'image' => $exhibition->banner_image ?: ($exhibition->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png'),
        ];
    }

    public static function homeFeaturedBooths(int $limit = 6): Collection
    {
        return DbGuard::whenAvailable(function () use ($limit) {
            return static::boothBookingQuery()
                ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
                ->withCount([
                    'boothProducts as published_products_count' => fn ($query) => $query->where('status', 'published'),
                    'boothCatalogues as public_catalogues_count' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
                ])
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
                        ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions', 'boothTeamMembers'])
                        ->publiclyVisible(),
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
                $venue = $exhibition->venue ?: ($exhibition->location ?: 'The venue will be updated soon.');
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
