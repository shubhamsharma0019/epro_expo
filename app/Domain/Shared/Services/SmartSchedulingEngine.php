<?php

namespace App\Domain\Shared\Services;

use App\Domain\Booth\Models\BoothMeetingSlot;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Booth\Models\BoothBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SmartSchedulingEngine
{
    /**
     * Validate a meeting request and check for conflicts.
     *
     * @return array{valid: bool, conflict: string|null, suggest_slot: BoothMeetingSlot|null}
     */
    public function validateMeetingRequest(
        int $companyId,
        ?int $visitorId,
        string $visitorEmail,
        string $date,
        string $time,
        string $meetingType, // one-to-one or one-to-many
        int $exhibitionId,
        ?int $slotId = null
    ): array {
        $start = Carbon::parse("$date $time");
        // Default duration is 30 minutes if not from slot
        $duration = 30;

        if ($slotId) {
            $slot = BoothMeetingSlot::find($slotId);
            if ($slot) {
                $duration = Carbon::parse($slot->start_time)->diffInMinutes(Carbon::parse($slot->end_time));
            }
        }
        $end = $start->copy()->addMinutes($duration);

        // 1. Check Exhibition Dates
        $exhibition = Exhibition::find($exhibitionId);
        if ($exhibition) {
            $meetingDate = Carbon::parse($date);
            $startDate = Carbon::parse($exhibition->start_date);
            $endDate = Carbon::parse($exhibition->end_date);
            if ($meetingDate->lt($startDate->startOfDay()) || $meetingDate->gt($endDate->endOfDay())) {
                $suggestion = $this->suggestNextBestSlot($companyId, $visitorId, $visitorEmail, now()->toDateTimeString(), $meetingType, $exhibitionId);
                return [
                    'valid' => false,
                    'conflict' => "Meeting date must be within exhibition dates: {$startDate->format('M d, Y')} to {$endDate->format('M d, Y')}.",
                    'suggest_slot' => $suggestion,
                ];
            }
        }

        // 2. Check Visitor Availability (prevent overlapping meetings for visitor)
        if ($visitorId) {
            $visitorConflictExists = VisitorMeetingBooking::where('visitor_id', $visitorId)
                ->whereIn('status', ['confirmed', 'accepted', 'rescheduled'])
                ->whereHas('companyMeeting', function ($query) use ($start, $end) {
                    $query->where('start_time', '<', $end->toDateTimeString())
                          ->where('end_time', '>', $start->toDateTimeString());
                })
                ->exists();

            if ($visitorConflictExists) {
                $suggestion = $this->suggestNextBestSlot($companyId, $visitorId, $visitorEmail, now()->toDateTimeString(), $meetingType, $exhibitionId);
                return [
                    'valid' => false,
                    'conflict' => "You have another confirmed meeting overlapping with this time slot.",
                    'suggest_slot' => $suggestion,
                ];
            }
        }

        // 3. Check Company Representative / Slot Availability
        // Check if there are other confirmed meetings for the company overlapping with this time
        $companyConflictExists = CompanyMeeting::where('company_id', $companyId)
            ->whereIn('status', ['confirmed', 'accepted', 'rescheduled'])
            ->where('start_time', '<', $end->toDateTimeString())
            ->where('end_time', '>', $start->toDateTimeString())
            ->where(function($q) use ($meetingType) {
                // If it's a one-to-one meeting, or the existing meeting is one-to-one, we cannot share it.
                $q->where('meeting_type', 'one-to-one')
                  ->orWhereRaw('? = ?', [$meetingType, 'one-to-one']);
            })
            ->exists();

        if ($companyConflictExists) {
            $suggestion = $this->suggestNextBestSlot($companyId, $visitorId, $visitorEmail, now()->toDateTimeString(), $meetingType, $exhibitionId);
            return [
                'valid' => false,
                'conflict' => "The company representative has another one-to-one meeting or slot conflict at this time.",
                'suggest_slot' => $suggestion,
            ];
        }

        // 4. Capacity checks for slot
        if ($slotId) {
            $slot = BoothMeetingSlot::find($slotId);
            if ($slot) {
                // If the slot is one-to-one, check if anyone else has already booked it
                $bookingCount = VisitorMeetingBooking::where('company_id', $companyId)
                    ->where(function ($q) use ($slot) {
                        $q->whereHas('companyMeeting', function ($sub) use ($slot) {
                            $sub->where('start_time', $slot->date->format('Y-m-d') . ' ' . $slot->start_time);
                        })->orWhere(function ($sub) use ($slot) {
                            $sub->where('preferred_date', $slot->date->format('Y-m-d'))
                                ->where('preferred_time', $slot->start_time);
                        });
                    })
                    ->whereIn('status', ['confirmed', 'accepted', 'pending'])
                    ->count();

                $maxCapacity = $slot->max_capacity ?? 1;

                if ($meetingType === 'one-to-one' || $slot->allow_one_to_one && !$slot->allow_one_to_many) {
                    if ($bookingCount >= 1) {
                        $suggestion = $this->suggestNextBestSlot($companyId, $visitorId, $visitorEmail, now()->toDateTimeString(), $meetingType, $exhibitionId);
                        return [
                            'valid' => false,
                            'conflict' => "This time slot is already booked for a One-to-One meeting.",
                            'suggest_slot' => $suggestion,
                        ];
                    }
                } else {
                    // One-to-many capacity check
                    if ($bookingCount >= $maxCapacity) {
                        return [
                            'valid' => true, // Valid for waitlisting!
                            'conflict' => 'waitlist',
                            'suggest_slot' => null,
                        ];
                    }
                }
            }
        }

        return [
            'valid' => true,
            'conflict' => null,
            'suggest_slot' => null,
        ];
    }

    /**
     * Suggest the next best available slot for the visitor and company.
     */
    public function suggestNextBestSlot(
        int $companyId,
        ?int $visitorId,
        string $visitorEmail,
        string $startAfter,
        string $meetingType,
        int $exhibitionId
    ): ?BoothMeetingSlot {
        $now = Carbon::parse($startAfter);

        // Fetch all future available slots for the company
        $slots = BoothMeetingSlot::where('company_id', $companyId)
            ->where('status', 'available')
            ->where(function ($q) use ($now) {
                $q->where('date', '>', $now->toDateString())
                  ->orWhere(function ($sub) use ($now) {
                      $sub->where('date', $now->toDateString())
                          ->where('start_time', '>=', $now->format('H:i:s'));
                  });
            })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        foreach ($slots as $slot) {
            $slotStart = Carbon::parse($slot->date->format('Y-m-d') . ' ' . $slot->start_time);
            $slotEnd = Carbon::parse($slot->date->format('Y-m-d') . ' ' . $slot->end_time);

            // Check if visitor has conflict
            if ($visitorId) {
                $visitorConflict = VisitorMeetingBooking::where('visitor_id', $visitorId)
                    ->whereIn('status', ['confirmed', 'accepted', 'rescheduled'])
                    ->whereHas('companyMeeting', function ($query) use ($slotStart, $slotEnd) {
                        $query->where('start_time', '<', $slotEnd->toDateTimeString())
                              ->where('end_time', '>', $slotStart->toDateTimeString());
                    })
                    ->exists();

                if ($visitorConflict) {
                    continue;
                }
            }

            // Check if company has conflict (overlap)
            $companyConflict = CompanyMeeting::where('company_id', $companyId)
                ->whereIn('status', ['confirmed', 'accepted', 'rescheduled'])
                ->where('start_time', '<', $slotEnd->toDateTimeString())
                ->where('end_time', '>', $slotStart->toDateTimeString())
                ->exists();

            if ($companyConflict) {
                continue;
            }

            // Check slot capacity
            $bookingCount = VisitorMeetingBooking::where('company_id', $companyId)
                ->where(function ($q) use ($slot) {
                    $q->whereHas('companyMeeting', function ($sub) use ($slot) {
                        $sub->where('start_time', $slot->date->format('Y-m-d') . ' ' . $slot->start_time);
                    })->orWhere(function ($sub) use ($slot) {
                        $sub->where('preferred_date', $slot->date->format('Y-m-d'))
                            ->where('preferred_time', $slot->start_time);
                    });
                })
                ->whereIn('status', ['confirmed', 'accepted', 'pending'])
                ->count();

            $maxCapacity = $slot->max_capacity ?? 1;
            if ($meetingType === 'one-to-one') {
                if ($bookingCount >= 1) {
                    continue;
                }
            } else {
                if ($bookingCount >= $maxCapacity) {
                    continue;
                }
            }

            // Found a good slot!
            return $slot;
        }

        return null;
    }
}
