@php
    $eventFlowItems = [
        ['Dashboard', route('company.event-company-flow.dashboard'), ['company.event-company-flow.home', 'company.event-company-flow.dashboard*'], 'ph ph-squares-four'],
        ['Create Event', route('company.event-company-flow.create'), ['company.event-company-flow.create*'], 'ph ph-calendar-plus'],
        ['Basic Details', route('company.event-company-flow.basic'), ['company.event-company-flow.basic*'], 'ph ph-note-pencil'],
        ['Branding', route('company.event-company-flow.branding'), ['company.event-company-flow.branding*'], 'ph ph-palette'],
        ['Tickets / Passes', route('company.event-company-flow.tickets'), ['company.event-company-flow.tickets*'], 'ph ph-ticket'],
        ['Preview', route('company.event-company-flow.preview'), ['company.event-company-flow.preview*'], 'ph ph-eye'],
        ['Submit Review', route('company.event-company-flow.submit'), ['company.event-company-flow.submit*', 'company.event-company-flow.payment*'], 'ph ph-paper-plane-tilt'],
    ];
@endphp

<aside id="company-event-sidebar" class="fixed inset-y-0 left-0 z-50 box-border flex h-screen w-[280px] max-w-[86vw] -translate-x-full flex-col overflow-hidden border-r border-gray-100 bg-white px-6 py-8 shadow-[2px_0_10px_rgba(0,0,0,0.02)] transition-transform duration-200 lg:translate-x-0">
    <div class="mb-10 flex shrink-0 items-center justify-between gap-3 pl-2">
        <a href="{{ route('company.event-company-flow.dashboard') }}" class="flex min-w-0 items-center gap-3 no-underline">
            <svg class="h-10 w-10 shrink-0" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 8.5C15.0964 8.5 9.5 14.0964 9.5 21C9.5 27.9036 15.0964 33.5 22 33.5C25.8643 33.5 29.3175 31.7454 31.621 28.9868" stroke="url(#companyEventLogoGradient)" stroke-width="7" stroke-linecap="round" />
                <circle cx="32" cy="11" r="3.5" fill="#FF8A00" />
                <defs>
                    <linearGradient id="companyEventLogoGradient" x1="9.5" y1="33.5" x2="31" y2="8.5" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#5B32F6" />
                        <stop offset="1" stop-color="#FF3366" />
                    </linearGradient>
                </defs>
            </svg>
            <span class="truncate text-[24px] font-bold tracking-tight text-[#1C1364]">eproexpo</span>
        </a>
        <button type="button" data-company-event-sidebar-close class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-[#1C1364] hover:bg-[#F8F9FA] lg:hidden" aria-label="Close event menu">
            <i class="ph ph-x text-2xl"></i>
        </button>
    </div>

    <nav class="flex min-h-0 flex-1 flex-col gap-1.5 overflow-y-auto overflow-x-hidden [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($eventFlowItems as [$label, $href, $patterns, $icon])
            @php
                $isActive = collect($patterns)->contains(fn ($pattern) => request()->routeIs($pattern)) || url()->current() === $href;
            @endphp
            <a href="{{ $href }}" @if ($isActive) aria-current="page" style="background-color: #4C10D0; box-shadow: 0 10px 20px rgba(76,16,208,0.24);" @endif class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors {{ $isActive ? 'font-semibold text-white' : 'font-medium text-[#1C1364] hover:bg-[#F8F9FA]' }}">
                <i class="{{ $icon }} shrink-0 text-[21px] {{ $isActive ? 'text-white' : 'text-[#1C1364]' }}"></i>
                <span class="truncate">{{ $label }}</span>
            </a>
        @endforeach
    </nav>

</aside>
