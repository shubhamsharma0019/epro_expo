<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Shared\Services\GoogleMeetService;
use App\Domain\Shared\Services\ZoomMeetingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CompanyMeetingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meetings = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->latest()
            ->get();

        $upcoming = $meetings->filter(fn ($m) => in_array($m->status, ['pending', 'confirmed', 'accepted'], true));
        $completed = $meetings->filter(fn ($m) => $m->status === 'completed');
        $cancelled = $meetings->filter(fn ($m) => in_array($m->status, ['cancelled', 'rejected'], true));
        $rescheduled = $meetings->filter(fn ($m) => $m->status === 'rescheduled');

        return view('backend.company.meetings.index', compact('meetings', 'upcoming', 'completed', 'cancelled', 'rescheduled'));
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

        $googleMeetConfigured = $googleMeetService->isConfigured();

        return view('backend.company.meetings.show', compact('meeting', 'googleMeetConfigured'));
    }

    public function createZoom($id, GoogleMeetService $googleMeetService): RedirectResponse
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
            $linkPayload = $googleMeetService->createForCompanyMeeting($meeting->companyMeeting);
            $meeting->companyMeeting->update($linkPayload);
        } catch (\Throwable $exception) {
            Log::warning('Google Meet provision failed', [
                'visitor_meeting_booking_id' => $meeting->id,
                'message' => $exception->getMessage(),
            ]);

            return back()->with('error', $exception->getMessage());
        }

        return back()->with('status', 'Google Meet link is ready. Share it with the visitor.');
    }

    public function updateZoom(Request $request, $id): RedirectResponse
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

        if ($meeting->companyMeeting) {
            $payload = $validated;
            if (! empty($payload['meeting_link']) && empty($payload['zoom_join_url'])) {
                $payload['zoom_join_url'] = $payload['meeting_link'];
            }
            $meeting->companyMeeting->update($payload);
        }

        return back()->with('status', 'Google Meet details saved.');
    }

    public function updateStatus(Request $request, $id, GoogleMeetService $googleMeetService, ZoomMeetingService $zoomMeetingService): RedirectResponse
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
                $manualPayload['zoom_join_url'] = $request->input('meeting_link');
            } elseif (! filled($meeting->companyMeeting->zoom_join_url) && ! filled($meeting->companyMeeting->meeting_link)) {
                try {
                    $meetPayload = $googleMeetService->createForCompanyMeeting($meeting->companyMeeting);
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

        if (in_array($status, ['confirmed', 'completed', 'rescheduled'], true) && $meeting->companyMeeting) {
            $meeting->companyMeeting->update(array_merge($manualPayload, array_filter($meetPayload)));
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

        $message = match ($status) {
            'confirmed' => 'Meeting accepted. Google Meet link is ready for the visitor.',
            'completed' => 'Meeting marked as completed.',
            'rejected' => 'Meeting invitation declined.',
            'rescheduled' => 'Meeting successfully rescheduled.' . (filled($meetPayload) ? ' Google Meet link updated.' : ''),
            default => 'Meeting status updated.',
        };

        return redirect()->route('company.meetings.show', $meeting->id)
            ->with('status', $message);
    }
}
