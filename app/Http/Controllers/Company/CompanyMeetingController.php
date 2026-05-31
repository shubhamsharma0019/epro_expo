<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\VisitorMeetingBooking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        return view('company.meetings.index', compact('meetings'));
    }

    public function show($id): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $meeting = VisitorMeetingBooking::with('companyMeeting')
            ->where('company_id', $companyId)
            ->findOrFail($id);

        return view('company.meetings.show', compact('meeting'));
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:confirmed,rejected,pending'],
        ]);

        $meeting = VisitorMeetingBooking::with('companyMeeting')->where('company_id', $companyId)->findOrFail($id);
        $status = $request->input('status');
        
        $meeting->update(['status' => $status]);

        if ($status === 'confirmed') {
            // Generate Mock Zoom Link
            $zoomId = rand(1000000000, 9999999999);
            $zoomLink = "https://zoom.us/j/{$zoomId}?pwd=" . bin2hex(random_bytes(8));
            
            // Save link on the CompanyMeeting if it doesn't have one
            if ($meeting->companyMeeting && empty($meeting->companyMeeting->meeting_link)) {
                $meeting->companyMeeting->update(['meeting_link' => $zoomLink]);
            }
        }

        $message = $status === 'confirmed' 
            ? 'Meeting confirmed successfully! Zoom link has been generated.' 
            : 'Meeting invitation declined.';

        return redirect()->route('company.meetings.show', $meeting->id)
            ->with('status', $message);
    }
}
