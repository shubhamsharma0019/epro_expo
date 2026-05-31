<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyEvent\CompanyEventPublishRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventApprovalController extends Controller
{
    public function index(): View
    {
        return view('admin.event-approvals.index', [
            'publishRequests' => CompanyEventPublishRequest::query()
                ->with(['company', 'companyEvent.branding', 'companyEvent.ticketTypes'])
                ->latest()
                ->get(),
        ]);
    }

    public function show(CompanyEventPublishRequest $publishRequest): View
    {
        return view('admin.event-approvals.show', [
            'publishRequest' => $publishRequest->load(['company', 'companyEvent.branding', 'companyEvent.ticketTypes']),
        ]);
    }

    public function approve(CompanyEventPublishRequest $publishRequest): RedirectResponse
    {
        $publishRequest->update([
            'status' => 'approved',
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
        ]);

        $publishRequest->companyEvent?->update([
            'status' => 'published',
            'visibility' => 'public',
            'published_at' => now(),
        ]);

        return back()->with('status', 'Event approved and published live.');
    }

    public function reject(Request $request, CompanyEventPublishRequest $publishRequest): RedirectResponse
    {
        $validated = $request->validate([
            'review_notes' => ['required', 'string', 'max:2000'],
        ]);

        $publishRequest->update([
            'status' => 'rejected',
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
        ]);

        $publishRequest->companyEvent?->update([
            'status' => 'draft',
        ]);

        return back()->with('status', 'Event rejected and returned to draft.');
    }
}
