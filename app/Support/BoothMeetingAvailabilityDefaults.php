<?php

namespace App\Support;

use App\Domain\Booth\Models\BoothBooking;
use Illuminate\Support\Carbon;

class BoothMeetingAvailabilityDefaults
{
    /** @return array<string, mixed> */
    public static function forBooking(BoothBooking $booking): array
    {
        $booking->loadMissing('exhibition');

        $defaultStart = $booking->exhibition?->start_date ?? now();
        $defaultEnd = $booking->exhibition?->end_date ?? $defaultStart;

        return [
            'company_id' => $booking->company_id,
            'booth_booking_id' => $booking->id,
            'available_start_date' => Carbon::parse($defaultStart)->toDateString(),
            'available_end_date' => Carbon::parse($defaultEnd)->toDateString(),
            'available_weekdays' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'daily_start_time' => '09:00:00',
            'daily_end_time' => '18:00:00',
            'meeting_types' => ['video'],
            'slot_duration' => 30,
            'buffer_time' => 10,
            'timezone' => 'Asia/Kolkata',
            'max_capacity' => 1,
            'allow_one_to_one' => true,
            'allow_one_to_many' => false,
            'allow_conference' => false,
        ];
    }
}
