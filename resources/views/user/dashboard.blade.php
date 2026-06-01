@extends('layouts.user')

@section('title', 'User Dashboard - EproExpo')
@section('page-title', 'Dashboard')

@section('content')
@php
    $user = auth()->user();
    $userName = $user->name ?? 'Visitor';
    $userEmail = $user->email ?? '';
    
    // Retrieve user's visitor tickets
    $tickets = \App\Models\VisitorTicket::where('user_id', $user->id)
        ->with(['companyEvent.branding', 'ticketType'])
        ->orderBy('created_at', 'desc')
        ->get();
        
    $totalTicketsCount = $tickets->count();
    $totalTicketsQty = $tickets->sum('quantity');
    $uniqueEventsCount = $tickets->pluck('company_event_id')->filter()->unique()->count();
    
    // Retrieve total enquiries count for the user
    $enquiriesCount = \App\Models\Enquiry::where('visitor_id', $user->id)->count();
    
    // Get latest active/confirmed ticket for visitor access widget
    $latestTicket = $tickets->first();
    $isPassActive = $latestTicket ? ($latestTicket->status === 'confirmed') : false;
    $latestEvent = $latestTicket ? $latestTicket->companyEvent : null;
    
    $eventTitle = $latestEvent ? $latestEvent->title : 'No Booked Events';
    $ticketId = $latestTicket ? $latestTicket->order_number : 'N/A';
    $ticketName = $latestTicket ? $latestTicket->ticket_name : 'No Active Pass';
    
    if ($latestEvent && $latestEvent->starts_at) {
        $dateStr = $latestEvent->starts_at->format('M d') . ' - ' . ($latestEvent->ends_at ? $latestEvent->ends_at->format('d, Y') : $latestEvent->starts_at->format('Y'));
    } else {
        $dateStr = 'No upcoming dates';
    }
    
    // Recommended/Upcoming published events
    $recommendedEvents = \App\Models\CompanyEvent\CompanyEvent::where('status', 'published')
        ->where('visibility', 'public')
        ->with('branding')
        ->latest()
        ->take(3)
        ->get();
        
    // Fetch upcoming sessions for user's booked events
    $bookedEventIds = $tickets->pluck('company_event_id')->filter()->unique();
    $upcomingSessions = [];
    if ($bookedEventIds->isNotEmpty()) {
        $upcomingSessions = \App\Models\CompanyEvent\CompanyEventSession::whereIn('company_event_id', $bookedEventIds)
            ->where('status', 'upcoming')
            ->orderBy('starts_at')
            ->take(3)
            ->get();
    }
@endphp

<main class="px-5 py-6 sm:px-8 lg:px-8">
    <h1 class="mb-2 text-[34px] font-semibold leading-[40px] tracking-[-1px] text-[#071044] sm:text-[42px] sm:leading-[48px] lg:text-[50px] lg:leading-[56px] lg:tracking-[-1.5px]">
        Welcome back, {{ $userName }}!
    </h1>

    <p class="mb-8 text-[16px] leading-7 text-[#5A6480] sm:text-[18px]">
        Your event tickets, registered sessions, and agenda are ready.
    </p>

    <!-- Top Stats Cards -->
    <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card 1: Active Event Pass -->
        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white p-7 shadow-sm">
            <div class="mb-5 text-[15px] font-bold text-[#8A94AD] uppercase tracking-wider">Active Event Pass</div>
            <div class="mb-2 text-[20px] font-bold text-[#071044] truncate" title="{{ $eventTitle }}">{{ $eventTitle }}</div>
            <div class="space-y-1.5 text-[14px] font-medium text-[#5A6480]">
                <p class="flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full {{ $isPassActive ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                    {{ $isPassActive ? 'Pass active' : 'No active pass' }}
                </p>
                <p>Ticket ID: <span class="font-semibold text-[#071044]">{{ $ticketId }}</span></p>
                <p class="text-[13px] text-[#8A94AD]">{{ $dateStr }}</p>
            </div>
        </div>

        <!-- Card 2: Booked Events -->
        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white p-7 shadow-sm">
            <div class="mb-6 text-[15px] font-bold text-[#8A94AD] uppercase tracking-wider">Booked Events</div>
            <div class="text-[44px] font-extrabold leading-none text-[#071044]">{{ $uniqueEventsCount }}</div>
            <p class="mt-2 text-[13px] text-[#5A6480]">Unique event registrations</p>
        </div>

        <!-- Card 3: Booked Tickets -->
        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white p-7 shadow-sm">
            <div class="mb-6 text-[15px] font-bold text-[#8A94AD] uppercase tracking-wider">Total Tickets</div>
            <div class="text-[44px] font-extrabold leading-none text-[#071044]">{{ $totalTicketsQty }}</div>
            <p class="mt-2 text-[13px] text-[#5A6480]">Total tickets purchased</p>
        </div>

        <!-- Card 4: Open Enquiries -->
        <div class="flex min-h-[150px] flex-col justify-start overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white p-7 shadow-sm">
            <div class="mb-6 text-[15px] font-bold text-[#8A94AD] uppercase tracking-wider">My Enquiries</div>
            <div class="text-[44px] font-extrabold leading-none text-[#071044]">{{ $enquiriesCount }}</div>
            <p class="mt-2 text-[13px] text-[#5A6480]">Submitted enquiry count</p>
        </div>
    </div>

    <!-- Main Columns -->
    <div class="grid grid-cols-1 items-start gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
        <!-- Left Column -->
        <div class="min-w-0">
            <h2 class="mb-5 text-[20px] font-bold text-[#071044]">Quick Actions</h2>

            <div class="mb-10 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <a href="{{ url('/events') }}" class="flex h-[52px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                    <i class="fa-solid fa-calendar-days text-[18px]"></i>
                    Explore Events
                </a>

                <a href="{{ route('user.tickets.index') }}" class="flex h-[52px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                    <i class="fa-solid fa-ticket text-[18px]"></i>
                    My Tickets
                </a>

                <a href="{{ route('user.enquiries.index') }}" class="flex h-[52px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                    <i class="fa-regular fa-message text-[18px]"></i>
                    My Enquiries
                </a>

                <a href="{{ route('user.profile') }}" class="flex h-[52px] items-center justify-center gap-3 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#5b2eff] shadow-sm hover:border-[#5b2eff] hover:bg-[#F8F5FF] transition">
                    <i class="fa-regular fa-user text-[18px]"></i>
                    Edit Profile
                </a>
            </div>

            <h2 class="mb-5 text-[20px] font-bold text-[#071044]">Recommended Events</h2>

            <div class="space-y-4">
                @forelse ($recommendedEvents as $event)
                    @php
                        $eventDate = $event->starts_at ? $event->starts_at->format('M d, Y') : 'Date TBD';
                        $eventBanner = $event->branding?->banner_path ? asset('storage/' . $event->branding->banner_path) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=450&fit=crop';
                    @endphp
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 rounded-2xl border border-[#E7EAF3] bg-white p-5 hover:border-[#CFC7F1] transition shadow-sm">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 min-w-0 w-full">
                            <img src="{{ $eventBanner }}" alt="{{ $event->title }}" class="h-[76px] w-[120px] rounded-xl object-cover bg-gray-100 shrink-0 shadow-sm" />
                            <div class="min-w-0 flex-1">
                                <h3 class="text-[17px] font-bold text-[#071044] truncate" title="{{ $event->title }}">{{ $event->title }}</h3>
                                <div class="mt-2 flex flex-wrap gap-x-5 gap-y-1.5 text-[13px] font-medium text-[#5A6480]">
                                    <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar-days text-[#8A94AD]"></i>{{ $eventDate }}</span>
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-[#8A94AD]"></i>{{ $event->venue_name ?? 'Venue TBD' }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('events.listings.show', $event->slug) }}" class="shrink-0 rounded-xl border border-[#C7F0D4] bg-[#EEFDF3] px-4 py-2.5 text-[12px] font-bold text-[#16A34A] hover:bg-[#D5F9E0] transition">
                            Book Ticket
                        </a>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#E7EAF3] bg-white p-10 text-center text-[14px] text-[#5A6480]">
                        No recommended events available at this moment.
                    </div>
                @endforelse
            </div>

            <a href="{{ url('/events') }}" class="mt-6 inline-flex items-center gap-2 text-[14.5px] font-bold text-[#5b2eff] hover:underline">
                View All Events
                <i class="fa-solid fa-arrow-right text-[12px]"></i>
            </a>
        </div>

        <!-- Right Column -->
        <div class="min-w-0 space-y-6 xl:pt-0">
            <!-- Visitor Event Access Card -->
            <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-[18px] font-bold text-[#071044]">Event Access Pass</h2>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-between text-[14px] text-[#5A6480]">
                        <span>Pass Status</span>
                        <span class="font-bold {{ $isPassActive ? 'text-emerald-600' : 'text-gray-500' }}">
                            {{ $isPassActive ? 'Active' : 'No Active Pass' }}
                        </span>
                    </div>

                    @if ($latestTicket)
                        <!-- Dynamic QR Code Card -->
                        <div class="rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-4 flex flex-col items-center justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=10&data={{ urlencode($ticketId . '|' . $eventTitle . '|' . $userEmail) }}" alt="Event Ticket QR" class="h-40 w-40 rounded-xl shadow-sm bg-white" />
                            <p class="mt-3 text-[12px] font-bold text-[#071044] tracking-wider">{{ $ticketId }}</p>
                            <p class="mt-1 text-[11px] text-[#8A94AD] truncate max-w-full">{{ $ticketName }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('user.tickets.show', $latestTicket->id) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-white text-[13px] font-bold text-[#5b2eff] ring-1 ring-[#DBEAFE] hover:bg-[#F8F5FF] transition">
                                View Ticket
                            </a>
                            <a href="{{ route('events.listings.show', $latestTicket->event_slug) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#5b2eff] text-[13px] font-bold text-white shadow-sm hover:bg-[#4310d8] transition">
                                Enter Event
                            </a>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-[#E7EAF3] bg-[#FAFAFC] p-8 text-center text-[13.5px] text-[#5A6480]">
                            No active tickets found. Book an event ticket to activate.
                        </div>
                        <a href="{{ url('/events') }}" class="flex h-11 items-center justify-center rounded-xl bg-[#5b2eff] text-[13px] font-bold text-white shadow-sm hover:bg-[#4310d8] transition">
                            Book Tickets
                        </a>
                    @endif
                </div>
            </div>

            <!-- Upcoming Sessions Card -->
            <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-[18px] font-bold text-[#071044]">Upcoming Sessions</h2>
                
                <div class="space-y-4">
                    @forelse ($upcomingSessions as $session)
                        @php
                            $sessionTime = $session->starts_at ? $session->starts_at->format('h:i A') : 'TBD';
                            $sessionDate = $session->starts_at ? $session->starts_at->format('M d') : 'Date TBD';
                        @endphp
                        <div class="flex items-start gap-4 border-b border-[#F1F3F9] pb-4 last:border-b-0 last:pb-0">
                            <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-[#F4F0FF] text-[#5b2eff]">
                                <span class="text-[10px] font-extrabold uppercase tracking-wide leading-none">{{ $sessionDate }}</span>
                                <span class="mt-1 text-[13px] font-black leading-none">{{ $sessionTime }}</span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-[14px] font-bold text-[#071044] truncate" title="{{ $session->title }}">{{ $session->title }}</h3>
                                <p class="mt-1.5 text-[12px] font-medium text-[#5A6480] truncate">{{ $session->session_type }} | {{ $session->location ?? 'Online' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-[13.5px] text-[#5A6480]">
                            No upcoming sessions scheduled for your booked events.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
