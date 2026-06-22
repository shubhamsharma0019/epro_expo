<?php

namespace App\Domain\Shared\Services;

use App\Domain\Event\Models\Pavilion;
use App\Support\ExhibitionTicketFlow;
use App\Support\LiveContent;

class ExhibitionTicketFlowContext
{
    /** @return array<string, mixed>|null */
    public static function resolve(string $slug): ?array
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

        return [
            'slug' => $slug,
            'exhibition' => $exhibition,
            'title' => $title,
            'bannerImage' => $bannerImage,
            'dateStr' => $dateStr,
            'location' => $location,
            'timeStr' => $timeStr,
            'pavilions' => $pavilions,
            'showVisitorSidebar' => ExhibitionTicketFlow::shouldShowVisitorSidebar($slug),
        ];
    }
}
