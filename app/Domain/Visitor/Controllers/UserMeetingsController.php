<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Booth\Models\Booth;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserMeetingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $bookings = VisitorMeetingBooking::query()
            ->with([
                'company.boothBookings.hall',
                'company.boothBookings.booth',
                'company.boothBookings.exhibition',
                'companyMeeting',
            ])
            ->where(function ($query) use ($user) {
                $query->where('visitor_id', $user->id);

                if ($user->email) {
                    $query->orWhere('visitor_email', $user->email);
                }
            })
            ->latest()
            ->get();

        $meetings = $bookings->map(fn (VisitorMeetingBooking $booking) => $this->formatMeeting($booking))->values();
        $liveCount = $meetings->filter(fn (array $meeting) => in_array('live', $meeting['tabs'], true))->count();
        $upcomingCount = $meetings->filter(fn (array $meeting) => in_array('upcoming', $meeting['tabs'], true))->count();
        $completedCount = $meetings->filter(fn (array $meeting) => in_array('completed', $meeting['tabs'], true))->count();

        return view('frontend.user.meetings.index', [
            'user' => $user,
            'meetings' => $meetings,
            'totalCount' => $meetings->count(),
            'liveCount' => $liveCount,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
        ]);
    }

    public function requestJoin(int $id): RedirectResponse
    {
        $user = auth()->user();

        $meeting = VisitorMeetingBooking::query()
            ->with(['companyMeeting', 'company'])
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('visitor_id', $user->id);
                if ($user->email) {
                    $query->orWhere('visitor_email', $user->email);
                }
            })
            ->firstOrFail();

        $joinUrl = $meeting->companyMeeting?->zoom_join_url ?: $meeting->companyMeeting?->meeting_link;
        $topic = $meeting->meeting_topic ?: $meeting->companyMeeting?->title ?: 'Meeting';

        if ($joinUrl && in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled'], true)) {
            return redirect()->away($joinUrl);
        }

        if ($joinUrl && in_array($meeting->status, ['pending', 'waitlisted'], true)) {
            $meeting->update(['status' => 'confirmed']);
            $meeting->companyMeeting?->update(['status' => 'confirmed']);

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $user->id,
                'company_id' => $meeting->company_id,
                'visitor_meeting_booking_id' => $meeting->id,
                'booth_session_id' => $meeting->booth_session_id,
                'type' => 'confirmed',
                'title' => 'Meeting Accepted',
                'message' => 'Your meeting "' . $topic . '" is ready. Join here: ' . $joinUrl,
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->away($joinUrl);
        }

        DB::table('meeting_notifications')->insert([
            'visitor_id' => $user->id,
            'company_id' => $meeting->company_id,
            'visitor_meeting_booking_id' => $meeting->id,
            'booth_session_id' => $meeting->booth_session_id,
            'type' => 'join_request',
            'title' => 'Visitor ready to join',
            'message' => ($user->name ?: $meeting->visitor_name) . ' requested to join "' . $topic . '".',
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Join request sent to the host. You will be notified when the meeting link is ready.');
    }

    /** @return array<string, mixed> */
    private function formatMeeting(VisitorMeetingBooking $booking): array
    {
        $company = $booking->company;
        $companyName = $company?->company_name ?: $company?->name ?: 'Company';
        $companyMeeting = $booking->companyMeeting;
        $startsAt = $this->resolveStartTime($booking, $companyMeeting);
        $endsAt = $companyMeeting?->end_time ?: $startsAt?->copy()->addMinutes(30);
        $isLive = $startsAt && $endsAt
            && now()->between($startsAt, $endsAt)
            && in_array($booking->status, ['confirmed', 'accepted'], true);
        $isCompleted = $booking->status === 'completed';
        $isPending = in_array($booking->status, ['pending', 'waitlisted'], true);
        $isConfirmed = in_array($booking->status, ['confirmed', 'accepted'], true) && ! $isLive && ! $isCompleted;

        $tabs = ['all'];
        if ($isLive) {
            $tabs[] = 'live';
        } elseif ($isCompleted) {
            $tabs[] = 'completed';
        } elseif ($isConfirmed || $isPending) {
            $tabs[] = 'upcoming';
        }

        $joinUrl = $companyMeeting?->zoom_join_url ?: $companyMeeting?->meeting_link;

        $isConference = (bool) $booking->booth_session_id;
        $canJoinNow = $joinUrl && ($isLive || ($isConference && in_array($booking->status, ['confirmed', 'accepted'], true)));

        return [
            'id' => $booking->id,
            'company' => $companyName,
            'initials' => $this->initials($companyName),
            'booth_label' => $this->boothLabel($company?->boothBookings ?? collect()),
            'hall_name' => $this->hallName($company?->boothBookings ?? collect()),
            'schedule_label' => $this->scheduleLabel($startsAt, $isLive),
            'tabs' => $tabs,
            'is_live' => $isLive,
            'is_conference' => $isConference,
            'status_key' => $isLive ? 'live' : ($isCompleted ? 'done' : ($isPending ? 'pending' : ($isConfirmed ? 'upcoming' : 'done'))),
            'status_label' => $isLive ? 'Live now' : match ($booking->status) {
                'confirmed', 'accepted' => 'Confirmed',
                'pending', 'waitlisted' => 'Pending',
                'completed' => 'Completed',
                'cancelled', 'rejected' => 'Cancelled',
                'rescheduled' => 'Rescheduled',
                default => ucfirst($booking->status),
            },
            'join_url' => $joinUrl,
            'notes' => $booking->notes ?: $booking->message,
            'action' => $this->resolveAction($booking, $isLive, $isCompleted, $isPending, $joinUrl, $canJoinNow),
        ];
    }

    private function resolveStartTime(VisitorMeetingBooking $booking, $companyMeeting): ?Carbon
    {
        if ($companyMeeting?->start_time) {
            return $companyMeeting->start_time->copy();
        }

        if ($booking->preferred_date && $booking->preferred_time) {
            return Carbon::parse($booking->preferred_date->format('Y-m-d') . ' ' . $booking->preferred_time);
        }

        return null;
    }

    private function initials(string $name): string
    {
        return collect(explode(' ', $name))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => strtoupper(substr($word, 0, 1)))
            ->implode('');
    }

    private function boothLabel(Collection $boothBookings): string
    {
        $booking = $boothBookings->sortByDesc('id')->first();
        if (! $booking) {
            return 'Booth TBD';
        }

        $boothIds = collect($booking->selected_booth_ids ?? [])
            ->filter()
            ->when($booking->booth_id, fn (Collection $ids) => $ids->push($booking->booth_id))
            ->unique()
            ->values();

        $numbers = $boothIds->isNotEmpty()
            ? Booth::query()->whereIn('id', $boothIds)->orderBy('booth_number')->pluck('booth_number')
            : collect([optional($booking->booth)->booth_number])->filter();

        if ($numbers->isEmpty()) {
            return 'Booth TBD';
        }

        if ($numbers->count() === 1) {
            return 'Booth ' . $numbers->first();
        }

        return 'Booth ' . $numbers->first() . '–' . $numbers->last();
    }

    private function hallName(Collection $boothBookings): string
    {
        $hall = $boothBookings->sortByDesc('id')->first()?->hall;

        return $hall?->title ?: 'Hall';
    }

    private function scheduleLabel(?Carbon $startsAt, bool $isLive): string
    {
        if (! $startsAt) {
            return 'Time TBD';
        }

        if ($isLive) {
            return 'Started ' . $startsAt->format('g:i A');
        }

        if ($startsAt->isToday()) {
            return 'Today, ' . $startsAt->format('g:i A');
        }

        if ($startsAt->isTomorrow()) {
            return 'Tomorrow, ' . $startsAt->format('g:i A');
        }

        return $startsAt->format('M j, g:i A');
    }

  /** @return array{type:string,label:string,url:?string,outline:bool,method:?string} */
    private function resolveAction(
        VisitorMeetingBooking $booking,
        bool $isLive,
        bool $isCompleted,
        bool $isPending,
        ?string $joinUrl,
        bool $canJoinNow = false
    ): array {
        if ($canJoinNow && $joinUrl) {
            return ['type' => 'join', 'label' => 'Join now', 'url' => $joinUrl, 'outline' => false, 'method' => null];
        }

        if ($isLive && $joinUrl) {
            return ['type' => 'join', 'label' => 'Join now', 'url' => $joinUrl, 'outline' => false, 'method' => null];
        }

        if ($isCompleted) {
            return ['type' => 'notes', 'label' => 'View notes', 'url' => null, 'outline' => true, 'method' => null];
        }

        if ($isPending || in_array($booking->status, ['waitlisted'], true)) {
            return [
                'type' => 'request',
                'label' => $booking->booth_session_id ? 'Request to join' : 'Send request',
                'url' => route('frontend.user.meetings.join', $booking->id),
                'outline' => false,
                'method' => 'POST',
            ];
        }

        if ($joinUrl) {
            return ['type' => 'join', 'label' => 'Join meeting', 'url' => $joinUrl, 'outline' => false, 'method' => null];
        }

        return ['type' => 'reschedule', 'label' => 'Reschedule', 'url' => null, 'outline' => true, 'method' => null];
    }
}
