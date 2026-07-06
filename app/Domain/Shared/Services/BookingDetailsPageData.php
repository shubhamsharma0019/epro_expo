<?php

namespace App\Domain\Shared\Services;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Support\HallMedia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class BookingDetailsPageData
{
    public function build(BoothBooking $booking, Collection $bookingDays, Collection $bookingServices): array
    {
        $booking->loadMissing([
            'company',
            'exhibition',
            'pavilion',
            'hall',
            'booth',
            'boothSize',
            'boothProfile',
            'boothBranding',
        ]);

        $exhibition = $booking->exhibition;
        $orderedDays = $bookingDays->sortBy('booking_date')->values();
        $firstBookedDay = $orderedDays->first()?->booking_date;
        $lastBookedDay = $orderedDays->last()?->booking_date;
        $daysCount = $orderedDays->count();

        $exhibitionStart = $exhibition?->start_date ? Carbon::parse($exhibition->start_date) : null;
        $exhibitionEnd = $exhibition?->end_date ? Carbon::parse($exhibition->end_date) : null;

        $rangeStart = $firstBookedDay ?: $exhibitionStart;
        $rangeEnd = $lastBookedDay ?: $exhibitionEnd;

        $setupDate = $rangeStart ?: $exhibitionStart;
        $lastDayDate = $rangeEnd ?: $exhibitionEnd;

        $dateRange = $this->formatDateRange($rangeStart, $rangeEnd, $daysCount);
        $venueLines = $this->venueLines($booking);

        $setupStarted = $booking->boothProfile
            || in_array($booking->booth_setup_status, [
                'setup_in_progress',
                'in_progress',
                'ready_to_publish',
                'pending_review',
                'submitted_for_review',
                'published',
                'approved',
                'live',
            ], true);

        return [
            'bookingReference' => 'EXPO-' . optional($booking->created_at)->format('Y') . '-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
            'previewImage' => $this->previewImage($booking),
            'eventTitle' => $exhibition?->title ?: ($exhibition?->name ?: 'Exhibition'),
            'dateRange' => $dateRange,
            'venuePrimary' => $venueLines['primary'],
            'venueSecondary' => $venueLines['secondary'],
            'pavilionTitle' => $booking->pavilion?->title ?: 'Pavilion',
            'hallTitle' => $booking->hall?->title ?: 'Hall',
            'boothNumber' => $this->boothNumberLabel($booking),
            'boothSizeLabel' => $this->boothSizeLabel($booking->boothSize),
            'setupSchedule' => $this->scheduleLine($setupDate, $exhibition?->setup_start_time, $exhibition?->setup_end_time),
            'showSchedule' => $this->scheduleLine($dateRange, $exhibition?->show_start_time, $exhibition?->show_end_time, isRange: true),
            'lastDaySchedule' => $this->scheduleLine($lastDayDate, $exhibition?->show_start_time, $exhibition?->last_day_end_time),
            'paymentStatus' => $this->statusBadge((string) ($booking->payment_status ?: 'pending')),
            'bookingStatus' => $this->statusBadge((string) ($booking->booking_status ?: 'pending')),
            'amountPaid' => (float) $booking->total_amount,
            'currencySymbol' => config('invoice.currency_symbol', '₹'),
            'setupAllowed' => $booking->payment_status === 'paid'
                && $booking->booking_status === 'confirmed'
                && $setupStarted,
            'servicesCount' => $bookingServices->count(),
        ];
    }

    private function previewImage(BoothBooking $booking): string
    {
        $candidates = [
            $booking->boothProfile?->booth_banner,
            $booking->boothBranding?->booth_banner,
            $booking->pavilion?->image,
            $booking->exhibition?->banner_image,
            $booking->exhibition?->banner_url,
            $booking->hall?->image,
        ];

        foreach ($candidates as $path) {
            if (filled($path)) {
                return HallMedia::imageUrl($path, 'assets/exhibition/images/booth_banner.png');
            }
        }

        return asset('assets/exhibition/images/booth_banner.png');
    }

    private function venueLines(BoothBooking $booking): array
    {
        $exhibition = $booking->exhibition;
        $rawVenue = trim((string) ($exhibition?->venue ?: ($booking->hall?->title ?: '')));

        if ($rawVenue === '') {
            return [
                'primary' => 'Venue not available',
                'secondary' => '',
            ];
        }

        $parts = collect(explode(',', $rawVenue))
            ->map(fn ($part) => trim($part))
            ->filter()
            ->values();

        $location = trim((string) ($exhibition?->location ?? ''));
        if ($parts->count() === 1 && $location !== '' && ! str_contains(strtolower($rawVenue), strtolower($location))) {
            return [
                'primary' => $parts->first(),
                'secondary' => $location,
            ];
        }

        return [
            'primary' => $parts->first() ?: $rawVenue,
            'secondary' => $parts->skip(1)->implode(', '),
        ];
    }

    private function boothNumberLabel(BoothBooking $booking): string
    {
        $boothIds = collect($booking->selected_booth_ids ?? [])
            ->filter()
            ->when($booking->booth_id, fn (Collection $ids) => $ids->push($booking->booth_id))
            ->unique()
            ->values();

        if ($boothIds->isNotEmpty()) {
            $numbers = Booth::query()
                ->whereIn('id', $boothIds)
                ->orderBy('booth_number')
                ->pluck('booth_number')
                ->filter();

            if ($numbers->count() > 1) {
                return $numbers->first() . '–' . $numbers->last();
            }

            if ($numbers->isNotEmpty()) {
                return (string) $numbers->first();
            }
        }

        return (string) ($booking->booth?->booth_number ?: '--');
    }

    private function boothSizeLabel($boothSize): string
    {
        if (! $boothSize) {
            return 'Not selected';
        }

        $title = trim((string) ($boothSize->title ?? ''));
        $width = $boothSize->width;
        $height = $boothSize->height;
        $area = $boothSize->area;

        if ($width && $height) {
            $label = rtrim(rtrim((string) $width, '0'), '.') . 'm × ' . rtrim(rtrim((string) $height, '0'), '.') . 'm';
            if ($area) {
                $label .= ' (' . rtrim(rtrim((string) $area, '0'), '.') . ' sqm)';
            }

            return $label;
        }

        if ($title !== '' && $area) {
            return $title . ' (' . rtrim(rtrim((string) $area, '0'), '.') . ' sqm)';
        }

        return $title !== '' ? $title : 'Not selected';
    }

    private function formatDateRange(?Carbon $start, ?Carbon $end, int $bookedDays): string
    {
        if (! $start && ! $end) {
            return 'Dates not available';
        }

        $startLabel = $start?->format('M d, Y');
        $endLabel = $end?->format('M d, Y');

        if ($startLabel && $endLabel) {
            $daysSuffix = $bookedDays > 0
                ? ' (' . $bookedDays . ' ' . ($bookedDays === 1 ? 'Day' : 'Days') . ')'
                : '';

            if ($start->isSameDay($end)) {
                return $startLabel . $daysSuffix;
            }

            return $startLabel . ' - ' . $endLabel . $daysSuffix;
        }

        return $startLabel ?: ($endLabel ?: 'Dates not available');
    }

    private function scheduleLine(
        Carbon|string|null $date,
        mixed $startTime,
        mixed $endTime,
        bool $isRange = false,
    ): string {
        if ($date === null || $date === '') {
            return 'Not available';
        }

        $dateLabel = $isRange
            ? (string) $date
            : ($date instanceof Carbon ? $date->format('M d, Y') : (string) $date);

        $start = $this->formatTime($startTime);
        $end = $this->formatTime($endTime);

        if ($start && $end) {
            return $dateLabel . ' | ' . $start . ' - ' . $end;
        }

        return $dateLabel;
    }

    private function formatTime(mixed $time): ?string
    {
        if (! filled($time)) {
            return null;
        }

        return Carbon::parse((string) $time)->format('g:i A');
    }

    /** @return array{label: string, classes: string} */
    private function statusBadge(string $status): array
    {
        $normalized = strtolower(str_replace(' ', '_', $status));

        return match ($normalized) {
            'paid', 'confirmed', 'approved', 'active', 'published', 'live' => [
                'label' => ucfirst(str_replace('_', ' ', $status)),
                'classes' => 'bg-[#E8F5E9] border-[#A5D6A7] text-[#2E7D32]',
            ],
            'pending', 'pending_approval', 'setup_in_progress', 'in_progress' => [
                'label' => ucfirst(str_replace('_', ' ', $status)),
                'classes' => 'bg-[#FFF8E1] border-[#FFE082] text-[#F57F17]',
            ],
            'cancelled', 'rejected', 'failed', 'refunded' => [
                'label' => ucfirst(str_replace('_', ' ', $status)),
                'classes' => 'bg-[#FFEBEE] border-[#EF9A9A] text-[#C62828]',
            ],
            default => [
                'label' => ucfirst(str_replace('_', ' ', $status)),
                'classes' => 'bg-gray-100 border-gray-200 text-gray-700',
            ],
        };
    }
}
