<?php

namespace App\Support;

use App\Domain\Company\Models\CompanyMeeting;

class MeetingJoinUrls
{
    public static function normalize(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = strtok(trim($url), '?') ?: trim($url);

        if (preg_match('#(https://meet\.google\.com/[a-z]{3}-[a-z]{4}-[a-z]{3})#i', $url, $matches)) {
            return strtolower($matches[1]);
        }

        return $url;
    }

    public static function resolve(CompanyMeeting $companyMeeting): ?string
    {
        foreach ([
            $companyMeeting->zoom_join_url,
            $companyMeeting->meeting_link,
            $companyMeeting->zoom_start_url,
        ] as $candidate) {
            $normalized = self::normalize($candidate);

            if ($normalized && str_contains($normalized, 'meet.google.com')) {
                return $normalized;
            }
        }

        return null;
    }

    /** @return array<string, mixed> */
    public static function syncPayload(string $url, ?string $calendarLink = null): array
    {
        $meetUrl = self::normalize($url);

        if (! $meetUrl) {
            return [];
        }

        $payload = [
            'meeting_link' => $meetUrl,
            'zoom_join_url' => $meetUrl,
            'zoom_start_url' => $meetUrl,
        ];

        if (preg_match('~meet\.google\.com/([a-z0-9-]+)~i', $meetUrl, $matches)) {
            $payload['zoom_meeting_id'] = $matches[1];
        }

        if (filled($calendarLink) && ! str_contains($calendarLink, 'meet.google.com')) {
            $payload['google_calendar_link'] = $calendarLink;
        }

        return $payload;
    }

    public static function syncModel(CompanyMeeting $companyMeeting, ?string $calendarLink = null): void
    {
        $meetUrl = self::resolve($companyMeeting);

        if (! $meetUrl) {
            return;
        }

        $companyMeeting->update(self::syncPayload(
            $meetUrl,
            $calendarLink ?: $companyMeeting->google_calendar_link
        ));
    }
}
