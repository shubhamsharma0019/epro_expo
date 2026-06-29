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

    $selectedBookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
    $visitor = null;
    if ($selectedBookingId) {
        $visitor = \App\Domain\Visitor\Models\Visitor::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('booking_id', $selectedBookingId)
            ->first();
    }
    if (!$visitor && auth()->check()) {
        $visitor = \App\Domain\Visitor\Models\Visitor::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    // Fallback: If no visitor pass found for current exhibition, search for any exhibition pass
    if (!$visitor && $selectedBookingId) {
        $visitor = \App\Domain\Visitor\Models\Visitor::query()
            ->where('booking_id', $selectedBookingId)
            ->first();
        if ($visitor && $visitor->exhibition_id != $exhibition->id) {
            $fallbackExh = \App\Domain\Event\Models\Exhibition::query()
                ->with([
                    'boothBookings' => fn ($query) => $query
                        ->with(['boothProfile', 'boothBranding', 'company'])
                        ->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->where('admin_status', 'approved')
                        ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
                ])
                ->find($visitor->exhibition_id);
            if ($fallbackExh) {
                $exhibition = $fallbackExh;
            }
        }
    }
    if (!$visitor && auth()->check()) {
        $visitor = \App\Domain\Visitor\Models\Visitor::query()
            ->where('email', auth()->user()->email)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($visitor && $visitor->exhibition_id != $exhibition->id) {
            $fallbackExh = \App\Domain\Event\Models\Exhibition::query()
                ->with([
                    'boothBookings' => fn ($query) => $query
                        ->with(['boothProfile', 'boothBranding', 'company'])
                        ->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->where('admin_status', 'approved')
                        ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live']),
                ])
                ->find($visitor->exhibition_id);
            if ($fallbackExh) {
                $exhibition = $fallbackExh;
            }
        }
    }

    if ($visitor) {
        session([
            'visitor_pass_active' => true,
            'selected_visitor_booking_id' => $visitor->booking_id,
            'activeExhibitionSlug' => $exhibition->slug,
        ]);
    }

    $showVisitorSidebar = \App\Support\ExhibitionTicketFlow::shouldShowVisitorSidebar($exhibition->slug);
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
    $location = \App\Support\LiveContent::formatExhibitionVenue($exhibition);
    $firstAgendaSession = \App\Domain\Event\Models\AgendaSession::query()
        ->where('exhibition_id', $exhibition->id)
        ->orderBy('start_time')
        ->first();
    $timeStr = $firstAgendaSession?->start_time
        ? trim($firstAgendaSession->start_time . ($firstAgendaSession->end_time ? ' - ' . $firstAgendaSession->end_time : ''))
        : 'Time TBD';

    $attendeeName = trim(($visitor?->first_name ?? '') . ' ' . ($visitor?->last_name ?? ''));
    $attendeeName = $attendeeName !== '' ? $attendeeName : '-';
    $visitorEmail = $visitor?->email ?? '-';
    $ticketType = ($visitor?->pass_type) ?: 'Free Visitor Pass';
    $bookingId = $visitor?->booking_id ?? $selectedBookingId ?? '';
    $ticketCount = $visitor ? 1 : '-';
    $ticketUrl = route('exhibitions.tickets.e-ticket', ['slug' => $exhibition->slug] + ($bookingId ? ['booking_id' => $bookingId] : []));
    $qrUrl = $bookingId ? 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($bookingId) : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - E-Ticket</title>
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
<body @class([
    'text-[#1E293B] font-sans flex h-screen overflow-hidden',
    'lg:pl-[260px]' => $showVisitorSidebar ?? false,
])>

    <!-- Sidebar Overlay for mobile -->
    @include('frontend.exhibitions.tickets.partials.visitor-sidebar-shell')

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-40 w-full relative">@include('frontend.exhibitions.tickets.header', ['hideMobileMenu' => !($showVisitorSidebar ?? false)])</div>

        <!-- Scrollable Content -->
        <div class="ticket-flow-main flex-1 overflow-y-auto px-4 py-6 sm:px-8 lg:px-12 lg:py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Content Area -->
            <div class="ticket-flow-two-col flex flex-col lg:flex-row gap-8">
                
                <!-- Left: E-Ticket Area -->
                <div class="flex-1 flex flex-col pb-10">
                    
                    <div class="mb-6">
                        <h1 class="text-[24px] font-bold text-[#1E1B4B] mb-1">Your E-Ticket</h1>
                        <p class="text-[#64748B] text-[14px] font-medium">Show this QR code at the venue entry.</p>
                    </div>

                    <!-- E-Ticket Card -->
                    <div class="relative w-full rounded-[24px] border border-gray-200 shadow-sm bg-white mb-6 flex flex-col overflow-hidden">
                        
                        <!-- Top Dark Section -->
                        <div class="bg-indigo-950 text-white p-5 sm:p-7 relative overflow-hidden min-h-[140px] h-auto flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                            <!-- Background pattern/glow -->
                            <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=800&q=80')] bg-cover bg-center mix-blend-overlay"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-950 via-indigo-900/90 to-blue-900/80"></div>
                            
                            <div class="relative z-10 w-[80px] h-[80px] sm:w-[90px] sm:h-[90px] rounded-xl bg-cover bg-center border border-indigo-700 shadow-md shrink-0" style="background-image: url('{{ $bannerImage }}');"></div>
                            
                            <div class="relative z-10 flex flex-col">
                                <h2 class="text-[18px] sm:text-[22px] font-bold mb-2 sm:mb-3 tracking-wide text-white leading-tight" data-bind="exh-name">{{ $title }}</h2>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 text-indigo-100 text-[12px] sm:text-[13px] font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph ph-calendar-blank text-[16px]"></i>
                                        <span data-bind="exh-dates">{{ $dateStr }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph ph-clock text-[16px]"></i>
                                        <span>{{ $timeStr }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 text-indigo-100 text-[12px] sm:text-[13px] font-medium mt-1.5">
                                    <i class="ph ph-map-pin text-[16px]"></i>
                                    <span data-bind="exh-venue">{{ $location }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Divider with Cutouts -->
                        <div class="relative h-[2px] w-full">
                            <div class="absolute inset-0 border-t-2 border-dashed border-gray-200 mx-8 -translate-y-1/2"></div>
                            <!-- Left Cutout -->
                            <div class="absolute left-[-1px] top-0 w-[18px] h-[36px] bg-[#FAFAFA] border border-gray-200 border-l-0 rounded-r-full z-20 -translate-y-1/2"></div>
                            <!-- Right Cutout -->
                            <div class="absolute right-[-1px] top-0 w-[18px] h-[36px] bg-[#FAFAFA] border border-gray-200 border-r-0 rounded-l-full z-20 -translate-y-1/2"></div>
                        </div>

                        <!-- Bottom White Section -->
                        <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between bg-white relative z-10 gap-6 md:gap-0">
                            
                            <!-- Left Info -->
                            <div class="flex flex-col gap-4 md:gap-6">
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Attendee Name</div>
                                    <div class="text-[18px] md:text-[20px] font-bold text-[#1E1B4B]" id="display-name">{{ $attendeeName }}</div>
                                </div>
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Ticket Type</div>
                                    <div class="text-[16px] md:text-[18px] font-bold text-[#1E293B]" id="display-ticket-type">{{ $ticketType }}</div>
                                </div>
                                <div>
                                    <div class="text-[13px] text-gray-500 font-medium mb-1">Booking ID</div>
                                    <div class="text-[16px] md:text-[18px] font-bold text-[#1E293B]" data-bind="booking-id">{{ $bookingId ?: '-' }}</div>
                                </div>
                            </div>

                            <!-- Right QR -->
                            <div class="flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-gray-100 pt-6 md:pt-0 md:pl-12 md:pr-6">
                                <div class="w-[160px] h-[160px] bg-white border border-gray-200 rounded-2xl p-3 mb-4 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                    <img id="ticket-qr" src="{{ $qrUrl }}" alt="QR Code" class="w-full h-full object-contain">
                                </div>
                                <div class="text-[14px] font-bold text-[#1E1B4B] mb-2">Scan at entry point</div>
                                <button id="download-qr-btn" class="flex items-center gap-1.5 text-primary-600 font-bold text-[13px] hover:underline">
                                    <i class="ph ph-download-simple text-[16px]"></i> Download QR Code
                                </button>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Info Row -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-4 md:p-5 grid grid-cols-2 gap-4 md:flex md:items-center md:justify-between mb-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center border border-primary-100 shrink-0">
                                <i class="ph ph-user-focus text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider leading-none">Ticket Count</div>
                                <div class="text-[14px] font-bold text-[#1E293B] mt-0.5">{{ $ticketCount }}</div>
                            </div>
                        </div>
                        <div class="hidden md:block w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0">
                                <i class="ph ph-calendar-blank text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider leading-none">Date</div>
                                <div class="text-[14px] font-bold text-[#1E293B] mt-0.5" data-bind="exh-dates">{{ $dateStr }}</div>
                            </div>
                        </div>
                        <div class="hidden md:block w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shrink-0">
                                <i class="ph ph-clock text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider leading-none">Time</div>
                                <div class="text-[14px] font-bold text-[#1E293B] mt-0.5">{{ $timeStr }}</div>
                            </div>
                        </div>
                        <div class="hidden md:block w-px h-10 bg-gray-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shrink-0">
                                <i class="ph ph-ticket text-[20px]"></i>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-500 font-semibold mb-0.5 uppercase tracking-wider leading-none">Ticket Type</div>
                                <div class="text-[14px] font-bold text-[#1E293B] mt-0.5" id="display-ticket-type2">{{ $ticketType }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Enter Lobby Button -->
                    <div class="mb-6">
                        <a href="{{ route('exhibitions.visit', $slug) }}" id="enter-lobby-btn" class="w-full bg-gradient-to-r from-primary-500 to-primary-700 hover:from-primary-600 hover:to-primary-700 text-white py-4 rounded-xl font-bold shadow-[0_4px_20px_rgba(90,50,250,0.3)] transition-all text-[16px] flex items-center justify-center gap-2 cursor-pointer">
                            <i class="ph ph-monitor-play text-[22px]"></i> Enter Exhibition Lobby
                        </a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-8">
                        <button id="add-to-wallet-btn" data-ticket-url="{{ $ticketUrl }}" data-ticket-title="{{ $title }}" data-ticket-date="{{ $dateStr }}" data-ticket-location="{{ $location }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] flex items-center justify-center gap-2">
                            <i class="ph ph-wallet text-[20px]"></i> Add to Wallet
                        </button>
                        <button id="print-ticket-btn" class="flex-1 border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-3.5 rounded-xl font-bold transition-all text-[15px] flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-printer text-[20px]"></i> Print E-Ticket
                        </button>
                        <button id="share-ticket-btn" data-ticket-url="{{ $ticketUrl }}" class="flex-1 border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-3.5 rounded-xl font-bold transition-all text-[15px] flex items-center justify-center gap-2 shadow-sm">
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
                                <div class="text-[13px] text-[#166534] font-medium">A confirmation email has been sent to <span id="display-confirm-email">{{ $visitorEmail }}</span></div>
                            </div>
                        </div>
                        <a id="resend-email-btn" href="{{ $visitor && $visitor->email ? 'mailto:' . $visitor->email . '?subject=' . rawurlencode('Your E-Ticket for ' . $title) : '#' }}" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-5 py-2.5 rounded-xl font-bold text-[13px] transition-colors flex items-center gap-2 shadow-sm">
                            <i class="ph ph-envelope-simple text-[16px]"></i> Resend Email
                        </a>
                    </div>

                </div>

                <!-- Right: Sidebars (Event, Booking, Instructions) -->
                <div class="ticket-flow-sidebar w-full lg:w-[340px] shrink-0 flex flex-col gap-6">
                    
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
                                <span class="font-bold text-[#1E293B]" data-bind="booking-id">{{ $bookingId ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Attendee Name</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-name">{{ $attendeeName }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Email</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-email">{{ $visitorEmail }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                <span class="text-gray-500 font-medium">Ticket Type</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-display-ticket-type">{{ $ticketType }}</span>
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
            let bookingId = urlParams.get('booking_id') || @json($bookingId) || localStorage.getItem('lastBookingId') || '';
            const shareBtn = document.getElementById('share-ticket-btn');
            const printBtn = document.getElementById('print-ticket-btn');
            const walletBtn = document.getElementById('add-to-wallet-btn');

            if (printBtn) {
                printBtn.addEventListener('click', () => window.print());
            }

            if (shareBtn) {
                shareBtn.addEventListener('click', async () => {
                    const shareUrl = shareBtn.dataset.ticketUrl || window.location.href;
                    const shareData = {
                        title: 'E-Ticket',
                        text: 'Here is your exhibition e-ticket.',
                        url: shareUrl,
                    };

                    if (navigator.share) {
                        try {
                            await navigator.share(shareData);
                            return;
                        } catch (error) {
                            // Fall back to clipboard copy below.
                        }
                    }

                    try {
                        await navigator.clipboard.writeText(shareUrl);
                        alert('E-ticket link copied.');
                    } catch (error) {
                        window.prompt('Copy your e-ticket link:', shareUrl);
                    }
                });
            }

            if (walletBtn) {
                walletBtn.addEventListener('click', () => {
                    const ticketUrl = walletBtn.dataset.ticketUrl || window.location.href;
                    const title = walletBtn.dataset.ticketTitle || 'Exhibition E-Ticket';
                    const details = [
                        `Ticket: ${title}`,
                        `Booking ID: ${bookingId || 'N/A'}`,
                        `Date: ${walletBtn.dataset.ticketDate || 'TBD'}`,
                        `Venue: ${walletBtn.dataset.ticketLocation || 'TBD'}`,
                        `E-Ticket: ${ticketUrl}`,
                    ].join('\n');
                    const walletFile = new Blob([details], { type: 'text/plain;charset=utf-8' });
                    const walletUrl = URL.createObjectURL(walletFile);
                    const link = document.createElement('a');
                    link.href = walletUrl;
                    link.download = `${(bookingId || 'ticket').replace(/[^a-z0-9-_]/gi, '_')}-wallet.txt`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(walletUrl);
                });
            }

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

                const resendEmailBtn = document.getElementById('resend-email-btn');
                if (resendEmailBtn && visitor.email) {
                    resendEmailBtn.href = `mailto:${visitor.email}?subject=${encodeURIComponent('Your E-Ticket for {{ $title }}')}`;
                }
                
                // Update Enter Lobby Button href with booking_id
                const lobbyBtn = document.getElementById('enter-lobby-btn');
                if (lobbyBtn) {
                    try {
                        const currentUrl = new URL(lobbyBtn.href, window.location.origin);
                        currentUrl.searchParams.set('booking_id', visitor.booking_id);
                        lobbyBtn.href = currentUrl.toString();
                    } catch (e) {
                        console.error('Error updating lobby link:', e);
                    }
                }

                // Add Download QR functionality
                const dlBtn = document.getElementById('download-qr-btn');
                if (dlBtn) {
                    dlBtn.addEventListener('click', () => {
                        window.open(`https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${visitor.booking_id}`, '_blank');
                    });
                }

                if (shareBtn) {
                    const shareUrl = new URL(shareBtn.dataset.ticketUrl || window.location.href, window.location.origin);
                    shareUrl.searchParams.set('booking_id', visitor.booking_id);
                    shareBtn.dataset.ticketUrl = shareUrl.toString();
                }
            }
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
