<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Pass Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="exhibition-details.html" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Header Section with Stepper -->
            <div class="flex items-start justify-between mb-8">
                <!-- Left: Event Info -->
                <div class="flex gap-5">
                    <div class="w-[100px] h-[100px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                    <div class="flex flex-col justify-center">
                        <h1 class="text-[22px] font-bold text-[#1E1B4B] tracking-tight mb-2">Global Tech Summit 2024</h1>
                        
                        <div class="flex items-center gap-4 text-[#475569] text-[13px] font-medium mb-2">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar-blank text-[16px]"></i>
                                <span>May 15 – May 17, 2024</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-clock text-[16px]"></i>
                                <span>09:00 AM – 06:00 PM (IST)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-[#475569] text-[13px] font-medium">
                            <i class="ph ph-map-pin text-[16px]"></i>
                            <span>Jio World Convention Centre, Mumbai, India</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Stepper -->
                <div class="flex flex-col pl-8">
                    <h2 class="text-[16px] font-bold text-[#1E1B4B] mb-5">Visitor Pass Selection</h2>
                    <div class="flex items-center">
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
            <div class="flex gap-4 mb-8">
                
                <!-- Card 1: Free Pass (Active) -->
                <div class="flex-1 border-[1.5px] border-primary-500 rounded-xl overflow-hidden flex flex-col relative transition-all">
                    <!-- Purple bg block for counter -->
                    <div class="absolute bottom-0 left-0 right-0 h-[64px] bg-primary-50 z-0"></div>
                    
                    <div class="p-5 flex-1 flex flex-col relative z-10 bg-white border-b border-gray-50">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="ph-fill ph-check-circle text-primary-500 text-[20px]"></i>
                            <h3 class="font-bold text-[#1E293B] text-[15px]">Free Visitor Pass</h3>
                        </div>
                        <div class="text-[20px] font-bold text-primary-600 mb-1">₹0</div>
                        <div class="text-[12px] text-gray-500 mb-5 border-b border-gray-100 pb-4">Access to exhibition & booths</div>
                        
                        <div class="space-y-3 flex-1">
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Access to exhibition floor</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Access to all booths</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Attend business sessions</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Expo guide & maps</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-x-circle text-gray-300 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-gray-400 font-medium">VIP lounge access</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-[64px] flex items-center justify-center relative z-10">
                        <div class="flex items-center gap-6 bg-white rounded-lg border border-gray-200 p-1 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-minus text-[14px] font-bold"></i>
                            </button>
                            <span class="text-[15px] font-bold text-[#1E1B4B]">1</span>
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-plus text-[14px] font-bold"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Business Pass -->
                <div class="flex-1 border border-gray-200 rounded-xl overflow-hidden flex flex-col bg-white transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="p-5 flex-1 flex flex-col border-b border-gray-50">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="ph ph-circle text-gray-300 text-[20px]"></i>
                            <h3 class="font-bold text-[#1E293B] text-[15px]">Business Visitor Pass</h3>
                        </div>
                        <div class="text-[20px] font-bold text-primary-600 mb-1">₹599</div>
                        <div class="text-[12px] text-gray-500 mb-5 border-b border-gray-100 pb-4">Enhanced networking access</div>
                        
                        <div class="space-y-3 flex-1">
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Everything in Free Pass</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Access to business lounge</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Priority entry</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Meet exhibitors</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-x-circle text-gray-300 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-gray-400 font-medium">VIP lounge access</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-[64px] flex items-center justify-center">
                        <div class="flex items-center gap-6 bg-white rounded-lg border border-gray-200 p-1 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-minus text-[14px] font-bold"></i>
                            </button>
                            <span class="text-[15px] font-bold text-[#1E1B4B]">0</span>
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-plus text-[14px] font-bold"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 3: VIP Pass -->
                <div class="flex-1 border border-gray-200 rounded-xl overflow-hidden flex flex-col bg-white transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="p-5 flex-1 flex flex-col border-b border-gray-50">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="ph ph-circle text-gray-300 text-[20px]"></i>
                            <h3 class="font-bold text-[#1E293B] text-[15px]">VIP Visitor Pass</h3>
                        </div>
                        <div class="text-[20px] font-bold text-primary-600 mb-1">₹1,499</div>
                        <div class="text-[12px] text-gray-500 mb-5 border-b border-gray-100 pb-4">Premium experience & benefits</div>
                        
                        <div class="space-y-3 flex-1">
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Everything in Business Pass</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">VIP lounge access</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Complimentary refreshments</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Dedicated support</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Exclusive networking events</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-[64px] flex items-center justify-center">
                        <div class="flex items-center gap-6 bg-white rounded-lg border border-gray-200 p-1 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-minus text-[14px] font-bold"></i>
                            </button>
                            <span class="text-[15px] font-bold text-[#1E1B4B]">0</span>
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-plus text-[14px] font-bold"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Student Pass -->
                <div class="flex-1 border border-gray-200 rounded-xl overflow-hidden flex flex-col bg-white transition-all hover:border-gray-300 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="p-5 flex-1 flex flex-col border-b border-gray-50">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="ph ph-circle text-gray-300 text-[20px]"></i>
                            <h3 class="font-bold text-[#1E293B] text-[15px]">Student Pass</h3>
                        </div>
                        <div class="text-[20px] font-bold text-primary-600 mb-1">₹299</div>
                        <div class="text-[12px] text-gray-500 mb-5 border-b border-gray-100 pb-4">For full-time students</div>
                        
                        <div class="space-y-3 flex-1">
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Access to exhibition floor</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Access to all booths</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-check-circle text-green-500 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-[#475569] font-medium">Attend select sessions</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-x-circle text-gray-300 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-gray-400 font-medium">Business lounge access</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <i class="ph-fill ph-x-circle text-gray-300 text-[16px] mt-0.5"></i>
                                <span class="text-[12px] text-gray-400 font-medium">VIP lounge access</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-[64px] flex items-center justify-center">
                        <div class="flex items-center gap-6 bg-white rounded-lg border border-gray-200 p-1 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-minus text-[14px] font-bold"></i>
                            </button>
                            <span class="text-[15px] font-bold text-[#1E1B4B]">0</span>
                            <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors">
                                <i class="ph ph-plus text-[14px] font-bold"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Section -->
            <div class="flex gap-4 pb-10">
                <!-- Promo Code -->
                <div class="w-1/3 border border-gray-100 rounded-xl p-6 shadow-sm bg-[#FAFAFA] flex flex-col justify-center">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                            <i class="ph ph-star text-[20px]"></i>
                        </div>
                        <h3 class="font-bold text-[#1E1B4B] text-[15px]">Have a promo code?</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="text" placeholder="Enter code" class="flex-1 border-b border-gray-300 bg-transparent px-1 py-2 text-[14px] text-[#1E293B] outline-none focus:border-primary-500 transition-colors">
                        <button class="border border-primary-500 text-primary-600 hover:bg-primary-50 px-6 py-2 rounded-lg font-bold text-[13px] transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="flex-1 border border-gray-100 rounded-xl p-6 shadow-sm bg-[#FAFAFA]">
                    <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-6">Order Summary</h3>
                    
                    <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                        <span class="text-[#475569] text-[14px] font-medium">Total Passes</span>
                        <span class="text-[#1E1B4B] text-[15px] font-bold">1</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[#1E1B4B] text-[15px] font-bold">Total Amount</span>
                        <span class="text-[#1E1B4B] text-[20px] font-bold" id="total-amount-display">₹0</span>
                    </div>
                    
                    <div class="flex flex-col items-center">
                        <a href="visitor-details.html" class="w-full inline-block text-center bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[14px] mb-3">
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

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cardContainers = document.querySelectorAll('.flex.gap-4.mb-8 > div');
            const totalAmountElem = document.getElementById('total-amount-display');
            const totalPassesElem = document.querySelector('.flex.items-center.justify-between.mb-4.border-b.border-gray-200.pb-4 span:last-child');
            
            // Default initialization
            if(!localStorage.getItem('selectedPassPrice')) {
                localStorage.setItem('selectedPassName', 'Free Visitor Pass');
                localStorage.setItem('selectedPassPrice', '0');
                localStorage.setItem('selectedPassFormattedPrice', '₹0');
                localStorage.setItem('selectedPassQuantity', '1');
            }

            // Fix z-index for all bottom bars
            cardContainers.forEach(c => {
                const bottomBar = c.querySelector('.h-\\[64px\\]');
                if(bottomBar) {
                    bottomBar.classList.add('relative', 'z-10');
                }
            });

            function updateUIAndStorage(activeCard, quantity) {
                let name = '';
                let priceNum = 0;
                let priceText = '₹0';
                
                cardContainers.forEach(c => {
                    const isCardActive = (c === activeCard && quantity > 0);
                    
                    // Style
                    if(isCardActive) {
                        c.className = "flex-1 border-[1.5px] border-primary-500 rounded-xl overflow-hidden flex flex-col relative transition-all";
                        if(!c.querySelector('.bg-primary-50.z-0')) {
                            c.insertAdjacentHTML('afterbegin', '<div class="absolute bottom-0 left-0 right-0 h-[64px] bg-primary-50 z-0"></div>');
                        }
                    } else {
                        c.className = "flex-1 border border-gray-200 rounded-xl overflow-hidden flex flex-col bg-white transition-all hover:border-gray-300";
                        const bg = c.querySelector('.bg-primary-50.z-0');
                        if(bg) bg.remove();
                    }
                    
                    // Icon
                    const icon = c.querySelector('.p-5 i:first-child');
                    if(icon) {
                        icon.className = isCardActive ? "ph-fill ph-check-circle text-primary-500 text-[20px]" : "ph ph-circle text-gray-300 text-[20px]";
                    }
                    
                    // Qty
                    const qtyElem = c.querySelector('.h-\\[64px\\] span');
                    if(qtyElem) qtyElem.innerText = isCardActive ? quantity : '0';
                    
                    // Button styles
                    const buttons = c.querySelectorAll('.h-\\[64px\\] button');
                    if(buttons.length >= 2) {
                        buttons[0].className = isCardActive ? "w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-primary-500 hover:bg-gray-50 transition-colors" : "w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors";
                    }
                    
                    if(isCardActive) {
                        const nameElem = c.querySelector('.p-5 h3');
                        const p5Div = c.querySelector('.p-5');
                        const priceElem = p5Div ? p5Div.children[1] : null;
                        
                        name = nameElem ? nameElem.innerText : '';
                        const basePriceText = priceElem ? priceElem.innerText : '₹0';
                        const basePriceNum = parseInt(basePriceText.replace('₹', '').replace(/,/g, '')) || 0;
                        
                        priceNum = basePriceNum * quantity;
                        priceText = '₹' + priceNum.toLocaleString('en-IN');
                    }
                });
                
                // Update Order Summary
                if (totalAmountElem) totalAmountElem.innerText = priceText;
                if (totalPassesElem) totalPassesElem.innerText = quantity;
                
                // Save
                localStorage.setItem('selectedPassName', name);
                localStorage.setItem('selectedPassPrice', priceNum);
                localStorage.setItem('selectedPassFormattedPrice', priceText);
                localStorage.setItem('selectedPassQuantity', quantity);
            }

            cardContainers.forEach((card) => {
                card.style.cursor = 'pointer';
                const buttons = card.querySelectorAll('.h-\\[64px\\] button');
                const minusBtn = buttons.length >= 2 ? buttons[0] : null;
                const plusBtn = buttons.length >= 2 ? buttons[1] : null;
                
                // Handle minus click
                if(minusBtn) {
                    minusBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const qtyElem = card.querySelector('.h-\\[64px\\] span');
                        let currentQty = parseInt(qtyElem.innerText) || 0;
                        if(currentQty > 0) {
                            updateUIAndStorage(card, currentQty - 1);
                        }
                    });
                }
                
                // Handle plus click
                if(plusBtn) {
                    plusBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const qtyElem = card.querySelector('.h-\\[64px\\] span');
                        let currentQty = parseInt(qtyElem.innerText) || 0;
                        updateUIAndStorage(card, currentQty + 1);
                    });
                }

                // Handle card click
                card.addEventListener('click', () => {
                    const qtyElem = card.querySelector('.h-\\[64px\\] span');
                    let currentQty = parseInt(qtyElem.innerText) || 0;
                    if(currentQty === 0) {
                        updateUIAndStorage(card, 1);
                    }
                });
            });
        });
    </script>
</body>
</html>
