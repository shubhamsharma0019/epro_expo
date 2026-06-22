<?php

namespace App\Domain\Shared\Services;

use App\Domain\Event\Models\Pavilion;
use App\Domain\Visitor\Models\Visitor;
use App\Support\ExhibitionTicketFlow;
use App\Support\LiveContent;
use Illuminate\Support\Collection;

class ExhibitionTicketVisitorDetailsPageData
{
    /** @return array<string, mixed>|null */
    public function build(string $slug): ?array
    {
        $exhibition = LiveContent::findExhibitionForVisitorFlow($slug);
        if (! $exhibition) {
            return null;
        }

        $title = $exhibition->title ?: $exhibition->name;
        $publishedBookings = ($exhibition->boothBookings ?? collect())->filter(
            fn ($booking) => in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true)
        );

        $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
            ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);

        $bannerPath = $exhibition->banner_url ?: $exhibition->banner_image;
        if (! $bannerPath && $firstBooking) {
            $bannerPath = $firstBooking->boothBranding?->booth_banner
                ?: $firstBooking->boothProfile?->company_logo
                ?: $firstBooking->company?->logo;
        }

        $bannerImage = LiveContent::resolvePublicAssetUrl($bannerPath ?: 'images/exhibitions/hero-pavilion-scene.png');

        $dateStr = $exhibition->start_date && $exhibition->end_date
            ? $exhibition->start_date->format('M d') . ' – ' . $exhibition->end_date->format('d, Y')
            : ($exhibition->start_date?->format('M d, Y') ?: 'Date TBD');

        $location = $exhibition->venue ?: ($exhibition->location ?: 'Virtual');
        $timeStr = LiveContent::resolveExhibitionTime($exhibition);

        $pavilions = Pavilion::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('status', 'active')
            ->orderBy('title')
            ->get(['id', 'title', 'slug']);

        $bookings = ($exhibition->boothBookings ?? collect())->values();

        $countries = $this->uniqueValues(
            $bookings->map(fn ($booking) => $booking->company?->country),
            $bookings->map(fn ($booking) => $booking->boothProfile?->country),
            Visitor::query()->where('exhibition_id', $exhibition->id)->pluck('country'),
            [$this->guessCountryFromLocation($location)]
        );

        $states = $this->uniqueValues(
            $bookings->map(fn ($booking) => $booking->boothProfile?->state),
            Visitor::query()->where('exhibition_id', $exhibition->id)->pluck('state')
        );

        $cities = $this->uniqueValues(
            $bookings->map(fn ($booking) => $booking->company?->city),
            $bookings->map(fn ($booking) => $booking->boothProfile?->city),
            Visitor::query()->where('exhibition_id', $exhibition->id)->pluck('city')
        );

        $industries = $this->uniqueValues(
            $bookings->map(fn ($booking) => $booking->company?->industry),
            $bookings->map(fn ($booking) => $booking->boothProfile?->industry),
            Visitor::query()->where('exhibition_id', $exhibition->id)->pluck('industry')
        );

        $companySizes = $this->uniqueValues(
            Visitor::query()->where('exhibition_id', $exhibition->id)->pluck('company_size')
        );

        if ($companySizes->isEmpty()) {
            $companySizes = collect([
                '1 - 10 Employees',
                '11 - 50 Employees',
                '51 - 200 Employees',
                '201 - 500 Employees',
                '501+ Employees',
            ]);
        }

        if ($countries->isEmpty()) {
            $countries = collect(['India']);
        }

        if ($industries->isEmpty()) {
            $industries = collect(['Technology', 'Healthcare', 'Finance', 'Education', 'Manufacturing', 'Automotive']);
        }

        return [
            'slug' => $slug,
            'exhibition' => $exhibition,
            'title' => $title,
            'bannerImage' => $bannerImage,
            'dateStr' => $dateStr,
            'location' => $location,
            'timeStr' => $timeStr,
            'pavilions' => $pavilions,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'industries' => $industries,
            'companySizes' => $companySizes,
            'defaultCountry' => $countries->first(),
            'showVisitorSidebar' => ExhibitionTicketFlow::shouldShowVisitorSidebar($slug),
        ];
    }

    private function uniqueValues(mixed ...$sources): Collection
    {
        return collect($sources)
            ->flatMap(function ($source) {
                if ($source instanceof Collection) {
                    return $source;
                }

                return collect(is_array($source) ? $source : [$source]);
            })
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->filter(fn ($value) => filled($value))
            ->unique()
            ->sort()
            ->values();
    }

    private function guessCountryFromLocation(string $location): ?string
    {
        $location = strtolower($location);

        if (str_contains($location, 'india') || str_contains($location, 'delhi') || str_contains($location, 'mumbai') || str_contains($location, 'bengaluru') || str_contains($location, 'hyderabad') || str_contains($location, 'chennai') || str_contains($location, 'noida')) {
            return 'India';
        }

        return null;
    }
}
