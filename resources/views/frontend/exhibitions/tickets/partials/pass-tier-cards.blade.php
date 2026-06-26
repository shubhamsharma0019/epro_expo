@php
    $tiers = $tiers ?? collect();
@endphp
<div id="pass-selection-section" class="mb-8">
    <h2 class="mb-1 text-[20px] font-bold text-[#1E1B4B]">Select Your Pass</h2>
    <p class="mb-4 text-[14px] font-medium text-gray-500">Choose the pass type that suits you, then fill in your details below.</p>

    <div id="pass-cards-container" class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        @forelse ($tiers as $index => $tier)
            @php
                $isActive = $index === 0;
                $benefits = array_filter(array_map('trim', explode(',', (string) $tier->benefits)));
            @endphp
            <div data-tier-id="{{ $tier->id }}" data-tier-price="{{ $tier->price }}" class="relative flex flex-1 flex-col overflow-hidden rounded-xl border {{ $isActive ? 'border-[1.5px] border-primary-500' : 'border-gray-200 bg-white' }} transition-all duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-md">
                @if ($isActive)
                    <div class="absolute bottom-0 left-0 right-0 z-0 h-[64px] bg-primary-50"></div>
                @endif

                <div class="relative z-10 flex flex-1 flex-col border-b border-gray-50 bg-white p-5">
                    <div class="mb-3 flex items-center gap-3">
                        <i class="{{ $isActive ? 'ph-fill ph-check-circle text-primary-500' : 'ph ph-circle text-gray-300' }} text-[20px]"></i>
                        <h3 class="text-[15px] font-bold text-[#1E293B]">{{ $tier->name }}</h3>
                    </div>
                    <div class="mb-1 text-[20px] font-bold text-primary-600">₹{{ number_format((float) $tier->price, 2) }}</div>
                    <div class="mb-5 border-b border-gray-100 pb-4 text-[12px] text-gray-500">
                        {{ (float) $tier->price == 0 ? 'Access to exhibition & booths' : 'Enhanced access & features' }}
                    </div>

                    <div class="flex-1 space-y-3">
                        @foreach ($benefits as $benefit)
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle mt-0.5 text-[16px] text-green-500"></i>
                                <span class="text-[12px] font-medium text-[#475569]">{{ $benefit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="relative z-10 flex h-[64px] items-center justify-center">
                    <div class="flex items-center gap-6 rounded-lg border border-gray-200 bg-white p-1 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                        <button type="button" class="btn-minus flex h-7 w-7 items-center justify-center rounded border border-gray-200 {{ $isActive ? 'text-primary-500' : 'text-gray-400' }} transition-colors hover:bg-gray-50">
                            <i class="ph ph-minus text-[14px] font-bold"></i>
                        </button>
                        <span class="qty-span text-[15px] font-bold text-[#1E1B4B]">{{ $isActive ? '1' : '0' }}</span>
                        <button type="button" class="btn-plus flex h-7 w-7 items-center justify-center rounded border border-gray-200 text-primary-500 transition-colors hover:bg-gray-50">
                            <i class="ph ph-plus text-[14px] font-bold"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-100 bg-white p-8 text-center text-[14px] font-semibold text-[#64748B] md:col-span-3">
                No visitor passes are available for this exhibition yet.
            </div>
        @endforelse
    </div>
</div>
