@php
    $activeSlug = request()->route('slug')
        ?? session('activeExhibitionSlug')
        ?? \App\Domain\Event\Models\Exhibition::orderBy('start_date')->first()?->slug
        ?? 'global-tech-expo-2024';

    $exhibition = \App\Domain\Event\Models\Exhibition::where('slug', $activeSlug)->first();
    $visitor = null;
    if (auth()->check() && $exhibition) {
        $visitor = \App\Domain\Visitor\Models\Visitor::where('exhibition_id', $exhibition->id)
            ->where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    $hasExhibitionPass = $visitor ? $visitor->payment_status === 'completed' : false;
    $passFlowHref = $exhibition ? route('exhibitions.tickets.visitor-details', $activeSlug) : route('frontend.user.dashboard');
    $passFlowLocked = $exhibition && auth()->check() && ! $hasExhibitionPass && session('exhibition_booking_path');

    $navLinks = [
        ['Dashboard', $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard'), 'ph-chart-pie-slice'],
    ];

    if ($exhibition) {
        $navLinks = array_merge($navLinks, [
            ['Exhibition Lobby', route('exhibitions.visit', $activeSlug), 'ph-door-open'],
            ['Companies', route('exhibitions.visitor.companies', $activeSlug), 'ph-storefront'],
            ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), 'ph-map-trifold'],
            ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), 'ph-play-circle'],
            ['My Meetings', route('exhibitions.visitor.meetings', $activeSlug), 'ph-calendar-check'],
            ['Notifications', route('exhibitions.visitor.notifications', $activeSlug), 'ph-bell'],
            ['QR Pass', $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.qr-pass', $activeSlug), 'ph-qr-code'],
        ]);
    }

    $navLinks = array_merge($navLinks, [
        ['My Passes', $passFlowLocked ? $passFlowHref : route('frontend.user.tickets.index'), 'ph-ticket'],
        ['Upcoming Events', url('/events/listings'), 'ph-calendar-blank'],
        ['My Bookings', url('/exhibitions/booking/my-bookings'), 'ph-calendar-check'],
        ['Profile', route('frontend.user.profile'), 'ph-user'],
    ]);
@endphp

<aside id="user-sidebar-aside" class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-[#0b1739] font-sans text-[#a0aabf]">
    <div class="flex shrink-0 items-center justify-between border-b border-white/10 px-5 py-5">
        <x-shared.brand-logo
            href="{{ $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard') }}"
            subtitle="VISITOR PANEL"
            mark-class="h-10 w-10 rounded-[14px] text-[18px]"
            title-class="text-[20px] text-white"
            subtitle-class="text-[10px] text-[#a0aabf]"
        />
        <button type="button" data-user-sidebar-close data-sidebar-close class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white lg:hidden">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <nav class="custom-scrollbar flex-1 overflow-y-auto px-4 pb-6">
        <ul class="space-y-1">
            @foreach ($navLinks as [$label, $href, $icon])
                <li>
                    <a href="{{ $href }}" class="flex items-center gap-3 rounded-[10px] px-4 py-3 text-[#a0aabf] transition-colors hover:bg-white/5 hover:text-white">
                        <i class="ph {{ $icon }} text-xl"></i>
                        <span class="text-[15px] font-medium">{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-white/10 px-4 py-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-[10px] px-4 py-3 text-[#a0aabf] transition-colors hover:bg-white/5 hover:text-white">
                    <i class="ph ph-globe text-xl"></i>
                    <span class="text-[15px] font-medium">Back to Website</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('frontend.user.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-[10px] border-0 bg-transparent px-4 py-3 text-left text-rose-300 transition-colors hover:bg-rose-500/10 hover:text-rose-200">
                        <i class="ph ph-sign-out text-xl"></i>
                        <span class="text-[15px] font-medium">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</aside>
