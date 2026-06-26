@php
    $currentStep = (int) ($currentStep ?? 1);
@endphp
<div class="mb-6 rounded-2xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-4 sm:px-6">
    <p class="mb-3 text-[12px] font-bold uppercase tracking-[0.14em] text-[#5B35D5] sm:hidden">
        Step {{ $currentStep }} of 4
    </p>
    <div class="flex items-center justify-between gap-2 overflow-x-auto">
        @foreach ([1 => 'Visitor Info', 2 => 'Tickets', 3 => 'Payment', 4 => 'QR Ticket'] as $step => $label)
            <div class="flex min-w-[72px] flex-1 flex-col items-center">
                <div class="mb-2 flex h-8 w-8 items-center justify-center rounded-full text-[12px] font-bold {{ $currentStep > $step ? 'bg-[#4318FF] text-white' : ($currentStep === $step ? 'bg-[#4318FF] text-white shadow-[0_4px_12px_rgba(67,24,255,0.25)]' : 'bg-[#E8E3F0] text-[#6A708F]') }}">
                    @if ($currentStep > $step)
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $step }}
                    @endif
                </div>
                <span class="text-center text-[11px] font-semibold leading-tight {{ $currentStep >= $step ? 'text-[#1F2A6A]' : 'text-[#9CA1B8]' }}">{{ $label }}</span>
            </div>
            @if (! $loop->last)
                <div class="mb-6 h-0.5 min-w-[20px] flex-1 {{ $currentStep > $step ? 'bg-[#4318FF]' : 'bg-[#E8E3F0]' }}"></div>
            @endif
        @endforeach
    </div>
</div>
