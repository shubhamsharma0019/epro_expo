@extends('layouts.company-flow')

@section('title', 'EproExpo Add Services')

@section('content')

@php
    $detailService = $bookingServices->first()?->service ?? $services->first();
    $selectedBookingServices = $bookingServices->values();
@endphp

<section class="min-h-full bg-[#f8fafc] px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-8">
    <div class="mx-auto w-full max-w-[1400px]">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-[#0f172a] sm:text-3xl">Add Services (Optional)</h1>
            <p class="mt-2 text-sm text-[#64748b]">
                Enhance your presence with premium services.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-[#dccfff] bg-[#f5f2ff] p-4 text-sm font-semibold text-[#5b2eff]">
                {{ session('status') }}
            </div>
        @endif

        <!-- Main Card Container -->
        <div class="rounded-2xl border border-[#e2e8f0] bg-white p-6 shadow-sm">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                
                <!-- Left Column (Choose Services) -->
                <div class="lg:col-span-7">
                    <div class="mb-6 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5f2ff] text-[#5b2eff]">
                            <i class="ph ph-gem text-lg font-bold"></i>
                        </span>
                        <h2 class="text-lg font-bold text-[#0f172a]">Choose from our premium services</h2>
                    </div>

                    <!-- Services Cards List -->
                    <div class="space-y-3">
                        @foreach ($services as $service)
                            @php
                                $selected = $bookingServices->get($service->id);
                            @endphp

                            <div 
                                class="service-card flex items-center justify-between rounded-xl border-2 p-4 transition-all duration-200 cursor-pointer {{ $selected ? 'bg-[#f5f2ff]/60 border-[#5b2eff]' : 'bg-white border-[#e2e8f0] hover:bg-gray-50/50' }}"
                                data-id="{{ $service->id }}"
                                data-title="{{ $service->title }}"
                                data-description="{{ $service->description ?? 'No description available for this service.' }}"
                                data-icon="{{ $service->icon ?: 'ph ph-star' }}"
                            >
                                <div class="flex items-center gap-4 flex-1 min-w-0">
                                    <!-- Checkbox form -->
                                    <form method="POST" action="{{ route('company.booth-booking.services.toggle') }}" id="toggle-form-{{ $service->id }}" class="inline-flex">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <input type="hidden" name="exhibition" value="{{ session('company_booth_booking.exhibition_slug') }}">
                                        <button type="submit" class="flex h-5 w-5 shrink-0 items-center justify-center rounded-[6px] border-2 transition-all {{ $selected ? 'bg-[#5b2eff] border-[#5b2eff] text-white' : 'bg-white border-[#cbd5e1]' }}">
                                            @if($selected)
                                                <i class="ph ph-check text-[12px] font-bold"></i>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Service name & optional quantity -->
                                    <div class="min-w-0 flex-1 flex items-center gap-3">
                                        <span class="font-semibold text-[#0f172a] text-[15px] truncate">
                                            {{ $service->title }}
                                        </span>
                                        
                                        @if ($selected)
                                            <!-- Simple quantity dropdown/input -->
                                            <form method="POST" action="{{ route('company.booth-booking.services.quantity') }}" class="inline-flex items-center gap-1.5 ml-2">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                                <input type="hidden" name="exhibition" value="{{ session('company_booth_booking.exhibition_slug') }}">
                                                <input 
                                                    type="number" 
                                                    name="quantity" 
                                                    min="1" 
                                                    max="99" 
                                                    value="{{ $selected->quantity }}" 
                                                    class="h-7 w-12 rounded-md border border-[#cbd5e1] bg-white text-center text-xs font-semibold text-[#0f172a] focus:border-[#5b2eff] outline-none"
                                                    onchange="this.form.submit()"
                                                >
                                                <span class="text-xs text-[#64748b]">qty</span>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="shrink-0 font-bold text-[#5b2eff] text-[15px] ml-4">
                                    &#8377;{{ number_format((float) $service->price) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Column (Service Details & Breakdown) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="mb-2 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5f2ff] text-[#5b2eff]">
                            <i class="ph ph-squares-three-and-four text-lg font-bold"></i>
                        </span>
                        <h2 class="text-lg font-bold text-[#0f172a]">Service Details</h2>
                    </div>

                    <!-- Details Card -->
                    <div class="rounded-xl border border-[#e2e8f0] bg-white p-5">
                        <div class="flex items-start gap-4">
                            <span id="detail-service-icon-bg" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#7a5bff] to-[#4b2de3] text-white shadow-[0_8px_20px_rgba(91,46,255,0.2)]">
                                <i id="detail-service-icon" class="ph ph-star text-lg font-bold"></i>
                            </span>

                            <div class="min-w-0 flex-1">
                                <h3 id="detail-service-title" class="text-base font-bold text-[#0f172a]">
                                    {{ $detailService?->title ?? 'Featured Listing' }}
                                </h3>
                                <p id="detail-service-desc" class="mt-3 text-sm leading-relaxed text-[#64748b]">
                                    {{ $detailService?->description ?? 'Highlight your company at the top of exhibitor lists for better visitor visibility.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Price summary -->
                        <div class="mt-6 space-y-3 border-t border-gray-100 pt-4 text-sm">
                            <div class="flex items-center justify-between text-[#64748b]">
                                <span>Selected Services</span>
                                <span class="font-semibold text-[#0f172a]" id="price-summary-count">{{ $selectedServicesCount }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[#64748b]">
                                <span>Services Amount</span>
                                <span class="font-semibold text-[#0f172a]">&#8377;{{ number_format($servicesAmount) }}</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-3 text-[15px] font-bold">
                                <span class="text-[#0f172a]">Total Amount</span>
                                <span class="text-lg text-[#5b2eff]">&#8377;{{ number_format($amountToPay) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Illustration Pedestal -->
                    <div class="flex flex-1 min-h-[260px] items-center justify-center rounded-xl border border-[#e2e8f0] bg-[#f8fafc]/50 p-6 relative overflow-hidden">
                        <!-- Pedestal graphic -->
                        <div class="relative flex w-full max-w-[260px] flex-col items-center justify-center">
                            <!-- Glow background -->
                            <div class="absolute inset-0 m-auto h-32 w-32 rounded-full bg-[#5b2eff]/10 blur-2xl"></div>
                            
                            <!-- Pedestal Base and Trophy elements styled exactly as in the image -->
                            <div class="relative flex flex-col items-center">
                                <!-- 3D Star icon inside a hexagonal badge -->
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7a5bff] to-[#4b2de3] text-white shadow-[0_12px_24px_rgba(91,46,255,0.3)] mb-4">
                                    <i class="ph ph-star text-3xl font-bold"></i>
                                </div>
                                
                                <!-- Pedestal Column -->
                                <div class="h-10 w-24 rounded-lg bg-white shadow-[0_8px_16px_rgba(0,0,0,0.05)] border border-[#e2e8f0] flex items-center justify-center">
                                    <span class="h-1.5 w-12 rounded-full bg-[#f1f5f9]"></span>
                                </div>
                                <!-- Pedestal Base -->
                                <div class="h-4 w-32 rounded-full bg-[#e2e8f0] mt-1 shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bar (Shopping Cart & Continue Button) -->
            <div class="mt-8 border-t border-[#e2e8f0] pt-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-[#f8fafc] rounded-2xl p-4 border border-[#e2e8f0]">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#f5f2ff] text-[#5b2eff]">
                            <i class="ph ph-shopping-cart text-xl font-bold"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#0f172a] text-base">Selected Services ({{ $selectedServicesCount }})</h3>
                            @if ($selectedBookingServices->isEmpty())
                                <p class="text-xs text-[#64748b] mt-0.5">No services selected yet.</p>
                            @else
                                <p class="text-xs text-[#64748b] mt-0.5">
                                    {{ $selectedBookingServices->map(fn($bs) => $bs->service?->title . ($bs->quantity > 1 ? ' x' . $bs->quantity : ''))->join(', ') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-6">
                        <div class="text-left sm:text-right">
                            <span class="text-xs font-semibold text-[#64748b]">Services Total</span>
                            <div class="text-2xl font-extrabold text-[#0f172a] mt-0.5">&#8377;{{ number_format($amountToPay) }}</div>
                        </div>

                        <form method="POST" action="{{ route('company.booth-booking.services.continue') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#5b2eff] hover:bg-[#4b25e0] px-6 text-sm font-semibold text-white shadow-[0_8px_16px_rgba(91,46,255,0.25)] transition-all duration-200 sm:min-w-[200px]">
                                Continue to Review
                                <i class="ph ph-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    (() => {
        // Handle client-side description hover updates
        const detailIcon = document.getElementById('detail-service-icon');
        const detailTitle = document.getElementById('detail-service-title');
        const detailDesc = document.getElementById('detail-service-desc');

        document.querySelectorAll('.service-card').forEach((card) => {
            // Hover behavior
            card.addEventListener('mouseenter', () => {
                const title = card.dataset.title;
                const desc = card.dataset.description;
                const icon = card.dataset.icon;

                if (detailTitle) detailTitle.textContent = title;
                if (detailDesc) detailDesc.textContent = desc;
                if (detailIcon) {
                    detailIcon.className = `${icon} text-lg font-bold`;
                }
            });

            // Prevent card toggle trigger when clicking quantity forms
            card.querySelectorAll('form').forEach(f => {
                f.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });

            // Make clicking anywhere on the card submit the toggle form
            card.addEventListener('click', (e) => {
                const form = card.querySelector('form[action*="toggle"]');
                if (form) {
                    form.submit();
                }
            });
        });
    })();
</script>
@endpush
