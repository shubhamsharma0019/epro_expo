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

    // Fetch dynamic bookings for the current exhibition
    $slug = $slug ?? 'innovation-expo';
    $exhibition = \App\Models\Exhibition::where('slug', $slug)->first();
    $liveBookings = $exhibition 
        ? \App\Models\BoothBooking::with(['company', 'boothProfile', 'booth'])
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
        $dbBoothNumber = 'B' . $label;
        $booking = $liveBookings->first(function ($bk) use ($dbBoothNumber) {
            // Match main booth number
            if (($bk->booth->booth_number ?? '') === $dbBoothNumber) {
                return true;
            }
            // Match selected booth ids or json format array
            if ($bk->selected_booth_ids) {
                $ids = is_string($bk->selected_booth_ids) ? json_decode($bk->selected_booth_ids, true) : $bk->selected_booth_ids;
                if (is_array($ids)) {
                    foreach ($ids as $id) {
                        $boothRecord = \App\Models\Booth::find($id);
                        if ($boothRecord && $boothRecord->booth_number === $dbBoothNumber) {
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

        $booths[] = [$label, $shape, $left, $top, $state, $company, $width, $height];
    }

    $stateClasses = [
        'available' => 'bg-[#21B86E] text-white',
        'selected' => 'bg-[#4B18D9] text-white',
        'booked' => 'bg-[#E7EAF3] text-[#1F2A6A] border border-[#BFC8DE]', 
        'reserved' => 'bg-[#D5D6D8] text-navy',
        'warning' => 'bg-[#FF7B33] text-white',
    ];
@endphp

<div class="mb-4 inline-flex max-w-full flex-wrap items-center gap-8 rounded-lg border border-borderColor bg-white px-6 py-5 shadow-sm">
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#22B66E]"></span><span class="text-[15px] font-semibold text-navy">Available</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#4B18D9]"></span><span class="text-[15px] font-semibold text-navy">Selected</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#7B7B7B]"></span><span class="text-[15px] font-semibold text-navy">Booked</span></div>
        <div class="flex items-center gap-3"><span class="h-6 w-6 rounded bg-[#D5D6D8]"></span><span class="text-[15px] font-semibold text-navy">Reserved</span></div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_300px]">
        <div>
            <div class="w-[1000px] rounded-xl border border-borderColor bg-white p-5 shadow-sm">
                <div class="min-w-[720px] max-w-[720px]">
                    <div class="mb-4 flex items-center gap-8 px-8 text-center text-[16px] font-semibold text-navy">
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                        <div>Main Aisle</div>
                        <div class="h-px flex-1 bg-[#9AA3B8]"></div>
                    </div>

                    <div class="relative h-[360px] rounded-md border border-[#BFC8DE] bg-white">
                        <div class="absolute left-[64px] top-[50px] h-[260px] w-px bg-[#E2E6F0]"></div>
                        <div class="absolute right-[64px] top-[50px] h-[260px] w-px bg-[#E2E6F0]"></div>
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

                                if (in_array($label, $hideList)) continue;
                                
                                $style = "left: {$left}px; top: {$top}px;";
                                if ($width) $style .= " width: {$width}px;";
                                if ($height) $style .= " height: {$height}px;";
                                if ($company && $state === 'booked') {
                                    $style .= " cursor: pointer;";
                                }
                                
                                $class = "absolute flex flex-col items-center justify-center font-semibold shadow-sm transition hover:scale-105 ";
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
                                {{-- We output dynamic onclick behavior securely --}}
                                {!! $onClickAttr !!}>
                                
                                @if($company && $state === 'booked')
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($company) }}&background=e0e7ff&color=4B18D9&size=24&rounded=true" class="mb-1 h-6 w-6" alt="{{ $company }}">
                                    <span class="w-full truncate px-1 text-[9px] leading-tight">{{ $company }}</span>
                                @else
                                    {{ $label }}
                                @endif
                                
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-7 w-[800px] rounded-xl border border-borderColor bg-white px-6 py-6 shadow-sm">
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-5">
                    <div><p class="text-[16px] font-semibold text-[#34405F]">Total Booths</p><p class="mt-4 text-[28px] font-semibold leading-none text-navy">60</p></div>
                    <div class="border-l border-borderColor pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Available</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#22B66E]">45</p></div>
                    <div class="border-l border-borderColor pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Selected</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#4B18D9]">1</p></div>
                    <div class="border-l border-borderColor pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Booked</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#4B5563]">12</p></div>
                    <div class="border-l border-borderColor pl-6"><p class="text-[16px] font-semibold text-[#34405F]">Reserved</p><p class="mt-4 text-[28px] font-semibold leading-none text-[#7B7B7B]">2</p></div>
                </div>
            </div>
        </div>

        @if(!isset($hideDetailsPanel) || !$hideDetailsPanel)
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
