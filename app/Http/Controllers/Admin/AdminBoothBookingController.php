<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use App\Models\Booth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminBoothBookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        
        $query = BoothBooking::with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid');
            
        if ($status === 'pending') {
            $query->where('admin_status', 'pending');
        } elseif ($status === 'approved') {
            $query->where('admin_status', 'approved');
        } elseif ($status === 'rejected') {
            $query->where('admin_status', 'rejected');
        }

        $bookings = $query->latest()->get();

        return view('admin.booth-bookings.index', compact('bookings', 'status'));
    }

    public function show($id): View
    {
        $booking = BoothBooking::with(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'days'])
            ->findOrFail($id);

        return view('admin.booth-bookings.show', compact('booking'));
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

        return redirect()->route('admin.booth-bookings.show', $booking->id)
            ->with('status', 'Booth booking has been rejected.');
    }
}
