<?php

namespace App\Domain\Visitor\Services;

use App\Domain\Booth\Models\BoothSession;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SessionRegistrationMeetingService
{
    public function syncFromRegistration(
        VisitorSessionRegistration $registration,
        BoothSession $session,
        ?Visitor $visitor = null
    ): ?VisitorMeetingBooking {
        $session->loadMissing('boothBooking');
        $companyId = (int) ($session->company_id ?: $session->boothBooking?->company_id);

        if (! $companyId) {
            return null;
        }

        $visitorId = $registration->user_id ?: auth()->id();
        $visitorEmail = $registration->visitor_email ?: $visitor?->email ?: auth()->user()?->email;

        if (! $visitorEmail) {
            return null;
        }

        $existing = VisitorMeetingBooking::query()
            ->where('booth_session_id', $session->id)
            ->where(function ($query) use ($visitorId, $visitorEmail) {
                if ($visitorId) {
                    $query->where('visitor_id', $visitorId);
                }

                $query->orWhere('visitor_email', $visitorEmail);
            })
            ->first();

        if ($existing) {
            return $existing;
        }

        $conferenceService = app(\App\Domain\Booth\Services\BoothSessionConferenceService::class);
        $companyMeeting = $session->companyMeeting ?: $conferenceService->syncConferenceMeeting($session);

        if ($visitorId) {
            return $conferenceService->ensureVisitorBookingForSession($session, $companyMeeting, (int) $visitorId, $visitor);
        }

        $sessionDate = $session->session_date?->format('Y-m-d') ?? now()->toDateString();
        $startTime = $sessionDate . ' ' . $session->start_time;
        $endTime = $sessionDate . ' ' . $session->end_time;
        $visitorName = $this->resolveVisitorName($visitor, $registration);

        return DB::transaction(function () use (
            $session,
            $companyId,
            $companyMeeting,
            $visitorId,
            $visitorEmail,
            $visitorName,
            $sessionDate
        ) {
            $visitorBooking = VisitorMeetingBooking::create([
                'company_id' => $companyId,
                'company_meeting_id' => $companyMeeting->id,
                'booth_session_id' => $session->id,
                'visitor_id' => $visitorId,
                'visitor_name' => $visitorName,
                'visitor_email' => $visitorEmail,
                'meeting_topic' => $session->title,
                'preferred_date' => $sessionDate,
                'preferred_time' => Carbon::parse($session->start_time)->format('H:i:s'),
                'message' => 'Registered for exhibitor session: ' . $session->title,
                'status' => 'pending',
                'created_by' => $visitorId,
            ]);

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $visitorId,
                'company_id' => $companyId,
                'visitor_meeting_booking_id' => $visitorBooking->id,
                'booth_session_id' => $session->id,
                'type' => 'created',
                'title' => 'Session Registration',
                'message' => $visitorName . ' registered for your session "' . $session->title . '".',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $visitorBooking;
        });
    }

    public function backfillExistingRegistrations(): int
    {
        $count = 0;

        VisitorSessionRegistration::query()
            ->with(['boothSession.boothBooking'])
            ->orderBy('id')
            ->get()
            ->each(function (VisitorSessionRegistration $registration) use (&$count) {
                $session = $registration->boothSession;

                if (! $session) {
                    return;
                }

                $before = VisitorMeetingBooking::query()
                    ->where('booth_session_id', $session->id)
                    ->count();

                $this->syncFromRegistration($registration, $session);

                $after = VisitorMeetingBooking::query()
                    ->where('booth_session_id', $session->id)
                    ->count();

                if ($after > $before) {
                    $count++;
                }
            });

        return $count;
    }

    private function resolveVisitorName(?Visitor $visitor, VisitorSessionRegistration $registration): string
    {
        if ($visitor) {
            $name = trim(($visitor->first_name ?? '') . ' ' . ($visitor->last_name ?? ''));

            if ($name !== '') {
                return $name;
            }
        }

        $user = $registration->user_id
            ? \App\Domain\Shared\Models\User::find($registration->user_id)
            : auth()->user();

        return $user?->name ?: 'Visitor';
    }
}
