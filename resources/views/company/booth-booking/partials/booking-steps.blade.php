@php
    $currentStep = $currentStep ?? 1;
    $steps = [
        [1, 'Pavilion', '/company/booth-booking/pavilions'],
        [2, 'Hall', '/company/booth-booking/halls'],
        [3, 'Booth Size', '/company/booth-booking/sizes'],
        [4, 'Layout', '/company/booth-booking/floor-plan'],
        [5, 'Slots', '/company/booth-booking/slots'],
        [6, 'Summary', '/company/booth-booking/summary'],
        [7, 'Services', '/company/booth-booking/services'],
        [8, 'Review', '/company/booth-booking/review'],
        [9, 'Payment', '/company/booth-booking/payment'],
        [10, 'Confirmed', '/company/booth-booking/confirmed'],
    ];
@endphp

<div class="mb-7 overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white px-4 py-4 shadow-sm">
    <div class="flex items-center gap-3 overflow-x-auto pb-1 text-[13px] font-semibold text-[#34405F]">
        @foreach ($steps as [$step, $label, $href])
            @php
                $isDone = $step < $currentStep;
                $isActive = $step === $currentStep;
            @endphp

            <a href="{{ url($href) }}" class="flex shrink-0 items-center gap-2 rounded-full px-2 py-1 {{ $isActive ? 'bg-[#F4F0FF] text-[#5b2eff]' : '' }}">
                <span class="grid h-8 w-8 place-items-center rounded-full text-[12px] font-bold {{ $isDone || $isActive ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white' : 'border border-[#D7DDEC] bg-white text-[#53607C]' }}">
                    @if ($isDone)
                        <i class="fa-solid fa-check text-[11px]"></i>
                    @else
                        {{ $step }}
                    @endif
                </span>
                <span class="{{ $isActive ? 'font-bold' : '' }}">{{ $label }}</span>
            </a>

            @if (! $loop->last)
                <i class="fa-solid fa-chevron-right shrink-0 text-[10px] text-[#A0A8BC]"></i>
            @endif
        @endforeach
    </div>
</div>
