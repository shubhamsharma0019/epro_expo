<?php

namespace App\Domain\Booth\Services;

use App\Domain\Booth\Models\BoothAnalytics;
use App\Domain\Booth\Models\BoothBooking;

class BoothAnalyticsService
{
    public function snapshot(BoothBooking $booking): BoothAnalytics
    {
        return BoothAnalytics::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $booking->company_id,
                'booth_views' => $booking->company?->boothViews()->count() ?? 0,
                'product_views' => $booking->boothProducts()->sum('views'),
                'brochure_downloads' => $booking->boothDocuments()->sum('downloads') + $booking->boothCatalogues()->sum('downloads'),
                'meeting_requests' => $booking->company?->visitorMeetingBookings()->count() ?? 0,
                'enquiries' => $booking->company?->enquiries()->count() ?? 0,
                'session_attendees' => 0,
                'lead_sources' => [],
                'traffic_trend' => [],
                'recent_activities' => [],
            ]
        );
    }
}
