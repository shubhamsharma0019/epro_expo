<?php

namespace App\Domain\Shared\Services;

use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\DbGuard;
use App\Support\LiveContent;
use App\Support\WebsiteContent;

class AboutPageData
{
    public function build(): array
    {
        $hero = WebsiteContent::aboutHero();

        return [
            'aboutHero' => $this->resolveHeroUrls($hero),
            'sectionHeadings' => WebsiteContent::aboutSectionHeadings(),
            'values' => WebsiteContent::aboutValues(),
            'stats' => $this->resolveStats(WebsiteContent::aboutStats()),
            'milestones' => WebsiteContent::aboutMilestones(),
            'partners' => WebsiteContent::aboutPartners(),
        ];
    }

    /** @param array<string, mixed> $hero */
    private function resolveHeroUrls(array $hero): array
    {
        $hero['button_1_url'] = $this->resolveUrl(
            $hero['button_1_url'] ?? null,
            'events.home'
        );
        $hero['button_2_url'] = $this->resolveUrl(
            $hero['button_2_url'] ?? null,
            'frontend.features'
        );
        $hero['cta_button_1_url'] = $this->resolveUrl(
            $hero['cta_button_1_url'] ?? $hero['button_1_url'] ?? null,
            'events.home'
        );
        $hero['cta_button_2_url'] = $this->resolveUrl(
            $hero['cta_button_2_url'] ?? $hero['button_2_url'] ?? null,
            'frontend.features'
        );

        if (empty($hero['contact_email'])) {
            $hero['contact_email'] = WebsiteContent::footer()['contact_email'] ?? 'hello@eproexpo.com';
        }

        return $hero;
    }

    /** @param list<array<string, mixed>> $stats */
    private function resolveStats(array $stats): array
    {
        $counts = (new HomePageData)->platformCounts();
        $ticketCount = $this->ticketCount();
        $countryCount = $this->countryCount();

        $liveValues = [
            'events' => (int) ($counts['events'] ?? 0),
            'companies' => (int) ($counts['companies'] ?? 0),
            'tickets' => $ticketCount,
            'countries' => $countryCount,
        ];

        return array_map(function (array $stat) use ($liveValues) {
            $meta = $stat['meta'] ?? [];
            $countKey = $meta['count_key'] ?? $this->inferCountKey((string) ($stat['subtitle'] ?? ''));

            if (($meta['use_live_count'] ?? true) === false || ! $countKey) {
                return $stat;
            }

            $live = $liveValues[$countKey] ?? 0;
            if ($live > 0) {
                $stat['title'] = $this->formatCount($live);
            }

            return $stat;
        }, $stats);
    }

    private function inferCountKey(string $label): ?string
    {
        $key = strtolower(trim($label));

        return match (true) {
            str_contains($key, 'event') => 'events',
            str_contains($key, 'organis') => 'companies',
            str_contains($key, 'ticket') => 'tickets',
            str_contains($key, 'countr') => 'countries',
            default => null,
        };
    }

    private function ticketCount(): int
    {
        return DbGuard::whenAvailable(function () {
            $eventTickets = VisitorTicket::query()->count();
            $exhibitionPasses = DbGuard::hasTable('visitors')
                ? Visitor::query()->where('payment_status', 'completed')->count()
                : 0;

            return $eventTickets + $exhibitionPasses;
        }, 0);
    }

    private function countryCount(): int
    {
        return DbGuard::whenAvailable(function () {
            $countries = collect();

            if (DbGuard::hasTable('company_events')) {
                $countries = $countries->merge(
                    LiveContent::databaseCompanyEventsQuery()
                        ->whereNotNull('country')
                        ->where('country', '!=', '')
                        ->pluck('country')
                );
            }

            if (DbGuard::hasTable('exhibitions')) {
                $countries = $countries->merge(
                    LiveContent::databaseExhibitionsQuery()
                        ->whereNotNull('country')
                        ->where('country', '!=', '')
                        ->pluck('country')
                );
            }

            return $countries
                ->map(fn ($country) => trim((string) $country))
                ->filter()
                ->unique(fn ($country) => strtolower($country))
                ->count();
        }, 0);
    }

    private function formatCount(int $count): string
    {
        return number_format($count) . '+';
    }

    private function resolveUrl(?string $url, ?string $fallbackRoute = null): string
    {
        if (filled($url)) {
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                return $url;
            }

            if (str_starts_with($url, '/')) {
                return url($url);
            }

            try {
                return route($url);
            } catch (\Throwable) {
                return url($url);
            }
        }

        if ($fallbackRoute) {
            try {
                return route($fallbackRoute);
            } catch (\Throwable) {
                return url('/');
            }
        }

        return url('/');
    }
}
