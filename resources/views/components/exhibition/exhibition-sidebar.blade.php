@php
    $activeSlug = request()->route('slug') ?? 'global-tech-expo-2026';

    // Resolve active visitor pass dynamically from database
    $exhibition = \App\Models\Exhibition::where('slug', $activeSlug)->first();
    $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
    $visitor = null;
    if ($bookingId) {
        $visitor = \App\Models\Visitor::where('booking_id', $bookingId)->first();
    }
    if (!$visitor && $exhibition) {
        $visitor = \App\Models\Visitor::where('exhibition_id', $exhibition->id)->orderBy('created_at', 'desc')->first();
    }
    $passName = $visitor ? ($visitor->pass_type ?: 'Free Visitor Pass') : 'No Active Pass';

    $primaryLinks = [
        ['Visitor Dashboard', route('exhibitions.visitor.dashboard', $activeSlug), request()->routeIs('exhibitions.dashboard') || request()->routeIs('exhibitions.visitor.dashboard'), 'fa-solid fa-house'],
        ['Browse Exhibitions', route('exhibitions.index'), request()->routeIs('exhibitions.index') || request()->routeIs('exhibitions.browse') || request()->routeIs('exhibitions.show'), 'fa-solid fa-magnifying-glass'],
        ['Companies', route('exhibitions.visitor.companies', $activeSlug), request()->routeIs('exhibitions.visitor.companies*'), 'fa-solid fa-store'],
        ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.halls.*') || request()->routeIs('exhibitions.visitor-halls.*'), 'fa-regular fa-map'],
        ['Get Visitor Pass', route('exhibitions.tickets.select', $activeSlug), request()->routeIs('exhibitions.tickets.*'), 'fa-regular fa-id-card'],
    ];

    $visitorLinks = [
        ['My Passes', route('exhibitions.visitor.my-passes', $activeSlug), request()->routeIs('exhibitions.visitor.my-passes'), 'fa-regular fa-bookmark'],
        ['Saved Booths', route('exhibitions.visitor.saved', $activeSlug), request()->routeIs('exhibitions.visitor.saved'), 'fa-regular fa-heart'],
        ['My Meetings', route('exhibitions.visitor.meetings', $activeSlug), request()->routeIs('exhibitions.visitor.meetings'), 'fa-regular fa-calendar-check'],
        ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), request()->routeIs('exhibitions.visitor.sessions'), 'fa-regular fa-circle-play'],
        ['Notifications', route('exhibitions.visitor.notifications', $activeSlug), request()->routeIs('exhibitions.visitor.notifications'), 'fa-regular fa-bell'],
        ['QR Pass', route('exhibitions.visitor.qr-pass', $activeSlug), request()->routeIs('exhibitions.visitor.qr-pass') || request()->routeIs('exhibitions.tickets.e-ticket'), 'fa-solid fa-qrcode'],
    ];
@endphp

<aside id="exhibition-sidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] shrink-0 -translate-x-full border-r border-borderColor bg-white shadow-[8px_0_24px_rgba(7,16,68,0.12)] transition-transform duration-200 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:translate-x-0 lg:overflow-y-auto lg:shadow-[8px_0_24px_rgba(7,16,68,0.06)]">
    <div class="flex h-[74px] items-center justify-between border-b border-borderColor px-5">
        <x-shared.brand-logo href="{{ route('exhibitions.visitor.dashboard', $activeSlug) }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[23px]" subtitle-class="text-[11px]" />

        <button type="button" data-sidebar-close class="flex h-10 w-10 items-center justify-center rounded-md border border-borderColor text-navy lg:hidden">
            <i class="fa-solid fa-xmark text-[18px]"></i>
        </button>
    </div>

    <div class="px-3 py-4">
        <div class="mb-4 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-3">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-purple">Active pass</p>
                    <p class="mt-1 truncate text-[14px] font-semibold text-navy">{{ $passName }}</p>
                </div>
                <a href="{{ route('exhibitions.visitor.qr-pass', $activeSlug) }}" class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#5b2eff] text-white" title="View QR pass">
                    <i class="fa-solid fa-qrcode text-[14px]"></i>
                </a>
            </div>
        </div>

        <p class="mb-1.5 px-3 text-[10px] font-bold uppercase tracking-[0.14em] text-[#8A90A8]">Explore</p>
        <nav class="space-y-0.5">
            @foreach ($primaryLinks as [$label, $href, $active, $icon])
                <a href="{{ $href }}" class="group flex h-[40px] items-center gap-2.5 rounded-lg px-3 text-[13px] transition {{ $active ? 'bg-[#F4F0FF] font-semibold text-purple' : 'font-medium text-navy hover:bg-[#F8F7FF] hover:text-purple' }}">
                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-md {{ $active ? 'bg-white text-purple' : 'text-purple group-hover:bg-white' }}">
                        <i class="{{ $icon }} text-[14px]"></i>
                    </span>
                    <span class="min-w-0 truncate">{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <p class="mb-1.5 mt-4 px-3 text-[10px] font-bold uppercase tracking-[0.14em] text-[#8A90A8]">My Expo</p>
        <nav class="space-y-0.5">
            @foreach ($visitorLinks as [$label, $href, $active, $icon])
                <a href="{{ $href }}" class="group flex h-[40px] items-center gap-2.5 rounded-lg px-3 text-[13px] transition {{ $active ? 'bg-[#F4F0FF] font-semibold text-purple' : 'font-medium text-navy hover:bg-[#F8F7FF] hover:text-purple' }}">
                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-md {{ $active ? 'bg-white text-purple' : 'text-purple group-hover:bg-white' }}">
                        <i class="{{ $icon }} text-[14px]"></i>
                    </span>
                    <span class="min-w-0 truncate">{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <a href="{{ route('home') }}" class="mt-4 flex h-[38px] items-center gap-2.5 rounded-lg px-3 text-[13px] font-medium text-[#5A6480] transition hover:bg-gray-50 hover:text-navy">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-md text-[#5A6480]">
                <i class="fa-solid fa-arrow-right-from-bracket text-[14px]"></i>
            </span>
            <span class="truncate">Back to Website</span>
        </a>
    </div>
</aside>
