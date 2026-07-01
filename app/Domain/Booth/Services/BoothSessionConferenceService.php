<?php

namespace App\Domain\Booth\Services;

use App\Domain\Booth\Models\BoothSession;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Shared\Models\User;
use App\Domain\Shared\Services\GoogleMeetService;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BoothSessionConferenceService
{
    public function syncConferenceMeeting(BoothSession $session): CompanyMeeting
    {
        $session->loadMissing('boothBooking.exhibition');
        $booking = $session->boothBooking;

        if (! $booking?->company_id) {
            throw new \RuntimeException('Booth booking is required for conference setup.');
        }

        $sessionDate = $session->session_date?->format('Y-m-d') ?? now()->toDateString();
        $startTime = Carbon::parse($sessionDate . ' ' . ($session->start_time ?: '10:00:00'));
        $endTime = Carbon::parse($sessionDate . ' ' . ($session->end_time ?: $startTime->copy()->addMinutes(30)->format('H:i:s')));

        if ($endTime->lte($startTime)) {
            $endTime = $startTime->copy()->addMinutes(30);
        }

        $payload = [
            'company_id' => $booking->company_id,
            'booth_session_id' => $session->id,
            'title' => $session->title ?: 'Conference Session',
            'meeting_type' => 'one-to-many',
            'start_time' => $startTime,
            'end_time' => $endTime,
            'description' => $session->description,
            'meeting_agenda' => 'Exhibitor conference: ' . ($session->title ?: 'Session'),
            'meeting_date' => $sessionDate,
            'meeting_time' => $startTime->format('H:i:s'),
            'max_attendees' => $session->attendee_limit ?: 50,
            'status' => $session->status === 'live' ? 'confirmed' : 'pending',
        ];

        $companyMeeting = $session->company_meeting_id
            ? CompanyMeeting::query()->find($session->company_meeting_id)
            : null;

        if ($companyMeeting) {
            $companyMeeting->update($payload);
        } else {
            $companyMeeting = CompanyMeeting::create($payload);
            $session->update(['company_meeting_id' => $companyMeeting->id]);
        }

        return $companyMeeting->fresh();
    }

    public function notifyExhibitionPassHolders(BoothSession $session, bool $force = false): int
    {
        if ($session->pass_holders_notified_at && ! $force) {
            return 0;
        }

        $session->loadMissing(['boothBooking', 'companyMeeting']);
        $booking = $session->boothBooking;

        if (! $booking?->exhibition_id || ! $booking->company_id) {
            return 0;
        }

        $companyMeeting = $session->companyMeeting ?: $this->syncConferenceMeeting($session);
        $companyName = $booking->boothProfile?->company_name
            ?: $booking->company?->company_name
            ?: $booking->company?->name
            ?: 'Exhibitor';

        $passes = Visitor::query()
            ->where('exhibition_id', $booking->exhibition_id)
            ->where('payment_status', 'completed')
            ->get();

        $notified = 0;

        foreach ($passes as $pass) {
            $userId = $this->resolveUserId($pass);

            if (! $userId) {
                continue;
            }

            $alreadyNotified = DB::table('meeting_notifications')
                ->where('visitor_id', $userId)
                ->where('booth_session_id', $session->id)
                ->where('type', 'conference_announced')
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $visitorBooking = $this->ensureVisitorBookingForSession($session, $companyMeeting, $userId, $pass);

            $scheduleLabel = $session->session_date?->format('M d, Y');
            if ($session->start_time) {
                $scheduleLabel .= ' at ' . Carbon::parse($session->start_time)->format('g:i A');
            }

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $userId,
                'company_id' => $booking->company_id,
                'visitor_meeting_booking_id' => $visitorBooking->id,
                'booth_session_id' => $session->id,
                'type' => 'conference_announced',
                'title' => 'New conference from ' . $companyName,
                'message' => $companyName . ' scheduled "' . ($session->title ?: 'a conference session') . '" on ' . ($scheduleLabel ?: 'soon') . '. Open My Meetings to register or join.',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $notified++;
        }

        if ($notified > 0 || ! $session->pass_holders_notified_at) {
            $session->update(['pass_holders_notified_at' => now()]);
        }

        return $notified;
    }

    public function provisionGoogleMeet(BoothSession $session, GoogleMeetService $googleMeetService): ?string
    {
        $session->loadMissing('companyMeeting');
        $companyMeeting = $session->companyMeeting ?: $this->syncConferenceMeeting($session);

        $existing = $companyMeeting->zoom_join_url ?: $companyMeeting->meeting_link;
        if ($existing) {
            return $existing;
        }

        if (! $googleMeetService->isConfigured()) {
            return null;
        }

        try {
            $linkPayload = $googleMeetService->createForCompanyMeeting($companyMeeting);
            $companyMeeting->update($linkPayload);

            return $linkPayload['zoom_join_url'] ?? $linkPayload['meeting_link'] ?? null;
        } catch (\Throwable $exception) {
            Log::warning('Conference Google Meet provision failed', [
                'booth_session_id' => $session->id,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function startConference(BoothSession $session, GoogleMeetService $googleMeetService): array
    {
        $session->loadMissing('boothBooking');
        $companyMeeting = $this->syncConferenceMeeting($session);
        $joinUrl = $this->provisionGoogleMeet($session, $googleMeetService);

        $session->update(['status' => 'live']);
        $companyMeeting->update(['status' => 'confirmed']);

        $bookings = VisitorMeetingBooking::query()
            ->where('booth_session_id', $session->id)
            ->get();

        foreach ($bookings as $visitorBooking) {
            $visitorBooking->update(['status' => 'confirmed']);

            if (! $visitorBooking->visitor_id) {
                continue;
            }

            $message = $joinUrl
                ? 'Your conference "' . ($session->title ?: 'session') . '" is live. Join here: ' . $joinUrl
                : 'Your conference "' . ($session->title ?: 'session') . '" is now live. The host will share the meeting link shortly.';

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $visitorBooking->visitor_id,
                'company_id' => $session->boothBooking->company_id,
                'visitor_meeting_booking_id' => $visitorBooking->id,
                'booth_session_id' => $session->id,
                'type' => $joinUrl ? 'confirmed' : 'updated',
                'title' => 'Conference is live',
                'message' => $message,
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return [
            'join_url' => $joinUrl,
            'host_url' => $companyMeeting->fresh()->zoom_start_url ?: $joinUrl,
            'notified' => $bookings->count(),
        ];
    }

    public function ensureVisitorBookingForSession(
        BoothSession $session,
        CompanyMeeting $companyMeeting,
        int $userId,
        ?Visitor $pass = null
    ): VisitorMeetingBooking {
        $user = User::find($userId);
        $session->loadMissing('boothBooking');

        $existing = VisitorMeetingBooking::query()
            ->where('booth_session_id', $session->id)
            ->where(function ($query) use ($userId, $user) {
                $query->where('visitor_id', $userId);
                if ($user?->email) {
                    $query->orWhere('visitor_email', $user->email);
                }
            })
            ->first();

        if ($existing) {
            if (! $existing->company_meeting_id) {
                $existing->update(['company_meeting_id' => $companyMeeting->id]);
            }

            return $existing;
        }

        $sessionDate = $session->session_date?->format('Y-m-d') ?? now()->toDateString();

        return VisitorMeetingBooking::create([
            'company_id' => $session->boothBooking->company_id,
            'company_meeting_id' => $companyMeeting->id,
            'booth_session_id' => $session->id,
            'visitor_id' => $userId,
            'visitor_name' => $user?->name ?: trim(($pass->first_name ?? '') . ' ' . ($pass->last_name ?? '')) ?: 'Visitor',
            'visitor_email' => $user?->email ?: $pass?->email,
            'meeting_topic' => $session->title ?: 'Conference Session',
            'preferred_date' => $sessionDate,
            'preferred_time' => $session->start_time ? Carbon::parse($session->start_time)->format('H:i:s') : null,
            'message' => 'Conference session invitation',
            'status' => 'pending',
            'created_by' => $userId,
        ]);
    }

    private function resolveUserId(Visitor $pass): ?int
    {
        if ($pass->user_id) {
            return (int) $pass->user_id;
        }

        if ($pass->email) {
            $userId = User::query()->whereRaw('LOWER(email) = ?', [strtolower($pass->email)])->value('id');
            if ($userId) {
                return (int) $userId;
            }
        }

        return null;
    }
}
