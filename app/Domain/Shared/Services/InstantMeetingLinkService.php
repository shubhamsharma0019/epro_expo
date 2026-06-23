<?php

namespace App\Domain\Shared\Services;

use App\Domain\Company\Models\CompanyMeeting;

class InstantMeetingLinkService
{
    /**
     * @return array{meeting_link: string, zoom_join_url: string, zoom_start_url: string, zoom_meeting_status: string}
     */
    public function createForCompanyMeeting(CompanyMeeting $meeting): array
    {
        $roomSlug = 'EproExpo-' . $meeting->id . '-' . substr(
            hash('crc32b', $meeting->id . '|' . config('app.key')),
            0,
            8
        );

        $joinUrl = rtrim(config('services.meeting.jitsi_base_url', 'https://meet.jit.si'), '/') . '/' . $roomSlug;

        return [
            'meeting_link' => $joinUrl,
            'zoom_join_url' => $joinUrl,
            'zoom_start_url' => $joinUrl,
            'zoom_meeting_status' => 'scheduled',
        ];
    }
}
