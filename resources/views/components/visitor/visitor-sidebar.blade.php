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
    $passFlowHref = $exhibition ? route('exhibitions.tickets.select', $activeSlug) : route('frontend.user.dashboard');
    $passFlowLocked = $exhibition && auth()->check() && ! $hasExhibitionPass && session('exhibition_booking_path');

    // Define menu items
    $dashboardLink = ['Dashboard', $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard'), request()->routeIs('frontend.user.dashboard'), 'fa-solid fa-chart-pie'];

    $exhibitionLinks = [];
    if ($exhibition) {
        $exhibitionLinks = [
            ['Exhibition Lobby', route('exhibitions.visit', $activeSlug), request()->routeIs('exhibitions.visit'), 'fa-solid fa-door-open'],
            ['Companies', route('exhibitions.visitor.companies', $activeSlug), request()->routeIs('exhibitions.visitor.companies*'), 'fa-solid fa-store'],
            ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.halls.*') || request()->routeIs('exhibitions.visitor-halls.*'), 'fa-regular fa-map'],
            ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), request()->routeIs('exhibitions.visitor.sessions'), 'fa-regular fa-circle-play'],
            ['My Meetings', route('exhibitions.visitor.meetings', $activeSlug), request()->routeIs('exhibitions.visitor.meetings'), 'fa-regular fa-calendar-check'],
            ['Notifications', route('exhibitions.visitor.notifications', $activeSlug), request()->routeIs('exhibitions.visitor.notifications'), 'fa-regular fa-bell'],
            ['QR Pass', $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.qr-pass', $activeSlug), request()->routeIs('exhibitions.visitor.qr-pass'), 'fa-solid fa-qrcode'],
        ];
    }

    $lowerPriorityLinks = [
        ['My Passes', $passFlowLocked ? $passFlowHref : route('frontend.user.tickets.index'), request()->routeIs('frontend.user.tickets.*') || request()->routeIs('frontend.user.exhibition-tickets.*'), 'fa-solid fa-ticket'],
        ['Upcoming Events', url('/events/listings'), request()->is('events/listings*'), 'fa-regular fa-calendar-days'],
        ['My Bookings', url('/exhibitions/booking/my-bookings'), request()->is('exhibitions/booking/my-bookings*'), 'fa-solid fa-calendar-check'],
        ['Profile', route('frontend.user.profile'), request()->routeIs('frontend.user.profile'), 'fa-regular fa-user'],
    ];
@endphp

<div class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-white font-sans text-[#34405F] border-r border-[#E7EAF3]">
    <!-- Logo Section -->
    <div class="py-4 px-5 flex items-center justify-between shrink-0">
        <x-shared.brand-logo 
            href="{{ $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard') }}" 
            subtitle="VISITOR PANEL" 
            mark-class="h-9 w-9 rounded-xl text-[16px]" 
            title-class="text-[20px] text-[#071044]" 
            subtitle-class="text-[9px] text-[#8A94AD]" 
        />
        <button type="button" data-user-sidebar-close data-sidebar-close data-visitor-sidebar-close class="flex h-8 w-8 items-center justify-center rounded-xl border border-[#E7EAF3] text-[#071044] lg:hidden hover:bg-[#F8FAFF]">
            <i class="fa-solid fa-xmark text-md"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto px-3 pb-4 custom-scrollbar">
        <ul class="space-y-1">
            <!-- Dashboard (Priority 1) -->
            <li>
                <a href="{{ $dashboardLink[1] }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors group {{ $dashboardLink[2] ? 'bg-[#F4F0FF] text-[#5b2eff] font-semibold' : 'text-[#475569] hover:bg-[#F8FAFF] hover:text-[#5b2eff]' }}">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $dashboardLink[2] ? 'bg-[#5b2eff] text-white' : 'bg-[#F8FAFF] text-[#8A94AD] group-hover:bg-[#5b2eff]/10 group-hover:text-[#5b2eff]' }}">
                        <i class="{{ $dashboardLink[3] }} text-[12px]"></i>
                    </span>
                    <span class="font-medium text-[13px]">{{ $dashboardLink[0] }}</span>
                    @if ($dashboardLink[2])
                        <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#5b2eff]"></span>
                    @endif
                </a>
            </li>

            <!-- Active Exhibition Section (Priority 2) -->
            @if ($exhibition)
                @foreach ($exhibitionLinks as [$label, $href, $active, $icon])
                    <li>
                        <a href="{{ $href }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors group {{ $active ? 'bg-[#F4F0FF] text-[#5b2eff] font-semibold' : 'text-[#475569] hover:bg-[#F8FAFF] hover:text-[#5b2eff]' }}">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $active ? 'bg-[#5b2eff] text-white' : 'bg-[#F8FAFF] text-[#8A94AD] group-hover:bg-[#5b2eff]/10 group-hover:text-[#5b2eff]' }}">
                                <i class="{{ $icon }} text-[12px]"></i>
                            </span>
                            <span class="font-medium text-[13px]">{{ $label }}</span>
                            @if ($active)
                                <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#5b2eff]"></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            @endif

            <!-- Lower Priority Section (Priority 3) -->
            @foreach ($lowerPriorityLinks as [$label, $href, $active, $icon])
                <li>
                    <a href="{{ $href }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors group {{ $active ? 'bg-[#F4F0FF] text-[#5b2eff] font-semibold' : 'text-[#475569] hover:bg-[#F8FAFF] hover:text-[#5b2eff]' }}">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $active ? 'bg-[#5b2eff] text-white' : 'bg-[#F8FAFF] text-[#8A94AD] group-hover:bg-[#5b2eff]/10 group-hover:text-[#5b2eff]' }}">
                            <i class="{{ $icon }} text-[12px]"></i>
                        </span>
                        <span class="font-medium text-[13px]">{{ $label }}</span>
                        @if ($active)
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#5b2eff]"></span>
                        @endif
                    </a>
                </li>
            @endforeach

            <!-- Account / Preferences -->
            <li class="border-t border-[#E7EAF3]/80 pt-2.5 mt-2.5">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[#475569] hover:bg-[#F8FAFF] hover:text-[#5b2eff] transition-colors group">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-[#F8FAFF] text-[#8A94AD] group-hover:bg-[#5b2eff]/10 group-hover:text-[#5b2eff]">
                        <i class="fa-solid fa-globe text-[12px]"></i>
                    </span>
                    <span class="font-medium text-[13px]">Back to Website</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('frontend.user.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors group text-left bg-transparent border-0 cursor-pointer">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-rose-50 text-rose-500 group-hover:bg-rose-100 group-hover:text-rose-600">
                            <i class="fa-solid fa-power-off text-[12px]"></i>
                        </span>
                        <span class="font-medium text-[13px]">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Hide scrollbar from sidebar completely -->
    <style>
        #user-sidebar::-webkit-scrollbar,
        #exhibition-sidebar::-webkit-scrollbar,
        .custom-scrollbar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        #user-sidebar,
        #exhibition-sidebar,
        .custom-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
    </style>
</div>
