<?php

namespace App\Domain\Shared\Services;

use App\Domain\Company\Models\CompanyMeeting;
use Carbon\Carbon;
use App\Support\MeetingJoinUrls;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class GoogleMeetService
{
    public function isConfigured(): bool
    {
        return filled(config('services.google_meet.client_id'))
            && filled(config('services.google_meet.client_secret'))
            && filled(config('services.google_meet.refresh_token'));
    }

    /**
     * @param  list<string>  $extraAttendeeEmails
     * @return array{meeting_link: string, zoom_join_url: string, zoom_start_url: string, zoom_meeting_id: string|null, zoom_meeting_status: string}
     */
    public function createForCompanyMeeting(CompanyMeeting $meeting, array $extraAttendeeEmails = []): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Google Meet is not configured. Add GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, and GOOGLE_REFRESH_TOKEN to .env.');
        }

        $meeting->loadMissing(['company', 'boothSession.teamMember', 'visitorMeetingBookings']);

        $attendeeEmails = collect([
            $meeting->company?->email,
            $meeting->boothSession?->teamMember?->email,
        ])
            ->merge($extraAttendeeEmails)
            ->merge($meeting->visitorMeetingBookings->pluck('visitor_email'))
            ->filter(fn ($email) => filled($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->map(fn (string $email) => ['email' => $email])
            ->all();

        $token = $this->accessToken();
        $timezone = config('services.google_meet.timezone', config('app.timezone', 'Asia/Kolkata'));
        $start = $this->resolveStartTime($meeting);
        $duration = (int) config('services.google_meet.default_duration', 30);
        $end = (clone $start)->addMinutes($duration);
        $calendarId = config('services.google_meet.calendar_id', 'primary');

        $eventPayload = [
            'summary' => $meeting->title ?: 'Exhibition Meeting',
            'description' => $meeting->meeting_agenda ?: $meeting->description,
            'start' => [
                'dateTime' => $start->format('Y-m-d\TH:i:s'),
                'timeZone' => $timezone,
            ],
            'end' => [
                'dateTime' => $end->format('Y-m-d\TH:i:s'),
                'timeZone' => $timezone,
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => 'erpoexpo-' . $meeting->id . '-' . Str::lower(Str::random(8)),
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
        ];

        if ($attendeeEmails !== []) {
            $eventPayload['attendees'] = $attendeeEmails;
            $eventPayload['guestsCanModify'] = false;
            $eventPayload['guestsCanInviteOthers'] = false;
            $eventPayload['guestsCanSeeOtherGuests'] = true;
        }

        $query = 'conferenceDataVersion=1' . ($attendeeEmails !== [] ? '&sendUpdates=all' : '');

        $response = Http::withToken($token)
            ->post("https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events?{$query}", $eventPayload);

        if (! $response->successful()) {
            Log::warning('Google Meet creation failed', [
                'meeting_id' => $meeting->id,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('Unable to create Google Meet. Check Google Calendar API credentials.');
        }

        $payload = $response->json();
        $eventId = $payload['id'] ?? null;
        $joinUrl = $this->extractMeetUrl($payload);

        if (! $joinUrl && $eventId) {
            $fetch = Http::withToken($token)
                ->get("https://www.googleapis.com/calendar/v3/calendars/{$calendarId}/events/{$eventId}", [
                    'conferenceDataVersion' => 1,
                ]);

            if ($fetch->successful()) {
                $joinUrl = $this->extractMeetUrl($fetch->json());
            }
        }

        if (! $joinUrl) {
            throw new RuntimeException('Google Meet link was not returned by Google Calendar API.');
        }

        preg_match('#meet\.google\.com/([a-z]{3}-[a-z]{4}-[a-z]{3})#i', $joinUrl, $matches);
        $meetCode = $matches[1] ?? null;
        $calendarLink = $payload['htmlLink'] ?? null;

        return array_merge(
            MeetingJoinUrls::syncPayload($joinUrl, $calendarLink),
            [
                'zoom_meeting_id' => $meetCode,
                'zoom_meeting_status' => 'scheduled',
            ]
        );
    }

    protected function extractMeetUrl(array $payload): ?string
    {
        $candidates = [];

        if (! empty($payload['hangoutLink'])) {
            $candidates[] = $payload['hangoutLink'];
        }

        foreach ($payload['conferenceData']['entryPoints'] ?? [] as $entryPoint) {
            if (($entryPoint['entryPointType'] ?? '') === 'video' && ! empty($entryPoint['uri'])) {
                $candidates[] = $entryPoint['uri'];
            }
        }

        foreach ($candidates as $url) {
            $url = strtok($url, '?') ?: $url;
            if (preg_match('#^https://meet\.google\.com/[a-z]{3}-[a-z]{4}-[a-z]{3}$#i', $url)) {
                return $url;
            }
        }

        return null;
    }

    protected function resolveStartTime(CompanyMeeting $meeting): Carbon
    {
        if ($meeting->start_time instanceof Carbon) {
            return $meeting->start_time;
        }

        if ($meeting->meeting_date && $meeting->meeting_time) {
            return Carbon::parse($meeting->meeting_date->format('Y-m-d') . ' ' . $meeting->meeting_time);
        }

        return Carbon::parse($meeting->start_time ?? now()->addHour());
    }

    protected function accessToken(): string
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google_meet.client_id'),
            'client_secret' => config('services.google_meet.client_secret'),
            'refresh_token' => config('services.google_meet.refresh_token'),
            'grant_type' => 'refresh_token',
        ]);

        if (! $response->successful()) {
            Log::warning('Google OAuth token request failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('Unable to authenticate with Google API. Refresh token may be invalid.');
        }

        $token = $response->json('access_token');

        if (! $token) {
            throw new RuntimeException('Google API did not return an access token.');
        }

        return $token;
    }
}
