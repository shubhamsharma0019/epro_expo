@php
    $exhibition = \App\Domain\Event\Models\Exhibition::query()
        ->with([
            'boothBookings' => fn ($query) => $query
                ->with(['boothProfile', 'boothBranding', 'company'])
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->where('admin_status', 'approved')
                ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
        ])
        ->where('slug', $slug)
        ->first();
    if (!$exhibition) {
        $exhibition = \App\Domain\Event\Models\Exhibition::query()
            ->with([
                'boothBookings' => fn ($query) => $query
                    ->with(['boothProfile', 'boothBranding', 'company'])
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved')
                    ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
            ])
            ->find($slug);
    }
    if (!$exhibition) {
        abort(404);
    }

    $title = $exhibition->title ?: $exhibition->name;
    
    // Resolve banner image (prioritize booth setup banner or logo)
    $publishedBookings = ($exhibition->boothBookings ?? collect())->filter(fn ($booking) => 
        in_array($booking->booth_setup_status, ['published', 'approved', 'live'])
    );
    $firstBooking = $publishedBookings->first(fn ($booking) => $booking->boothBranding?->booth_banner)
        ?: $publishedBookings->first(fn ($booking) => $booking->boothProfile?->company_logo || $booking->company?->logo);
        
    $bannerImage = $exhibition->banner_url ?: ($exhibition->banner_image ?: 'images/exhibitions/hero-pavilion-scene.png');
    if ($firstBooking) {
        if ($firstBooking->boothBranding?->booth_banner) {
            $bannerPath = $firstBooking->boothBranding->booth_banner;
            $bannerImage = str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/' . $bannerPath;
        } elseif ($firstBooking->boothProfile?->company_logo) {
            $logoPath = $firstBooking->boothProfile->company_logo;
            $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        } elseif ($firstBooking->company?->logo) {
            $logoPath = $firstBooking->company->logo;
            $bannerImage = str_starts_with($logoPath, 'storage/') ? $logoPath : 'storage/' . $logoPath;
        }
    }

    if (str_starts_with($bannerImage, 'http://') || str_starts_with($bannerImage, 'https://')) {
        // Keep absolute URLs as is
    } elseif (str_starts_with($bannerImage, 'images/') || str_starts_with($bannerImage, 'assets/') || str_starts_with($bannerImage, 'storage/')) {
        $bannerImage = asset($bannerImage);
    } else {
        $bannerImage = asset('storage/' . $bannerImage);
    }
    
    // Resolve date string
    if ($exhibition->start_date && $exhibition->end_date) {
        $dateStr = $exhibition->start_date->format('M d') . ' – ' . $exhibition->end_date->format('d, Y');
    } else {
        $dateStr = 'Date TBD';
    }
    
    // Resolve location
    $location = $exhibition->venue ?: ($exhibition->location ?: 'Virtual');
    $firstAgendaSession = \App\Domain\Event\Models\AgendaSession::query()
        ->where('exhibition_id', $exhibition->id)
        ->orderBy('start_time')
        ->first();
    $timeStr = $firstAgendaSession?->start_time
        ? trim($firstAgendaSession->start_time . ($firstAgendaSession->end_time ? ' - ' . $firstAgendaSession->end_time : ''))
        : 'Time TBD';

    // Get Ticket Tiers
    $tiers = \App\Domain\Event\Models\TicketTier::where('exhibition_id', $exhibition->id)
        ->orderBy('price')
        ->orderBy('id')
        ->get()
        ->filter(fn ($tier) => filled($tier->name))
        ->values();

    if ($tiers->isEmpty()) {
        $tiers = collect([
            new \App\Domain\Event\Models\TicketTier(['id' => 1, 'name' => 'Free Visitor Pass', 'price' => 0.00, 'benefits' => 'Access to exhibition & booths, Standard sessions entry, Digital certificate']),
            new \App\Domain\Event\Models\TicketTier(['id' => 2, 'name' => 'Business Pass', 'price' => 999.00, 'benefits' => 'Access to all pavilions, B2B matchmaking lounges, Standard speaker sessions, Catalogue book']),
            new \App\Domain\Event\Models\TicketTier(['id' => 3, 'name' => 'VIP All-Access Pass', 'price' => 2499.00, 'benefits' => 'Priority check-in, VIP lounge access, Invite-only keynote, VIP networking dinner']),
        ]);
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Pass Selection</title>
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
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Overlay for mobile -->
    <div id="exhibition-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#071044]/40 lg:hidden"></div>

    <!-- Exhibition Sidebar -->
    @include('components.exhibition.exhibition-sidebar')

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-40 w-full relative">@include('frontend.exhibitions.tickets.header')</div>

        <!-- Scrollable Content -->
        <div class="ticket-flow-main flex-1 overflow-y-auto px-4 py-6 sm:px-8 lg:px-12 lg:py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Header Section with Stepper -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6">
                <!-- Left: Event Info -->
                <div class="flex gap-5">
                    <div class="w-[100px] h-[100px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('{{ $bannerImage }}');"></div>
                    <div class="flex flex-col justify-center">
                        <h1 id="exh-title-val" class="text-[22px] font-bold text-[#1E1B4B] tracking-tight mb-2">{{ $title }}</h1>
                        
                        <div class="flex items-center gap-4 text-[#475569] text-[13px] font-medium mb-2">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar-blank text-[16px]"></i>
                                <span id="exh-dates-val">{{ $dateStr }}</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-clock text-[16px]"></i>
                                <span>{{ $timeStr }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-[#475569] text-[13px] font-medium">
                            <i class="ph ph-map-pin text-[16px]"></i>
                            <span id="exh-venue-val">{{ $location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Stepper -->
                <div class="flex flex-col lg:pl-8 w-full lg:w-auto overflow-hidden">
                    <h2 class="text-[16px] font-bold text-[#1E1B4B] mb-5">Visitor Pass Selection</h2>
                    <div class="flex items-center ticket-flow-stepper no-scrollbar">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[12px] font-bold mb-2 shadow-sm">1</div>
                            <span class="text-[12px] font-bold text-primary-600 text-center leading-tight">Select Pass</span>
                        </div>
                        <!-- Line 1 -->
                        <div class="flex-1 h-px bg-gray-200 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[12px] font-bold mb-2">2</div>
                            <span class="text-[12px] font-medium text-gray-500 text-center leading-tight">Visitor Details</span>
                        </div>
                        <!-- Line 2 -->
                        <div class="flex-1 h-px bg-gray-200 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[12px] font-bold mb-2">3</div>
                            <span class="text-[12px] font-medium text-gray-500 text-center leading-tight">Review & Confirm</span>
                        </div>
                        <!-- Line 3 -->
                        <div class="flex-1 h-px bg-gray-200 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[12px] font-bold mb-2">4</div>
                            <span class="text-[12px] font-medium text-gray-500 text-center leading-tight">Payment</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-[16px] font-bold text-[#1E1B4B] mb-4">Choose the pass that suits you best.</h2>

            <!-- Cards Container -->
            <div id="pass-cards-container" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @forelse ($tiers as $index => $tier)
                    @php
                        $isActive = $index === 0;
                        $benefits = array_filter(array_map('trim', explode(',', $tier->benefits)));
                    @endphp
                    <div data-tier-id="{{ $tier->id }}" data-tier-price="{{ $tier->price }}" class="flex-1 border {{ $isActive ? 'border-[1.5px] border-primary-500' : 'border-gray-200 bg-white' }} rounded-xl overflow-hidden flex flex-col relative transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md duration-300">
                        @if ($isActive)
                            <div class="absolute bottom-0 left-0 right-0 h-[64px] bg-primary-50 z-0"></div>
                        @endif
                        
                        <div class="p-5 flex-1 flex flex-col relative z-10 bg-white border-b border-gray-50">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="{{ $isActive ? 'ph-fill ph-check-circle text-primary-500' : 'ph ph-circle text-gray-300' }} text-[20px]"></i>
                                <h3 class="font-bold text-[#1E293B] text-[15px]">{{ $tier->name }}</h3>
                            </div>
                            <div class="text-[20px] font-bold text-primary-600 mb-1">₹{{ number_format($tier->price, 2) }}</div>
                            <div class="text-[12px] text-gray-500 mb-5 border-b border-gray-100 pb-4">
                                {{ $tier->price == 0 ? 'Access to exhibition & booths' : 'Enhanced access & features' }}
                            </div>
                            
                            <div class="space-y-3 flex-1">
                                @foreach ($benefits as $benefit)
                                    <div class="flex items-start gap-2.5">
                                        <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                        <span class="text-[12px] text-[#475569] font-medium">{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="h-[64px] flex items-center justify-center relative z-10">
                            <div class="flex items-center gap-6 bg-white rounded-lg border border-gray-200 p-1 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center {{ $isActive ? 'text-primary-500' : 'text-gray-400' }} hover:bg-gray-50 transition-colors btn-minus">
                                    <i class="ph ph-minus text-[14px] font-bold"></i>
                                </button>
                                <span class="text-[15px] font-bold text-[#1E1B4B] qty-span">{{ $isActive ? '1' : '0' }}</span>
                                <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors btn-plus">
                                    <i class="ph ph-plus text-[14px] font-bold"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 rounded-xl border border-gray-100 bg-white p-8 text-center text-[14px] font-semibold text-[#64748B]">
                        No visitor passes are available for this exhibition yet.
                    </div>
                @endforelse
            </div>

            <!-- Bottom Section -->
            <div class="flex flex-col lg:flex-row gap-4 pb-10">
                <!-- Order Summary -->
                <div class="flex-1 border border-gray-100 rounded-xl p-6 shadow-sm bg-[#FAFAFA]">
                    <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-6">Order Summary</h3>
                    
                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                        <span class="text-[#475569] text-[14px] font-medium">Total Passes</span>
                        <span class="text-[#1E1B4B] text-[15px] font-bold" id="total-passes-summary">1</span>
                    </div>

                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                        <span class="text-[#475569] text-[14px] font-medium">Subtotal</span>
                        <span class="text-[#1E1B4B] text-[15px] font-bold" id="subtotal-amount-summary">₹0</span>
                    </div>

                    <div id="discount-row-summary" class="hidden flex items-center justify-between mb-4 border-b border-gray-200 pb-4 text-green-600">
                        <span class="text-[14px] font-semibold" id="discount-label-summary">Discount</span>
                        <span class="text-[15px] font-bold" id="discount-amount-summary">-₹0</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[#1E1B4B] text-[15px] font-bold">Total Amount</span>
                        <span class="text-[#1E1B4B] text-[20px] font-bold" id="total-amount-display">₹0</span>
                    </div>
                    
                    <div class="flex flex-col items-center">
                        <a id="continue-btn" href="{{ $tiers->isNotEmpty() ? route('exhibitions.tickets.visitor-details', $slug) : '#' }}" class="w-full inline-block text-center {{ $tiers->isNotEmpty() ? 'bg-primary-600 hover:bg-primary-700 text-white shadow-[0_4px_14px_rgba(90,50,250,0.25)]' : 'pointer-events-none bg-gray-200 text-gray-500' }} py-3.5 rounded-xl font-bold transition-all text-[14px] mb-3">
                            Continue to Attendee Details
                        </a>
                        <div class="flex items-center gap-1.5 text-gray-500 text-[12px]">
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
        document.addEventListener('DOMContentLoaded', () => {
            const cardContainers = document.querySelectorAll('#pass-cards-container > div[data-tier-id]');
            const totalAmountElem = document.getElementById('total-amount-display');
            const totalPassesElem = document.getElementById('total-passes-summary');
            const subtotalValElem = document.getElementById('subtotal-amount-summary');
            
            let selectedQuantity = 1;
            let basePrice = 0;
            let promoDiscountPercent = 0;
            let appliedPromoCode = '';

            const promoCodes = {
                'WELCOME50': 50,
                'SAVE10': 10,
                'DISCOUNT10': 10,
                'DISCOUNT50': 50,
                'PROMO100': 100,
                'FREE': 100
            };

            function updateUIAndStorage(activeCard, quantity) {
                let name = '';
                let priceNum = 0;
                let priceText = '₹0';
                
                cardContainers.forEach(c => {
                    const isCardActive = (c === activeCard && quantity > 0);
                    
                    if(isCardActive) {
                        c.className = "flex-1 border-[1.5px] border-primary-500 rounded-xl overflow-hidden flex flex-col relative transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md duration-300";
                        if(!c.querySelector('.bg-primary-50.z-0')) {
                            c.insertAdjacentHTML('afterbegin', '<div class="absolute bottom-0 left-0 right-0 h-[64px] bg-primary-50 z-0"></div>');
                        }
                    } else {
                        c.className = "flex-1 border border-gray-200 rounded-xl overflow-hidden flex flex-col bg-white transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md duration-300";
                        const bg = c.querySelector('.bg-primary-50.z-0');
                        if(bg) bg.remove();
                    }
                    
                    const icon = c.querySelector('.p-5 i:first-child');
                    if(icon) {
                        icon.className = isCardActive ? "ph-fill ph-check-circle text-primary-500 text-[20px]" : "ph ph-circle text-gray-300 text-[20px]";
                    }
                    
                    const qtyElem = c.querySelector('.qty-span');
                    if(qtyElem) qtyElem.innerText = isCardActive ? quantity : '0';
                    
                    const minusBtn = c.querySelector('.btn-minus');
                    if(minusBtn) {
                        minusBtn.className = isCardActive ? "w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors btn-minus" : "w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors btn-minus";
                    }
                    
                    if(isCardActive) {
                        const nameElem = c.querySelector('.p-5 h3');
                        name = nameElem ? nameElem.innerText : '';
                        basePrice = parseFloat(c.getAttribute('data-tier-price')) || 0;
                        selectedQuantity = quantity;
                        
                        priceNum = basePrice * quantity;
                        priceText = '₹' + priceNum.toLocaleString('en-IN');
                    }
                });

                if (quantity === 0) {
                    name = '';
                    basePrice = 0;
                    selectedQuantity = 0;
                    priceNum = 0;
                    priceText = '₹0';
                }
                
                if (subtotalValElem) subtotalValElem.innerText = '₹' + priceNum.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                if (totalPassesElem) totalPassesElem.innerText = quantity;

                // Calculate Discount
                let discountAmount = 0;
                if (promoDiscountPercent > 0 && priceNum > 0) {
                    discountAmount = (priceNum * promoDiscountPercent) / 100;
                }

                // Update Discount Row UI
                const discountRow = document.getElementById('discount-row-summary');
                const discountLabel = document.getElementById('discount-label-summary');
                const discountAmountElem = document.getElementById('discount-amount-summary');

                if (discountAmount > 0) {
                    if (discountRow) discountRow.classList.remove('hidden');
                    if (discountLabel) discountLabel.innerText = `Discount (${promoDiscountPercent}% via ${appliedPromoCode})`;
                    if (discountAmountElem) discountAmountElem.innerText = `-₹` + discountAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                } else {
                    if (discountRow) discountRow.classList.add('hidden');
                }

                // Calculate Final Total Amount
                const finalTotal = priceNum - discountAmount;
                if (totalAmountElem) totalAmountElem.innerText = '₹' + finalTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
                localStorage.setItem('selectedPassName', name);
                localStorage.setItem('selectedPassPrice', basePrice);
                localStorage.setItem('selectedPassSubtotal', priceNum);
                localStorage.setItem('selectedPassDiscount', discountAmount);
                localStorage.setItem('selectedPassPromoCode', appliedPromoCode);
                localStorage.setItem('selectedPassQuantity', quantity);
                localStorage.setItem('selectedPassTotalAmount', finalTotal);
                localStorage.setItem('selectedPassFormattedPrice', '₹' + finalTotal.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            }

            // Set initial state: try to restore saved pass, or fallback to first card
            if (cardContainers.length > 0) {
                const savedPassName = localStorage.getItem('selectedPassName');
                const savedPassQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 1;
                
                let activeCard = cardContainers[0];
                let activeQty = 1;
                
                if (savedPassName) {
                    let foundSavedCard = false;
                    cardContainers.forEach(card => {
                        const nameElem = card.querySelector('.p-5 h3');
                        if (nameElem && nameElem.innerText.trim() === savedPassName.trim()) {
                            activeCard = card;
                            activeQty = savedPassQty;
                            foundSavedCard = true;
                        }
                    });
                }
                
                updateUIAndStorage(activeCard, activeQty);
            }

            // Clear previous registration details when starting a new flow
            const continueBtn = document.getElementById('continue-btn');
            if (continueBtn) {
                continueBtn.addEventListener('click', () => {
                    const fieldsToClear = ['first_name', 'last_name', 'email', 'mobile', 'job_title', 'company', 'country', 'state', 'city', 'industry', 'company_size', 'business_address', 'pavilion_id'];
                    fieldsToClear.forEach(field => {
                        localStorage.removeItem(`visitor_reg_${field}`);
                    });
                });
            }

            // Promo Code listener
            const applyPromoBtn = document.getElementById('apply-promo-btn');
            const promoInput = document.getElementById('promo-code-input');
            const promoMsg = document.getElementById('promo-message');

            if (applyPromoBtn && promoInput && promoMsg) {
                applyPromoBtn.addEventListener('click', () => {
                    const enteredCode = promoInput.value.trim().toUpperCase();
                    if (!enteredCode) {
                        promoMsg.className = "text-[12px] font-semibold mt-1 text-red-500";
                        promoMsg.innerText = "Please enter a promo code.";
                        return;
                    }

                    if (promoCodes.hasOwnProperty(enteredCode)) {
                        promoDiscountPercent = promoCodes[enteredCode];
                        appliedPromoCode = enteredCode;
                        promoMsg.className = "text-[12px] font-semibold mt-1 text-green-600";
                        promoMsg.innerText = `Promo code "${enteredCode}" applied successfully! (${promoDiscountPercent}% Off)`;
                    } else {
                        promoDiscountPercent = 0;
                        appliedPromoCode = '';
                        promoMsg.className = "text-[12px] font-semibold mt-1 text-red-500";
                        promoMsg.innerText = "Invalid promo code.";
                    }

                    // Re-calculate with selected active card
                    let activeCard = null;
                    let qty = 0;
                    cardContainers.forEach(c => {
                        const q = parseInt(c.querySelector('.qty-span').innerText) || 0;
                        if (q > 0) {
                            activeCard = c;
                            qty = q;
                        }
                    });

                    // If no card is active but there are cards, default to first card with qty 1
                    if (!activeCard && cardContainers.length > 0) {
                        activeCard = cardContainers[0];
                        qty = 1;
                    }

                    updateUIAndStorage(activeCard, qty);
                });
            }

            cardContainers.forEach((card) => {
                card.style.cursor = 'pointer';
                const minusBtn = card.querySelector('.btn-minus');
                const plusBtn = card.querySelector('.btn-plus');
                
                if(minusBtn) {
                    minusBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const qtyElem = card.querySelector('.qty-span');
                        let currentQty = parseInt(qtyElem.innerText) || 0;
                        if(currentQty > 0) {
                            updateUIAndStorage(card, currentQty - 1);
                        }
                    });
                }
                
                if(plusBtn) {
                    plusBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const qtyElem = card.querySelector('.qty-span');
                        let currentQty = parseInt(qtyElem.innerText) || 0;
                        updateUIAndStorage(card, currentQty + 1);
                    });
                }

                card.addEventListener('click', () => {
                    const qtyElem = card.querySelector('.qty-span');
                    let currentQty = parseInt(qtyElem.innerText) || 0;
                    if(currentQty === 0) {
                        updateUIAndStorage(card, 1);
                    }
                });
            });
        });
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
