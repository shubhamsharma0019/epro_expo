<?php

namespace App\Domain\Shared\Services;

use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\DbGuard;
use App\Support\LiveContent;
use Illuminate\Support\Str;

class EventsHomePageData
{
    public function build(): array
    {
        return DbGuard::whenAvailable(function () {
            $publishedEvents = LiveContent::companyEventQuery()
                ->with(['branding', 'ticketTypes'])
                ->latest('updated_at')
                ->get();

            $upcomingEvents = $publishedEvents
                ->filter(fn ($event) => $event->starts_at && $event->starts_at->greaterThanOrEqualTo(now()->startOfDay()))
                ->sortBy('starts_at')
                ->values();

            $carouselEvents = $upcomingEvents->isNotEmpty()
                ? $upcomingEvents
                : $publishedEvents->take(6);

            $categories = $this->buildCategories();
            $countries = $this->buildCountries($publishedEvents);

            return [
                'events' => $publishedEvents->take(6)->map(fn ($event) => $this->mapTrendingEvent($event))->values()->all(),
                'categories' => $categories,
                'countries' => $countries,
                'hero_slides' => $this->buildHeroSlides($carouselEvents),
                'hero_meta' => [
                    'event_count' => LiveContent::companyEventQuery()->count(),
                    'category_count' => count($categories),
                    'country_count' => count($countries),
                ],
                'tickets' => $this->buildTickets(),
                'slots' => $this->buildSlots($upcomingEvents->isNotEmpty() ? $upcomingEvents : $publishedEvents),
                'sample_ticket' => $this->buildSampleTicket($publishedEvents->first()),
            ];
        }, fn () => $this->emptyPayload());
    }

    private function emptyPayload(): array
    {
        return [
            'events' => [],
            'categories' => [],
            'countries' => [],
            'hero_slides' => $this->defaultHeroSlides(),
            'hero_meta' => [
                'event_count' => 0,
                'category_count' => 0,
                'country_count' => 0,
            ],
            'tickets' => [],
            'slots' => [],
            'sample_ticket' => null,
        ];
    }

    private function buildCategories(): array
    {
        $categoryIcons = [
            'technology' => 'technology.svg',
            'business' => 'business.svg',
            'education' => 'education.svg',
            'healthcare' => 'healthcare.svg',
            'marketing' => 'marketing.svg',
            'design' => 'design.svg',
            'finance' => 'finance.svg',
            'lifestyle' => 'lifestyle.svg',
            'manufacturing' => 'business.svg',
        ];

        return LiveContent::companyEventQuery()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(8)
            ->get()
            ->map(function ($row) use ($categoryIcons) {
                $key = Str::slug($row->category);

                return [
                    'icon' => $categoryIcons[$key] ?? 'business.svg',
                    'name' => ucfirst(str_replace('_', ' ', $row->category)),
                    'value' => $row->category,
                    'count' => $row->total . ' ' . Str::plural('Event', $row->total),
                ];
            })
            ->values()
            ->all();
    }

    private function buildCountries($publishedEvents): array
    {
        $countryCounts = $publishedEvents
            ->map(fn ($event) => $this->resolveEventCountry($event))
            ->filter()
            ->countBy()
            ->sortDesc();

        if ($countryCounts->isEmpty()) {
            return [];
        }

        return $countryCounts
            ->map(fn ($count, $country) => [
                'flag' => $this->countryFlag($country),
                'name' => $country,
                'count' => $count . ' ' . Str::plural('Event', $count),
            ])
            ->values()
            ->all();
    }

    private function buildHeroSlides($events): array
    {
        $slides = $events
            ->map(function ($event) {
                $imageUrl = $this->eventImageUrl($event->branding);

                if (! $imageUrl) {
                    return null;
                }

                return [
                    'image' => $imageUrl,
                    'alt' => $event->title,
                    'href' => url('/events/listings/' . $event->slug),
                    'title' => $event->title,
                ];
            })
            ->filter()
            ->values()
            ->all();

        return ! empty($slides) ? $slides : $this->defaultHeroSlides();
    }

    private function defaultHeroSlides(): array
    {
        return [
            [
                'image' => asset('images/events-home/hero-slider/event-hero-tech.png'),
                'alt' => 'Technology event hero',
                'href' => route('events.listings.index'),
            ],
            [
                'image' => asset('images/events-home/hero-slider/event-hero-ai.png'),
                'alt' => 'AI conference hero',
                'href' => route('events.listings.index'),
            ],
            [
                'image' => asset('images/events-home/hero-slider/event-hero-education.png'),
                'alt' => 'Education summit hero',
                'href' => route('events.listings.index'),
            ],
        ];
    }

    private function mapTrendingEvent($event): array
    {
        $startsAt = $event->starts_at;
        $endsAt = $event->ends_at;
        $minTicket = $event->ticketTypes->sortBy('price')->first();
        $isLive = $startsAt && $startsAt->isPast() && (! $endsAt || $endsAt->isFuture());

        if ($isLive) {
            $badge = 'Live Now';
            $badgeClass = 'bg-[#D7194A] text-white';
        } elseif ($startsAt && $startsAt->isToday()) {
            $badge = 'Today';
            $badgeClass = 'bg-[#F36F21] text-white';
        } elseif ($startsAt && $startsAt->isTomorrow()) {
            $badge = 'Tomorrow';
            $badgeClass = 'bg-[#FFF2DF] text-[#C46F10]';
        } else {
            $badge = 'Upcoming';
            $badgeClass = 'bg-[#EEF2FF] text-[#3730A3]';
        }

        return [
            'slug' => $event->slug,
            'badge' => $badge,
            'badgeClass' => $badgeClass,
            'imageUrl' => $this->eventImageUrl($event->branding),
            'title' => $event->title,
            'date' => $startsAt
                ? $startsAt->format('M d') . ($endsAt ? ' - ' . $endsAt->format('d, Y') : ', ' . $startsAt->format('Y'))
                : 'Date TBD',
            'country' => $this->resolveEventCountry($event) ?: 'Location TBD',
            'type' => ucfirst(str_replace('_', ' ', $event->event_mode ?: $event->event_type ?: 'Event')),
            'price' => $minTicket
                ? (($minTicket->currency ?: 'INR') . ' ' . number_format((float) $minTicket->price, 0))
                : 'Free',
        ];
    }

    private function buildTickets(): array
    {
        if (! auth()->check()) {
            return [];
        }

        return VisitorTicket::with(['companyEvent.branding'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($ticket) {
                $event = $ticket->companyEvent;

                return [
                    'imageUrl' => $this->eventImageUrl($event?->branding),
                    'title' => $event?->title ?? 'Event Ticket',
                    'time' => $event?->starts_at
                        ? $event->starts_at->format('M d, Y - h:i A')
                        : 'Date TBD',
                    'type' => $ticket->ticket_name,
                    'orderId' => $ticket->order_number,
                    'status' => ucfirst($ticket->status),
                    'href' => url('/user/tickets/' . $ticket->id . '/e-ticket'),
                ];
            })
            ->values()
            ->all();
    }

    private function buildSlots($events): array
    {
        return $events
            ->filter(fn ($event) => filled($event->starts_at))
            ->take(5)
            ->map(function ($event) {
                $minTicket = $event->ticketTypes->sortBy('price')->first();
                $sold = $event->ticketTypes->sum('quantity_sold');
                $capacity = $event->capacity ?: $event->ticketTypes->sum('quantity_total');
                $seatsLeft = $capacity ? max(0, $capacity - $sold) : null;

                return [
                    'time' => $event->starts_at->format('M d, h:i A') . ($event->ends_at ? ' - ' . $event->ends_at->format('h:i A') : ''),
                    'seats' => $seatsLeft !== null ? $seatsLeft . ' Seats Left' : 'Seats Available',
                    'price' => $minTicket ? (($minTicket->currency ?: 'INR') . ' ' . number_format((float) $minTicket->price, 0)) : 'Free',
                    'href' => url('/events/tickets/select?event=' . $event->slug),
                ];
            })
            ->values()
            ->all();
    }

    private function buildSampleTicket($sampleEvent): ?array
    {
        if (! $sampleEvent) {
            return null;
        }

        return [
            'title' => $sampleEvent->title,
            'date' => $sampleEvent->starts_at?->format('M d, Y') ?? 'Date TBD',
            'time' => $sampleEvent->starts_at
                ? $sampleEvent->starts_at->format('h:i A') . ($sampleEvent->ends_at ? ' - ' . $sampleEvent->ends_at->format('h:i A') : '')
                : 'Time TBD',
            'type' => ucfirst(str_replace('_', ' ', $sampleEvent->event_mode ?: $sampleEvent->event_type ?: 'Event')),
            'holder' => auth()->user()->name ?? 'Visitor',
            'orderId' => 'PREVIEW-' . strtoupper($sampleEvent->slug),
            'qrData' => 'PREVIEW|' . $sampleEvent->slug . '|' . (auth()->user()->email ?? 'visitor'),
        ];
    }

    private function eventImageUrl($branding): ?string
    {
        foreach ([$branding?->banner_path, $branding?->logo_path] as $path) {
            $resolved = LiveContent::resolveCompanyEventBannerUrl($path);

            if ($resolved) {
                return $resolved;
            }
        }

        return null;
    }

    private function resolveEventCountry($event): ?string
    {
        return collect([$event->country, $event->city])
            ->filter(fn ($value) => filled($value))
            ->first();
    }

    private function countryFlag(string $country): string
    {
        $map = [
            'india' => 'in.svg',
            'united states' => 'us.svg',
            'usa' => 'us.svg',
            'united kingdom' => 'uk.svg',
            'uk' => 'uk.svg',
            'canada' => 'ca.svg',
            'australia' => 'au.svg',
            'germany' => 'de.svg',
            'singapore' => 'sg.svg',
            'uae' => 'ae.svg',
            'united arab emirates' => 'ae.svg',
        ];

        return $map[strtolower(trim($country))] ?? 'in.svg';
    }
}
