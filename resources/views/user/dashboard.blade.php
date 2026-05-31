<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-[#020617] antialiased">
@php
    $userName = auth()->user()->name ?? 'Marcus George';
    $userEmail = auth()->user()->email ?? 'visitor@example.com';
    $stats = [
        ['Event Tickets', '3', '1 confirmed', '2 upcoming/saved', 'fa-solid fa-ticket', 'bg-[#EFF6FF]', 'text-[#2563EB]', route('user.tickets.index')],
        ['Exhibition Passes', '3', '1 active', '2 upcoming/saved', 'fa-regular fa-id-card', 'bg-white', 'text-[#2563EB]', route('user.exhibition-tickets.index')],
        ['Open Enquiries', '3', '1 replied', '2 need follow-up', 'fa-regular fa-message', 'bg-white', 'text-[#0F766E]', route('user.enquiries.index')],
    ];
    $activities = [
        ['Event ticket', 'Global Tech Summit 2024 | General Pass x 2', 'Confirmed', 'text-emerald-500', 'bg-emerald-50', '/user/tickets/1/e-ticket'],
        ['Exhibition pass', 'Global Tech Expo 2026 | Innovation Pavilion', 'Active', 'text-[#2563EB]', 'bg-[#EFF6FF]', '/user/exhibition-tickets/1/e-ticket'],
        ['Booth visit', 'Innovation Pavilion | Hall 1 | 8 booths explored', 'Completed', 'text-emerald-500', 'bg-emerald-50', route('user.visits.index')],
        ['Enquiry', 'Demo meeting request sent to CloudBridge', 'Replied', 'text-amber-500', 'bg-amber-50', '/user/enquiries/2'],
    ];
    $passes = [
        ['Global Tech Expo 2026', 'Visitor Pass | Innovation Pavilion', 'Active', '100%', '/user/exhibition-tickets/1/e-ticket'],
        ['Startup Connect 2026', 'Business Pass | Aug 12, 2026', 'Confirmed', '80%', '/user/tickets/3/e-ticket'],
        ['Healthcare Innovation Expo', 'Business Pass | Healthcare Pavilion', 'Upcoming', '60%', '/user/exhibition-tickets/2'],
    ];
    $categories = [
        ['Event Tickets', '3', 'bg-[#2563EB]'],
        ['Exhibition Passes', '3', 'bg-blue-400'],
        ['Saved Exhibitions', '3', 'bg-blue-200'],
        ['Enquiries', '3', 'bg-blue-100'],
    ];
    $eventChecklist = [
        ['Event', 'Global Tech Summit 2024'],
        ['Pass', 'General Pass x 2'],
        ['Ticket ID', 'EVT-240515-000123'],
        ['Entry', 'Gate 2 | 10:00 AM'],
    ];
    $exhibitionChecklist = [
        ['Exhibition', 'Global Tech Expo 2026'],
        ['Pass', 'Visitor Pass'],
        ['Pavilion', 'Innovation Pavilion'],
        ['Access', 'Lobby + Public Booths'],
    ];
    $eventAccess = [
        'title' => 'Global Tech Summit 2024',
        'pass' => 'General Pass x 2',
        'date' => 'May 15 - May 17, 2024',
        'id' => 'EVT-240515-000123',
        'qr' => 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=10&data=EVT-240515-000123%7CGlobal-Tech-Summit-2024%7C'.$userEmail,
        'ticketUrl' => url('/user/tickets/1/e-ticket'),
        'entryUrl' => route('events.home'),
    ];
    $exhibitionAccess = [
        'title' => 'Global Tech Expo 2026',
        'pass' => 'Visitor Pass',
        'date' => 'June 12 - June 14, 2026',
        'id' => 'EXP-20486',
        'qr' => 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=10&data=EXP-20486%7CGlobal-Tech-Expo-2026%7C'.$userEmail,
        'ticketUrl' => url('/user/exhibition-tickets/1/e-ticket'),
        'entryUrl' => route('exhibitions.visit', 'global-tech-expo-2026'),
    ];
@endphp

<main class="flex min-h-screen w-full overflow-hidden bg-white">
    <aside class="hidden w-[190px] shrink-0 border-r border-[#F1F5F9] bg-white px-5 py-7 lg:block">
        <a href="{{ route('home') }}" class="mb-9 flex items-center gap-2">
            <span class="grid grid-cols-2 gap-[3px]">
                <i class="h-[9px] w-[9px] rounded-[2px] bg-[#2563EB]"></i>
                <i class="h-[9px] w-[9px] rounded-[2px] bg-sky-400"></i>
                <i class="h-[9px] w-[9px] rounded-[2px] bg-sky-400"></i>
                <i class="h-[9px] w-[9px] rounded-[2px] bg-[#2563EB]"></i>
            </span>
            <span class="text-[19px] font-bold text-[#020617]">EproExpo</span>
        </a>

        <nav class="space-y-2">
            @foreach ([
                ['Dashboard', route('user.dashboard'), 'fa-solid fa-table-columns', true],
                ['Tickets', route('user.tickets.index'), 'fa-solid fa-ticket', false],
                ['Passes', route('user.exhibition-tickets.index'), 'fa-regular fa-id-card', false],
                ['Visits', route('user.visits.index'), 'fa-solid fa-store', false],
                ['Saved', route('user.saved.exhibitions'), 'fa-regular fa-bookmark', false],
                ['Enquiries', route('user.enquiries.index'), 'fa-regular fa-message', false],
            ] as [$label, $href, $icon, $active])
                <a href="{{ $href }}" class="flex h-[40px] items-center gap-3 rounded-[8px] px-4 text-[13px] font-medium {{ $active ? 'bg-[#2563EB] text-white' : 'text-[#64748B] hover:bg-[#EFF6FF]' }}">
                    <i class="{{ $icon }} w-4 text-center"></i>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="my-8 h-px bg-[#E5E7EB]"></div>

        <nav class="space-y-2">
            <a href="{{ route('user.profile') }}" class="flex h-[40px] items-center gap-3 rounded-[8px] px-4 text-[13px] font-medium text-[#64748B] hover:bg-[#EFF6FF]"><i class="fa-regular fa-user w-4 text-center"></i>Profile</a>
            <a href="{{ route('user.settings') }}" class="flex h-[40px] items-center gap-3 rounded-[8px] px-4 text-[13px] font-medium text-[#64748B] hover:bg-[#EFF6FF]"><i class="fa-solid fa-gear w-4 text-center"></i>Settings</a>
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button class="flex h-[40px] w-full items-center gap-3 rounded-[8px] px-4 text-left text-[13px] font-medium text-[#64748B] hover:bg-[#EFF6FF]"><i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>Logout</button>
            </form>
        </nav>
    </aside>

    <section class="min-w-0 flex-1 overflow-hidden bg-white px-5 py-6 lg:px-8">
        <header class="mb-5 flex min-h-[48px] flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-[#2563EB]">Visitor Workspace</p>
                <h1 class="mt-1 text-[26px] font-bold text-[#020617]">Dashboard</h1>
            </div>

            <div class="flex flex-wrap items-center gap-4 lg:gap-5">
                <label class="flex h-[36px] w-full items-center justify-between rounded-full bg-[#F8FAFC] px-4 text-[11px] text-[#8B95A1] sm:w-[285px]">
                    <input class="w-full bg-transparent outline-none" placeholder="Search tickets, booths, events">
                    <i class="fa-solid fa-magnifying-glass text-[#4B5563]"></i>
                </label>
                <a href="{{ route('user.enquiries.index') }}" class="flex h-8 w-8 items-center justify-center rounded-full text-[#64748B]"><i class="fa-regular fa-comment-dots"></i></a>
                <a href="{{ route('user.exhibition-tickets.index') }}" class="relative flex h-8 w-8 items-center justify-center rounded-full text-[#64748B]">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute right-[6px] top-[5px] h-[8px] w-[8px] rounded-full bg-red-500"></span>
                </a>
                <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-[8px] bg-[#2563EB] text-[13px] font-bold text-white">{{ strtoupper(substr($userName, 0, 1)) }}</span>
                    <div class="w-[128px]">
                        <h2 class="truncate text-[13px] font-semibold leading-none text-[#020617]">{{ $userName }}</h2>
                        <p class="mt-1 truncate text-[10px] text-[#64748B]">{{ $userEmail }}</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]">
            <div class="grid gap-5">
                <section class="grid gap-5 md:grid-cols-3">
                    @foreach ($stats as [$label, $value, $change, $meta, $icon, $bg, $color, $href])
                        <article class="relative min-h-[105px] overflow-hidden rounded-[8px] {{ $bg }} p-4 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                            <div class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-md bg-[#2563EB] text-xs text-white"><i class="{{ $icon }}"></i></div>
                            <p class="text-[11px] text-[#64748B]">{{ $label }}</p>
                            <div class="mt-7 flex items-end justify-between gap-3">
                                <h3 class="text-[24px] font-bold tracking-tight text-[#020617]">{{ $value }}</h3>
                                <p class="text-right text-[10px] font-semibold {{ $color }}">{{ $change }}<br><span class="text-[8px] text-[#64748B]">{{ $meta }}</span></p>
                            </div>
                            <a href="{{ $href }}" class="absolute inset-0" aria-label="Open {{ $label }}"></a>
                        </article>
                    @endforeach
                </section>

                <section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]">
                    <article class="overflow-hidden rounded-[8px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-[18px] font-semibold text-[#020617]">Tickets, QR & Entry</h2>
                                <p class="mt-2 text-[12px] font-medium leading-5 text-[#64748B]">Latest event ticket and exhibition pass appear here after booking, with QR and direct entry.</p>
                            </div>
                            <a href="{{ route('user.exhibition-tickets.index') }}" class="h-[40px] rounded-md bg-[#2563EB] px-5 py-3 text-[13px] font-semibold text-white">View Passes</a>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="rounded-[12px] border border-[#E2E8F0] bg-[#F8FAFC] p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-[#2563EB]">Event Ticket</p>
                                        <h3 id="event-ticket-title" class="mt-2 text-[18px] font-bold text-[#020617]">{{ $eventAccess['title'] }}</h3>
                                    </div>
                                    <span class="grid h-10 w-10 place-items-center rounded-[8px] bg-[#2563EB] text-white"><i class="fa-solid fa-ticket"></i></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-[1fr_112px] sm:items-center">
                                    <div class="space-y-3">
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Pass</span><strong id="event-ticket-pass" class="text-right font-bold text-[#020617]">{{ $eventAccess['pass'] }}</strong></div>
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Date</span><strong id="event-ticket-date" class="text-right font-bold text-[#020617]">{{ $eventAccess['date'] }}</strong></div>
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Ticket ID</span><strong id="event-ticket-id" class="text-right font-bold text-[#020617]">{{ $eventAccess['id'] }}</strong></div>
                                    </div>
                                    <div class="rounded-[10px] bg-white p-2 shadow-[0_8px_20px_rgba(15,23,42,0.06)]">
                                        <img id="event-ticket-qr" src="{{ $eventAccess['qr'] }}" alt="Event ticket QR" class="h-24 w-24 rounded-[6px]">
                                    </div>
                                </div>

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <a id="event-ticket-link" href="{{ $eventAccess['ticketUrl'] }}" class="inline-flex h-10 items-center justify-center rounded-[8px] bg-white text-[13px] font-bold text-[#2563EB] ring-1 ring-[#DBEAFE]">View Ticket</a>
                                    <a id="event-entry-link" href="{{ $eventAccess['entryUrl'] }}" class="inline-flex h-10 items-center justify-center rounded-[8px] bg-[#2563EB] text-[13px] font-bold text-white">Enter Event</a>
                                </div>
                            </div>

                            <div class="rounded-[12px] border border-[#DBEAFE] bg-[#EFF6FF] p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-[#2563EB]">Exhibition Pass</p>
                                        <h3 id="exhibition-pass-title" class="mt-2 text-[18px] font-bold text-[#020617]">{{ $exhibitionAccess['title'] }}</h3>
                                    </div>
                                    <span class="grid h-10 w-10 place-items-center rounded-[8px] bg-[#2563EB] text-white"><i class="fa-regular fa-id-card"></i></span>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-[1fr_112px] sm:items-center">
                                    <div class="space-y-3">
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Pass</span><strong id="exhibition-pass-type" class="text-right font-bold text-[#020617]">{{ $exhibitionAccess['pass'] }}</strong></div>
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Date</span><strong id="exhibition-pass-date" class="text-right font-bold text-[#020617]">{{ $exhibitionAccess['date'] }}</strong></div>
                                        <div class="flex justify-between gap-4 text-[13px]"><span class="text-[#64748B]">Pass ID</span><strong id="exhibition-pass-id" class="text-right font-bold text-[#020617]">{{ $exhibitionAccess['id'] }}</strong></div>
                                    </div>
                                    <div class="rounded-[10px] bg-white p-2 shadow-[0_8px_20px_rgba(15,23,42,0.06)]">
                                        <img id="exhibition-pass-qr" src="{{ $exhibitionAccess['qr'] }}" alt="Exhibition pass QR" class="h-24 w-24 rounded-[6px]">
                                    </div>
                                </div>

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <a id="exhibition-pass-link" href="{{ $exhibitionAccess['ticketUrl'] }}" class="inline-flex h-10 items-center justify-center rounded-[8px] bg-white text-[13px] font-bold text-[#2563EB] ring-1 ring-[#DBEAFE]">View QR Pass</a>
                                    <a id="exhibition-entry-link" href="{{ $exhibitionAccess['entryUrl'] }}" class="inline-flex h-10 items-center justify-center rounded-[8px] bg-[#2563EB] text-[13px] font-bold text-white">Enter Exhibition</a>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="overflow-hidden rounded-[8px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                        <div class="flex items-center justify-between">
                            <h2 class="text-[18px] font-semibold text-[#020617]">Flow Readiness</h2>
                            <i class="fa-solid fa-ellipsis text-[#64748B]"></i>
                        </div>
                        <div class="relative mt-8 flex h-[125px] justify-center">
                            <div class="absolute top-0 h-[85px] w-[170px] rounded-t-full border-[19px] border-b-0 border-blue-100"></div>
                            <div class="absolute top-0 h-[85px] w-[170px] rounded-t-full border-[19px] border-b-0 border-[#2563EB]" style="clip-path: polygon(0 0, 86% 0, 86% 100%, 0 100%);"></div>
                            <div class="absolute top-[55px] text-center">
                                <h3 class="text-[28px] font-bold leading-none text-[#020617]">Ready</h3>
                                <p class="mt-2 text-[10px] text-emerald-500">QR active <span class="text-[#64748B]">for entry</span></p>
                            </div>
                        </div>
                        <div class="mt-1 text-center">
                            <h3 class="text-[13px] font-bold text-[#020617]">Next Step</h3>
                            <p class="mt-2 text-[10px] leading-5 text-[#64748B]">Keep event and exhibition QR passes ready before check-in or lobby entry.</p>
                        </div>
                        <div class="mt-6 grid grid-cols-2 overflow-hidden rounded-md bg-blue-50">
                            <div class="border-r border-white py-4 text-center"><p class="text-[10px] text-[#64748B]">Event QR</p><h4 class="text-[14px] font-bold text-[#020617]">Ready</h4></div>
                            <div class="py-4 text-center"><p class="text-[10px] text-[#64748B]">Expo QR</p><h4 class="text-[14px] font-bold text-[#020617]">Active</h4></div>
                        </div>
                    </article>
                </section>

                <section class="grid gap-5 xl:grid-cols-[300px_minmax(0,1fr)]">
                    <article class="overflow-hidden rounded-[14px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                        <div class="mb-4 flex items-center justify-between"><h2 class="text-[18px] font-semibold text-[#020617]">Current Access</h2><i class="fa-solid fa-ellipsis text-[#64748B]"></i></div>
                        <div class="mb-5 flex items-start justify-between gap-3">
                            <div><h3 class="text-[32px] font-bold leading-none text-[#020617]">6</h3><p class="mt-2 text-[13px] text-[#64748B]">tickets and passes</p></div>
                            <div class="w-[126px] shrink-0 rounded-[8px] bg-blue-50 px-3 py-3 text-right"><p class="text-[13px] font-semibold text-emerald-500">2 QR</p><p class="mt-1 text-[11px] leading-4 text-[#64748B]">ready now</p></div>
                        </div>
                        <div class="space-y-4">
                            @foreach ($passes as [$name, $area, $status, $width, $href])
                                <a href="{{ url($href) }}" class="block">
                                    <div class="mb-2 flex justify-between gap-3 text-[13px]"><span class="truncate text-[#64748B]">{{ $name }}</span><b class="text-[#020617]">{{ $status }}</b></div>
                                    <div class="h-[7px] overflow-hidden rounded-full bg-blue-100"><div class="h-full rounded-full bg-[#2563EB]" style="width: {{ $width }}"></div></div>
                                    <p class="mt-1 text-[10px] text-[#94A3B8]">{{ $area }}</p>
                                </a>
                            @endforeach
                        </div>
                    </article>

                    <article class="overflow-hidden rounded-[14px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                        <div class="mb-4 flex items-center justify-between"><h2 class="text-[18px] font-semibold text-[#020617]">Recent Activity</h2><a href="{{ route('user.tickets.index') }}" class="rounded-[8px] bg-[#2563EB] px-5 py-3 text-[13px] font-semibold text-white">View All</a></div>
                        <div class="grid gap-3">
                            @foreach ($activities as [$title, $meta, $status, $statusColor, $statusBg, $href])
                                <a href="{{ url($href) }}" class="grid items-center gap-3 rounded-[10px] border border-[#E2E8F0] p-3 transition hover:bg-[#F8FAFC] sm:grid-cols-[auto_1fr_auto]">
                                    <span class="grid h-10 w-10 place-items-center rounded-[8px] bg-[#EFF6FF] text-[#2563EB]"><i class="fa-regular fa-circle-check"></i></span>
                                    <div class="min-w-0"><h3 class="truncate text-[14px] font-bold text-[#020617]">{{ $title }}</h3><p class="mt-1 truncate text-[12px] text-[#64748B]">{{ $meta }}</p></div>
                                    <span class="w-fit rounded-md px-2.5 py-1 text-[12px] font-semibold {{ $statusColor }} {{ $statusBg }}">{{ $status }}</span>
                                </a>
                            @endforeach
                        </div>
                    </article>
                </section>
            </div>

            <aside class="grid gap-5 xl:grid-rows-[405px_359px]">
                <article class="overflow-hidden rounded-[8px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                    <div class="mb-6 flex items-center justify-between"><h2 class="text-[16px] font-semibold text-[#020617]">User Flow Summary</h2><a href="{{ route('user.profile') }}" class="text-[11px] font-medium text-[#64748B]">Profile</a></div>
                    <div class="relative mx-auto mb-7 h-[185px] w-[185px]">
                        <div class="absolute inset-0 rounded-full border-[18px] border-blue-100"></div>
                        <div class="absolute inset-0 rounded-full border-[18px] border-[#2563EB]" style="clip-path: polygon(50% 0, 100% 0, 100% 84%, 50% 50%);"></div>
                        <div class="absolute inset-[38px] flex flex-col items-center justify-center rounded-full bg-white">
                            <p class="text-[9px] text-[#64748B]">Tracked Items</p>
                            <h3 class="text-[21px] font-bold text-[#020617]">12</h3>
                        </div>
                    </div>
                    <div class="space-y-4 text-[12px]">
                        @foreach ($categories as [$label, $value, $dot])
                            <div class="flex items-center justify-between gap-3"><span class="flex items-center gap-2 text-[#64748B]"><i class="h-2 w-2 rounded-sm {{ $dot }}"></i>{{ $label }}</span><b class="text-[#020617]">{{ $value }}</b></div>
                        @endforeach
                    </div>
                </article>

                <article class="overflow-hidden rounded-[8px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                    <div class="mb-5 flex items-center justify-between"><h2 class="text-[16px] font-semibold text-[#020617]">Quick Actions</h2><i class="fa-solid fa-ellipsis text-[#64748B]"></i></div>
                    <div class="mb-6 flex h-[44px] overflow-hidden rounded-md">
                        <div class="flex-[40] bg-blue-100"></div><div class="flex-[30] border-l border-white bg-blue-200"></div><div class="flex-[15] border-l border-white bg-blue-300"></div><div class="flex-[10] border-l border-white bg-blue-400"></div><div class="flex-[5] border-l border-white bg-[#2563EB]"></div>
                    </div>
                    <div class="space-y-3 text-[12px]">
                        @foreach ([['Book Event Ticket', route('events.tickets.select')], ['Get Exhibition Pass', route('exhibitions.tickets.select', 'global-tech-expo-2026')], ['My Event Tickets', route('user.tickets.index')], ['My Exhibition Passes', route('user.exhibition-tickets.index')], ['Visited Booths', route('user.booths.visited')], ['My Enquiries', route('user.enquiries.index')]] as [$label, $href])
                            <a href="{{ $href }}" class="flex justify-between rounded-md px-2 py-1.5 text-[#64748B] hover:bg-[#EFF6FF]"><span>{{ $label }}</span><i class="fa-solid fa-arrow-right text-[#2563EB]"></i></a>
                        @endforeach
                    </div>
                </article>
            </aside>
        </div>
    </section>
    <script>
        (() => {
            const setText = (id, value) => {
                const element = document.getElementById(id);
                if (element && value) element.textContent = value;
            };
            const setAttr = (id, attr, value) => {
                const element = document.getElementById(id);
                if (element && value) element.setAttribute(attr, value);
            };
            const qrUrl = (value) => `https://api.qrserver.com/v1/create-qr-code/?size=180x180&margin=10&data=${encodeURIComponent(value)}`;

            const eventOrder = JSON.parse(localStorage.getItem('eventOrder') || 'null');
            if (eventOrder) {
                const ticketId = eventOrder.ticketId || 'EVT-240515-000123';
                const eventName = eventOrder.eventName || 'Global Tech Summit 2024';
                const passName = eventOrder.passName || 'General Pass';
                const quantity = eventOrder.quantity || 1;

                setText('event-ticket-title', eventName);
                setText('event-ticket-pass', `${passName} x ${quantity}`);
                setText('event-ticket-date', eventOrder.date || 'May 15 - May 17, 2024');
                setText('event-ticket-id', ticketId);
                setAttr('event-ticket-qr', 'src', qrUrl(`${ticketId}|${eventName}|{{ $userEmail }}`));
            }

            const exhibitionPass = JSON.parse(localStorage.getItem('exhibitionPass') || 'null');
            if (exhibitionPass) {
                const passId = exhibitionPass.passId || 'EXP-20486';
                const exhibitionName = exhibitionPass.exhibitionName || 'Global Tech Expo 2026';

                setText('exhibition-pass-title', exhibitionName);
                setText('exhibition-pass-type', exhibitionPass.passType || 'Business Pass');
                setText('exhibition-pass-date', exhibitionPass.dates || 'June 12 - June 14, 2026');
                setText('exhibition-pass-id', passId);
                setAttr('exhibition-pass-qr', 'src', qrUrl(`${passId}|${exhibitionName}|{{ $userEmail }}`));
                setAttr('exhibition-entry-link', 'href', exhibitionPass.entryUrl || '{{ route('exhibitions.visit', 'global-tech-expo-2026') }}');
            }
        })();
    </script>
</main>
</body>
</html>
