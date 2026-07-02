<?php

namespace App\Domain\Booth\Services;

use App\Domain\Booth\Models\BoothAnalytics;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothView;
use Illuminate\Support\Facades\DB;

class BoothAnalyticsService
{
    public function snapshot(BoothBooking $booking): BoothAnalytics
    {
        $visitorMetrics = $this->visitorMetrics($booking);

        return BoothAnalytics::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $booking->company_id,
                'booth_views' => $visitorMetrics['total'],
                'unique_visitors' => $visitorMetrics['unique'],
                'returning_visitors' => $visitorMetrics['returning'],
                'avg_time_spent_seconds' => $visitorMetrics['avg_seconds'],
                'product_views' => (int) $booking->boothProducts()->sum('views'),
                'brochure_downloads' => (int) $booking->boothDocuments()->sum('downloads') + (int) $booking->boothCatalogues()->sum('downloads'),
                'meeting_requests' => (int) ($booking->company?->visitorMeetingBookings()->count() ?? 0),
                'enquiries' => (int) ($booking->company?->enquiries()->count() ?? 0),
                'session_attendees' => 0,
                'lead_sources' => [],
                'traffic_trend' => [],
                'recent_activities' => [],
            ]
        );
    }

    public function visitorMetrics(BoothBooking $booking): array
    {
        $query = BoothView::query()->where('company_id', $booking->company_id);

        if ($booking->boothProfile?->id) {
            $query->where('booth_profile_id', $booking->boothProfile->id);
        }

        $total = (int) (clone $query)->count();

        $unique = (int) (clone $query)
            ->selectRaw('COUNT(DISTINCT COALESCE(visitor_id, ip_address)) as aggregate')
            ->value('aggregate');

        $returning = (int) (clone $query)
            ->select(DB::raw('COALESCE(visitor_id, ip_address) as visitor_key'))
            ->whereNotNull(DB::raw('COALESCE(visitor_id, ip_address)'))
            ->groupBy('visitor_key')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        $avgSeconds = (int) round((clone $query)->where('time_spent_seconds', '>', 0)->avg('time_spent_seconds') ?? 0);

        return [
            'total' => $total,
            'unique' => $unique,
            'returning' => $returning,
            'avg_seconds' => $avgSeconds,
            'avg_time' => $this->formatAvgTime($avgSeconds),
        ];
    }

    public function formatAvgTime(int $seconds): string
    {
        if ($seconds <= 0) {
            return '00:00';
        }

        $minutes = intdiv($seconds, 60);
        $remaining = $seconds % 60;

        return sprintf('%02d:%02d', $minutes, $remaining);
    }
}
