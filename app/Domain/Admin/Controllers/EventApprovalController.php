<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', 'all');

        $rows = CompanyEventPublishRequest::query()
            ->with(['company', 'companyEvent'])
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->latest()
            ->paginate(12)
            ->through(function (CompanyEventPublishRequest $publishRequest) {
                $event = $publishRequest->companyEvent;

                return [
                    'url' => route('admin.event-approvals.show', $publishRequest),
                    'cells' => [
                        $event?->title ?? 'Event',
                        $publishRequest->company?->company_name ?? 'Company',
                        $this->badge($publishRequest->status),
                        $publishRequest->created_at?->format('M d, Y') ?? 'N/A',
                    ],
                    'actions' => array_values(array_filter([
                        $publishRequest->status === 'pending' ? [
                            'label' => 'Approve',
                            'href' => route('admin.event-approvals.approve', $publishRequest),
                            'method' => 'POST',
                            'variant' => 'success',
                        ] : null,
                        $publishRequest->status === 'pending' ? [
                            'label' => 'Reject',
                            'href' => route('admin.event-approvals.reject', $publishRequest),
                            'method' => 'POST',
                            'variant' => 'danger',
                        ] : null,
                        $publishRequest->status === 'approved' && ($event?->publish_status ?? '') !== 'published' ? [
                            'label' => 'Publish',
                            'href' => route('admin.event-approvals.publish', $publishRequest),
                            'method' => 'POST',
                            'variant' => 'success',
                        ] : null,
                        ($event?->publish_status ?? '') === 'published' ? [
                            'label' => 'Unpublish',
                            'href' => route('admin.event-approvals.unpublish', $publishRequest),
                            'method' => 'POST',
                            'variant' => 'danger',
                        ] : null,
                        [
                            'label' => 'Review',
                            'href' => route('admin.event-approvals.show', $publishRequest),
                        ],
                    ])),
                ];
            });

        return view('admin.resources.index', [
            'pageTitle' => 'Event Approval',
            'pageDescription' => 'Review company event publish requests before they go live.',
            'search' => '',
            'status' => $status,
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Requests', 'value' => CompanyEventPublishRequest::count(), 'tone' => 'indigo'],
                ['label' => 'Pending', 'value' => CompanyEventPublishRequest::where('status', 'pending')->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => CompanyEventPublishRequest::where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => CompanyEventPublishRequest::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ],
            'columns' => ['Event', 'Company', 'Status', 'Submitted'],
            'rows' => $rows,
        ]);
    }

    private function badge(?string $value): string
    {
        $value = $value ?: 'unknown';
        $tone = match ($value) {
            'approved', 'published' => 'green',
            'pending' => 'amber',
            'rejected' => 'rose',
            default => 'slate',
        };

        $class = match ($tone) {
            'green' => 'bg-green-50 text-green-700',
            'amber' => 'bg-amber-50 text-amber-700',
            'rose' => 'bg-rose-50 text-rose-700',
            default => 'bg-slate-100 text-slate-700',
        };

        return '<span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold ' . $class . '">' . e(ucfirst($value)) . '</span>';
    }

    public function show(CompanyEventPublishRequest $publishRequest): View
    {
        return view('admin.event-approvals.show', [
            'publishRequest' => $publishRequest->load(['company', 'companyEvent.branding', 'companyEvent.ticketTypes']),
        ]);
    }

    public function preview(): RedirectResponse
    {
        $publishRequest = CompanyEventPublishRequest::query()
            ->where('status', 'pending')
            ->latest()
            ->first()
            ?? CompanyEventPublishRequest::query()->latest()->first();

        if ($publishRequest) {
            return redirect()->route('admin.event-approvals.show', $publishRequest);
        }

        return redirect()
            ->route('admin.event-approvals.index')
            ->with('status', 'No event approval requests available to review yet.');
    }

    public function approve(CompanyEventPublishRequest $publishRequest): RedirectResponse
    {
        if ($publishRequest->status !== 'pending') {
            return back()->withErrors(['approve' => 'This request has already been reviewed.']);
        }

        $publishRequest->update([
            'status' => 'approved',
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
        ]);

        $publishRequest->companyEvent?->update([
            'status' => 'published',
            'publish_status' => 'published',
            'visibility' => 'public',
            'published_at' => now(),
        ]);

        AdminAudit::log('event_publish_approved', 'event-approvals', 'company_event_publish_request', $publishRequest->id);

        return back()->with('status', 'Event approved and published for visitors.');
    }

    public function publish(CompanyEventPublishRequest $publishRequest): RedirectResponse
    {
        if ($publishRequest->status !== 'approved') {
            return back()->withErrors(['publish' => 'Event must be approved before it can be published.']);
        }

        $publishRequest->companyEvent?->update([
            'status' => 'published',
            'publish_status' => 'published',
            'visibility' => 'public',
            'published_at' => now(),
        ]);

        AdminAudit::log('event_published', 'event-approvals', 'company_event', $publishRequest->company_event_id);

        return back()->with('status', 'Event is now live for visitors.');
    }

    public function unpublish(CompanyEventPublishRequest $publishRequest): RedirectResponse
    {
        $publishRequest->companyEvent?->update([
            'status' => 'approved',
            'publish_status' => 'unpublished',
            'visibility' => 'private',
        ]);

        AdminAudit::log('event_unpublished', 'event-approvals', 'company_event', $publishRequest->company_event_id);

        return back()->with('status', 'Event has been unpublished and is no longer visible to visitors.');
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
            'publish_status' => 'unpublished',
            'visibility' => 'private',
        ]);

        AdminAudit::log('event_publish_rejected', 'event-approvals', 'company_event_publish_request', $publishRequest->id, $validated);

        return back()->with('status', 'Event rejected and returned to draft.');
    }
}
