<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Review & Confirm</title>
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
            <div class="flex items-start justify-between mb-8 pb-8 border-b border-gray-100">
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
            <div class="flex gap-8">
                
                <!-- Left: Review Info -->
                <div class="flex-1">
                    <div class="mb-6">
                        <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Review & Confirm</h2>
                        <p class="text-[14px] text-gray-500 font-medium">Please review your details and confirm your order.</p>
                    </div>

                    <!-- 1. Selected Pass -->
                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm bg-white mb-6">
                        <div class="flex items-center justify-between mb-4 border-b border-gray-50 pb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">1. Selected Pass</h3>
                            <a href="pass-selection.html" class="flex items-center gap-1.5 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-pencil-simple text-[15px]"></i> Edit
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center">
                                    <i class="ph ph-identification-badge text-[24px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[15px] mb-1" id="visitor-pass-name">Free Visitor Pass</div>
                                    <div class="text-[13px] text-[#475569]">Access to exhibition & booths</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-[#1E1B4B] text-[20px] mb-1" id="visitor-pass-price">₹0</div>
                                <div class="text-primary-600 font-medium text-[12px] bg-primary-50 px-3 py-1 rounded-full inline-block" id="visitor-pass-qty-pill">Quantity: 1</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Visitor Details -->
                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm bg-white mb-6">
                        <div class="flex items-center justify-between mb-5 border-b border-gray-50 pb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">2. Visitor Details</h3>
                            <a href="visitor-details.html" class="flex items-center gap-1.5 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-pencil-simple text-[15px]"></i> Edit
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-y-6 gap-x-4">
                            <!-- Col 1 -->
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Name</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">John Doe</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Email Address</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">john.doe@email.com</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Business Address</div>
                                <div class="text-[14px] text-[#1E293B] font-medium leading-relaxed max-w-[200px]">401, Infinity Tower, Mindspace, Malad West, Mumbai, Maharashtra, India</div>
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Mobile Number</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">+91 98765 43210</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Company / Organization</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">TechNext Solutions Pvt. Ltd.</div>
                            </div>
                            <div class="row-span-2 col-start-3 self-end -mt-6">
                                <!-- Empty to align with business address if needed, wait the image has Business Address spanning down or taking space -->
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Job Title</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">Product Manager</div>
                            </div>
                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Company Size</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">51 - 200 Employees</div>
                            </div>
                            <div class="col-start-3">
                                <div class="text-[12px] text-gray-500 font-medium mb-1">City, State, Country</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">Mumbai, Maharashtra, India</div>
                            </div>

                            <div>
                                <div class="text-[12px] text-gray-500 font-medium mb-1">Industry</div>
                                <div class="text-[14px] text-[#1E293B] font-medium">Technology</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Additional Information -->
                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm bg-white mb-10">
                        <div class="mb-4 pb-2">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">3. Additional Information</h3>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex gap-4 items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center flex-shrink-0">
                                    <i class="ph ph-envelope-simple text-[20px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[13px] mb-0.5">Updates & Notifications</div>
                                    <div class="text-[13px] text-[#64748B] max-w-[400px] leading-relaxed">You will receive updates about this event and future events from eproexpo and partners.</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-full font-bold text-[12px] border border-green-100">
                                <i class="ph-bold ph-check"></i> Subscribed
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="pb-10">
                        <a href="visitor-details.html" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm text-[14px]">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="w-[340px] shrink-0 flex flex-col gap-5">
                    
                    <!-- Order Summary Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-6 shadow-sm">
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
                            <div class="w-[70px] h-[70px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                            <div class="flex flex-col">
                                <div class="font-bold text-[#1E1B4B] text-[13px] mb-1.5">Global Tech Summit 2024</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-calendar-blank text-[14px]"></i>
                                    <span>May 15 – May 17, 2024</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-snug">
                                    <i class="ph ph-map-pin text-[14px] mt-0.5"></i>
                                    <span>Jio World Convention Centre, Mumbai, India</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proceed to Payment Button -->
                    <div class="flex flex-col items-center mt-2">
                        <a href="payment.html" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] mb-3">
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

    <script src="../assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passName = localStorage.getItem('selectedPassName');
            const passPriceFormatted = localStorage.getItem('selectedPassFormattedPrice');
            const passQty = localStorage.getItem('selectedPassQuantity');
            
            if (passName) {
                const nameElem = document.getElementById('visitor-pass-name');
                if (nameElem) nameElem.innerText = passName;
            }
            
            if (passPriceFormatted) {
                const priceElem = document.getElementById('visitor-pass-price');
                const subtotalElem = document.getElementById('visitor-subtotal');
                const totalElem = document.getElementById('visitor-total');
                
                if (priceElem) priceElem.innerText = passPriceFormatted;
                if (subtotalElem) subtotalElem.innerText = passPriceFormatted;
                if (totalElem) totalElem.innerText = passPriceFormatted;
            }
            
            if (passQty) {
                const qtyPill = document.getElementById('visitor-pass-qty-pill');
                const totalPasses = document.getElementById('visitor-total-passes');
                if (qtyPill) qtyPill.innerText = 'Quantity: ' + passQty;
                if (totalPasses) totalPasses.innerText = passQty;
            }
        });
    </script>
</body>
</html>
