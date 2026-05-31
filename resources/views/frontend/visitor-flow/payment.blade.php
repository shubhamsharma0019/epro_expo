@php
    $exhibition = \App\Models\Exhibition::query()
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
        $exhibition = \App\Models\Exhibition::query()
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
        $dateStr = 'June 12 - 14, 2026';
    }
    
    // Resolve location
    $location = $exhibition->venue ?: ($exhibition->location ?: 'Virtual');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Payment</title>
    <script>
        // Check if all visitor details and pass selection are filled before showing page content
        (function() {
            const passName = localStorage.getItem('selectedPassName');
            if (!passName) {
                alert('Please select a pass first.');
                window.location.href = "{{ route('exhibitions.tickets.select', $slug) }}";
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
                window.location.href = "{{ route('exhibitions.tickets.visitor-details', $slug) }}";
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
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
            font-size: 12px;
            font-weight: 500;
            color: #64748B;
            margin-bottom: 6px;
        }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Header Section with Stepper -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 pb-8 gap-6 border-b border-gray-100">
                <!-- Left: Event Info -->
                <div class="flex gap-5">
                    <div class="w-[100px] h-[100px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('{{ $bannerImage }}');"></div>
                    <div class="flex flex-col justify-center">
                        <h1 class="text-[22px] font-bold text-[#1E1B4B] tracking-tight mb-2">{{ $title }}</h1>
                        
                        <div class="flex items-center gap-4 text-[#475569] text-[13px] font-medium mb-2">
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-calendar-blank text-[16px]"></i>
                                <span>{{ $dateStr }}</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-1.5">
                                <i class="ph ph-clock text-[16px]"></i>
                                <span>09:00 AM – 06:00 PM (IST)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-[#475569] text-[13px] font-medium">
                            <i class="ph ph-map-pin text-[16px]"></i>
                            <span>{{ $location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Stepper -->
                <div class="flex flex-col lg:pl-8 w-full lg:w-auto">
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
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[16px] mb-2 shadow-sm">
                                <i class="ph-fill ph-check font-bold"></i>
                            </div>
                            <span class="text-[12px] font-medium text-[#1E1B4B] text-center leading-tight">Review & Confirm</span>
                        </div>
                        <!-- Line 3 (Completed) -->
                        <div class="flex-1 h-[2px] bg-primary-500 -mx-6 mt-[calc(-24px)] relative z-0 min-w-[60px]"></div>
                        <!-- Step 4 (Active) -->
                        <div class="flex flex-col items-center relative z-10 w-24">
                            <div class="w-7 h-7 rounded-full bg-primary-500 text-white flex items-center justify-center text-[12px] font-bold mb-2 shadow-sm">4</div>
                            <span class="text-[12px] font-bold text-primary-600 text-center leading-tight">Payment</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left: Main Form Area -->
                <div class="flex-1">
                    <div class="mb-6">
                        <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-1">Payment</h2>
                        <p class="text-[14px] text-gray-500 font-medium">Choose a payment method and complete your purchase.</p>
                    </div>

                    <!-- Amount to Pay Box -->
                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm bg-white mb-6">
                        <div class="flex items-center justify-between mb-5 border-b border-gray-50 pb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Amount to Pay</h3>
                            <span class="font-bold text-primary-600 text-[20px]" id="payment-total-top">₹0</span>
                        </div>
                        <div class="space-y-4 mb-5">
                            <div class="flex items-center justify-between text-[14px]">
                                <span class="text-[#475569] font-medium">Total Passes</span>
                                <span class="font-semibold text-[#1E293B]" id="payment-qty-top">1</span>
                            </div>
                            <div class="flex items-center justify-between text-[14px]">
                                <span class="text-[#475569] font-medium">Subtotal</span>
                                <span class="font-semibold text-[#1E293B]" id="payment-subtotal-top">₹0</span>
                            </div>
                            <div id="payment-discount-row-top" class="hidden flex items-center justify-between text-[14px] text-green-600">
                                <span id="payment-discount-label-top" class="font-medium">Discount</span>
                                <span class="font-bold" id="payment-discount-amount-top">-₹0</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="font-bold text-[#1E1B4B] text-[15px]">Total Amount</span>
                            <span class="font-bold text-primary-600 text-[22px]" id="payment-grand-top">₹0</span>
                        </div>
                    </div>

                    <!-- Select Payment Method Section -->
                    <div class="mb-2">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Select Payment Method</h3>
                    </div>

                    <!-- Payment Method Container -->
                    <div class="flex flex-col md:flex-row border border-gray-200 rounded-2xl overflow-hidden bg-white mb-10 shadow-sm min-h-[400px]">
                        
                        <!-- Left Col: Payment Options -->
                        <div id="payment-methods-list" class="w-full md:w-full max-w-[320px] bg-white border-b md:border-b-0 md:border-r border-gray-200 flex flex-col">
                            
                            <!-- Option 1: Card (Active) -->
                            <div class="p-4 border-b border-gray-100 bg-primary-50/50 cursor-pointer flex items-center justify-between relative">
                                <!-- Active border indicator -->
                                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-primary-500"></div>
                                <div class="flex items-start gap-3">
                                    <i class="ph-fill ph-radio-button text-primary-500 text-[20px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">Credit / Debit Card</div>
                                        <div class="text-[12px] text-gray-500">Visa, Mastercard, Rupay & more</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-[#1A1F71] font-bold text-[10px] italic">VISA</span>
                                    <span class="w-4 h-4 bg-red-500 rounded-full mix-blend-multiply opacity-80"></span>
                                    <span class="text-blue-600 font-bold text-[10px] italic">RuPay</span>
                                    <span class="text-blue-500 font-bold text-[10px]">AMEX</span>
                                </div>
                            </div>
                            
                            <!-- Option 2: UPI -->
                            <div class="p-4 border-b border-gray-100 bg-white cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-circle text-gray-300 text-[20px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">UPI</div>
                                        <div class="text-[12px] text-gray-500">Pay using any UPI app</div>
                                    </div>
                                </div>
                                <div class="text-gray-400 font-bold text-[14px] italic border px-2 py-0.5 rounded">UPI</div>
                            </div>

                            <!-- Option 3: Net Banking -->
                            <div class="p-4 border-b border-gray-100 bg-white cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-circle text-gray-300 text-[20px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">Net Banking</div>
                                        <div class="text-[12px] text-gray-500">All major banks supported</div>
                                    </div>
                                </div>
                                <i class="ph ph-bank text-primary-500 text-[24px]"></i>
                            </div>

                            <!-- Option 4: Wallets -->
                            <div class="p-4 border-b border-gray-100 bg-white cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-circle text-gray-300 text-[20px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">Wallets</div>
                                        <div class="text-[12px] text-gray-500">Pay using popular wallets</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-blue-900 font-bold text-[10px]">Paytm</span>
                                    <span class="text-orange-500 font-bold text-[10px]">amazon pay</span>
                                </div>
                            </div>

                            <!-- Option 5: Pay Later -->
                            <div class="p-4 bg-white cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-circle text-gray-300 text-[20px] mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">Pay Later</div>
                                        <div class="text-[12px] text-gray-500">Buy now, pay later</div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-blue-400 font-bold text-[10px] leading-tight">Paytm</span>
                                    <span class="text-blue-900 font-bold text-[9px] bg-blue-100 px-1 rounded-sm">POSTPAID</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Col: Card Details Form -->
                        <div class="flex-1 p-4 md:p-8 flex flex-col bg-[#FAFAFA]">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-6" id="form-title">Card Details</h3>
                            
                            <!-- Card Form -->
                            <div id="form-card" class="payment-form space-y-5 flex-1 block">
                                <div>
                                    <label class="form-label">Card Number</label>
                                    <div class="relative">
                                        <input type="text" class="form-input bg-white" placeholder="1234 5678 9012 3456">
                                        <i class="ph ph-credit-card absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="form-label">Name on Card</label>
                                    <input type="text" id="card-name-input" class="form-input bg-white" placeholder="Aarav Sharma">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label">Expiry Date</label>
                                        <input type="text" class="form-input bg-white" placeholder="MM / YY">
                                    </div>
                                    <div>
                                        <label class="form-label">CVV</label>
                                        <div class="relative">
                                            <input type="password" class="form-input bg-white pr-8" placeholder="123">
                                            <i class="ph ph-info absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-1">
                                    <div class="w-4 h-4 rounded-sm bg-primary-600 flex items-center justify-center text-white cursor-pointer">
                                        <i class="ph-bold ph-check text-[10px]"></i>
                                    </div>
                                    <span class="text-[13px] text-[#475569] font-medium">Save card for future payments</span>
                                </div>
                            </div>

                            <!-- UPI Form -->
                            <div id="form-upi" class="payment-form space-y-5 flex-1 hidden">
                                <div>
                                    <label class="form-label">UPI ID / VPA</label>
                                    <div class="relative">
                                        <input type="text" class="form-input bg-white" placeholder="username@upi">
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                                            <span class="text-[12px] font-bold text-primary-600 cursor-pointer hover:underline border-l pl-3 border-gray-200">Verify</span>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-2">A payment request will be sent to this UPI app.</p>
                                </div>
                                <div class="p-4 bg-white border border-gray-100 rounded-xl flex items-center justify-center gap-4 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center">
                                        <i class="ph ph-qr-code text-[24px] text-gray-400"></i>
                                    </div>
                                    <div class="text-[13px] text-gray-500 font-medium">Or scan QR code using<br>any UPI app</div>
                                </div>
                            </div>

                            <!-- Net Banking Form -->
                            <div id="form-netbanking" class="payment-form space-y-5 flex-1 hidden">
                                <div>
                                    <label class="form-label">Select Bank</label>
                                    <select class="form-input bg-white appearance-none pr-10">
                                        <option value="" disabled selected>Choose your bank</option>
                                        <option>HDFC Bank</option>
                                        <option>ICICI Bank</option>
                                        <option>State Bank of India</option>
                                        <option>Axis Bank</option>
                                        <option>Kotak Mahindra Bank</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                    <div class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-primary-500 transition-colors">
                                        <div class="w-8 h-8 bg-blue-50 rounded-full mx-auto mb-2 border border-blue-100"></div>
                                        <div class="text-[11px] font-medium text-gray-600">HDFC</div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-primary-500 transition-colors">
                                        <div class="w-8 h-8 bg-orange-50 rounded-full mx-auto mb-2 border border-orange-100"></div>
                                        <div class="text-[11px] font-medium text-gray-600">ICICI</div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-primary-500 transition-colors">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full mx-auto mb-2 border border-blue-200"></div>
                                        <div class="text-[11px] font-medium text-gray-600">SBI</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Wallets Form -->
                            <div id="form-wallets" class="payment-form space-y-5 flex-1 hidden">
                                <div>
                                    <label class="form-label">Select Wallet</label>
                                    <div class="space-y-3">
                                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg bg-white cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="wallet" class="w-4 h-4 text-primary-600">
                                            <span class="text-[14px] font-medium text-[#1E1B4B]">Paytm</span>
                                        </label>
                                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg bg-white cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="wallet" class="w-4 h-4 text-primary-600">
                                            <span class="text-[14px] font-medium text-[#1E1B4B]">Amazon Pay</span>
                                        </label>
                                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg bg-white cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="wallet" class="w-4 h-4 text-primary-600">
                                            <span class="text-[14px] font-medium text-[#1E1B4B]">PhonePe Wallet</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Pay Later Form -->
                            <div id="form-paylater" class="payment-form space-y-5 flex-1 hidden">
                                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 text-center mt-2">
                                    <i class="ph ph-clock-counter-clockwise text-[32px] text-blue-500 mb-2"></i>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Buy Now, Pay Later</h4>
                                    <p class="text-[12px] text-gray-500 mb-4">Complete your payment using your eligible postpaid account.</p>
                                    
                                    <div>
                                        <label class="form-label text-left">Mobile Number linked to Postpaid</label>
                                        <input type="text" id="paylater-mobile-input" class="form-input bg-white text-center tracking-widest font-medium" placeholder="+91 98765 43210">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pay Button Box -->
                            <div class="mt-6 flex flex-col items-center w-full">
                                <button id="pay-securely-btn" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] mb-3">
                                    <i class="ph ph-lock-key"></i> Pay Securely
                                </button>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[11px] font-medium">
                                    <i class="ph-fill ph-shield-check text-[14px]"></i>
                                    <span>Your payment information is encrypted and secure.</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Buttons -->
                    <div class="flex items-center justify-between pb-10">
                        <a href="{{ route('exhibitions.tickets.summary', $slug) }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm text-[14px]">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                        <div class="flex items-center gap-1.5 text-gray-400 text-[12px] font-medium mr-4">
                            <i class="ph ph-lock text-[14px]"></i>
                            <span>Secure checkout powered by eproexpo</span>
                        </div>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="w-full lg:w-[340px] shrink-0 flex flex-col gap-5">
                    
                    <!-- Order Summary Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Order Summary</h3>
                        
                        <div class="flex items-center justify-between text-[14px] mb-3">
                            <span class="text-[#475569] font-medium" id="payment-pass-name">Free Visitor Pass</span>
                            <span class="font-semibold text-[#1E293B]" id="payment-pass-price">₹0</span>
                        </div>
                        <div class="flex items-center justify-between text-[13px] mb-6 pb-5 border-b border-gray-100">
                            <span class="text-gray-500">Quantity</span>
                            <span class="font-medium text-gray-700" id="payment-pass-qty">1</span>
                        </div>

                        <div class="flex items-center justify-between text-[14px] mb-5">
                            <span class="text-[#475569] font-medium">Subtotal</span>
                            <span class="font-semibold text-[#1E293B]" id="payment-subtotal">₹0</span>
                        </div>
                        <div id="payment-discount-row" class="hidden flex items-center justify-between text-[14px] mb-5 text-green-600">
                            <span id="payment-discount-label" class="font-medium">Discount</span>
                            <span class="font-bold" id="payment-discount-amount">-₹0</span>
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 mb-6">
                            <span class="font-bold text-[#1E1B4B] text-[15px]">Total Amount</span>
                            <span class="font-bold text-primary-600 text-[26px]" id="payment-total">₹0</span>
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

                    <!-- Need Help Box -->
                    <div class="border border-indigo-100 rounded-2xl bg-indigo-50/30 p-5 flex gap-4">
                        <i class="ph ph-headset text-primary-500 text-[24px]"></i>
                        <div>
                            <div class="font-bold text-[#1E1B4B] text-[14px] mb-1.5">Need help?</div>
                            <p class="text-[12px] text-[#475569] font-medium mb-3 leading-relaxed">If you face any issues during payment, contact our support team.</p>
                            <div class="flex flex-col gap-1 text-[12px] font-bold text-primary-600">
                                <a href="mailto:support@eproexpo.com" class="hover:underline">support@eproexpo.com</a>
                                <a href="tel:+919876543210" class="hover:underline">+91 98765 43210</a>
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
        async function initializePaymentPage() {
            const urlParams = new URLSearchParams(window.location.search);
            let exhId = '{{ $exhibition->id }}';
            localStorage.setItem('activeExhibitionId', exhId);
            localStorage.setItem('activeExhibitionName', '{{ addslashes($title) }}');

            // Load LocalStorage Data
            const passName = localStorage.getItem('selectedPassName') || 'Free Visitor Pass';
            
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
            
            const nameElem = document.getElementById('payment-pass-name');
            if (nameElem) nameElem.innerText = passName;
            
            const qtyElemTop = document.getElementById('payment-qty-top');
            const qtyElem = document.getElementById('payment-pass-qty');
            if (qtyElemTop) qtyElemTop.innerText = passQty;
            if (qtyElem) qtyElem.innerText = passQty;
            
            const totalTop = document.getElementById('payment-total-top');
            const subTop = document.getElementById('payment-subtotal-top');
            const grandTop = document.getElementById('payment-grand-top');
            
            const passPrice = document.getElementById('payment-pass-price');
            const subtotal = document.getElementById('payment-subtotal');
            const total = document.getElementById('payment-total');
            
            if (totalTop) totalTop.innerText = formatINR(passTotalAmount);
            if (subTop) subTop.innerText = formatINR(passSubtotal);
            if (grandTop) grandTop.innerText = formatINR(passTotalAmount);
            
            if (passPrice) passPrice.innerText = formatINR(passPriceNum);
            if (subtotal) subtotal.innerText = formatINR(passSubtotal);
            if (total) total.innerText = formatINR(passTotalAmount);

            // Handle Discount Rows
            const discountRowTop = document.getElementById('payment-discount-row-top');
            const discountLabelTop = document.getElementById('payment-discount-label-top');
            const discountAmountTop = document.getElementById('payment-discount-amount-top');
            
            if (passDiscount > 0) {
                if (discountRowTop) {
                    discountRowTop.classList.remove('hidden');
                    if (discountLabelTop) {
                        discountLabelTop.innerText = appliedPromoCode ? `Discount (${appliedPromoCode})` : 'Discount';
                    }
                    if (discountAmountTop) {
                        discountAmountTop.innerText = '-₹' + passDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                }
            } else {
                if (discountRowTop) {
                    discountRowTop.classList.add('hidden');
                }
            }
            
            const discountRow = document.getElementById('payment-discount-row');
            const discountLabel = document.getElementById('payment-discount-label');
            const discountAmount = document.getElementById('payment-discount-amount');
            
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

            // Pre-fill Name on Card & Mobile Input fields
            const firstName = localStorage.getItem('visitor_reg_first_name') || '';
            const lastName = localStorage.getItem('visitor_reg_last_name') || '';
            const fullName = `${firstName} ${lastName}`.trim();
            const mobileNumber = localStorage.getItem('visitor_reg_mobile') || '';
            
            const cardNameInput = document.getElementById('card-name-input');
            if (cardNameInput) {
                cardNameInput.value = fullName;
            }
            
            const paylaterMobileInput = document.getElementById('paylater-mobile-input');
            if (paylaterMobileInput && mobileNumber) {
                if (mobileNumber.startsWith('+')) {
                    paylaterMobileInput.value = mobileNumber;
                } else if (mobileNumber.startsWith('91') && mobileNumber.length > 10) {
                    paylaterMobileInput.value = '+' + mobileNumber;
                } else {
                    paylaterMobileInput.value = '+91 ' + mobileNumber;
                }
            }

            // Payment Option Selection Logic
            const paymentOptions = document.querySelectorAll('#payment-methods-list > div');
            
            paymentOptions.forEach(option => {
                option.addEventListener('click', () => {
                    // Reset all options
                    paymentOptions.forEach(opt => {
                        opt.className = "p-4 border-b border-gray-100 bg-white cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between relative";
                        const indicator = opt.querySelector('.bg-primary-500.absolute');
                        if (indicator) indicator.remove();
                        
                        const icon = opt.querySelector('i.ph-radio-button, i.ph-circle');
                        if (icon) {
                            icon.className = "ph ph-circle text-gray-300 text-[20px] mt-0.5";
                        }
                    });

                    // Activate clicked option
                    option.className = "p-4 border-b border-gray-100 bg-primary-50/50 cursor-pointer flex items-center justify-between relative";
                    option.insertAdjacentHTML('afterbegin', '<div class="absolute left-0 top-0 bottom-0 w-[3px] bg-primary-500"></div>');
                    
                    const icon = option.querySelector('i.ph-circle');
                    if (icon) {
                        icon.className = "ph-fill ph-radio-button text-primary-500 text-[20px] mt-0.5";
                    }

                    // Toggle corresponding form
                    const titleElem = document.getElementById('form-title');
                    const forms = document.querySelectorAll('.payment-form');
                    forms.forEach(f => {
                        f.classList.remove('block');
                        f.classList.add('hidden');
                    });

                    const optText = option.querySelector('.font-bold').innerText.toLowerCase();
                    
                    if(optText.includes('card')) {
                        titleElem.innerText = 'Card Details';
                        document.getElementById('form-card').classList.replace('hidden', 'block');
                    } else if(optText.includes('upi')) {
                        titleElem.innerText = 'UPI Payment';
                        document.getElementById('form-upi').classList.replace('hidden', 'block');
                    } else if(optText.includes('net banking')) {
                        titleElem.innerText = 'Net Banking';
                        document.getElementById('form-netbanking').classList.replace('hidden', 'block');
                    } else if(optText.includes('wallet')) {
                        titleElem.innerText = 'Select Wallet';
                        document.getElementById('form-wallets').classList.replace('hidden', 'block');
                    } else if(optText.includes('pay later')) {
                        titleElem.innerText = 'Pay Later';
                        document.getElementById('form-paylater').classList.replace('hidden', 'block');
                    }
                });
            });

            // Perform Secure Payment registration POST to Laravel backend
            const payBtn = document.getElementById('pay-securely-btn');
            if (payBtn) {
                payBtn.addEventListener('click', async (e) => {
                    e.preventDefault();

                    const first_name = localStorage.getItem('visitor_reg_first_name') || '';
                    const last_name = localStorage.getItem('visitor_reg_last_name') || '';
                    const email = localStorage.getItem('visitor_reg_email') || '';
                    const mobile = localStorage.getItem('visitor_reg_mobile') || '';

                    // Prepare registration details
                    const visitorData = {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        mobile: mobile,
                        job_title: localStorage.getItem('visitor_reg_job_title') || '',
                        company: localStorage.getItem('visitor_reg_company') || '',
                        country: localStorage.getItem('visitor_reg_country') || '',
                        state: localStorage.getItem('visitor_reg_state') || '',
                        city: localStorage.getItem('visitor_reg_city') || '',
                        industry: localStorage.getItem('visitor_reg_industry') || '',
                        company_size: localStorage.getItem('visitor_reg_company_size') || '',
                        business_address: localStorage.getItem('visitor_reg_business_address') || '',
                        pavilion_id: localStorage.getItem('visitor_reg_pavilion_id') || '',
                        pass_type: passName,
                        amount: passTotalAmount
                    };

                    const handleBackendRegistration = async () => {
                        payBtn.disabled = true;
                        payBtn.innerHTML = '<i class="ph ph-spinner-gap animate-spin"></i> Processing...';
                        try {
                            // 1. Submit Registration POST
                            const visitor = await ExhibitionAPI.registerVisitor(exhId, visitorData);
                            
                            if (visitor && visitor.booking_id) {
                                const bookingId = visitor.booking_id;
                                localStorage.setItem('lastBookingId', bookingId);
                                localStorage.setItem('lastVisitorEmail', visitor.email);
                                
                                // 2. Perform Payment Confirmation simulation POST if there is a cost
                                if (passTotalAmount > 0) {
                                    await ExhibitionAPI.confirmPayment(bookingId);
                                }

                                // 3. Redirect to success page
                                window.location.href = `{{ route('exhibitions.tickets.confirmed', $slug) }}?booking_id=${bookingId}&id=${exhId}`;
                            } else {
                                throw new Error('Registration failed to return valid visitor details.');
                            }
                        } catch (err) {
                            console.error(err);
                            alert('An error occurred during registration. Please try again.');
                            payBtn.disabled = false;
                            payBtn.innerHTML = '<i class="ph ph-lock-key"></i> Pay Securely';
                        }
                    };

                     // Temporarily bypassing Razorpay for testing so payments succeed immediately
                     handleBackendRegistration();
                 });
             }
        }

        if (document.readyState !== 'loading') {
            initializePaymentPage();
        } else {
            document.addEventListener('DOMContentLoaded', initializePaymentPage);
        }
    </script>
</body>
</html>
