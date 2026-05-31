@php
    $items = [
        ['Dashboard', '/company/dashboard', 'company/dashboard', 'fa-solid fa-house'],
        ['Pavilions', '/company/booth-booking/pavilions', 'company/booth-booking/pavilions', 'fa-regular fa-building'],
        ['Halls', '/company/booth-booking/halls', 'company/booth-booking/halls', 'fa-regular fa-calendar'],
        ['Book Booths', '/company/booth-booking/pavilions', 'company/booth-booking*', 'fa-regular fa-clipboard'],
        ['My Bookings', '/company/bookings', 'company/bookings*', 'fa-regular fa-bookmark'],
        ['Leads', '/company/enquiries', 'company/enquiries*', 'fa-solid fa-users'],
        ['Invoices', '/company/bookings', 'company/bookings*', 'fa-regular fa-file-lines'],
        ['Profile', '/company/profile', 'company/profile', 'fa-regular fa-user'],
        ['Support', '/company/meetings', 'company/meetings*', 'fa-solid fa-headphones'],
        ['Settings', '/company/settings', 'company/settings', 'fa-solid fa-gear'],
    ];

    $sidebarCompany = \App\Models\Company::find(session('company_id'));
    $activeBoothBooking = $sidebarCompany?->boothBookings()
        ->with(['hall', 'booth'])
        ->where('payment_status', 'paid')
        ->whereIn('booking_status', ['confirmed', 'active'])
        ->latest()
        ->first();
@endphp

<aside id="company-sidebar" class="fixed inset-y-0 left-0 z-50 w-[280px] shrink-0 -translate-x-full border-r border-[#E7EAF3] bg-white transition-transform duration-200 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:translate-x-0 lg:overflow-y-auto">
    <div class="flex h-[76px] items-center justify-between px-5 lg:h-[92px]">
        <x-shared.brand-logo href="{{ url('/company/dashboard') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[23px]" subtitle-class="text-[11px]" />

        <button type="button" data-company-sidebar-close class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#E7EAF3] text-[#071044] lg:hidden">
            <i class="fa-solid fa-xmark text-[18px]"></i>
        </button>
    </div>

    <div class="px-4 pb-5">
        @if ($activeBoothBooking)
        <div class="rounded-[22px] bg-gradient-to-br from-[#071044] via-[#172166] to-[#5b2eff] p-4 text-white">
            <p class="text-[12px] font-medium text-white/68">Active booth</p>
            <p class="mt-2 text-[15px] font-medium leading-5">{{ $activeBoothBooking->hall?->name ?? 'Hall' }} - Booth {{ $activeBoothBooking->booth?->booth_number ?? $activeBoothBooking->booth_id }}</p>
            <div class="mt-4 flex items-center justify-between gap-3">
                <span class="rounded-full bg-white/12 px-3 py-1 text-[11px] font-medium capitalize">{{ $activeBoothBooking->booking_status }}</span>
                <a href="{{ url('/company/bookings') }}" class="text-[12px] font-medium text-white">Manage</a>
            </div>
        </div>
        @else
        <div class="rounded-[22px] bg-gray-100 p-4 text-gray-500">
            <p class="text-[12px] font-medium">No active booth</p>
            <p class="mt-2 text-[13px] leading-5">Book a booth to unlock full features.</p>
            <div class="mt-4 flex items-center justify-between gap-3">
                <a href="{{ url('/company/booth-booking/pavilions') }}" class="text-[12px] font-bold text-[#5b2eff]">Book Now</a>
            </div>
        </div>
        @endif

        <p class="mb-3 mt-6 px-3 text-[11px] font-medium uppercase tracking-[0.16em] text-[#8A94AD]">Workspace</p>
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

        <div class="my-5 h-px bg-[#E7EAF3]"></div>
        <form method="POST" action="{{ url('/company/logout') }}">
            @csrf
            <button type="submit" class="flex h-[44px] w-full items-center gap-3 rounded-2xl px-3 text-left text-[14px] text-[#34405F] transition hover:bg-[#FFF1F2] hover:text-[#E11D48]">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#F1F4FB]"><i class="fa-solid fa-arrow-right-from-bracket text-[14px]"></i></span>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>
