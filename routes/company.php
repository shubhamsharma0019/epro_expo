<?php

use App\Domain\Shared\Controllers\Auth\CompanyAuthController;
use App\Domain\Booth\Controllers\BookingDetailsController;
use App\Domain\Booth\Controllers\BoothAnalyticsController;
use App\Domain\Booth\Controllers\BoothBrandingController;
use App\Domain\Booth\Controllers\BoothCatalogueController;
use App\Domain\Booth\Controllers\BoothDocumentController;
use App\Domain\Booth\Controllers\BoothMediaController;
use App\Domain\Booth\Controllers\BoothMeetingAvailabilityController;
use App\Domain\Booth\Controllers\BoothPreviewController;
use App\Domain\Booth\Controllers\BoothProductController;
use App\Domain\Booth\Controllers\BoothProfileController;
use App\Domain\Booth\Controllers\BoothPublishController;
use App\Domain\Booth\Controllers\BoothSessionController;
use App\Domain\Booth\Controllers\BoothSetupController;
use App\Domain\Booth\Controllers\BoothTeamMemberController;
use App\Domain\Company\Controllers\CompanyBoothBookingController;
use App\Domain\Company\Controllers\CompanyDashboardController;
use App\Domain\Company\Controllers\CompanyEnquiryController;
use App\Domain\Company\Controllers\CompanyExhibitionController;
use App\Domain\Company\Controllers\CompanyMeetingController;
use App\Domain\Company\Controllers\CompanyProfileController;
use App\Domain\Company\Services\CompanyNotificationService;
use App\Domain\Event\Controllers\BrandingController as CompanyEventBrandingController;
use App\Domain\Event\Controllers\DashboardController as CompanyEventDashboardController;
use App\Domain\Event\Controllers\EventDraftController as CompanyEventDraftController;
use App\Domain\Event\Controllers\PaymentController;
use App\Domain\Event\Controllers\PreviewController as CompanyEventPreviewController;
use App\Domain\Event\Controllers\SubmitReviewController as CompanyEventSubmitReviewController;
use App\Domain\Event\Controllers\TicketTypeController as CompanyEventTicketTypeController;
use App\Domain\Booth\Models\BoothBooking;
use Illuminate\Support\Facades\Route;

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
    Route::get('/event-company/register', [CompanyAuthController::class, 'showEventCompanyRegister'])->name('event-company.register');
    Route::post('/event-company/register', [CompanyAuthController::class, 'register'])->name('event-company.register.store');
    Route::get('/register', [CompanyAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CompanyAuthController::class, 'register'])->name('register.store');
    Route::match(['GET', 'POST'], '/logout', [CompanyAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->middleware('company')->name('dashboard');
    Route::get('/dashboard-data', [CompanyDashboardController::class, 'data'])->middleware('company')->name('dashboard.data');

    Route::prefix('event-company-flow')->name('event-company-flow.')->middleware(['company', 'company.event'])->group(function () {
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

    Route::get('/analytics', [CompanyDashboardController::class, 'analytics'])->middleware('company')->name('analytics');

    Route::get('/payments-invoices', function () {
        $booking = BoothBooking::where('company_id', (int) session('company_id'))
            ->where('payment_status', 'paid')
            ->latest()
            ->first();

        return $booking
            ? redirect()->route('company.bookings.invoice', $booking)
            : redirect()->route('company.bookings.index');
    })->middleware('company')->name('payments-invoices');

    Route::get('/notifications', function (CompanyNotificationService $notifications) {
        $company = \App\Domain\Company\Models\Company::find((int) session('company_id'));

        if (! $company) {
            return redirect('/company/login');
        }

        $notifications->markAsSeen($company);
        $items = $notifications->forCompany($company);

        return view('company.notifications.notification-list', [
            'company' => $company,
            'notifications' => $items,
        ]);
    })->middleware('company')->name('notifications');

    Route::get('/notifications/unread-count', function (CompanyNotificationService $notifications) {
        $company = \App\Domain\Company\Models\Company::find((int) session('company_id'));

        return response()->json([
            'count' => $company ? $notifications->unreadCount($company) : 0,
        ]);
    })->middleware('company')->name('notifications.unread-count');

    Route::get('/profile', [CompanyProfileController::class, 'edit'])->middleware('company')->name('profile');
    Route::post('/profile', [CompanyProfileController::class, 'update'])->middleware('company')->name('profile.update');

    Route::get('/settings', function () {
        return view('company.settings.company-settings');
    })->middleware('company')->name('settings');

    Route::prefix('exhibitions')->name('exhibitions.')->middleware('company')->group(function () {
        Route::get('/', [CompanyExhibitionController::class, 'index'])->name('index');
        Route::get('/{slug}', [CompanyExhibitionController::class, 'show'])->name('show');
    });

    Route::prefix('booth-booking')->name('booth-booking.')->middleware('company')->group(function () {
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

        Route::get('/customize', [CompanyBoothBookingController::class, 'customize'])->name('customize');

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
        Route::get('/', function (\Illuminate\Http\Request $request) {
            $activeStatus = in_array($request->query('status', 'all'), ['all', 'upcoming', 'completed', 'cancelled'], true)
                ? $request->query('status', 'all')
                : 'all';
            $search = trim((string) $request->query('search', ''));

            $allBookings = BoothBooking::with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
                ->where('company_id', (int) session('company_id'))
                ->latest()
                ->get();

            $bookings = $allBookings
                ->filter(function (BoothBooking $booking) use ($activeStatus) {
                    $startDate = $booking->exhibition?->start_date;
                    $endDate = $booking->exhibition?->end_date;
                    $isCancelled = $booking->booking_status === 'cancelled' || $booking->admin_status === 'rejected';

                    return match ($activeStatus) {
                        'upcoming' => $startDate && $startDate->isFuture() && ! $isCancelled,
                        'completed' => $endDate && $endDate->isPast() && ! $isCancelled,
                        'cancelled' => $isCancelled,
                        default => true,
                    };
                })
                ->filter(function (BoothBooking $booking) use ($search) {
                    if ($search === '') {
                        return true;
                    }

                    $haystack = collect([
                        'BOOK-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                        $booking->exhibition?->title,
                        $booking->pavilion?->title,
                        $booking->hall?->title,
                        $booking->booth?->booth_number,
                        $booking->boothSize?->title,
                    ])->filter()->implode(' ');

                    return str_contains(strtolower($haystack), strtolower($search));
                })
                ->values();

            return view('company.bookings.my-bookings', compact('bookings', 'allBookings', 'activeStatus', 'search'));
        })->name('index');

        Route::get('/{booking}', [BookingDetailsController::class, 'show'])->name('show');
        Route::get('/{booking}/invoice', [BookingDetailsController::class, 'invoice'])->name('invoice');
    });

    $latestSetupRedirect = function (string $path = '') {
        $booking = BoothBooking::where('company_id', (int) session('company_id'))
            ->where('payment_status', 'paid')
            ->where('booking_status', 'confirmed')
            ->latest()
            ->first();

        if (! $booking) {
            return redirect('/company/exhibitions')
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
        Route::post('/sessions/meeting-setup', [BoothSessionController::class, 'updateMeetingSetup'])->name('sessions.meeting-setup.update');
        Route::resource('/sessions', BoothSessionController::class)->names('sessions');
        Route::get('/preview', [BoothPreviewController::class, 'show'])->name('preview');
        Route::post('/preview/mark-ready', [BoothPreviewController::class, 'markReady'])->name('preview.mark-ready');
        Route::get('/publish', [BoothPublishController::class, 'show'])->name('publish.show');
        Route::post('/publish', [BoothPublishController::class, 'submit'])->name('publish.submit');
        Route::get('/analytics', [BoothAnalyticsController::class, 'index'])->name('analytics');
    });

    foreach (['products', 'documents', 'catalogues', 'media'] as $module) {
        Route::prefix($module)->name($module . '.')->middleware('company')->group(function () use ($module, $latestSetupRedirect) {
            Route::get('/', fn () => $latestSetupRedirect('/' . ($module === 'media' ? 'media' : $module)))->name('index');
            Route::get('/create', fn () => $latestSetupRedirect('/' . ($module === 'media' ? 'media/create' : $module . '/create')))->name('create');
            Route::get('/{id}/edit', fn ($id) => $latestSetupRedirect('/' . ($module === 'media' ? 'media/' . $id . '/edit' : $module . '/' . $id . '/edit')))->name('edit');
            Route::get('/{id}', fn ($id) => $latestSetupRedirect('/' . ($module === 'media' ? 'media/' . $id : $module . '/' . $id)))->name('show');
        });
    }

    Route::prefix('enquiries')->name('enquiries.')->middleware('company')->group(function () {
        Route::get('/', [CompanyEnquiryController::class, 'index'])->name('index');
        Route::get('/{id}', [CompanyEnquiryController::class, 'show'])->name('show');
        Route::post('/{id}/reply', [CompanyEnquiryController::class, 'reply'])->name('reply');
    });

    Route::prefix('meetings')->name('meetings.')->middleware('company')->group(function () {
        Route::get('/', [CompanyMeetingController::class, 'index'])->name('index');
        Route::get('/{id}', [CompanyMeetingController::class, 'show'])->name('show');
        Route::post('/{id}/zoom', [CompanyMeetingController::class, 'updateZoom'])->name('zoom.update');
        Route::post('/{id}/zoom/create', [CompanyMeetingController::class, 'createZoom'])->name('zoom.create');
        Route::post('/{id}/status', [CompanyMeetingController::class, 'updateStatus'])->name('status.update');
    });

});



