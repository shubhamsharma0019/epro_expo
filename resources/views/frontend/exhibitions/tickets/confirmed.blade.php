@php
    $title = $title ?? 'Exhibition';
    $bannerImage = $bannerImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $dateStr = $dateStr ?? 'Date TBD';
    $location = $location ?? 'Virtual';
    $bookingId = $bookingId ?? null;
    $qrCodeUrl = $qrCodeUrl ?? null;
    $eTicketUrl = $eTicketUrl ?? route('exhibitions.tickets.e-ticket', $slug ?? '');
    $dashboardUrl = $dashboardUrl ?? '#';
    $confirmedUrl = $confirmedUrl ?? '#';
    $nextSteps = $nextSteps ?? [];
    $actionButtons = $actionButtons ?? [];
    $showVisitorSidebar = false;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Registration Successful - EproExpo</title>
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

        /* Confetti Animation Elements */
        .confetti {
            position: absolute;
            border-radius: 50%;
        }
        .confetti-square {
            position: absolute;
            transform: rotate(45deg);
        }
        .confetti-triangle {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 10px solid currentColor;
            transform: rotate(30deg);
        }
    </style>
    @include('frontend.exhibitions.visitor.partials.ticket-responsive')
</head>
<body class="text-[#1E293B] font-sans flex min-h-screen flex-col lg:h-screen lg:overflow-hidden">

    <!-- Main Content Area -->
    <main class="flex min-h-0 flex-1 flex-col bg-white lg:h-screen lg:overflow-hidden">
        
        <!-- Header Container -->
        <div id="header-container" class="relative z-40 w-full shrink-0">@include('frontend.exhibitions.tickets.header', ['hideMobileMenu' => true])</div>

        <!-- Scrollable Content -->
        <div class="ticket-flow-main flex-1 overflow-y-auto px-4 py-6 sm:px-8 lg:px-12 lg:py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <!-- Content Area -->
            <div class="ticket-flow-two-col flex flex-col gap-6 lg:flex-row lg:gap-8">
                
                <!-- Left: Main Success Area -->
                <div class="flex flex-1 flex-col pb-10">
                    
                    <!-- Success Header -->
                    <div class="flex flex-col items-center text-center mb-8 relative pt-4">
                        
                        <!-- Decorative Confetti -->
                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <div class="confetti w-2 h-2 bg-blue-500 top-10 left-[20%]"></div>
                            <div class="confetti w-3 h-3 bg-green-400 top-[60%] left-[15%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-yellow-400 top-4 left-[35%]"></div>
                            <div class="confetti-triangle text-purple-500 top-16 left-[28%]"></div>
                            
                            <div class="confetti w-2 h-2 bg-red-400 top-8 right-[25%]"></div>
                            <div class="confetti w-3 h-3 bg-blue-400 top-[60%] right-[15%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-green-500 top-20 right-[35%]"></div>
                            <div class="confetti-triangle text-yellow-500 top-12 right-[10%]"></div>
                        </div>

                        <!-- Checkmark Icon -->
                        <div class="w-16 h-16 rounded-full bg-[#16A34A] flex items-center justify-center text-white text-[32px] mb-6 relative z-10 shadow-[0_8px_20px_rgba(22,163,74,0.3)]">
                            <i class="ph-bold ph-check"></i>
                        </div>
                        
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3 relative z-10">Registration Successful!</h1>
                        <p class="text-[#475569] text-[16px] font-medium mb-2 relative z-10">Thank you for registering for</p>
                        <h2 class="text-[26px] font-bold text-primary-600 mb-6 relative z-10 tracking-tight" data-bind="exh-name">{{ $title }}</h2>
                        <p class="text-[#475569] text-[15px] font-medium relative z-10">Your booking is confirmed.</p>
                    </div>

                    <!-- Booking ID Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-8 max-w-lg w-full mx-auto text-center mb-10 shadow-sm">
                        <div class="text-[#64748B] text-[14px] font-semibold mb-2">Booking ID</div>
                        <div class="text-[24px] font-bold text-[#1E1B4B] mb-5 tracking-wide" data-bind="booking-id">{{ $visitor?->booking_id ?? ($bookingId ?: '-') }}</div>
                        <div class="text-[14px] text-[#475569]">
                            A confirmation email has been sent to<br>
                            <span class="font-bold text-[#1E293B]" id="success-email">{{ $visitor?->email ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- What's Next Section -->
                    <div class="mb-10">
                        <h3 class="text-center text-[#475569] text-[14px] font-semibold mb-6">What's Next?</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($nextSteps as $step)
                                @if ($step['url'])
                                    <a href="{{ $step['url'] }}" @if ($step['target']) target="{{ $step['target'] }}" @endif class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                @else
                                    <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                @endif
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4 border {{ $step['icon_wrap_class'] }}">
                                        <i class="{{ $step['icon'] }} text-[24px]"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">{{ $step['title'] }}</h4>
                                    <p class="text-[12px] text-[#64748B] leading-relaxed" @if ($step['description_id']) id="{{ $step['description_id'] }}" @endif>{{ $step['description'] }}</p>
                                @if ($step['url'])
                                    </a>
                                @else
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mb-12 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
                        @foreach ($actionButtons as $button)
                            @if (($button['type'] ?? 'link') === 'button')
                                <button id="{{ $button['id'] }}" type="button" class="{{ $button['class'] }}">
                                    <i class="{{ $button['icon'] }}"></i> {{ $button['label'] }}
                                </button>
                            @elseif (! empty($button['url']))
                                <a href="{{ $button['url'] }}" class="{{ $button['class'] }}">
                                    <i class="{{ $button['icon'] }}"></i> {{ $button['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>

                <!-- Right: Ticket & Summary Sidebar -->
                <div class="ticket-flow-sidebar flex w-full shrink-0 flex-col gap-6 lg:w-[340px]">
                    
                    <!-- Your E-Ticket -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col items-center">
                        <div class="w-full text-left mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Your E-Ticket</h3>
                            <p class="text-[12px] text-gray-500 font-medium">Show this QR code at the venue entry.</p>
                        </div>
                        
                        <!-- Event Banner embedded in ticket -->
                        <div class="w-full rounded-xl bg-indigo-900 text-white p-4 mb-6 relative overflow-hidden shadow-md" style="background-image: linear-gradient(rgba(30, 27, 75, 0.4), rgba(30, 27, 75, 0.95)), url('{{ $bannerImage }}'); background-size: cover; background-position: center;">
                            <!-- Abstract background lines for event card -->
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] mix-blend-overlay"></div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-[14px] mb-2 tracking-wide uppercase" data-bind="exh-name">{{ $title }}</h4>
                                <p class="text-[11px] text-indigo-100 mb-1 font-medium" data-bind="exh-dates">{{ $dateStr }}</p>
                                <p class="text-[11px] text-indigo-200 leading-tight" data-bind="exh-venue">{{ $location }}</p>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="mb-3 h-36 w-36 rounded-xl border border-gray-200 bg-white p-2 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                            <img id="success-qr" src="{{ $qrCodeUrl ?? '' }}" alt="QR Code for {{ $visitor?->booking_id ?? 'ticket' }}" class="h-full w-full object-contain">
                        </div>
                        <p class="text-[#475569] text-[13px] font-semibold">Scan at entry point</p>
                    </div>

                    <!-- Booking Details Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Booking Details</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Booking ID</span>
                                <span class="font-bold text-[#1E293B]" data-bind="booking-id">{{ $visitor?->booking_id ?? ($bookingId ?: '-') }}</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Event</span>
                                <span class="font-medium text-[#1E293B] text-right" data-bind="exh-name">{{ $title }}</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Date</span>
                                <span class="font-medium text-[#1E293B] text-right" data-bind="exh-dates">{{ $dateStr }}</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Venue</span>
                                <span class="font-medium text-[#1E293B] text-right w-[150px] leading-relaxed" data-bind="exh-venue">{{ $location }}</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px] pt-4 border-t border-gray-100">
                                <span class="text-gray-500 font-medium">Ticket Type</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-ticket-type">{{ $visitor?->pass_type ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-start text-[13px]">
                                <span class="text-gray-500 font-medium">Ticket Count</span>
                                <span class="font-bold text-[#1E293B]" id="sidebar-ticket-count">-</span>
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
        async function initializeSuccessPage() {
            const urlParams = new URLSearchParams(window.location.search);
            let bookingId = urlParams.get('booking_id') || @json($bookingId) || localStorage.getItem('lastBookingId') || '';
            const exhId = '{{ $exhibition->id }}';

            if (bookingId) {
                localStorage.setItem('lastBookingId', bookingId);
                localStorage.setItem('selected_visitor_booking_id', bookingId);
                localStorage.setItem('activeExhibitionId', exhId);
                localStorage.setItem('activeExhibitionSlug', '{{ $slug }}');
                localStorage.setItem('activeExhibitionName', @json($title));
            }

            const passQty = parseInt(localStorage.getItem('selectedPassQuantity')) || 1;
            const ticketCountElem = document.getElementById('sidebar-ticket-count');
            if (ticketCountElem) ticketCountElem.textContent = passQty;

            @if ($visitor)
            const visitor = @json($visitor);
            @else
            const visitor = bookingId ? await ExhibitionAPI.getTicketDetails(bookingId) : null;
            @endif

            if (visitor) {
                bookingId = visitor.booking_id || bookingId;

                const bIdElems = document.querySelectorAll('[data-bind="booking-id"]');
                bIdElems.forEach(el => el.textContent = visitor.booking_id);

                const emailElem = document.getElementById('success-email');
                if (emailElem) emailElem.textContent = visitor.email;

                const nextEmailCopy = document.getElementById('next-email-copy');
                if (nextEmailCopy && visitor.email) {
                    nextEmailCopy.textContent = `Your e-ticket and event details have been sent to ${visitor.email}.`;
                }

                const qrImg = document.getElementById('success-qr');
                if (qrImg && visitor.booking_id) {
                    qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(visitor.booking_id)}`;
                }

                const ticketTypeElem = document.getElementById('sidebar-ticket-type');
                if (ticketTypeElem) ticketTypeElem.textContent = visitor.pass_type || 'Free Visitor Pass';

                const ticketBtn = document.querySelector('.btn-e-ticket');
                if (ticketBtn) {
                    ticketBtn.href = `{{ route('exhibitions.tickets.e-ticket', $slug) }}?booking_id=${encodeURIComponent(visitor.booking_id)}&id=${exhId}`;
                }
            }

            const shareBtn = document.getElementById('share-registration-btn');
            if (shareBtn) {
                shareBtn.addEventListener('click', async () => {
                    const shareUrl = bookingId
                        ? `{{ $confirmedUrl }}?booking_id=${encodeURIComponent(bookingId)}&id=${exhId}`
                        : window.location.href;
                    const shareData = {
                        title: @json($title . ' Registration'),
                        text: `Registration confirmed for ${@json($title)}${bookingId ? ' - Booking ID: ' + bookingId : ''}`,
                        url: shareUrl,
                    };

                    if (navigator.share) {
                        await navigator.share(shareData);
                    } else if (navigator.clipboard) {
                        await navigator.clipboard.writeText(shareUrl);
                        shareBtn.textContent = 'Link Copied';
                    }
                });
            }
        }

        if (document.readyState !== 'loading') {
            initializeSuccessPage();
        } else {
            document.addEventListener('DOMContentLoaded', initializeSuccessPage);
        }
    </script>
</body>
</html>
