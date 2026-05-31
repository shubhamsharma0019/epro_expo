<?php

use App\Http\Controllers\Auth\CompanyAuthController;
use App\Http\Controllers\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\BoothApprovalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventApprovalController;
use App\Http\Controllers\Company\BookingDetailsController;
use App\Http\Controllers\Frontend\VisitorExhibitionController;
use App\Http\Controllers\Company\BoothAnalyticsController;
use App\Http\Controllers\Company\BoothBrandingController;
use App\Http\Controllers\Company\CompanyBoothBookingController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\BoothCatalogueController;
use App\Http\Controllers\Company\BoothDocumentController;
use App\Http\Controllers\Company\BoothMediaController;
use App\Http\Controllers\Company\BoothMeetingAvailabilityController;
use App\Http\Controllers\Company\BoothPreviewController;
use App\Http\Controllers\Company\BoothProductController;
use App\Http\Controllers\Company\BoothProfileController;
use App\Http\Controllers\Company\BoothPublishController;
use App\Http\Controllers\Company\BoothSessionController;
use App\Http\Controllers\Company\BoothSetupController;
use App\Http\Controllers\Company\BoothTeamMemberController;
use App\Http\Controllers\CompanyEvent\BrandingController as CompanyEventBrandingController;
use App\Http\Controllers\CompanyEvent\DashboardController as CompanyEventDashboardController;
use App\Http\Controllers\CompanyEvent\EventDraftController as CompanyEventDraftController;
use App\Http\Controllers\CompanyEvent\PreviewController as CompanyEventPreviewController;
use App\Http\Controllers\CompanyEvent\SubmitReviewController as CompanyEventSubmitReviewController;
use App\Http\Controllers\CompanyEvent\TicketTypeController as CompanyEventTicketTypeController;
use App\Models\BoothBooking;
use App\Http\Controllers\Frontend\ExhibitionBookingController;
use App\Http\Controllers\Frontend\ExhibitionBoothController;
use App\Http\Controllers\Admin\AdminBoothBookingController;
use App\Http\Controllers\Company\CompanyExhibitionController;
use App\Http\Controllers\Company\CompanyEnquiryController;
use App\Http\Controllers\Company\CompanyMeetingController;
use App\Http\Controllers\CompanyEvent\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/home', function () {
    return view('frontend.home');
})->name('frontend.home');

Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', function () {
        return redirect('/user/dashboard');
    })->name('home');

    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.store');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VisitorEvent\UserTicketController::class, 'index'])->name('index');

        Route::get('/{id}/e-ticket', [\App\Http\Controllers\VisitorEvent\UserTicketController::class, 'download'])->name('e-ticket');

        Route::get('/{id}', [\App\Http\Controllers\VisitorEvent\UserTicketController::class, 'show'])->name('show');
    });

    Route::prefix('exhibition-tickets')->name('exhibition-tickets.')->group(function () {
        Route::get('/', function () {
            return view('user.exhibition-tickets.index');
        })->name('index');

        Route::get('/{id}/e-ticket', function ($id) {
            return view('user.exhibition-tickets.e-ticket', compact('id'));
        })->name('e-ticket');

        Route::get('/{id}', function ($id) {
            return view('user.exhibition-tickets.show', compact('id'));
        })->name('show');
    });

    Route::prefix('visits')->name('visits.')->group(function () {
        Route::get('/', function () {
            return view('user.visits.index');
        })->name('index');

        Route::get('/{id}', function ($id) {
            return view('user.visits.show', compact('id'));
        })->name('show');
    });

    Route::get('/saved/exhibitions', function () {
        return view('user.saved.exhibitions');
    })->name('saved.exhibitions');

    Route::get('/booths/visited', function () {
        return view('user.booths.visited');
    })->name('booths.visited');

    Route::prefix('enquiries')->name('enquiries.')->group(function () {
        Route::get('/', function () {
            return view('user.enquiries.index');
        })->name('index');

        Route::get('/{id}', function ($id) {
            return view('user.enquiries.show', compact('id'));
        })->name('show');
    });

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('profile');

    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');
});

Route::prefix('exhibitions')->name('exhibitions.')->group(function () {

    Route::get('/', function () {
        $dynamicExhibitions = \App\Models\Exhibition::query()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
            ])
            ->where('status', 'active')
            ->orderBy('start_date')
            ->get();

        return view('frontend.exhibitions.index', compact('dynamicExhibitions'));
    })->name('index');

    Route::get('/home', function () {
        $liveBooths = \App\Models\BoothBooking::query()
            ->with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
            ->withCount([
                'boothProducts as published_products_count' => fn ($query) => $query->where('status', 'published'),
                'boothCatalogues as public_catalogues_count' => fn ($query) => $query->where('visibility', 'public')->where('status', 'active'),
            ])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live'])
            ->latest()
            ->take(6)
            ->get()
            ->filter(fn ($booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name))
            ->values();

        return view('frontend.exhibitions.home', compact('liveBooths'));
    })->name('home');

    Route::get('/dashboard', function () {
        $isPassActive = true;

        return view('frontend.exhibitions.dashboard', compact('isPassActive'));
    })->name('dashboard');

    Route::get('/booking-dashboard', function () {
        return redirect()->route('exhibitions.home');
    })->name('booking-dashboard');

    Route::get('/browse', function () {
        $dynamicExhibitions = \App\Models\Exhibition::query()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
            ])
            ->where('status', 'active')
            ->orderBy('start_date')
            ->get();

        return view('frontend.exhibitions.index', compact('dynamicExhibitions'));
    })->name('browse');

    Route::get('/pavilions', function () {
        $slug = 'innovation-expo';
        $isPassActive = false;

        return view('frontend.exhibitions.visitor.companies.index', compact('slug', 'isPassActive'));
    })->name('pavilions.index');

    Route::get('/pavilions/show', function () {
        $slug = 'innovation-expo';
        $companySlug = 'technova-solutions';
        $isPassActive = false;

        return view('frontend.exhibitions.booths.show', compact('slug', 'companySlug', 'isPassActive'));
    })->name('pavilions.show');

    Route::get('/pavilions/{slug}', function ($slug) {
        $eventSlug = 'innovation-expo';
        $companySlug = $slug;
        $isPassActive = false;

        return view('frontend.exhibitions.booths.show', ['slug' => $eventSlug, 'companySlug' => $companySlug, 'isPassActive' => $isPassActive]);
    })->name('pavilions.show.slug');

    Route::get('/halls', function () {
        return view('frontend.exhibitions.halls.index');
    })->name('halls.index');

    Route::get('/halls/show', function () {
        $slug = 'innovation-expo';
        $isPassActive = false;

        return view('frontend.exhibitions.halls.floor-plan', compact('slug', 'isPassActive'));
    })->name('halls.show');

    Route::get('/halls/floor-plan', function () {
        return view('frontend.exhibitions.halls.floor-plan');
    })->name('halls.floor-plan');

    Route::get('/halls/floor-plan/view', function () {
        return view('frontend.exhibitions.halls.floor-plan');
    })->name('halls.floor-plan.view');

    Route::get('/halls/{slug}', function ($slug) {
        $isPassActive = false;

        return view('frontend.exhibitions.halls.floor-plan', ['slug' => 'innovation-expo', 'isPassActive' => $isPassActive]);
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
        return view('frontend.exhibitions.booking.my-bookings');
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

    Route::get('/exhibitors/enquiries', function () {
        return view('frontend.exhibitions.exhibitors.enquiries');
    })->name('exhibitors.enquiries');

    Route::prefix('{slug}/tickets')->name('tickets.')->group(function () {
        Route::get('/select', function ($slug) {
            return view('frontend.visitor-flow.pass-selection', compact('slug'));
        })->name('select');

        Route::get('/visitor-details', function ($slug) {
            return view('frontend.visitor-flow.visitor-details', compact('slug'));
        })->name('visitor-details');

        Route::get('/summary', function ($slug) {
            return view('frontend.visitor-flow.review-confirm', compact('slug'));
        })->name('summary');

        Route::get('/payment', function ($slug) {
            return view('frontend.visitor-flow.payment', compact('slug'));
        })->name('payment');

        Route::get('/confirmed', function ($slug) {
            session(['visitor_pass_active' => true]);
            return view('frontend.visitor-flow.success', compact('slug'));
        })->name('confirmed');

        Route::get('/e-ticket', function ($slug) {
            return view('frontend.visitor-flow.e-ticket', compact('slug'));
        })->name('e-ticket');
    });

    Route::get('/{slug}/visit', [VisitorExhibitionController::class, 'lobby'])->name('visit');
    Route::get('/{slug}/companies', [ExhibitionBoothController::class, 'index'])->name('visitor.companies');
    Route::get('/{slug}/companies/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('visitor.companies.show');
    
    Route::post('/{slug}/companies/{companySlug}/meetings/book', [ExhibitionBoothController::class, 'bookMeeting'])->name('visitor.meetings.book');
    Route::post('/{slug}/companies/{companySlug}/enquiry', [ExhibitionBoothController::class, 'sendEnquiry'])->name('visitor.enquiry.send');
    
    Route::get('/{slug}/floor-map', [VisitorExhibitionController::class, 'floorMap'])->name('visitor.floor-map');
    
    Route::get('/{slug}/register-pass', function ($slug) {
        return redirect()->route('exhibitions.tickets.select', $slug);
    })->name('visitor.register-pass');

    Route::get('/{slug}/visitor-dashboard', [VisitorExhibitionController::class, 'dashboard'])->name('visitor.dashboard');
    
    Route::get('/{slug}/qr-pass', function ($slug) {
        return view('frontend.exhibitions.tickets.e-ticket', compact('slug'));
    })->name('visitor.qr-pass');

    Route::get('/{slug}/my-passes', [VisitorExhibitionController::class, 'myPasses'])->name('visitor.my-passes');
    Route::get('/{slug}/saved-booths', [VisitorExhibitionController::class, 'savedBooths'])->name('visitor.saved');
    Route::get('/{slug}/my-meetings', [VisitorExhibitionController::class, 'meetings'])->name('visitor.meetings');
    Route::get('/{slug}/sessions', [VisitorExhibitionController::class, 'sessions'])->name('visitor.sessions');
    Route::get('/{slug}/notifications', [VisitorExhibitionController::class, 'notifications'])->name('visitor.notifications');
    Route::get('/{slug}/chat/{companySlug?}', [VisitorExhibitionController::class, 'chat'])->name('visitor.chat');

    Route::get('/{slug}/pavilions', [VisitorExhibitionController::class, 'pavilionsIndex'])->name('visitor-pavilions.index');
    Route::get('/{slug}/pavilions/{pavilionSlug}', [VisitorExhibitionController::class, 'pavilionsShow'])->name('visitor-pavilions.show');

    Route::get('/{slug}/halls', [VisitorExhibitionController::class, 'hallsIndex'])->name('visitor-halls.index');
    Route::get('/{slug}/halls/{hallSlug}', [VisitorExhibitionController::class, 'hallsShow'])->name('visitor-halls.show');

    Route::get('/{slug}/booths', [ExhibitionBoothController::class, 'index'])->name('booths.index');

    Route::get('/{slug}/booths/{companySlug}', [ExhibitionBoothController::class, 'show'])->name('booths.show');

    Route::get('/{slug}', function ($slug) {
        session(['activeExhibitionSlug' => $slug]);
        
        $exhibition = \App\Models\Exhibition::query()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
            ])
            ->where('slug', $slug)
            ->first();

        if (!$exhibition) {
            $exhibition = \App\Models\Exhibition::query()
                ->with([
                    'boothBookings' => fn ($query) => $query
                        ->with(['boothProfile', 'boothBranding', 'company', 'boothProducts', 'boothCatalogues', 'boothSessions'])
                        ->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->where('admin_status', 'approved')
                        ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
                ])
                ->where('id', $slug)
                ->first();
        }

        if (!$exhibition) {
            abort(404);
        }

        $boothSponsors = \App\Models\BoothBooking::query()
            ->with(['company', 'boothProfile', 'boothSize'])
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
            ->get();

        if ($boothSponsors->isNotEmpty()) {
            $sponsors = $boothSponsors->map(function ($booking) {
                $companyName = $booking->boothProfile?->company_name 
                    ?: ($booking->company?->company_name 
                    ?: ($booking->company?->name 
                    ?: ''));

                $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');
                $logoUrl = $logo ? (str_starts_with($logo, 'http') ? $logo : (str_starts_with($logo, 'storage/') ? asset($logo) : asset('storage/' . $logo))) : null;

                $price = (float) $booking->amount;
                if ($price >= 2000) {
                    $level = 'Platinum';
                } elseif ($price >= 1000) {
                    $level = 'Gold';
                } else {
                    $level = 'Silver';
                }

                return (object) [
                    'id' => $booking->id,
                    'name' => $companyName,
                    'logo_url' => $logoUrl,
                    'level' => $level,
                ];
            });
        } else {
            $sponsors = \App\Models\Sponsor::where('exhibition_id', $exhibition->id)->get();
        }

        $boothTeamMembers = \App\Models\BoothTeamMember::whereHas('boothBooking', function ($query) use ($exhibition) {
            $query->where('exhibition_id', $exhibition->id)
                  ->where('payment_status', 'paid')
                  ->whereIn('booking_status', ['confirmed', 'active'])
                  ->where('admin_status', 'approved')
                  ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
        })->where('status', 'active')->with(['company', 'boothBooking.boothProfile'])->get();

        if ($boothTeamMembers->isNotEmpty()) {
            $speakers = $boothTeamMembers->map(function ($member) {
                $companyName = $member->company?->company_name 
                    ?: ($member->company?->name 
                    ?: ($member->boothBooking?->boothProfile?->company_name 
                    ?: ''));

                $avatarUrl = $member->photo 
                    ? asset('storage/' . $member->photo) 
                    : null;

                $bio = $member->expertise_tags 
                    ? 'Expertise: ' . implode(', ', $member->expertise_tags)
                    : 'Representative of ' . $companyName;

                return (object) [
                    'id' => $member->id,
                    'name' => $member->name,
                    'title' => $member->designation,
                    'company' => $companyName,
                    'avatar_url' => $avatarUrl,
                    'bio' => $bio,
                ];
            });
        } else {
            $speakers = \App\Models\Speaker::where('exhibition_id', $exhibition->id)->get();
        }
        $faqs = \App\Models\Faq::where('exhibition_id', $exhibition->id)->get();

        $boothSessions = \App\Models\BoothSession::whereHas('boothBooking', function ($query) use ($exhibition) {
            $query->where('exhibition_id', $exhibition->id)
                  ->where('payment_status', 'paid')
                  ->whereIn('booking_status', ['confirmed', 'active'])
                  ->where('admin_status', 'approved')
                  ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
        })->where('status', 'upcoming')->with(['teamMember'])->get();

        if ($boothSessions->isNotEmpty()) {
            $agenda = $boothSessions->map(function ($session) {
                $startTime = $session->start_time 
                    ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') 
                    : '';

                $dateStr = $session->session_date 
                    ? ($session->session_date instanceof \DateTimeInterface 
                        ? $session->session_date->format('M d, Y') 
                        : \Carbon\Carbon::parse($session->session_date)->format('M d, Y')) 
                    : 'Date TBD';

                return (object) [
                    'id' => $session->id,
                    'start_time' => $startTime,
                    'date' => $dateStr,
                    'title' => $session->title,
                    'description' => $session->description,
                    'speaker_name' => $session->teamMember?->name,
                ];
            });
        } else {
            $agenda = \App\Models\AgendaSession::where('exhibition_id', $exhibition->id)->get();
        }

        return view('frontend.exhibitions.show', compact('exhibition', 'slug', 'sponsors', 'speakers', 'faqs', 'agenda'));
    })->name('show');

});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    })->name('home');

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.store');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    foreach (['events', 'exhibitions', 'pavilions', 'halls', 'booths', 'companies', 'users', 'sponsors', 'news'] as $module) {
        Route::prefix($module)->name($module . '.')->group(function () use ($module) {
            Route::get('/', function () use ($module) {
                return view('admin.' . $module . '.index');
            })->name('index');

            Route::get('/create', function () use ($module) {
                return view('admin.' . $module . '.create');
            })->name('create');

            Route::get('/{id}/edit', function ($id) use ($module) {
                return view('admin.' . $module . '.edit', compact('id'));
            })->name('edit');

            Route::get('/{id}', function ($id) use ($module) {
                return view('admin.' . $module . '.show', compact('id'));
            })->name('show');
        });
    }

    foreach (['event-tickets', 'exhibition-tickets', 'payments', 'enquiries', 'meetings'] as $module) {
        Route::prefix($module)->name($module . '.')->group(function () use ($module) {
            Route::get('/', function () use ($module) {
                return view('admin.' . $module . '.index');
            })->name('index');

            Route::get('/{id}', function ($id) use ($module) {
                return view('admin.' . $module . '.show', compact('id'));
            })->name('show');
        });
    }

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', function () {
            return view('admin.gallery.index');
        })->name('index');

        Route::get('/create', function () {
            return view('admin.gallery.create');
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('admin.gallery.edit', compact('id'));
        })->name('edit');
    });

    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reports.index');

    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');

    Route::prefix('booth-approvals')->name('booth-approvals.')->group(function () {
        Route::get('/', [BoothApprovalController::class, 'index'])->name('index');
        Route::get('/{publishRequest}', [BoothApprovalController::class, 'show'])->name('show');
        Route::post('/{publishRequest}/approve', [BoothApprovalController::class, 'approve'])->name('approve');
        Route::post('/{publishRequest}/reject', [BoothApprovalController::class, 'reject'])->name('reject');
    });

    Route::prefix('event-approvals')->name('event-approvals.')->group(function () {
        Route::get('/', [EventApprovalController::class, 'index'])->name('index');
        Route::get('/{publishRequest}', [EventApprovalController::class, 'show'])->name('show');
        Route::post('/{publishRequest}/approve', [EventApprovalController::class, 'approve'])->name('approve');
        Route::post('/{publishRequest}/reject', [EventApprovalController::class, 'reject'])->name('reject');
    });

    Route::prefix('booth-bookings')->name('booth-bookings.')->group(function () {
        Route::get('/', [AdminBoothBookingController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminBoothBookingController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminBoothBookingController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminBoothBookingController::class, 'reject'])->name('reject');
    });

    }); // End admin middleware group

});

Route::prefix('company')->name('company.')->group(function () {

    Route::get('/', function () {
        return session()->has('company_id')
            ? redirect('/company/dashboard')
            : redirect('/company/login');
    })->name('home');

    Route::get('/login', [CompanyAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CompanyAuthController::class, 'login'])->name('login.store');
    Route::get('/event-company/login', [CompanyAuthController::class, 'showEventCompanyLogin'])->name('event-company.login');
    Route::post('/event-company/login', [CompanyAuthController::class, 'loginEventCompany'])->name('event-company.login.store');
    Route::get('/register', [CompanyAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CompanyAuthController::class, 'register'])->name('register.store');
    Route::post('/logout', [CompanyAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-data', [CompanyDashboardController::class, 'data'])->middleware('company')->name('dashboard.data');

    Route::prefix('event-company-flow')->name('event-company-flow.')->middleware('company')->group(function () {
        Route::get('/', function () {
            return redirect()->route('company.event-company-flow.dashboard');
        })->name('home');

        Route::get('/dashboard', CompanyEventDashboardController::class)->name('dashboard');
        Route::get('/create', [CompanyEventDraftController::class, 'create'])->name('create');
        Route::post('/create', [CompanyEventDraftController::class, 'store'])->name('create.store');
        Route::get('/basic-details/{companyEvent?}', [CompanyEventDraftController::class, 'basic'])->name('basic');
        Route::post('/basic-details/{companyEvent?}', [CompanyEventDraftController::class, 'updateBasic'])->name('basic.update');
        Route::get('/branding/{companyEvent?}', [CompanyEventBrandingController::class, 'edit'])->name('branding');
        Route::post('/branding/{companyEvent?}', [CompanyEventBrandingController::class, 'update'])->name('branding.update');
        Route::get('/ticket-setup/{companyEvent?}', [CompanyEventTicketTypeController::class, 'index'])->name('tickets');
        Route::post('/ticket-setup/{companyEvent?}', [CompanyEventTicketTypeController::class, 'store'])->name('tickets.store');
        Route::post('/ticket-setup/{companyEvent?}/settings', [CompanyEventTicketTypeController::class, 'updateSettings'])->name('tickets.settings.update');
        Route::put('/{companyEvent}/ticket-types/{ticketType}', [CompanyEventTicketTypeController::class, 'update'])->name('tickets.update');
        Route::delete('/{companyEvent}/ticket-types/{ticketType}', [CompanyEventTicketTypeController::class, 'destroy'])->name('tickets.destroy');
        Route::get('/preview/{companyEvent?}', [CompanyEventPreviewController::class, 'show'])->name('preview');
        Route::get('/submit-review/{companyEvent?}', [CompanyEventSubmitReviewController::class, 'show'])->name('submit');
        Route::post('/submit-review/{companyEvent?}', [CompanyEventSubmitReviewController::class, 'submit'])->name('submit.store');
        Route::get('/payment/{companyEvent}', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{companyEvent}/razorpay-order', [PaymentController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
        Route::post('/payment/{companyEvent}/verify', [PaymentController::class, 'pay'])->name('payment.verify');
        Route::post('/payment/{companyEvent}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    });


    Route::prefix('event-flow')->name('event-flow.')->middleware('company')->group(function () {
        Route::get('/{path?}', function (?string $path = null) {
            return redirect('/company/event-company-flow' . ($path ? '/' . $path : ''));
        })->where('path', '.*')->name('legacy');
    });

    Route::get('/analytics', function () {
        return view('company.analytics');
    })->name('analytics');

    Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [CompanyProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', function () {
        return view('company.settings');
    })->name('settings');

    Route::prefix('exhibitions')->name('exhibitions.')->group(function () {
        Route::get('/', [CompanyExhibitionController::class, 'index'])->name('index');
        Route::get('/{slug}', [CompanyExhibitionController::class, 'show'])->name('show');
    });

    Route::prefix('booth-booking')->name('booth-booking.')->group(function () {
        Route::get('/pavilions', [CompanyBoothBookingController::class, 'pavilions'])->name('pavilions');

        Route::get('/halls', [CompanyBoothBookingController::class, 'halls'])->name('halls');

        Route::get('/floor-plan', [CompanyBoothBookingController::class, 'floorPlan'])->name('floor-plan');
        Route::post('/floor-plan/select', [CompanyBoothBookingController::class, 'selectBooth'])->name('floor-plan.select');

        Route::get('/sizes', [CompanyBoothBookingController::class, 'sizes'])->name('sizes');
        Route::post('/sizes/select', [CompanyBoothBookingController::class, 'selectSize'])->name('sizes.select');
        Route::post('/sizes/continue', [CompanyBoothBookingController::class, 'continueFromSizes'])->name('sizes.continue');
        Route::post('/sizes/custom', [CompanyBoothBookingController::class, 'requestCustomSize'])->name('sizes.custom');

        Route::get('/slots', [CompanyBoothBookingController::class, 'slots'])->name('slots');
        Route::post('/slots/days', [CompanyBoothBookingController::class, 'updateDays'])->name('slots.days');
        Route::post('/slots/select', [CompanyBoothBookingController::class, 'selectSlot'])->name('slots.select');
        Route::post('/slots/continue', [CompanyBoothBookingController::class, 'continueFromSlots'])->name('slots.continue');
        Route::post('/slots/custom', [CompanyBoothBookingController::class, 'requestCustomSlot'])->name('slots.custom');

        Route::get('/customize', function () {
            return view('company.booth-booking.customize');
        })->name('customize');

        Route::get('/summary', [CompanyBoothBookingController::class, 'summary'])->name('summary');

        Route::get('/services', [CompanyBoothBookingController::class, 'services'])->name('services');
        Route::post('/services/toggle', [CompanyBoothBookingController::class, 'toggleService'])->name('services.toggle');
        Route::post('/services/quantity', [CompanyBoothBookingController::class, 'updateServiceQuantity'])->name('services.quantity');
        Route::post('/services/continue', [CompanyBoothBookingController::class, 'continueFromServices'])->name('services.continue');

        Route::get('/review', [CompanyBoothBookingController::class, 'review'])->name('review');

        Route::get('/payment', [CompanyBoothBookingController::class, 'payment'])->name('payment');
        Route::get('/payment/summary', [CompanyBoothBookingController::class, 'paymentSummary'])->name('payment.summary');
        Route::post('/payment/razorpay-order', [CompanyBoothBookingController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
        Route::post('/payment/verify', [CompanyBoothBookingController::class, 'verifyRazorpayPayment'])->name('payment.verify');
        Route::post('/payment/continue', [CompanyBoothBookingController::class, 'continueAfterPayment'])->name('payment.continue');

        Route::get('/confirmed', [CompanyBoothBookingController::class, 'confirmed'])->name('confirmed');
    });

    Route::prefix('bookings')->name('bookings.')->middleware('company')->group(function () {
        Route::get('/', function () {
            $bookings = BoothBooking::with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
                ->where('company_id', (int) session('company_id'))
                ->latest()
                ->get();

            return view('company.bookings.index', compact('bookings'));
        })->name('index');

        Route::get('/{booking}', [BookingDetailsController::class, 'show'])->name('show');
    });

    $latestSetupRedirect = function (string $path = '') {
        $booking = BoothBooking::where('company_id', (int) session('company_id'))
            ->where('payment_status', 'paid')
            ->where('booking_status', 'confirmed')
            ->latest()
            ->first();

        if (! $booking) {
            return redirect('/company/booth-booking/pavilions')
                ->with('status', 'Please book and pay for a booth before starting booth setup.');
        }

        return redirect('/company/bookings/' . $booking->id . '/setup' . $path);
    };

    Route::prefix('booth-setup')->middleware('company')->group(function () use ($latestSetupRedirect) {
        Route::get('/', fn () => $latestSetupRedirect())->name('booth-setup.legacy');
        Route::get('/company-profile', fn () => $latestSetupRedirect('/profile'))->name('booth-setup.legacy.profile');
        Route::get('/branding', fn () => $latestSetupRedirect('/branding'))->name('booth-setup.legacy.branding');
        Route::get('/products', fn () => $latestSetupRedirect('/products'))->name('booth-setup.legacy.products');
        Route::get('/documents', fn () => $latestSetupRedirect('/documents'))->name('booth-setup.legacy.documents');
        Route::get('/catalogues', fn () => $latestSetupRedirect('/catalogues'))->name('booth-setup.legacy.catalogues');
        Route::get('/media', fn () => $latestSetupRedirect('/media'))->name('booth-setup.legacy.media');
        Route::get('/team', fn () => $latestSetupRedirect('/team-members'))->name('booth-setup.legacy.team');
        Route::get('/meetings', fn () => $latestSetupRedirect('/meetings'))->name('booth-setup.legacy.meetings');
        Route::get('/sessions', fn () => $latestSetupRedirect('/sessions'))->name('booth-setup.legacy.sessions');
        Route::get('/preview', fn () => $latestSetupRedirect('/preview'))->name('booth-setup.legacy.preview');
        Route::get('/publish', fn () => $latestSetupRedirect('/publish'))->name('booth-setup.legacy.publish');
        Route::get('/analytics', fn () => $latestSetupRedirect('/analytics'))->name('booth-setup.legacy.analytics');
    });

    Route::prefix('bookings/{booking}/setup')->name('booth-setup.')->middleware('company')->group(function () {
        Route::get('/', [BoothSetupController::class, 'index'])->name('index');
        Route::get('/profile', [BoothProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [BoothProfileController::class, 'update'])->name('profile.update');
        Route::get('/branding', [BoothBrandingController::class, 'edit'])->name('branding.edit');
        Route::post('/branding', [BoothBrandingController::class, 'update'])->name('branding.update');
        Route::resource('/products', BoothProductController::class)->names('products');
        Route::resource('/documents', BoothDocumentController::class)->names('documents');
        Route::resource('/catalogues', BoothCatalogueController::class)->names('catalogues');
        Route::resource('/media', BoothMediaController::class)->parameters(['media' => 'medium'])->names('media');
        Route::resource('/team-members', BoothTeamMemberController::class)->parameters(['team-members' => 'teamMember'])->names('team-members');
        Route::get('/meetings', [BoothMeetingAvailabilityController::class, 'edit'])->name('meetings.edit');
        Route::post('/meetings', [BoothMeetingAvailabilityController::class, 'update'])->name('meetings.update');
        Route::resource('/sessions', BoothSessionController::class)->names('sessions');
        Route::get('/preview', [BoothPreviewController::class, 'show'])->name('preview');
        Route::post('/preview/mark-ready', [BoothPreviewController::class, 'markReady'])->name('preview.mark-ready');
        Route::get('/publish', [BoothPublishController::class, 'show'])->name('publish.show');
        Route::post('/publish', [BoothPublishController::class, 'submit'])->name('publish.submit');
        Route::get('/analytics', [BoothAnalyticsController::class, 'index'])->name('analytics');
    });

    foreach (['products', 'documents', 'catalogues', 'media'] as $module) {
        Route::prefix($module)->name($module . '.')->group(function () use ($module) {
            Route::get('/', function () use ($module) {
                return view('company.' . $module . '.index');
            })->name('index');

            Route::get('/create', function () use ($module) {
                return view('company.' . $module . '.create');
            })->name('create');

            Route::get('/{id}/edit', function ($id) use ($module) {
                return view('company.' . $module . '.edit', compact('id'));
            })->name('edit');

            Route::get('/{id}', function ($id) use ($module) {
                return view('company.' . $module . '.show', compact('id'));
            })->name('show');
        });
    }

    Route::prefix('enquiries')->name('enquiries.')->group(function () {
        Route::get('/', [CompanyEnquiryController::class, 'index'])->name('index');
        Route::get('/{id}', [CompanyEnquiryController::class, 'show'])->name('show');
        Route::post('/{id}/reply', [CompanyEnquiryController::class, 'reply'])->name('reply');
    });

    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/', [CompanyMeetingController::class, 'index'])->name('index');
        Route::get('/{id}', [CompanyMeetingController::class, 'show'])->name('show');
        Route::post('/{id}/status', [CompanyMeetingController::class, 'updateStatus'])->name('status.update');
    });

});

Route::prefix('events')->name('events.')->group(function () {

    Route::get('/', function () {
        $websiteEventStatuses = ['published', 'pending_review', 'submitted', 'draft'];

        $publishedEvents = \App\Models\CompanyEvent\CompanyEvent::with(['branding', 'ticketTypes'])
            ->whereIn('status', $websiteEventStatuses)
            ->latest('updated_at')
            ->take(6)
            ->get();

        $events = $publishedEvents->map(function ($event) {
            $startsAt = $event->starts_at;
            $endsAt = $event->ends_at;
            $minTicket = $event->ticketTypes->sortBy('price')->first();
            $isLive = $startsAt && $startsAt->isPast() && (! $endsAt || $endsAt->isFuture());

            if ($isLive) {
                $badge = 'Live Now';
                $badgeClass = 'bg-[#D7194A] text-white';
            } elseif ($startsAt && $startsAt->isToday()) {
                $badge = 'Today';
                $badgeClass = 'bg-[#F36F21] text-white';
            } elseif ($startsAt && $startsAt->isTomorrow()) {
                $badge = 'Tomorrow';
                $badgeClass = 'bg-[#FFF2DF] text-[#C46F10]';
            } else {
                $badge = 'Upcoming';
                $badgeClass = 'bg-[#EEF2FF] text-[#3730A3]';
            }

            return [
                'slug' => $event->slug,
                'badge' => $badge,
                'badgeClass' => $badgeClass,
                'imageUrl' => $event->branding?->banner_path
                    ? asset('storage/' . $event->branding->banner_path)
                    : asset('images/events-home/trending/global-tech-summit.svg'),
                'title' => $event->title,
                'date' => $startsAt
                    ? $startsAt->format('M d') . ($endsAt ? ' - ' . $endsAt->format('d, Y') : $startsAt->format(', Y'))
                    : 'Date TBD',
                'country' => $event->country ?: ($event->city ?: 'Online'),
                'type' => ucfirst(str_replace('_', ' ', $event->event_mode ?: $event->event_type ?: 'Event')),
                'price' => $minTicket
                    ? (($minTicket->currency ?: 'INR') . ' ' . number_format((float) $minTicket->price, 0))
                    : 'Free',
            ];
        })->values()->all();

        $categoryIcons = [
            'technology' => 'technology.svg',
            'business' => 'business.svg',
            'education' => 'education.svg',
            'healthcare' => 'healthcare.svg',
            'marketing' => 'marketing.svg',
            'design' => 'design.svg',
            'finance' => 'finance.svg',
            'lifestyle' => 'lifestyle.svg',
        ];

        $categories = \App\Models\CompanyEvent\CompanyEvent::query()
            ->whereIn('status', $websiteEventStatuses)
            ->whereNotNull('category')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(8)
            ->get()
            ->map(function ($row) use ($categoryIcons) {
                $key = \Illuminate\Support\Str::slug($row->category);

                return [
                    'icon' => $categoryIcons[$key] ?? 'business.svg',
                    'name' => ucfirst(str_replace('_', ' ', $row->category)),
                    'value' => $row->category,
                    'count' => $row->total . ' ' . \Illuminate\Support\Str::plural('Event', $row->total),
                ];
            })->values()->all();

        $flagMap = [
            'United States' => 'us.svg',
            'USA' => 'us.svg',
            'United Kingdom' => 'uk.svg',
            'UK' => 'uk.svg',
            'India' => 'in.svg',
            'Canada' => 'ca.svg',
            'Australia' => 'au.svg',
            'Germany' => 'de.svg',
            'Singapore' => 'sg.svg',
            'UAE' => 'ae.svg',
        ];

        $countries = \App\Models\CompanyEvent\CompanyEvent::query()
            ->whereIn('status', $websiteEventStatuses)
            ->whereNotNull('country')
            ->selectRaw('country, count(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->take(8)
            ->get()
            ->map(fn ($row) => [
                'flag' => $flagMap[$row->country] ?? 'in.svg',
                'name' => $row->country,
                'count' => $row->total . ' ' . \Illuminate\Support\Str::plural('Event', $row->total),
            ])->values()->all();

        $tickets = auth()->check()
            ? \App\Models\VisitorTicket::with('companyEvent')
                ->where('user_id', auth()->id())
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($ticket) {
                    $event = $ticket->companyEvent;

                    return [
                        'imageUrl' => asset('images/events-home/trending/global-tech-summit.svg'),
                        'title' => $event?->title ?? 'Event Ticket',
                        'time' => $event?->starts_at
                            ? $event->starts_at->format('M d, Y - h:i A')
                            : 'Date TBD',
                        'type' => $ticket->ticket_name,
                        'orderId' => $ticket->order_number,
                        'status' => ucfirst($ticket->status),
                        'href' => url('/user/tickets/' . $ticket->id . '/e-ticket'),
                    ];
                })->values()->all()
            : [];

        $slots = $publishedEvents
            ->filter(fn ($event) => filled($event->starts_at))
            ->take(5)
            ->map(function ($event) {
                $minTicket = $event->ticketTypes->sortBy('price')->first();
                $sold = $event->ticketTypes->sum('quantity_sold');
                $capacity = $event->capacity ?: $event->ticketTypes->sum('quantity_total');
                $seatsLeft = $capacity ? max(0, $capacity - $sold) : null;

                return [
                    'time' => $event->starts_at->format('M d, h:i A') . ($event->ends_at ? ' - ' . $event->ends_at->format('h:i A') : ''),
                    'seats' => $seatsLeft !== null ? $seatsLeft . ' Seats Left' : 'Seats Available',
                    'price' => $minTicket ? (($minTicket->currency ?: 'INR') . ' ' . number_format((float) $minTicket->price, 0)) : 'Free',
                    'href' => url('/events/tickets/select?event=' . $event->slug),
                ];
            })->values()->all();

        $sampleEvent = $publishedEvents->first();
        $sampleTicket = $sampleEvent ? [
            'title' => $sampleEvent->title,
            'date' => $sampleEvent->starts_at?->format('M d, Y') ?? 'Date TBD',
            'time' => $sampleEvent->starts_at
                ? $sampleEvent->starts_at->format('h:i A') . ($sampleEvent->ends_at ? ' - ' . $sampleEvent->ends_at->format('h:i A') : '')
                : 'Time TBD',
            'type' => ucfirst(str_replace('_', ' ', $sampleEvent->event_mode ?: $sampleEvent->event_type ?: 'Event')),
            'holder' => auth()->user()->name ?? 'Visitor',
            'orderId' => 'PREVIEW-' . strtoupper($sampleEvent->slug),
            'qrData' => 'PREVIEW|' . $sampleEvent->slug . '|' . (auth()->user()->email ?? 'visitor'),
        ] : null;

        return view('frontend.events.home', compact('events', 'categories', 'countries', 'tickets', 'slots', 'sampleTicket'));
    })->name('home');





    Route::get('/listings', function (\Illuminate\Http\Request $request) {
        $websiteEventStatuses = ['published', 'pending_review', 'submitted', 'draft'];

        $dbEvents = \App\Models\CompanyEvent\CompanyEvent::with('branding')
            ->whereIn('status', $websiteEventStatuses)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')->toString()))
            ->when($request->filled('country'), fn ($query) => $query->where('country', $request->string('country')->toString()))
            ->when($request->filled('date'), fn ($query) => $query->whereDate('starts_at', $request->input('date')))
            ->latest('updated_at')
            ->get();

        $categories = \App\Models\CompanyEvent\CompanyEvent::query()
            ->whereIn('status', $websiteEventStatuses)
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $countries = \App\Models\CompanyEvent\CompanyEvent::query()
            ->whereIn('status', $websiteEventStatuses)
            ->whereNotNull('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        return view('frontend.events.listings.index', compact('dbEvents', 'categories', 'countries'));
    })->name('listings.index');

    Route::get('/listings/{slug}', function ($slug) {
        $websiteEventStatuses = ['published', 'pending_review', 'submitted', 'draft'];

        $dbEvent = \App\Models\CompanyEvent\CompanyEvent::with([
            'branding',
            'ticketTypes' => fn ($query) => $query->orderBy('price'),
            'sessions' => fn ($query) => $query->orderBy('starts_at'),
            'speakers' => fn ($query) => $query->orderBy('name'),
            'company',
        ])
            ->where('slug', $slug)
            ->whereIn('status', $websiteEventStatuses)
            ->first();

        if ($dbEvent) {
            return view('frontend.events.listings.show', compact('dbEvent'));
        }

        // Fallback for static events
        $staticSlugs = [
            'global-tech-summit-2024',
            'future-of-ai-expo',
            'sustainability-forum',
            'healthcare-innovation-summit',
            'world-ai-conference-2024',
            'digital-marketing-summit',
            'healthcare-innovation-2024',
            'future-of-education-summit',
            'sustainability-forum-2024'
        ];

        if (in_array($slug, $staticSlugs)) {
            return view('frontend.events.listings.show', compact('slug'));
        }

        abort(404);
    })->name('listings.show');

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/my_bookings.html', function () {
            return redirect('/exhibitions/booking/my-bookings');
        })->name('legacy-my-bookings');

        Route::get('/select', function (\Illuminate\Http\Request $request) {
            $slug = $request->query('event');
            $dbEvent = null;
            if ($slug) {
                $dbEvent = \App\Models\CompanyEvent\CompanyEvent::with('ticketTypes')
                    ->where('slug', $slug)
                    ->whereIn('status', ['published', 'pending_review', 'submitted', 'draft'])
                    ->first();
            }
            return view('frontend.events.tickets.select', compact('dbEvent', 'slug'));
        })->name('select');

        Route::middleware('auth')->group(function () {
            Route::get('/attendee-details', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'attendeeDetails'])->name('attendee-details');
            
            Route::get('/summary', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'summary'])->name('summary');
            
            Route::get('/payment', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'payment'])->name('payment');
            Route::post('/payment/razorpay-order', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
            Route::post('/payment/verify', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'confirmPayment'])->name('payment.verify');
            Route::post('/payment/confirm', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'confirmPayment'])->name('payment.confirm');
            
            Route::get('/confirmed', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'confirmed'])->name('confirmed');
            
            Route::get('/e-ticket', [\App\Http\Controllers\VisitorEvent\PurchaseController::class, 'eTicket'])->name('e-ticket');
            
            Route::get('/invoice', function () {
                return view('frontend.events.tickets.invoice');
            })->name('invoice');
        });
    });

    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/schedule', function () {
            return view('frontend.events.agenda.schedule');
        })->name('schedule');

        Route::get('/sessions', function () {
            return view('frontend.events.agenda.sessions');
        })->name('sessions');

        Route::get('/speakers', function () {
            return view('frontend.events.agenda.speakers');
        })->name('speakers');
    });

    Route::prefix('networking')->name('networking.')->group(function () {
        Route::get('/attendees', function () {
            return view('frontend.events.networking.attendees');
        })->name('attendees');

        Route::get('/meetings', function () {
            return view('frontend.events.networking.meetings');
        })->name('meetings');

        Route::get('/chat', function () {
            return view('frontend.events.networking.chat');
        })->name('chat');

        Route::get('/connections', function () {
            return view('frontend.events.networking.connections');
        })->name('connections');
    });

    Route::prefix('live')->name('live.')->group(function () {
        Route::get('/livestream', function () {
            return view('frontend.events.live.livestream');
        })->name('livestream');

        Route::get('/polls', function () {
            return view('frontend.events.live.polls');
        })->name('polls');

        Route::get('/qna', function () {
            return view('frontend.events.live.qna');
        })->name('qna');

        Route::get('/feedback', function () {
            return view('frontend.events.live.feedback');
        })->name('feedback');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', function () {
            return view('frontend.events.profile.index');
        })->name('index');

        Route::get('/saved-events', function () {
            return view('frontend.events.profile.saved-events');
        })->name('saved-events');

        Route::get('/my-tickets', function () {
            return view('frontend.events.profile.my-tickets');
        })->name('my-tickets');

        Route::get('/notifications', function () {
            return view('frontend.events.profile.notifications');
        })->name('notifications');

        Route::get('/settings', function () {
            return view('frontend.events.profile.settings');
        })->name('settings');
    });

});

// Redirect old HTML pages to dynamic routes
Route::get('/exhibitions.html', function () {
    return redirect('/exhibitions');
});

Route::get('/exhibition-details.html', function (\Illuminate\Http\Request $request) {
    $idOrSlug = $request->query('id');
    
    if (!$idOrSlug) {
        $idOrSlug = session('activeExhibitionSlug') ?: 'global-tech-expo-2024';
    }
    
    if (is_numeric($idOrSlug)) {
        $exhibition = \App\Models\Exhibition::find($idOrSlug);
        if ($exhibition) {
            $idOrSlug = $exhibition->slug;
        }
    }
    
    return redirect()->route('exhibitions.show', $idOrSlug);
});

Route::get('/lobby.html', function () {
    $slug = session('activeExhibitionSlug') ?: 'global-tech-expo-2024';
    return redirect()->route('exhibitions.visit', $slug);
});

Route::get('/pavallion.html', function () {
    $slug = session('activeExhibitionSlug') ?: 'global-tech-expo-2024';
    return redirect()->route('exhibitions.visitor.companies', $slug);
});

Route::get('/halls.html', function () {
    $slug = session('activeExhibitionSlug') ?: 'global-tech-expo-2024';
    return redirect()->route('exhibitions.visitor-halls.index', $slug);
});

Route::get('/my-tickets.html', function () {
    $slug = session('activeExhibitionSlug') ?: 'global-tech-expo-2024';
    return redirect()->route('exhibitions.visitor.my-passes', $slug);
});
Route::get('/{page}.html', [\App\Http\Controllers\VisitorFlow\VisitorFlowController::class, 'servePage']);
