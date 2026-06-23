<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoothApprovalController extends Controller
{
    public function index(): View
    {
        $rows = BoothPublishRequest::query()
            ->with(['boothBooking.company', 'boothBooking.booth', 'boothBooking.exhibition'])
            ->latest()
            ->paginate(12)
            ->through(function (BoothPublishRequest $request) {
                $booking = $request->boothBooking;

                return [
                    'url' => route('admin.booth-approvals.show', $request),
                    'cells' => [
                        $booking?->company?->company_name ?? 'Company',
                        $booking?->booth?->booth_number ?? 'Booth',
                        $booking?->exhibition?->title ?? ($booking?->exhibition?->name ?? 'Exhibition'),
                        $this->badge($request->status),
                        $request->created_at?->format('M d, Y') ?? 'N/A',
                    ],
                    'actions' => $request->status === 'pending'
                        ? [
                            [
                                'label' => 'Approve',
                                'href' => route('admin.booth-approvals.approve', $request),
                                'method' => 'POST',
                                'variant' => 'success',
                            ],
                            [
                                'label' => 'Reject',
                                'href' => route('admin.booth-approvals.reject', $request),
                                'method' => 'POST',
                                'variant' => 'danger',
                            ],
                        ]
                        : [[
                            'label' => 'Review',
                            'href' => route('admin.booth-approvals.show', $request),
                        ]],
                ];
            });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Booth Setup Review',
            'pageDescription' => 'Review exhibitor booth setup submissions before publishing.',
            'search' => '',
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Requests', 'value' => BoothPublishRequest::count(), 'tone' => 'indigo'],
                ['label' => 'Pending', 'value' => BoothPublishRequest::where('status', 'pending')->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => BoothPublishRequest::where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => BoothPublishRequest::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [],
            'columns' => ['Company', 'Booth', 'Exhibition', 'Status', 'Submitted'],
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

    public function show(BoothPublishRequest $publishRequest): View
    {
        return view('backend.admin.booth-approvals.show', [
            'publishRequest' => $publishRequest->load(['boothBooking.company', 'boothBooking.booth']),
        ]);
    }

    public function preview(): RedirectResponse
    {
        $publishRequest = BoothPublishRequest::query()
            ->where('status', 'pending')
            ->latest()
            ->first()
            ?? BoothPublishRequest::query()->latest()->first();

        if ($publishRequest) {
            return redirect()->route('admin.booth-approvals.show', $publishRequest);
        }

        return redirect()
            ->route('admin.booth-approvals.index')
            ->with('status', 'No booth setup requests available to review yet.');
    }

    public function approve(BoothPublishRequest $publishRequest): RedirectResponse
    {
        $publishRequest->update(['status' => 'approved', 'reviewed_by' => session('admin_id'), 'reviewed_at' => now()]);
        $publishRequest->boothBooking?->update(['booth_setup_status' => 'published']);

        AdminAudit::log('booth_publish_approved', 'booth-approvals', 'booth_publish_request', $publishRequest->id);

        return back()->with('status', 'Booth approved and marked published.');
    }

    public function reject(Request $request, BoothPublishRequest $publishRequest): RedirectResponse
    {
        $validated = $request->validate(['rejection_reason' => ['required', 'string']]);
        $publishRequest->update(['status' => 'rejected', 'reviewed_by' => session('admin_id'), 'reviewed_at' => now(), 'rejection_reason' => $validated['rejection_reason']]);
        $publishRequest->boothBooking?->update(['booth_setup_status' => 'rejected']);

        AdminAudit::log('booth_publish_rejected', 'booth-approvals', 'booth_publish_request', $publishRequest->id, $validated);

        return back()->with('status', 'Booth rejected.');
    }
}
