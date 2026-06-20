@php
    $exhibitionSlug = session('company_booth_booking.exhibition_slug');
    $exQuery = $exhibitionSlug ? ['exhibition' => $exhibitionSlug] : [];
    $steps = $steps ?? [
        ['Pavilion', '/company/booth-booking/pavilions'],
        ['Hall', '/company/booth-booking/halls'],
        ['Floor Plan', '/company/booth-booking/floor-plan'],
        ['Booth Size', '/company/booth-booking/sizes'],
        ['Booth Slot', '/company/booth-booking/slots'],
        ['Customize', '/company/booth-booking/customize'],
        ['Summary', '/company/booth-booking/summary'],
        ['Services', '/company/booth-booking/services'],
        ['Review', '/company/booth-booking/review'],
        ['Payment', '/company/booth-booking/payment'],
    ];
    $active = $active ?? 'Pavilion';
    $activeIndex = collect($steps)->search(fn ($step) => $step[0] === $active);
@endphp

<div class="mb-10 overflow-x-auto pb-1">
    <div class="flex min-w-max items-center gap-5 text-[15px] font-medium text-[#34405F]">
        @foreach ($steps as $index => [$label, $href])
            @php
                $isDone = $activeIndex !== false && $index < $activeIndex;
                $isActive = $label === $active;
                $url = url($href);
                if (!empty($exQuery)) {
                    $url .= '?' . http_build_query($exQuery);
                }
            @endphp

            <a href="{{ $url }}" class="flex shrink-0 items-center gap-3 {{ $isActive ? 'rounded-full bg-[#F4F0FF] px-4 py-2 text-purple' : '' }}">
                <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $isDone || $isActive ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white' : 'border border-[#8FA0C7] bg-white text-navy' }} text-[14px] font-semibold">
                    @if ($isDone)
                        <i class="fa-solid fa-check text-[12px]"></i>
                    @else
                        {{ $index + 1 }}
                    @endif
                </span>
                <span class="{{ $isActive ? 'font-semibold' : '' }}">{{ $label }}</span>
            </a>

            @if (! $loop->last)
                <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
            @endif
        @endforeach
    </div>
</div>
