@php
    $title = $title ?? 'Exhibition';
    $bannerImage = $bannerImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $dateStr = $dateStr ?? 'Date TBD';
    $location = $location ?? 'Virtual';
    $timeStr = $timeStr ?? 'Time TBD';
    $pavilions = $pavilions ?? collect();
    $pavilionMap = $pavilionMap ?? collect();
    $ticketTiers = $ticketTiers ?? collect();
    $showVisitorSidebar = $showVisitorSidebar ?? false;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Review & Confirm - EproExpo</title>
    <script>
        // Check if all visitor details and pass selection are filled before showing page content
        (function() {
            const passName = localStorage.getItem('selectedPassName');
            if (!passName) {
                alert('Please select a pass first.');
                window.location.href = "{{ route('exhibitions.tickets.pass-details', $slug) }}";
                return;
            }
            const fields = ['first_name', 'last_name', 'email', 'mobile', 'job_title', 'company', 'country', 'state', 'city', 'industry', 'company_size', 'business_address', 'pavilion_id'];
            let allFilled = true;
            for (const field of fields) {
                const val = localStorage.getItem('visitor_reg_' + field);
                if (!val || !val.trim()) {
                    allFilled = false;
                    break;
                }
            }
            if (!allFilled) {
                alert('Please fill out all visitor details first.');
                window.location.href = "{{ route('exhibitions.tickets.pass-details', $slug) }}";
            }
        })();
    </script>
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
                <div class="flex w-full min-w-0 flex-col overflow-hidden lg:w-auto lg:pl-8">
                    <p class="mb-3 text-[13px] font-bold text-primary-600 sm:hidden">Step 3 of 4 · Review & Confirm</p>
                    <h2 class="mb-4 hidden text-[16px] font-bold text-[#1E1B4B] sm:mb-5 sm:block">Visitor Pass Selection</h2>
                    <div class="ticket-flow-stepper no-scrollbar flex w-full min-w-0 items-center overflow-x-auto">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[16px] mb-2 shadow-sm">
                                <i class="ph-fill ph-check font-bold"></i>
                            </div>
                            <span class="text-[12px] font-medium text-[#1E1B4B] text-center leading-tight">Select Pass</span>
                        </div>
                        <!-- Line 1 (Completed) -->
                        <div class="flex-1 h-[2px] bg-primary-500 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[16px] mb-2 shadow-sm">
                                <i class="ph-fill ph-check font-bold"></i>
                            </div>
                            <span class="text-[12px] font-medium text-[#1E1B4B] text-center leading-tight">Visitor Details</span>
                        </div>
                        <!-- Line 2 (Completed) -->
                        <div class="flex-1 h-[2px] bg-primary-500 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 3 (Active) -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[12px] font-bold mb-2 shadow-sm">3</div>
                            <span class="text-[12px] font-bold text-primary-600 text-center leading-tight">Review & Confirm</span>
                        </div>
                        <!-- Line 3 -->
                        <div class="flex-1 h-[2px] bg-gray-200 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[12px] font-bold mb-2">4</div>
                            <span class="text-[12px] font-medium text-gray-500 text-center leading-tight">Payment</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="ticket-flow-two-col flex flex-col gap-6 lg:flex-row lg:gap-8">
                
                <!-- Left: Review Info -->
                <div class="min-w-0 flex-1">
                    <div class="mb-6">
                        <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Review & Confirm</h2>
                        <p class="text-[14px] text-gray-500 font-medium">Please review your details and confirm your order.</p>
                    </div>

                    <!-- 1. Selected Pass -->
                    <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-4 flex items-center justify-between border-b border-gray-50 pb-4">
                            <h3 class="text-[15px] font-bold text-[#1E1B4B]">1. Selected Pass</h3>
                            <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="flex items-center gap-1.5 text-[13px] font-bold text-primary-600 hover:underline">
                                <i class="ph ph-pencil-simple text-[15px]"></i> Edit
                            </a>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex min-w-0 items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-600">
                                    <i class="ph ph-identification-badge text-[24px]"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="mb-1 text-[15px] font-bold text-[#1E293B]" id="visitor-pass-name">Free Visitor Pass</div>
                                    <div class="text-[13px] text-[#475569]" id="visitor-pass-description">Access to exhibition & booths</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-4 sm:block sm:text-right">
                                <div class="text-[20px] font-bold text-[#1E1B4B]" id="visitor-pass-price">₹0</div>
                                <div class="inline-block rounded-full bg-primary-50 px-3 py-1 text-[12px] font-medium text-primary-600" id="visitor-pass-qty-pill">Quantity: 1</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Visitor Details -->
                    <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5 flex items-center justify-between border-b border-gray-50 pb-4">
                            <h3 class="text-[15px] font-bold text-[#1E1B4B]">2. Visitor Details</h3>
                            <a href="{{ route('exhibitions.tickets.pass-details', $slug) }}?edit=true" class="flex items-center gap-1.5 text-[13px] font-bold text-primary-600 hover:underline">
                                <i class="ph ph-pencil-simple text-[15px]"></i> Edit
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-2 md:grid-cols-3">
                            <!-- Col 1 -->
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Name</div>
                                <div id="display-name" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Selected Pavilion</div>
                                <div id="display-pavilion" class="text-[14px] text-primary-600 font-bold">-</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Email Address</div>
                                <div id="display-email" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                            <div>
                                <div class="mb-1 text-[12px] font-medium text-gray-500">Business Address</div>
                                <div id="display-address" class="max-w-none text-[14px] font-medium leading-relaxed text-[#1E293B] sm:max-w-[240px]">-</div>
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Mobile Number</div>
                                <div id="display-mobile" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                            <div>
                                <div class="mb-1 text-[12px] font-medium text-gray-500">Company / Organization</div>
                                <div id="display-company" class="text-[14px] font-medium text-[#1E293B]">-</div>
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Job Title</div>
                                <div id="display-job-title" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Company Size</div>
                                <div id="display-company-size" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                            <div>
                                <div class="mb-1 text-[12px] font-medium text-gray-500">City, State, Country</div>
                                <div id="display-csc" class="text-[14px] font-medium text-[#1E293B]">-</div>
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Industry</div>
                                <div id="display-industry" class="text-[14px] text-[#1E293B] font-medium">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Additional Information -->
                    <div class="mb-10 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-4 pb-2">
                            <h3 class="text-[15px] font-bold text-[#1E1B4B]">3. Additional Information</h3>
                        </div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex min-w-0 items-center gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-600">
                                    <i class="ph ph-envelope-simple text-[20px]"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="mb-0.5 text-[13px] font-bold text-[#1E293B]" id="subscription-title">Updates & Notifications</div>
                                    <div class="max-w-none text-[13px] leading-relaxed text-[#64748B] sm:max-w-[400px]" id="subscription-description">Checking your notification preference...</div>
                                </div>
                            </div>
                            <div id="subscription-status-badge" class="flex w-fit items-center gap-1.5 rounded-full border px-3 py-1.5 text-[12px] font-bold">
                                <i id="subscription-status-icon" class="ph-bold"></i> <span id="subscription-status-text"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="pb-10">
                        <a href="{{ route('exhibitions.tickets.pass-details', $slug) }}?edit=true" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-200 px-6 py-3 text-[14px] font-bold text-gray-600 shadow-sm transition-colors hover:bg-gray-50 sm:w-auto">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="ticket-flow-sidebar flex w-full shrink-0 flex-col gap-5 lg:w-[340px]">
                    
                    <!-- Order Summary Box -->
                    <div class="rounded-2xl border border-gray-100 bg-[#FAFAFA] p-5 shadow-sm sm:p-6 lg:sticky lg:top-0">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Order Summary</h3>
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between text-[14px]">
                                <span class="text-[#475569] font-medium">Total Passes</span>
                                <span class="font-bold text-[#1E293B]" id="visitor-total-passes">1</span>
                            </div>
                            <div class="flex items-center justify-between text-[14px]">
                                <span class="text-[#475569] font-medium">Subtotal</span>
                                <span class="font-bold text-[#1E293B]" id="visitor-subtotal">₹0</span>
                            </div>
                            <div id="visitor-discount-row" class="hidden flex items-center justify-between text-[14px] text-green-600">
                                <span id="visitor-discount-label" class="font-medium">Discount</span>
                                <span class="font-bold" id="visitor-discount-amount">-₹0</span>
                            </div>
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="flex items-center justify-between pt-5 border-t border-gray-200 mb-6">
                            <span class="font-bold text-[#1E1B4B] text-[15px]">Total Amount</span>
                            <span class="font-bold text-primary-600 text-[26px]" id="visitor-total">₹0</span>
                        </div>
                        
                        <!-- Secure Payments Alert -->
                        <div class="bg-green-50 rounded-xl p-4 flex gap-3 border border-green-100">
                            <i class="ph-fill ph-shield-check text-green-500 text-[22px]"></i>
                            <div>
                                <div class="font-bold text-green-700 text-[13px] mb-0.5">100% Secure Payments</div>
                                <div class="text-green-600 text-[12px] leading-tight">Your payment information is encrypted and secure.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Event Details</h3>
                        <div class="flex gap-4">
                            <div id="summary-exh-image" class="w-[70px] h-[70px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('{{ $bannerImage }}');"></div>
                            <div class="flex flex-col">
                                <div id="summary-exh-name" class="font-bold text-[#1E293B] text-[13px] mb-1.5 leading-tight">{{ $title }}</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-calendar-blank text-[14px]"></i>
                                    <span id="summary-exh-dates">{{ $dateStr }}</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-snug">
                                    <i class="ph ph-map-pin text-[14px] mt-0.5"></i>
                                    <span id="summary-exh-venue">{{ $location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proceed to Payment Button -->
                    <div class="flex flex-col items-center mt-2">
                        <a id="payment-btn" href="{{ route('exhibitions.tickets.payment', $slug) }}" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] mb-3">
                            Proceed to Payment <i class="ph ph-arrow-right text-[18px]"></i>
                        </a>
                        <div class="flex items-center gap-1.5 text-gray-500 text-[12px] font-medium">
                            <i class="ph ph-lock text-[14px]"></i>
                            <span>Secure checkout</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script src="/exhibition-api.js"></script>
    <script src="/script.js"></script>
    <script>
        async function initializeReviewPage() {
            const ticketTiers = @json($ticketTiers);
            const pavilionMap = @json($pavilionMap);

            localStorage.setItem('activeExhibitionId', '{{ $exhibition->id }}');
            localStorage.setItem('activeExhibitionSlug', '{{ $slug }}');
            localStorage.setItem('activeExhibitionName', @json($title));

            // Populate Selection Summary
            const passName = localStorage.getItem('selectedPassName') || 'Free Visitor Pass';
            const matchedTier = ticketTiers.find((tier) => tier.name === passName);
            
            const rawPrice = parseFloat(localStorage.getItem('selectedPassPrice'));
            const passPriceNum = isNaN(rawPrice) ? 0 : rawPrice;
            
            const rawQty = parseInt(localStorage.getItem('selectedPassQuantity'));
            const passQty = isNaN(rawQty) ? 1 : rawQty;
            
            const rawSubtotal = parseFloat(localStorage.getItem('selectedPassSubtotal'));
            const passSubtotal = isNaN(rawSubtotal) ? (passPriceNum * passQty) : rawSubtotal;
            
            const rawDiscount = parseFloat(localStorage.getItem('selectedPassDiscount'));
            const passDiscount = isNaN(rawDiscount) ? 0 : rawDiscount;
            
            const rawTotal = parseFloat(localStorage.getItem('selectedPassTotalAmount'));
            const passTotalAmount = isNaN(rawTotal) ? (passSubtotal - passDiscount) : rawTotal;
            
            const appliedPromoCode = localStorage.getItem('selectedPassPromoCode') || '';

            const formatINR = (num) => {
                const parsed = parseFloat(num);
                const val = isNaN(parsed) ? 0 : parsed;
                return '₹' + val.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            };
            
            const nameElem = document.getElementById('visitor-pass-name');
            if (nameElem) nameElem.innerText = passName;

            const descElem = document.getElementById('visitor-pass-description');
            if (descElem) {
                descElem.innerText = matchedTier?.summary || (passPriceNum === 0 ? 'Access to exhibition & booths' : 'Enhanced access & features');
            }
            
            const priceElem = document.getElementById('visitor-pass-price');
            if (priceElem) priceElem.innerText = '₹' + passPriceNum.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            
            const subtotalElem = document.getElementById('visitor-subtotal');
            if (subtotalElem) subtotalElem.innerText = formatINR(passSubtotal);
            
            const totalElem = document.getElementById('visitor-total');
            if (totalElem) totalElem.innerText = formatINR(passTotalAmount);
            
            const qtyPill = document.getElementById('visitor-pass-qty-pill');
            if (qtyPill) qtyPill.innerText = 'Quantity: ' + passQty;
            
            const totalPasses = document.getElementById('visitor-total-passes');
            if (totalPasses) totalPasses.innerText = passQty;

            // Handle Discount Row
            const discountRow = document.getElementById('visitor-discount-row');
            const discountLabel = document.getElementById('visitor-discount-label');
            const discountAmount = document.getElementById('visitor-discount-amount');
            
            if (passDiscount > 0) {
                if (discountRow) {
                    discountRow.classList.remove('hidden');
                    if (discountLabel) {
                        discountLabel.innerText = appliedPromoCode ? `Discount (${appliedPromoCode})` : 'Discount';
                    }
                    if (discountAmount) {
                        discountAmount.innerText = '-₹' + passDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                }
            } else {
                if (discountRow) {
                    discountRow.classList.add('hidden');
                }
            }

            // Load values to display fields
            const displayMapping = {
                'display-name': () => {
                    const fn = localStorage.getItem('visitor_reg_first_name') || '';
                    const ln = localStorage.getItem('visitor_reg_last_name') || '';
                    return `${fn} ${ln}`.trim();
                },
                'display-pavilion': () => {
                    const id = localStorage.getItem('visitor_reg_pavilion_id');
                    return pavilionMap[id] || id || '-';
                },
                'display-email': () => localStorage.getItem('visitor_reg_email') || '',
                'display-mobile': () => {
                    const val = localStorage.getItem('visitor_reg_mobile');
                    return val ? '+91 ' + val : '';
                },
                'display-company': () => localStorage.getItem('visitor_reg_company') || '',
                'display-job-title': () => localStorage.getItem('visitor_reg_job_title') || '',
                'display-company-size': () => localStorage.getItem('visitor_reg_company_size') || '',
                'display-csc': () => {
                    const c = localStorage.getItem('visitor_reg_city');
                    const s = localStorage.getItem('visitor_reg_state');
                    const co = localStorage.getItem('visitor_reg_country');
                    if (c || s || co) {
                        return [c, s, co].filter(Boolean).join(', ');
                    }
                    return '';
                },
                'display-industry': () => localStorage.getItem('visitor_reg_industry') || '',
                'display-address': () => localStorage.getItem('visitor_reg_business_address') || ''
            };

            Object.entries(displayMapping).forEach(([id, getter]) => {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = getter() || '-';
                }
            });

            // Subscription Badge UI Sync
            const receiveUpdates = localStorage.getItem('visitor_reg_receive_updates') !== 'false';
            const subBadge = document.getElementById('subscription-status-badge');
            const subIcon = document.getElementById('subscription-status-icon');
            const subText = document.getElementById('subscription-status-text');
            const subTitle = document.getElementById('subscription-title');
            const subDescription = document.getElementById('subscription-description');
            if (subBadge && subIcon && subText) {
                if (receiveUpdates) {
                    subBadge.className = "flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-full font-bold text-[12px] border border-green-100";
                    subIcon.className = "ph-bold ph-check";
                    subText.textContent = "Subscribed";
                    if (subTitle) subTitle.textContent = "Updates & Notifications";
                    if (subDescription) subDescription.textContent = "You will receive updates about this event and future events from eproexpo and partners.";
                } else {
                    subBadge.className = "flex items-center gap-1.5 bg-gray-50 text-gray-500 px-3 py-1.5 rounded-full font-bold text-[12px] border border-gray-200";
                    subIcon.className = "ph-bold ph-x";
                    subText.textContent = "Not Subscribed";
                    if (subTitle) subTitle.textContent = "Updates & Notifications";
                    if (subDescription) subDescription.textContent = "You opted out of updates for this event and future event notifications.";
                }
            }
        }

        if (document.readyState !== 'loading') {
            initializeReviewPage();
        } else {
            document.addEventListener('DOMContentLoaded', initializeReviewPage);
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
