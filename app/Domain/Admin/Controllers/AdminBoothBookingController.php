<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\Booth;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminBoothBookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = BoothBooking::query()
            ->with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid')
            ->when($status === 'pending', fn ($builder) => $builder->where('admin_status', 'pending'))
            ->when($status === 'approved', fn ($builder) => $builder->where('admin_status', 'approved'))
            ->when($status === 'rejected', fn ($builder) => $builder->where('admin_status', 'rejected'))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->whereHas('company', function ($builder) use ($search) {
                    $builder->where('company_name', 'like', '%' . $search . '%');
                });
            })
            ->latest();

        $rows = $query->paginate(12)->through(function (BoothBooking $booking) {
            return [
                'cells' => [
                    $booking->company?->company_name ?? 'Company',
                    $booking->exhibition?->title ?? ($booking->exhibition?->name ?? 'Exhibition'),
                    $booking->booth?->booth_number ?? 'Booth',
                    $this->badge($booking->admin_status),
                    $this->money($booking->total_amount),
                    $booking->created_at?->format('M d, Y') ?? 'N/A',
                ],
                'actions' => array_filter([
                    [
                        'label' => 'View',
                        'href' => route('admin.booth-bookings.show', $booking->id),
                    ],
                    $booking->admin_status === 'pending'
                        ? [
                            'label' => 'Approve',
                            'href' => route('admin.booth-bookings.approve', $booking->id),
                            'method' => 'POST',
                            'variant' => 'success',
                        ]
                        : null,
                    $booking->admin_status === 'pending'
                        ? [
                            'label' => 'Reject',
                            'href' => route('admin.booth-bookings.reject', $booking->id),
                            'method' => 'POST',
                            'variant' => 'danger',
                        ]
                        : null,
                ]),
            ];
        });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Booth Management',
            'pageDescription' => 'Manage paid booth bookings and admin approval status.',
            'search' => $search,
            'status' => $status,
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Paid Bookings', 'value' => BoothBooking::where('payment_status', 'paid')->count(), 'tone' => 'indigo'],
                ['label' => 'Pending Approval', 'value' => BoothBooking::where('payment_status', 'paid')->where('admin_status', 'pending')->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => BoothBooking::where('payment_status', 'paid')->where('admin_status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => BoothBooking::where('payment_status', 'paid')->where('admin_status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ],
            'columns' => ['Company', 'Exhibition', 'Booth', 'Admin Status', 'Amount', 'Booked On'],
            'rows' => $rows,
        ]);
    }

    private function badge(?string $value): string
    {
        $value = $value ?: 'unknown';
        $class = match ($value) {
            'approved' => 'bg-green-50 text-green-700',
            'rejected' => 'bg-rose-50 text-rose-700',
            'pending' => 'bg-amber-50 text-amber-700',
            default => 'bg-slate-100 text-slate-700',
        };

        return '<span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold ' . $class . '">' . e(ucfirst($value)) . '</span>';
    }

    private function money(float|int|string|null $value): string
    {
        return 'Rs. ' . number_format((float) $value, 2);
    }

    public function show($id): View
    {
        $booking = BoothBooking::with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'days'])
            ->findOrFail($id);

        return view('backend.admin.booth-bookings.show', compact('booking'));
    }

    public function approve($id): RedirectResponse
    {
        $booking = BoothBooking::findOrFail($id);
        
        DB::transaction(function () use ($booking) {
            $booking->update([
                'admin_status' => 'approved',
                'approved_by' => session('admin_id') ?? 1,
                'approved_at' => now(),
            ]);

            // Ensure booths are marked as booked
            $selectedBoothIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                ->push($booking->booth_id)
                ->filter()
                ->unique()
                ->values();

            Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'booked']);
        });

        AdminAudit::log('booth_booking_approved', 'booth-bookings', 'booth_booking', $booking->id);

        return redirect()->route('admin.booth-bookings.show', $booking->id)
            ->with('status', 'Booth booking has been approved successfully.');
    }

    public function reject(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $booking = BoothBooking::findOrFail($id);

        DB::transaction(function () use ($booking, $validated) {
            $booking->update([
                'admin_status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
                'approved_by' => session('admin_id') ?? 1,
                'approved_at' => now(),
            ]);

            // Release the booths back to available
            $selectedBoothIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                ->push($booking->booth_id)
                ->filter()
                ->unique()
                ->values();

            Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'available']);
        });

        AdminAudit::log('booth_booking_rejected', 'booth-bookings', 'booth_booking', $booking->id, $validated);

        return redirect()->route('admin.booth-bookings.show', $booking->id)
            ->with('status', 'Booth booking has been rejected.');
    }
}
