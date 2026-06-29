@extends('layouts.frontend')

@section('title', 'Attendee Details - ' . (isset($dbEvent) ? $dbEvent->title : 'Global Tech Summit 2024'))

@section('content')
@php
    $eventSlugForOrder = isset($dbEvent) ? $dbEvent->slug : ($slug ?? 'global-tech-summit-2024');
    $eventTicketDuration = 'Event Duration';

    if (isset($dbEvent) && $dbEvent->starts_at) {
        $eventDays = $dbEvent->ends_at
            ? max(1, $dbEvent->starts_at->copy()->startOfDay()->diffInDays($dbEvent->ends_at->copy()->startOfDay()) + 1)
            : 1;
        $eventTicketDuration = $eventDays . ' ' . str('Day')->plural($eventDays);
    }
@endphp
<main class="px-4 md:px-[44px] pt-6 pb-12 flex-1 max-w-[1200px] w-full mx-auto">
            <!-- Breadcrumbs -->
            <div class="mb-8 flex items-center gap-2 text-[14px] text-[#6A708F]">
                <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url('/events/listings') }}" class="hover:text-[#5B35D5] transition">Events</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                @if (isset($dbEvent))
                    <a href="{{ route('events.listings.show', $dbEvent->slug) }}" class="hover:text-[#5B35D5] transition">{{ $dbEvent->title }}</a>
                @else
                    <a href="{{ url('/events/listings/global-tech-summit-2024') }}" class="hover:text-[#5B35D5] transition">Global Tech Summit 2024</a>
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-[#1F2A6A]">Select Tickets</span>
            </div>

            @include('frontend.events.tickets.partials.event-flow-stepper', ['currentStep' => 2])

            <!-- Page content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: Ticket Selection + Attendee Forms -->
                <div class="lg:col-span-8">
                    @include('frontend.events.tickets.partials.ticket-type-selection', ['dbEvent' => $dbEvent ?? null, 'eventTicketDuration' => $eventTicketDuration])

                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-[22px] font-bold text-[#1F2A6A]">Attendee Information</h2>
                            <p class="mt-2 text-[15px] text-[#4E567A]">Enter details of the attendees for this booking.</p>
                        </div>
                        <button type="button" onclick="addAttendee()" class="rounded-xl border border-[#B9A8F3] px-5 py-3 text-[14px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF] hover:border-[#5B35D5]">
                            Add Attendee
                        </button>
                    </div>

                    <div id="attendees-container" class="space-y-6">
                        <!-- Populated dynamically via JavaScript -->
                    </div>

                    <!-- Bottom Actions -->
                    <div class="flex items-center justify-between border-t border-[#E8E3F0] pt-8 mt-12">
                        <button onclick="window.history.back()" class="rounded-xl border border-[#B9A8F3] px-9 py-3.5 text-[15px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF] hover:border-[#5B35D5]">
                            Back
                        </button>
                        <button onclick="validateAndProceed()" class="rounded-xl bg-[#4318FF] px-10 py-3.5 text-[15px] font-bold text-white transition hover:bg-[#3412C9] shadow-[0_8px_20px_rgba(67,24,255,0.25)]">
                            Continue to Payment
                        </button>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-4">
                    <div class="rounded-[20px] border border-[#E8E3F0] bg-[#FAFAFC] p-8 sticky top-8">
                        <h3 class="mb-7 text-[20px] font-bold text-[#1F2A6A]">Order Summary</h3>
                        
                        <!-- Event Info -->
                        <div class="mb-7 rounded-2xl bg-[#F4F0FF] p-5 border border-[#E8E3F0]">
                            <div class="flex items-start gap-4">
                                <img
                                    src="{{ \App\Support\LiveContent::resolveCompanyEventBrandingImageUrl($dbEvent?->branding, asset('images/events/banner_bg.png')) }}"
                                    alt="{{ $dbEvent?->title ?? 'Event' }}"
                                    class="h-14 w-14 shrink-0 rounded-xl object-cover bg-white shadow-[0_2px_8px_rgba(91,53,213,0.08)]"
                                >
                                <div class="min-w-0">
                                    <h4 class="text-[15px] font-bold text-[#1F2A6A]" id="summary-event-title">
                                        {{ $dbEvent ? $dbEvent->title : 'Global Tech Summit 2024' }}
                                    </h4>
                                    <p class="mt-1 text-[13px] font-medium text-[#4E567A]" id="summary-event-date">
                                        {{ $dbEvent && $dbEvent->starts_at ? ($dbEvent->starts_at->format('M d') . ' - ' . ($dbEvent->ends_at ? $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format('Y'))) : 'May 15 - May 17, 2024' }}
                                    </p>
                                    <p class="mt-1 text-[13px] leading-[1.5] text-[#6A708F]" id="summary-event-venue">
                                        {{ isset($dbEvent) ? \App\Support\LiveContent::formatCompanyEventVenue($dbEvent) : 'Jio World Convention Centre, Mumbai, India' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Summary -->
                        <div class="border-b border-[#E8E3F0] pb-6" id="summary-tickets-container">
                            <h4 class="mb-4 text-[16px] font-bold text-[#1F2A6A]">Tickets</h4>
                            <div class="flex items-center justify-between" id="summary-tickets-item">
                                <span class="text-[14.5px] font-medium text-[#4E567A]" id="summary-pass-qty-label">General Pass &times; 2</span>
                                <span class="text-[15px] font-bold text-[#1F2A6A]" id="summary-pass-total">₹98.00</span>
                            </div>
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="flex items-center justify-between border-b border-[#E8E3F0] py-6">
                            <span class="text-[16px] font-bold text-[#1F2A6A]">Total Amount</span>
                            <span class="text-[26px] font-extrabold text-[#1F2A6A]" id="summary-total-amount">₹98.00</span>
                        </div>

                        <!-- Attendee Preview Summary -->
                        <div class="py-6">
                            <div class="mb-5 flex items-center justify-between">
                                <h4 class="text-[15px] font-bold text-[#1F2A6A]">Attendee Details</h4>
                            </div>
                            
                            <div id="summary-attendees-preview" class="space-y-5">
                                <!-- Populated dynamically via JavaScript -->
                            </div>
                        </div>

                        <!-- Terms & Conditions Footer -->
                        <div class="mt-2 flex items-start gap-3 rounded-[12px] bg-[#F4F0FF] p-4 border border-[#E8E3F0]/50">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#5B35D5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <p class="text-[12.5px] leading-relaxed text-[#4E567A]">
                                By proceeding, you agree to our <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Terms & Conditions</a> and <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Cancellation Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
@endsection

@push('scripts')
<script>
    const loggedInUser = {
        name: @json(auth()->user()->name ?? ''),
        email: @json(auth()->user()->email ?? ''),
        phone: @json(auth()->user()->phone ?? ''),
        gender: @json(auth()->user()->gender ?? ''),
        city: @json(auth()->user()->city ?? '')
    };
    const eventSlugForOrder = @json($eventSlugForOrder);

@if (isset($dbEvent) && $dbEvent->ticketTypes->isNotEmpty())
    const prices = {
        @foreach ($dbEvent->ticketTypes as $ticketType)
            '{{ Str::slug($ticketType->name) }}': {{ (float) $ticketType->price }},
        @endforeach
    };
    const quantities = {
        @foreach ($dbEvent->ticketTypes as $ticketType)
            '{{ Str::slug($ticketType->name) }}': 0,
        @endforeach
    };
    const maxQuantities = {
        @foreach ($dbEvent->ticketTypes as $ticketType)
            '{{ Str::slug($ticketType->name) }}': {{ max(0, (int) ($ticketType->quantity_total ?? 0) - (int) ($ticketType->quantity_sold ?? 0)) ?: 'Number.MAX_SAFE_INTEGER' }},
        @endforeach
    };
    const passNames = {
        @foreach ($dbEvent->ticketTypes as $ticketType)
            '{{ Str::slug($ticketType->name) }}': @json($ticketType->name),
        @endforeach
    };
    const currencyLabel = @json($dbEvent->ticketTypes->first()?->currency ?? 'INR');
@else
    const prices = { general: 49.00 };
    const quantities = { general: 1 };
    const maxQuantities = { general: Number.MAX_SAFE_INTEGER };
    const passNames = { general: 'General Pass' };
    const currencyLabel = 'INR';
@endif

    const ticketStockByType = maxQuantities;
    const ticketPriceByType = prices;
    const ticketCurrencyByType = Object.fromEntries(Object.keys(prices).map((key) => [key, currencyLabel]));

    function selectPass(type) {
        for (const key in quantities) {
            if (key !== type && quantities[key] > 0) {
                quantities[key] = 0;
                updateTicketUI(key);
            }
        }

        if (quantities[type] === 0) {
            quantities[type] = 1;
        }

        updateTicketUI(type);
        syncEventOrderFromSelection();
    }

    function updateQty(type, delta, clickEvent) {
        if (clickEvent) clickEvent.stopPropagation();
        if (quantities[type] + delta < 0) return;
        if (delta > 0 && quantities[type] >= maxQuantities[type]) return;

        if (delta > 0) {
            for (const key in quantities) {
                if (key !== type && quantities[key] > 0) {
                    quantities[key] = 0;
                    updateTicketUI(key);
                }
            }
        }

        quantities[type] += delta;
        updateTicketUI(type);
        syncEventOrderFromSelection();
    }

    function updateTicketUI(type) {
        const qtyElement = document.getElementById(`qty-${type}`);
        if (qtyElement) qtyElement.innerText = quantities[type];

        const card = document.getElementById(`card-${type}`);
        const radio = document.getElementById(`radio-${type}`);
        const iconWrapper = document.getElementById(`icon-wrapper-${type}`);

        if (quantities[type] > 0) {
            if (card) card.className = 'flex cursor-pointer flex-col gap-4 rounded-xl border border-[#5B35D5] bg-[#FBFAFE] p-5 shadow-[0_2px_10px_rgba(91,53,213,0.05)] transition sm:flex-row sm:items-center sm:justify-between';
            if (radio) {
                radio.innerHTML = '<div class="h-2.5 w-2.5 rounded-full bg-[#5B35D5]"></div>';
                radio.className = 'mt-1 flex h-5 w-5 items-center justify-center rounded-full border-2 border-[#5B35D5] bg-white transition';
            }
            if (iconWrapper) iconWrapper.className = 'flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#5B35D5] text-white transition';
        } else {
            if (card) card.className = 'flex cursor-pointer flex-col gap-4 rounded-xl border border-[#E8E3F0] bg-white p-5 transition hover:border-[#D0D4EA] sm:flex-row sm:items-center sm:justify-between';
            if (radio) {
                radio.innerHTML = '';
                radio.className = 'mt-1 h-5 w-5 rounded-full border-2 border-[#D0D4EA] transition';
            }
            if (iconWrapper) iconWrapper.className = 'flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-lg bg-[#F4F0FF] text-[#5B35D5] transition';
        }
    }

    function getActivePassSelection() {
        let activePass = null;
        let totalQty = 0;
        let totalAmt = 0;

        for (const key in quantities) {
            if (quantities[key] > 0) {
                activePass = key;
                totalQty += quantities[key];
                totalAmt += quantities[key] * prices[key];
            }
        }

        return { activePass, totalQty, totalAmt };
    }

    function syncEventOrderFromSelection() {
        const { activePass, totalQty, totalAmt } = getActivePassSelection();
        if (!activePass || totalQty === 0) {
            localStorage.removeItem('eventOrder');
            updateOrderSummary(null);
            return null;
        }

        const existing = JSON.parse(localStorage.getItem('eventOrder') || '{}');
        const orderData = {
            eventSlug: eventSlugForOrder,
            passType: activePass,
            passName: passNames[activePass] || activePass,
            quantity: totalQty,
            price: prices[activePass],
            priceCurrency: currencyLabel,
            totalAmount: totalAmt,
            attendees: existing.attendees || [],
            attendee_name: existing.attendee_name || '',
            attendee_email: existing.attendee_email || '',
            attendee_phone: existing.attendee_phone || '',
        };

        localStorage.setItem('eventOrder', JSON.stringify(orderData));
        updateOrderSummary(orderData);

        const qty = totalQty;
        if (document.getElementById('attendees-container')?.children.length !== qty) {
            renderAttendeeCards(qty, orderData.attendees || []);
        } else {
            syncOrderQuantity(qty, readAttendeesFromForm());
        }

        return orderData;
    }

    function restoreTicketSelectionFromOrder(orderData) {
        if (!orderData?.passType || quantities[orderData.passType] === undefined) {
            const firstKey = Object.keys(quantities)[0];
            if (firstKey) {
                quantities[firstKey] = orderData?.quantity || 1;
                updateTicketUI(firstKey);
            }
            return syncEventOrderFromSelection();
        }

        for (const key in quantities) {
            quantities[key] = 0;
            updateTicketUI(key);
        }

        quantities[orderData.passType] = orderData.quantity || 1;
        updateTicketUI(orderData.passType);
        return syncEventOrderFromSelection();
    }

    function getCurrencySymbol(orderData) {
        const currency = orderData?.priceCurrency || (orderData?.eventSlug && orderData.eventSlug !== 'global-tech-summit-2024' ? 'INR' : '₹');
        return currency === 'USD' ? '$' : (currency === 'INR' || currency === '₹' ? '₹' : currency + ' ');
    }

    function readAttendeesFromForm() {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        const qty = orderData ? orderData.quantity : 1;
        const attendees = [];

        for (let i = 1; i <= qty; i++) {
            attendees.push({
                name: document.getElementById(`attendee-name-${i}`)?.value.trim() || '',
                email: document.getElementById(`attendee-email-${i}`)?.value.trim() || '',
                phone: document.getElementById(`attendee-phone-${i}`)?.value.trim() || '',
                company: document.getElementById(`attendee-company-${i}`)?.value.trim() || '',
                jobTitle: document.getElementById(`attendee-title-${i}`)?.value.trim() || ''
            });
        }

        return attendees;
    }

    function syncOrderQuantity(qty, attendees = null) {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) return null;

        if (ticketPriceByType[orderData.passType] !== undefined) {
            orderData.price = Number(ticketPriceByType[orderData.passType]);
        }
        if (ticketCurrencyByType[orderData.passType]) {
            orderData.priceCurrency = ticketCurrencyByType[orderData.passType];
        }

        orderData.quantity = Math.max(1, qty);
        orderData.totalAmount = Number(orderData.price || 0) * orderData.quantity;
        orderData.attendees = attendees ?? readAttendeesFromForm().slice(0, orderData.quantity);

        localStorage.setItem("eventOrder", JSON.stringify(orderData));
        updateOrderSummary(orderData);

        return orderData;
    }

    function updateOrderSummary(orderData = null) {
        orderData = orderData || JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) return;

        const qty = orderData.quantity || 1;
        const currencySymbol = getCurrencySymbol(orderData);

        const passLabel = document.getElementById("summary-pass-qty-label");
        if (passLabel) {
            passLabel.innerHTML = `${orderData.passName} &times; ${qty}`;
        }

        const passTotal = document.getElementById("summary-pass-total");
        if (passTotal) {
            passTotal.innerText = `${currencySymbol}${(Number(orderData.price || 0) * qty).toFixed(2)}`;
        }

        const totalAmount = document.getElementById("summary-total-amount");
        if (totalAmount) {
            totalAmount.innerText = `${currencySymbol}${Number(orderData.totalAmount || 0).toFixed(2)}`;
        }
    }

    function renderAttendeeCards(qty, existingAttendees = null) {
        const container = document.getElementById('attendees-container');
        if (!container) return;

        const savedAttendees = existingAttendees ?? (JSON.parse(localStorage.getItem("eventOrder"))?.attendees || []);
        
        let html = '';
        for (let i = 1; i <= qty; i++) {
            const isFirst = (i === 1);
            const saved = savedAttendees[i - 1] || {};
            const nameVal = saved.name ?? (isFirst ? loggedInUser.name : '');
            const emailVal = saved.email ?? (isFirst ? loggedInUser.email : '');
            const phoneVal = saved.phone ?? (isFirst ? loggedInUser.phone : '');
            const companyVal = saved.company ?? '';
            const jobTitleVal = saved.jobTitle ?? '';
            
            html += `
            <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-7 shadow-[0_2px_10px_rgba(31,42,107,0.02)] attendee-card" data-index="${i}">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-[16px] font-bold text-[#1F2A6A]">Attendee ${i}</h3>
                    ${qty > 1 ? `
                    <button type="button" onclick="deleteAttendee(${i})" class="flex items-center gap-1.5 text-[14px] font-semibold text-[#E03137] hover:text-[#C92A2F] transition">
                        <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                    ` : ''}
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Full Name -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Full Name <span class="text-[#E03137]">*</span></label>
                        <input type="text" id="attendee-name-${i}" value="${nameVal}" oninput="updateRightPreview()" class="attendee-name rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" required />
                    </div>
                    
                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Email Address <span class="text-[#E03137]">*</span></label>
                        <input type="email" id="attendee-email-${i}" value="${emailVal}" oninput="updateRightPreview()" class="attendee-email rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" required />
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Phone Number <span class="text-[#E03137]">*</span></label>
                        <div class="flex items-center overflow-hidden rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] transition focus-within:border-[#5B35D5] focus-within:bg-white">
                            <button type="button" class="flex items-center gap-2 border-r border-[#E8E3F0] px-4 py-3 text-[14px] font-medium text-[#1F2A6A] hover:bg-[#F1EFF7] transition">
                                <img src="https://flagcdn.com/w20/in.png" alt="India Flag" class="h-3.5 w-5 rounded-sm object-cover" />
                            </button>
                            <input type="tel" id="attendee-phone-${i}" value="${phoneVal}" oninput="updateRightPreview()" class="attendee-phone w-full bg-transparent px-4 py-3 text-[14px] text-[#1F2A6A] outline-none" required />
                        </div>
                    </div>
                    
                    <!-- Company -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Company (Optional)</label>
                        <input type="text" id="attendee-company-${i}" value="${companyVal}" class="attendee-company rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                    </div>
                    
                    <!-- Job Title -->
                    <div class="flex flex-col gap-2 md:col-span-1">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Job Title (Optional)</label>
                        <input type="text" id="attendee-title-${i}" value="${jobTitleVal}" class="attendee-title rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                    </div>
                </div>
            </div>
            `;
        }
        container.innerHTML = html;
        updateRightPreview();
    }

    function addAttendee() {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) return;

        const maxQty = ticketStockByType[orderData.passType] || Number.MAX_SAFE_INTEGER;
        if ((orderData.quantity || 1) >= maxQty) {
            alert("No more tickets are available for this pass.");
            return;
        }

        const attendees = readAttendeesFromForm();
        attendees.push({ name: '', email: '', phone: '', company: '', jobTitle: '' });

        syncOrderQuantity((orderData.quantity || 1) + 1, attendees);
        renderAttendeeCards(attendees.length, attendees);
    }

    function deleteAttendee(index) {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData || (orderData.quantity || 1) <= 1) return;

        const attendees = readAttendeesFromForm();
        attendees.splice(index - 1, 1);

        syncOrderQuantity(attendees.length, attendees);
        renderAttendeeCards(attendees.length, attendees);
    }

    function clearAttendeeFields(i) {
        const nameInput = document.getElementById(`attendee-name-${i}`);
        const emailInput = document.getElementById(`attendee-email-${i}`);
        const phoneInput = document.getElementById(`attendee-phone-${i}`);
        const companyInput = document.getElementById(`attendee-company-${i}`);
        const titleInput = document.getElementById(`attendee-title-${i}`);
        
        if (nameInput) nameInput.value = '';
        if (emailInput) emailInput.value = '';
        if (phoneInput) phoneInput.value = '';
        if (companyInput) companyInput.value = '';
        if (titleInput) titleInput.value = '';
        
        updateRightPreview();
    }

    function updateRightPreview() {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        const qty = orderData ? orderData.quantity : 1;
        const previewContainer = document.getElementById('summary-attendees-preview');
        if (!previewContainer) return;
        
        let html = '';
        for (let i = 1; i <= qty; i++) {
            const nameInput = document.getElementById(`attendee-name-${i}`);
            const emailInput = document.getElementById(`attendee-email-${i}`);
            const phoneInput = document.getElementById(`attendee-phone-${i}`);
            
            const nameVal = nameInput ? nameInput.value.trim() : (i === 1 ? loggedInUser.name : '');
            const emailVal = emailInput ? emailInput.value.trim() : (i === 1 ? loggedInUser.email : '');
            const phoneVal = phoneInput ? phoneInput.value.trim() : (i === 1 ? loggedInUser.phone : '');
            
            html += `
            <div class="${i < qty ? 'mb-5' : ''} space-y-0.5">
                <h5 class="mb-1 text-[13.5px] font-bold text-[#4E567A]">Attendee ${i}</h5>
                <p class="text-[13px] text-[#6A708F]">${nameVal || '<i class="text-gray-400 font-normal">Pending Name</i>'}</p>
                <p class="text-[13px] text-[#6A708F]">${emailVal || '<i class="text-gray-400 font-normal">Pending Email</i>'}</p>
                <p class="text-[13px] text-[#6A708F]">${phoneVal || '<i class="text-gray-400 font-normal">Pending Phone</i>'}</p>
            </div>
            `;
        }
        previewContainer.innerHTML = html;
    }

    function validateAndProceed() {
        const orderData = syncEventOrderFromSelection();
        if (!orderData) {
            alert('Please select at least one ticket to continue.');
            document.getElementById('ticket-selection-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            return;
        }
        
        const qty = orderData.quantity || 1;
        const attendees = [];
        
        for (let i = 1; i <= qty; i++) {
            const name = document.getElementById(`attendee-name-${i}`).value.trim();
            const email = document.getElementById(`attendee-email-${i}`).value.trim();
            const phone = document.getElementById(`attendee-phone-${i}`).value.trim();
            const company = document.getElementById(`attendee-company-${i}`).value.trim();
            const jobTitle = document.getElementById(`attendee-title-${i}`).value.trim();
            
            if (!name) {
                alert(`Please enter Full Name for Attendee ${i}`);
                document.getElementById(`attendee-name-${i}`).focus();
                return;
            }
            if (!email) {
                alert(`Please enter Email Address for Attendee ${i}`);
                document.getElementById(`attendee-email-${i}`).focus();
                return;
            }
            if (!phone) {
                alert(`Please enter Phone Number for Attendee ${i}`);
                document.getElementById(`attendee-phone-${i}`).focus();
                return;
            }
            
            attendees.push({ name, email, phone, company, jobTitle });
        }
        
        orderData.attendee_name = attendees[0].name;
        orderData.attendee_email = attendees[0].email;
        orderData.attendee_phone = attendees[0].phone;
        orderData.attendee_gender = loggedInUser.gender || '';
        orderData.attendee_city = loggedInUser.city || '';
        orderData.attendee_company = attendees[0].company;
        orderData.attendee_job_title = attendees[0].jobTitle;
        orderData.attendees = attendees;
        orderData.quantity = qty;
        orderData.totalAmount = Number(orderData.price || 0) * qty;

        localStorage.setItem('eventOrder', JSON.stringify(orderData));
        
        window.location.href = "{{ route('events.tickets.payment') }}?event=" + encodeURIComponent(orderData.eventSlug);
    }

    // Initialize UI on page load
    document.addEventListener('DOMContentLoaded', () => {
        const savedOrder = JSON.parse(localStorage.getItem('eventOrder') || 'null');
        const orderData = savedOrder && savedOrder.eventSlug === eventSlugForOrder
            ? restoreTicketSelectionFromOrder(savedOrder)
            : syncEventOrderFromSelection();

        if (orderData) {
            renderAttendeeCards(orderData.quantity || 1, orderData.attendees || []);
            updateOrderSummary(orderData);
        } else {
            const firstKey = Object.keys(quantities)[0];
            if (firstKey) {
                quantities[firstKey] = 1;
                updateTicketUI(firstKey);
                const initialized = syncEventOrderFromSelection();
                renderAttendeeCards(initialized?.quantity || 1, initialized?.attendees || []);
            } else {
                renderAttendeeCards(1);
            }
        }
    });
</script>
@endpush
