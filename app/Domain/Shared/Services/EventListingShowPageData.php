<?php

namespace App\Domain\Shared\Services;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Support\LiveContent;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EventListingShowPageData
{
    public function build(string $slug): ?array
    {
        $dbEvent = LiveContent::companyEventPageQuery()
            ->with([
                'branding',
                'ticketTypes' => fn ($query) => $query->orderBy('price'),
                'sessions' => fn ($query) => $query->orderBy('starts_at'),
                'speakers' => fn ($query) => $query->orderBy('name'),
                'company',
            ])
            ->where('slug', $slug)
            ->first();

        if ($dbEvent) {
            return $this->fromDatabaseEvent($dbEvent);
        }

        $staticEvent = $this->staticEventDetails()[$slug] ?? null;

        if ($staticEvent) {
            return $this->fromStaticEvent($slug, $staticEvent);
        }

        return null;
    }

    private function fromDatabaseEvent(CompanyEvent $dbEvent): array
    {
        $ticketTypes = $dbEvent->ticketTypes ?? collect();
        $sessions = $dbEvent->sessions ?? collect();
        $speakers = $dbEvent->speakers ?? collect();
        $minTicket = $ticketTypes->sortBy('price')->first();
        $minPrice = $minTicket?->price;
        $currency = strtoupper($minTicket?->currency ?: 'INR');
        $currencySymbols = ['INR' => 'Rs. ', 'USD' => '$', 'EUR' => 'EUR ', 'GBP' => 'GBP '];
        $price = $minPrice !== null
            ? (($currencySymbols[$currency] ?? $currency . ' ') . number_format((float) $minPrice, 2))
            : 'Free';

        $eventVenue = LiveContent::formatCompanyEventVenue($dbEvent, 'Location TBD');
        $eventWebsite = $dbEvent->website ?: $dbEvent->company?->website;
        $eventWebsiteUrl = $eventWebsite
            ? (str_starts_with($eventWebsite, 'http') ? $eventWebsite : 'https://' . $eventWebsite)
            : null;

        $organizerName = $dbEvent->company?->company_name
            ?: $dbEvent->company?->name
            ?: $dbEvent->company?->contact_person_name
            ?: 'Organizer TBD';

        $eventDays = $dbEvent->starts_at && $dbEvent->ends_at
            ? max(1, $dbEvent->starts_at->copy()->startOfDay()->diffInDays($dbEvent->ends_at->copy()->startOfDay()) + 1)
            : 1;

        $ticketCapacity = (int) $ticketTypes->sum('quantity_total');
        $ticketSold = (int) $ticketTypes->sum('quantity_sold');
        $eventCapacity = (int) ($dbEvent->capacity ?: $ticketCapacity);
        $seatsLeft = $eventCapacity > 0 ? max(0, $eventCapacity - $ticketSold) : null;

        $summary = $this->meaningfulText($dbEvent->summary);
        $description = $this->meaningfulText($dbEvent->description, $dbEvent->summary);
        $tagline = $this->meaningfulText(
            $dbEvent->branding?->tagline,
            $dbEvent->summary,
        ) ?: $this->defaultTagline($dbEvent);

        $title = $this->meaningfulText($dbEvent->branding?->headline, $dbEvent->title) ?: $dbEvent->title;

        $highlights = collect($dbEvent->highlights ?: [])
            ->filter(fn ($value) => filled($value) && ! $this->isPlaceholderText($value))
            ->values()
            ->all();

        if (empty($highlights)) {
            $highlights = collect([
                $eventDays > 1 ? $eventDays . ' days event' : '1 day event',
                $sessions->count() ? $sessions->count() . ' sessions planned' : null,
                $speakers->count() ? $speakers->count() . ' speakers' : null,
                $eventCapacity ? number_format($eventCapacity) . ' attendee capacity' : null,
                $seatsLeft !== null ? number_format($seatsLeft) . ' seats left' : null,
                $dbEvent->event_mode ? ucfirst(str_replace('_', ' ', $dbEvent->event_mode)) . ' event experience' : null,
            ])->filter()->values()->all();
        }

        $event = [
            'title' => $title,
            'tagline' => $tagline,
            'date' => $dbEvent->starts_at
                ? $dbEvent->starts_at->format('M d') . ($dbEvent->ends_at ? ' - ' . $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format(', Y'))
                : 'Date TBD',
            'venue' => $eventVenue ?: 'Location TBD',
            'price' => $price,
            'image' => $this->eventImageUrl($dbEvent->branding)
                ?: 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
            'description' => $description ?: ($summary ?: $dbEvent->title . ' event information will be updated soon.'),
            'website' => $eventWebsite ?: 'Not provided',
            'website_url' => $eventWebsiteUrl,
            'organizer' => $organizerName,
            'category' => collect([$dbEvent->category, $dbEvent->sub_category])
                ->filter()
                ->map(fn ($value) => ucfirst(str_replace('_', ' ', $value)))
                ->join(', ') ?: 'General',
            'event_id' => 'EVT-' . str_pad((string) $dbEvent->id, 4, '0', STR_PAD_LEFT),
            'time' => $dbEvent->starts_at
                ? $dbEvent->starts_at->format('h:i A') . ($dbEvent->ends_at ? ' - ' . $dbEvent->ends_at->format('h:i A') : '') . ($dbEvent->timezone ? ' (' . $dbEvent->timezone . ')' : '')
                : 'Time TBD',
            'tags' => collect([$dbEvent->event_mode, $dbEvent->category, $dbEvent->sub_category])
                ->filter()
                ->map(fn ($value) => ucfirst(str_replace('_', ' ', $value)))
                ->unique()
                ->values()
                ->all(),
            'highlights' => $highlights,
        ];

        return [
            'dbEvent' => $dbEvent,
            'eventSlug' => $dbEvent->slug,
            'event' => $event,
            'heroStats' => $this->buildHeroStats($dbEvent, $eventDays, $eventCapacity, $seatsLeft),
            'sessions' => $sessions,
            'speakers' => $speakers,
            'eventTabs' => $this->buildTabs($event, $sessions, $speakers),
        ];
    }

    private function fromStaticEvent(string $slug, array $staticEvent): array
    {
        $event = $staticEvent;
        $event['tags'] = collect(explode(',', $event['category'] ?? 'Event'))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();
        $event['highlights'] = [
            'Event schedule information',
            'Ticket booking available',
            'Organizer details provided',
        ];

        return [
            'dbEvent' => null,
            'eventSlug' => $slug,
            'event' => $event,
            'heroStats' => $this->buildHeroStats(null, 1, null, null, $event),
            'sessions' => collect(),
            'speakers' => collect(),
            'eventTabs' => collect([
                ['label' => 'About', 'href' => '#event-about', 'show' => true],
            ])->filter(fn ($tab) => $tab['show'])->values(),
        ];
    }

    private function buildTabs(array $event, Collection $sessions, Collection $speakers): Collection
    {
        return collect([
            ['label' => 'About', 'href' => '#event-about', 'show' => filled($event['description']) || count($event['highlights']) > 0],
            ['label' => 'Schedule', 'href' => '#event-agenda', 'show' => $sessions->isNotEmpty()],
            ['label' => 'Speakers', 'href' => '#event-speakers', 'show' => $speakers->isNotEmpty()],
            ['label' => 'Location', 'href' => '#event-venue', 'show' => filled($event['venue'])],
        ])->filter(fn ($tab) => $tab['show'])->values();
    }

    private function buildHeroStats(?CompanyEvent $dbEvent, int $eventDays = 1, ?int $eventCapacity = null, ?int $seatsLeft = null, ?array $staticEvent = null): array
    {
        $mode = $dbEvent?->event_mode
            ? ucfirst(str_replace('_', ' ', $dbEvent->event_mode))
            : ($staticEvent['tags'][0] ?? 'In person');

        return [
            [
                'icon' => 'far fa-calendar-alt',
                'value' => ($eventDays > 1 ? $eventDays . ' days' : '1 day'),
                'label' => 'Event length',
            ],
            [
                'icon' => 'fas fa-users',
                'value' => $eventCapacity ? number_format($eventCapacity) . ' attendees' : 'Open capacity',
                'label' => 'Capacity',
            ],
            [
                'icon' => 'far fa-ticket-alt',
                'value' => $seatsLeft !== null ? number_format($seatsLeft) . ' seats' : 'Available',
                'label' => 'Still available',
            ],
            [
                'icon' => 'fas fa-building',
                'value' => $mode,
                'label' => 'Experience',
            ],
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

    private function meaningfulText(?string ...$candidates): ?string
    {
        foreach ($candidates as $text) {
            if (! $this->isPlaceholderText($text)) {
                return trim($text);
            }
        }

        return null;
    }

    private function isPlaceholderText(?string $text): bool
    {
        if (! filled($text)) {
            return true;
        }

        $normalized = strtolower(trim($text));
        $needles = [
            'identify static data',
            'replace it with dynamic data',
            'event information will be updated soon',
            'add an event summary',
            'add a detailed event description',
            'event tagline will appear here',
            'lorem ipsum',
            'placeholder',
        ];

        foreach ($needles as $needle) {
            if (str_contains($normalized, $needle)) {
                return true;
            }
        }

        return false;
    }

    private function defaultTagline(CompanyEvent $dbEvent): string
    {
        $parts = collect([
            $dbEvent->category ? ucfirst(str_replace('_', ' ', $dbEvent->category)) : null,
            $dbEvent->event_mode ? ucfirst(str_replace('_', ' ', $dbEvent->event_mode)) . ' event' : null,
        ])->filter();

        return $parts->isNotEmpty()
            ? $parts->join(' · ')
            : 'Event details and tickets are available now.';
    }

    private function staticEventDetails(): array
    {
        return [
            'global-tech-summit-2024' => [
                'title' => 'Global Tech Summit 2024',
                'tagline' => 'Innovate. Connect. Transform.',
                'date' => 'May 15 - May 17, 2024',
                'venue' => 'Jio World Convention Centre, Mumbai',
                'price' => 'Rs. 49.00',
                'image' => asset('images/events-home/trending/global-tech-summit.svg'),
                'description' => 'Global Tech Summit 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.globaltechsummit.com',
                'website_url' => url('/events'),
                'organizer' => 'TechFuture Events',
                'category' => 'Technology, Conference',
                'event_id' => 'GTS-2024-MUM',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'world-ai-conference-2024' => [
                'title' => 'World AI Conference 2024',
                'tagline' => 'Explore the next generation of intelligent products.',
                'date' => 'May 18 - May 19, 2024',
                'venue' => 'Bengaluru International Exhibition Centre, Bengaluru',
                'price' => 'Rs. 29.00',
                'image' => asset('images/events-home/trending/world-ai-conference.svg'),
                'description' => 'World AI Conference 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.worldai.com',
                'website_url' => url('/events'),
                'organizer' => 'AI Global Forum',
                'category' => 'AI, Conference',
                'event_id' => 'WAI-2024-BLR',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'digital-marketing-summit' => [
                'title' => 'Digital Marketing Summit',
                'tagline' => 'Growth, content, performance, and brand strategy.',
                'date' => 'May 21, 2024',
                'venue' => 'Jio World Convention Centre, Mumbai',
                'price' => 'Rs. 19.00',
                'image' => asset('images/events-home/trending/digital-marketing-summit.svg'),
                'description' => 'Digital Marketing Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.digitalmarketing.com',
                'website_url' => url('/events'),
                'organizer' => 'Marketing Assoc',
                'category' => 'Marketing, Summit',
                'event_id' => 'DMS-2024-MUM',
                'time' => '09:00 AM - 05:00 PM (IST)',
            ],
            'healthcare-innovation-2024' => [
                'title' => 'Healthcare Innovation 2024',
                'tagline' => 'Modern healthcare, diagnostics, and patient experience.',
                'date' => 'May 18 - May 20, 2024',
                'venue' => 'HITEC City Convention Centre, Hyderabad',
                'price' => 'Rs. 39.00',
                'image' => asset('images/events-home/trending/healthcare-innovation.svg'),
                'description' => 'Healthcare Innovation 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.healthcare-innovation.in',
                'website_url' => url('/events'),
                'organizer' => 'MedTech India',
                'category' => 'Healthcare, Innovation',
                'event_id' => 'HCI-2024-HYD',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'future-of-education-summit' => [
                'title' => 'Future of Education Summit',
                'tagline' => 'Learning technology, classrooms, and skills for tomorrow.',
                'date' => 'May 25 - May 26, 2024',
                'venue' => 'India Expo Centre, Greater Noida',
                'price' => 'Rs. 24.00',
                'image' => asset('images/events-home/trending/future-education.svg'),
                'description' => 'Future of Education Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.futureeducation.in',
                'website_url' => url('/events'),
                'organizer' => 'EdTech India',
                'category' => 'Education, Summit',
                'event_id' => 'FES-2024-DEL',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'sustainability-forum-2024' => [
                'title' => 'Sustainability Forum 2024',
                'tagline' => 'Climate, circular business, and clean growth.',
                'date' => 'May 27 - May 28, 2024',
                'venue' => 'Pune International Exhibition Centre, Pune',
                'price' => 'Rs. 19.00',
                'image' => asset('images/events-home/trending/sustainability-forum.svg'),
                'description' => 'Sustainability Forum 2024 brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.sustainabilityforum.in',
                'website_url' => url('/events'),
                'organizer' => 'GreenBusiness India',
                'category' => 'Sustainability, Forum',
                'event_id' => 'SUF-2024-PUN',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'future-of-ai-expo' => [
                'title' => 'Future of AI Expo',
                'tagline' => 'AI products, demos, and automation showcases.',
                'date' => 'Jun 10 - Jun 12, 2024',
                'venue' => 'Pragati Maidan, New Delhi',
                'price' => 'Rs. 29.00',
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Future of AI Expo brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.futureaiexpo.com',
                'website_url' => url('/events'),
                'organizer' => 'AI Tech Association',
                'category' => 'AI, Expo',
                'event_id' => 'AIX-2024-DEL',
                'time' => '10:00 AM - 06:00 PM (IST)',
            ],
            'sustainability-forum' => [
                'title' => 'Sustainability Forum',
                'tagline' => 'Clean energy, climate action, and sustainable business.',
                'date' => 'Jun 20, 2024',
                'venue' => 'BEC, Bangalore',
                'price' => 'Rs. 19.00',
                'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Sustainability Forum brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.sustainabilityforum.in',
                'website_url' => url('/events'),
                'organizer' => 'GreenTech Forum',
                'category' => 'Sustainability, Conference',
                'event_id' => 'SUS-2024-BLR',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
            'healthcare-innovation-summit' => [
                'title' => 'Healthcare Innovation Summit',
                'tagline' => 'Healthcare leaders, product innovation, and care delivery.',
                'date' => 'Jul 01 - Jul 02, 2024',
                'venue' => 'HICC, Hyderabad',
                'price' => 'Rs. 39.00',
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Healthcare Innovation Summit brings together industry leaders, innovators, and enthusiasts to explore the latest trends, products, and opportunities.',
                'website' => 'www.healthinnovation.in',
                'website_url' => url('/events'),
                'organizer' => 'Health India',
                'category' => 'Healthcare, Conference',
                'event_id' => 'HIS-2024-HYD',
                'time' => '09:00 AM - 06:00 PM (IST)',
            ],
        ];
    }
}
