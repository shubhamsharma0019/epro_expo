<?php

use App\Domain\Event\Controllers\ExhibitionBookingController;
use App\Domain\Booth\Controllers\ExhibitionBoothController;
use App\Domain\Visitor\Controllers\VisitorExhibitionController;
use App\Domain\Visitor\Controllers\VisitorTicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('exhibitions')->name('exhibitions.')->group(function () {

    Route::prefix('visitor')->name('visitor.')->group(function () {
        Route::get('/login', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'showExhibitionTicketLogin'])->name('login');
        Route::post('/login', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'login'])->name('login.store');
        Route::get('/register', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'showExhibitionTicketRegister'])->name('register');
        Route::post('/register', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'register'])->name('register.store');
    });

    Route::get('/', function () {
        $dynamicExhibitions = \App\Support\LiveContent::exhibitionPageQuery()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothProducts', 'boothCatalogues', 'company'])
                    ->publiclyVisible(),
            ])
            ->orderBy('start_date')
            ->orderBy('id')
            ->get()
            ->unique(fn ($exhibition) => strtolower(trim((string) ($exhibition->title ?: $exhibition->name))))
            ->values();

        return view('frontend.exhibitions.index', compact('dynamicExhibitions'));
    })->name('index');

    Route::get('/home', function () {
        $liveBooths = \App\Support\LiveContent::boothBookingQuery()
            ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
            ->withCount([
                'boothProducts as published_products_count' => fn ($query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->latest()
            ->take(6)
            ->get()
            ->filter(fn ($booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
            ->values();

        return view('frontend.exhibitions.home', compact('liveBooths'));
    })->name('home');

    Route::get('/dashboard', function () {
        $slug = request()->query('slug');
        if ($slug) {
            return redirect()->route('exhibitions.visitor.dashboard', $slug);
        }

        $exhibition = \App\Support\LiveContent::exhibitionQuery()->orderBy('start_date')->first();
        if ($exhibition) {
            return redirect()->route('exhibitions.visitor.dashboard', $exhibition->slug);
        }

        return view('frontend.visitor-exhibition.visitor-dashboard.index', [
            'slug' => '',
            'isPassActive' => false,
        ]);
    })->name('dashboard');

    Route::get('/booking-dashboard', function () {
        return redirect()->route('exhibitions.home');
    })->name('booking-dashboard');

    Route::get('/browse', function () {
        $dynamicExhibitions = \App\Support\LiveContent::exhibitionPageQuery()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothProducts', 'boothCatalogues', 'company'])
                    ->publiclyVisible(),
            ])
            ->orderBy('start_date')
            ->orderBy('id')
            ->get()
            ->unique(fn ($exhibition) => strtolower(trim((string) ($exhibition->title ?: $exhibition->name))))
            ->values();

        return view('frontend.exhibitions.index', compact('dynamicExhibitions'));
    })->name('browse');

    Route::get('/pavilions', function () {
        $exhibition = \App\Support\LiveContent::exhibitionQuery()->orderBy('start_date')->first();
        if ($exhibition) {
            return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
        }

        $slug = '';
        $isPassActive = false;
        $booths = collect();

        return view('frontend.visitor-exhibition.booths.companies', compact('slug', 'isPassActive', 'booths'));
    })->name('pavilions.index');

    Route::get('/pavilions/show', function () {
        $exhibition = \App\Support\LiveContent::exhibitionQuery()->orderBy('start_date')->first();

        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
    })->name('pavilions.show');

    Route::get('/pavilions/{slug}', function ($slug) {
        $exhibition = \App\Support\LiveContent::exhibitionQuery()->where('slug', $slug)->first();

        if ($exhibition) {
            return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
        }

        $fallbackExhibition = \App\Support\LiveContent::exhibitionQuery()->orderBy('start_date')->first();

        abort_unless($fallbackExhibition, 404);

        return redirect()->route('exhibitions.visitor.companies.show', [
            'slug' => $fallbackExhibition->slug,
            'companySlug' => $slug,
        ]);
    })->name('pavilions.show.slug');

    Route::get('/halls', function () {
        return view('frontend.exhibitions.halls.index');
    })->name('halls.index');

    Route::get('/halls/show', function () {
        $exhibition = \App\Support\LiveContent::exhibitionQuery()->orderBy('start_date')->first();

        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.floor-map', $exhibition->slug);
    })->name('halls.show');

    Route::get('/halls/floor-plan', function () {
        return view('frontend.exhibitions.halls.floor-plan');
    })->name('halls.floor-plan');

    Route::get('/halls/floor-plan/view', function () {
        return view('frontend.exhibitions.halls.floor-plan');
    })->name('halls.floor-plan.view');

    Route::get('/halls/{slug}', function ($slug) {
        return redirect()->route('exhibitions.visitor.floor-map', $slug);
    })->name('halls.show.slug');

    Route::get('/booths/sizes', function () {
        return view('frontend.exhibitions.booths.sizes');
    })->name('booths.sizes');

    Route::get('/booths/slots', function () {
        return view('frontend.exhibitions.booths.slots');
    })->name('booths.slots');

    Route::get('/booths/customize', function () {
        return view('frontend.exhibitions.booths.customize');
    })->name('booths.customize');

    Route::get('/booths/details', function () {
        return view('frontend.exhibitions.booths.details');
    })->name('booths.details');

    Route::get('/booking/summary', function () {
        return view('frontend.exhibitions.booking.summary');
    })->name('booking.summary');

    Route::get('/booking/services', [ExhibitionBookingController::class, 'services'])->name('booking.services');
    Route::post('/booking/services/toggle', [ExhibitionBookingController::class, 'toggleService'])->name('booking.services.toggle');

    Route::get('/booking/review', [ExhibitionBookingController::class, 'review'])->name('booking.review');

    Route::get('/booking/payment', function () {
        return view('frontend.exhibitions.booking.payment');
    })->name('booking.payment');

    Route::get('/booking/confirmed', function () {
        return view('frontend.exhibitions.booking.confirmed');
    })->name('booking.confirmed');

    Route::get('/booking/my-bookings', function () {
        $visitors = collect();
        if (auth()->check()) {
            $visitors = \App\Domain\Visitor\Models\Visitor::where('email', auth()->user()->email)
                ->with('exhibition')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('frontend.exhibitions.booking.my-bookings', compact('visitors'));
    })->name('booking.my-bookings');

    Route::get('/exhibitors/booth-profile', function () {
        return view('frontend.exhibitions.exhibitors.booth-profile');
    })->name('exhibitors.booth-profile');

    Route::get('/exhibitors/products', function () {
        return view('frontend.exhibitions.exhibitors.products');
    })->name('exhibitors.products');

    Route::get('/exhibitors/documents', function () {
        return view('frontend.exhibitions.exhibitors.documents');
    })->name('exhibitors.documents');

    Route::get('/exhibitors/catalogues', function () {
        return view('frontend.exhibitions.exhibitors.catalogues');
    })->name('exhibitors.catalogues');

    Route::get('/exhibitors/media-gallery', function () {
        return view('frontend.exhibitions.exhibitors.media-gallery');
    })->name('exhibitors.media-gallery');

    Route::get('/exhibitors/meetings', function () {
        return view('frontend.exhibitions.exhibitors.meetings');
    })->name('exhibitors.meetings');

    Route::get('/exhibitors/enquiries', [ExhibitionBoothController::class, 'exhibitorEnquiryForm'])->name('exhibitors.enquiries');
    Route::post('/exhibitors/enquiries', [ExhibitionBoothController::class, 'sendExhibitorEnquiry'])->name('exhibitors.enquiries.send');

    Route::prefix('{slug}/tickets')->name('tickets.')->group(function () {
        Route::get('/select', function ($slug) {
            session([
                'activeExhibitionSlug' => $slug,
                'exhibition_booking_path' => route('exhibitions.tickets.select', $slug),
                'user_flow_context' => 'exhibition_ticket',
            ]);

            if (! auth()->check()) {
                session()->put('url.intended', route('exhibitions.tickets.select', $slug));
                session()->put('exhibition_booking_path', route('exhibitions.tickets.select', $slug));
                session()->put('user_flow_context', 'exhibition_ticket');

                return redirect()->route('exhibitions.visitor.login', ['exhibition' => $slug]);
            }

            return view('frontend.exhibitions.tickets.select', compact('slug'));
        })->name('select');

        Route::get('/visitor-details', function ($slug) {
            return view('frontend.exhibitions.tickets.visitor-details', compact('slug'));
        })->name('visitor-details');

        Route::post('/register', [VisitorTicketController::class, 'register'])->name('register');

        Route::get('/summary', function ($slug) {
            return view('frontend.exhibitions.tickets.summary', compact('slug'));
        })->name('summary');

        Route::get('/payment', function ($slug) {
            return view('frontend.exhibitions.tickets.payment', compact('slug'));
        })->name('payment');

        Route::post('/payment/{bookingId}/confirm', [VisitorTicketController::class, 'confirmPayment'])->name('payment.confirm');

        Route::get('/confirmed', function ($slug) {
            session(['visitor_pass_active' => true]);
            return view('frontend.exhibitions.tickets.confirmed', compact('slug'));
        })->name('confirmed');

        Route::get('/e-ticket', function ($slug) {
            return view('frontend.exhibitions.tickets.e-ticket', compact('slug'));
        })->name('e-ticket');
    });

    Route::get('/{slug}/visit', [VisitorExhibitionController::class, 'lobby'])->name('visit');
    Route::get('/{slug}/companies', [ExhibitionBoothController::class, 'index'])->name('visitor.companies');
    Route::get('/{slug}/companies/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('visitor.companies.show');
    
    Route::post('/{slug}/companies/{companySlug}/meetings/book', [ExhibitionBoothController::class, 'bookMeeting'])->name('visitor.meetings.book');
    Route::post('/{slug}/companies/{companySlug}/enquiry', [ExhibitionBoothController::class, 'sendEnquiry'])->name('visitor.enquiry.send');
    
    Route::get('/{slug}/floor-map', [VisitorExhibitionController::class, 'floorMap'])->name('visitor.floor-map');
    
    Route::get('/{slug}/register-pass', function ($slug) {
        session([
            'activeExhibitionSlug' => $slug,
            'url.intended' => route('exhibitions.tickets.select', $slug),
            'exhibition_booking_path' => route('exhibitions.tickets.select', $slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        if (auth()->check()) {
            return redirect()->route('exhibitions.visitor.dashboard', $slug);
        }

        return redirect()->route('exhibitions.visitor.login', ['exhibition' => $slug]);
    })->name('visitor.register-pass');

    Route::get('/{slug}/visitor-dashboard', [VisitorExhibitionController::class, 'dashboard'])->name('visitor.dashboard');
    
    Route::get('/{slug}/qr-pass', function ($slug) {
        return view('frontend.exhibitions.tickets.e-ticket', compact('slug'));
    })->name('visitor.qr-pass');

    Route::get('/{slug}/my-passes', [VisitorExhibitionController::class, 'myPasses'])->name('visitor.my-passes');
    Route::get('/{slug}/saved-booths', [VisitorExhibitionController::class, 'savedBooths'])->name('visitor.saved');
    Route::get('/{slug}/my-meetings', [VisitorExhibitionController::class, 'meetings'])->name('visitor.meetings');
    Route::get('/{slug}/sessions', [VisitorExhibitionController::class, 'sessions'])->name('visitor.sessions');
    Route::post('/{slug}/sessions/{session}/register', [VisitorExhibitionController::class, 'registerSession'])->name('visitor.sessions.register');
    Route::get('/{slug}/notifications', [VisitorExhibitionController::class, 'notifications'])->name('visitor.notifications');
    Route::get('/{slug}/chat/{companySlug?}', [VisitorExhibitionController::class, 'chat'])->name('visitor.chat');
    Route::post('/{slug}/chat/{companySlug}/message', [VisitorExhibitionController::class, 'sendChatMessage'])->name('visitor.chat.send');

    Route::get('/{slug}/pavilions', [VisitorExhibitionController::class, 'pavilionsIndex'])->name('visitor-pavilions.index');
    Route::get('/{slug}/pavilions/{pavilionSlug}', [VisitorExhibitionController::class, 'pavilionsShow'])->name('visitor-pavilions.show');

    Route::get('/{slug}/halls', [VisitorExhibitionController::class, 'hallsIndex'])->name('visitor-halls.index');
    Route::get('/{slug}/halls/{hallSlug}', [VisitorExhibitionController::class, 'hallsShow'])->name('visitor-halls.show');

    Route::get('/{slug}/booths', [ExhibitionBoothController::class, 'index'])->name('booths.index');

    Route::get('/{slug}/booths/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('booths.show');

    Route::get('/{slug}', function ($slug) {
        $exhibition = \App\Support\LiveContent::exhibitionPageQuery()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions', 'boothTeamMembers'])
                    ->publiclyVisible(),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $speakers = \App\Domain\Event\Models\Speaker::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('name')
            ->get();

        $agenda = \App\Domain\Event\Models\AgendaSession::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('start_time')
            ->get();

        $sponsors = \App\Domain\Event\Models\Sponsor::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('name')
            ->get();

        $faqs = \App\Domain\Event\Models\Faq::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('id')
            ->get();

        if ($faqs->isEmpty()) {
            $title = $exhibition->title ?: $exhibition->name;
            $date = $exhibition->start_date && $exhibition->end_date
                ? $exhibition->start_date->format('M d') . ' - ' . $exhibition->end_date->format('d, Y')
                : 'The event date will be updated soon.';
            $venue = $exhibition->venue ?: ($exhibition->location ?: 'The venue will be updated soon.');
            $exhibitorCount = $exhibition->boothBookings
                ->map(fn ($booking) => $booking->company_id ?: $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name)
                ->filter()
                ->unique()
                ->count();

            $faqs = collect([
                (object) ['question' => 'When is ' . $title . '?', 'answer' => $date, 'icon' => 'ph-calendar-blank'],
                (object) ['question' => 'Where is the exhibition hosted?', 'answer' => $venue, 'icon' => 'ph-map-pin'],
                (object) ['question' => 'How can visitors attend?', 'answer' => 'Visitors can get a visitor pass from this exhibition page and then follow the visitor flow to explore companies, floor map, sessions, meetings and booth details.', 'icon' => 'ph-ticket'],
                (object) ['question' => 'How many companies are participating?', 'answer' => $exhibitorCount > 0 ? $exhibitorCount . ' companies are currently visible for visitors.' : 'Participating companies will appear here once approved booths are published.', 'icon' => 'ph-buildings'],
            ]);
        }

        $halls = \App\Domain\Event\Models\Hall::whereHas('pavilion', fn($q) => $q->where('exhibition_id', $exhibition->id))
            ->where('status', 'active')
            ->get();

        return view('frontend.exhibitions.show', compact('slug', 'exhibition', 'speakers', 'agenda', 'sponsors', 'faqs', 'halls'));
    })->name('show');

});
