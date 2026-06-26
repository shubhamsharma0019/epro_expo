<header class="border-b border-gray-100 px-4 py-4 md:px-10 md:py-5 flex items-center justify-between bg-white w-full h-full">
    <div class="flex items-center gap-3">
        @unless($hideMobileMenu ?? false)
        <!-- Hamburger Menu for Mobile -->
        <button id="mobile-menu-toggle" data-sidebar-open class="lg:hidden text-gray-500 hover:text-primary-600 focus:outline-none transition p-1.5 rounded-lg hover:bg-gray-100 cursor-pointer">
            <i class="ph ph-list text-[26px]"></i>
        </button>
        @endunless
    </div>
    <div class="flex items-center gap-6 ml-auto">
@php
    $activeSlug = $slug ?? request()->route('slug') ?? 'global-tech-expo-2024';
    $visitorBookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
    $headerVisitor = $visitorBookingId
        ? \App\Domain\Visitor\Models\Visitor::query()->where('booking_id', $visitorBookingId)->latest()->first()
        : null;

    if (! $headerVisitor && auth()->check()) {
        $headerVisitor = \App\Domain\Visitor\Models\Visitor::query()
            ->where('email', auth()->user()->email)
            ->when($activeSlug, function ($query) use ($activeSlug) {
                $query->whereHas('exhibition', fn ($exhibitionQuery) => $exhibitionQuery->where('slug', $activeSlug));
            })
            ->latest()
            ->first();
    }

    $headerName = $headerVisitor
        ? trim($headerVisitor->first_name . ' ' . $headerVisitor->last_name)
        : (auth()->user()->name ?? 'Visitor');
    $headerRole = $headerVisitor ? 'Visitor' : ucfirst(auth()->user()->role ?? 'Visitor');
    $headerInitial = strtoupper(substr(trim($headerName) ?: 'V', 0, 1));
    $passFlowHref = route('exhibitions.tickets.visitor-details', $activeSlug);
    $passFlowLocked = session('exhibition_booking_path') && ! session('visitor_pass_active');

    $drawerPrimaryLinks = [
        ['Visitor Dashboard', $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.dashboard', $activeSlug), request()->routeIs('exhibitions.dashboard') || request()->routeIs('exhibitions.visitor.dashboard'), 'ph ph-house'],
        ['Exhibition Lobby', route('exhibitions.visit', $activeSlug), request()->routeIs('exhibitions.visit'), 'ph ph-monitor-play'],
        ['Browse Exhibitions', route('exhibitions.index'), request()->routeIs('exhibitions.index') || request()->routeIs('exhibitions.browse') || request()->routeIs('exhibitions.show'), 'ph ph-magnifying-glass'],
        ['Companies', route('exhibitions.visitor.companies', $activeSlug), request()->routeIs('exhibitions.visitor.companies*'), 'ph ph-storefront'],
        ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.halls.*') || request()->routeIs('exhibitions.visitor-halls.*'), 'ph ph-map-trifold'],
        ['Get Visitor Pass', route('exhibitions.tickets.visitor-details', $activeSlug), request()->routeIs('exhibitions.tickets.*'), 'ph ph-identification-card'],
    ];

    $drawerVisitorLinks = [
        ['My Passes', $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.my-passes', $activeSlug), request()->routeIs('exhibitions.visitor.my-passes'), 'ph ph-bookmark'],
        ['My Meetings', route('exhibitions.visitor.meetings', $activeSlug), request()->routeIs('exhibitions.visitor.meetings'), 'ph ph-calendar-check'],
        ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), request()->routeIs('exhibitions.visitor.sessions'), 'ph ph-play-circle'],
        ['Notifications', route('exhibitions.visitor.notifications', $activeSlug), request()->routeIs('exhibitions.visitor.notifications'), 'ph ph-bell'],
        ['QR Pass', $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.qr-pass', $activeSlug), request()->routeIs('exhibitions.visitor.qr-pass') || request()->routeIs('exhibitions.tickets.e-ticket'), 'ph ph-qr-code'],
    ];
@endphp
        @auth

        <div class="relative inline-block text-left" id="profileDropdownContainer">
            <button type="button" id="profileDropdownBtn" class="flex items-center gap-3 cursor-pointer pl-4 border-l border-gray-100 hover:opacity-85 transition-opacity focus:outline-none bg-transparent border-0 p-0">
                    <div class="text-right hidden sm:block">
                        <div class="text-[13px] font-bold text-[#1E293B]">{{ $headerName }}</div>
                        <div class="text-[11px] text-gray-500 font-medium">{{ $headerRole }}</div>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#5A32FA] to-[#246BFF] text-[14px] font-medium text-white shadow-sm">
                        {{ $headerInitial }}
                    </span>
                <i class="ph ph-caret-down text-[14px] text-gray-400"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="profileDropdownMenu" class="hidden absolute right-0 z-50 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 focus:outline-none transition-all duration-200 border border-gray-50">
                    <a href="{{ $passFlowLocked ? $passFlowHref : route('exhibitions.visitor.dashboard', $activeSlug) }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-layout text-[16px] text-gray-500"></i>
                        Visitor Dashboard
                    </a>
                    <a href="{{ $passFlowLocked ? $passFlowHref : url('/user/dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-ticket text-[16px] text-gray-500"></i>
                        My Passes
                    </a>
                    <hr class="border-gray-100 my-1">
                    <form method="POST" action="{{ url('/user/logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-red-600 hover:bg-red-50/50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                            <i class="ph ph-sign-out text-[16px] text-red-500"></i>
                            Logout
                        </button>
                    </form>
            </div>
        </div>
        @endauth

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('profileDropdownBtn');
                const menu = document.getElementById('profileDropdownMenu');
                if (btn && menu) {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        menu.classList.toggle('hidden');
                    });
                    document.addEventListener('click', (e) => {
                        if (!btn.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </div>
</header>

