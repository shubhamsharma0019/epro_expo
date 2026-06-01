@php
    $hideExhibition = request()->is('user/dashboard') || request()->is('user/tickets*') || request()->query('flow') === 'event';

    $items = [
        ['Dashboard', '/user/dashboard', 'user/dashboard', 'fa-solid fa-house'],
        ['Event Tickets', '/user/tickets', 'user/tickets*', 'fa-solid fa-ticket'],
    ];

    if (!$hideExhibition) {
        $items[] = ['Exhibition Tickets', '/user/exhibition-tickets', 'user/exhibition-tickets*', 'fa-regular fa-id-card'];
        $items[] = ['Visit History', '/user/visits', 'user/visits*', 'fa-regular fa-clock'];
        $items[] = ['Saved Exhibitions', '/user/saved/exhibitions', 'user/saved*', 'fa-regular fa-bookmark'];
        $items[] = ['Visited Booths', '/user/booths/visited', 'user/booths*', 'fa-solid fa-store'];
    }

    $items[] = ['Enquiries', '/user/enquiries', 'user/enquiries*', 'fa-regular fa-message'];
    $items[] = ['Profile', '/user/profile', 'user/profile', 'fa-regular fa-user'];
    $items[] = ['Settings', '/user/settings', 'user/settings', 'fa-solid fa-gear'];
@endphp

<aside id="user-sidebar" class="fixed inset-y-0 left-0 z-50 w-[280px] shrink-0 -translate-x-full border-r border-[#E7EAF3] bg-white transition-transform duration-200 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:translate-x-0 lg:overflow-y-auto">
    <div class="flex h-[76px] items-center justify-between px-5 lg:h-[92px]">
        <x-shared.brand-logo href="{{ url('/user/dashboard') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[23px] text-[#071044]" subtitle-class="text-[11px] text-[#8A94AD]" />
        <button type="button" data-user-sidebar-close class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#E7EAF3] text-[#071044] lg:hidden">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="px-4 pb-5">
        <a href="{{ route('home') }}" class="mb-3 flex h-[44px] items-center gap-3 rounded-2xl border border-[#E7EAF3] bg-[#FBFCFF] px-3 text-[14px] text-[#34405F] transition hover:border-[#CFC7F1] hover:bg-[#F4F0FF] hover:text-[#5b2eff]">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-[#5b2eff] shadow-sm">
                <i class="fa-solid fa-house text-[14px]"></i>
            </span>
            <span class="truncate font-medium">Back to Home</span>
        </a>

        @if (!$hideExhibition)
        <div class="rounded-[22px] bg-gradient-to-br from-[#071044] via-[#18206B] to-[#5b2eff] p-4 text-white">
            <p class="text-[12px] font-medium text-white/68">Active pass</p>
            <p class="mt-2 text-[15px] font-medium leading-5">Global Tech Expo</p>
            <div class="mt-4 flex items-center justify-between gap-3">
                <span class="rounded-full bg-white/12 px-3 py-1 text-[11px] font-medium">Confirmed</span>
                <a href="{{ url('/user/exhibition-tickets/1/e-ticket') }}" class="text-[12px] font-medium text-white">Open</a>
            </div>
        </div>
        @endif

        <p class="mb-3 mt-6 px-3 text-[11px] font-medium uppercase tracking-[0.16em] text-[#8A94AD]">Navigation</p>
        <nav class="space-y-1">
            @foreach ($items as [$label, $href, $pattern, $icon])
                @php $active = request()->is($pattern); @endphp
                <a href="{{ url($href) }}" class="group flex h-[44px] items-center gap-3 rounded-2xl px-3 text-[14px] transition {{ $active ? 'bg-[#F4F0FF] text-[#5b2eff]' : 'text-[#34405F] hover:bg-[#F8F5FF] hover:text-[#5b2eff]' }}">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl {{ $active ? 'bg-[#5b2eff] text-white' : 'bg-[#F1F4FB] text-[#7A849D] group-hover:bg-[#EEE8FF] group-hover:text-[#5b2eff]' }}">
                        <i class="{{ $icon }} text-[14px]"></i>
                    </span>
                    <span class="truncate font-medium">{{ $label }}</span>
                    @if ($active)
                        <span class="ml-auto h-2 w-2 rounded-full bg-[#5b2eff]"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        @if (!$hideExhibition)
        <p class="mb-3 mt-6 px-3 text-[11px] font-medium uppercase tracking-[0.16em] text-[#8A94AD]">Explore flows</p>
        <div class="space-y-1">
            <a href="{{ url('/events') }}" class="group flex h-[44px] items-center gap-3 rounded-2xl px-3 text-[14px] text-[#34405F] transition hover:bg-[#F8F5FF] hover:text-[#5b2eff]">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#F1F4FB] text-[#7A849D] group-hover:bg-[#EEE8FF] group-hover:text-[#5b2eff]">
                    <i class="fa-regular fa-calendar text-[14px]"></i>
                </span>
                <span class="truncate font-medium">Event Flow</span>
            </a>
            <a href="{{ url('/exhibitions') }}" class="group flex h-[44px] items-center gap-3 rounded-2xl px-3 text-[14px] text-[#34405F] transition hover:bg-[#F8F5FF] hover:text-[#5b2eff]">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#F1F4FB] text-[#7A849D] group-hover:bg-[#EEE8FF] group-hover:text-[#5b2eff]">
                    <i class="fa-solid fa-building-columns text-[14px]"></i>
                </span>
                <span class="truncate font-medium">Exhibition Flow</span>
            </a>
        </div>
        @endif

        <div class="my-5 h-px bg-[#E7EAF3]"></div>
        <form method="POST" action="{{ url('/user/logout') }}">
            @csrf
            <button type="submit" class="flex h-[44px] w-full items-center gap-3 rounded-2xl px-3 text-left text-[14px] text-[#34405F] transition hover:bg-[#FFF1F2] hover:text-[#E11D48]">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#F1F4FB]"><i class="fa-solid fa-arrow-right-from-bracket text-[14px]"></i></span>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>
