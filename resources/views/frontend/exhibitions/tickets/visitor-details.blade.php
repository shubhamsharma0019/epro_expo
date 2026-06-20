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

    // Get Pavilions dynamically
    $pavilions = \App\Domain\Event\Models\Pavilion::where('exhibition_id', $exhibition->id)->get();

    // Get logged in user details if authenticated (Do not auto-prefill fields as per user request)
    $firstName = '';
    $lastName = '';
    $email = '';
    $phone = '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Visitor Details</title>
    <script>
        // Check if pass selection is filled before showing page content
        (function() {
            const passName = localStorage.getItem('selectedPassName');
            if (!passName) {
                alert('Please select a pass first.');
                window.location.href = "{{ route('exhibitions.tickets.select', $slug) }}";
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
                                <span>{{ $timeStr }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-[#475569] text-[13px] font-medium">
                            <i class="ph ph-map-pin text-[16px]"></i>
                            <span>{{ $location }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Stepper -->
                <div class="flex flex-col lg:pl-8 w-full lg:w-auto overflow-hidden">
                    <h2 class="text-[16px] font-bold text-[#1E1B4B] mb-5">Visitor Pass Selection</h2>
                    <div class="flex items-center ticket-flow-stepper no-scrollbar">
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
            <div class="ticket-flow-two-col flex flex-col lg:flex-row gap-8">
                
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                        <!-- Row 0: Exhibition & Pavilion Selection -->
                        <div class="col-span-2">
                            <label class="form-label">Selected Exhibition</label>
                            <input type="text" id="selected_exhibition_display" class="form-input bg-gray-50 text-gray-500 font-medium" disabled value="{{ $title }}">
                        </div>
                        <div>
                            <label class="form-label">Select Pavilion <span class="required">*</span></label>
                            <div class="relative">
                                <select id="pavilion_id" class="form-input appearance-none bg-white font-medium">
                                    <option value="">-- Select Pavilion --</option>
                                    @foreach ($pavilions as $p)
                                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                                    @endforeach
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Row 1 -->
                        <div>
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" class="form-input" value="{{ old('first_name', $firstName) }}">
                        </div>
                        <div>
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" class="form-input" value="{{ old('last_name', $lastName) }}">
                        </div>
                        <div>
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" class="form-input" value="{{ old('email', $email) }}">
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
                                <input type="text" id="mobile" class="flex-1 px-3 py-2 text-[14px] outline-none" value="{{ old('mobile', $phone) }}">
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
                                    <option value="" disabled selected>-- Select Country --</option>
                                    <option value="India">India</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">State <span class="required">*</span></label>
                            <div class="relative">
                                <select id="state" class="form-input appearance-none bg-white">
                                    <option value="" disabled selected>-- Select State --</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">City <span class="required">*</span></label>
                            <div class="relative">
                                <select id="city" class="form-input appearance-none bg-white">
                                    <option value="" disabled selected>-- Select City --</option>
                                    <option value="Mumbai">Mumbai</option>
                                    <option value="Bengaluru">Bengaluru</option>
                                    <option value="New Delhi">New Delhi</option>
                                    <option value="Ahmedabad">Ahmedabad</option>
                                    <option value="Chennai">Chennai</option>
                                    <option value="Hyderabad">Hyderabad</option>
                                    <option value="Noida">Noida</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4 (2 columns) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="form-label">Industry <span class="required">*</span></label>
                            <div class="relative">
                                <select id="industry" class="form-input appearance-none bg-white">
                                    <option value="" disabled selected>-- Select Industry --</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Education">Education</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Automotive">Automotive</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Company Size <span class="required">*</span></label>
                            <div class="relative">
                                <select id="company_size" class="form-input appearance-none bg-white">
                                    <option value="" disabled selected>-- Select Company Size --</option>
                                    <option value="51 - 200 Employees">51 - 200 Employees</option>
                                    <option value="1 - 10 Employees">1 - 10 Employees</option>
                                    <option value="11 - 50 Employees">11 - 50 Employees</option>
                                    <option value="201 - 500 Employees">201 - 500 Employees</option>
                                    <option value="501+ Employees">501+ Employees</option>
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
                    <div class="flex items-center gap-3 mb-10 mt-2 cursor-pointer select-none" id="checkbox-updates-wrapper">
                        <div id="checkbox-updates" class="w-5 h-5 rounded border border-primary-500 bg-primary-500 flex items-center justify-center text-white shrink-0 shadow-sm transition-colors">
                            <i id="checkbox-check-icon" class="ph-bold ph-check text-[14px]"></i>
                        </div>
                        <span class="text-[14px] text-[#1E293B] font-medium">Receive updates about this event and future events from eproexpo and partners.</span>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="flex items-center justify-between pb-10">
                        <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm text-[15px]">
                            <i class="ph ph-arrow-left text-lg"></i> Back
                        </a>
                        <a id="continue-to-review-btn" href="{{ route('exhibitions.tickets.summary', $slug) }}" class="flex items-center gap-2 px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-[0_4px_14px_rgba(90,50,250,0.25)] text-[15px]">
                            Continue to Review <i class="ph ph-arrow-right text-lg"></i>
                        </a>
                    </div>

                </div>

                <!-- Right: Summary Sidebar -->
                <div class="ticket-flow-sidebar w-full lg:w-[340px] shrink-0">
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] sticky top-0">
                        
                        <!-- Your Selection -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-[#1E1B4B] text-[15px]">Your Selection</h3>
                                <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="text-primary-600 font-bold text-[13px] hover:underline">Edit</a>
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
        async function initializeDetailsPage() {
            const urlParams = new URLSearchParams(window.location.search);
            let exhId = '{{ $exhibition->id }}';
            localStorage.setItem('activeExhibitionId', exhId);
            localStorage.setItem('activeExhibitionName', '{{ addslashes($title) }}');

            // Preselect active pavilion if user came from a pavilion page
            const activePav = urlParams.get('pavilion_id') || localStorage.getItem('activePavilionId');
            const pavSelect = document.getElementById('pavilion_id');
            if (activePav && pavSelect) {
                pavSelect.value = activePav;
            }

            // Populate Selection Sidebar from localStorage
            const passName = localStorage.getItem('selectedPassName') || 'Free Visitor Pass';
            const passPrice = parseFloat(localStorage.getItem('selectedPassPrice')) || 0;
            const passQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 1;
            const passSubtotal = parseFloat(localStorage.getItem('selectedPassSubtotal')) || (passPrice * passQty);
            const passDiscount = parseFloat(localStorage.getItem('selectedPassDiscount')) || 0;
            const passTotalAmount = parseFloat(localStorage.getItem('selectedPassTotalAmount')) || (passSubtotal - passDiscount);
            const appliedPromoCode = localStorage.getItem('selectedPassPromoCode') || '';
            const passPriceFormatted = localStorage.getItem('selectedPassFormattedPrice') || ('₹' + passTotalAmount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            
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
                if (discountLabel) {
                    discountLabel.innerText = `Discount (${appliedPromoCode})`;
                }
                if (discountAmountElem) {
                    discountAmountElem.innerText = `-₹` + passDiscount.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            } else if (discountRow) {
                discountRow.classList.add('hidden');
            }

            // Load previously filled values if in edit mode
            const urlParamsEdit = new URLSearchParams(window.location.search);
            const isEditMode = urlParamsEdit.get('edit') === 'true';
            const fields = ['first_name', 'last_name', 'email', 'mobile', 'job_title', 'company', 'country', 'state', 'city', 'industry', 'company_size', 'business_address', 'pavilion_id'];
            
            if (isEditMode) {
                fields.forEach(field => {
                    const el = document.getElementById(field);
                    if (el) {
                        const savedVal = localStorage.getItem(`visitor_reg_${field}`);
                        if (savedVal) {
                            el.value = savedVal;
                        }
                    }
                });
            }

            // Subscription Checkbox State
            let receiveUpdates = true;
            const savedUpdates = localStorage.getItem('visitor_reg_receive_updates');
            if (savedUpdates !== null) {
                receiveUpdates = savedUpdates === 'true';
            } else {
                localStorage.setItem('visitor_reg_receive_updates', 'true');
            }

            const cbWrapper = document.getElementById('checkbox-updates-wrapper');
            const cbBox = document.getElementById('checkbox-updates');
            const cbIcon = document.getElementById('checkbox-check-icon');

            function updateCheckboxUI() {
                if (receiveUpdates) {
                    cbBox.className = "w-5 h-5 rounded border border-primary-500 bg-primary-500 flex items-center justify-center text-white shrink-0 shadow-sm transition-colors";
                    cbIcon.classList.remove('hidden');
                } else {
                    cbBox.className = "w-5 h-5 rounded border border-gray-300 bg-white flex items-center justify-center text-transparent shrink-0 shadow-sm transition-colors";
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

            // Intercept continue click to save data
            const continueBtn = document.getElementById('continue-to-review-btn');
            if (continueBtn) {
                continueBtn.addEventListener('click', (e) => {
                    // Basic Validation
                    let valid = true;
                    fields.forEach(field => {
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
                        e.preventDefault();
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
