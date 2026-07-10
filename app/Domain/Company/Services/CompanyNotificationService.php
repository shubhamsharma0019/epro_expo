<?php

namespace App\Domain\Company\Services;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CompanyNotificationService
{
    public function forCompany(Company $company): Collection
    {
        return $this->build($company)
            ->filter(fn (array $notification) => ! empty($notification['time']))
            ->sortByDesc('time')
            ->values();
    }

    public function unreadCount(?Company $company): int
    {
        if (! $company) {
            return 0;
        }

        $seenAt = $this->seenAt();

        return $this->forCompany($company)
            ->filter(function (array $notification) use ($seenAt) {
                if (! $seenAt) {
                    return true;
                }

                $time = $notification['time'];

                return $time instanceof Carbon && $time->gt($seenAt);
            })
            ->count();
    }

    public function markAsSeen(Company $company): void
    {
        session([
            'company_notifications_seen_at' => now()->toDateTimeString(),
        ]);

        session()->save();
    }

    private function seenAt(): ?Carbon
    {
        $value = session('company_notifications_seen_at');

        if ($value instanceof Carbon) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            return Carbon::parse($value);
        }

        return null;
    }

    private function build(Company $company): Collection
    {
        $enquiries = $company->enquiries()
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($enquiry) => [
                'title' => 'New enquiry received',
                'message' => ($enquiry->name ?: $enquiry->email) . ' sent an enquiry.',
                'time' => $enquiry->created_at,
                'icon' => 'ph ph-envelope-simple',
            ]);

        $meetings = $company->visitorMeetingBookings()
            ->whereNull('booth_session_id')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($meeting) => [
                'title' => 'Meeting request received',
                'message' => ($meeting->visitor_name ?: $meeting->visitor_email) . ' requested a meeting.',
                'time' => $meeting->created_at,
                'icon' => 'ph ph-calendar-check',
            ]);

        $joinRequests = DB::table('meeting_notifications')
            ->where('company_id', $company->id)
            ->where('type', 'join_request')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($notification) => [
                'title' => $notification->title ?: 'Visitor ready to join',
                'message' => $notification->message,
                'time' => Carbon::parse($notification->created_at),
                'icon' => 'ph ph-user-plus',
            ]);

        $bookings = $company->boothBookings()
            ->with(['exhibition', 'booth'])
            ->latest()
            ->take(15)
            ->get()
            ->map(fn (BoothBooking $booking) => $this->boothBookingNotification($booking))
            ->filter();

        return $enquiries->concat($meetings)->concat($joinRequests)->concat($bookings);
    }

    private function boothBookingNotification(BoothBooking $booking): ?array
    {
        $exhibitionName = $booking->exhibition?->title ?: 'your exhibition';
        $boothLabel = $booking->booth ? 'Booth ' . $booking->booth->booth_number : 'Your booth';
        $time = $booking->paid_at ?? $booking->updated_at ?? $booking->created_at;

        if (($booking->admin_status === 'rejected') || ($booking->booking_status === 'cancelled')) {
            return [
                'title' => 'Booth booking cancelled',
                'message' => $boothLabel . ' for ' . $exhibitionName . ' was cancelled or rejected.',
                'time' => $time,
                'icon' => 'ph ph-x-circle',
            ];
        }

        if ($booking->admin_status === 'approved') {
            return [
                'title' => 'Booth booking approved',
                'message' => $boothLabel . ' for ' . $exhibitionName . ' has been approved. You can start your booth setup.',
                'time' => $time,
                'icon' => 'ph ph-seal-check',
            ];
        }

        if ($booking->payment_status === 'paid' && in_array($booking->booking_status, ['confirmed', 'active'], true)) {
            return [
                'title' => 'Booth booking pending approval',
                'message' => $boothLabel . ' for ' . $exhibitionName . ' is awaiting organizer approval.',
                'time' => $time,
                'icon' => 'ph ph-hourglass-medium',
            ];
        }

        if ($booking->booking_status === 'draft') {
            return [
                'title' => 'Incomplete booth booking',
                'message' => 'Finish booking ' . $boothLabel . ' for ' . $exhibitionName . ' to confirm your space.',
                'time' => $time,
                'icon' => 'ph ph-warning-circle',
            ];
        }

        return null;
    }
}
