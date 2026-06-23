<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothView;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserPortalController extends Controller
{
    public function profile(): View
    {
        $user = auth()->user();
        $passCount = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->where('payment_status', 'completed')
            ->count();

        $eventTicketCount = \App\Domain\Visitor\Models\VisitorTicket::where('user_id', $user->id)->count();

        return view('frontend.user.profile', [
            'user' => $user,
            'passCount' => $passCount,
            'eventTicketCount' => $eventTicketCount,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function visits(): View
    {
        $user = auth()->user();
        $items = $this->buildVisitItems($user);

        return view('frontend.user.visits.index', [
            'title' => 'Visit History',
            'variant' => 'visit',
            'eyebrow' => 'Visitor Timeline',
            'description' => 'Review exhibitions, halls, booths, and companies you visited recently.',
            'icon' => 'fa-regular fa-clock',
            'items' => $items,
        ]);
    }

    public function visitShow(int $id): View
    {
        $user = auth()->user();
        $pass = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->with('exhibition')
            ->findOrFail($id);

        $exhibition = $pass->exhibition;
        $sessionsCount = VisitorSessionRegistration::query()
            ->where('visitor_booking_id', $pass->booking_id)
            ->count();
        $meetingsCount = VisitorMeetingBooking::query()
            ->where('visitor_email', $user->email)
            ->when($exhibition, fn ($query) => $query->whereHas('company.boothBookings', fn ($q) => $q->where('exhibition_id', $exhibition->id)))
            ->count();
        $boothViewsCount = BoothView::query()->where('visitor_id', $user->id)->count();

        $title = $exhibition->title ?? $exhibition->name ?? 'Exhibition Visit';

        return view('frontend.user.visits.show', [
            'pass' => $pass,
            'exhibition' => $exhibition,
            'title' => $title,
            'sessionsCount' => $sessionsCount,
            'meetingsCount' => $meetingsCount,
            'boothViewsCount' => $boothViewsCount,
        ]);
    }

    public function savedExhibitions(): View
    {
        $user = auth()->user();
        $passes = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->where('payment_status', 'completed')
            ->with('exhibition')
            ->latest()
            ->get();

        $items = $passes->map(function (Visitor $pass) {
            $exhibition = $pass->exhibition;
            $name = $exhibition->title ?? $exhibition->name ?? 'Exhibition';
            $meta = collect([
                $exhibition?->city,
                $pass->booking_id,
                $exhibition?->start_date?->format('M d, Y'),
            ])->filter()->join(' | ');

            return [
                $name,
                $meta ?: 'Registered pass',
                'Saved',
                $exhibition?->slug ? route('exhibitions.visit', $exhibition->slug) : route('frontend.user.tickets.index'),
            ];
        })->values()->all();

        return view('frontend.user.saved.exhibitions', [
            'title' => 'Saved Exhibitions',
            'eyebrow' => 'Your exhibitions',
            'description' => 'Exhibitions where you hold an active or registered visitor pass.',
            'icon' => 'fa-regular fa-bookmark',
            'items' => $items,
        ]);
    }

    public function visitedBooths(): View
    {
        $user = auth()->user();
        $views = BoothView::query()
            ->with(['company.boothBookings.exhibition', 'boothProfile'])
            ->where('visitor_id', $user->id)
            ->latest('viewed_at')
            ->take(50)
            ->get();

        $items = $views->map(function (BoothView $view) {
            $companyName = $view->boothProfile?->company_name
                ?: $view->company?->company_name
                ?: $view->company?->name
                ?: 'Company';
            $booking = $view->company?->boothBookings?->first();
            $slug = $booking?->exhibition?->slug ?? session('activeExhibitionSlug');
            $companySlug = Str::slug($companyName);
            $meta = $view->viewed_at?->format('M d, Y g:i A') ?? 'Recently viewed';
            $href = $slug
                ? route('exhibitions.visitor.companies.show', [$slug, $companySlug])
                : route('frontend.user.dashboard');

            return [$companyName, $meta, 'Visited', $href];
        })->unique(fn ($item) => $item[0])->values()->all();

        return view('frontend.user.booths.visited', [
            'title' => 'Visited Booths',
            'variant' => 'cards',
            'eyebrow' => 'Booth activity',
            'description' => 'Companies and booths you recently explored during exhibitions.',
            'icon' => 'fa-solid fa-store',
            'items' => $items,
        ]);
    }

    private function buildVisitItems($user): array
    {
        $passes = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->with('exhibition')
            ->latest()
            ->get();

        return $passes->map(function (Visitor $pass) {
            $exhibition = $pass->exhibition;
            $name = ($exhibition->title ?? $exhibition->name ?? 'Exhibition') . ' Visit';
            $date = $exhibition?->start_date?->format('M d, Y') ?? $pass->created_at?->format('M d, Y') ?? 'Date TBD';
            $status = $pass->payment_status === 'completed' ? 'Completed' : ucfirst($pass->payment_status);

            return [$name, $date . ' | Pass ' . $pass->booking_id, $status, route('frontend.user.visits.show', $pass->id)];
        })->values()->all();
    }
}
