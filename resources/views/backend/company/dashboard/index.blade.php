@extends('layouts.company')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    $companyDisplayName = $currentCompany->company_name ?? $currentCompany->name ?? 'Company';
    $contactName = $currentCompany->contact_person_name ?? $currentCompany->owner_name ?? $companyDisplayName;
    $selectedExhibition = optional(optional($latestBooking)->exhibition)->title ?? ($pendingBooking ? optional($pendingBooking->exhibition)->title : 'No active exhibition');
    $setupHref = $latestBooking 
        ? route('company.booth-setup.index', $latestBooking) 
        : ($pendingBooking ? '#' : url('/company/exhibitions'));
    $publicBoothHref = ($latestBooking && $latestBooking->exhibition)
        ? route('exhibitions.booths.show', [
            $latestBooking->exhibition->slug,
            \Illuminate\Support\Str::slug(optional($latestBooking->boothProfile)->company_name ?: $currentCompany->company_name ?: $currentCompany->name),
        ])
        : null;
    $floorPlanHref = $latestBooking
        ? url('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
            'hall' => $latestBooking->hall_id,
            'booth' => $latestBooking->booth_id,
            'size' => $latestBooking->booth_size_id,
        ])))
        : ($pendingBooking
            ? url('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $pendingBooking->hall_id,
                'booth' => $pendingBooking->booth_id,
                'size' => $pendingBooking->booth_size_id,
            ])))
            : url('/company/exhibitions'));
    $selectedBoothCount = $latestBooking ? collect($latestBooking->selected_booth_ids ?: [$latestBooking->booth_id])->filter()->unique()->count() : ($pendingBooking ? collect($pendingBooking->selected_booth_ids ?: [$pendingBooking->booth_id])->filter()->unique()->count() : 0);
    $boothNumber = $latestBooking
        ? ($selectedBoothCount > 1 ? $selectedBoothCount . ' linked booths' : optional($latestBooking->booth)->booth_number)
        : ($pendingBooking 
            ? ($selectedBoothCount > 1 ? $selectedBoothCount . ' linked booths' : optional($pendingBooking->booth)->booth_number) 
            : null);
    $bookingId = $latestBooking ? 'BOOK-' . str_pad((string) $latestBooking->id, 5, '0', STR_PAD_LEFT) : ($pendingBooking ? 'BOOK-' . str_pad((string) $pendingBooking->id, 5, '0', STR_PAD_LEFT) : 'Not booked');
    $bookingDate = optional(optional($latestBooking ?? $pendingBooking)->created_at)->format('M d, Y') ?? 'Not booked';
    $boothSize = optional(optional($latestBooking ?? $pendingBooking)->boothSize)->title ?? 'Not selected';
    $bookedStepActive = (bool) ($latestBooking ?? $pendingBooking);
    $setupStepActive = $bookedStepActive && ($boothSetup['progress_percent'] ?? 0) > 0 && $latestBooking;
    $liveStepActive = $bookedStepActive && in_array(optional($latestBooking)->booth_setup_status, ['published', 'approved', 'live'], true);
    $isBoothLive = (bool) $liveStepActive;
    $primaryBoothHref = $isBoothLive && $publicBoothHref ? $publicBoothHref : $setupHref;
    $primaryBoothTarget = $isBoothLive && $publicBoothHref ? '_blank' : null;
    $eventCompleted = $latestBooking && in_array($latestBooking->booking_status, ['completed', 'closed'], true);
    $setupStatusLabel = $latestBooking
        ? match ($latestBooking->booth_setup_status ?? 'draft') {
            'pending_review', 'submitted_for_review' => 'Pending Review',
            'published', 'approved', 'live' => 'Live',
            'setup_in_progress', 'ready_to_publish', 'in_progress' => 'Continue Setup',
            default => (($boothSetup['preview_status'] ?? '') === 'Ready' ? 'Setup Ready' : 'Setup Pending'),
        }
        : ($pendingBooking ? 'Pending Approval' : 'Book Booth First');
    $setupStatusCopy = $latestBooking
        ? match ($latestBooking->booth_setup_status ?? 'draft') {
            'published', 'approved', 'live' => 'Your booth is live on the website. Visitors can now view it and interact with your content.',
            'pending_review', 'submitted_for_review' => 'Your booth has been submitted and is waiting for review.',
            default => 'Complete your booth setup to start showcasing your brand.',
        }
        : ($pendingBooking 
            ? 'Your booth booking is currently pending review. Setup will unlock upon approval.' 
            : 'Book a booth to unlock setup, meetings, leads, and booth editing.');
    $setupButtonLabel = $isBoothLive ? 'View Live Booth' : ($latestBooking && ($boothSetup['progress_percent'] ?? 0) > 0 ? 'Continue Setup' : ($latestBooking ? 'Setup Your Booth' : ($pendingBooking ? 'Awaiting Approval' : 'Book Booth')));
    $flowTitle = $isBoothLive ? 'Your booth is live' : 'Book a booth and set up your profile';
    $flowCopy = $isBoothLive ? 'Visitors can now discover your booth, products, documents, sessions, and meeting options.' : 'Secure your spot at an upcoming exhibition, then build your booth profile with products, documents, and a dedicated team.';
    $flowSecondaryLabel = $isBoothLive ? 'View Live Booth' : 'Booth Setup';
    $statusCardTitle = $isBoothLive ? 'Booth Status' : 'Setup Status';
    $statusBadgeClass = $isBoothLive ? 'bg-success-light text-success' : ($latestBooking ? 'bg-warning-light text-warning' : 'bg-gray-100 text-gray-500');
    $statusCardClass = $isBoothLive ? 'border-success-light bg-[#f6fffb]' : 'border-[#fce9d7] bg-[#fffaf5]';
    $statusIconClass = $isBoothLive ? 'border-success-light text-success' : 'border-warning-light text-warning';
    $dashboardBookings = collect($recentBookings ?? []);
    $performancePoints = collect($performanceData['points'] ?? []);
    $performanceAxisLabels = collect($performanceData['axis_labels'] ?? []);
    $performanceValues = collect($performanceData['values'] ?? []);
@endphp

<section class="mx-auto w-full max-w-[1400px] p-4 sm:p-6 lg:p-8">
    @if ($pendingBooking)
        <div class="mb-8 rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm sm:p-6">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-100 text-yellow-700">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Booking Pending Approval</h3>
                    <p class="mt-1.5 text-[14px] leading-relaxed text-gray-600">
                        Your booking for <strong>{{ $pendingBooking->exhibition->title }}</strong> (Booth <strong>{{ $pendingBooking->booth->booth_number ?? '' }}</strong>) is currently pending admin approval. You will be able to set up your booth profile and publish it once approved.
                    </p>
                </div>
            </div>
        </div>
    @elseif (!$latestBooking)
        <div class="mb-8 rounded-2xl border border-[#E4DEFF] bg-[#FBFAFF] p-5 shadow-sm sm:p-6">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Ready to showcase?</h3>
                    <p class="mt-1 text-[14px] text-gray-600">Book a booth at an upcoming exhibition to showcase your products, capture leads, and arrange B2B meetings.</p>
                </div>
                <a href="{{ url('/company/exhibitions') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white shadow-sm transition-colors hover:bg-blue-700">
                    <i class="ph ph-calendar-plus text-lg"></i>
                    Book a Booth Now
                </a>
            </div>
        </div>
    @endif

    <div class="mb-8 flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
        <div>
            <h2 class="mb-1 flex items-center gap-2 text-[24px] font-bold leading-tight text-gray-900 sm:text-[28px]">
                Welcome back, {{ $contactName }}!
            </h2>
            <p class="text-[14px] leading-6 text-gray-500 sm:text-[15px]">
                {{ $companyDisplayName }} | {{ $currentCompany->email ?? 'No email available' }} | {{ ucfirst($currentCompany->status ?? 'pending') }}
            </p>
        </div>

        <div class="relative w-full sm:min-w-[240px] lg:w-auto">
            <select onchange="if (this.value) window.location.href = this.value" class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-4 pr-10 font-medium text-gray-700 shadow-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">{{ $selectedExhibition }}</option>
                @if ($dashboardBookings->isNotEmpty())
                    <optgroup label="Your booked exhibitions">
                        @foreach ($dashboardBookings as $bookingOption)
                            @php
                                $canOpenSetup = $bookingOption->payment_status === 'paid'
                                    && in_array($bookingOption->booking_status, ['confirmed', 'active'], true)
                                    && $bookingOption->admin_status === 'approved';
                            @endphp
                            <option value="{{ $canOpenSetup ? route('company.booth-setup.index', $bookingOption) : url('/company/bookings') }}">
                                {{ $bookingOption->exhibition?->title ?? 'Exhibition' }} - {{ $canOpenSetup ? 'Manage setup' : 'Booking status' }}
                            </option>
                        @endforeach
                    </optgroup>
                @endif
                <option value="{{ route('company.exhibitions.index') }}">Book another exhibition booth</option>
                @foreach (($availableExhibitions ?? collect()) as $exhibitionOption)
                    <option value="{{ route('company.booth-booking.pavilions', ['exhibition' => $exhibitionOption->slug]) }}">
                        Book booth: {{ $exhibitionOption->title }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                <i class="ph ph-caret-down"></i>
            </div>
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary-light text-primary">
                    <i class="ph ph-storefront text-2xl"></i>
                </div>
                <div>
                    <p class="mb-1 text-[13px] font-medium text-gray-500">Total Booths</p>
                    <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['total_bookings'] ?? 0) }}</h3>
                </div>
            </div>
            <div class="mt-2 text-[13px] font-medium text-gray-500">
                {{ number_format($stats['confirmed_bookings'] ?? 0) }} Active
            </div>
        </div>

        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-success-light text-success">
                    <i class="ph ph-users text-2xl"></i>
                </div>
                <div>
                    <p class="mb-1 text-[13px] font-medium text-gray-500">Total Visitors</p>
                    <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['booth_views_count'] ?? 0) }}</h3>
                </div>
            </div>
            <div class="mt-2 flex items-center text-[13px] font-bold text-success">
                <i class="ph ph-arrow-up mr-1"></i> Booth views
            </div>
        </div>

        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-warning-light text-warning">
                    <i class="ph ph-user-list text-2xl"></i>
                </div>
                <div>
                    <p class="mb-1 text-[13px] font-medium text-gray-500">Total Leads</p>
                    <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['enquiries_count'] ?? 0) }}</h3>
                </div>
            </div>
            <a href="{{ url('/company/enquiries') }}" class="mt-2 flex items-center text-[13px] font-bold text-success">
                <i class="ph ph-arrow-up mr-1"></i> Enquiries
            </a>
        </div>

        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-light text-purple">
                    <i class="ph ph-users-three text-2xl"></i>
                </div>
                <div>
                    <p class="mb-1 text-[13px] font-medium text-gray-500">Upcoming Meetings</p>
                    <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['meetings_count'] ?? 0) }}</h3>
                </div>
            </div>
            <a href="{{ url('/company/meetings') }}" class="mt-2 text-[13px] font-medium text-gray-500 transition-colors hover:text-primary">
                View All
            </a>
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-1 text-[13px] font-medium text-gray-500">Products</p>
            <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['products_count'] ?? 0) }}</h3>
            <a href="{{ $latestBooking ? route('company.booth-setup.products.index', $latestBooking) : url('/company/exhibitions') }}" class="mt-4 text-[13px] font-bold text-primary">Manage Products</a>
        </div>
        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-1 text-[13px] font-medium text-gray-500">Documents</p>
            <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['documents_count'] ?? 0) }}</h3>
            <a href="{{ $latestBooking ? route('company.booth-setup.documents.index', $latestBooking) : url('/company/exhibitions') }}" class="mt-4 text-[13px] font-bold text-primary">Manage Documents</a>
        </div>
        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-1 text-[13px] font-medium text-gray-500">Catalogues</p>
            <h3 class="text-[28px] font-bold leading-none text-gray-900">{{ number_format($stats['catalogues_count'] ?? 0) }}</h3>
            <a href="{{ $latestBooking ? route('company.booth-setup.catalogues.index', $latestBooking) : url('/company/exhibitions') }}" class="mt-4 text-[13px] font-bold text-primary">Manage Catalogues</a>
        </div>
        <div class="flex flex-col justify-between rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-1 text-[13px] font-medium text-gray-500">Total Spend</p>
            <h3 class="text-[28px] font-bold leading-none text-gray-900">&#8377;{{ number_format($stats['total_spend'] ?? 0, 2) }}</h3>
            <a href="{{ url('/company/bookings') }}" class="mt-4 text-[13px] font-bold text-primary">View Bookings</a>
        </div>
    </div>


    <div class="mb-8 rounded-2xl border border-[#3b18ff]/10 bg-[#f4f2ff] p-6 sm:p-8">
        <div class="flex flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex-1">
                <h2 class="mb-2 text-[11px] font-bold uppercase tracking-[0.15em] text-[#3b18ff]">EXHIBITOR FLOW</h2>
                <h3 class="mb-3 text-2xl font-bold text-gray-900 sm:text-[28px]">{{ $flowTitle }}</h3>
                <p class="max-w-2xl text-[15px] leading-relaxed text-gray-600">{{ $flowCopy }}</p>
            </div>
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row w-full lg:w-auto">
                <a href="{{ url('/company/exhibitions') }}" class="flex h-12 w-full min-w-[180px] items-center justify-center gap-2 rounded-xl border-2 border-[#3b18ff] bg-[#3b18ff] px-6 text-[15px] font-bold text-white shadow-sm shadow-[#3b18ff]/20 transition-all hover:bg-[#3111e8] hover:shadow-md hover:-translate-y-0.5 sm:w-auto">
                    <i class="ph ph-calendar-plus text-xl"></i>
                    Book Booth
                </a>
                <a href="{{ $primaryBoothHref }}" @if($primaryBoothTarget) target="{{ $primaryBoothTarget }}" @endif class="flex h-12 w-full min-w-[180px] items-center justify-center gap-2 rounded-xl border-2 border-transparent bg-white px-6 text-[15px] font-bold text-[#3b18ff] shadow-sm transition-all hover:bg-gray-50 sm:w-auto">
                    <i class="{{ $isBoothLive ? 'ph ph-eye' : 'ph ph-storefront' }} text-xl"></i>
                    {{ $flowSecondaryLabel }}
                </a>
            </div>
        </div>
    </div>

    <div class="mb-8 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Your Exhibition Booths</h3>
                <p class="mt-1 text-[13px] leading-5 text-gray-500 sm:text-sm">Manage booth setup for any exhibition from this company dashboard.</p>
            </div>
            <a href="{{ url('/company/exhibitions') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-bold text-white shadow-sm transition-colors hover:bg-blue-700">
                <i class="ph ph-plus-circle text-lg"></i>
                Book Another Booth
            </a>
        </div>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
            @forelse ($dashboardBookings as $bookingItem)
                @php
                    $itemCanSetup = $bookingItem->payment_status === 'paid'
                        && in_array($bookingItem->booking_status, ['confirmed', 'active'], true)
                        && $bookingItem->admin_status === 'approved';
                    $itemIsLive = $itemCanSetup && in_array($bookingItem->booth_setup_status, ['published', 'approved', 'live'], true);
                    $itemCompanyName = $bookingItem->boothProfile?->company_name ?: $currentCompany->company_name ?: $currentCompany->name;
                    $itemPublicHref = ($itemIsLive && $bookingItem->exhibition)
                        ? route('exhibitions.booths.show', [$bookingItem->exhibition->slug, \Illuminate\Support\Str::slug($itemCompanyName)])
                        : null;
                    $itemProgress = $itemCanSetup
                        ? min(
                            ($currentCompany->isProfileComplete() ? 15 : 0)
                            + ($bookingItem->boothProfile ? 15 : 0)
                            + (($bookingItem->booth_products_count ?? 0) > 0 ? 15 : 0)
                            + (($bookingItem->booth_documents_count ?? 0) > 0 ? 10 : 0)
                            + (($bookingItem->booth_catalogues_count ?? 0) > 0 ? 10 : 0)
                            + (($bookingItem->booth_media_count ?? 0) > 0 ? 10 : 0)
                            + (($bookingItem->booth_team_members_count ?? 0) > 0 ? 10 : 0)
                            + (($bookingItem->booth_meeting_slots_count ?? 0) > 0 ? 10 : 0)
                            + (in_array($bookingItem->booth_setup_status, ['ready_to_publish', 'pending_review', 'published', 'approved', 'live'], true) ? 5 : 0),
                            100
                        )
                        : 0;
                    $itemStatus = $itemIsLive ? 'Live' : ($itemCanSetup ? 'Setup Available' : ucfirst(str_replace('_', ' ', $bookingItem->admin_status ?: $bookingItem->booking_status ?: 'pending')));
                @endphp
                <article class="rounded-xl border border-gray-100 bg-[#FBFCFF] p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h4 class="truncate text-base font-bold text-gray-900">{{ $bookingItem->exhibition?->title ?? 'Exhibition' }}</h4>
                            <p class="mt-1 text-[12px] font-semibold text-gray-500">BOOK-{{ str_pad((string) $bookingItem->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <span class="shrink-0 rounded-md px-3 py-1 text-[11px] font-bold {{ $itemIsLive ? 'bg-success-light text-success' : ($itemCanSetup ? 'bg-warning-light text-warning' : 'bg-gray-100 text-gray-500') }}">{{ $itemStatus }}</span>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3 text-[12px] font-semibold text-gray-600">
                        <p><span class="block text-[10px] uppercase tracking-[0.08em] text-gray-400">Hall</span>{{ $bookingItem->hall?->title ?? 'Not assigned' }}</p>
                        <p><span class="block text-[10px] uppercase tracking-[0.08em] text-gray-400">Booth</span>{{ $bookingItem->booth?->booth_number ? 'Booth ' . $bookingItem->booth->booth_number : 'Not assigned' }}</p>
                    </div>

                    <div class="mt-4">
                        <div class="mb-1 flex items-center justify-between text-[11px] font-bold text-gray-500">
                            <span>Setup Progress</span>
                            <span>{{ $itemProgress }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full {{ $itemIsLive ? 'bg-success' : 'bg-primary' }}" style="width: {{ $itemProgress }}%"></div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                        @if ($itemCanSetup)
                            <a href="{{ route('company.booth-setup.index', $bookingItem) }}" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg bg-primary px-4 text-[13px] font-bold text-white">
                                {{ $itemIsLive ? 'Manage Booth' : 'Continue Setup' }}
                            </a>
                        @else
                            <a href="{{ url('/company/bookings') }}" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg bg-gray-100 px-4 text-[13px] font-bold text-gray-600">
                                View Status
                            </a>
                        @endif
                        @if ($itemPublicHref)
                            <a href="{{ $itemPublicHref }}" target="_blank" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-primary px-4 text-[13px] font-bold text-primary">
                                View Live
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-gray-200 bg-[#FBFCFF] p-5 text-sm font-semibold text-gray-500">
                    No booths booked yet. Start with a new exhibition booth booking.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex flex-col rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 lg:col-span-2">
            <h3 class="mb-6 text-lg font-bold text-gray-900">Booth Overview</h3>

            <div class="relative mb-8 mt-2 px-2 py-2 sm:px-10">
                <div class="absolute left-10 right-10 top-8 z-0 hidden h-0.5 bg-gray-200 sm:block"></div>
                <div class="absolute left-10 top-8 z-0 hidden h-0.5 bg-primary sm:block {{ $bookedStepActive ? 'w-[33%]' : 'w-0' }}"></div>
                <div class="absolute left-[calc(10px+33%)] top-8 z-0 hidden h-0.5 bg-warning sm:block {{ $setupStepActive ? 'w-[33%]' : 'w-0' }}"></div>

                <div class="relative z-10 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center sm:gap-0">
                    @foreach ([
                        ['Booth Booked', 'ph ph-briefcase', $bookedStepActive, 'success'],
                        ['Booth Setup', 'ph ph-storefront', $setupStepActive, 'warning'],
                        ['Booth Live', 'ph ph-desktop', $liveStepActive, 'primary'],
                        ['Event Completed', 'ph ph-flag', $eventCompleted, 'success'],
                    ] as [$label, $icon, $active, $state])
                        <div class="flex w-full items-center gap-4 sm:w-auto sm:flex-col sm:gap-3 sm:text-center">
                            <div class="relative flex h-16 w-16 shrink-0 items-center justify-center rounded-full font-bold shadow-sm ring-8 ring-white {{ $active ? ($state === 'success' ? 'bg-success-light text-success' : ($state === 'warning' ? 'bg-warning-light text-warning' : 'bg-primary-light text-primary')) : 'bg-gray-50 text-gray-400' }}">
                                <i class="{{ $icon }} text-4xl"></i>
                                @if ($active)
                                    <div class="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full border-2 border-white text-white {{ $state === 'warning' ? 'bg-warning' : 'bg-success' }}">
                                        <i class="{{ $state === 'warning' ? 'ph ph-warning' : 'ph ph-check' }} text-[12px] font-bold"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-[13px] font-bold {{ $active ? 'text-gray-900' : 'text-gray-500' }} sm:text-sm">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-2 flex flex-col gap-6 md:flex-row">
                <div class="flex-1">
                    <h4 class="mb-4 text-base font-bold text-gray-900">Booking Details</h4>
                    <div class="space-y-4">
                        @foreach ([
                            ['Booth Number', $boothNumber ? ($selectedBoothCount > 1 ? $boothNumber : 'Booth ' . $boothNumber) : 'Not booked', 'ph ph-user'],
                            ['Booking ID', $bookingId, 'ph ph-calendar-blank'],
                            ['Booking Date', $bookingDate, 'ph ph-calendar-check'],
                            ['Booth Size', $boothSize, 'ph ph-corners-out'],
                        ] as [$label, $value, $icon])
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                                <div class="flex items-center text-sm font-medium text-gray-500">
                                    <i class="{{ $icon }} mr-2 text-xl text-primary"></i> {{ $label }}
                                </div>
                                <div class="text-sm font-bold text-gray-900">{{ $value }}</div>
                            </div>
                        @endforeach

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                            <div class="flex items-center text-sm font-medium text-gray-500">
                                <i class="ph ph-info mr-2 text-xl text-primary"></i> Status
                            </div>
                            <div class="w-fit rounded-md px-3 py-1 text-[11px] font-bold {{ $statusBadgeClass }}">
                                {{ $setupStatusLabel }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-1 flex-col rounded-xl border {{ $statusCardClass }} p-5 text-center">
                    <h4 class="mb-4 text-left text-base font-bold text-gray-900">{{ $statusCardTitle }}</h4>
                    <div class="mb-4 flex items-start gap-4 text-left">
                        <div class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border {{ $statusIconClass }} bg-white shadow-sm">
                            <i class="ph ph-user text-2xl"></i>
                            <i class="ph ph-star absolute bottom-1 right-1 text-xs"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 text-base font-bold leading-tight text-gray-900">{{ $setupStatusLabel }}</h5>
                            <p class="pr-2 text-[13px] leading-relaxed text-gray-500 sm:text-sm">{{ $setupStatusCopy }}</p>
                        </div>
                    </div>
                    <div class="mt-auto flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="{{ $primaryBoothHref }}" @if($primaryBoothTarget) target="{{ $primaryBoothTarget }}" @endif class="inline-flex w-full items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white shadow-sm transition-colors hover:bg-blue-700 sm:w-auto sm:px-8 {{ $pendingBooking ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                            {{ $setupButtonLabel }}
                        </a>
                        @if ($publicBoothHref && ! $isBoothLive)
                            <a href="{{ $publicBoothHref }}" target="_blank" class="inline-flex w-full items-center justify-center rounded-lg border border-primary px-6 py-3 text-sm font-bold text-primary transition-colors hover:bg-primary-light sm:w-auto sm:px-8">
                                View Booth
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-6 flex items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-900">Recent Notifications</h3>
                <a href="{{ url('/company/enquiries') }}" class="shrink-0 text-sm font-bold text-primary hover:underline">View All</a>
            </div>

            <div class="flex-1 space-y-6">
                @forelse ($recentEnquiries->take(3) as $enquiry)
                    <div class="flex items-start">
                        <div class="mr-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-light text-primary">
                            <i class="ph ph-user-plus text-xl"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="mb-1 flex items-start justify-between gap-3">
                                <h4 class="text-base font-bold text-gray-900">{{ $enquiry->subject ?: 'New lead received' }}</h4>
                                <span class="shrink-0 whitespace-nowrap text-[11px] font-medium text-gray-500 sm:text-xs">{{ optional($enquiry->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-[13px] text-gray-500 sm:text-sm">{{ $enquiry->name ?? optional($enquiry->visitor)->name ?? 'Visitor' }} has shown interest.</p>
                        </div>
                    </div>
                    <hr class="border-gray-50">
                @empty
                    <div class="flex items-start">
                        <div class="mr-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-light text-primary">
                            <i class="ph ph-info text-xl"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="mb-1 flex items-start justify-between gap-3">
                                <h4 class="text-base font-bold text-gray-900">{{ $isBoothLive ? 'Booth is live' : ($latestBooking ? 'Booth setup progress' : 'No booth booked yet') }}</h4>
                                <span class="shrink-0 whitespace-nowrap text-[11px] font-medium text-gray-500 sm:text-xs">Now</span>
                            </div>
                            <p class="text-[13px] text-gray-500 sm:text-sm">{{ $isBoothLive ? 'Your published booth is available for visitors.' : ($latestBooking ? (($boothSetup['progress_percent'] ?? 0) . '% setup completed.') : 'Book a booth to start your exhibitor flow.') }}</p>
                        </div>
                    </div>
                    <hr class="border-gray-50">
                @endforelse

                @if ($recentMeetings->isNotEmpty())
                    @foreach ($recentMeetings->take(1) as $meeting)
                        <div class="flex items-start">
                            <div class="mr-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-light text-primary">
                                <i class="ph ph-calendar-plus text-xl"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="mb-1 flex items-start justify-between gap-3">
                                    <h4 class="text-base font-bold text-gray-900">Meeting request received</h4>
                                    <span class="shrink-0 whitespace-nowrap text-[11px] font-medium text-gray-500 sm:text-xs">{{ optional($meeting->created_at)->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-gray-500 sm:text-sm">{{ optional($meeting->visitor)->name ?? 'Visitor' }} requested a meeting.</p>
                            </div>
                        </div>
                        <hr class="border-gray-50">
                    @endforeach
                @endif

                @if ($latestBooking)
                    <div class="flex items-start">
                        <div class="mr-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-light text-primary">
                            <i class="ph ph-check-circle text-xl"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="mb-1 flex items-start justify-between gap-3">
                                <h4 class="text-base font-bold text-gray-900">Booth {{ ucfirst($latestBooking->admin_status ?? $latestBooking->booking_status ?? 'pending') }}</h4>
                                <span class="shrink-0 whitespace-nowrap text-[11px] font-medium text-gray-500 sm:text-xs">{{ optional($latestBooking->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-[13px] text-gray-500 sm:text-sm">{{ $boothNumber ? ($selectedBoothCount > 1 ? $boothNumber : 'Booth ' . $boothNumber) : 'Your booth' }} is connected to this dashboard.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex flex-col rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 lg:col-span-2">
            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <h3 class="text-lg font-bold text-gray-900">Booth Performance</h3>
                <div class="relative w-full sm:w-auto">
                    <select class="w-full appearance-none rounded-lg border border-gray-200 bg-white py-2 pl-4 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <i class="ph ph-caret-down text-sm"></i>
                    </div>
                </div>
            </div>

            <div class="relative mt-4 h-[280px] w-full overflow-hidden">
                <div class="absolute inset-0 flex flex-col justify-between pb-8">
                    @foreach ($performanceAxisLabels->push(0) as $label)
                        <div class="flex w-full items-center">
                            <span class="mr-4 w-10 text-right text-xs font-medium text-gray-400">{{ number_format($label) }}</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                    @endforeach
                </div>

                <div class="absolute inset-0 top-2 h-[250px] w-full pb-8 pl-14 pr-4">
                    <svg class="h-full w-full overflow-hidden" viewBox="0 0 700 200" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradientArea" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#3b18ff" stop-opacity="0.15" />
                                <stop offset="100%" stop-color="#3b18ff" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $performanceData['polygon'] ?? '20,180 620,180 620,200 20,200' }}" fill="url(#gradientArea)" />
                        <polyline points="{{ $performanceData['polyline'] ?? '20,180 620,180' }}" fill="none" stroke="#3b18ff" stroke-width="2.5" />
                        @foreach ($performancePoints as $point)
                            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                        @endforeach
                    </svg>
                </div>

                <div class="absolute bottom-0 left-14 right-4 flex justify-between overflow-hidden">
                    @foreach ($performanceValues as $date)
                        <span class="text-[10px] font-medium text-gray-400 sm:text-xs">{{ $date['label'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
            <h3 class="mb-6 text-lg font-bold text-gray-900">Quick Actions</h3>
            <div class="mb-4 grid flex-1 grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                <a href="{{ $setupHref }}" class="flex items-center justify-center gap-2 rounded-xl border border-gray-100 px-2 py-3 text-[13px] font-bold text-gray-900 shadow-sm transition-colors hover:border-primary hover:bg-primary-light sm:text-sm">
                    <i class="ph ph-storefront text-xl text-primary"></i>
                    {{ $latestBooking ? 'Edit Booth' : 'Book Booth' }}
                </a>
                <a href="{{ url('/company/analytics') }}" class="flex items-center justify-center gap-2 rounded-xl border border-gray-100 px-2 py-3 text-[13px] font-bold text-gray-900 shadow-sm transition-colors hover:border-primary hover:bg-primary-light sm:text-sm">
                    <i class="ph ph-chart-bar text-xl text-primary"></i>
                    View Analytics
                </a>
                <a href="{{ $floorPlanHref }}" class="flex items-center justify-center gap-2 rounded-xl border border-gray-100 px-2 py-3 text-[13px] font-bold text-gray-900 shadow-sm transition-colors hover:border-primary hover:bg-primary-light sm:text-sm">
                    <i class="ph ph-map-trifold text-xl text-primary"></i>
                    View Floor Plan
                </a>
                <a href="{{ url('/company/bookings') }}" class="flex items-center justify-center gap-2 rounded-xl border border-gray-100 px-2 py-3 text-[13px] font-bold text-gray-900 shadow-sm transition-colors hover:border-primary hover:bg-primary-light sm:text-sm">
                    <i class="ph ph-file-text text-xl text-primary"></i>
                    View Booking Details
                </a>
            </div>
            <a href="{{ url('/company/settings') }}" class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl border border-primary-light bg-white px-4 py-3 text-sm font-bold text-primary shadow-sm transition-colors hover:border-primary">
                <i class="ph ph-phone text-lg"></i>
                Contact Support
            </a>
        </div>
    </div>
</section>
@endsection
