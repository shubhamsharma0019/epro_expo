<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Event\Models\Exhibition;
use App\Support\LiveContent;
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
                ['Dashboard', $passActive ? 'Pass dashboard' : 'Visitor dashboard', route('exhibitions.visitor.dashboard', $slug), 'fa-solid fa-gauge'],
            ],
            'lobbyCards' => [
                ['Participating Companies', 'Browse exhibitor profiles, products, booth locations and categories.', route('exhibitions.visitor.companies', $slug)],
                ['Floor Map & Halls', 'Use the map to understand halls, booth positions and active zones.', route('exhibitions.visitor.floor-map', $slug)],
                ['Sessions & Webinars', 'Join live product demos, expert talks and exhibitor sessions.', route('exhibitions.visitor.sessions', $slug)],
                ['Featured Speakers', 'Meet our industry experts and keynote presenters.', route('exhibitions.show', $slug) . '#tab-speakers'],
                ['Event Sponsors', 'Explore our premium sponsors and corporate partners.', route('exhibitions.show', $slug) . '#tab-sponsors'],
                ['Visitor Dashboard', 'See your QR pass, meetings and notifications.', route('exhibitions.visitor.dashboard', $slug)],
            ],
        ];
    }

    public function lobby(string $slug): View
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $exhibition = LiveContent::exhibitionQuery()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved'),
                'boothBookings.boothSessions',
                'boothBookings.hall',
                'boothBookings.booth'
            ])
            ->where('slug', $slug)
            ->first()
            ?: Exhibition::with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions', 'hall', 'booth'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved'),
            ])->where('slug', $slug)->first();

        $liveBooths = BoothBooking::query()
            ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile', 'boothSessions'])
            ->withCount([
                'boothProducts as published_products_count' => fn (Builder $query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn (Builder $query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->take(6)
            ->get()
            ->filter(fn (BoothBooking $booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
            ->values();

        $isPassActive = $this->isPassActive($slug);

        return view('frontend.visitor-exhibition.lobby.index', array_merge(
            [
                'slug' => $slug,
                'liveBooths' => $liveBooths,
                'exhibition' => $exhibition,
            ],
            $this->prepareLobbyViewData($exhibition, $liveBooths, $slug, $isPassActive)
        ));
    }

    public function floorMap(string $slug): View
    {
        $exhibition = Exhibition::where('slug', $slug)->firstOrFail();

        // Fetch active pavilions with active halls loaded for the dropdown
        $pavilions = Pavilion::with(['halls' => function($q) {
                $q->where('status', 'active');
            }])
            ->where('exhibition_id', $exhibition->id)
            ->where('status', 'active')
            ->get();

        // Get selected hall
        $hallId = request()->query('hall');
        $hall = null;
        if ($hallId) {
            $hall = Hall::with(['booths.boothSize', 'pavilion.exhibition'])
                ->where('status', 'active')
                ->find($hallId);
        }

        // Fallback to first hall of first pavilion if no hall matches or is passed
        if (!$hall) {
            $firstPavilion = $pavilions->first();
            if ($firstPavilion) {
                $hall = $firstPavilion->halls->first();
                if ($hall) {
                    $hall->loadMissing(['booths.boothSize', 'pavilion.exhibition']);
                }
            }
        }

        $isPassActive = $this->isPassActive($slug);

        return view('frontend.visitor-exhibition.halls.floor-plan', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'exhibition' => $exhibition,
            'pavilions' => $pavilions,
            'hall' => $hall,
        ]);
    }

    public function dashboard(string $slug): View|RedirectResponse
    {
        if (request()->has('booking_id')) {
            session(['selected_visitor_booking_id' => request()->query('booking_id')]);
        }

        $exhibition = $this->resolveExhibition($slug);
        $visitor = $this->resolveVisitor($exhibition);
        $isPassActive = $this->isPassActive($slug);

        if (! $isPassActive && session('exhibition_booking_path')) {
            return redirect(session('exhibition_booking_path'));
        }

        if (! $isPassActive) {
            return redirect()->route('exhibitions.tickets.select', $slug);
        }

        $meetingsCount = 0;
        if (auth()->check() || $visitor?->email) {
            $meetingsCount = VisitorMeetingBooking::query()
                ->when($exhibition, fn ($query) => $query->whereHas('company.boothBookings', fn ($bookingQuery) => $bookingQuery->where('exhibition_id', $exhibition->id)))
                ->where(function ($query) use ($visitor) {
                    if (auth()->check()) {
                        $query->where('visitor_id', auth()->id());
                    }
                    if ($visitor?->email) {
                        auth()->check()
                            ? $query->orWhere('visitor_email', $visitor->email)
                            : $query->where('visitor_email', $visitor->email);
                    }
                })
                ->count();
        }

        $sessionsJoinedCount = $this->resolveRegisteredSessionsCount($exhibition, $visitor);

        $recommendedCompanies = collect();
        if ($exhibition) {
            $recommendedCompanies = BoothBooking::query()
                ->with(['company', 'boothProfile', 'hall', 'booth'])
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
                ->latest()
                ->take(2)
                ->get()
                ->map(function ($booking, $index) {
                    $companyName = $booking->boothProfile?->company_name
                        ?: $booking->company?->company_name
                        ?: $booking->company?->name
                        ?: 'Company';
                    $hallName = $booking->hall?->name ?: 'Hall TBD';
                    $boothNumber = $booking->booth?->booth_number ?: $booking->booth_id;

                    return [
                        'company' => $companyName,
                        'location' => trim($hallName . ($boothNumber ? ' - Booth ' . $boothNumber : '')),
                        'meta' => $booking->boothSessions?->first()?->title ?: 'Explore booth details and sessions',
                        'status' => $index === 0 ? 'Featured' : 'Open',
                    ];
                });
        }

        $todaySessions = collect();
        if ($exhibition) {
            $todaySessions = BoothSession::query()
                ->whereIn('status', ['live', 'upcoming', 'completed'])
                ->whereHas('boothBooking', function (Builder $query) use ($exhibition) {
                    $query
                        ->where('exhibition_id', $exhibition->id)
                        ->publiclyVisible();
                })
                ->orderBy('session_date')
                ->orderBy('start_time')
                ->take(3)
                ->get()
                ->map(fn ($session) => [
                    'time' => $session->start_time
                        ? \Illuminate\Support\Carbon::parse($session->start_time)->format('h:i A')
                        : 'TBD',
                    'title' => $session->title,
                ]);
        }

        $notifications = $this->buildVisitorNotifications($exhibition, $visitor);
        $unreadNotificationsCount = $notifications->count();

        return view('frontend.visitor-exhibition.visitor-dashboard.index', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'exhibition' => $exhibition,
            'visitor' => $visitor,
            'meetingsCount' => $meetingsCount,
            'sessionsJoinedCount' => $sessionsJoinedCount,
            'recommendedCompanies' => $recommendedCompanies,
            'todaySessions' => $todaySessions,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    public function myPasses(string $slug)
    {
        return redirect()->route('frontend.user.tickets.index');
    }

    public function savedBooths(string $slug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = $this->resolveExhibition($slug);
        $visitor = $this->resolveVisitor($exhibition);
        $savedBoothIds = $this->resolveBookmarkedBoothIds($visitor);

        if ($savedBoothIds->isEmpty()) {
            $savedBooths = collect();
        } else {
            $savedBooths = BoothBooking::query()
                ->with(['company', 'boothProfile', 'hall', 'booth'])
                ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
                ->whereIn('id', $savedBoothIds)
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
                ->latest()
                ->get()
                ->filter(fn (BoothBooking $booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
                ->values();
        }

        return view('frontend.visitor-exhibition.booths.saved', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'savedBooths' => $savedBooths,
        ]);
    }

    public function meetings(string $slug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first()
            ?: Exhibition::where('slug', $slug)->first();
        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        $visitor = null;

        if ($bookingId) {
            $visitor = Visitor::query()
                ->when($exhibition, fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('booking_id', $bookingId)
                ->first();
        }

        if (! $visitor && auth()->check()) {
            $visitor = Visitor::query()
                ->when($exhibition, fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('email', auth()->user()->email)
                ->latest()
                ->first();
        }

        $meetings = collect();

        if (auth()->check() || $visitor?->email) {
            $meetings = VisitorMeetingBooking::query()
                ->with(['company.boothBookings.boothProfile', 'company.boothBookings.exhibition', 'companyMeeting'])
                ->when($exhibition, function ($query) use ($exhibition) {
                    $query->whereHas('company.boothBookings', fn ($bookingQuery) => $bookingQuery->where('exhibition_id', $exhibition->id));
                })
                ->where(function ($query) use ($visitor) {
                    if (auth()->check()) {
                        $query->where('visitor_id', auth()->id());
                    }

                    if ($visitor?->email) {
                        auth()->check()
                            ? $query->orWhere('visitor_email', $visitor->email)
                            : $query->where('visitor_email', $visitor->email);
                    }
                })
                ->latest()
                ->get();
        }

        $upcoming = $meetings->filter(fn ($m) => in_array($m->status, ['pending', 'confirmed', 'accepted'], true));
        $completed = $meetings->filter(fn ($m) => $m->status === 'completed');
        $cancelled = $meetings->filter(fn ($m) => in_array($m->status, ['cancelled', 'rejected'], true));
        $rescheduled = $meetings->filter(fn ($m) => $m->status === 'rescheduled');

        return view('frontend.visitor-exhibition.meetings.index', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'meetings' => $meetings,
            'upcoming' => $upcoming,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'rescheduled' => $rescheduled,
            'exhibition' => $exhibition,
        ]);
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

    public function sessions(string $slug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = LiveContent::exhibitionQuery()->where('slug', $slug)->first();
        $visitor = $this->resolveVisitor($exhibition);

        $sessions = BoothSession::query()
            ->with([
                'teamMember',
                'boothBooking.company',
                'boothBooking.boothProfile',
                'boothBooking.hall',
                'boothBooking.booth',
            ])
            ->whereIn('status', ['live', 'upcoming', 'completed'])
            ->whereHas('boothBooking', function (Builder $query) use ($exhibition) {
                $query
                    ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
                    ->publiclyVisible();
            })
            ->orderByRaw("CASE status WHEN 'live' THEN 0 WHEN 'upcoming' THEN 1 WHEN 'completed' THEN 2 ELSE 3 END")
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        return view('frontend.visitor-exhibition.sessions.index', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'sessions' => $sessions,
            'exhibition' => $exhibition,
            'registeredSessionIds' => $this->resolveRegisteredSessionIds($exhibition, $visitor),
        ]);
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

        VisitorSessionRegistration::firstOrCreate(
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

        return back()->with('success', 'Session registration saved.');
    }

    public function notifications(string $slug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = $this->resolveExhibition($slug);
        $visitor = $this->resolveVisitor($exhibition);

        return view('frontend.visitor-exhibition.notifications.index', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'notifications' => $this->buildVisitorNotifications($exhibition, $visitor),
        ]);
    }

    public function chat(string $slug, string $companySlug = null): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = $this->resolveExhibition($slug);
        $visitor = $this->resolveVisitor($exhibition);

        $booking = BoothBooking::query()
            ->with(['company', 'boothProfile'])
            ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
            ->publiclyVisible()
            ->get()
            ->first(fn (BoothBooking $item) => $this->companySlugForBooking($item) === $companySlug);

        if (! $booking && $companySlug) {
            $booking = BoothBooking::query()
                ->with(['company', 'boothProfile'])
                ->when($exhibition, fn (Builder $query) => $query->where('exhibition_id', $exhibition->id))
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->get()
                ->first(fn (BoothBooking $item) => $this->companySlugForBooking($item) === $companySlug);
        }

        $companySlug = $companySlug ?: ($booking ? $this->companySlugForBooking($booking) : '');
        $companyName = $booking
            ? ($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
            : str($companySlug)->replace('-', ' ')->title();

        $messages = collect();
        if ($exhibition && $booking?->company_id) {
            $messages = VisitorBoothMessage::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('company_id', $booking->company_id)
                ->when($visitor?->booking_id, fn ($query) => $query->where('visitor_booking_id', $visitor->booking_id))
                ->oldest()
                ->get();
        }

        return view('frontend.visitor-exhibition.networking.chat', [
            'slug' => $slug,
            'companySlug' => $companySlug,
            'isPassActive' => $isPassActive,
            'booking' => $booking,
            'companyName' => $companyName,
            'messages' => $messages,
            'visitor' => $visitor,
        ]);
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

    public function hallsIndex(string $slug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = $this->resolveExhibition($slug);

        $halls = collect();
        if ($exhibition) {
            $halls = Hall::query()
                ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('status', 'active')
                ->withCount([
                    'boothBookings as active_booths_count' => fn (Builder $query) => $query
                        ->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->where('admin_status', 'approved'),
                ])
                ->orderBy('title')
                ->get();
        }

        return view('frontend.visitor-exhibition.halls.index', [
            'slug' => $slug,
            'isPassActive' => $isPassActive,
            'halls' => $halls,
            'exhibition' => $exhibition,
        ]);
    }

    public function hallsShow(string $slug, string $hallSlug): View
    {
        $isPassActive = $this->isPassActive($slug);
        $exhibition = $this->resolveExhibition($slug);

        $hall = null;
        $featuredBooths = collect();
        $hallSessions = collect();

        if ($exhibition) {
            $hall = Hall::query()
                ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('status', 'active')
                ->where(fn ($query) => $query->where('slug', $hallSlug)->orWhere('id', $hallSlug))
                ->with(['booths.boothSize', 'pavilion'])
                ->first();

            if ($hall) {
                $featuredBooths = BoothBooking::query()
                    ->with(['company', 'boothProfile', 'hall', 'booth', 'boothSessions'])
                    ->where('hall_id', $hall->id)
                    ->publiclyVisible()
                    ->latest()
                    ->take(8)
                    ->get()
                    ->filter(fn (BoothBooking $booking) => $this->companySlugForBooking($booking) !== '')
                    ->values();

                $hallSessions = BoothSession::query()
                    ->with('boothBooking.boothProfile')
                    ->whereIn('status', ['live', 'upcoming'])
                    ->whereHas('boothBooking', fn (Builder $query) => $query->where('hall_id', $hall->id)->publiclyVisible())
                    ->orderBy('session_date')
                    ->orderBy('start_time')
                    ->take(4)
                    ->get();
            }
        }

        return view('frontend.visitor-exhibition.halls.show', [
            'slug' => $slug,
            'hallSlug' => $hallSlug,
            'isPassActive' => $isPassActive,
            'hall' => $hall,
            'featuredBooths' => $featuredBooths,
            'hallSessions' => $hallSessions,
        ]);
    }

    public function pavilionsIndex(string $slug): RedirectResponse
    {
        return redirect()->route('exhibitions.visitor.companies', $slug);
    }

    public function pavilionsShow(string $slug, string $pavilionSlug): RedirectResponse
    {
        return redirect()->route('exhibitions.visitor.companies', $slug);
    }
}
