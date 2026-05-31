<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothPublishRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoothApprovalController extends Controller
{
    public function index(): View
    {
        return view('admin.booth-approvals.index', [
            'publishRequests' => BoothPublishRequest::with(['boothBooking.company', 'boothBooking.booth'])->latest()->get(),
        ]);
    }

    public function show(BoothPublishRequest $publishRequest): View
    {
        return view('admin.booth-approvals.show', [
            'publishRequest' => $publishRequest->load(['boothBooking.company', 'boothBooking.booth']),
        ]);
    }

    public function approve(BoothPublishRequest $publishRequest): RedirectResponse
    {
        $publishRequest->update(['status' => 'approved', 'reviewed_by' => session('admin_id'), 'reviewed_at' => now()]);
        $publishRequest->boothBooking?->update(['booth_setup_status' => 'published']);

        return back()->with('status', 'Booth approved and marked published.');
    }

    public function reject(Request $request, BoothPublishRequest $publishRequest): RedirectResponse
    {
        $validated = $request->validate(['rejection_reason' => ['required', 'string']]);
        $publishRequest->update(['status' => 'rejected', 'reviewed_by' => session('admin_id'), 'reviewed_at' => now(), 'rejection_reason' => $validated['rejection_reason']]);
        $publishRequest->boothBooking?->update(['booth_setup_status' => 'rejected']);

        return back()->with('status', 'Booth rejected.');
    }
}
