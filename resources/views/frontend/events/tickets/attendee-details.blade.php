@extends('layouts.frontend')

@section('title', 'Attendee Details - ' . (isset($dbEvent) ? $dbEvent->title : 'Global Tech Summit 2024'))

@section('content')
<main class="px-[44px] pt-6 pb-12 flex-1 max-w-[1200px] w-full mx-auto">
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
                <span class="font-medium text-[#1F2A6A]">Attendee Details</span>
            </div>

            <!-- Page content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: Attendee Forms -->
                <div class="lg:col-span-8">
                    <div class="mb-6">
                        <h2 class="text-[22px] font-bold text-[#1F2A6A]">Attendee Information</h2>
                        <p class="mt-2 text-[15px] text-[#4E567A]">Enter details of the attendees for this booking.</p>
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
                            Continue
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
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-[#5B35D5] shadow-[0_2px_8px_rgba(91,53,213,0.08)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[22px] w-[22px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[15px] font-bold text-[#1F2A6A]" id="summary-event-title">
                                        {{ $dbEvent ? $dbEvent->title : 'Global Tech Summit 2024' }}
                                    </h4>
                                    <p class="mt-1 text-[13px] font-medium text-[#4E567A]" id="summary-event-date">
                                        {{ $dbEvent && $dbEvent->starts_at ? ($dbEvent->starts_at->format('M d') . ' - ' . ($dbEvent->ends_at ? $dbEvent->ends_at->format('M d, Y') : $dbEvent->starts_at->format('Y'))) : 'May 15 - May 17, 2024' }}
                                    </p>
                                    <p class="mt-1 text-[13px] leading-[1.5] text-[#6A708F]" id="summary-event-venue">
                                        {{ $dbEvent ? $dbEvent->venue_name : 'Jio World Convention Centre' }},<br>{{ $dbEvent ? $dbEvent->city : 'Mumbai' }}
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
    // Prefill data using logged-in Laravel User details
    const loggedInUser = {
        name: @json(auth()->user()->name ?? ''),
        email: @json(auth()->user()->email ?? ''),
        phone: @json(auth()->user()->phone ?? '')
    };

    function renderAttendeeCards(qty) {
        const container = document.getElementById('attendees-container');
        if (!container) return;
        
        let html = '';
        for (let i = 1; i <= qty; i++) {
            const isFirst = (i === 1);
            const nameVal = isFirst ? loggedInUser.name : '';
            const emailVal = isFirst ? loggedInUser.email : '';
            const phoneVal = isFirst ? loggedInUser.phone : '';
            
            html += `
            <div class="rounded-[16px] border border-[#E8E3F0] bg-white p-7 shadow-[0_2px_10px_rgba(31,42,107,0.02)] attendee-card" data-index="${i}">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-[16px] font-bold text-[#1F2A6A]">Attendee ${i}</h3>
                    ${!isFirst ? `
                    <button type="button" onclick="clearAttendeeFields(${i})" class="flex items-center gap-1.5 text-[14px] font-semibold text-[#E03137] hover:text-[#C92A2F] transition">
                        <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear
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
                        <input type="text" id="attendee-company-${i}" class="attendee-company rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                    </div>
                    
                    <!-- Job Title -->
                    <div class="flex flex-col gap-2 md:col-span-1">
                        <label class="text-[13px] font-bold text-[#1F2A6A]">Job Title (Optional)</label>
                        <input type="text" id="attendee-title-${i}" class="attendee-title rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white" />
                    </div>
                </div>
            </div>
            `;
        }
        container.innerHTML = html;
        updateRightPreview();
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
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (!orderData) {
            alert("Order details not found. Please select tickets again.");
            window.location.href = "{{ url('/events/tickets/select') }}";
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
            
            attendees.push({
                name: name,
                email: email,
                phone: phone,
                company: company,
                jobTitle: jobTitle
            });
        }
        
        // Save primary attendee details at root of orderData for database compatibility
        orderData.attendee_name = attendees[0].name;
        orderData.attendee_email = attendees[0].email;
        orderData.attendee_phone = attendees[0].phone;
        orderData.attendee_company = attendees[0].company;
        orderData.attendee_job_title = attendees[0].jobTitle;
        
        // Save all attendees
        orderData.attendees = attendees;
        
        localStorage.setItem("eventOrder", JSON.stringify(orderData));
        
        // Proceed to summary page with event query param
        const eventParam = orderData.eventSlug ? `?event=${encodeURIComponent(orderData.eventSlug)}` : '';
        window.location.href = "{{ url('/events/tickets/summary') }}" + eventParam;
    }

    // Initialize UI on page load
    document.addEventListener("DOMContentLoaded", () => {
        const orderData = JSON.parse(localStorage.getItem("eventOrder"));
        if (orderData) {
            const qty = orderData.quantity || 1;
            
            // Render forms for quantity of attendees
            renderAttendeeCards(qty);
            
            // Set tickets summary in right column
            const passLabel = document.getElementById("summary-pass-qty-label");
            if (passLabel) {
                passLabel.innerHTML = `${orderData.passName} &times; ${orderData.quantity}`;
            }
            
            const currency = orderData.priceCurrency || (orderData.eventSlug && orderData.eventSlug !== 'global-tech-summit-2024' ? 'INR' : '₹');
            const currencySymbol = currency === 'USD' ? '$' : (currency === 'INR' || currency === '₹' ? '₹' : currency + ' ');
            
            const passTotal = document.getElementById("summary-pass-total");
            if (passTotal) {
                passTotal.innerText = `${currencySymbol}${(orderData.price * orderData.quantity).toFixed(2)}`;
            }
            
            const totalAmount = document.getElementById("summary-total-amount");
            if (totalAmount) {
                totalAmount.innerText = `${currencySymbol}${(orderData.totalAmount).toFixed(2)}`;
            }
        } else {
            // Default fallback
            renderAttendeeCards(1);
        }
    });
</script>
@endpush
