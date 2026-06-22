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
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-4">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7a5bff] to-[#4310d8] text-white shadow-[0_10px_22px_rgba(91,46,255,0.28)]">
                    <i class="fa-solid fa-layer-group text-[18px]"></i>
                </span>
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h1 class="text-[24px] font-bold leading-tight tracking-tight text-[#0f172a] sm:text-[30px]">Add Services</h1>
                        <span class="inline-flex items-center rounded-full bg-[#f1f5f9] px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-[#64748b]">Optional</span>
                    </div>
                    <p class="mt-1.5 max-w-[560px] text-[13.5px] font-medium leading-6 text-[#64748b] sm:text-sm">
                        Boost your exhibition presence with add-ons. Your total updates instantly as you select.
                    </p>
                </div>
            </div>

            <div class="hidden shrink-0 items-center gap-3 rounded-2xl border border-[#e2e8f0] bg-white px-5 py-3 shadow-sm sm:flex">
                <div class="text-right">
                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#94a3b8]">Total</p>
                    <p class="text-[20px] font-extrabold leading-none text-[#5b2eff]">&#8377;{{ number_format($amountToPay) }}</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#dccfff] bg-[#f5f2ff] p-4 text-sm font-semibold text-[#5b2eff]">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Main Card Container -->
        <div class="rounded-2xl border border-[#e2e8f0] bg-white p-4 shadow-sm sm:p-6">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:gap-8">

                <!-- Left Column (Choose Services) -->
                <div class="lg:col-span-7">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5f2ff] text-[#5b2eff]">
                            <i class="fa-solid fa-gem text-[15px]"></i>
                        </span>
                        <h2 class="text-[17px] font-bold text-[#0f172a]">Choose from our premium services</h2>
                    </div>

                    <!-- Services Cards List -->
                    <div class="space-y-3">
                        @forelse ($services as $service)
                            @php
                                $selected = $bookingServices->get($service->id);
                                $serviceIcon = $service->icon ?: 'fa-regular fa-star';
                            @endphp

                            <div
                                class="service-card group flex items-center gap-3 rounded-xl border-2 p-3.5 transition-all duration-200 cursor-pointer sm:gap-4 sm:p-4 {{ $selected ? 'border-[#5b2eff] bg-[#f5f2ff]/70 shadow-[0_6px_16px_rgba(91,46,255,0.10)]' : 'border-[#e2e8f0] bg-white hover:border-[#c7bcff] hover:bg-[#faf9ff] hover:shadow-sm' }}"
                                data-id="{{ $service->id }}"
                                data-title="{{ $service->title }}"
                                data-description="{{ $service->description ?? 'No description available for this service.' }}"
                                data-icon="{{ $serviceIcon }}"
                            >
                                <!-- Service icon badge -->
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-[16px] transition-all {{ $selected ? 'bg-gradient-to-br from-[#7a5bff] to-[#4310d8] text-white shadow-[0_8px_18px_rgba(91,46,255,0.25)]' : 'bg-[#f5f2ff] text-[#5b2eff] group-hover:bg-[#ece7ff]' }}">
                                    <i class="{{ $serviceIcon }}"></i>
                                </span>

                                <!-- Service name, description & optional quantity -->
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-x-2.5 gap-y-1">
                                        <span class="font-semibold text-[#0f172a] text-[15px]">
                                            {{ $service->title }}
                                        </span>

                                        @if ($selected)
                                            <!-- Quantity input -->
                                            <form method="POST" action="{{ route('company.booth-booking.services.quantity') }}" class="inline-flex items-center gap-1.5">
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
                                    <p class="mt-0.5 truncate text-[12.5px] leading-5 text-[#64748b]">
                                        {{ $service->description ?? 'Premium exhibition add-on.' }}
                                    </p>
                                </div>

                                <!-- Price -->
                                <div class="shrink-0 text-right">
                                    <div class="font-bold text-[#5b2eff] text-[15px]">&#8377;{{ number_format((float) $service->price) }}</div>
                                </div>

                                <!-- Checkbox form -->
                                <form method="POST" action="{{ route('company.booth-booking.services.toggle') }}" id="toggle-form-{{ $service->id }}" class="inline-flex shrink-0">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                    <input type="hidden" name="exhibition" value="{{ session('company_booth_booking.exhibition_slug') }}">
                                    <button type="submit" class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md border-2 transition-all {{ $selected ? 'border-[#5b2eff] bg-[#5b2eff] text-white' : 'border-[#cbd5e1] bg-white group-hover:border-[#5b2eff]' }}">
                                        @if($selected)
                                            <i class="fa-solid fa-check text-[11px]"></i>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-[#cbd5e1] bg-[#f8fafc] p-6 text-center text-[13.5px] font-medium text-[#64748b]">
                                No add-on services are available right now.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column (Service Details & Breakdown) -->
                <div class="lg:col-span-5">
                    <div class="flex flex-col gap-5 lg:sticky lg:top-6">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5f2ff] text-[#5b2eff]">
                                <i class="fa-solid fa-receipt text-[15px]"></i>
                            </span>
                            <h2 class="text-[17px] font-bold text-[#0f172a]">Service Details</h2>
                        </div>

                        <!-- Details Card -->
                        <div class="rounded-2xl border border-[#e2e8f0] bg-white p-5 shadow-sm">
                            <div class="flex items-start gap-4">
                                <span id="detail-service-icon-bg" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#7a5bff] to-[#4310d8] text-white shadow-[0_8px_20px_rgba(91,46,255,0.22)]">
                                    <i id="detail-service-icon" class="{{ $detailService?->icon ?: 'fa-regular fa-star' }} text-[18px]"></i>
                                </span>

                                <div class="min-w-0 flex-1">
                                    <h3 id="detail-service-title" class="text-[16px] font-bold text-[#0f172a]">
                                        {{ $detailService?->title ?? 'No service selected' }}
                                    </h3>
                                    <p id="detail-service-desc" class="mt-2 text-[13.5px] leading-relaxed text-[#64748b]">
                                        {{ $detailService?->description ?? 'Select a service from the list to see its details here.' }}
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
                                <div class="flex items-center justify-between rounded-xl bg-[#f5f2ff] px-4 py-3 text-[15px] font-bold">
                                    <span class="text-[#0f172a]">Total Amount</span>
                                    <span class="text-[18px] text-[#5b2eff]">&#8377;{{ number_format($amountToPay) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Premium highlight panel -->
                        <div class="relative hidden overflow-hidden rounded-2xl border border-[#e2e8f0] bg-gradient-to-br from-[#faf9ff] to-[#f8fafc] p-6 lg:block">
                            <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full bg-[#5b2eff]/10 blur-2xl"></div>
                            <div class="relative flex items-center gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7a5bff] to-[#4310d8] text-white shadow-[0_12px_24px_rgba(91,46,255,0.3)]">
                                    <i class="fa-solid fa-award text-[24px]"></i>
                                </div>
                                <div>
                                    <h4 class="text-[15px] font-bold text-[#0f172a]">Stand out at the event</h4>
                                    <p class="mt-1 text-[12.5px] leading-5 text-[#64748b]">Curated add-ons help you attract more visitors and capture quality leads.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bar (Shopping Cart & Continue Button) -->
            <div class="mt-7 border-t border-[#e2e8f0] pt-6">
                <div class="flex flex-col gap-4 rounded-2xl border border-[#e2e8f0] bg-[#f8fafc] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#f5f2ff] text-[#5b2eff]">
                            <i class="fa-solid fa-cart-shopping text-[18px]"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-base font-bold text-[#0f172a]">Selected Services ({{ $selectedServicesCount }})</h3>
                            @if ($selectedBookingServices->isEmpty())
                                <p class="mt-0.5 text-xs text-[#64748b]">No services selected yet.</p>
                            @else
                                <p class="mt-0.5 line-clamp-2 text-xs text-[#64748b]">
                                    {{ $selectedBookingServices->map(fn($bs) => $bs->service?->title . ($bs->quantity > 1 ? ' x' . $bs->quantity : ''))->join(', ') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-6">
                        <div class="text-left sm:text-right">
                            <span class="text-xs font-semibold text-[#64748b]">Total Amount</span>
                            <div class="mt-0.5 text-2xl font-extrabold text-[#0f172a]">&#8377;{{ number_format($amountToPay) }}</div>
                        </div>

                        <form method="POST" action="{{ route('company.booth-booking.services.continue') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-sm font-semibold text-white shadow-[0_8px_16px_rgba(91,46,255,0.25)] transition-all duration-200 hover:brightness-110 sm:min-w-[200px]">
                                Continue to Review
                                <i class="fa-solid fa-arrow-right text-[13px]"></i>
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
                    detailIcon.className = `${icon} text-[18px]`;
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
