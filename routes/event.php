<?php

use Illuminate\Support\Facades\Route;

$eventHomeHandler = function () {
    return \App\Support\DbGuard::whenAvailable(function () {
        $publishedEvents = \App\Support\LiveContent::databaseCompanyEventsQuery()
            ->with(['branding', 'ticketTypes'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        $eventImageUrl = function ($branding) {
            foreach ([$branding?->banner_path, $branding?->logo_path] as $path) {
                if (! filled($path)) {
                    continue;
                }

                if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) {
                    return $path;
                }

                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    return asset('storage/' . $path);
                }
            }

            return asset('images/events-home/trending/global-tech-summit.svg');
        };

        $events = $publishedEvents->map(function ($event) use ($eventImageUrl) {
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
                'imageUrl' => $eventImageUrl($event->branding),
                'title' => $event->title,
                'date' => $startsAt
                    ? $startsAt->format('M d') . ($endsAt ? ' - ' . $endsAt->format('d, Y') : $startsAt->format(', Y'))
                    : 'Date TBD',
                'country' => 'India',
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

        $categories = \App\Support\LiveContent::databaseCompanyEventsQuery()
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

        $totalCountryEvents = \App\Support\LiveContent::databaseCompanyEventsQuery()->count();
        $countries = $totalCountryEvents > 0 ? [[
            'flag' => 'in.svg',
            'name' => 'India',
            'count' => $totalCountryEvents . ' ' . \Illuminate\Support\Str::plural('Event', $totalCountryEvents),
        ]] : [];

        $tickets = auth()->check()
            ? \App\Domain\Visitor\Models\VisitorTicket::with('companyEvent')
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
    }, function () {
        return view('frontend.events.home', [
            'events' => [],
            'categories' => [],
            'countries' => [],
            'tickets' => [],
            'slots' => [],
            'sampleTicket' => null,
        ]);
    });
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

    Route::get('/listings/{slug}', function ($slug) {
        $dbEvent = \App\Support\LiveContent::companyEventPageQuery()
            ->with([
            'branding',
            'ticketTypes' => fn ($query) => $query->orderBy('price'),
            'sessions' => fn ($query) => $query->orderBy('starts_at'),
            'speakers' => fn ($query) => $query->orderBy('name'),
            'company',
        ])
            ->where('slug', $slug)
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
            if (! auth()->check()) {
                session()->put('url.intended', $request->fullUrl());
                session()->put('event_booking_path', $request->fullUrl());
                session()->put('user_flow_context', 'event_ticket');

                return redirect()->route('events.visitor.login');
            }

            $slug = $request->query('event');
            $dbEvent = null;
            if ($slug) {
                $dbEvent = \App\Support\LiveContent::companyEventQuery()
                    ->with([
                    'ticketTypes' => fn ($query) => $query->orderBy('price'),
                ])
                    ->where('slug', $slug)
                    ->first();
            }
            return view('frontend.events.tickets.select', compact('dbEvent', 'slug'));
        })->name('select');

        Route::middleware('auth')->group(function () {
            Route::get('/attendee-details', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'attendeeDetails'])->name('attendee-details');
            
            Route::get('/summary', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'summary'])->name('summary');
            
            Route::get('/payment', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'payment'])->name('payment');
            Route::post('/payment/razorpay-order', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
            Route::post('/payment/verify', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.verify');
            Route::post('/payment/confirm', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.confirm');
            
            Route::get('/confirmed', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmed'])->name('confirmed');
            
            Route::get('/e-ticket', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'eTicket'])->name('e-ticket');
            
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

            $slug = $request->query('event');
            $dbEvent = null;
            if ($slug) {
                $dbEvent = \App\Support\LiveContent::companyEventQuery()
                    ->with([
                    'ticketTypes' => fn ($query) => $query->orderBy('price'),
                ])
                    ->where('slug', $slug)
                    ->first();
            }
            return view('frontend.events.tickets.select', compact('dbEvent', 'slug'));
        })->name('select');

        Route::middleware('auth')->group(function () {
            Route::get('/attendee-details', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'attendeeDetails'])->name('attendee-details');
            
            Route::get('/summary', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'summary'])->name('summary');
            
            Route::get('/payment', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'payment'])->name('payment');
            Route::post('/payment/razorpay-order', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'createRazorpayOrder'])->name('payment.razorpay-order');
            Route::post('/payment/verify', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.verify');
            Route::post('/payment/confirm', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmPayment'])->name('payment.confirm');
            
            Route::get('/confirmed', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'confirmed'])->name('confirmed');
            
            Route::get('/e-ticket', [\App\Domain\Visitor\Controllers\PurchaseController::class, 'eTicket'])->name('e-ticket');
            
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

    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect()->route('frontend.user.dashboard');
        })->name('index');

        Route::get('/saved-events', function () {
            return view('frontend.events.profile.saved-events');
        })->name('saved-events');

        Route::get('/my-tickets', function () {
            return redirect()->route('frontend.user.tickets.index');
        })->name('my-tickets');
        Route::get('/settings', function () {
            return view('frontend.events.profile.settings');
        })->name('settings');
    });

});


