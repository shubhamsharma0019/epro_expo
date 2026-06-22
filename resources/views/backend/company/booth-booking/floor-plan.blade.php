@extends('layouts.company-flow')

@section('title', 'EproExpo Hall Layout')

@section('content')
@php
    $stateClasses = [
        'available' => 'bg-[#21B86E] text-white',
        'selected' => 'bg-[#4B18D9] text-white',
        'booked' => 'bg-[#777777] text-white',
        'reserved' => 'bg-[#D5D6D8] text-navy',
    ];
    $selectedBoothStatus = $selectedBooth?->status ?? 'available';
    $selectedBoothAvailable = $selectedBooth && $selectedBoothStatus === 'available';
    $detailSize = $selectedSize ?? $selectedBooth?->boothSize;
    $detailPrice = $selectedSize?->price ?? $selectedBooth?->price ?? 0;
    $selectedFootprint = $selectedFootprint ?? collect();
    $selectedFootprintIds = $selectedFootprintIds ?? [];
    $groupedBookedBoothIds = array_map('intval', $groupedBookedBoothIds ?? []);
    if ($selectedBoothAvailable && array_intersect(array_map('intval', $selectedFootprintIds), $groupedBookedBoothIds)) {
        $selectedBoothAvailable = false;
        $selectedBoothStatus = 'booked';
    }
    $requiredSpaces = $requiredSpaces ?? 1;
    $hasEnoughSelectedSpaces = $hasEnoughSelectedSpaces ?? false;
    $sizeAvailableInHall = $sizeAvailableInHall ?? true;
    $selectedVisual = $selectedVisual ?? ['width' => 48, 'height' => 44, 'font' => 14];
    $selectedSpaceBounds = $selectedSpaceBounds ?? ['left' => 0, 'top' => 0, 'width' => 48, 'height' => 44];
    $selectedSpaceSegments = $selectedSpaceSegments ?? [];
    $selectedSpaceNumbers = $selectedSpaceNumbers ?? [];
    $selectedSpaceLeft = max((int) ($selectedSpaceBounds['left'] ?? 0), 0);
    $selectedSpaceTop = max((int) ($selectedSpaceBounds['top'] ?? 0), 0);
    $selectedSpaceWidth = max((int) ($selectedSpaceBounds['width'] ?? $selectedVisual['width']), 48);
    $selectedSpaceHeight = max((int) ($selectedSpaceBounds['height'] ?? $selectedVisual['height']), 44);
    $companyLogoUrl = $currentCompany?->logo ? asset($currentCompany->logo) : null;
    $companyInitial = strtoupper(substr($currentCompany?->company_name ?? $currentCompany?->name ?? 'C', 0, 1));
    $visibleSelectedCount = $selectedBoothAvailable ? max($selectedFootprint->count(), 1) : ($selectedCount ?? 0);
    if (empty($selectedSpaceSegments) && $selectedBoothAvailable && $selectedFootprint->count() > 1) {
        $selectedSpaceSegments = [[
            'left' => $selectedSpaceLeft,
            'top' => $selectedSpaceTop,
            'width' => $selectedSpaceWidth,
            'height' => $selectedSpaceHeight,
        ]];
    }
@endphp

<section class="w-full max-w-[1500px] px-4 py-6 sm:px-8 sm:py-8 lg:px-10 lg:py-10">
    <div class="mb-6 flex flex-col gap-5 lg:mb-8 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-[26px] font-semibold leading-[32px] tracking-[-0.4px] text-navy sm:text-[32px] sm:leading-[40px] sm:tracking-[-0.8px]">
                {{ $hall->title }}
            </h1>
            <p class="mt-3 text-[14px] font-medium text-[#5A6480] sm:mt-4">
                {{ optional($hall->pavilion)->title ?? 'Pavilion' }}
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ url('/company/booth-booking/halls?' . http_build_query(array_filter(['pavilion' => $hall->pavilion_id, 'exhibition' => session('company_booth_booking.exhibition_slug')]))) }}" class="inline-flex h-[48px] items-center justify-center rounded-md border border-borderColor px-4 text-[14px] font-semibold text-navy">
                Back
            </a>
            <button id="floor-zoom-in" type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-[18px] font-semibold text-navy transition">+</button>
            <button id="floor-zoom-out" type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-[22px] font-semibold text-navy transition">&minus;</button>
            <button id="floor-expand" type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-navy">
                <i class="fa-solid fa-expand text-[16px]"></i>
            </button>
        </div>
    </div>

    <div class="mb-4 grid max-w-full grid-cols-2 gap-3 rounded-lg border border-borderColor bg-white px-4 py-4 shadow-sm sm:inline-flex sm:flex-wrap sm:items-center sm:gap-8 sm:px-6 sm:py-5">
        <div class="flex items-center gap-3"><span class="h-5 w-5 rounded bg-[#22B66E] sm:h-6 sm:w-6"></span><span class="text-[14px] font-semibold text-navy sm:text-[15px]">Available</span></div>
        <div class="flex items-center gap-3"><span class="h-5 w-5 rounded bg-[#4B18D9] sm:h-6 sm:w-6"></span><span class="text-[14px] font-semibold text-navy sm:text-[15px]">Selected</span></div>
        <div class="flex items-center gap-3"><span class="h-5 w-5 rounded bg-[#7B7B7B] sm:h-6 sm:w-6"></span><span class="text-[14px] font-semibold text-navy sm:text-[15px]">Booked</span></div>
        <div class="flex items-center gap-3"><span class="h-5 w-5 rounded bg-[#D5D6D8] sm:h-6 sm:w-6"></span><span class="text-[14px] font-semibold text-navy sm:text-[15px]">Reserved</span></div>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-[#DCD3FF] bg-[#F7F4FF] px-5 py-4 text-[15px] font-semibold text-purple">
            {{ session('status') }}
        </div>
    @endif

    @if ($selectedSize && ! $sizeAvailableInHall)
        <div class="mb-4 flex items-start gap-3 rounded-lg border border-[#F4D38A] bg-[#FFF8EC] px-5 py-4 text-[14px] font-semibold text-[#92660C]">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 text-[16px]"></i>
            <span>Selected booth size is not available in this hall. Please choose another size or hall.</span>
        </div>
    @endif

    {{-- relative + z-[1] creates an explicit stacking context here so the zoom-animated
         floor-map canvas (and its child stacking contexts) stay bounded at z-level 1.
         The popup is appended to <body> with z-[2000], which always wins. --}}
    <div class="relative z-[1] grid min-w-0 grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_300px]">
        <div class="min-w-0">
            <div id="floor-map-shell" class="max-w-full overflow-hidden rounded-xl border border-borderColor bg-white p-3 shadow-sm sm:p-5">
                <div class="mx-auto w-full max-w-[720px]">
                    <div class="mb-4 flex items-center gap-4 px-2 text-center text-[15px] font-semibold text-navy sm:gap-8 sm:px-8 sm:text-[16px]">
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                        <div class="shrink-0">Main Aisle</div>
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                    </div>

                    <div id="floor-map-viewport" class="w-full overflow-x-auto">
                    <div id="floor-map-scale-wrap" class="mx-auto overflow-hidden">
                    <div id="floor-map-canvas" class="w-[720px] transition-transform">
                    <div class="relative w-full min-h-[400px] rounded-md border border-[#BFC8DE] bg-white">

                        @foreach ($selectedSpaceSegments as $segmentIndex => $segment)
                            <div
                                @if ($segmentIndex === 0) id="selected-space-overlay" @endif
                                data-selected-overlay-segment
                                style="display: {{ $selectedBoothAvailable && $selectedFootprint->count() > 1 ? 'flex' : 'none' }}; left: {{ (int) ($segment['left'] ?? 0) }}px; top: {{ (int) ($segment['top'] ?? 0) }}px; width: {{ max((int) ($segment['width'] ?? 48), 48) }}px; height: {{ max((int) ($segment['height'] ?? 44), 44) }}px;"
                                class="absolute z-30 items-center justify-center gap-2 rounded-md bg-[#4B18D9] px-2 text-center text-[13px] font-bold text-white shadow-md ring-1 ring-black/10"
                            >
                                @if ($segmentIndex === 0)
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white/95 text-[12px] font-extrabold text-[#4B18D9]">
                                        @if ($companyLogoUrl)
                                            <img src="{{ $companyLogoUrl }}" alt="{{ $currentCompany?->company_name ?? 'Company' }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ $companyInitial }}';">
                                        @else
                                            {{ $companyInitial }}
                                        @endif
                                    </span>
                                    <span id="selected-space-label" class="min-w-0 truncate">{{ count($selectedSpaceNumbers) > 1 ? count($selectedSpaceNumbers) . ' booths selected' : 'Booth ' . ($selectedSpaceNumbers[0] ?? '--') }}</span>
                                @endif
                            </div>
                        @endforeach

                        @foreach ($bookedBoothGroups as $groupIndex => $group)
                            @php
                                $groupSegments = $group['segments'] ?? [[
                                    'left' => $group['left'],
                                    'top' => $group['top'],
                                    'width' => $group['width'],
                                    'height' => $group['height'],
                                ]];
                                // Payload consumed by the booth-click popup. Everything here is
                                // loaded dynamically from the database (company + booking + hall).
                                $boothPopupPayload = [
                                    'company_name' => $group['company_name'],
                                    'logo_url' => $group['logo_url'],
                                    'exhibition_name' => $group['exhibition_name'] ?? null,
                                    'hall_name' => $group['hall_name'] ?? null,
                                    'pavilion_name' => $group['pavilion_name'] ?? null,
                                    'booth_numbers' => $group['booth_numbers'],
                                    'size_title' => $group['size_title'] ?? null,
                                    'booth_count' => $group['booth_count'] ?? count($group['booth_numbers']),
                                    'status' => $group['status'] ?? 'Confirmed',
                                    'contact_person' => $group['contact_person'] ?? null,
                                    'email' => $group['email'] ?? null,
                                    'phone' => $group['phone'] ?? null,
                                    'website' => $group['website'] ?? null,
                                    'category' => $group['category'] ?? null,
                                    'location' => $group['location'] ?? null,
                                ];
                            @endphp
                            @foreach ($groupSegments as $segmentIndex => $segment)
                                <button
                                    type="button"
                                    data-booked-group="{{ $groupIndex }}"
                                    @if ($segmentIndex === 0) data-booked-payload='@json($boothPopupPayload)' @endif
                                    style="position: absolute; left: {{ (int) ($segment['left'] ?? 0) }}px; top: {{ (int) ($segment['top'] ?? 0) }}px; width: {{ max((int) ($segment['width'] ?? 48), 48) }}px; height: {{ max((int) ($segment['height'] ?? 44), 44) }}px;"
                                    class="absolute z-20 flex cursor-pointer items-center justify-center gap-2 rounded-md bg-[#777777] px-2 text-center text-[12px] font-bold text-white shadow-md ring-1 ring-black/10 transition hover:bg-[#5f5f5f]"
                                    title="{{ $group['company_name'] }} - {{ implode(', ', $group['booth_numbers']) }} (click for details)"
                                >
                                    @if ($segmentIndex === 0)
                                        <span class="pointer-events-none flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white/95 text-[12px] font-extrabold text-[#4B5563]">
                                            @if ($group['logo_url'])
                                                <img src="{{ $group['logo_url'] }}" alt="{{ $group['company_name'] }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ strtoupper(substr($group['company_name'], 0, 1)) }}';">
                                            @else
                                                {{ strtoupper(substr($group['company_name'], 0, 1)) }}
                                            @endif
                                        </span>
                                        <span class="pointer-events-none min-w-0 truncate">{{ count($group['booth_numbers']) > 1 ? count($group['booth_numbers']) . ' booths' : 'Booth ' . ($group['booth_numbers'][0] ?? '') }}</span>
                                    @endif
                                </button>
                            @endforeach
                        @endforeach

                        @forelse ($booths as $booth)
                            @php
                                $isHiddenGroupedBooking = in_array($booth->id, $groupedBookedBoothIds ?? [], true);
                                $rawState = $isHiddenGroupedBooking ? 'booked' : 'available';
                                $isCurrent = $selectedBooth && $selectedBooth->id === $booth->id;
                                $boothMetrics = \App\Support\BoothFloorMap::metricsForBooth($booth);
                                $defaultVisual = [
                                    'width' => $boothMetrics['width'],
                                    'height' => $boothMetrics['height'],
                                    'font' => $boothMetrics['width'] >= 80 ? 18 : 14,
                                ];
                                $visual = $defaultVisual;
                                $left = $boothMetrics['left'];
                                $top = $boothMetrics['top'];
                                $footprint = $availableFootprints[$booth->id] ?? [
                                    'ids' => [$booth->id],
                                    'numbers' => [$booth->booth_number],
                                    'left' => $left,
                                    'top' => $top,
                                    'width' => $visual['width'],
                                    'height' => $visual['height'],
                                ];
                                $centerX = $left + ($defaultVisual['width'] / 2);
                                $centerY = $top + ($defaultVisual['height'] / 2);
                                $isIncludedInSelectedSpace = $selectedBoothAvailable
                                    && in_array($booth->id, $selectedFootprintIds, true);
                                $isHiddenSelectedSpace = $isIncludedInSelectedSpace;
                                $state = ($isCurrent || $isIncludedInSelectedSpace) ? 'selected' : $rawState;
                                $location = 'Row ' . chr(65 + ($loop->index % 4)) . ' &bull; ' . (($booth->position_y ?? 0) < 160 ? 'Near Main Aisle' : 'Inner Zone');
                            @endphp
                            <button
                                type="button"
                                style="position: absolute; left: {{ $left }}px; top: {{ $top }}px; width: {{ $visual['width'] }}px; height: {{ $visual['height'] }}px; font-size: {{ $visual['font'] }}px;"
                                data-booth-button
                                data-id="{{ $booth->id }}"
                                data-number="{{ $booth->booth_number }}"
                                data-status="{{ $rawState }}"
                                data-size="{{ optional($selectedSize ?? $booth->boothSize)->title ?? 'Custom Size' }}"
                                data-area="{{ optional($selectedSize ?? $booth->boothSize)->area ? number_format((float) optional($selectedSize ?? $booth->boothSize)->area, 0) . ' sq.m' : 'Custom area' }}"
                                data-location="{{ $location }}"
                                data-price="{{ number_format((float) ($selectedSize?->price ?? $booth->price), 2) }}"
                                data-select-url="{{ url('/company/booth-booking/slots?' . http_build_query(array_filter(['hall' => $hall->id, 'booth' => $booth->id, 'size' => $selectedSize?->id, 'exhibition' => session('company_booth_booking.exhibition_slug')]))) }}"
                                data-default-width="{{ $defaultVisual['width'] }}"
                                data-default-height="{{ $defaultVisual['height'] }}"
                                data-default-font="{{ $defaultVisual['font'] }}"
                                data-selected-width="{{ $selectedVisual['width'] }}"
                                data-selected-height="{{ $selectedVisual['height'] }}"
                                data-selected-font="{{ $selectedVisual['font'] }}"
                                data-selected-spaces="{{ count($footprint['ids'] ?? []) ?: 1 }}"
                                data-required-spaces="{{ $requiredSpaces }}"
                                data-footprint-ids="{{ implode(',', $footprint['ids'] ?? [$booth->id]) }}"
                                data-footprint-numbers="{{ implode(',', $footprint['numbers'] ?? [$booth->booth_number]) }}"
                                data-footprint-left="{{ $footprint['left'] ?? $left }}"
                                data-footprint-top="{{ $footprint['top'] ?? $top }}"
                                data-footprint-width="{{ $footprint['width'] ?? $visual['width'] }}"
                                data-footprint-height="{{ $footprint['height'] ?? $visual['height'] }}"
                                data-footprint-segments='@json($footprint['segments'] ?? [])'
                                data-grouped-booking="0"
                                class="absolute z-10 {{ $isHiddenGroupedBooking || ($selectedBoothAvailable && $isIncludedInSelectedSpace && count($selectedFootprintIds) > 1) ? 'hidden' : 'flex' }} shrink-0 items-center justify-center rounded-md font-semibold shadow-sm ring-1 ring-black/5 transition hover:scale-[1.04] {{ $stateClasses[$state] ?? $stateClasses['available'] }}"
                            >
                                {{ str_replace('B', '', $booth->booth_number) }}
                            </button>
                        @empty
                            <div class="absolute inset-0 flex items-center justify-center text-[15px] font-semibold text-[#5A6480]">
                                No booths available for this hall yet.
                            </div>
                        @endforelse
                    </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-borderColor bg-white px-4 py-5 shadow-sm sm:mt-7 sm:px-6 sm:py-6">
                <div class="grid grid-cols-2 gap-4 min-[560px]:grid-cols-3 lg:grid-cols-5 lg:gap-6">
                    <div><p class="text-[13px] font-semibold text-[#34405F] sm:text-[16px]">Total Booths</p><p class="mt-3 text-[24px] font-semibold leading-none text-navy sm:mt-4 sm:text-[28px]">{{ $totalBooths }}</p></div>
                    <div class="border-l border-borderColor pl-4 sm:pl-6"><p class="text-[13px] font-semibold text-[#34405F] sm:text-[16px]">Available</p><p class="mt-3 text-[24px] font-semibold leading-none text-[#22B66E] sm:mt-4 sm:text-[28px]">{{ $availableCount }}</p></div>
                    <div class="border-l border-borderColor pl-4 sm:pl-6"><p class="text-[13px] font-semibold text-[#34405F] sm:text-[16px]">Selected</p><p id="selected-space-count" class="mt-3 text-[24px] font-semibold leading-none text-[#4B18D9] sm:mt-4 sm:text-[28px]">{{ $visibleSelectedCount }}</p></div>
                    <div class="border-l border-borderColor pl-4 sm:pl-6"><p class="text-[13px] font-semibold text-[#34405F] sm:text-[16px]">Booked</p><p class="mt-3 text-[24px] font-semibold leading-none text-[#4B5563] sm:mt-4 sm:text-[28px]">{{ $bookedCount }}</p></div>
                    <div class="border-l border-borderColor pl-4 sm:pl-6"><p class="text-[13px] font-semibold text-[#34405F] sm:text-[16px]">Reserved</p><p class="mt-3 text-[24px] font-semibold leading-none text-[#7B7B7B] sm:mt-4 sm:text-[28px]">{{ $reservedCount }}</p></div>
                </div>
            </div>
        </div>

        <aside class="min-w-0 rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6 xl:self-start">
            <h2 class="mb-6 text-[20px] font-semibold text-navy sm:mb-8 sm:text-[22px]">Booth Details</h2>
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3 sm:flex-nowrap sm:gap-4">
                <h3 id="booth-detail-number" class="text-[18px] font-semibold text-navy sm:text-[20px]">Booth {{ $selectedBooth?->booth_number ?? '--' }}</h3>
                <span id="booth-detail-status" class="rounded-md border px-3 py-2 text-[13px] font-semibold {{ $selectedBoothAvailable ? 'border-[#BFE8CF] bg-[#EAF9F0] text-[#16A34A]' : 'border-borderColor bg-gray-100 text-[#4B5563]' }}">{{ ucfirst($selectedBoothStatus) }}</span>
            </div>
            <p id="booth-detail-size" class="mb-8 text-[15px] font-semibold text-[#34405F]">{{ optional($detailSize)->title ?? 'Custom Size' }} ({{ optional($detailSize)->area ? number_format((float) optional($detailSize)->area, 0) . ' sq.m' : 'Custom area' }})</p>
            <div class="mb-7">
                <p class="mb-4 text-[15px] font-semibold text-[#34405F]">Location</p>
                <p id="booth-detail-location" class="text-[15px] font-medium text-navy">Row A &bull; Near Main Aisle</p>
            </div>
            <div class="mb-8">
                <p class="mb-4 text-[15px] font-semibold text-[#34405F]">Price</p>
                <p id="booth-detail-price" class="text-[20px] font-semibold text-navy">&#8377;{{ number_format((float) $detailPrice, 2) }}</p>
            </div>
            <form method="POST" action="{{ route('company.booth-booking.floor-plan.select') }}">
                @csrf
                <input id="booth-select-hall" type="hidden" name="hall_id" value="{{ $hall->id }}">
                <input id="booth-select-id" type="hidden" name="booth_id" value="{{ $selectedBooth?->id }}">
                <input id="booth-select-size" type="hidden" name="size_id" value="{{ $selectedSize?->id }}">
                <button id="booth-select-link" type="submit" class="inline-flex h-[54px] w-full items-center justify-center rounded-md px-5 text-[16px] font-semibold sm:h-[58px] sm:px-7 sm:text-[18px] {{ $hasEnoughSelectedSpaces ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]' : 'cursor-not-allowed bg-gray-100 text-gray-400' }}" @disabled(! $hasEnoughSelectedSpaces)>
                    {{ $hasEnoughSelectedSpaces ? 'Select Booth' : 'Choose Another Booth' }}
                </button>
            </form>
        </aside>
    </div>

    {{-- Compact booked-booth card popup.
         Outer wrapper uses inline styles so Tailwind JIT purging cannot remove critical
         position/z-index values. Appended to <body> by JS so it escapes the zoomed
         canvas stacking context entirely. --}}
    <div id="booth-popup"
         style="position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;padding:1rem;">
        {{-- Translucent backdrop --}}
        <div id="booth-popup-overlay"
             style="position:absolute;inset:0;background:rgba(15,23,42,0.32);"></div>

        {{-- Card: 320px wide, auto height --}}
        <div id="booth-popup-card"
             style="position:relative;z-index:10;width:100%;max-width:320px;background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.18),0 4px 16px rgba(0,0,0,0.08);transform:scale(0.94);opacity:0;transition:transform 0.16s ease,opacity 0.16s ease;">

            {{-- Header --}}
            <div style="display:flex;align-items:flex-start;gap:12px;padding:18px 18px 14px;border-bottom:1px solid #F3F4F6;">
                <span id="booth-popup-logo"
                      style="display:flex;align-items:center;justify-content:center;width:44px;height:44px;min-width:44px;border-radius:12px;background:#EEE9FF;font-size:17px;font-weight:800;color:#4B18D9;overflow:hidden;">
                </span>
                <div style="min-width:0;flex:1;padding-top:2px;">
                    <h3 id="booth-popup-company"
                        style="margin:0;font-size:14px;font-weight:700;color:#0F172A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></h3>
                    <p id="booth-popup-exhibition"
                       style="margin:3px 0 0;font-size:11px;color:#6B7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></p>
                </div>
                <button id="booth-popup-close" type="button"
                        style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;min-width:26px;border-radius:50%;border:none;background:transparent;cursor:pointer;color:#9CA3AF;"
                        onmouseover="this.style.background='#F3F4F6';this.style.color='#374151';"
                        onmouseout="this.style.background='transparent';this.style.color='#9CA3AF';"
                        aria-label="Close">
                    <i class="fa-solid fa-xmark" style="font-size:12px;"></i>
                </button>
            </div>

            {{-- Body --}}
            <div style="padding:14px 18px 16px;display:flex;flex-direction:column;gap:10px;">
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <span style="min-width:58px;font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#9CA3AF;padding-top:2px;">Booth(s)</span>
                    <span id="booth-popup-booths" style="font-size:13px;font-weight:600;color:#0F172A;"></span>
                </div>
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <span style="min-width:58px;font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#9CA3AF;padding-top:2px;">Hall</span>
                    <span id="booth-popup-hall" style="font-size:13px;font-weight:600;color:#0F172A;"></span>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="min-width:58px;font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#9CA3AF;">Status</span>
                    <span id="booth-popup-status"
                          style="display:inline-flex;align-items:center;gap:5px;border-radius:999px;padding:3px 10px;font-size:11px;font-weight:600;"></span>
                </div>
                <div id="booth-popup-contact-row" style="display:none;align-items:flex-start;gap:10px;">
                    <span style="min-width:58px;font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#9CA3AF;padding-top:2px;">Contact</span>
                    <span id="booth-popup-contact" style="font-size:13px;font-weight:600;color:#0F172A;"></span>
                </div>
            </div>

        </div>
    </div>

</section>

@push('scripts')
<script>
    (() => {
        const canvas = document.getElementById('floor-map-canvas');
        const shell = document.getElementById('floor-map-shell');
        const viewport = document.getElementById('floor-map-viewport');
        const scaleWrap = document.getElementById('floor-map-scale-wrap');
        const zoomIn = document.getElementById('floor-zoom-in');
        const zoomOut = document.getElementById('floor-zoom-out');
        const expand = document.getElementById('floor-expand');
        const buttons = Array.from(document.querySelectorAll('[data-booth-button]'));
        const number = document.getElementById('booth-detail-number');
        const status = document.getElementById('booth-detail-status');
        const size = document.getElementById('booth-detail-size');
        const location = document.getElementById('booth-detail-location');
        const price = document.getElementById('booth-detail-price');
        const selectLink = document.getElementById('booth-select-link');
        const selectBoothId = document.getElementById('booth-select-id');
        const selectedOverlay = document.getElementById('selected-space-overlay');
        const selectedOverlayLabel = document.getElementById('selected-space-label');
        const selectedOverlayParent = selectedOverlay?.parentElement;
        const selectedOverlayTemplate = selectedOverlay?.cloneNode(true);
        const selectedSpaceCount = document.getElementById('selected-space-count');
        let scale = 1;
        let fitScale = 1;

        const setZoomActive = (activeButton) => {
            [zoomIn, zoomOut].forEach((button) => {
                button?.classList.remove('border-purple', 'bg-[#F4F0FF]', 'text-purple');
                button?.classList.add('border-borderColor', 'text-navy');
            });

            activeButton?.classList.remove('border-borderColor', 'text-navy');
            activeButton?.classList.add('border-purple', 'bg-[#F4F0FF]', 'text-purple');
        };

        const applyScale = () => {
            if (canvas && viewport && scaleWrap) {
                const finalScale = fitScale * scale;

                canvas.style.transform = 'none';
                canvas.style.zoom = finalScale;
                scaleWrap.style.width = `${720 * finalScale}px`;
                scaleWrap.style.height = 'auto';
                canvas.style.marginBottom = '0';
            }
        };

        const updateFitScale = () => {
            if (!viewport) {
                return;
            }

            fitScale = Math.min(1, viewport.clientWidth / 720);
            applyScale();
        };

        zoomIn?.addEventListener('click', () => {
            scale = Math.min(scale + 0.1, 1.4);
            setZoomActive(zoomIn);
            applyScale();
        });

        zoomOut?.addEventListener('click', () => {
            scale = Math.max(scale - 0.1, 0.8);
            setZoomActive(zoomOut);
            applyScale();
        });

        expand?.addEventListener('click', () => {
            if (shell?.requestFullscreen) {
                shell.requestFullscreen();
            }
        });

        window.addEventListener('resize', updateFitScale);

        if ('ResizeObserver' in window && viewport) {
            new ResizeObserver(updateFitScale).observe(viewport);
        }

        const setSelectState = (isAvailable, boothId, hasEnoughSpaces = true) => {
            const canSelect = isAvailable && hasEnoughSpaces;

            if (selectBoothId) {
                selectBoothId.value = canSelect ? boothId : '';
            }

            selectLink.disabled = !canSelect;
            selectLink.textContent = canSelect ? 'Select Booth' : (isAvailable ? 'Choose Another Booth' : 'Select Booth');
            selectLink.className = `inline-flex h-[54px] w-full items-center justify-center rounded-md px-5 text-[16px] font-semibold sm:h-[58px] sm:px-7 sm:text-[18px] ${canSelect ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]' : 'cursor-not-allowed bg-gray-100 text-gray-400'}`;
        };

        const resetSelectedOverlays = () => {
            document.querySelectorAll('[data-selected-overlay-segment]').forEach((overlay) => {
                if (overlay.id === 'selected-space-overlay') {
                    overlay.style.display = 'none';
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                    return;
                }

                overlay.remove();
            });
        };

        const renderSelectedSegments = (segments, labelText) => {
            if (!selectedOverlayParent || !selectedOverlayTemplate || !segments.length) {
                return;
            }

            resetSelectedOverlays();

            segments.forEach((segment, index) => {
                const overlay = index === 0 ? selectedOverlay : selectedOverlayTemplate.cloneNode(true);
                if (!overlay) {
                    return;
                }

                if (index > 0) {
                    overlay.removeAttribute('id');
                    overlay.innerHTML = '';
                    overlay.setAttribute('data-selected-overlay-segment', '');
                    selectedOverlayParent.appendChild(overlay);
                }

                overlay.style.display = 'flex';
                overlay.style.left = `${Number(segment.left || 0)}px`;
                overlay.style.top = `${Number(segment.top || 0)}px`;
                overlay.style.width = `${Math.max(Number(segment.width || 48), 48)}px`;
                overlay.style.height = `${Math.max(Number(segment.height || 44), 44)}px`;
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            });

            const label = document.getElementById('selected-space-label');
            if (label) {
                label.textContent = labelText;
            }
        };

        const resetBoothFootprints = () => {
            buttons.forEach((item) => {
                if (item.dataset.status === 'available') {
                    item.classList.add('bg-[#21B86E]');
                    item.classList.remove('bg-[#4B18D9]');
                }
                item.classList.add('flex');
                item.classList.remove('hidden');
            });

            resetSelectedOverlays();

            if (selectedSpaceCount) {
                selectedSpaceCount.textContent = '0';
            }
        };

        const applySelectedFootprint = (selectedButton) => {
            resetBoothFootprints();

            if (selectedButton.dataset.status !== 'available') {
                return 0;
            }

            const footprintIds = (selectedButton.dataset.footprintIds || selectedButton.dataset.id)
                .split(',')
                .map((id) => id.trim())
                .filter(Boolean);
            const footprintNumbers = (selectedButton.dataset.footprintNumbers || selectedButton.dataset.number)
                .split(',')
                .map((number) => number.trim())
                .filter(Boolean);
            let footprintSegments = [];

            try {
                footprintSegments = JSON.parse(selectedButton.dataset.footprintSegments || '[]');
            } catch (error) {
                footprintSegments = [];
            }

            if (!footprintSegments.length && footprintIds.length > 1) {
                footprintSegments = [{
                    left: Number(selectedButton.dataset.footprintLeft || 0),
                    top: Number(selectedButton.dataset.footprintTop || 0),
                    width: Number(selectedButton.dataset.footprintWidth || 48),
                    height: Number(selectedButton.dataset.footprintHeight || 44),
                }];
            }

            if (footprintIds.length > 1) {
                renderSelectedSegments(
                    footprintSegments,
                    footprintNumbers.length > 1 ? `${footprintNumbers.length} booths selected` : `Booth ${selectedButton.dataset.number}`
                );

                buttons.forEach((item) => {
                    if (footprintIds.includes(item.dataset.id)) {
                        item.classList.add('hidden');
                        item.classList.remove('flex');
                    }
                });
            } else {
                selectedButton.classList.add('bg-[#4B18D9]');
                selectedButton.classList.remove('bg-[#21B86E]');
            }

            if (selectedSpaceCount) {
                selectedSpaceCount.textContent = String(footprintIds.length || 1);
            }

            return footprintIds.length || 1;
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                resetBoothFootprints();

                buttons.forEach((item) => {
                    if (item.dataset.status === 'available') {
                        item.classList.remove('bg-[#4B18D9]');
                        item.classList.add('bg-[#21B86E]');
                    }
                });

                if (button.dataset.status === 'available') {
                    button.classList.remove('bg-[#21B86E]');
                    button.classList.add('bg-[#4B18D9]');
                }

                const isAvailable = button.dataset.status === 'available';
                const selectedFootprintCount = isAvailable ? applySelectedFootprint(button) : 0;
                const requiredSpaces = Math.max(1, Number(button.dataset.requiredSpaces || button.dataset.selectedSpaces || 1));
                const hasEnoughSpaces = selectedFootprintCount >= requiredSpaces;
                number.textContent = `Booth ${button.dataset.number}`;
                status.textContent = button.dataset.status.charAt(0).toUpperCase() + button.dataset.status.slice(1);
                status.className = `rounded-md border px-3 py-2 text-[13px] font-semibold ${isAvailable ? 'border-[#BFE8CF] bg-[#EAF9F0] text-[#16A34A]' : 'border-borderColor bg-gray-100 text-[#4B5563]'}`;
                size.textContent = `${button.dataset.size} (${button.dataset.area})`;
                location.innerHTML = button.dataset.location;
                price.textContent = `\u20B9${button.dataset.price}`;
                setSelectState(isAvailable, button.dataset.id, hasEnoughSpaces);
            });
        });

        const initiallySelected = buttons.find((button) => button.classList.contains('bg-[#4B18D9]'));
        if (initiallySelected) {
            applySelectedFootprint(initiallySelected);
        }

        // ---- Booked booth details popup ----
        const popup = document.getElementById('booth-popup');
        const popupOverlay = document.getElementById('booth-popup-overlay');
        const popupClose = document.getElementById('booth-popup-close');
        const groupButtons = Array.from(document.querySelectorAll('[data-booked-group]'));

        // The floor map uses CSS `zoom`, which creates a stacking context that can paint
        // over a fixed modal nested inside it. Re-parent the popup to <body> so it always
        // renders above the whole page regardless of the map's transforms/zoom.
        if (popup && popup.parentElement !== document.body) {
            document.body.appendChild(popup);
        }

        const popupCard = document.getElementById('booth-popup-card');

        const val = (v) => (v && String(v).trim() !== '' ? String(v).trim() : null);

        const setText = (id, value, fallback = 'Not available') => {
            const el = document.getElementById(id);
            if (el) el.textContent = val(value) ?? fallback;
        };

        const openPopup = (payload) => {
            if (!popup) return;

            // Logo / initial
            const initial = (payload.company_name || 'C').trim().charAt(0).toUpperCase();
            const logo = document.getElementById('booth-popup-logo');
            if (logo) {
                logo.innerHTML = payload.logo_url
                    ? `<img src="${payload.logo_url}" alt="${payload.company_name || ''}" class="h-full w-full object-cover" onerror="this.remove();this.parentElement.textContent='${initial}';">`
                    : initial;
            }

            setText('booth-popup-company', payload.company_name, 'Booked Company');
            setText('booth-popup-exhibition', payload.exhibition_name, '');

            // Booth numbers
            const numbers = Array.isArray(payload.booth_numbers) ? payload.booth_numbers : [];
            const boothLabels = numbers.map((n) => (String(n).toUpperCase().startsWith('B') ? n : `Booth ${n}`));
            setText('booth-popup-booths', boothLabels.join(', ') || null);

            setText('booth-popup-hall', payload.hall_name);

            // Status badge – colour coded via inline styles (immune to Tailwind JIT purge)
            const statusEl = document.getElementById('booth-popup-status');
            if (statusEl) {
                const raw = val(payload.status) ?? 'Confirmed';
                const low = raw.toLowerCase();
                let bg, color, dot;
                if (low.includes('confirm')) {
                    bg = '#DCFCE7'; color = '#15803D'; dot = '#22C55E';
                } else if (low.includes('pending') || low.includes('review')) {
                    bg = '#FEF3C7'; color = '#92400E'; dot = '#F59E0B';
                } else {
                    bg = '#F3F4F6'; color = '#4B5563'; dot = '#9CA3AF';
                }
                statusEl.style.background = bg;
                statusEl.style.color      = color;
                statusEl.innerHTML = `<span style="width:6px;height:6px;border-radius:50%;background:${dot};display:inline-block;"></span>${raw}`;
            }

            // Contact – show row only when present
            const contactRow = document.getElementById('booth-popup-contact-row');
            const contactVal = val(payload.contact_person);
            if (contactRow) contactRow.style.display = contactVal ? 'flex' : 'none';
            if (contactVal) setText('booth-popup-contact', contactVal);

            // Hide canvas to prevent zoom stacking-context bleed-through
            if (canvas) canvas.style.visibility = 'hidden';

            popup.style.display = 'flex';

            // Animate card in (two rAF frames so transition is registered)
            requestAnimationFrame(() => requestAnimationFrame(() => {
                if (popupCard) {
                    popupCard.style.transform = 'scale(1)';
                    popupCard.style.opacity   = '1';
                }
            }));
        };

        const closePopup = () => {
            if (!popup) return;

            if (popupCard) {
                popupCard.style.transform = 'scale(0.94)';
                popupCard.style.opacity   = '0';
            }

            // Wait for CSS transition to finish before hiding
            setTimeout(() => {
                popup.style.display = 'none';
                if (canvas) canvas.style.visibility = '';
            }, 160);
        };

        groupButtons.forEach((groupButton) => {
            groupButton.addEventListener('click', () => {
                const groupIndex = groupButton.dataset.bookedGroup;
                // The payload lives on the first segment of each group.
                const payloadHost = document.querySelector(`[data-booked-group="${groupIndex}"][data-booked-payload]`) || groupButton;
                let payload = {};
                try {
                    payload = JSON.parse(payloadHost.dataset.bookedPayload || '{}');
                } catch (error) {
                    payload = {};
                }
                openPopup(payload);
            });
        });

        popupClose?.addEventListener('click', closePopup);
        popupOverlay?.addEventListener('click', closePopup);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closePopup();
            }
        });

        updateFitScale();
    })();
</script>
@endpush

@endsection








