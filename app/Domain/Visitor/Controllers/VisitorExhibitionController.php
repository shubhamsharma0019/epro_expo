<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Services\BoothSessionConferenceService;
use App\Domain\Event\Models\Exhibition;
use App\Support\LiveContent;
use App\Support\LegacyVisitorExhibitionRedirect;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Domain\Visitor\Models\Visitor;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Event\Models\Announcement;
use App\Domain\Visitor\Models\Bookmark;
use App\Domain\Booth\Models\BoothCatalogue;
use App\Domain\Visitor\Models\VisitorBoothMessage;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use App\Domain\Visitor\Services\SessionRegistrationMeetingService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class VisitorExhibitionController extends Controller
{
    private function resolveExhibition(string $slug): ?Exhibition
    {
        return LiveContent::exhibitionQuery()->where('slug', $slug)->first()
            ?: Exhibition::where('slug', $slug)->first();
    }

    private function resolveVisitor(?Exhibition $exhibition): ?Visitor
    {
        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');

        if ($bookingId) {
            $visitor = Visitor::query()
                ->when($exhibition, fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('booking_id', $bookingId)
                ->first();

            if ($visitor) {
                return $visitor;
            }
        }

        if (auth()->check() && $exhibition) {
            return Visitor::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('email', auth()->user()->email)
                ->latest()
                ->first();
        }

        return null;
    }

    private function resolveBookmarkedBoothIds(?Visitor $visitor): Collection
    {
        if (! $visitor?->booking_id) {
            return collect((array) session('saved_booths', []))->filter()->values();
        }

        return Bookmark::query()
            ->where('booking_id', $visitor->booking_id)
            ->get()
            ->map(function (Bookmark $bookmark) {
                $target = (string) $bookmark->bookmarkable_id;

                if (str_starts_with($target, 'booking-')) {
                    return (int) str_replace('booking-', '', $target);
                }

                return is_numeric($target) ? (int) $target : null;
            })
            ->filter()
            ->unique()
            ->values();
    }

    private function buildVisitorNotifications(?Exhibition $exhibition, ?Visitor $visitor): Collection
    {
        if (! $exhibition) {
            return collect();
        }

        $items = Announcement::query()
            ->where('exhibition_id', $exhibition->id)
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Announcement $announcement) => [
                'title' => $announcement->title,
                'copy' => $announcement->content,
                'time' => $announcement->created_at?->diffForHumans() ?? '',
            ]);

        if ($visitor?->email || auth()->check()) {
            $meetingNotifications = \Illuminate\Support\Facades\DB::table('meeting_notifications')
                ->where(function ($query) use ($visitor) {
                    if (auth()->check()) {
                        $query->where('visitor_id', auth()->id());
                    }
                    if ($visitor?->email) {
                        $query->orWhereIn('visitor_meeting_booking_id', function ($sub) use ($visitor) {
                            $sub->select('id')->from('visitor_meeting_bookings')->where('visitor_email', $visitor->email);
                        });
                    }
                })
                ->latest()
                ->take(6)
                ->get()
                ->map(fn ($notif) => [
                    'title' => $notif->title,
                    'copy' => $notif->message,
                    'time' => \Carbon\Carbon::parse($notif->created_at)->diffForHumans() ?? '',
                ]);

            $items = $meetingNotifications->concat($items);
        }

        $catalogueItems = BoothCatalogue::query()
            ->whereHas('boothBooking', fn (Builder $query) => $query
                ->where('exhibition_id', $exhibition->id)
                ->publiclyVisible())
            ->where('visibility', 'public')
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (BoothCatalogue $catalogue) => [
                'title' => 'Brochure available',
                'copy' => ($catalogue->title ?: 'A new catalogue') . ' was published for visitors.',
                'time' => $catalogue->created_at?->diffForHumans() ?? '',
            ]);

        return $items->concat($catalogueItems)->take(12)->values();
    }

    private function companySlugForBooking(BoothBooking $booking): string
    {
        return Str::slug($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?: '');
    }
    private function isPassActive(string $slug = null): bool
    {
        if (session('visitor_pass_active', false)) {
            return true;
        }

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        if ($bookingId) {
            $exhibition = Exhibition::where('slug', $slug)->first();
            $exists = Visitor::where('booking_id', $bookingId)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->where('payment_status', 'completed')
                ->exists();
            if ($exists) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $bookingId]);
                return true;
            }
        }

        if (auth()->check()) {
            $userEmail = auth()->user()->email;
            $exhibition = Exhibition::where('slug', $slug)->first();
            
            $visitor = Visitor::where('email', $userEmail)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->where('payment_status', 'completed')
                ->first();
                
            if ($visitor) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $visitor->booking_id]);
                return true;
            }
        }

        return false;
    }

    private function prepareLobbyViewData(?Exhibition $exhibition, Collection $liveBooths, string $slug, bool $isPassActive): array
    {
        $visitor = $this->resolveVisitor($exhibition);
        $passActive = $visitor ? $visitor->payment_status === 'completed' : $isPassActive;
        $passName = $visitor?->pass_type ?: 'Free Visitor Pass';

        $exhibitionName = $exhibition ? ($exhibition->title ?: $exhibition->name) : 'Exhibition Lobby';
        $exhibitionDesc = $exhibition?->description
            ?: 'Start here, then move through companies, halls, booth pages, sessions and your QR visitor pass.';

        $bannerImage = asset('images/exhibitions/hero-pavilion-scene.png');
        if ($exhibition) {
            $publishedBookings = ($exhibition->boothBookings ?? collect())->filter(
                fn ($booking) => in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true)
            );
            $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
                ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);

            $bannerPath = $exhibition->banner_url ?: $exhibition->banner_image;
            if (! $bannerPath && $firstBooking) {
                $bannerPath = $firstBooking->boothBranding?->booth_banner
                    ?: $firstBooking->boothProfile?->company_logo
                    ?: $firstBooking->company?->logo;
            }
            if (! $bannerPath) {
                $bannerPath = 'images/exhibitions/hero-pavilion-scene.png';
            }

            if (str_starts_with($bannerPath, 'http://') || str_starts_with($bannerPath, 'https://')) {
                $bannerImage = $bannerPath;
            } elseif (str_starts_with($bannerPath, 'images/') || str_starts_with($bannerPath, 'assets/') || str_starts_with($bannerPath, 'storage/')) {
                $bannerImage = asset($bannerPath);
            } else {
                $bannerImage = asset('storage/' . $bannerPath);
            }
        }

        if ($exhibition) {
            $boothsSource = ($exhibition->boothBookings ?? collect())->isNotEmpty()
                ? $exhibition->boothBookings
                : $liveBooths;
            $boothsCount = $boothsSource->count();
            $hallsCount = $boothsSource->pluck('hall_id')->filter()->unique()->count();
            $sessionsCount = $boothsSource->sum(fn ($b) => $b->boothSessions?->count() ?? 0);
            $visitorsCount = Visitor::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->count();

            $displayBooths = (string) $boothsCount;
            $displayHalls = (string) $hallsCount;
            $displaySessions = (string) $sessionsCount;
            $displayVisitors = $exhibition->visitors_count
                ? number_format($exhibition->visitors_count) . '+'
                : number_format($visitorsCount);
        } else {
            $displayBooths = '0';
            $displayHalls = '0';
            $displaySessions = '0';
            $displayVisitors = '0';
        }

        $passAction = $passActive
            ? ['label' => 'View QR Pass', 'href' => route('exhibitions.visitor.qr-pass', $slug)]
            : ['label' => 'Register / Get Pass', 'href' => route('exhibitions.tickets.select', $slug)];

        return [
            'visitor' => $visitor,
            'isPassActive' => $passActive,
            'passName' => $passName,
            'exhibitionName' => $exhibitionName,
            'exhibitionDesc' => $exhibitionDesc,
            'bannerImage' => $bannerImage,
            'heroStats' => [
                [$displayBooths, 'Companies'],
                [$displayHalls, 'Halls'],
                [$displaySessions, 'Sessions'],
                [$displayVisitors, 'Visitors'],
            ],
            'passAction' => $passAction,
            'lobbyEssentials' => [
                ['Companies', $displayBooths . ' listed', route('exhibitions.visitor.companies', $slug), 'fa-solid fa-store'],
                ['Floor Map', $displayHalls . ' halls', route('exhibitions.visitor.floor-map', $slug), 'fa-regular fa-map'],
                ['Sessions', $displaySessions . ' scheduled', route('exhibitions.visitor.sessions', $slug), 'fa-regular fa-circle-play'],
                ['QR Pass', $passActive ? 'Ready to scan' : 'Get visitor pass', $passAction['href'], 'fa-solid fa-qrcode'],
                ['Dashboard', $passActive ? 'Pass dashboard' : 'Visitor dashboard', route('frontend.user.dashboard', ['slug' => $slug]), 'fa-solid fa-gauge'],
            ],
            'lobbyCards' => [
                ['Participating Companies', 'Browse exhibitor profiles, products, booth locations and categories.', route('exhibitions.visitor.companies', $slug)],
                ['Floor Map & Halls', 'Use the map to understand halls, booth positions and active zones.', route('exhibitions.visitor.floor-map', $slug)],
                ['Sessions & Webinars', 'Join live product demos, expert talks and exhibitor sessions.', route('exhibitions.visitor.sessions', $slug)],
                ['Featured Speakers', 'Meet our industry experts and keynote presenters.', route('exhibitions.show', $slug) . '#tab-speakers'],
                ['Event Sponsors', 'Explore our premium sponsors and corporate partners.', route('exhibitions.show', $slug) . '#tab-sponsors'],
                ['Visitor Dashboard', 'See your QR pass, meetings and notifications.', route('frontend.user.dashboard', ['slug' => $slug])],
            ],
        ];
    }

    public function lobby(string $slug): RedirectResponse
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function floorMap(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function dashboard(string $slug): RedirectResponse
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $isPassActive = $this->isPassActive($slug);

        if (! $isPassActive && session('exhibition_booking_path')) {
            return redirect(session('exhibition_booking_path'));
        }

        if (! $isPassActive) {
            return redirect()->route('exhibitions.tickets.select', $slug);
        }

        session(['activeExhibitionSlug' => $slug]);

        return LegacyVisitorExhibitionRedirect::dashboard($slug);
    }

    public function myPasses(string $slug)
    {
        return redirect()->route('frontend.user.passes');
    }

    public function savedBooths(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::dashboard($slug);
    }

    private function resolveRegisteredSessionsCount(?Exhibition $exhibition, ?Visitor $visitor): int
    {
        if (! $exhibition) {
            return 0;
        }

        $query = VisitorSessionRegistration::query()
            ->where('exhibition_id', $exhibition->id);

        if ($visitor?->booking_id) {
            $query->where('visitor_booking_id', $visitor->booking_id);
        } elseif (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            return 0;
        }

        return $query->count();
    }

    private function resolveRegisteredSessionIds(?Exhibition $exhibition, ?Visitor $visitor): array
    {
        if (! $exhibition) {
            return [];
        }

        $query = VisitorSessionRegistration::query()
            ->where('exhibition_id', $exhibition->id);

        if ($visitor?->booking_id) {
            $query->where('visitor_booking_id', $visitor->booking_id);
        } elseif (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            return [];
        }

        return $query->pluck('booth_session_id')->all();
    }

    public function sessions(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::dashboard($slug);
    }

    public function requestSessionJoin(string $slug, int $session, BoothSessionConferenceService $conference): RedirectResponse
    {
        $exhibition = $this->resolveExhibition($slug);
        if (! $exhibition) {
            return back()->with('error', 'Exhibition not found.');
        }

        if (! auth()->check()) {
            return redirect()->route('exhibitions.tickets.visitor-details', $slug)
                ->with('error', 'Please log in to request joining a conference.');
        }

        if (! $this->isPassActive($slug)) {
            return redirect()->route('exhibitions.tickets.select', $slug)
                ->with('error', 'An active visitor pass is required to join sessions.');
        }

        $visitor = $this->resolveVisitor($exhibition);
        $boothSession = BoothSession::query()
            ->whereKey($session)
            ->whereHas('boothBooking', fn (Builder $query) => $query
                ->where('exhibition_id', $exhibition->id)
                ->publiclyVisible())
            ->firstOrFail();

        $visitorBooking = $conference->requestSessionJoin($boothSession, (int) auth()->id(), $visitor);
        $joinUrl = $visitorBooking->companyMeeting?->zoom_join_url ?: $visitorBooking->companyMeeting?->meeting_link;

        if ($joinUrl && in_array($visitorBooking->status, ['confirmed', 'accepted'], true)) {
            return redirect()->away($joinUrl);
        }

        return back()->with('success', 'Join request sent to the exhibitor. Check Notifications or My Meetings for the conference link.');
    }

    public function registerSession(Request $request, string $slug, int $session): RedirectResponse
    {
        $exhibition = $this->resolveExhibition($slug);
        if (! $exhibition) {
            return back()->with('error', 'Exhibition not found.');
        }

        if (! $this->isPassActive($slug)) {
            return redirect()->route('exhibitions.tickets.select', $slug)
                ->with('error', 'An active visitor pass is required to register for sessions.');
        }

        $visitor = $this->resolveVisitor($exhibition);
        $boothSession = BoothSession::query()
            ->whereKey($session)
            ->whereHas('boothBooking', fn (Builder $query) => $query
                ->where('exhibition_id', $exhibition->id)
                ->publiclyVisible())
            ->firstOrFail();

        $registration = VisitorSessionRegistration::firstOrCreate(
            [
                'booth_session_id' => $boothSession->id,
                'exhibition_id' => $exhibition->id,
                'visitor_booking_id' => $visitor?->booking_id,
                'user_id' => auth()->id(),
            ],
            [
                'visitor_email' => $visitor?->email ?: auth()->user()?->email,
                'status' => 'registered',
            ]
        );

        app(SessionRegistrationMeetingService::class)->syncFromRegistration(
            $registration,
            $boothSession,
            $visitor
        );

        return back()->with('success', 'Session registration saved.');
    }

    public function notifications(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::dashboard($slug);
    }

    public function chat(string $slug, string $companySlug = null): RedirectResponse
    {
        if ($companySlug) {
            return LegacyVisitorExhibitionRedirect::boothShow($slug, $companySlug);
        }

        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function sendChatMessage(Request $request, string $slug, string $companySlug): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $exhibition = $this->resolveExhibition($slug);
        if (! $exhibition) {
            return back()->with('error', 'Exhibition not found.');
        }

        $booking = BoothBooking::query()
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->publiclyVisible()
            ->get()
            ->first(fn (BoothBooking $item) => $this->companySlugForBooking($item) === $companySlug);

        if (! $booking?->company_id) {
            return back()->with('error', 'Company not found.');
        }

        $visitor = $this->resolveVisitor($exhibition);

        VisitorBoothMessage::create([
            'exhibition_id' => $exhibition->id,
            'company_id' => $booking->company_id,
            'visitor_booking_id' => $visitor?->booking_id,
            'user_id' => auth()->id(),
            'sender_type' => 'visitor',
            'sender_name' => $visitor?->first_name ?: (auth()->user()->name ?? 'Visitor'),
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message sent.');
    }

    public function hallsIndex(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function hallsShow(string $slug, string $hallSlug): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.exhibitions.halls.show', [
                'slug' => $slug,
                'hallSlug' => $hallSlug,
            ]);
        }

        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function pavilionsIndex(string $slug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::halls($slug);
    }

    public function pavilionsShow(string $slug, string $pavilionSlug): RedirectResponse
    {
        return LegacyVisitorExhibitionRedirect::halls($slug);
    }
}
