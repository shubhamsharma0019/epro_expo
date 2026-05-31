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
    <title>EproExpo - E-Ticket</title>
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

            <!-- Content Area -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left: E-Ticket Area -->
                <div class="flex-1 flex flex-col pb-10">
                    
                    <div class="mb-6">
                        <h1 class="text-[24px] font-bold text-[#1E1B4B] mb-1">Your E-Ticket</h1>
                        <p class="text-[#64748B] text-[14px] font-medium">Show this QR code at the venue entry.</p>
                    </div>

                    <!-- E-Ticket Card -->
                    <div class="relative w-full rounded-[24px] border border-gray-200 shadow-sm bg-white mb-6 flex flex-col overflow-hidden">
                        
                        <!-- Left Cutout -->
                        <div class="absolute left-[-1px] top-[140px] w-[18px] h-[36px] bg-white border border-gray-200 border-l-0 rounded-r-full z-20 -translate-y-1/2"></div>
                        <!-- Right Cutout -->
                        <div class="absolute right-[-1px] top-[140px] w-[18px] h-[36px] bg-white border border-gray-200 border-r-0 rounded-l-full z-20 -translate-y-1/2"></div>
                        
                        <!-- Top Dark Section -->
                        <div class="bg-indigo-950 text-white p-7 relative overflow-hidden h-[140px] flex items-center gap-6">
                            <!-- Background pattern/glow -->
                            <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=800&q=80')] bg-cover bg-center mix-blend-overlay"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-950 via-indigo-900/90 to-blue-900/80"></div>
                            
                            <div class="relative z-10 w-[90px] h-[90px] rounded-xl bg-cover bg-center border border-indigo-700 shadow-md" style="background-image: url('{{ $bannerImage }}');"></div>
                            
                            <div class="relative z-10 flex flex-col">
                                <h2 class="text-[22px] font-bold mb-3 tracking-wide text-white" data-bind="exh-name">{{ $title }}</h2>
                                <div class="flex items-center gap-5 text-indigo-100 text-[13px] font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph ph-calendar-blank text-[16px]"></i>
                                        <span data-bind="exh-dates">{{ $dateStr }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph ph-clock text-[16px]"></i>
                                        <span>09:00 AM – 06:00 PM (IST)</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 text-indigo-100 text-[13px] font-medium mt-1.5">
                                    <i class="ph ph-map-pin text-[16px]"></i>
                                    <span data-bind="exh-venue">{{ $location }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="relative h-[2px] w-full">
                            <div class="absolute inset-0 border-t-2 border-dashed border-gray-200 mx-8 -translate-y-1/2"></div>
                        </div>

                        <!-- Bottom White Section -->
                        <div class="p-8 flex items-center justify-between bg-white relative z-10">
                            
                            <!-- Left Info -->
                            <div class="flex flex-col gap-6">
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Attendee Name</div>
                                    <div class="text-[20px] font-bold text-[#1E1B4B]" id="display-name">-</div>
                                </div>
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Ticket Type</div>
                                    <div class="text-[18px] font-bold text-[#1E293B]" id="display-ticket-type">-</div>
                                </div>
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Booking ID</div>
                                    <div class="text-[18px] font-bold text-[#1E293B]" data-bind="booking-id">-</div>
                                </div>
                            </div>

                            <!-- Right QR -->
                            <div class="flex flex-col items-center justify-center border-l border-gray-100 pl-12 pr-6">
                                <div class="w-[160px] h-[160px] bg-white border border-gray-200 rounded-2xl p-3 mb-4 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                    <img id="ticket-qr" src="" alt="QR Code" class="w-full h-full object-contain">
                                </div>
                                <div class="text-[14px] font-bold text-[#1E1B4B] mb-2">Scan at entry point</div>
                                <button id="download-qr-btn" class="flex items-center gap-1.5 text-primary-600 font-bold text-[13px] hover:underline">
                                    <i class="ph ph-download-simple text-[16px]"></i> Download QR Code
                                </button>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Info Row -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 flex items-center justify-between mb-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center border border-primary-100">
                                <i class="ph ph-user-focus text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Ticket Count</div>
                                <div class="text-[14px] font-bold text-[#1E293B]">1</div>
                            </div>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                                <i class="ph ph-calendar-blank text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Date</div>
                                <div class="text-[14px] font-bold text-[#1E293B]" data-bind="exh-dates">{{ $dateStr }}</div>
                            </div>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                                <i class="ph ph-clock text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Time</div>
                                <div class="text-[14px] font-bold text-[#1E293B]">09:00 AM – 06:00 PM (IST)</div>
                            </div>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3 pr-4">
                            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                                <i class="ph ph-ticket text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider">Ticket Type</div>
                                <div class="text-[14px] font-bold text-[#1E293B]" id="display-ticket-type2">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mb-8">
                        <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] flex items-center justify-center gap-2">
                            <i class="ph ph-wallet text-[20px]"></i> Add to Wallet
                        </button>
                        <button class="flex-1 border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-3.5 rounded-xl font-bold transition-all text-[15px] flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-printer text-[20px]"></i> Print E-Ticket
                        </button>
                        <button class="flex-1 border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-3.5 rounded-xl font-bold transition-all text-[15px] flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-export text-[20px]"></i> Share E-Ticket
                        </button>
                    </div>

                    <!-- Alert Box -->
                    <div class="border border-green-200 rounded-2xl bg-[#F0FDF4] p-5 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#16A34A] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="ph-fill ph-shield-check text-[20px]"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[#14532D] text-[15px] mb-0.5">Registration Confirmed!</div>
                                <div class="text-[13px] text-[#166534] font-medium">A confirmation email has been sent to <span id="display-confirm-email">-</span></div>
                            </div>
                        </div>
                        <a href="#" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-5 py-2.5 rounded-xl font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            <i class="ph ph-envelope-simple text-[16px]"></i> Resend Email
                        </a>
                    </div>

                </div>

                <!-- Right: Sidebars (Event, Booking, Instructions) -->
                <div class="w-full lg:w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Event Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Event Details</h3>
                        <div class="flex gap-4">
                            <div id="sidebar-exh-image" class="w-[70px] h-[70px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('{{ $bannerImage }}');"></div>
                            <div class="flex flex-col">
                                <div class="font-bold text-[#1E1B4B] text-[13px] mb-1.5" data-bind="exh-name">{{ $title }}</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-calendar-blank text-[14px]"></i>
                                    <span data-bind="exh-dates">{{ $dateStr }}</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-snug">
                                    <i class="ph ph-map-pin text-[14px] mt-0.5"></i>
                                    <span data-bind="exh-venue">{{ $location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Booking Details</h3>
                        
                        <div class="space-y-4 text-[13px]">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Booking ID</span>
                                <span class="font-bold text-[#1E293B]" data-bind="booking-id">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Attendee Name</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-name">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Email</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-email">-</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                <span class="text-gray-500 font-medium">Ticket Type</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-ticket-type">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Ticket Count</span>
                                <span class="font-bold text-[#1E293B]">1</span>
                            </div>
                        </div>
                    </div>

                    <!-- Important Instructions Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Important Instructions</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 border border-indigo-100 mt-0.5">
                                    <i class="ph ph-scan text-[14px]"></i>
                                </div>
                                <p class="text-[13px] text-gray-600 font-medium leading-relaxed">Show the QR code at the venue entry.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 border border-indigo-100 mt-0.5">
                                    <i class="ph ph-ticket text-[14px]"></i>
                                </div>
                                <p class="text-[13px] text-gray-600 font-medium leading-relaxed">Each ticket is valid for one entry only.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 border border-indigo-100 mt-0.5">
                                    <i class="ph ph-identification-card text-[14px]"></i>
                                </div>
                                <p class="text-[13px] text-gray-600 font-medium leading-relaxed">Please carry a valid photo ID.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 border border-indigo-100 mt-0.5">
                                    <i class="ph ph-prohibit text-[14px]"></i>
                                </div>
                                <p class="text-[13px] text-gray-600 font-medium leading-relaxed">Tickets are non-transferable and non-refundable.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 border border-indigo-100 mt-0.5">
                                    <i class="ph ph-headset text-[14px]"></i>
                                </div>
                                <p class="text-[13px] text-gray-600 font-medium leading-relaxed">For any support, contact our help desk.</p>
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
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            let bookingId = urlParams.get('booking_id') || localStorage.getItem('lastBookingId') || '';

            if (!bookingId) {
                return;
            }

            // Fetch details from backend via helper
            const visitor = await ExhibitionAPI.getTicketDetails(bookingId);

            if (visitor) {
                // Populate Booking IDs
                const bIdElems = document.querySelectorAll('[data-bind="booking-id"]');
                bIdElems.forEach(el => el.textContent = visitor.booking_id);

                // Populate Attendee Name
                const fullName = `${visitor.first_name} ${visitor.last_name}`;
                document.getElementById('display-name').textContent = fullName;
                document.getElementById('sidebar-display-name').textContent = fullName;

                // Populate Email
                document.getElementById('sidebar-display-email').textContent = visitor.email;
                document.getElementById('display-confirm-email').textContent = visitor.email;

                // Populate Ticket Type
                document.getElementById('display-ticket-type').textContent = visitor.pass_type || 'Free Visitor Pass';
                document.getElementById('display-ticket-type2').textContent = visitor.pass_type || 'Free Visitor Pass';
                document.getElementById('sidebar-display-ticket-type').textContent = visitor.pass_type || 'Free Visitor Pass';

                // Update QR Code image
                const qrImg = document.getElementById('ticket-qr');
                if (qrImg) {
                    qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${visitor.booking_id}`;
                }
                
                // Add Download QR functionality
                const dlBtn = document.getElementById('download-qr-btn');
                if (dlBtn) {
                    dlBtn.addEventListener('click', () => {
                        window.open(`https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${visitor.booking_id}`, '_blank');
                    });
                }
            }
        });
    </script>
</body>
</html>
