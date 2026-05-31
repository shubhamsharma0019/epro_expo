<?php

namespace App\Services\Company;

use App\Models\BoothMeetingAvailability;
use App\Models\BoothMeetingSlot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BoothMeetingSlotService
{
    public function regenerate(BoothMeetingAvailability $availability): void
    {
        BoothMeetingSlot::where('booth_booking_id', $availability->booth_booking_id)
            ->where('status', 'available')
            ->delete();

        $weekdays = collect($availability->available_weekdays ?? [])->map(fn ($day) => strtolower((string) $day));
        $meetingTypes = collect($availability->meeting_types ?? ['video'])->values();
        $period = CarbonPeriod::create($availability->available_start_date, $availability->available_end_date);
        $slotDuration = max(1, (int) $availability->slot_duration);
        $bufferTime = max(0, (int) $availability->buffer_time);

        foreach ($period as $date) {
            if ($weekdays->isNotEmpty() && ! $weekdays->contains(strtolower($date->format('l')))) {
                continue;
            }

            $cursor = Carbon::parse($date->toDateString() . ' ' . $availability->daily_start_time);
            $end = Carbon::parse($date->toDateString() . ' ' . $availability->daily_end_time);

            while ($cursor->copy()->addMinutes($slotDuration)->lte($end)) {
                $slotEnd = $cursor->copy()->addMinutes($slotDuration);
                foreach ($meetingTypes as $meetingType) {
                    BoothMeetingSlot::create([
                        'company_id' => $availability->company_id,
                        'booth_booking_id' => $availability->booth_booking_id,
                        'created_by' => $availability->created_by,
                        'team_member_id' => $availability->assigned_team_member_id,
                        'date' => $date->toDateString(),
                        'start_time' => $cursor->format('H:i:s'),
                        'end_time' => $slotEnd->format('H:i:s'),
                        'meeting_type' => $meetingType,
                        'status' => 'available',
                    ]);
                }

                $cursor = $slotEnd->addMinutes($bufferTime);
            }
        }
    }
}
