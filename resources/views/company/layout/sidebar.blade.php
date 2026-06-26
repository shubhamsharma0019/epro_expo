@php
    $sidebarCompany = $currentCompany ?? (session('company_id') ? \App\Domain\Company\Models\Company::find(session('company_id')) : null);
    $sidebarLatestBooking = $latestBooking ?? $sidebarCompany?->boothBookings()
        ->where('payment_status', 'paid')
        ->whereIn('booking_status', ['confirmed', 'active'])
        ->latest()
        ->first();
    $boothSetupHrefForSidebar = $sidebarLatestBooking
        ? route('company.booth-setup.index', $sidebarLatestBooking)
        : route('company.exhibitions.index');
    $meetingHrefForSidebar = route('company.meetings.index');
    $sidebarNotificationCount = ($stats['enquiries_count'] ?? $sidebarCompany?->enquiries()->count() ?? 0)
        + ($stats['meetings_count'] ?? $sidebarCompany?->visitorMeetingBookings()->count() ?? 0);

    $sidebarItems = [
        ['Dashboard', route('company.dashboard'), ['company.dashboard'], [], 'ph ph-squares-four'],

        ['Pavilions', route('company.booth-booking.pavilions'), ['company.booth-booking.pavilions'], [], 'ph ph-bank'],
        ['Halls', route('company.booth-booking.halls'), ['company.booth-booking.halls'], [], 'ph ph-buildings'],
        ['Book Booths', route('company.exhibitions.index'), ['company.booth-booking.floor-plan*', 'company.booth-booking.sizes*', 'company.booth-booking.slots*', 'company.booth-booking.summary', 'company.booth-booking.services*', 'company.booth-booking.review', 'company.booth-booking.payment*', 'company.booth-booking.confirmed'], [], 'ph ph-grid-four'],
        ['My Bookings', route('company.bookings.index'), ['company.bookings.index', 'company.bookings.show'], [], 'ph ph-calendar-check'],
        ['Booth Setup', $boothSetupHrefForSidebar, ['company.booth-setup.*', 'company.booth-setup.legacy*'], ['company/bookings/*/setup*', 'company/booth-setup*'], 'ph ph-storefront'],
        ['Enquiries / Leads', route('company.enquiries.index'), ['company.enquiries.*'], [], 'ph ph-user-list'],
        ['Meeting Request', $meetingHrefForSidebar, ['company.meetings.*'], [], 'ph ph-users'],
        ['Analytics', route('company.analytics'), ['company.analytics'], [], 'ph ph-chart-bar'],
        ['Payments / Invoices', route('company.payments-invoices'), ['company.payments-invoices', 'company.bookings.invoice'], ['company/payments-invoices', 'company/bookings/*/invoice'], 'ph ph-receipt'],
        ['Profile', route('company.profile'), ['company.profile', 'company.profile.update'], [], 'ph ph-user-circle'],
        ['Notification', route('company.notifications'), ['company.notifications'], [], 'ph ph-bell'],
    ];
@endphp

<aside id="company-sidebar" class="fixed inset-y-0 left-0 z-50 flex h-screen w-[300px] max-w-[86vw] shrink-0 -translate-x-full flex-col overflow-y-auto overflow-x-hidden border-r border-gray-100 bg-white px-5 py-4 shadow-sm transition-transform duration-200 lg:static lg:z-30 lg:w-[280px] lg:max-w-none lg:translate-x-0">
    <div class="mb-3 flex h-[68px] shrink-0 items-center justify-between px-3">
        <x-shared.brand-logo href="{{ url('/company/dashboard') }}" mark-class="h-9 w-9 rounded-[13px] text-[18px]" title-class="text-[24px] text-[#071044]" subtitle-class="text-[9px] text-[#8A94AD]" subtitle="EXHIBITOR CENTRE" />
        <button type="button" data-company-sidebar-close class="grid h-10 w-10 place-items-center rounded-xl text-gray-500 hover:bg-gray-50 lg:hidden">
            <i class="ph ph-x text-2xl"></i>
        </button>
    </div>

    <ul class="flex flex-1 list-none flex-col gap-1.5 pb-3">
        @foreach ($sidebarItems as $item)
            @php
                [$label, $href, $routePatterns, $pathPatterns, $icon] = $item;
                $isActive = collect($routePatterns)->contains(fn ($pattern) => request()->routeIs($pattern))
                    || collect($pathPatterns)->contains(fn ($pattern) => request()->is($pattern));
                $isNotification = $label === 'Notification';
            @endphp
            <li>
                <a href="{{ $href }}" @if ($isActive) aria-current="page" @endif class="flex min-w-0 items-center rounded-xl px-5 py-3 text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 {{ $isActive ? 'bg-[#f4f2ff] text-[#3b18ff]' : '' }}">
                    <span class="relative flex shrink-0 items-center">
                        <i class="{{ $icon }} mr-4 text-[22px] transition-colors duration-200 {{ $isActive ? 'text-[#3b18ff]' : 'text-gray-900' }}"></i>
                        @if ($isNotification && $sidebarNotificationCount > 0)
                            <span class="absolute right-4 top-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-red-600"></span>
                        @endif
                    </span>
                    <span class="min-w-0 truncate text-base font-medium">{{ $label }}</span>
                </a>
            </li>
        @endforeach

        <li class="pt-2">
            <form method="POST" action="{{ route('company.logout') }}">
                @csrf
                <button type="submit" class="flex w-full min-w-0 items-center rounded-xl px-5 py-3 text-left text-gray-900 transition-all duration-200 hover:bg-gray-50">
                    <i class="ph ph-sign-out mr-4 shrink-0 text-[22px] text-gray-900 transition-colors duration-200"></i>
                    <span class="min-w-0 truncate text-base font-medium">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</aside>
