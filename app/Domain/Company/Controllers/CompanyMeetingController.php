<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Company\Services\MeetingLeadService;
use App\Domain\Shared\Services\GoogleMeetService;
use App\Domain\Shared\Services\ZoomMeetingService;
use App\Support\MeetingJoinUrls;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Carbon\Carbon;

class CompanyMeetingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = (int) session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meetings = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->latest()
            ->get();

        $upcoming = $meetings->filter(fn ($m) => in_array($m->status, ['pending', 'waitlisted', 'confirmed', 'accepted'], true));
        $completed = $meetings->filter(fn ($m) => $m->status === 'completed');
        $cancelled = $meetings->filter(fn ($m) => in_array($m->status, ['cancelled', 'rejected'], true));
        $rescheduled = $meetings->filter(fn ($m) => $m->status === 'rescheduled');

        return view('company.meetings.meeting-requests', compact('meetings', 'upcoming', 'completed', 'cancelled', 'rescheduled'));
    }

    public function show($id, GoogleMeetService $googleMeetService): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        $this->healStaleGoogleMeetLinks($meeting);

        if ($meeting->companyMeeting) {
            MeetingJoinUrls::syncModel($meeting->companyMeeting);
            $meeting->load('companyMeeting');
        }

        $googleMeetConfigured = $googleMeetService->isConfigured();
        $meetJoinUrl = $meeting->companyMeeting ? MeetingJoinUrls::resolve($meeting->companyMeeting) : null;

        return view('company.meetings.meeting-details', compact('meeting', 'googleMeetConfigured', 'meetJoinUrl'));
    }

    public function joinMeeting($id, MeetingLeadService $meetingLeadService): RedirectResponse
    {
        $companyId = (int) session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        if (! $meeting->companyMeeting) {
            return back()->with('error', 'Meeting details not found.');
        }

        MeetingJoinUrls::syncModel($meeting->companyMeeting);
        $meetUrl = MeetingJoinUrls::resolve($meeting->companyMeeting->fresh());

        if (! $meetUrl) {
            return back()->with('error', 'No Google Meet link saved yet. Paste your meet.google.com link and click Save meeting details.');
        }

        $meetingLeadService->recordHostJoin($meeting);

        return redirect()->away($meetUrl);
    }

    public function createZoom($id, GoogleMeetService $googleMeetService, MeetingLeadService $meetingLeadService): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        if (! $meeting->companyMeeting) {
            return back()->with('error', 'Meeting details not found.');
        }

        try {
            $linkPayload = $googleMeetService->createForCompanyMeeting(
                $meeting->companyMeeting,
                array_filter([$meeting->visitor_email])
            );
            $meeting->companyMeeting->update(array_merge(
                $linkPayload,
                $this->meetingParticipantEmails($meeting, (int) $companyId)
            ));
        } catch (\Throwable $exception) {
            Log::warning('Google Meet provision failed', [
                'visitor_meeting_booking_id' => $meeting->id,
                'message' => $exception->getMessage(),
            ]);

            return back()->with('error', $exception->getMessage());
        }

        $joinUrl = MeetingJoinUrls::resolve($meeting->companyMeeting->fresh());
        $autoConfirmed = $this->confirmMeetingIfPending($meeting);
        $this->notifyVisitor($meeting, $autoConfirmed ? 'confirmed' : 'updated', $joinUrl);

        if ($joinUrl) {
            $meetingLeadService->recordHostJoin($meeting);

            return redirect()->away($joinUrl);
        }

        $message = $autoConfirmed
            ? 'Google Meet link created and meeting confirmed. The visitor can join from My Meetings.'
            : 'Google Meet link is ready. The visitor has been notified.';

        return back()->with('status', $message);
    }

    public function updateZoom(Request $request, $id, MeetingLeadService $meetingLeadService): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'meeting_link' => ['nullable', 'url', 'max:500'],
            'zoom_meeting_id' => ['nullable', 'string', 'max:100'],
            'zoom_passcode' => ['nullable', 'string', 'max:100'],
            'meeting_date' => ['nullable', 'date'],
            'meeting_time' => ['nullable', 'date_format:H:i'],
            'meeting_agenda' => ['nullable', 'string', 'max:2000'],
        ]);

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        if (! $meeting->companyMeeting) {
            return back()->with('error', 'Meeting details not found.');
        }

        $payload = array_filter($validated, fn ($value) => $value !== null && $value !== '');

        if (! empty($payload['meeting_link'])) {
            $payload = $this->syncGoogleMeetLinkFields($payload);
        }

        if (! empty($payload['meeting_date']) && ! empty($payload['meeting_time'])) {
            $start = Carbon::parse($payload['meeting_date'] . ' ' . $payload['meeting_time']);
            $payload['start_time'] = $start->format('Y-m-d H:i:s');
            $payload['end_time'] = $start->copy()->addMinutes(30)->format('Y-m-d H:i:s');
            $payload['meeting_time'] = $start->format('H:i:s');
        }

        $payload = array_merge($payload, $this->meetingParticipantEmails($meeting, (int) $companyId));

        $meeting->companyMeeting->update($payload);
        MeetingJoinUrls::syncModel($meeting->companyMeeting);

        $joinUrl = MeetingJoinUrls::resolve($meeting->companyMeeting->fresh());
        $autoConfirmed = ! empty($joinUrl) && $this->confirmMeetingIfPending($meeting);
        $this->notifyVisitor($meeting, $autoConfirmed ? 'confirmed' : 'updated', $joinUrl);

        if ($joinUrl) {
            $meetingLeadService->recordHostJoin($meeting);

            return redirect()->away($joinUrl);
        }

        $message = $autoConfirmed
            ? 'Meeting confirmed. Google Meet link sent to the visitor — they can join from My Meetings.'
            : 'Meeting details saved and the visitor has been notified.';

        return back()->with('status', $message);
    }

    public function updateStatus(Request $request, $id, GoogleMeetService $googleMeetService, ZoomMeetingService $zoomMeetingService, MeetingLeadService $meetingLeadService): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:confirmed,accepted,rejected,pending,completed,rescheduled,cancelled'],
            'meeting_link' => ['nullable', 'url', 'max:500'],
            'zoom_meeting_id' => ['nullable', 'string', 'max:100'],
            'zoom_passcode' => ['nullable', 'string', 'max:100'],
            'meeting_date' => ['nullable', 'date'],
            'meeting_time' => ['nullable', 'date_format:H:i'],
            'meeting_agenda' => ['nullable', 'string', 'max:2000'],
        ]);

        $meeting = VisitorMeetingBooking::with('companyMeeting')->where('company_id', $companyId)->findOrFail($id);
        $status = $request->input('status') === 'accepted' ? 'confirmed' : $request->input('status');

        $oldDate = $meeting->companyMeeting?->meeting_date?->format('Y-m-d');
        $oldTime = $meeting->companyMeeting?->meeting_time;

        if ($status === 'rescheduled' && $request->filled('meeting_date') && $request->filled('meeting_time')) {
            $engine = new \App\Domain\Shared\Services\SmartSchedulingEngine();
            $exhibitionId = \App\Domain\Booth\Models\BoothBooking::where('company_id', $companyId)->first()?->exhibition_id ?? 1;

            $validation = $engine->validateMeetingRequest(
                (int) $companyId,
                $meeting->visitor_id,
                $meeting->visitor_email,
                $request->input('meeting_date'),
                $request->input('meeting_time'),
                $meeting->companyMeeting?->meeting_type ?? 'one-to-one',
                $exhibitionId
            );

            if (! $validation['valid']) {
                $errorMsg = $validation['conflict'];
                if ($validation['suggest_slot']) {
                    $suggested = $validation['suggest_slot'];
                    $sDate = \Carbon\Carbon::parse($suggested->date)->format('M d, Y');
                    $sTime = \Carbon\Carbon::parse($suggested->start_time)->format('h:i A');
                    $errorMsg .= " Suggested next available slot: {$sDate} at {$sTime}.";
                }

                return back()->with('error', $errorMsg)->withInput();
            }
        }

        $manualPayload = array_filter([
            'meeting_link' => $request->input('meeting_link'),
            'zoom_meeting_id' => $request->input('zoom_meeting_id'),
            'zoom_passcode' => $request->input('zoom_passcode'),
            'meeting_date' => $request->input('meeting_date'),
            'meeting_time' => $request->input('meeting_time'),
            'meeting_agenda' => $request->input('meeting_agenda'),
        ], fn ($value) => $value !== null && $value !== '');

        if ($status === 'rescheduled' && $request->filled('meeting_date') && $request->filled('meeting_time')) {
            $newStart = $request->input('meeting_date') . ' ' . $request->input('meeting_time');
            $newEnd = \Carbon\Carbon::parse($newStart)->addMinutes(30)->format('Y-m-d H:i:s');
            $manualPayload['start_time'] = $newStart;
            $manualPayload['end_time'] = $newEnd;
        }

        $meetPayload = [];

        if (in_array($status, ['confirmed', 'rescheduled'], true) && $meeting->companyMeeting) {
            if ($request->filled('meeting_link')) {
                $manualPayload = array_merge(
                    $manualPayload,
                    $this->syncGoogleMeetLinkFields(['meeting_link' => $request->input('meeting_link')])
                );
            } elseif (! MeetingJoinUrls::resolve($meeting->companyMeeting)) {
                try {
                    $meetPayload = $googleMeetService->createForCompanyMeeting(
                        $meeting->companyMeeting,
                        array_filter([$meeting->visitor_email])
                    );
                } catch (\Throwable $exception) {
                    Log::warning('Google Meet auto-provision failed', [
                        'visitor_meeting_booking_id' => $meeting->id,
                        'message' => $exception->getMessage(),
                    ]);

                    return back()->with('error', $exception->getMessage() . ' You can paste a Google Meet link manually below.')->withInput();
                }
            }
        }

        if (in_array($status, ['rejected', 'cancelled'], true) && $meeting->companyMeeting) {
            try {
                $zoomMeetingService->deleteForCompanyMeeting($meeting->companyMeeting);
            } catch (\Throwable $exception) {
                Log::warning('Zoom meeting delete skipped', [
                    'visitor_meeting_booking_id' => $meeting->id,
                    'message' => $exception->getMessage(),
                ]);
            }
        }

        if (in_array($status, ['rejected', 'cancelled', 'rescheduled'], true) && $oldDate && $oldTime) {
            $oldSlot = \App\Domain\Booth\Models\BoothMeetingSlot::where('company_id', $companyId)
                ->where('date', $oldDate)
                ->where('start_time', $oldTime)
                ->first();
            if ($oldSlot) {
                $oldSlot->update(['status' => 'available']);
            }
        }

        if (in_array($status, ['confirmed', 'rescheduled'], true) && $request->filled('meeting_date') && $request->filled('meeting_time')) {
            $newSlot = \App\Domain\Booth\Models\BoothMeetingSlot::where('company_id', $companyId)
                ->where('date', $request->input('meeting_date'))
                ->where('start_time', $request->input('meeting_time'))
                ->first();
            if ($newSlot) {
                $newSlot->update(['status' => 'booked']);
            }
        }

        $meeting->update([
            'status' => $status,
            'updated_by' => auth()->id(),
            'completed_at' => $status === 'completed' ? now() : $meeting->completed_at,
        ]);

        if ($meeting->companyMeeting) {
            $companyPayload = ['status' => $status];

            if (in_array($status, ['confirmed', 'completed', 'rescheduled'], true)) {
                $companyPayload = array_merge(
                    $companyPayload,
                    $manualPayload,
                    array_filter($meetPayload),
                    $this->meetingParticipantEmails($meeting, (int) $companyId)
                );
            }

            $meeting->companyMeeting->update($companyPayload);
            MeetingJoinUrls::syncModel($meeting->companyMeeting);
        }

        \Illuminate\Support\Facades\DB::table('meeting_notifications')->insert([
            'visitor_id' => $meeting->visitor_id,
            'company_id' => $companyId,
            'visitor_meeting_booking_id' => $meeting->id,
            'type' => $status,
            'title' => 'Meeting ' . ucfirst($status),
            'message' => 'The meeting status has been updated to ' . $status . ' by the company.',
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (in_array($status, ['confirmed', 'rescheduled'], true)) {
            $meeting->load('companyMeeting');
            $joinUrl = MeetingJoinUrls::resolve($meeting->companyMeeting);
            if ($joinUrl) {
                $this->notifyVisitor($meeting, $status === 'confirmed' ? 'confirmed' : 'updated', $joinUrl);
            }
        }

        $message = match ($status) {
            'confirmed' => 'Meeting accepted. Google Meet link is ready for the visitor.',
            'completed' => 'Meeting marked as completed.',
            'rejected' => 'Meeting invitation declined.',
            'rescheduled' => 'Meeting successfully rescheduled.' . (filled($meetPayload) ? ' Google Meet link updated.' : ''),
            default => 'Meeting status updated.',
        };

        if ($status === 'confirmed') {
            $meetUrl = MeetingJoinUrls::resolve($meeting->companyMeeting);

            if ($meetUrl) {
                $meetingLeadService->recordHostJoin($meeting);

                return redirect()->away($meetUrl);
            }
        }

        return redirect()->route('company.meetings.show', $meeting->id)
            ->with('status', $message);
    }

    private function confirmMeetingIfPending(VisitorMeetingBooking $meeting): bool
    {
        if ($meeting->status !== 'pending') {
            return false;
        }

        $meeting->update(['status' => 'confirmed', 'updated_by' => auth()->id()]);
        $meeting->companyMeeting?->update(['status' => 'confirmed']);

        return true;
    }

    private function syncGoogleMeetLinkFields(array $payload): array
    {
        $link = $payload['meeting_link'] ?? null;

        if (! $link) {
            return $payload;
        }

        return array_merge($payload, MeetingJoinUrls::syncPayload($link));
    }

    /** @return array{host_email: ?string, attendee_email: ?string} */
    private function meetingParticipantEmails(VisitorMeetingBooking $meeting, int $companyId): array
    {
        $companyEmail = DB::table('companies')->where('id', $companyId)->value('email');

        return array_filter([
            'host_email' => filled($companyEmail) ? $companyEmail : null,
            'attendee_email' => filled($meeting->visitor_email) ? $meeting->visitor_email : null,
        ], fn ($value) => filled($value));
    }

    private function healStaleGoogleMeetLinks(VisitorMeetingBooking $meeting): void
    {
        if (! $meeting->companyMeeting) {
            return;
        }

        MeetingJoinUrls::syncModel($meeting->companyMeeting);
        $meeting->load('companyMeeting');
    }

    private function notifyVisitor(VisitorMeetingBooking $meeting, string $type, ?string $joinUrl = null): void
    {
        $title = match ($type) {
            'confirmed' => 'Meeting Accepted',
            'updated' => 'Meeting Details Updated',
            default => 'Meeting Update',
        };

        $message = match ($type) {
            'confirmed' => 'Your meeting request has been accepted by the company.',
            'updated' => 'The company updated your meeting details.',
            default => 'Your meeting has been updated.',
        };

        if ($joinUrl) {
            $message .= ' Join here: ' . $joinUrl;
        }

        DB::table('meeting_notifications')->insert([
            'visitor_id' => $meeting->visitor_id,
            'company_id' => $meeting->company_id,
            'visitor_meeting_booking_id' => $meeting->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
