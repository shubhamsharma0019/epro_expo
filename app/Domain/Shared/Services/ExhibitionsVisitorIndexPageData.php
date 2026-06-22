<?php

namespace App\Domain\Shared\Services;

use App\Domain\Event\Models\Exhibition;
use App\Support\LiveContent;
use Illuminate\Support\Collection;

class ExhibitionsVisitorIndexPageData
{
    public function build(): array
    {
        $dynamicExhibitions = LiveContent::exhibitionsForVisitorIndex();
        $exhibitions = $dynamicExhibitions
            ->map(fn (Exhibition $item) => LiveContent::mapExhibitionForListingCard($item))
            ->values()
            ->all();

        $featuredExhibition = $dynamicExhibitions->firstWhere('is_home_featured', true)
            ?? $dynamicExhibitions->first();

        $heroMetrics = LiveContent::exhibitionHeroMetrics($featuredExhibition);
        $heroImageUrl = LiveContent::resolvePublicAssetUrl($heroMetrics['image']);

        $aggregateStats = $this->buildAggregateStats($dynamicExhibitions);
        $featuredTitle = $featuredExhibition
            ? ($featuredExhibition->title ?: $featuredExhibition->name)
            : ($exhibitions[0]['title'] ?? 'Exhibition');
        $featuredSlug = $featuredExhibition?->slug ?? ($exhibitions[0]['slug'] ?? null);

        return [
            'dynamicExhibitions' => $dynamicExhibitions,
            'exhibitions' => $exhibitions,
            'featuredExhibition' => $featuredExhibition,
            'featuredSlug' => $featuredSlug,
            'featuredTitle' => $featuredTitle,
            'heroPavilionsCount' => $heroMetrics['pavilions'],
            'heroHallsCount' => $heroMetrics['halls'],
            'heroBoothsCount' => $heroMetrics['booths'],
            'heroPreviewStatus' => strtoupper($heroMetrics['status']),
            'heroImageUrl' => $heroImageUrl,
            'heroStats' => [
                [number_format($aggregateStats['companies']), 'Companies', 'fa-solid fa-store', '#6325E6'],
                [number_format($aggregateStats['halls']), 'Halls', 'fa-regular fa-map', '#FF9B41'],
                [number_format($aggregateStats['sessions']), 'Sessions', 'fa-regular fa-circle-play', '#3478E5'],
                ['QR', 'Visitor Pass', 'fa-solid fa-qrcode', '#48C4AE'],
            ],
            'exhibitionFilters' => $this->buildFilters($exhibitions),
            'visitorAccessCards' => [
                ['Preview allowed', $featuredTitle . ' details, companies, booth previews, floor map and schedule previews.'],
                ['Pass required', 'Book meeting, live chat, brochure download, protected demo, join session and save booth.'],
            ],
            'visitorTools' => [
                ['Companies', 'Search exhibitors, products, brochures and booth locations.', 'fa-solid fa-building'],
                ['Floor map', 'Preview halls and jump directly to company booth pages.', 'fa-regular fa-map'],
                ['Visitor pass', 'Register once and carry a QR pass for dashboard access.', 'fa-regular fa-id-card'],
                ['Meetings', 'Book meetings, join sessions and continue live chat after entry.', 'fa-regular fa-calendar-check'],
            ],
            'suggestedRouteSteps' => $featuredSlug ? [
                ['01', 'Detail', route('exhibitions.show', $featuredSlug)],
                ['02', 'Companies', route('exhibitions.visitor.companies', $featuredSlug)],
                ['03', 'Map', route('exhibitions.visitor-halls.index', $featuredSlug)],
                ['04', 'QR Pass', route('exhibitions.tickets.select', $featuredSlug)],
            ] : [],
        ];
    }

    private function buildAggregateStats(Collection $dynamicExhibitions): array
    {
        if ($dynamicExhibitions->isEmpty()) {
            return ['companies' => 0, 'halls' => 0, 'sessions' => 0];
        }

        $publishedBookings = $dynamicExhibitions
            ->flatMap(fn ($item) => $item->boothBookings ?? collect())
            ->values();

        return [
            'companies' => $publishedBookings
                ->map(fn ($booking) => $booking->company_id ?: strtolower(trim((string) ($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))))
                ->filter()
                ->unique()
                ->count(),
            'halls' => $publishedBookings->pluck('hall_id')->filter()->unique()->count(),
            'sessions' => $publishedBookings->sum(fn ($booking) => $booking->boothSessions?->count() ?? 0),
        ];
    }

    /** @param list<array<string, mixed>> $exhibitions */
    private function buildFilters(array $exhibitions): array
    {
        $categories = collect($exhibitions)
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return array_values(array_unique(array_merge(['All'], $categories)));
    }
}
