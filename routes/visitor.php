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

    Route::get('/', function (\App\Domain\Shared\Services\ExhibitionsVisitorIndexPageData $pageData) {
        return view('frontend.exhibitions.index', $pageData->build());
    })->name('index');

    Route::get('/home', function () {
        $liveBooths = \App\Support\LiveContent::homeFeaturedBooths();

        return view('frontend.exhibitions.home', compact('liveBooths'));
    })->name('home');

    Route::get('/dashboard', function () {
        return redirect()->route('frontend.user.dashboard', array_filter([
            'slug' => request()->query('slug'),
        ]));
    })->name('dashboard');

    Route::get('/booking-dashboard', function () {
        return redirect()->route('exhibitions.home');
    })->name('booking-dashboard');

    Route::get('/browse', function (\App\Domain\Shared\Services\ExhibitionsVisitorIndexPageData $pageData) {
        return view('frontend.exhibitions.index', $pageData->build());
    })->name('browse');

    Route::get('/pavilions', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        if ($exhibition) {
            return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
        }

        $slug = '';
        $isPassActive = false;
        $booths = collect();

        return view('frontend.visitor-exhibition.booths.companies', compact('slug', 'isPassActive', 'booths'));
    })->name('pavilions.index');

    Route::get('/pavilions/show', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();

        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
    })->name('pavilions.show');

    Route::get('/pavilions/{slug}', function ($slug) {
        $exhibition = \App\Support\LiveContent::findLiveExhibitionBySlug($slug);

        if ($exhibition) {
            return redirect()->route('exhibitions.visitor.companies', $exhibition->slug);
        }

        $fallbackExhibition = \App\Support\LiveContent::firstLiveExhibition();

        abort_unless($fallbackExhibition, 404);

        return redirect()->route('exhibitions.visitor.companies.show', [
            'slug' => $fallbackExhibition->slug,
            'companySlug' => $slug,
        ]);
    })->name('pavilions.show.slug');

    Route::get('/halls', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor-halls.index', $exhibition->slug);
    })->name('halls.index');

    Route::get('/halls/show', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();

        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.floor-map', $exhibition->slug);
    })->name('halls.show');

    Route::get('/halls/floor-plan', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.floor-map', $exhibition->slug);
    })->name('halls.floor-plan');

    Route::get('/halls/floor-plan/view', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.visitor.floor-map', $exhibition->slug);
    })->name('halls.floor-plan.view');

    Route::get('/halls/{slug}', function ($slug) {
        return redirect()->route('exhibitions.visitor.floor-map', $slug);
    })->name('halls.show.slug');

    Route::get('/booths/sizes', function () {
        return redirect('/company/booth-booking/sizes');
    })->name('booths.sizes');

    Route::get('/booths/slots', function () {
        return redirect('/company/booth-booking/summary');
    })->name('booths.slots');

    Route::get('/booths/customize', function () {
        return redirect('/company/booth-booking/customize');
    })->name('booths.customize');

    Route::get('/booths/details', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('booths.details');

    Route::get('/booking/summary', function () {
        return redirect('/company/booth-booking/summary');
    })->name('booking.summary');

    Route::get('/booking/services', [ExhibitionBookingController::class, 'services'])->name('booking.services');
    Route::post('/booking/services/toggle', [ExhibitionBookingController::class, 'toggleService'])->name('booking.services.toggle');

    Route::get('/booking/review', [ExhibitionBookingController::class, 'review'])->name('booking.review');

    Route::get('/booking/payment', function () {
        $bookingId = session('selected_visitor_booking_id');
        $slug = session('activeExhibitionSlug')
            ?: \App\Support\LiveContent::firstLiveExhibitionSlug();

        if ($bookingId && $slug) {
            return redirect()->route('exhibitions.tickets.e-ticket', [
                'slug' => $slug,
                'booking_id' => $bookingId,
            ]);
        }

        return redirect('/exhibitions/booking/review');
    })->name('booking.payment');

    Route::get('/booking/confirmed', function () {
        $bookingId = session('selected_visitor_booking_id');
        $slug = session('activeExhibitionSlug')
            ?: \App\Support\LiveContent::firstLiveExhibitionSlug();

        if ($bookingId && $slug) {
            session(['activeExhibitionSlug' => $slug]);

            return redirect()->route('frontend.user.dashboard', [
                'slug' => $slug,
                'booking_id' => $bookingId,
            ]);
        }

        return redirect()->route('exhibitions.index');
    })->name('booking.confirmed');

    Route::get('/booking/my-bookings', function () {
        $visitors = \App\Support\DbGuard::whenAvailable(function () {
            if (! auth()->check()) {
                return collect();
            }

            return \App\Domain\Visitor\Models\Visitor::where('email', auth()->user()->email)
                ->with('exhibition')
                ->orderBy('created_at', 'desc')
                ->get();
        }, collect());

        return view('frontend.exhibitions.booking.my-bookings', compact('visitors'));
    })->name('booking.my-bookings');

    Route::get('/exhibitors/booth-profile', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('exhibitors.booth-profile');

    Route::get('/exhibitors/products', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('exhibitors.products');

    Route::get('/exhibitors/documents', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('exhibitors.documents');

    Route::get('/exhibitors/catalogues', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('exhibitors.catalogues');

    Route::get('/exhibitors/media-gallery', function () {
        $exhibition = \App\Support\LiveContent::firstLiveExhibition();
        abort_unless($exhibition, 404);

        return redirect()->route('exhibitions.booths.index', $exhibition->slug);
    })->name('exhibitors.media-gallery');

    Route::get('/exhibitors/meetings', function () {
        return redirect()->route('frontend.user.meetings');
    })->name('exhibitors.meetings');

    Route::get('/exhibitors/enquiries', [ExhibitionBoothController::class, 'exhibitorEnquiryForm'])->name('exhibitors.enquiries');
    Route::post('/exhibitors/enquiries', [ExhibitionBoothController::class, 'sendExhibitorEnquiry'])->name('exhibitors.enquiries.send');

    Route::prefix('{slug}/tickets')->name('tickets.')->group(function () {
        Route::get('/select', function ($slug) {
            session([
                'activeExhibitionSlug' => $slug,
                'exhibition_booking_path' => route('exhibitions.tickets.visitor-details', $slug),
                'user_flow_context' => 'exhibition_ticket',
            ]);

            return redirect()->route('exhibitions.tickets.visitor-details', $slug);
        })->name('select');

        Route::get('/visitor-details', [\App\Domain\Visitor\Controllers\VisitorTicketController::class, 'visitorRegistration'])->name('visitor-details');
        Route::post('/visitor-details', [\App\Domain\Visitor\Controllers\VisitorTicketController::class, 'storeVisitorRegistration'])->name('visitor-details.store');
        Route::get('/pass-details', [\App\Domain\Visitor\Controllers\VisitorTicketController::class, 'passDetails'])->name('pass-details');

        Route::post('/register', [VisitorTicketController::class, 'register'])->name('register');

        Route::get('/summary', function (string $slug, \App\Domain\Shared\Services\ExhibitionTicketSummaryPageData $pageData) {
            $data = $pageData->build($slug);

            abort_unless($data, 404);

            return view('frontend.exhibitions.tickets.summary', $data);
        })->name('summary');

        Route::get('/payment', function ($slug) {
            if (! \App\Support\ExhibitionTicketFlow::hasVisitorRegistration($slug)) {
                return redirect()->route('exhibitions.tickets.visitor-details', $slug);
            }

            return view('frontend.exhibitions.tickets.payment', compact('slug'));
        })->name('payment');

        Route::post('/payment/{bookingId}/confirm', [VisitorTicketController::class, 'confirmPayment'])->name('payment.confirm');

        Route::get('/confirmed', function (string $slug, \App\Domain\Shared\Services\ExhibitionTicketConfirmedPageData $pageData) {
            $data = $pageData->build($slug);

            abort_unless($data, 404);

            if ($data['visitor'] && $data['visitor']->payment_status === 'completed') {
                session([
                    'visitor_pass_active' => true,
                    'activeExhibitionSlug' => $slug,
                    'selected_visitor_booking_id' => $data['visitor']->booking_id,
                ]);
                session()->forget('exhibition_booking_path');

                return redirect()->route('frontend.user.dashboard', array_filter([
                    'slug' => $slug,
                    'booking_id' => $data['visitor']->booking_id,
                ]));
            }

            return view('frontend.exhibitions.tickets.confirmed', $data);
        })->name('confirmed');

        Route::get('/e-ticket', function ($slug) {
            return view('frontend.exhibitions.tickets.e-ticket', compact('slug'));
        })->name('e-ticket');
    });

    Route::get('/{slug}/visit', [VisitorExhibitionController::class, 'lobby'])->name('visit');
    Route::get('/{slug}/companies', [ExhibitionBoothController::class, 'index'])->name('visitor.companies');
    Route::get('/{slug}/companies/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('visitor.companies.show');
    
    Route::post('/{slug}/companies/{companySlug}/meetings/book', [ExhibitionBoothController::class, 'bookMeeting'])->name('visitor.meetings.book');
    Route::post('/{slug}/companies/{companySlug}/meetings/{id}/join', [ExhibitionBoothController::class, 'requestMeetingJoin'])->name('visitor.meetings.join');
    Route::post('/{slug}/companies/{companySlug}/enquiry', [ExhibitionBoothController::class, 'sendEnquiry'])->name('visitor.enquiry.send');
    
    Route::get('/{slug}/floor-map', [VisitorExhibitionController::class, 'floorMap'])->name('visitor.floor-map');
    
    Route::get('/{slug}/register-pass', function ($slug) {
        session([
            'activeExhibitionSlug' => $slug,
            'exhibition_booking_path' => route('exhibitions.tickets.visitor-details', $slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        return redirect()->route('exhibitions.tickets.visitor-details', $slug);
    })->name('visitor.register-pass');

    Route::get('/{slug}/visitor-dashboard', [VisitorExhibitionController::class, 'dashboard'])->name('visitor.dashboard');
    
    Route::get('/{slug}/qr-pass', function ($slug) {
        return view('frontend.exhibitions.tickets.e-ticket', compact('slug'));
    })->name('visitor.qr-pass');

    Route::get('/{slug}/my-passes', [VisitorExhibitionController::class, 'myPasses'])->name('visitor.my-passes');
    Route::get('/{slug}/saved-booths', [VisitorExhibitionController::class, 'savedBooths'])->name('visitor.saved');
    Route::get('/{slug}/my-meetings', function (string $slug) {
        return redirect()->route('frontend.user.meetings');
    })->name('visitor.meetings');
    Route::get('/{slug}/sessions', [VisitorExhibitionController::class, 'sessions'])->name('visitor.sessions');
    Route::post('/{slug}/sessions/{session}/register', [VisitorExhibitionController::class, 'registerSession'])->name('visitor.sessions.register');
    Route::post('/{slug}/sessions/{session}/request-join', [VisitorExhibitionController::class, 'requestSessionJoin'])->name('visitor.sessions.request-join');
    Route::get('/{slug}/notifications', [VisitorExhibitionController::class, 'notifications'])->name('visitor.notifications');
    Route::get('/{slug}/chat/{companySlug?}', [VisitorExhibitionController::class, 'chat'])->name('visitor.chat');
    Route::post('/{slug}/chat/{companySlug}/message', [VisitorExhibitionController::class, 'sendChatMessage'])->name('visitor.chat.send');

    Route::get('/{slug}/pavilions', [VisitorExhibitionController::class, 'pavilionsIndex'])->name('visitor-pavilions.index');
    Route::get('/{slug}/pavilions/{pavilionSlug}', [VisitorExhibitionController::class, 'pavilionsShow'])->name('visitor-pavilions.show');

    Route::get('/{slug}/halls', [VisitorExhibitionController::class, 'hallsIndex'])->name('visitor-halls.index');
    Route::get('/{slug}/halls/{hallSlug}', [VisitorExhibitionController::class, 'hallsShow'])->name('visitor-halls.show');

    Route::get('/{slug}/booths', [ExhibitionBoothController::class, 'index'])->name('booths.index');

    Route::get('/{slug}/booths/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('booths.show');

    Route::get('/{slug}', function (string $slug, \App\Domain\Shared\Services\ExhibitionShowPageData $pageData) {
        $context = \App\Support\LiveContent::exhibitionShowContext($slug);

        abort_unless($context, 404);

        return view('frontend.exhibitions.show', $pageData->build($slug, $context));
    })->name('show');

});
