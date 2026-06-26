@php
    $currentStep = (int) ($currentStep ?? 1);
@endphp
<div class="flex w-full min-w-0 flex-col overflow-hidden lg:w-auto lg:pl-8">
    <p class="mb-3 text-[13px] font-bold text-primary-600 sm:hidden">
        Step {{ $currentStep }} of 4
        @if ($currentStep === 1)
            · Visitor Info
        @elseif ($currentStep === 2)
            · Pass & Details
        @elseif ($currentStep === 3)
            · Payment
        @else
            · QR Ticket
        @endif
    </p>
    <h2 class="mb-4 hidden text-[16px] font-bold text-[#1E1B4B] sm:mb-5 sm:block">Get Your Visitor Pass</h2>
    <div class="ticket-flow-stepper no-scrollbar flex w-full min-w-0 items-center overflow-x-auto">
        @foreach ([1 => 'Visitor Info', 2 => 'Pass & Details', 3 => 'Payment', 4 => 'QR Ticket'] as $step => $label)
            <div class="relative z-10 flex w-24 flex-col items-center">
                @if ($currentStep > $step)
                    <div class="mb-2 flex h-7 w-7 items-center justify-center rounded-full bg-primary-500 text-[16px] text-white shadow-sm">
                        <i class="ph-fill ph-check font-bold"></i>
                    </div>
                @elseif ($currentStep === $step)
                    <div class="mb-2 flex h-7 w-7 items-center justify-center rounded-full bg-primary-500 text-[12px] font-bold text-white shadow-sm">{{ $step }}</div>
                @else
                    <div class="mb-2 flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-[12px] font-bold text-gray-500">{{ $step }}</div>
                @endif
                <span class="{{ $currentStep >= $step ? 'font-bold text-primary-600' : 'font-medium text-gray-500' }} text-center text-[11px] leading-tight">{{ $label }}</span>
            </div>
            @if ($step < 4)
                <div class="{{ $currentStep > $step ? 'bg-primary-500' : 'bg-gray-200' }} relative z-0 mt-[calc(-24px)] h-[2px] min-w-[40px] flex-1"></div>
            @endif
        @endforeach
    </div>
</div>
