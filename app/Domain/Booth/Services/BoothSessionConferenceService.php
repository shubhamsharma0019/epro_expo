<?php

namespace App\Domain\Booth\Services;

use App\Domain\Booth\Models\BoothSession;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Shared\Models\User;
use App\Domain\Shared\Services\GoogleMeetService;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Support\MeetingJoinUrls;
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

        $existing = MeetingJoinUrls::resolve($companyMeeting);
        if ($existing) {
            return $existing;
        }

        if (! $googleMeetService->isConfigured()) {
            return null;
        }

        try {
            $linkPayload = $googleMeetService->createForCompanyMeeting($companyMeeting);
            $companyMeeting->update($linkPayload);
            MeetingJoinUrls::syncModel($companyMeeting);

            return MeetingJoinUrls::resolve($companyMeeting->fresh());
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

            $this->insertVisitorNotification(
                (int) $visitorBooking->visitor_id,
                (int) $session->boothBooking->company_id,
                (int) $visitorBooking->id,
                (int) $session->id,
                $joinUrl ? 'confirmed' : 'updated',
                'Conference is live',
                $message
            );
        }

        $this->broadcastSessionLive($session, $joinUrl);

        return [
            'join_url' => $joinUrl,
            'host_url' => $joinUrl,
            'notified' => $bookings->count(),
        ];
    }

    public function broadcastSessionLive(BoothSession $session, ?string $joinUrl): int
    {
        $session->loadMissing('boothBooking');
        $booking = $session->boothBooking;

        if (! $booking?->exhibition_id || ! $booking->company_id) {
            return 0;
        }

        $companyMeeting = $session->companyMeeting ?: $this->syncConferenceMeeting($session);
        $companyName = $booking->boothProfile?->company_name
            ?: $booking->company?->company_name
            ?: $booking->company?->name
            ?: 'Exhibitor';

        $notified = 0;

        foreach ($this->completedPassesForExhibition((int) $booking->exhibition_id) as $pass) {
            $userId = $this->resolveUserId($pass);

            if (! $userId) {
                continue;
            }

            $alreadyLiveNotice = DB::table('meeting_notifications')
                ->where('visitor_id', $userId)
                ->where('booth_session_id', $session->id)
                ->where('type', 'session_live')
                ->where('created_at', '>=', now()->subHours(6))
                ->exists();

            if ($alreadyLiveNotice) {
                continue;
            }

            $visitorBooking = $this->ensureVisitorBookingForSession($session, $companyMeeting, $userId, $pass);

            $message = $joinUrl
                ? $companyName . ' conference "' . ($session->title ?: 'session') . '" is LIVE now. Open My Meetings to join: ' . $joinUrl
                : $companyName . ' conference "' . ($session->title ?: 'session') . '" is LIVE now. Request to join from My Meetings.';

            $this->insertVisitorNotification(
                $userId,
                (int) $booking->company_id,
                (int) $visitorBooking->id,
                (int) $session->id,
                'session_live',
                'Conference is live',
                $message
            );

            $notified++;
        }

        return $notified;
    }

    /**
     * @return array{host_url: string|null, join_url: string|null}
     */
    public function approveJoinRequest(VisitorMeetingBooking $visitorBooking, GoogleMeetService $googleMeetService): array
    {
        $visitorBooking->loadMissing(['companyMeeting', 'boothSession.boothBooking']);

        if (! $visitorBooking->booth_session_id || ! $visitorBooking->boothSession) {
            throw new \InvalidArgumentException('This request is not linked to a conference session.');
        }

        $session = $visitorBooking->boothSession;
        $companyMeeting = $visitorBooking->companyMeeting ?: $this->syncConferenceMeeting($session);

        $joinUrl = $companyMeeting->zoom_join_url ?: $companyMeeting->meeting_link;

        if (! $joinUrl) {
            $joinUrl = $this->provisionGoogleMeet($session, $googleMeetService);
        }

        $companyMeeting->refresh();
        $joinUrl = MeetingJoinUrls::resolve($companyMeeting) ?: $joinUrl;

        $visitorBooking->update([
            'status' => 'confirmed',
            'company_meeting_id' => $companyMeeting->id,
        ]);

        $companyMeeting->update(['status' => 'confirmed']);
        $session->update(['status' => 'live']);

        if ($visitorBooking->visitor_id) {
            $topic = $session->title ?: 'Conference Session';
            $message = $joinUrl
                ? 'Your join request for "' . $topic . '" was approved. Join here: ' . $joinUrl
                : 'Your join request for "' . $topic . '" was approved. The host will share the meeting link shortly.';

            $this->insertVisitorNotification(
                (int) $visitorBooking->visitor_id,
                (int) $visitorBooking->company_id,
                (int) $visitorBooking->id,
                (int) $session->id,
                $joinUrl ? 'confirmed' : 'updated',
                'Join request approved',
                $message
            );
        }

        return [
            'host_url' => $joinUrl,
            'join_url' => $joinUrl,
        ];
    }

    public function requestSessionJoin(BoothSession $session, int $userId, ?Visitor $pass = null): VisitorMeetingBooking
    {
        $session->loadMissing('boothBooking');
        $companyMeeting = $session->companyMeeting ?: $this->syncConferenceMeeting($session);
        $visitorBooking = $this->ensureVisitorBookingForSession($session, $companyMeeting, $userId, $pass);

        $joinUrl = $companyMeeting->zoom_join_url ?: $companyMeeting->meeting_link;
        $topic = $session->title ?: 'Conference Session';
        $user = User::find($userId);

        if ($joinUrl && in_array($visitorBooking->status, ['confirmed', 'accepted'], true)) {
            return $visitorBooking;
        }

        $alreadyRequested = $visitorBooking->join_requested_at
            && $visitorBooking->join_requested_at->gt(now()->subMinutes(10));

        if (! $alreadyRequested) {
            $visitorBooking->update(['join_requested_at' => now()]);

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $userId,
                'company_id' => $session->boothBooking->company_id,
                'visitor_meeting_booking_id' => $visitorBooking->id,
                'booth_session_id' => $session->id,
                'type' => 'join_request',
                'title' => 'Visitor requested to join conference',
                'message' => ($user?->name ?: $visitorBooking->visitor_name) . ' requested to join "' . $topic . '".',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $visitorBooking->fresh();
    }

    private function completedPassesForExhibition(int $exhibitionId)
    {
        return Visitor::query()
            ->where('exhibition_id', $exhibitionId)
            ->where('payment_status', 'completed')
            ->get();
    }

    private function insertVisitorNotification(
        int $visitorId,
        int $companyId,
        int $visitorMeetingBookingId,
        int $boothSessionId,
        string $type,
        string $title,
        string $message
    ): void {
        DB::table('meeting_notifications')->insert([
            'visitor_id' => $visitorId,
            'company_id' => $companyId,
            'visitor_meeting_booking_id' => $visitorMeetingBookingId,
            'booth_session_id' => $boothSessionId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
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
