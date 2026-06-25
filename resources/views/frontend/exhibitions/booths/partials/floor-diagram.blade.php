@php
    $size = request('size', '3x3');
    
    // Dynamic sizing logic
    $w = 48; 
    $h = 44;
    $hideList = [];
    
    if ($size === '3x4') {
        $w = 48; $h = 66;
    } elseif ($size === '6x3') {
        $w = 108; $h = 44; // 48*2 + 12
        $hideList = ['25'];
    } elseif ($size === '6x6') {
        $w = 108; $h = 102; // 48*2+12 x 44*2+14
        $hideList = ['25', '44', '45'];
    } elseif ($size === '9x9') {
        $w = 168; $h = 160; // 48*3+24 x 44*3+28
        $hideList = ['25', '26', '44', '45', '46', '47']; // Hiding overlapping ones
    }

    $slug = $slug ?? '';
    
    $stateClasses = [
        'available' => 'bg-[#21B86E] text-white',
        'selected' => 'bg-[#4B18D9] text-white',
        'booked' => 'bg-[#7B7B7B] text-white',
        'reserved' => 'bg-[#D5D6D8] text-navy',
        'warning' => 'bg-[#FF7B33] text-white',
    ];
    $stateColors = [
        'available' => ['bg' => '#21B86E', 'text' => '#ffffff'],
        'selected' => ['bg' => '#4B18D9', 'text' => '#ffffff'],
        'booked' => ['bg' => '#7B7B7B', 'text' => '#ffffff'],
        'reserved' => ['bg' => '#D5D6D8', 'text' => '#071044'],
        'warning' => ['bg' => '#FF7B33', 'text' => '#ffffff'],
    ];
    $showDetailsPanel = !isset($hideDetailsPanel) || !$hideDetailsPanel;
    $isVisitorMap = ($visitorFloorMap ?? null) || (isset($hall) && ! $showDetailsPanel);
    $normalizeBoothNumber = function ($number) {
        $value = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $number));
        $value = str_starts_with($value, 'B') ? substr($value, 1) : $value;

        if (preg_match('/^0*(\d+)([A-Z]*)$/', $value, $matches)) {
            return ((string) ((int) $matches[1])) . $matches[2];
        }

        return $value;
    };
    $formatBoothLabel = function ($number) use ($normalizeBoothNumber) {
        $value = $normalizeBoothNumber($number);

        if (preg_match('/^(\d+)$/', $value, $matches)) {
            return ((int) $matches[1]) < 10 ? str_pad($matches[1], 2, '0', STR_PAD_LEFT) : $matches[1];
        }

        return $value;
    };

    $mapFromVisitorFloorMap = function (array $mapData) {
        return [
            'booths' => collect($mapData['booths'])->map(function (array $booth) {
                return [
                    $booth['label'],
                    $booth['shape'],
                    $booth['left'],
                    $booth['top'],
                    $booth['state'],
                    $booth['company'] ?? null,
                    $booth['width'] ?? null,
                    $booth['height'] ?? null,
                    'is_hidden' => $booth['is_hidden'] ?? false,
                    'category_color' => filled($booth['category'] ?? null)
                        ? \App\Support\VisitorFloorMap::colorForCategory($booth['category'])['color']
                        : null,
                ];
            })->all(),
            'overlayBookedBoothGroups' => collect($mapData['overlayBookedBoothGroups'] ?? []),
            'totalBoothsCount' => $mapData['totalBoothsCount'],
            'availableBoothsCount' => $mapData['availableBoothsCount'],
            'selectedBoothsCount' => $mapData['selectedBoothsCount'],
            'bookedBoothsCount' => $mapData['bookedBoothsCount'],
            'reservedBoothsCount' => $mapData['reservedBoothsCount'],
        ];
    };

    if (($visitorFloorMap ?? null) || isset($hall)) {
        $resolvedMap = $visitorFloorMap ?? \App\Support\VisitorFloorMap::prepare($hall);
        $mapped = $mapFromVisitorFloorMap($resolvedMap);
        $booths = $mapped['booths'];
        $overlayBookedBoothGroups = $mapped['overlayBookedBoothGroups'];
        $totalBoothsCount = $mapped['totalBoothsCount'];
        $availableBoothsCount = $mapped['availableBoothsCount'];
        $selectedBoothsCount = $mapped['selectedBoothsCount'];
        $bookedBoothsCount = $mapped['bookedBoothsCount'];
        $reservedBoothsCount = $mapped['reservedBoothsCount'];
    } elseif (filled($slug ?? null)) {
        $exhibition = \App\Domain\Event\Models\Exhibition::where('slug', $slug)->first();
        $dbHall = $exhibition
            ? \App\Domain\Event\Models\Hall::query()
                ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
                ->where('status', 'active')
                ->with('booths.boothSize')
                ->orderBy('id')
                ->first()
            : null;

        if ($dbHall && $dbHall->booths->isNotEmpty()) {
            $resolvedMap = \App\Support\VisitorFloorMap::prepare($dbHall);
            $mapped = $mapFromVisitorFloorMap($resolvedMap);
            $booths = $mapped['booths'];
            $overlayBookedBoothGroups = $mapped['overlayBookedBoothGroups'];
            $totalBoothsCount = $mapped['totalBoothsCount'];
            $availableBoothsCount = $mapped['availableBoothsCount'];
            $selectedBoothsCount = $mapped['selectedBoothsCount'];
            $bookedBoothsCount = $mapped['bookedBoothsCount'];
            $reservedBoothsCount = $mapped['reservedBoothsCount'];
        } else {
            $booths = [];
            $overlayBookedBoothGroups = collect();
            $totalBoothsCount = 0;
            $availableBoothsCount = 0;
            $selectedBoothsCount = 0;
            $bookedBoothsCount = 0;
            $reservedBoothsCount = 0;
        }
    } else {
        // Fetch dynamic bookings for the current exhibition
        $exhibition = \App\Domain\Event\Models\Exhibition::where('slug', $slug)->first();
        $liveBookings = $exhibition 
            ? \App\Domain\Booth\Models\BoothBooking::with(['company', 'boothProfile', 'booth'])
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->get()
            : collect();

        $staticBooths = [
            ['01', 'circle', 18, 28, 'reserved'],
            ['02', 'square', 78, 30, 'reserved'],
            ['03', 'square', 138, 30, 'reserved'],
            ['04', 'square', 198, 30, 'reserved'],
            ['05', 'square', 258, 30, 'reserved'],
            ['06', 'square', 318, 30, 'reserved'],
            ['07', 'square', 386, 30, 'available'],
            ['08', 'square', 446, 30, 'available'],
            ['09', 'square', 506, 30, 'available'],
            ['10', 'circle', 640, 28, 'reserved'],
            ['11', 'square', 18, 82, 'available'],
            ['12', 'square', 640, 82, 'available'],
            ['13', 'square', 18, 136, 'available'],
            ['14', 'square', 640, 136, 'available'],
            ['15', 'square', 18, 190, 'available'],
            ['16', 'square', 640, 190, 'available'],
            ['19', 'square', 18, 244, 'available'],
            ['18', 'square', 640, 244, 'available'],
            ['21', 'circle', 18, 304, 'reserved'],
            ['32', 'circle', 640, 304, 'reserved'],
            ['22', 'large', 120, 122, 'booked', 'Microsoft'],
            ['17', 'large', 250, 122, 'warning'],
            ['16A', 'large', 380, 122, 'available'],
            ['18A', 'large', 510, 122, 'booked', 'Google'],
            
            // This is our dynamically selected booth starting at 24
            ['24', 'custom', 78, 248, 'selected', '', $w, $h],
            ['25', 'square', 138, 248, 'available'],
            ['26', 'square', 198, 248, 'reserved'],
            ['27', 'square', 258, 248, 'reserved'],
            ['28', 'square', 318, 248, 'reserved'],
            ['29', 'square', 386, 248, 'reserved'],
            
            ['30', 'custom', 446, 248, 'booked', 'Amazon', 108, 44], // Mocking a 6x3 booked booth
            // 31 is hidden by Amazon's 6x3 booth
            
            ['44', 'square', 78, 306, 'available'],
            ['45', 'square', 138, 306, 'available'],
            ['46', 'square', 198, 306, 'reserved'],
            ['47', 'square', 258, 306, 'reserved'],
            ['48', 'square', 318, 306, 'available'],
            ['49', 'square', 386, 306, 'available'],
            ['50', 'square', 446, 306, 'available'],
            ['51', 'square', 506, 306, 'available'],
        ];

        $bookedBoothGroups = collect();
        $overlayBookedBoothGroups = collect();
        $groupedBookedBoothIds = [];

        $booths = [];
        foreach ($staticBooths as $b) {
            $label = $b[0];
            $shape = $b[1];
            $left = $b[2];
            $top = $b[3];
            $state = $b[4];
            $company = $b[5] ?? null;
            $width = $b[6] ?? null;
            $height = $b[7] ?? null;

            // Try to match a live booking from DB
            $dbBoothNumber = $normalizeBoothNumber($label);
            $booking = $liveBookings->first(function ($bk) use ($dbBoothNumber, $normalizeBoothNumber) {
                // Match main booth number
                if ($normalizeBoothNumber($bk->booth->booth_number ?? '') === $dbBoothNumber) {
                    return true;
                }
                // Match selected booth ids or json format array
                if ($bk->selected_booth_ids) {
                    $ids = is_string($bk->selected_booth_ids) ? json_decode($bk->selected_booth_ids, true) : $bk->selected_booth_ids;
                    if (is_array($ids)) {
                        foreach ($ids as $id) {
                            $boothRecord = \App\Domain\Booth\Models\Booth::find($id);
                            if ($boothRecord && $normalizeBoothNumber($boothRecord->booth_number) === $dbBoothNumber) {
                                return true;
                            }
                        }
                    }
                }
                return false;
            });

            if ($booking) {
                $state = 'booked';
                $company = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;
            }

            $booths[] = [
                $label, $shape, $left, $top, $state, $company, $width, $height,
                'is_hidden' => in_array($label, $hideList)
            ];
        }

        $totalBoothsCount = 60;
        $availableBoothsCount = 45;
        $selectedBoothsCount = 1;
        $bookedBoothsCount = 12;
        $reservedBoothsCount = 2;
    }
@endphp

<div class="mb-4 inline-flex max-w-full flex-wrap items-center gap-8 rounded-lg border border-borderColor bg-white px-6 py-5 shadow-sm">
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#22B66E]"></span><span class="text-[15px] font-semibold text-navy">Available</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#4B18D9]"></span><span class="text-[15px] font-semibold text-navy">Selected</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#7B7B7B]"></span><span class="text-[15px] font-semibold text-navy">Booked</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#D5D6D8]"></span><span class="text-[15px] font-semibold text-navy">Reserved</span></div>
    </div>

    <div class="grid grid-cols-1 gap-6 {{ $showDetailsPanel ? 'xl:grid-cols-[minmax(0,1fr)_300px]' : '' }}">
        <div class="min-w-0">
            <div class="w-full overflow-x-auto">
                <div class="mx-auto w-[720px] max-w-none">
                    <div class="mb-4 flex items-center gap-8 px-8 text-center text-[16px] font-semibold text-navy">
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                        <div>Main Aisle</div>
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                    </div>

                    <div class="floor-map-canvas relative w-[720px] max-w-none rounded-md border border-[#BFC8DE] bg-[#F8FAFF]" style="height: 380px; min-height: 380px;">

                        @if (isset($overlayBookedBoothGroups) && $showDetailsPanel && ! $isVisitorMap)
                            @foreach ($overlayBookedBoothGroups as $group)
                                @php
                                    $groupCompany = $group['company_name'] ?? 'Booked Company';
                                    $groupNumbers = $group['booth_numbers'] ?? [];
                                    $groupLabel = count($groupNumbers) > 1
                                        ? count($groupNumbers) . ' booths'
                                        : 'Booth ' . $formatBoothLabel($groupNumbers[0] ?? '');
                                    $groupCompanySlug = \Illuminate\Support\Str::slug($groupCompany);
                                    $groupCompanyUrl = route('exhibitions.visitor.companies.show', [$slug, $groupCompanySlug]);
                                    $groupSegments = $group['segments'] ?? [[
                                        'left' => (int) ($group['left'] ?? 0),
                                        'top' => (int) ($group['top'] ?? 0),
                                        'width' => max((int) ($group['width'] ?? 48), 48),
                                        'height' => max((int) ($group['height'] ?? 44), 44),
                                    ]];
                                @endphp
                                @foreach ($groupSegments as $segmentIndex => $segment)
                                    @php
                                        $groupLeft = (int) ($segment['left'] ?? 0);
                                        $groupTop = (int) ($segment['top'] ?? 0);
                                        $groupWidth = max((int) ($segment['width'] ?? 48), 48);
                                        $groupHeight = max((int) ($segment['height'] ?? 44), 44);
                                    @endphp
                                    <button
                                        type="button"
                                        style="position: absolute; left: {{ $groupLeft }}px; top: {{ $groupTop }}px; width: {{ $groupWidth }}px; height: {{ $groupHeight }}px; z-index: 20;"
                                        class="absolute flex cursor-pointer flex-col items-center justify-center rounded-md bg-[#7B7B7B] px-2 text-center text-[12px] font-bold text-white shadow-sm transition hover:scale-[1.02]"
                                        title="{{ $groupCompany }} - {{ implode(', ', $groupNumbers) }}"
                                        onclick="window.location.href='{{ $groupCompanyUrl }}'">
                                        @if ($segmentIndex === 0)
                                            @if (! empty($group['logo_url']))
                                                <img src="{{ $group['logo_url'] }}" alt="{{ $groupCompany }}" class="mb-1 h-6 w-6 rounded-full object-cover" onerror="this.remove();">
                                            @endif
                                            <span class="w-full truncate px-1 text-[9px] leading-tight">{{ $groupLabel }}</span>
                                            <span class="mt-0.5 w-full truncate px-1 text-[8px] font-semibold leading-tight opacity-90">{{ \Illuminate\Support\Str::limit($groupCompany, 10) }}</span>
                                        @endif
                                    </button>
                                @endforeach
                            @endforeach
                        @endif

                        @foreach ($booths as $booth)
                            @php
                                $label = $booth[0];
                                $shape = $booth[1];
                                $left = $booth[2];
                                $top = $booth[3];
                                $state = $booth[4];
                                $company = $booth[5] ?? null;
                                $width = $booth[6] ?? null;
                                $height = $booth[7] ?? null;
                                $isHidden = $booth['is_hidden'] ?? false;
                                $categoryColor = $booth['category_color'] ?? null;

                                if ($isHidden) continue;

                                $boothWidth = (int) ($width ?: ($shape === 'large' ? 86 : 48));
                                $boothHeight = (int) ($height ?: ($shape === 'large' ? 70 : 44));
                                $palette = $stateColors[$state] ?? $stateColors['available'];
                                $style = "position: absolute; left: {$left}px; top: {$top}px; z-index: 10; width: {$boothWidth}px; height: {$boothHeight}px; display: flex; align-items: center; justify-content: center; flex-direction: column; font-size: " . ($shape === 'large' ? '18px' : '14px') . "; font-weight: 600; border-radius: " . ($shape === 'circle' ? '9999px' : '6px') . "; box-shadow: 0 1px 2px rgba(7,16,68,0.12);";

                                if ($shape === 'circle' && in_array($state, ['available', 'reserved'], true)) {
                                    if ($state === 'reserved') {
                                        $style .= " background: {$palette['bg']}; color: {$palette['text']}; border: none;";
                                    } else {
                                        $style .= " background: #ffffff; color: #071044; border: 1px solid #26335E;";
                                    }
                                } else {
                                    $style .= " background: {$palette['bg']}; color: {$palette['text']}; border: none;";
                                }

                                if ($company && $state === 'booked') {
                                    $style .= " cursor: pointer;";
                                }

                                $class = $isVisitorMap ? 'transition' : 'transition hover:scale-105';
                                if (! $isVisitorMap) {
                                    $class .= " font-semibold shadow-sm ";
                                    if ($shape === 'large') {
                                        $class .= "flex-col text-[18px] " . ($stateClasses[$state] ?? $stateClasses['available']);
                                    } elseif ($shape === 'circle') {
                                        $class .= "text-[14px] rounded-full border border-[#26335E] bg-white text-navy shadow-none";
                                    } else {
                                        $class .= "flex-col text-[14px] " . ($stateClasses[$state] ?? $stateClasses['available']);
                                    }
                                }

                                $onClickAttr = '';
                                if ($company && $state === 'booked') {
                                    $companySlug = \Illuminate\Support\Str::slug($company);
                                    $companyUrl = route('exhibitions.visitor.companies.show', [$slug, $companySlug]);
                                    $onClickAttr = "onclick=\"window.location.href='{$companyUrl}'\"";
                                }
                            @endphp
                            <button
                                type="button"
                                style="{{ $style }}"
                                class="{{ $class }}"
                                title="{{ $company && $state === 'booked' ? $company : 'Booth ' . $label }}"
                                {{-- We output dynamic onclick behavior securely --}}
                                {!! $onClickAttr !!}>
                                
                                @if($company && $state === 'booked' && $shape === 'large')
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($company) }}&background=e0e7ff&color=4B18D9&size=24&rounded=true" class="mb-1 h-6 w-6" alt="{{ $company }}">
                                    <span class="w-full truncate px-1 text-[9px] leading-tight">{{ $company }}</span>
                                @elseif($company && $state === 'booked')
                                    <span class="text-[12px] font-bold leading-none">{{ $label }}</span>
                                    @unless ($isVisitorMap)
                                        <span class="mt-0.5 w-full truncate px-1 text-[8px] font-semibold leading-tight opacity-90">{{ \Illuminate\Support\Str::limit($company, 8) }}</span>
                                    @endunless
                                @else
                                    {{ $label }}
                                @endif
                                
                            </button>
                        @endforeach

                        @if (empty($booths))
                            <div class="absolute inset-0 flex items-center justify-center px-6 text-center text-[15px] font-semibold text-[#5A6480]">
                                Booth layout is loading. Please refresh or select another hall.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-7 w-full rounded-xl border border-borderColor bg-white px-4 py-5 shadow-sm sm:px-6 sm:py-6">
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-5">
                    <div><p class="text-[16px] font-semibold text-[#34405F]">Total Booths</p><p class="mt-4 text-[28px] font-semibold leading-none text-navy">{{ $totalBoothsCount }}</p></div>
                    <div class="sm:border-l border-borderColor sm:pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Available</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#22B66E]">{{ $availableBoothsCount }}</p></div>
                    <div class="sm:border-l border-borderColor sm:pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Selected</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#4B18D9]">{{ $selectedBoothsCount }}</p></div>
                    <div class="sm:border-l border-borderColor sm:pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Booked</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#4B5563]">{{ $bookedBoothsCount }}</p></div>
                    <div class="sm:border-l border-borderColor sm:pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Reserved</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#7B7B7B]">{{ $reservedBoothsCount }}</p></div>
                </div>
            </div>
        </div>

        @if($showDetailsPanel)
        <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
            <h2 class="mb-8 text-[22px] font-semibold text-navy">Booth Details</h2>
            <div class="mb-5 flex items-center justify-between gap-4">
                <h3 class="text-[20px] font-semibold text-navy">Booth 24</h3>
                <span class="rounded-md border border-[#C6B8FF] bg-[#F4F0FF] px-3 py-2 text-[13px] font-semibold text-purple">Selected</span>
            </div>
            <p class="mb-8 text-[15px] font-semibold text-[#34405F]">{{ $size }} sq.m variant</p>
            <div class="mb-7">
                <p class="mb-4 text-[15px] font-semibold text-[#34405F]">Location</p>
                <p class="text-[15px] font-medium text-navy">Row C &bull; Near Main Aisle</p>
            </div>
            <div class="mb-8">
                <p class="mb-4 text-[15px] font-semibold text-[#34405F]">Price</p>
                <p class="text-[20px] font-semibold text-navy">
                    @if($size === '3x4') ₹899 @elseif($size === '6x3') ₹1,499 @elseif($size === '6x6') ₹1,999 @elseif($size === '9x9') ₹2,499 @else ₹499 @endif
                </p>
            </div>
            <a href="{{ url('/exhibitions/booths/customize') }}" class="inline-flex h-[58px] w-full items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                Select Booth
            </a>
        </aside>
        @endif
    </div>
