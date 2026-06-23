<?php

namespace App\Domain\Shared\Services;

use App\Domain\Company\Models\CompanyMeeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ZoomMeetingService
{
    public function isConfigured(): bool
    {
        return filled(config('services.zoom.account_id'))
            && filled(config('services.zoom.client_id'))
            && filled(config('services.zoom.client_secret'));
    }

    /**
     * @return array{configured: bool, meeting_link?: string, zoom_meeting_id?: string, zoom_passcode?: string, zoom_join_url?: string, zoom_start_url?: string, zoom_duration?: int, zoom_meeting_status?: string}
     */
    public function createForCompanyMeeting(CompanyMeeting $meeting): array
    {
        if (! $this->isConfigured()) {
            return ['configured' => false];
        }

        $token = $this->accessToken();
        $start = $this->resolveStartTime($meeting);
        $duration = (int) ($meeting->zoom_duration ?: config('services.zoom.default_duration', 30));
        $userId = config('services.zoom.user_id', 'me');

        $response = Http::withToken($token)
            ->post("https://api.zoom.us/v2/users/{$userId}/meetings", [
                'topic' => $meeting->title ?: 'Exhibition Meeting',
                'type' => 2,
                'start_time' => $start->utc()->format('Y-m-d\TH:i:s\Z'),
                'duration' => $duration,
                'timezone' => config('app.timezone', 'UTC'),
                'agenda' => $meeting->meeting_agenda ?: $meeting->description,
                'settings' => [
                    'join_before_host' => true,
                    'waiting_room' => false,
                ],
            ]);

        if (! $response->successful()) {
            Log::warning('Zoom meeting creation failed', [
                'meeting_id' => $meeting->id,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('Unable to create Zoom meeting. Check Zoom API credentials.');
        }

        $payload = $response->json();

        return $this->mapMeetingResponse($payload, $duration);
    }

    /**
     * @return array{configured: bool, meeting_link?: string, zoom_meeting_id?: string, zoom_passcode?: string, zoom_join_url?: string, zoom_start_url?: string, zoom_duration?: int, zoom_meeting_status?: string}
     */
    public function updateForCompanyMeeting(CompanyMeeting $meeting): array
    {
        if (! $this->isConfigured()) {
            return ['configured' => false];
        }

        if (! filled($meeting->zoom_meeting_id)) {
            return $this->createForCompanyMeeting($meeting);
        }

        $token = $this->accessToken();
        $start = $this->resolveStartTime($meeting);
        $duration = (int) ($meeting->zoom_duration ?: config('services.zoom.default_duration', 30));

        $response = Http::withToken($token)
            ->patch("https://api.zoom.us/v2/meetings/{$meeting->zoom_meeting_id}", [
                'topic' => $meeting->title ?: 'Exhibition Meeting',
                'start_time' => $start->utc()->format('Y-m-d\TH:i:s\Z'),
                'duration' => $duration,
                'timezone' => config('app.timezone', 'UTC'),
                'agenda' => $meeting->meeting_agenda ?: $meeting->description,
            ]);

        if (! $response->successful()) {
            Log::warning('Zoom meeting update failed', [
                'meeting_id' => $meeting->id,
                'zoom_meeting_id' => $meeting->zoom_meeting_id,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('Unable to update Zoom meeting. Check Zoom API credentials.');
        }

        return $this->mapMeetingResponse($response->json(), $duration);
    }

    public function deleteForCompanyMeeting(CompanyMeeting $meeting): void
    {
        if (! $this->isConfigured() || ! filled($meeting->zoom_meeting_id)) {
            return;
        }

        $token = $this->accessToken();

        $response = Http::withToken($token)
            ->delete("https://api.zoom.us/v2/meetings/{$meeting->zoom_meeting_id}");

        if (! $response->successful() && $response->status() !== 404) {
            Log::warning('Zoom meeting delete failed', [
                'meeting_id' => $meeting->id,
                'zoom_meeting_id' => $meeting->zoom_meeting_id,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
        }
    }

    protected function resolveStartTime(CompanyMeeting $meeting): Carbon
    {
        if ($meeting->start_time instanceof Carbon) {
            return $meeting->start_time;
        }

        if ($meeting->meeting_date && $meeting->meeting_time) {
            return Carbon::parse($meeting->meeting_date->format('Y-m-d') . ' ' . $meeting->meeting_time);
        }

        return Carbon::parse($meeting->start_time ?? now()->addDay());
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array{configured: bool, meeting_link?: string, zoom_meeting_id?: string, zoom_passcode?: string, zoom_join_url?: string, zoom_start_url?: string, zoom_duration?: int, zoom_meeting_status?: string}
     */
    protected function mapMeetingResponse(array $payload, int $duration): array
    {
        return [
            'configured' => true,
            'meeting_link' => $payload['join_url'] ?? null,
            'zoom_meeting_id' => isset($payload['id']) ? (string) $payload['id'] : null,
            'zoom_passcode' => $payload['password'] ?? null,
            'zoom_join_url' => $payload['join_url'] ?? null,
            'zoom_start_url' => $payload['start_url'] ?? null,
            'zoom_duration' => $duration,
            'zoom_meeting_status' => 'scheduled',
        ];
    }

    protected function accessToken(): string
    {
        $accountId = config('services.zoom.account_id');
        $clientId = config('services.zoom.client_id');
        $clientSecret = config('services.zoom.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if (! $response->successful()) {
            Log::warning('Zoom OAuth token request failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('Unable to authenticate with Zoom API.');
        }

        $token = $response->json('access_token');

        if (! $token) {
            throw new RuntimeException('Zoom API did not return an access token.');
        }

        return $token;
    }
}
