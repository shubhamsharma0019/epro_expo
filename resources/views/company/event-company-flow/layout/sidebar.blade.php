@php
    $eventFlowCompany = $currentCompany
        ?? ($companyEvent->company ?? null)
        ?? (session('company_id') ? \App\Domain\Company\Models\Company::find(session('company_id')) : null);
    $eventFlowCompanyName = $eventFlowCompany?->company_name ?? $eventFlowCompany?->name ?? 'Company';
    $eventFlowContactName = $eventFlowCompany?->contact_person_name ?? $eventFlowCompany?->owner_name ?? $eventFlowCompanyName;
    $eventFlowInitials = collect(preg_split('/\s+/', trim((string) $eventFlowContactName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->join('') ?: 'C';

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
    <div class="mb-10 flex shrink-0 items-center justify-between gap-3">
        <x-shared.brand-logo
            href="{{ route('company.event-company-flow.dashboard') }}"
            subtitle="EVENT SUITE"
            mark-class="h-10 w-10 rounded-[14px] text-[19px]"
            title-class="text-[24px] text-[#071044]"
            subtitle-class="text-[10px] text-[#8A94AD]"
        />
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
        <form method="POST" action="{{ route('company.logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="flex w-full min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-left text-[15px] font-medium text-[#1C1364] transition-colors hover:bg-[#F8F9FA]">
                <i class="ph ph-sign-out shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Logout</span>
            </button>
        </form>
    </nav>

    <div class="mt-5 shrink-0 border-t border-gray-100 pt-5">
        <a href="{{ route('company.profile', ['flow' => 'event']) }}" class="flex min-w-0 items-center gap-3 rounded-xl px-2 py-2 text-[#1C1364] no-underline transition-colors hover:bg-[#F8F9FA]">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gray-100 text-sm font-bold text-[#5B32F6]">{{ $eventFlowInitials }}</span>
            <span class="min-w-0 flex-1">
                <span class="block truncate text-sm font-semibold">{{ $eventFlowContactName }}</span>
                <span class="block truncate text-xs text-[#6B7280]">{{ $eventFlowCompanyName }}</span>
            </span>
            <i class="ph ph-caret-down shrink-0 text-base text-[#1C1364]"></i>
        </a>
    </div>
</aside>
