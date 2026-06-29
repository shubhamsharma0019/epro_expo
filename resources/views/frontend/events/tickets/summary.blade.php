@extends('layouts.frontend')

@section('title', 'Review & Confirm - ' . (isset($dbEvent) ? $dbEvent->title : 'Global Tech Summit 2024'))

@section('content')
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
                <span class="font-medium text-[#1F2A6A]">Review & Confirm</span>
            </div>

            <!-- Page content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: Review Your Order -->
                <div class="lg:col-span-8">
                    <div class="mb-6">
                        <h2 class="text-[22px] font-bold text-[#1F2A6A]">Review Your Order</h2>
                        <p class="mt-2 text-[15px] text-[#4E567A]">Please review your order details before proceeding.</p>
                    </div>

                    <!-- Single Large Card for all sections -->
                    <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-7 shadow-[0_2px_10px_rgba(31,42,107,0.02)]">
                        
                        <!-- Event Summary Section -->
                        <div>
                            <h3 class="mb-5 text-[16px] font-bold text-[#1F2A6A]">Event Summary</h3>
                            <div class="flex flex-col sm:flex-row items-start gap-5 rounded-xl border border-[#E8E3F0] p-4 bg-[#FAFAFC]">
                                <img src="{{ \App\Support\LiveContent::resolveCompanyEventBrandingImageUrl($dbEvent?->branding, asset('images/events/banner_bg.png')) }}" alt="Event Thumbnail" class="h-[110px] w-[180px] rounded-lg object-cover shadow-sm bg-gray-200" />
                                <div class="flex-1">
                                    <h4 class="mb-2.5 text-[17px] font-bold text-[#1F2A6A]">
                                        {{ $dbEvent ? $dbEvent->title : 'Global Tech Summit 2024' }}
                                    </h4>
                                    
                                    <div class="mb-3 space-y-2 text-[13px] text-[#4E567A]">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>
                                                {{ $dbEvent && $dbEvent->starts_at ? ($dbEvent->starts_at->format('M d') . ' - ' . ($dbEvent->ends_at ? $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format('Y'))) : 'May 15 - May 17, 2024' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ isset($dbEvent) ? \App\Support\LiveContent::formatCompanyEventVenue($dbEvent) : 'Jio World Convention Centre, Mumbai, India' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2.5">
                                        <span class="rounded-md bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold text-[#5B35D5]">{{ $dbEvent ? $dbEvent->category : 'Conference' }}</span>
                                        <span class="rounded-md bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold text-[#5B35D5]">{{ $dbEvent ? $dbEvent->event_mode : 'Technology' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="my-7 h-px bg-[#E8E3F0]"></div>

                        <!-- Tickets Section -->
                        <div>
                            <div class="mb-4 flex items-center gap-2 text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                <h3 class="text-[16px] font-bold text-[#1F2A6A]">Tickets</h3>
                            </div>
                            
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h4 class="text-[15px] font-semibold text-[#1F2A6A]" id="left-pass-name">General Pass</h4>
                                    <p class="mt-1 text-[13px] text-[#6A708F]" id="left-pass-desc">Access to all sessions</p>
                                </div>
                                <div class="flex flex-col items-end gap-1 border-t border-gray-100 pt-3 sm:border-t-0 sm:pt-0">
                                    <div class="flex items-center gap-6 min-[400px]:gap-10">
                                        <span class="text-[14px] font-medium text-[#1F2A6A]" id="left-pass-price-qty">₹49.00 &times; 2</span>
                                        <span class="text-[15px] font-bold text-[#1F2A6A] w-24 text-right" id="left-pass-total">₹98.00</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-5 border-t border-[#F1EFF7] pt-5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[14px] font-bold text-[#5B35D5]">Total Tickets</span>
                                    <span class="text-[15px] font-bold text-[#1F2A6A] w-24 text-right" id="left-total-tickets">2</span>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="my-7 h-px bg-[#E8E3F0]"></div>

                        <!-- Attendee Details Section -->
                        <div>
                            <div class="mb-5 flex items-center gap-2 text-[#5B35D5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <h3 class="text-[16px] font-bold text-[#1F2A6A]" id="left-attendees-count-title">Attendee Details (2)</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-4" id="left-attendees-list">
                                <!-- Populated dynamically via JavaScript -->
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Actions -->
                    <div class="mt-8 flex items-center justify-between border-t border-[#E8E3F0] pt-8">
                        <button onclick="window.history.back()" class="rounded-xl border border-[#B9A8F3] px-9 py-3.5 text-[15px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF] hover:border-[#5B35D5]">
                            Back
                        </button>
                        <button onclick="proceedToPayment()" class="rounded-xl bg-[#4318FF] px-10 py-3.5 text-[15px] font-bold text-white transition hover:bg-[#3412C9] shadow-[0_8px_20px_rgba(67,24,255,0.25)]">
                            Proceed to Payment
                        </button>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-4">
                    <div class="rounded-[20px] border border-[#E8E3F0] bg-white p-8 shadow-[0_2px_10px_rgba(31,42,107,0.02)] sticky top-8">
                        <h3 class="mb-7 text-[20px] font-bold text-[#1F2A6A]">Order Summary</h3>
                        
                        <!-- Tickets Summary -->
                        <div class="border-b border-[#E8E3F0] pb-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-[15px] font-semibold text-[#2B3263]" id="right-pass-name">General Pass</h4>
                                    <p class="mt-1.5 text-[13px] text-[#6A708F]" id="right-pass-price-qty">₹49.00 &times; 2</p>
                                </div>
                                <span class="text-[15px] font-bold text-[#1F2A6A]" id="right-pass-total">₹98.00</span>
                            </div>
                        </div>
                        
                        <!-- Total Tickets & Amount -->
                        <div class="border-b border-[#E8E3F0] py-6 space-y-5">
                            <div class="flex items-center justify-between">
                                <span class="text-[15px] font-medium text-[#4E567A]">Total Tickets</span>
                                <span class="text-[16px] font-bold text-[#1F2A6A]" id="right-total-tickets">2</span>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-[16px] font-bold text-[#1F2A6A]">Total Amount</span>
                                <span class="text-[26px] font-extrabold text-[#1F2A6A]" id="right-total-amount">₹98.00</span>
                            </div>
                        </div>

                        <!-- Attendee Preview Summary -->
                        <div class="py-6 border-b border-[#E8E3F0]">
                            <div class="mb-5 flex items-center justify-between">
                                <h4 class="text-[15px] font-bold text-[#1F2A6A]">Attendee Details</h4>
                                <button onclick="window.history.back()" class="text-[14px] font-bold text-[#5B35D5] hover:underline">Edit</button>
                            </div>
                            
                            <div id="right-attendees-list" class="space-y-5">
                                <!-- Populated dynamically via JavaScript -->
                            </div>
                        </div>
                        
                        <!-- Trust & Security Box -->
                        <div class="mt-6 rounded-[16px] border border-[#E8E3F0] bg-[#FAFAFC] p-5 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#F4F0FF] text-[#5B35D5]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[13.5px] font-semibold text-[#1F2A6A]">Your payment is secure and encrypted.</p>
                                    <p class="mt-1.5 text-[12.5px] leading-relaxed text-[#6A708F]">
                                        By proceeding, you agree to our <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Terms & Conditions</a> and <a href="{{ url('/events') }}" class="font-bold text-[#5B35D5] hover:underline">Cancellation Policy</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
@endsection

@push('scripts')
<script>
    function proceedToPayment() {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) {
            alert("Order details not found.");
            return;
        }
        const eventParam = orderData.eventSlug ? `?event=${encodeURIComponent(orderData.eventSlug)}` : '';
        window.location.href = "{{ url('/events/tickets/payment') }}" + eventParam;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) {
            alert("No ticket selection found. Redirecting to selection page.");
            window.location.href = "{{ url('/events/tickets/select') }}";
            return;
        }

        const attendees = orderData.attendees || [];
        const qty = orderData.quantity || 1;
        const currency = orderData.priceCurrency || (orderData.eventSlug && orderData.eventSlug !== 'global-tech-summit-2024' ? 'INR' : '₹');
        const currencySymbol = currency === 'USD' ? '$' : (currency === 'INR' || currency === '₹' ? '₹' : currency + ' ');

        // Update left tickets section
        document.getElementById("left-pass-name").innerText = orderData.passName;
        document.getElementById("left-pass-price-qty").innerHTML = `${currencySymbol}${orderData.price.toFixed(2)} &times; ${qty}`;
        document.getElementById("left-pass-total").innerText = `${currencySymbol}${orderData.totalAmount.toFixed(2)}`;
        document.getElementById("left-total-tickets").innerText = qty;

        // Update left attendees title and list
        document.getElementById("left-attendees-count-title").innerText = `Attendee Details (${qty})`;
        const leftAttendeesList = document.getElementById("left-attendees-list");
        let leftHtml = '';
        
        // Update right order summary
        document.getElementById("right-pass-name").innerText = orderData.passName;
        document.getElementById("right-pass-price-qty").innerHTML = `${currencySymbol}${orderData.price.toFixed(2)} &times; ${qty}`;
        document.getElementById("right-pass-total").innerText = `${currencySymbol}${orderData.totalAmount.toFixed(2)}`;
        document.getElementById("right-total-tickets").innerText = qty;
        document.getElementById("right-total-amount").innerText = `${currencySymbol}${orderData.totalAmount.toFixed(2)}`;

        const rightAttendeesList = document.getElementById("right-attendees-list");
        let rightHtml = '';

        for (let i = 0; i < qty; i++) {
            const att = attendees[i] || {
                name: 'Attendee ' + (i + 1),
                email: 'N/A',
                phone: 'N/A',
                company: '',
                jobTitle: ''
            };

            const initials = att.name ? att.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'A';
            const companyDisplay = att.company ? `${att.jobTitle || 'Representative'}, ${att.company}` : (att.jobTitle || 'Representative');

            leftHtml += `
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 rounded-xl bg-[#FAFAFC] border border-[#E8E3F0] p-4">
                <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#F1EFF7] text-[15px] font-bold text-[#1F2A6A]">
                    ${initials}
                </div>
                <div class="flex-1 w-full flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-[14.5px] font-bold text-[#1F2A6A]">${att.name}</h4>
                        <p class="mt-0.5 text-[13px] text-[#6A708F]">${companyDisplay}</p>
                    </div>
                    <div class="space-y-1 md:text-right">
                        <div class="flex items-center md:justify-end gap-2 text-[13px] text-[#4E567A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>${att.email}</span>
                        </div>
                        <div class="flex items-center md:justify-end gap-2 text-[13px] text-[#4E567A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>${att.phone}</span>
                        </div>
                    </div>
                </div>
            </div>
            `;

            rightHtml += `
            <div class="${i < qty - 1 ? 'mb-5' : ''} space-y-0.5">
                <h5 class="mb-1 text-[13.5px] font-bold text-[#4E567A]">${i + 1}. ${att.name}</h5>
                <p class="text-[13px] text-[#6A708F]">${att.email}</p>
                <p class="text-[13px] text-[#6A708F]">${att.phone}</p>
            </div>
            `;
        }

        leftAttendeesList.innerHTML = leftHtml;
        rightAttendeesList.innerHTML = rightHtml;
    });
</script>
@endpush
