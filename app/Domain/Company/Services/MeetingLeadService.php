<?php

namespace App\Domain\Company\Services;

use App\Domain\Company\Models\Enquiry;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MeetingLeadService
{
    public function recordHostJoin(VisitorMeetingBooking $booking): void
    {
        if ($booking->host_joined_at) {
            return;
        }

        $booking->update(['host_joined_at' => now()]);
    }

    public function recordVisitorJoinAndCaptureLead(VisitorMeetingBooking $booking): void
    {
        if (! $booking->visitor_joined_at) {
            $booking->update(['visitor_joined_at' => now()]);
        }

        $this->captureLead($booking);
    }

    public function captureLead(VisitorMeetingBooking $booking): void
    {
        if (Enquiry::query()->where('visitor_meeting_booking_id', $booking->id)->exists()) {
            return;
        }

        $topic = $booking->meeting_topic
            ?: $booking->companyMeeting?->title
            ?: 'Meeting';

        $message = 'Visitor joined the Google Meet session.';
        if (filled($booking->message)) {
            $message .= ' Original request: ' . $booking->message;
        }

        $enquiry = Enquiry::create([
            'company_id' => $booking->company_id,
            'visitor_id' => $booking->visitor_id,
            'visitor_meeting_booking_id' => $booking->id,
            'name' => $booking->visitor_name ?: 'Visitor',
            'email' => $booking->visitor_email ?: '',
            'phone' => $booking->visitor_phone,
            'subject' => 'Meeting Join: ' . $topic,
            'message' => $message,
            'status' => 'new',
        ]);

        if (! Schema::hasTable('admin_leads')) {
            return;
        }

        $leadExists = DB::table('admin_leads')
            ->where('visitor_meeting_booking_id', $booking->id)
            ->exists();

        if ($leadExists) {
            return;
        }

        DB::table('admin_leads')->insert([
            'company_id' => $booking->company_id,
            'enquiry_id' => $enquiry->id,
            'visitor_meeting_booking_id' => $booking->id,
            'lead_source' => 'meeting',
            'lead_status' => 'new',
            'lead_score' => 75,
            'notes' => 'Visitor joined Google Meet for: ' . $topic,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
