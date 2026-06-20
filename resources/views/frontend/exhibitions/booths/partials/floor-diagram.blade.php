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
    $showDetailsPanel = !isset($hideDetailsPanel) || !$hideDetailsPanel;
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
    $fallbackBoothLayout = collect([
        ['B01', 18, 28, 'reserved'], ['B02', 78, 30, 'reserved'], ['B03', 138, 30, 'reserved'],
        ['B04', 198, 30, 'reserved'], ['B05', 258, 30, 'reserved'], ['B06', 318, 30, 'reserved'],
        ['B07', 386, 30, 'available'], ['B08', 446, 30, 'available'], ['B09', 506, 30, 'available'],
        ['B10', 640, 28, 'reserved'], ['B11', 18, 82, 'available'], ['B12', 640, 82, 'available'],
        ['B13', 18, 136, 'available'], ['B14', 640, 136, 'available'], ['B15', 18, 190, 'available'],
        ['B16', 640, 190, 'available'], ['B19', 18, 244, 'available'], ['B18', 640, 244, 'available'],
        ['B21', 18, 304, 'reserved'], ['B32', 640, 304, 'reserved'], ['B22', 120, 122, 'available'],
        ['B17', 250, 122, 'available'], ['B16A', 380, 122, 'available'], ['B18A', 510, 122, 'available'],
        ['B24', 78, 248, 'available'], ['B25', 138, 248, 'available'], ['B26', 198, 248, 'reserved'],
        ['B27', 258, 248, 'reserved'], ['B28', 318, 248, 'reserved'], ['B29', 386, 248, 'reserved'],
        ['B30', 446, 248, 'available'], ['B44', 78, 306, 'available'], ['B45', 138, 306, 'available'],
        ['B46', 198, 306, 'reserved'], ['B47', 258, 306, 'reserved'], ['B48', 318, 306, 'available'],
        ['B49', 386, 306, 'available'], ['B50', 446, 306, 'available'], ['B51', 506, 306, 'available'],
    ])->mapWithKeys(function ($booth) use ($normalizeBoothNumber, $formatBoothLabel) {
        return [
            $normalizeBoothNumber($booth[0]) => [
                'number' => $booth[0],
                'label' => $formatBoothLabel($booth[0]),
                'x' => $booth[1],
                'y' => $booth[2],
                'status' => $booth[3],
            ],
        ];
    });

    if (isset($hall)) {
        // Fetch booths for the hall sorted by coordinate alignment
        $dbBooths = $hall->booths()
            ->with('boothSize')
            ->get()
            ->sortBy(function ($booth) {
                return str_pad((string) $booth->position_y, 4, '0', STR_PAD_LEFT)
                    . str_pad((string) $booth->position_x, 4, '0', STR_PAD_LEFT);
            })
            ->values();

        $dbBooths = $dbBooths->map(function ($booth) use ($fallbackBoothLayout, $normalizeBoothNumber) {
            $layout = $fallbackBoothLayout->get($normalizeBoothNumber($booth->booth_number));
            if ($layout && ((int) ($booth->position_x ?? 0) <= 0 && (int) ($booth->position_y ?? 0) <= 0)) {
                $booth->position_x = $layout['x'];
                $booth->position_y = $layout['y'];
            } elseif ((int) ($booth->position_x ?? 0) <= 0 && (int) ($booth->position_y ?? 0) <= 0) {
                $booth->position_x = 336;
                $booth->position_y = 150;
            }

            if ($layout && blank($booth->status)) {
                $booth->status = $layout['status'];
            }

            return $booth;
        });

        $dbBooths = $dbBooths
            ->sortBy(function ($booth) {
                return str_pad((string) $booth->position_y, 4, '0', STR_PAD_LEFT)
                    . str_pad((string) $booth->position_x, 4, '0', STR_PAD_LEFT);
            })
            ->values();

        // Calculate booked groups
        $bookedBoothsById = $dbBooths->keyBy('id');
        $bookedBoothGroups = collect();
        if ($bookedBoothsById->isNotEmpty()) {
            $bookings = \App\Domain\Booth\Models\BoothBooking::query()
                ->with(['company', 'boothProfile'])
                ->where('hall_id', $hall->id)
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where(function ($query) use ($bookedBoothsById) {
                    $query->whereIn('booth_id', $bookedBoothsById->keys())
                        ->orWhereNotNull('selected_booth_ids');
                })
                ->orderByRaw("CASE WHEN payment_status = 'paid' THEN 0 ELSE 1 END")
                ->orderByRaw("CASE WHEN admin_status = 'approved' THEN 0 ELSE 1 END")
                ->get()
                ->filter(fn ($booking) => $booking->company_id && $booking->booth_id);

            $bookedBoothGroups = $bookings
                ->map(function ($booking) use ($bookedBoothsById) {
                    $selectedIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                        ->push($booking->booth_id)
                        ->filter()
                        ->map(fn ($id) => (int) $id)
                        ->unique();

                    $items = $selectedIds
                        ->map(function (int $boothId) use ($booking, $bookedBoothsById) {
                            $booth = $bookedBoothsById->get($boothId);
                            if (! $booth) {
                                return null;
                            }

                            $height = (int) ($booth->position_y ?? 0) === 122 ? 70 : 44;
                            $width = (int) ($booth->position_y ?? 0) === 122 ? 86 : 48;
                            $left = min((int) ($booth->position_x ?? 0), 700 - $width);
                            $top = min((int) ($booth->position_y ?? 0), 350 - $height);

                            return [
                                'booking' => $booking,
                                'booth' => $booth,
                                'left' => $left,
                                'top' => $top,
                                'right' => $left + $width,
                                'bottom' => $top + $height,
                            ];
                        })
                        ->filter()
                        ->values();

                    if ($items->isEmpty()) {
                        return null;
                    }

                    $logo = $booking->boothProfile?->company_logo
                        ? asset('storage/' . $booking->boothProfile->company_logo)
                        : ($booking->company?->logo ? asset($booking->company->logo) : null);

                    return [
                        'company_id' => $booking->company_id,
                        'company_name' => $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name ?? 'Booked Company',
                        'logo_url' => $logo,
                        'booth_ids' => $items->pluck('booth.id')->values()->all(),
                        'booth_numbers' => $items->pluck('booth.booth_number')->values()->all(),
                        'left' => max(min($items->min('left') - 4, 700), 0),
                        'top' => max(min($items->min('top') - 4, 350), 0),
                        'width' => min($items->max('right') - $items->min('left') + 8, 700),
                        'height' => min($items->max('bottom') - $items->min('top') + 8, 350),
                    ];
                })
                ->filter()
                ->values();
        }

        $groupedBookedBoothIds = $bookedBoothGroups
            ->flatMap(fn ($group) => $group['booth_ids'])
            ->unique()
            ->values()
            ->all();
        $overlayBookedBoothGroups = $bookedBoothGroups
            ->filter(fn ($group) => count($group['booth_ids']) > 1)
            ->values();
        $overlayBookedBoothIds = $overlayBookedBoothGroups
            ->flatMap(fn ($group) => $group['booth_ids'])
            ->unique()
            ->values()
            ->all();
        $companyNamesByBoothId = $bookedBoothGroups
            ->flatMap(fn ($group) => collect($group['booth_ids'])->mapWithKeys(fn ($boothId) => [$boothId => $group['company_name']]));

        $booths = [];
        foreach ($dbBooths as $booth) {
            $label = $formatBoothLabel($booth->booth_number);
            $booth->loadMissing('boothSize');
            if ($booth->boothSize) {
                $width = (int) (floatval($booth->boothSize->width) * 16);
                $height = (int) (floatval($booth->boothSize->height) * 15);
                $shape = 'custom';
            } else {
                $isCenterFeatureBooth = in_array((int) ($booth->position_y ?? 0), [122], true);
                $shape = $isCenterFeatureBooth ? 'large' : 'square';
                $width = $isCenterFeatureBooth ? 86 : 48;
                $height = $isCenterFeatureBooth ? 70 : 44;
            }
            $left = (int) ($booth->position_x ?? 0);
            $top = (int) ($booth->position_y ?? 0);
            $left = min($left, 700 - $width);
            $top = min($top, 350 - $height);
            $state = in_array($booth->id, $groupedBookedBoothIds, true) ? 'booked' : $booth->status;

            $companyName = $companyNamesByBoothId->get($booth->id);

            $booths[] = [
                $label,
                $shape,
                $left,
                $top,
                $state,
                $companyName,
                $width,
                $height,
                'is_hidden' => false
            ];
        }

        $totalBoothsCount = $dbBooths->count();
        $availableBoothsCount = $dbBooths
            ->filter(fn ($booth) => $booth->status === 'available' && ! in_array($booth->id, $groupedBookedBoothIds, true))
            ->count();
        $selectedBoothsCount = 0;
        $bookedBoothsCount = $dbBooths
            ->filter(fn ($booth) => $booth->status === 'booked' || in_array($booth->id, $groupedBookedBoothIds, true))
            ->count();
        $reservedBoothsCount = $dbBooths->where('status', 'reserved')->count();

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
            <div class="w-full overflow-x-auto rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-5">
                <div class="w-[720px] max-w-none">
                    <div class="mb-4 flex items-center gap-8 px-8 text-center text-[16px] font-semibold text-navy">
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                        <div>Main Aisle</div>
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                    </div>

                    <div class="relative w-full min-h-[400px] bg-white rounded-md border border-[#BFC8DE]">
                        
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

                                if ($isHidden) continue;
                                
                                $style = "position: absolute; left: {$left}px; top: {$top}px;";
                                if ($width) $style .= " width: {$width}px;";
                                if ($height) $style .= " height: {$height}px;";
                                if ($company && $state === 'booked') {
                                    $style .= " cursor: pointer;";
                                }
                                
                                $class = "absolute flex shrink-0 flex-col items-center justify-center font-semibold shadow-sm transition hover:scale-105 ";
                                if ($shape === 'large') {
                                    $class .= "h-[70px] w-[86px] text-[18px] rounded " . $stateClasses[$state];
                                } elseif ($shape === 'circle') {
                                    $class .= "h-[44px] w-[48px] text-[14px] rounded-full border border-[#26335E] bg-white text-navy shadow-none";
                                } elseif ($shape === 'custom') {
                                    $class .= "text-[14px] rounded " . $stateClasses[$state];
                                } else {
                                    $class .= "h-[44px] w-[48px] text-[14px] rounded " . $stateClasses[$state];
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
                                    <span class="mt-0.5 w-full truncate px-1 text-[8px] font-semibold leading-tight opacity-90">{{ \Illuminate\Support\Str::limit($company, 8) }}</span>
                                @else
                                    {{ $label }}
                                @endif
                                
                            </button>
                        @endforeach
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
