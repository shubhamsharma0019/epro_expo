@php
    $title = $title ?? 'Exhibition';
    $bannerImage = $bannerImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $dateStr = $dateStr ?? 'Date TBD';
    $location = $location ?? 'Virtual';
    $timeStr = $timeStr ?? 'Time TBD';
    $pavilions = $pavilions ?? collect();
    $countries = $countries ?? collect(['India']);
    $states = $states ?? collect();
    $cities = $cities ?? collect();
    $industries = $industries ?? collect();
    $companySizes = $companySizes ?? collect();
    $defaultCountry = $defaultCountry ?? $countries->first();
    $showVisitorSidebar = $showVisitorSidebar ?? false;
    $tiers = $tiers ?? collect();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Pass Selection - EproExpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F4F0FF', 100: '#E0D4FC', 500: '#5A32FA', 600: '#4A22E0', 700: '#3D1CBA' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Form Inputs */
        .form-input {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1E293B;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #5A32FA; }
        .form-input::placeholder { color: #94A3B8; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .required { color: #EF4444; }
    </style>
    @include('frontend.exhibitions.visitor.partials.ticket-responsive')
</head>
<body class="text-[#1E293B] font-sans flex min-h-screen flex-col lg:h-screen lg:overflow-hidden">

    <!-- Sidebar Overlay for mobile -->
    @include('frontend.exhibitions.tickets.partials.visitor-sidebar-shell')

    <!-- Main Content Area -->
    <main class="flex min-h-0 flex-1 flex-col bg-white lg:h-screen lg:overflow-hidden">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-40 w-full relative">@include('frontend.exhibitions.tickets.header', ['hideMobileMenu' => !($showVisitorSidebar ?? false)])</div>

        <!-- Scrollable Content -->
        <div class="ticket-flow-main flex-1 overflow-y-auto px-4 py-6 sm:px-8 lg:px-12 lg:py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Header Section with Stepper -->
            <div class="mb-8 flex flex-col gap-6 border-b border-gray-100 pb-6 sm:pb-8 lg:flex-row lg:items-center lg:justify-between">
                <!-- Left: Event Info -->
                <div class="flex min-w-0 gap-4 sm:gap-5">
                    <div class="ticket-flow-hero-img h-[72px] w-[72px] shrink-0 rounded-2xl border border-gray-100 bg-cover bg-center shadow-sm sm:h-[100px] sm:w-[100px]" style="background-image: url('{{ $bannerImage }}');"></div>
                    <div class="flex min-w-0 flex-col justify-center">
                        <h1 class="mb-2 text-lg font-bold tracking-tight text-[#1E1B4B] sm:text-[22px]">{{ $title }}</h1>
                        
                        <div class="mb-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-[12px] font-medium text-[#475569] sm:text-[13px]">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar-blank text-[16px]"></i>
                                <span>{{ $dateStr }}</span>
                            </div>
                            <span class="hidden h-1 w-1 rounded-full bg-gray-300 sm:inline"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-clock text-[16px]"></i>
                                <span>{{ $timeStr }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-[12px] font-medium text-[#475569] sm:text-[13px]">
                            <i class="ph ph-map-pin shrink-0 text-[16px]"></i>
                            <span class="break-words">{{ $location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Stepper -->
                @include('frontend.exhibitions.tickets.partials.visitor-flow-stepper', ['currentStep' => 2])
            </div>

            <!-- Content Area (Form + Summary) -->
            <div class="ticket-flow-two-col flex flex-col gap-6 lg:flex-row lg:gap-8">
                
                <!-- Left: Main Form Area -->
                <div class="min-w-0 flex-1">
                    @include('frontend.exhibitions.tickets.partials.pass-tier-cards', ['tiers' => $tiers])

                    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Visitor Details</h2>
                            <p class="text-[14px] text-gray-500 font-medium">Please enter your details to continue.</p>
                        </div>
                        <div class="text-[12px] text-gray-500 font-medium sm:text-[13px]">
                            All fields marked with <span class="required">*</span> are required
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 md:grid-cols-3">
                        <!-- Row 0: Exhibition & Pavilion Selection -->
                        <div class="md:col-span-2">
                            <label class="form-label">Selected Exhibition</label>
                            <input type="text" id="selected_exhibition_display" class="form-input bg-gray-50 text-gray-500 font-medium" disabled value="{{ $title }}">
                        </div>
                        <div>
                            <label class="form-label">Select Pavilion <span class="required">*</span></label>
                            <div class="relative">
                                <select id="pavilion_id" class="form-input appearance-none bg-white font-medium">
                                    <option value="">-- Select Pavilion --</option>
                                    @forelse ($pavilions as $pavilion)
                                        <option value="{{ $pavilion->id }}">{{ $pavilion->title }}</option>
                                    @empty
                                        <option value="" disabled>No pavilions available for this exhibition</option>
                                    @endforelse
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Row 1 -->
                        <div>
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" class="form-input" value="{{ old('first_name') }}">
                        </div>
                        <div>
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" class="form-input" value="{{ old('last_name') }}">
                        </div>
                        <div>
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" class="form-input" value="{{ old('email') }}">
                        </div>

                        <!-- Row 2 -->
                        <div>
                            <label class="form-label">Mobile Number <span class="required">*</span></label>
                            <div class="flex w-full min-w-0 overflow-hidden rounded-lg border border-[#E2E8F0] transition-colors focus-within:border-primary-500">
                                <button type="button" class="flex shrink-0 items-center gap-1.5 border-r border-[#E2E8F0] bg-gray-50 px-2.5 text-[13px] font-medium sm:px-3 sm:text-[14px]">
                                    <span>🇮🇳</span>
                                    <span>+91</span>
                                    <i class="ph ph-caret-down ml-1 text-xs text-gray-400"></i>
                                </button>
                                <input type="text" id="mobile" class="min-w-0 flex-1 px-3 py-2 text-[14px] outline-none" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Job Title <span class="required">*</span></label>
                            <input type="text" id="job_title" class="form-input" value="">
                        </div>
                        <div>
                            <label class="form-label">Company / Organization <span class="required">*</span></label>
                            <input type="text" id="company" class="form-input" value="">
                        </div>

                        <!-- Row 3 -->
                        <div>
                            <label class="form-label">Country <span class="required">*</span></label>
                            <div class="relative">
                                <select id="country" class="form-input appearance-none bg-white">
                                    <option value="" disabled {{ old('country') ? '' : 'selected' }}>-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}" @selected(old('country', $defaultCountry) === $country)>{{ $country }}</option>
                                    @endforeach
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">State <span class="required">*</span></label>
                            <div class="relative">
                                <select id="state" class="form-input appearance-none bg-white">
                                    <option value="" disabled {{ old('state') ? '' : 'selected' }}>-- Select State --</option>
                                    @forelse ($states as $state)
                                        <option value="{{ $state }}" @selected(old('state') === $state)>{{ $state }}</option>
                                    @empty
                                        <option value="Not Applicable">Not Applicable</option>
                                    @endforelse
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">City <span class="required">*</span></label>
                            <div class="relative">
                                <select id="city" class="form-input appearance-none bg-white">
                                    <option value="" disabled {{ old('city') ? '' : 'selected' }}>-- Select City --</option>
                                    @forelse ($cities as $city)
                                        <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                                    @empty
                                        <option value="Other">Other</option>
                                    @endforelse
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4 (2 columns) -->
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
                        <div>
                            <label class="form-label">Industry <span class="required">*</span></label>
                            <div class="relative">
                                <select id="industry" class="form-input appearance-none bg-white">
                                    <option value="" disabled {{ old('industry') ? '' : 'selected' }}>-- Select Industry --</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry }}" @selected(old('industry') === $industry)>{{ $industry }}</option>
                                    @endforeach
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Company Size <span class="required">*</span></label>
                            <div class="relative">
                                <select id="company_size" class="form-input appearance-none bg-white">
                                    <option value="" disabled {{ old('company_size') ? '' : 'selected' }}>-- Select Company Size --</option>
                                    @foreach ($companySizes as $size)
                                        <option value="{{ $size }}" @selected(old('company_size') === $size)>{{ $size }}</option>
                                    @endforeach
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5 (Full width) -->
                    <div class="mb-6">
                        <label class="form-label">Business Address <span class="required">*</span></label>
                        <input type="text" id="business_address" class="form-input" value="">
                    </div>

                    <!-- Checkbox -->
                    <div class="mb-10 mt-2 flex cursor-pointer select-none items-start gap-3" id="checkbox-updates-wrapper">
                        <div id="checkbox-updates" class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded border border-primary-500 bg-primary-500 text-white shadow-sm transition-colors">
                            <i id="checkbox-check-icon" class="ph-bold ph-check text-[14px]"></i>
                        </div>
                        <span class="text-[13px] font-medium leading-relaxed text-[#1E293B] sm:text-[14px]">Receive updates about this event and future events from eproexpo and partners.</span>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="flex flex-col-reverse gap-3 pb-10 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('exhibitions.tickets.visitor-details', $slug) }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-gray-200 px-6 py-3 text-[15px] font-bold text-gray-600 shadow-sm transition-colors hover:bg-gray-50 sm:w-auto">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                        <a id="continue-to-payment-btn" href="{{ route('exhibitions.tickets.payment', $slug) }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary-600 px-8 py-3 text-[15px] font-bold text-white shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all hover:bg-primary-700 sm:w-auto">
                            Continue to Payment <i class="ph ph-arrow-right text-lg"></i>
                        </a>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="ticket-flow-sidebar w-full shrink-0 lg:w-[340px]">
                    <div class="rounded-2xl border border-gray-100 bg-[#FAFAFA] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] sm:p-6 lg:sticky lg:top-0">
                        
                        <!-- Your Selection -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-[#1E1B4B] text-[15px]">Your Selection</h3>
                                <a href="#pass-selection-section" class="text-[13px] font-bold text-primary-600 hover:underline">Edit</a>
                            </div>
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3">
                                    <i class="ph-fill ph-check-circle text-primary-500 text-[22px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[14px] mb-1" id="visitor-pass-name">Free Visitor Pass</div>
                                        <div class="text-[12px] text-gray-500 font-medium">Quantity</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-[#1E1B4B] text-[16px] mb-1" id="visitor-pass-price">₹0</div>
                                    <div class="font-bold text-[#1E293B] text-[14px]" id="visitor-pass-qty">1</div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-px bg-gray-200 w-full mb-6"></div>

                        <!-- Event Details -->
                        <div class="mb-6">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Event Details</h3>
                            <div class="flex gap-4">
                                <div id="summary-exh-image" class="w-14 h-14 rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('{{ $bannerImage }}');"></div>
                                <div class="flex flex-col">
                                    <div id="summary-exh-name" class="font-bold text-[#1E293B] text-[13px] mb-1.5 leading-tight">{{ $title }}</div>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[11px] mb-1 font-medium">
                                        <i class="ph ph-calendar-blank text-[13px]"></i>
                                        <span id="summary-exh-dates">{{ $dateStr }}</span>
                                    </div>
                                    <div class="flex items-start gap-1.5 text-gray-500 text-[11px] font-medium leading-snug">
                                        <i class="ph ph-map-pin text-[13px] mt-0.5"></i>
                                        <span id="summary-exh-venue">{{ $location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-px bg-gray-200 w-full mb-6"></div>

                        <!-- Order Summary -->
                        <div>
                            <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Order Summary</h3>
                            <div class="space-y-3 mb-5">
                                <div class="flex items-center justify-between text-[13px]">
                                    <span class="text-gray-500 font-medium">Total Passes</span>
                                    <span class="font-bold text-[#1E293B]" id="visitor-total-qty">1</span>
                                </div>
                                <div class="flex items-center justify-between text-[13px]">
                                    <span class="text-gray-500 font-medium">Subtotal</span>
                                    <span class="font-bold text-[#1E293B]" id="visitor-subtotal">₹0</span>
                                </div>
                                <div id="visitor-discount-row" class="hidden flex items-center justify-between text-[13px] text-green-600">
                                    <span id="visitor-discount-label" class="font-medium">Discount</span>
                                    <span class="font-bold" id="visitor-discount-amount">-₹0</span>
                                </div>
                            </div>
                            
                            <!-- Total Amount -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="font-bold text-[#1E1B4B] text-[15px]">Total Amount</span>
                                <span class="font-bold text-primary-600 text-[24px]" id="visitor-total">₹0</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>

    <script src="/exhibition-api.js"></script>
    <script src="/script.js"></script>
    <script>
        function refreshSelectionSidebar() {
            const passName = localStorage.getItem('selectedPassName') || 'Free Visitor Pass';
            const passPrice = parseFloat(localStorage.getItem('selectedPassPrice')) || 0;
            const passQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 1;
            const passSubtotal = parseFloat(localStorage.getItem('selectedPassSubtotal')) || (passPrice * passQty);
            const passDiscount = parseFloat(localStorage.getItem('selectedPassDiscount')) || 0;
            const passTotalAmount = parseFloat(localStorage.getItem('selectedPassTotalAmount')) || (passSubtotal - passDiscount);
            const appliedPromoCode = localStorage.getItem('selectedPassPromoCode') || '';

            const nameElem = document.getElementById('visitor-pass-name');
            if (nameElem) nameElem.innerText = passName;

            const priceElem = document.getElementById('visitor-pass-price');
            if (priceElem) priceElem.innerText = '₹' + passPrice.toLocaleString('en-IN');

            const subtotalElem = document.getElementById('visitor-subtotal');
            if (subtotalElem) subtotalElem.innerText = '₹' + passSubtotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const totalElem = document.getElementById('visitor-total');
            if (totalElem) totalElem.innerText = '₹' + passTotalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const qtyElem = document.getElementById('visitor-pass-qty');
            if (qtyElem) qtyElem.innerText = passQty;

            const totalQtyElem = document.getElementById('visitor-total-qty');
            if (totalQtyElem) totalQtyElem.innerText = passQty;

            const discountRow = document.getElementById('visitor-discount-row');
            const discountLabel = document.getElementById('visitor-discount-label');
            const discountAmountElem = document.getElementById('visitor-discount-amount');

            if (discountRow && passDiscount > 0) {
                discountRow.classList.remove('hidden');
                if (discountLabel) discountLabel.innerText = `Discount (${appliedPromoCode})`;
                if (discountAmountElem) discountAmountElem.innerText = `-₹` + passDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            } else if (discountRow) {
                discountRow.classList.add('hidden');
            }
        }

        function initializePassSelection() {
            const cardContainers = document.querySelectorAll('#pass-cards-container > div[data-tier-id]');
            if (!cardContainers.length) {
                return;
            }

            let selectedQuantity = 1;

            function updateUIAndStorage(activeCard, quantity) {
                let name = '';
                let basePrice = 0;
                let priceNum = 0;

                cardContainers.forEach((card) => {
                    const isCardActive = card === activeCard && quantity > 0;

                    if (isCardActive) {
                        card.className = 'relative flex flex-1 flex-col overflow-hidden rounded-xl border border-[1.5px] border-primary-500 transition-all duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-md';
                        if (!card.querySelector('.bg-primary-50.z-0')) {
                            card.insertAdjacentHTML('afterbegin', '<div class="absolute bottom-0 left-0 right-0 z-0 h-[64px] bg-primary-50"></div>');
                        }
                    } else {
                        card.className = 'relative flex flex-1 flex-col overflow-hidden rounded-xl border border-gray-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-md';
                        card.querySelector('.bg-primary-50.z-0')?.remove();
                    }

                    const icon = card.querySelector('.p-5 i:first-child, .relative.z-10.flex i:first-child');
                    if (icon) {
                        icon.className = isCardActive ? 'ph-fill ph-check-circle text-primary-500 text-[20px]' : 'ph ph-circle text-gray-300 text-[20px]';
                    }

                    const qtyElem = card.querySelector('.qty-span');
                    if (qtyElem) qtyElem.innerText = isCardActive ? quantity : '0';

                    const minusBtn = card.querySelector('.btn-minus');
                    if (minusBtn) {
                        minusBtn.className = isCardActive
                            ? 'btn-minus flex h-7 w-7 items-center justify-center rounded border border-gray-200 text-primary-500 transition-colors hover:bg-gray-50'
                            : 'btn-minus flex h-7 w-7 items-center justify-center rounded border border-gray-200 text-gray-400 transition-colors hover:bg-gray-50';
                    }

                    if (isCardActive) {
                        const nameElem = card.querySelector('h3');
                        name = nameElem ? nameElem.innerText : '';
                        basePrice = parseFloat(card.getAttribute('data-tier-price')) || 0;
                        selectedQuantity = quantity;
                        priceNum = basePrice * quantity;
                    }
                });

                if (quantity === 0) {
                    name = '';
                    basePrice = 0;
                    selectedQuantity = 0;
                    priceNum = 0;
                }

                localStorage.setItem('selectedPassName', name);
                localStorage.setItem('selectedPassPrice', basePrice);
                localStorage.setItem('selectedPassSubtotal', priceNum);
                localStorage.setItem('selectedPassDiscount', 0);
                localStorage.setItem('selectedPassPromoCode', '');
                localStorage.setItem('selectedPassQuantity', quantity);
                localStorage.setItem('selectedPassTotalAmount', priceNum);
                localStorage.setItem('selectedPassFormattedPrice', '₹' + priceNum.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                refreshSelectionSidebar();
            }

            const savedPassName = localStorage.getItem('selectedPassName');
            const savedPassQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 1;
            let activeCard = cardContainers[0];
            let activeQty = 1;

            if (savedPassName) {
                cardContainers.forEach((card) => {
                    const nameElem = card.querySelector('h3');
                    if (nameElem && nameElem.innerText.trim() === savedPassName.trim()) {
                        activeCard = card;
                        activeQty = savedPassQty;
                    }
                });
            }

            updateUIAndStorage(activeCard, activeQty);

            cardContainers.forEach((card) => {
                card.style.cursor = 'pointer';
                const minusBtn = card.querySelector('.btn-minus');
                const plusBtn = card.querySelector('.btn-plus');

                minusBtn?.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const currentQty = parseInt(card.querySelector('.qty-span')?.innerText) || 0;
                    if (currentQty > 0) {
                        updateUIAndStorage(card, currentQty - 1);
                    }
                });

                plusBtn?.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const currentQty = parseInt(card.querySelector('.qty-span')?.innerText) || 0;
                    updateUIAndStorage(card, currentQty + 1);
                });

                card.addEventListener('click', () => {
                    const currentQty = parseInt(card.querySelector('.qty-span')?.innerText) || 0;
                    if (currentQty === 0) {
                        updateUIAndStorage(card, 1);
                    }
                });
            });
        }

        async function initializeDetailsPage() {
            const exhId = '{{ $exhibition->id }}';
            localStorage.setItem('activeExhibitionId', exhId);
            localStorage.setItem('activeExhibitionSlug', '{{ $slug }}');
            localStorage.setItem('activeExhibitionName', @json($title));

            initializePassSelection();

            const urlParams = new URLSearchParams(window.location.search);
            const activePav = urlParams.get('pavilion_id') || localStorage.getItem('activePavilionId');
            const pavSelect = document.getElementById('pavilion_id');
            if (activePav && pavSelect) {
                pavSelect.value = activePav;
            }

            refreshSelectionSidebar();

            const fields = ['first_name', 'last_name', 'email', 'mobile', 'job_title', 'company', 'country', 'state', 'city', 'industry', 'company_size', 'business_address', 'pavilion_id'];
            const loggedInUser = {
                name: @json(auth()->user()->name ?? ''),
                email: @json(auth()->user()->email ?? ''),
                phone: @json(auth()->user()->phone ?? ''),
                city: @json(auth()->user()->city ?? ''),
            };
            const nameParts = loggedInUser.name ? loggedInUser.name.trim().split(/\s+/) : [];
            const defaultFirstName = nameParts[0] || '';
            const defaultLastName = nameParts.slice(1).join(' ') || '';

            fields.forEach((field) => {
                const savedVal = localStorage.getItem(`visitor_reg_${field}`);
                const el = document.getElementById(field);
                if (!el) return;

                if (savedVal && !el.value) {
                    el.value = savedVal;
                    return;
                }

                if (field === 'first_name' && !el.value && defaultFirstName) el.value = defaultFirstName;
                if (field === 'last_name' && !el.value && defaultLastName) el.value = defaultLastName;
                if (field === 'email' && !el.value && loggedInUser.email) el.value = loggedInUser.email;
                if (field === 'mobile' && !el.value && loggedInUser.phone) el.value = loggedInUser.phone;
                if (field === 'city' && !el.value && loggedInUser.city) el.value = loggedInUser.city;
            });

            let receiveUpdates = localStorage.getItem('visitor_reg_receive_updates') !== 'false';
            const cbWrapper = document.getElementById('checkbox-updates-wrapper');
            const cbBox = document.getElementById('checkbox-updates');
            const cbIcon = document.getElementById('checkbox-check-icon');

            function updateCheckboxUI() {
                if (!cbBox || !cbIcon) return;
                if (receiveUpdates) {
                    cbBox.className = 'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded border border-primary-500 bg-primary-500 text-white shadow-sm transition-colors';
                    cbIcon.classList.remove('hidden');
                } else {
                    cbBox.className = 'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded border border-gray-300 bg-white text-transparent shadow-sm transition-colors';
                    cbIcon.classList.add('hidden');
                }
            }

            if (cbWrapper && cbBox && cbIcon) {
                updateCheckboxUI();
                cbWrapper.addEventListener('click', () => {
                    receiveUpdates = !receiveUpdates;
                    localStorage.setItem('visitor_reg_receive_updates', receiveUpdates ? 'true' : 'false');
                    updateCheckboxUI();
                });
            }

            const continueBtn = document.getElementById('continue-to-payment-btn');
            if (continueBtn) {
                continueBtn.addEventListener('click', (event) => {
                    const passName = localStorage.getItem('selectedPassName');
                    const passQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 0;

                    if (!passName || passQty < 1) {
                        event.preventDefault();
                        alert('Please select a visitor pass to continue.');
                        document.getElementById('pass-selection-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        return;
                    }

                    let valid = true;
                    fields.forEach((field) => {
                        const el = document.getElementById(field);
                        if (el) {
                            if (!el.value.trim()) {
                                el.style.borderColor = '#EF4444';
                                valid = false;
                            } else {
                                el.style.borderColor = '#E2E8F0';
                                localStorage.setItem(`visitor_reg_${field}`, el.value.trim());
                            }
                        }
                    });

                    if (!valid) {
                        event.preventDefault();
                        alert('Please fill out all required fields.');
                    } else {
                        localStorage.setItem('visitor_reg_receive_updates', receiveUpdates ? 'true' : 'false');
                    }
                });
            }
        }

        if (document.readyState !== 'loading') {
            initializeDetailsPage();
        } else {
            document.addEventListener('DOMContentLoaded', initializeDetailsPage);
        }
    </script>
    <script>
        (() => {
            const sidebar = document.getElementById('exhibition-sidebar');
            const overlay = document.getElementById('exhibition-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-sidebar-close]');

            const openSidebar = () => {
                sidebar?.classList.remove('-translate-x-full');
                overlay?.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar?.classList.add('-translate-x-full');
                overlay?.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openButtons.forEach((button) => button.addEventListener('click', openSidebar));
            closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    overlay?.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        })();
    </script>
</body>
</html>
