@php
    use App\Domain\Event\Models\Exhibition;
    use App\Domain\Visitor\Models\Visitor;

    $activeSlug = request()->route('slug')
        ?? session('activeExhibitionSlug')
        ?? Exhibition::query()->orderBy('start_date')->value('slug')
        ?? 'global-tech-expo-2024';

    $exhibition = Exhibition::query()->where('slug', $activeSlug)->first();

    $visitor = null;
    if (auth()->check() && $exhibition) {
        $visitor = Visitor::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('email', auth()->user()->email)
            ->orderByDesc('created_at')
            ->first();
    }

    $hasExhibitionPass = $visitor ? $visitor->payment_status === 'completed' : false;
    $passFlowHref = $exhibition
        ? route('exhibitions.tickets.visitor-details', $activeSlug)
        : route('frontend.user.dashboard');
    $passFlowLocked = $exhibition
        && auth()->check()
        && ! $hasExhibitionPass
        && session('exhibition_booking_path');

    $dashboardHref = $passFlowLocked ? $passFlowHref : route('frontend.user.dashboard');
    $passesHref = $passFlowLocked ? $passFlowHref : route('frontend.user.passes');

    $navLinks = [
        [
            'label' => 'Dashboard',
            'href' => $dashboardHref,
            'icon' => 'ph-chart-pie-slice',
            'active' => request()->routeIs('frontend.user.dashboard'),
        ],
    ];

    if ($exhibition) {
        $navLinks = array_merge($navLinks, [
            [
                'label' => 'Exhibition Lobby',
                'href' => route('exhibitions.visit', $activeSlug),
                'icon' => 'ph-door-open',
                'active' => request()->routeIs('exhibitions.visit'),
            ],
            [
                'label' => 'Companies',
                'href' => route('exhibitions.visitor.companies', $activeSlug),
                'icon' => 'ph-storefront',
                'active' => request()->routeIs('exhibitions.visitor.companies*'),
            ],
            [
                'label' => 'Halls & Map',
                'href' => route('exhibitions.visitor.floor-map', $activeSlug),
                'icon' => 'ph-map-trifold',
                'active' => request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.visitor.halls*'),
            ],
            [
                'label' => 'Sessions',
                'href' => route('exhibitions.visitor.sessions', $activeSlug),
                'icon' => 'ph-play-circle',
                'active' => request()->routeIs('exhibitions.visitor.sessions'),
            ],
            [
                'label' => 'My Meetings',
                'href' => route('frontend.user.meetings'),
                'icon' => 'ph-calendar-check',
                'active' => request()->routeIs('frontend.user.meetings'),
            ],
            [
                'label' => 'Notifications',
                'href' => route('frontend.user.dashboard'),
                'icon' => 'ph-bell',
                'active' => request()->routeIs('frontend.user.dashboard'),
            ],
            [
                'label' => 'QR Pass',
                'href' => $passFlowLocked ? $passFlowHref : route('frontend.user.passes'),
                'icon' => 'ph-qr-code',
                'active' => request()->routeIs('frontend.user.passes', 'frontend.user.tickets.*'),
            ],
        ]);
    }

    $navLinks = array_merge($navLinks, [
        [
            'label' => 'My Passes',
            'href' => $passesHref,
            'icon' => 'ph-ticket',
            'active' => request()->routeIs('frontend.user.passes', 'frontend.user.tickets.*'),
        ],
        [
            'label' => 'Upcoming Events',
            'href' => url('/events/listings'),
            'icon' => 'ph-calendar-blank',
            'active' => request()->is('events/listings*'),
        ],
    ]);
@endphp

<aside id="user-sidebar-aside" class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-[#0b1739] font-sans text-[#a0aabf]">
    <div class="flex shrink-0 items-center justify-between border-b border-white/10 px-5 py-5">
        <x-shared.brand-logo
            href="{{ $dashboardHref }}"
            subtitle=""
            mark-class="h-10 w-10 rounded-[14px] text-[18px]"
            title-class="text-[20px] text-white"
            subtitle-class="hidden"
        />
        <button type="button" data-user-sidebar-close data-sidebar-close class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white lg:hidden">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <nav class="custom-scrollbar flex-1 overflow-y-auto px-4 pb-6">
        <ul class="space-y-1">
            @foreach ($navLinks as $link)
                <li>
                    <a
                        href="{{ $link['href'] }}"
                        @class([
                            'flex items-center gap-3 rounded-[10px] px-4 py-3 transition-colors',
                            'bg-[#5B32F6] text-white shadow-[0_8px_20px_rgba(91,50,246,0.22)]' => $link['active'] ?? false,
                            'text-[#a0aabf] hover:bg-white/5 hover:text-white' => ! ($link['active'] ?? false),
                        ])
                    >
                        <i class="ph {{ $link['icon'] }} text-xl"></i>
                        <span class="text-[15px] font-medium">{{ $link['label'] }}</span>
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
