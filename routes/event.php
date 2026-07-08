<?php

use Illuminate\Support\Facades\Route;

$eventHomeHandler = function (\App\Domain\Shared\Services\EventsHomePageData $eventsHomePageData) {
    $payload = $eventsHomePageData->build();

    return view('frontend.events.home', [
        'events' => $payload['events'],
        'categories' => $payload['categories'],
        'countries' => $payload['countries'],
        'heroSlides' => $payload['hero_slides'],
        'heroMeta' => $payload['hero_meta'],
        'tickets' => $payload['tickets'],
        'slots' => $payload['slots'],
        'sampleTicket' => $payload['sample_ticket'],
        'featuredEvent' => $payload['featured_event'],
    ]);
};

Route::get('/eventsdynamic', $eventHomeHandler)->name('events.dynamic');

Route::prefix('events')->name('events.')->group(function () use ($eventHomeHandler) {

    Route::get('/', $eventHomeHandler)->name('home');

    Route::prefix('visitor')->name('visitor.')->group(function () {
        Route::get('/login', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'showEventTicketLogin'])->name('login');
        Route::post('/login', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'login'])->name('login.store');
        Route::get('/register', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'showEventTicketRegister'])->name('register');
        Route::post('/register', [\App\Domain\Shared\Controllers\Auth\UserAuthController::class, 'register'])->name('register.store');
    });





    Route::get('/listings', function (\Illuminate\Http\Request $request) {
        if (! \App\Support\DbGuard::available()) {
            return view('frontend.events.listings.index', [
                'dbEvents' => collect(),
                'status' => 'upcoming',
                'statusCounts' => ['upcoming' => 0, 'ongoing' => 0, 'past' => 0],
                'categories' => collect(),
                'countries' => collect(['India']),
            ]);
        }

        $status = in_array($request->string('status')->toString(), ['upcoming', 'ongoing', 'past'], true)
            ? $request->string('status')->toString()
            : 'upcoming';

        $baseQuery = \App\Support\LiveContent::databaseCompanyEventsQuery()
            ->with('branding')
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
            ->when($request->filled('country') && strtolower($request->string('country')->toString()) !== 'india', fn ($query) => $query->where('country', $request->string('country')->toString()))
            ->when($status === 'upcoming', fn ($query) => $query->whereDate('starts_at', '>=', now()->toDateString()))
            ->when($status === 'ongoing', fn ($query) => $query
                ->whereDate('starts_at', '<=', now()->toDateString())
                ->where(function ($query) {
                    $query->whereNull('ends_at')
                        ->orWhereDate('ends_at', '>=', now()->toDateString());
                }))
            ->when($status === 'past', fn ($query) => $query->whereDate('ends_at', '<', now()->toDateString()))
            ->latest('updated_at');

        $dbEvents = (clone $baseQuery)
            ->latest('updated_at')
            ->get();

        $statusCounts = [
            'upcoming' => (clone \App\Support\LiveContent::databaseCompanyEventsQuery())
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
                ->when($request->filled('country') && strtolower($request->string('country')->toString()) !== 'india', fn ($query) => $query->where('country', $request->string('country')->toString()))
                ->whereDate('starts_at', '>=', now()->toDateString())
                ->count(),
            'ongoing' => (clone \App\Support\LiveContent::databaseCompanyEventsQuery())
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
                ->when($request->filled('country') && strtolower($request->string('country')->toString()) !== 'india', fn ($query) => $query->where('country', $request->string('country')->toString()))
                ->whereDate('starts_at', '<=', now()->toDateString())
                ->where(function ($query) {
                    $query->whereNull('ends_at')
                        ->orWhereDate('ends_at', '>=', now()->toDateString());
                })
                ->count(),
            'past' => (clone \App\Support\LiveContent::databaseCompanyEventsQuery())
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
                ->when($request->filled('country') && strtolower($request->string('country')->toString()) !== 'india', fn ($query) => $query->where('country', $request->string('country')->toString()))
                ->whereDate('ends_at', '<', now()->toDateString())
                ->count(),
        ];

        $categories = \App\Support\LiveContent::databaseCompanyEventsQuery()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $countries = collect(['India']);

        return view('frontend.events.listings.index', compact('dbEvents', 'categories', 'countries', 'status', 'statusCounts'));
    })->name('listings.index');

    Route::get('/listings/categories', function () {
        $categories = \App\Support\DbGuard::whenAvailable(fn () => \App\Support\LiveContent::databaseCompanyEventsQuery()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->map(fn ($row) => [
                'name' => ucfirst(str_replace('_', ' ', $row->category)),
                'value' => $row->category,
                'total' => (int) $row->total,
            ])
            ->values(), collect());

        return view('frontend.events.listings.categories', compact('categories'));
    })->name('listings.categories');

    Route::get('/listings/search', function () {
        return view('frontend.events.listings.search');
    })->name('listings.search');
    Route::get('/listings/{slug}', function ($slug) {
        $pageData = app(\App\Domain\Shared\Services\EventListingShowPageData::class)->build($slug);

        if ($pageData === null) {
            abort(404);
        }

        return view('frontend.events.listings.show', $pageData);
    })->name('listings.show');

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/my_bookings.html', function () {
            return redirect('/exhibitions/booking/my-bookings');
        })->name('legacy-my-bookings');

        Route::get('/select', function (\Illuminate\Http\Request $request) {
            $slug = $request->query('event');

            session([
                'event_booking_path' => \App\Support\EventTicketFlow::visitorPassEntryUrl($slug),
                'user_flow_context' => 'event_ticket',
            ]);

            if (auth()->check()) {
                return \App\Support\EventTicketFlow::redirectAuthenticatedVisitor($slug)
                    ?? redirect()->route('events.tickets.attendee-details', ['event' => $slug]);
            }

            return redirect()->route('events.tickets.visitor-details', ['event' => $slug]);
        })->name('select');

        Route::get('/visitor-details', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'visitorDetails'])->name('visitor-details');
        Route::post('/visitor-details', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'storeVisitorDetails'])->name('visitor-details.store');

        Route::get('/attendee-details', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'attendeeDetails'])->name('attendee-details');
        Route::get('/summary', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'summary'])->name('summary');
        Route::get('/payment', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'payment'])->name('payment');
        Route::post('/payment/razorpay-order', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
        Route::post('/payment/verify', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.verify');
        Route::post('/payment/confirm', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.confirm');
        Route::get('/confirmed', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmed'])->name('confirmed');
        Route::get('/e-ticket', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'eTicket'])->name('e-ticket');
        Route::post('/send-ticket-email', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'sendTicketEmail'])->name('send-ticket-email');
        Route::get('/invoice', function () {
            return view('frontend.events.tickets.invoice');
        })->name('invoice');
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

    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect()->route('frontend.user.dashboard');
        })->name('index');

        Route::get('/saved-events', function () {
            return view('frontend.events.profile.saved-events');
        })->name('saved-events');

        Route::get('/my-tickets', function () {
            return redirect()->route('frontend.user.passes');
        })->name('my-tickets');
        Route::get('/settings', function () {
            return view('frontend.events.profile.settings');
        })->name('settings');
    });

});


