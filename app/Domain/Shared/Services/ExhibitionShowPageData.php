<?php

namespace App\Domain\Shared\Services;

use App\Support\LiveContent;
use Illuminate\Support\Str;

class ExhibitionShowPageData
{
    public function build(string $slug, array $context): array
    {
        $exhibition = $context['exhibition'];
        $agenda = $context['agenda'];
        $speakers = $context['speakers'];
        $sponsors = $context['sponsors'];
        $faqs = $context['faqs'];
        $halls = $context['halls'];

        $title = $exhibition->title ?: $exhibition->name;
        $publishedBookings = ($exhibition->boothBookings ?? collect())->values();
        $bannerImage = LiveContent::resolvePublicAssetUrl(
            $exhibition->banner_image ?: ($exhibition->banner_url ?: 'images/exhibitions/hero-pavilion-scene.png')
        );

        $dateStr = $exhibition->start_date && $exhibition->end_date
            ? $exhibition->start_date->format('M d') . ' – ' . $exhibition->end_date->format('d, Y')
            : ($exhibition->start_date?->format('M d, Y') ?: 'Date TBD');

        $location = LiveContent::formatExhibitionVenue($exhibition);
        $timeStr = LiveContent::resolveExhibitionTime($exhibition);
        $eventType = LiveContent::resolveExhibitionCategory($exhibition);
        $statusLabel = LiveContent::resolveExhibitionStatus($exhibition);

        $participatingCompanies = $publishedBookings
            ->map(function ($booking) use ($location) {
                $companyName = $booking->boothProfile?->company_name
                    ?: ($booking->company?->company_name ?: ($booking->company?->name ?: null));

                if (! filled($companyName)) {
                    return null;
                }

                $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');
                $logoUrl = $logo
                    ? (str_starts_with($logo, 'http') ? $logo : (str_starts_with($logo, 'storage/') ? asset($logo) : asset('storage/' . ltrim($logo, '/'))))
                    : null;

                return [
                    'key' => 'name-' . (string) Str::of($companyName)->lower()->squish(),
                    'name' => $companyName,
                    'logo_url' => $logoUrl,
                    'slug' => Str::slug($companyName),
                    'location' => $booking->company?->country ?: $location,
                ];
            })
            ->filter()
            ->unique('key')
            ->values();

        $speakerCards = $speakers
            ->map(fn ($speaker) => (object) [
                'name' => $speaker->name,
                'title' => $speaker->title,
                'company' => $speaker->company,
                'bio' => $speaker->bio,
                'avatar_url' => $speaker->avatar_url,
            ])
            ->concat($publishedBookings->flatMap(function ($booking) {
                $companyName = $booking->boothProfile?->company_name
                    ?: ($booking->company?->company_name ?: ($booking->company?->name ?: null));

                return ($booking->boothTeamMembers ?? collect())
                    ->where('status', 'active')
                    ->map(function ($member) use ($companyName) {
                        $photo = $member->photo ? ltrim($member->photo, '/') : null;

                        return (object) [
                            'name' => $member->name,
                            'title' => $member->designation,
                            'company' => $companyName,
                            'bio' => collect($member->expertise_tags ?? [])->filter()->implode(', '),
                            'avatar_url' => $photo
                                ? (str_starts_with($photo, 'http') ? $photo : (str_starts_with($photo, 'storage/') ? asset($photo) : asset('storage/' . $photo)))
                                : null,
                        ];
                    });
            }))
            ->filter(fn ($speaker) => filled($speaker->name))
            ->unique(fn ($speaker) => strtolower(trim($speaker->name)))
            ->values();

        $boothSessionsCount = $publishedBookings
            ->flatMap(fn ($booking) => $booking->boothSessions ?? collect())
            ->whereIn('status', ['live', 'upcoming', 'completed'])
            ->count();

        $displayCompanies = $participatingCompanies->count();
        $displayCountries = $publishedBookings
            ->map(fn ($booking) => $booking->company?->country)
            ->filter()
            ->unique()
            ->count();
        $displaySpeakers = $speakerCards->count();
        $displaySessions = $agenda->count() + $boothSessionsCount;

        $tags = $this->buildTags($exhibition, $halls);

        $expectations = [
            ['ph-star', 'Explore ' . $title],
            ['ph-users', $displayCompanies . ' participating ' . Str::plural('company', $displayCompanies)],
            ['ph-user-circle', $displaySpeakers . ' keynote ' . Str::plural('speaker', $displaySpeakers)],
            ['ph-presentation-chart', $displaySessions . ' agenda ' . Str::plural('session', $displaySessions)],
            ['ph-certificate', 'One-to-one meetings and visitor pass access'],
        ];

        $ticketUrl = \App\Support\ExhibitionTicketFlow::visitorPassEntryUrl($slug);

        return array_merge($context, [
            'slug' => $slug,
            'title' => $title,
            'ticketUrl' => $ticketUrl,
            'bannerImage' => $bannerImage,
            'dateStr' => $dateStr,
            'location' => $location,
            'timeStr' => $timeStr,
            'eventType' => $eventType,
            'statusLabel' => $statusLabel,
            'tags' => $tags,
            'participatingCompanies' => $participatingCompanies,
            'speakerCards' => $speakerCards,
            'displayCompanies' => $displayCompanies,
            'displayCountries' => $displayCountries,
            'displaySpeakers' => $displaySpeakers,
            'displaySessions' => $displaySessions,
            'expectations' => $expectations,
            'visibleTabs' => $this->buildVisibleTabs($agenda, $speakerCards, $sponsors, $halls, $faqs),
        ]);
    }

    private function buildTags($exhibition, $halls): array
    {
        $tags = collect([LiveContent::resolveExhibitionCategory($exhibition)]);

        $halls->pluck('pavilion.title')
            ->filter()
            ->unique()
            ->take(3)
            ->each(function ($title) use ($tags) {
                $label = trim((string) Str::of($title)->replaceMatches('/\s*pavilion$/i', ''));
                $tags->push($label !== '' ? $label : $title);
            });

        if (filled($exhibition->description)) {
            $description = strtolower($exhibition->description);
            foreach (['ai', 'technology', 'healthcare', 'innovation', 'manufacturing', 'sustainability'] as $keyword) {
                if (str_contains($description, $keyword)) {
                    $tags->push(ucwords($keyword));
                }
            }
        }

        $tags = $tags->filter()->unique()->take(4)->values();

        return $tags->isNotEmpty() ? $tags->all() : ['Expo', 'Interactive'];
    }

    private function buildVisibleTabs($agenda, $speakerCards, $sponsors, $halls, $faqs): array
    {
        return collect([
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'ph-layout', 'show' => true],
            ['id' => 'agenda', 'label' => 'Agenda', 'icon' => 'ph-calendar-blank', 'show' => $agenda->isNotEmpty()],
            ['id' => 'speakers', 'label' => 'Speakers', 'icon' => 'ph-users', 'show' => $speakerCards->isNotEmpty()],
            ['id' => 'sponsors', 'label' => 'Sponsors', 'icon' => 'ph-shield-star', 'show' => $sponsors->isNotEmpty()],
            ['id' => 'floorplan', 'label' => 'Floor Plan', 'icon' => 'ph-map-trifold', 'show' => $halls->isNotEmpty()],
            ['id' => 'faqs', 'label' => 'FAQs', 'icon' => 'ph-question', 'show' => $faqs->isNotEmpty()],
        ])->filter(fn ($tab) => $tab['show'])->values()->all();
    }
}
