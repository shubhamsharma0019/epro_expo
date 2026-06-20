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
        $start = $meeting->start_time instanceof Carbon
            ? $meeting->start_time
            : Carbon::parse($meeting->start_time ?? now()->addDay());

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
