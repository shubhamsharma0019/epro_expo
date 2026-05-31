<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Visitor Details</title>
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
                        <!-- Step 2 (Active) -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[12px] font-bold mb-2 shadow-sm">2</div>
                            <span class="text-[12px] font-bold text-primary-600 text-center leading-tight">Visitor Details</span>
                        </div>
                        <!-- Line 2 -->
                        <div class="flex-1 h-[2px] bg-gray-200 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[12px] font-bold mb-2">3</div>
                            <span class="text-[12px] font-medium text-gray-500 text-center leading-tight">Review & Confirm</span>
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

            <!-- Content Area (Form + Summary) -->
            <div class="flex gap-8">
                
                <!-- Left: Main Form Area -->
                <div class="flex-1">
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Visitor Details</h2>
                            <p class="text-[14px] text-gray-500 font-medium">Please enter your details to continue.</p>
                        </div>
                        <div class="text-[13px] text-gray-500 font-medium">
                            All fields marked with <span class="required">*</span> are required
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <!-- Row 1 -->
                        <div>
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" class="form-input" value="John">
                        </div>
                        <div>
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-input" value="Doe">
                        </div>
                        <div>
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" class="form-input" value="john.doe@email.com">
                        </div>

                        <!-- Row 2 -->
                        <div>
                            <label class="form-label">Mobile Number <span class="required">*</span></label>
                            <div class="flex border border-[#E2E8F0] rounded-lg overflow-hidden focus-within:border-primary-500 transition-colors">
                                <button class="flex items-center gap-1.5 px-3 bg-gray-50 border-r border-[#E2E8F0] text-[14px] font-medium">
                                    <span>🇮🇳</span>
                                    <span>+91</span>
                                    <i class="ph ph-caret-down text-gray-400 text-xs ml-1"></i>
                                </button>
                                <input type="text" class="flex-1 px-3 py-2 text-[14px] outline-none" value="98765 43210">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Job Title <span class="required">*</span></label>
                            <input type="text" class="form-input" value="Product Manager">
                        </div>
                        <div>
                            <label class="form-label">Company / Organization <span class="required">*</span></label>
                            <input type="text" class="form-input" value="TechNext Solutions Pvt. Ltd.">
                        </div>

                        <!-- Row 3 -->
                        <div>
                            <label class="form-label">Country <span class="required">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none bg-white">
                                    <option>India</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">State <span class="required">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none bg-white">
                                    <option>Maharashtra</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">City <span class="required">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none bg-white">
                                    <option>Mumbai</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4 (2 columns) -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="form-label">Industry <span class="required">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none bg-white">
                                    <option>Technology</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Company Size <span class="required">*</span></label>
                            <div class="relative">
                                <select class="form-input appearance-none bg-white">
                                    <option>51 - 200 Employees</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5 (Full width) -->
                    <div class="mb-6">
                        <label class="form-label">Business Address <span class="required">*</span></label>
                        <input type="text" class="form-input" value="401, Infinity Tower, Mindspace, Malad West">
                    </div>

                    <!-- Checkbox -->
                    <div class="flex items-center gap-3 mb-10 mt-2">
                        <div class="w-5 h-5 rounded border border-primary-500 bg-primary-500 flex items-center justify-center text-white shrink-0 cursor-pointer shadow-sm">
                            <i class="ph-bold ph-check text-[14px]"></i>
                        </div>
                        <span class="text-[14px] text-[#1E293B] font-medium">Receive updates about this event and future events from eproexpo and partners.</span>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="flex items-center justify-between pb-10">
                        <a href="pass-selection.html" class="flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm text-[15px]">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                        <a href="review-confirm.html" class="flex items-center gap-2 px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-[0_4px_14px_rgba(90,50,250,0.25)] text-[15px]">
                            Continue to Review <i class="ph ph-arrow-right text-lg"></i>
                        </a>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="w-[340px] shrink-0">
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] sticky top-0">
                        
                        <!-- Your Selection -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-[#1E1B4B] text-[15px]">Your Selection</h3>
                                <a href="pass-selection.html" class="text-primary-600 font-bold text-[13px] hover:underline">Edit</a>
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
                                <div class="w-14 h-14 rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                                <div class="flex flex-col">
                                    <div class="font-bold text-[#1E293B] text-[13px] mb-1.5 leading-tight">Global Tech Summit 2024</div>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[11px] mb-1 font-medium">
                                        <i class="ph ph-calendar-blank text-[13px]"></i>
                                        <span>May 15 – May 17, 2024</span>
                                    </div>
                                    <div class="flex items-start gap-1.5 text-gray-500 text-[11px] font-medium leading-snug">
                                        <i class="ph ph-map-pin text-[13px] mt-0.5"></i>
                                        <span>Jio World Convention Centre, Mumbai, India</span>
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
                                    <span class="font-bold text-[#1E293B]">1</span>
                                </div>
                                <div class="flex items-center justify-between text-[13px]">
                                    <span class="text-gray-500 font-medium">Subtotal</span>
                                    <span class="font-bold text-[#1E293B]" id="visitor-subtotal">₹0</span>
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
                const qtyElem = document.getElementById('visitor-pass-qty');
                const qtySummaryElem = document.getElementById('visitor-pass-qty-summary');
                if (qtyElem) qtyElem.innerText = passQty;
                if (qtySummaryElem) qtySummaryElem.innerText = passQty;
            }
        });
    </script>
</body>
</html>
