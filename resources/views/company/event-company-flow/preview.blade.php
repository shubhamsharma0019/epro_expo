@extends('layouts.company-event')

@section('title', 'Event Preview | eproexpo')

@section('content')
@php
    $primaryColor = $eventBranding->primary_color ?? '#4C10D0';
    $secondaryColor = $eventBranding->secondary_color ?? '#00B894';
    $accentColor = $eventBranding->accent_color ?? '#FF8A00';
    $eventTitle = $companyEvent->title ?: 'Untitled Company Event';
    $eventHeadline = $eventBranding?->headline ?: $eventTitle;
    $eventTagline = $eventBranding?->tagline ?: $companyEvent->summary ?: 'Event tagline will appear here.';
    $eventSummary = $companyEvent->summary ?: $companyEvent->description ?: 'Add an event summary in Basic Details.';
    $eventDescription = $companyEvent->description ?: $companyEvent->summary ?: 'Add a detailed event description in Basic Details.';
    $eventVenueName = $companyEvent->venue_name ?: 'Venue TBD';
    $eventLocation = \App\Support\LiveContent::formatCompanyEventVenue($companyEvent, 'Location TBD');
    $eventAddress = $eventLocation !== 'Location TBD'
        ? collect(explode(',', $eventLocation))->slice(1)->map(fn ($part) => trim($part))->filter()->join(', ')
        : '';
    $eventDate = $companyEvent->starts_at
        ? $companyEvent->starts_at->format('M d') . ($companyEvent->ends_at ? ' - ' . $companyEvent->ends_at->format('d, Y') : ', ' . $companyEvent->starts_at->format('Y'))
        : 'Date TBD';
    $eventTime = $companyEvent->starts_at
        ? $companyEvent->starts_at->format('h:i A') . ($companyEvent->ends_at ? ' - ' . $companyEvent->ends_at->format('h:i A') : '')
        : 'Time TBD';
    $eventDays = $companyEvent->starts_at && $companyEvent->ends_at
        ? max(1, $companyEvent->starts_at->copy()->startOfDay()->diffInDays($companyEvent->ends_at->copy()->startOfDay()) + 1)
        : 1;
    $ticketTypes = collect($ticketTypes ?? []);
    $eventSessions = collect($eventSessions ?? []);
    $activeTickets = $ticketTypes->where('status', 'active')->values();
    $ticketCapacity = (int) $ticketTypes->sum('quantity_total');
    $eventCapacityValue = (int) ($companyEvent->capacity ?: $ticketCapacity);
    $eventCapacity = $eventCapacityValue > 0 ? number_format($eventCapacityValue) . '+' : '0';
    $sessionCount = $eventSessions->count();
    $ticketCount = $ticketTypes->count();
    $minTicket = $activeTickets->sortBy('price')->first() ?: $ticketTypes->sortBy('price')->first();
    $ticketPriceLabel = $minTicket
        ? (($minTicket->currency ?: 'INR') === 'INR' ? 'Rs.' : ($minTicket->currency ?: 'INR')) . ' ' . number_format((float) $minTicket->price, 0)
        : 'No tickets yet';
    $eventModeLabel = ucfirst(str_replace('_', ' ', $companyEvent->event_mode ?: $companyEvent->event_type ?: 'event'));
    $eventCategoryLabel = $companyEvent->category ?: 'Category TBD';
    $eventInitials = collect(preg_split('/\s+/', trim($eventHeadline)))->filter()->take(3)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('') ?: 'EVT';
    $eventYear = $companyEvent->starts_at?->format('Y') ?? now()->format('Y');
    $logoUrl = $eventBranding?->logo_path ? asset('storage/' . $eventBranding->logo_path) : null;
    $bannerUrl = $eventBranding?->banner_path ? asset('storage/' . $eventBranding->banner_path) : null;
    $brochureUrl = $eventBranding?->brochure_path ? asset('storage/' . $eventBranding->brochure_path) : null;
    $websiteUrl = $companyEvent->website
        ? (\Illuminate\Support\Str::startsWith($companyEvent->website, ['http://', 'https://']) ? $companyEvent->website : 'https://' . $companyEvent->website)
        : null;
    $ctaLabel = $eventBranding?->cta_label ?: ($ticketCount > 0 ? 'Buy Tickets' : 'Tickets Coming Soon');
    $brandingCtaUrl = $eventBranding?->cta_url;
    $ctaUrl = $brandingCtaUrl
        ? (\Illuminate\Support\Str::startsWith($brandingCtaUrl, ['http://', 'https://', '#'])
            ? $brandingCtaUrl
            : 'https://' . $brandingCtaUrl)
        : '#tickets';
    $tabs = collect([
        ['label' => 'About', 'href' => '#about', 'show' => true],
        ['label' => 'Agenda', 'href' => '#agenda', 'show' => $sessionCount > 0],
        ['label' => 'Tickets', 'href' => '#tickets', 'show' => true],
        ['label' => 'Venue', 'href' => '#venue', 'show' => filled($eventLocation) && $eventLocation !== 'Location TBD'],
    ])->filter(fn ($tab) => $tab['show'])->values();
@endphp

<div class="px-4 sm:px-6 md:px-8 py-8 max-w-[1250px] w-full flex flex-col flex-1 pb-20">
    <div class="flex justify-between items-center mb-6">
        <div></div>
        <div class="flex items-center gap-8">
            <a href="{{ route('company.event-company-flow.submit', $companyEvent) }}" style="border-color: {{ $primaryColor }}; color: {{ $primaryColor }};" class="flex items-center gap-2 rounded-lg border bg-white px-5 py-2 text-[13px] font-bold shadow-sm transition-colors hover:bg-gray-50">
                Continue Review
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>

    <div class="relative w-full min-h-[280px] sm:h-[280px] rounded-[16px] overflow-hidden mb-6 shadow-sm bg-cover bg-center bg-no-repeat" style="background-color: {{ $primaryColor }}; @if ($bannerUrl) background-image: url('{{ $bannerUrl }}'); @endif">
        @unless ($bannerUrl)
            <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, #111827 58%, {{ $secondaryColor }} 130%);"></div>
            <div class="absolute right-10 top-10 text-white/10 text-[120px] font-black leading-none">{{ $eventInitials }}</div>
        @endunless
        <div class="absolute inset-0 bg-gradient-to-r from-[#0D0B2E] via-[#0D0B2E]/80 to-transparent"></div>

        <div class="absolute inset-0 p-5 sm:p-10 flex flex-col justify-center">
            <div class="text-white mb-6 max-w-[760px]">
                <div class="text-[20px] font-bold leading-tight mb-2">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $eventTitle }} logo" class="w-12 h-12 rounded-lg object-contain bg-white/90 p-1">
                    @else
                        {{ $eventInitials }}<br>{{ $eventYear }}
                    @endif
                </div>
                <h1 class="text-[20px] min-[400px]:text-[24px] sm:text-[32px] font-bold tracking-tight mb-2">{{ str($eventHeadline)->upper() }}</h1>
                <p class="text-[16px] font-medium text-gray-200">{{ $eventDate }} | {{ $eventLocation }}</p>
                <p class="mt-2 text-[13px] font-medium text-gray-300">{{ $eventTagline }}</p>
            </div>
            <div class="flex flex-wrap gap-3 sm:gap-4">
                <a href="{{ $ctaUrl }}" style="background-color: {{ $primaryColor }}; color: #FFFFFF;" class="px-8 py-3 rounded-lg text-[14px] font-bold hover:opacity-90 transition-opacity shadow-sm">{{ $ctaLabel }}</a>
                @if ($websiteUrl)
                    <a href="{{ $websiteUrl }}" target="_blank" rel="noopener" class="bg-transparent border border-white text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-white/10 transition-colors">Visit Website</a>
                @elseif ($brochureUrl)
                    <a href="{{ $brochureUrl }}" target="_blank" rel="noopener" class="bg-transparent border border-white text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-white/10 transition-colors">View Brochure</a>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-[12px] p-6 grid grid-cols-1 gap-6 shadow-sm mb-6 md:grid-cols-3">
        <div class="flex items-center gap-4 min-w-0">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="color: {{ $primaryColor }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </div>
            <div class="flex min-w-0 flex-col flex-1">
                <span class="font-bold text-[#1C1364] text-[14px] truncate">{{ $eventDays }} {{ str('Day')->plural($eventDays) }}</span>
                <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5 truncate">{{ $eventDate }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4 md:border-l md:border-gray-100 md:pl-6 min-w-0">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="color: {{ $primaryColor }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <div class="flex min-w-0 flex-col flex-1">
                <span class="font-bold text-[#1C1364] text-[14px] truncate" title="{{ $eventVenueName }}">{{ $eventVenueName }}</span>
                <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5 truncate" title="{{ $eventLocation }}">{{ $eventLocation }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4 md:border-l md:border-gray-100 md:pl-6 min-w-0">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="color: {{ $primaryColor }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div class="flex min-w-0 flex-col flex-1">
                <span class="font-bold text-[#1C1364] text-[14px] truncate">{{ $eventCapacity }}</span>
                <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5 truncate">Expected Attendees</span>
            </div>
        </div>

    </div>

    <div class="flex items-center gap-10 border-b border-gray-200 mb-8 px-4 overflow-x-auto">
        @foreach ($tabs as $tab)
            <a href="{{ $tab['href'] }}" style="{{ $loop->first ? 'color: ' . $primaryColor . '; border-color: ' . $primaryColor . ';' : '' }}" class="pb-4 font-bold {{ $loop->first ? 'border-b-2' : 'text-[#1C1364] hover:opacity-85' }} text-[14px] whitespace-nowrap">{{ $tab['label'] }}</a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1fr_350px]">
        <div class="flex flex-col gap-8">
            <div id="about" class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)] h-fit">
                <div class="flex flex-wrap gap-2 mb-5">
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-[12px] font-bold" style="color: {{ $primaryColor }}">{{ $eventModeLabel }}</span>
                    <span class="rounded-full bg-gray-50 px-3 py-1 text-[12px] font-bold text-[#1C1364]">{{ $eventCategoryLabel }}</span>
                    @if ($companyEvent->sub_category)
                        <span class="rounded-full bg-gray-50 px-3 py-1 text-[12px] font-bold text-[#1C1364]">{{ $companyEvent->sub_category }}</span>
                    @endif
                </div>
                <h3 class="text-[16px] font-bold text-[#1C1364] mb-4">About the Event</h3>
                <p class="text-[13px] text-[#5B6B8A] leading-relaxed">{{ $eventSummary }}</p>
                @if ($eventDescription !== $eventSummary)
                    <p class="mt-4 text-[13px] text-[#5B6B8A] leading-relaxed">{{ $eventDescription }}</p>
                @endif
            </div>

            @if ($sessionCount > 0)
                <div id="agenda" class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Agenda</h3>
                    <div class="flex flex-col gap-4">
                        @foreach ($eventSessions->sortBy('starts_at')->take(4) as $session)
                            <div class="flex gap-4 border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <div class="w-[92px] shrink-0 text-[12px] font-bold" style="color: {{ $primaryColor }}">
                                    {{ $session->starts_at?->format('M d') ?: 'Date TBD' }}<br>
                                    <span class="text-[#5B6B8A]">{{ $session->starts_at?->format('h:i A') ?: 'Time TBD' }}</span>
                                </div>
                                <div>
                                    <h4 class="text-[14px] font-bold text-[#1C1364]">{{ $session->title }}</h4>
                                    <p class="mt-1 text-[12px] text-[#5B6B8A]">{{ $session->description ?: ucfirst($session->session_type ?: 'session') }}</p>
                                    @if ($session->location)
                                        <p class="mt-1 text-[12px] font-semibold text-[#1C1364]">{{ $session->location }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div id="venue" class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                <h3 class="text-[16px] font-bold text-[#1C1364] mb-4">Venue & Timing</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-[12px] font-bold text-[#5B6B8A]">Date</p>
                        <p class="mt-1 text-[14px] font-bold text-[#1C1364]">{{ $eventDate }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-bold text-[#5B6B8A]">Time</p>
                        <p class="mt-1 text-[14px] font-bold text-[#1C1364]">{{ $eventTime }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-bold text-[#5B6B8A]">Venue</p>
                        <p class="mt-1 text-[14px] font-bold text-[#1C1364]">{{ $eventVenueName }}</p>
                    </div>
                    <div>
                        <p class="text-[12px] font-bold text-[#5B6B8A]">Address</p>
                        <p class="mt-1 text-[14px] font-bold text-[#1C1364]">{{ $eventAddress ?: $eventLocation }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="tickets" class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)] h-fit flex flex-col">
            <div class="mb-6 flex items-center justify-between gap-4">
                <h3 class="text-[16px] font-bold text-[#1C1364]">Tickets</h3>
                <span class="text-[12px] font-bold text-[#5B6B8A]">{{ $ticketCount }} {{ str('Type')->plural($ticketCount) }}</span>
            </div>

            <div class="flex flex-col gap-6">
                @forelse ($ticketTypes as $ticketType)
                    @php
                        $remaining = $ticketType->quantity_total !== null ? max(0, (int) $ticketType->quantity_total - (int) $ticketType->quantity_sold) : null;
                    @endphp
                    <div class="flex flex-col pb-6 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-start justify-between gap-4 mb-1">
                            <div>
                                <span class="font-bold text-[#1C1364] text-[14px]">{{ $ticketType->name }}</span>
                                @if ($ticketType->description)
                                    <p class="mt-1 text-[12px] text-[#5B6B8A]">{{ $ticketType->description }}</p>
                                @endif
                            </div>
                            <span class="font-bold text-[#1C1364] text-[14px] whitespace-nowrap">{{ ($ticketType->currency ?: 'INR') === 'INR' ? 'Rs.' : ($ticketType->currency ?: 'INR') }} {{ number_format((float) $ticketType->price, 0) }}</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between gap-3">
                            <span class="text-[12px] font-medium text-[#5B6B8A]">{{ ucfirst($ticketType->status ?: 'active') }}</span>
                            <span class="text-[12px] font-medium text-[#5B6B8A]">{{ $remaining !== null ? number_format($remaining) . ' remaining' : 'Capacity open' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-400 text-xs font-medium">No ticket types configured yet.</div>
                @endforelse

                <div class="rounded-[12px] bg-gray-50 p-4">
                    <p class="text-[12px] font-medium text-[#5B6B8A]">Starts from</p>
                    <p class="mt-1 text-[18px] font-bold text-[#1C1364]">{{ $ticketPriceLabel }}</p>
                </div>

                <a href="{{ $ctaUrl }}" style="background-color: {{ $primaryColor }}; color: #FFFFFF;" class="w-full py-3.5 rounded-lg text-[14px] font-bold hover:opacity-95 transition-opacity shadow-sm text-center">
                    {{ $ctaLabel }}
                </a>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-10 shrink-0">
        <a href="{{ route('company.event-company-flow.tickets', $companyEvent) }}" class="px-8 py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-semibold hover:bg-gray-50 transition-colors shadow-sm inline-block">Back</a>
        <a href="{{ route('company.event-company-flow.submit', $companyEvent) }}" style="background-color: {{ $primaryColor }}; color: #FFFFFF;" class="px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:opacity-95 transition-opacity inline-block">Continue</a>
    </div>
</div>
@endsection
