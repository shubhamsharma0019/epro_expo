<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Ticket Sent</title>
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

        /* Confetti Animation Elements */
        .confetti { position: absolute; border-radius: 50%; }
        .confetti-square { position: absolute; transform: rotate(45deg); }
        .confetti-triangle {
            position: absolute; width: 0; height: 0;
            border-left: 5px solid transparent; border-right: 5px solid transparent;
            border-bottom: 10px solid currentColor; transform: rotate(30deg);
        }
        
        /* CSS Envelope */
        .envelope-wrapper { position: relative; width: 120px; height: 110px; z-index: 10; margin-bottom: 1rem; }
        .envelope-back { position: absolute; bottom: 0; width: 120px; height: 80px; background-color: #4A22E0; border-radius: 8px; }
        .envelope-card { position: absolute; bottom: 35px; left: 15px; width: 90px; height: 90px; background-color: #FFFFFF; border-radius: 8px 8px 0 0; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; }
        .envelope-front-left { position: absolute; bottom: 0; left: 0; width: 60px; height: 80px; background-color: #5A32FA; border-radius: 0 0 0 8px; clip-path: polygon(0 0, 100% 50%, 0 100%); }
        .envelope-front-right { position: absolute; bottom: 0; right: 0; width: 60px; height: 80px; background-color: #5A32FA; border-radius: 0 0 8px 0; clip-path: polygon(100% 0, 0 50%, 100% 100%); }
        .envelope-front-bottom { position: absolute; bottom: 0; width: 120px; height: 50px; background-color: #6D48FF; border-radius: 0 0 8px 8px; clip-path: polygon(0 100%, 50% 0, 100% 100%); }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="e-ticket.html" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to E-Ticket
            </a>

            <!-- Content Area -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left: Main Area -->
                <div class="flex-1 flex flex-col pb-10">
                    
                    <!-- Header with Envelope -->
                    <div class="flex flex-col items-center text-center mb-8 relative pt-4">
                        
                        <!-- Decorative Confetti -->
                        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                            <div class="confetti w-2 h-2 bg-blue-500 top-10 left-[25%]"></div>
                            <div class="confetti w-3 h-3 bg-green-400 top-[60%] left-[20%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-yellow-400 top-4 left-[35%]"></div>
                            <div class="confetti-triangle text-purple-500 top-16 left-[28%]"></div>
                            
                            <!-- Little paper plane icon -->
                            <i class="ph-fill ph-paper-plane-right absolute text-indigo-300 text-2xl top-10 right-[30%] rotate-12"></i>
                            
                            <div class="confetti w-2 h-2 bg-red-400 top-8 right-[25%]"></div>
                            <div class="confetti w-3 h-3 bg-blue-400 top-[60%] right-[20%]"></div>
                            <div class="confetti-square w-2.5 h-2.5 bg-green-500 top-20 right-[35%]"></div>
                            <div class="confetti-triangle text-yellow-500 top-12 right-[15%]"></div>
                        </div>

                        <!-- CSS Envelope Graphic -->
                        <div class="envelope-wrapper">
                            <div class="envelope-back"></div>
                            <div class="envelope-card">
                                <div class="w-10 h-10 rounded-full bg-[#16A34A] flex items-center justify-center text-white text-[20px] shadow-sm">
                                    <i class="ph-bold ph-check"></i>
                                </div>
                            </div>
                            <div class="envelope-front-left"></div>
                            <div class="envelope-front-right"></div>
                            <div class="envelope-front-bottom"></div>
                        </div>
                        
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3 relative z-10">Your Ticket Has Been Sent!</h1>
                        <p class="text-[#475569] text-[16px] font-medium mb-2 relative z-10">Thank you for registering for</p>
                        <h2 id="success-exh-name" class="text-[26px] font-bold text-primary-600 mb-4 relative z-10 tracking-tight">Global Tech Summit 2024</h2>
                        <p class="text-[#475569] text-[15px] font-medium relative z-10">Your e-ticket has been successfully sent to</p>
                    </div>

                    <!-- Email Confirmation Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-6 max-w-md w-full mx-auto flex items-center gap-5 mb-10 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-100">
                            <i class="ph ph-hourglass-high text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <div id="success-email" class="font-bold text-[#1E1B4B] text-[16px] mb-1">john.doe@email.com</div>
                            <div class="text-[13px] text-[#64748B] leading-relaxed">Check your inbox for your e-ticket and event details.</div>
                        </div>
                    </div>

                    <!-- What's Next Section -->
                    <div class="mb-10">
                        <h3 class="text-center text-[#475569] text-[14px] font-semibold mb-6">What's Next?</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <!-- Card 1 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 mb-4 border border-primary-100">
                                    <i class="ph ph-ticket text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">View E-Ticket</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Access your e-ticket anytime from your dashboard.</p>
                            </div>
                            
                            <!-- Card 2 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 mb-4 border border-green-100">
                                    <i class="ph ph-calendar-plus text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Add to Calendar</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Save the event dates to your calendar.</p>
                            </div>
                            
                            <!-- Card 3 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-4 border border-blue-100">
                                    <i class="ph ph-map-pin text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Plan Your Visit</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Explore agenda, speakers and venue details.</p>
                            </div>
                            
                            <!-- Card 4 -->
                            <div class="border border-gray-100 rounded-xl p-5 bg-white text-center shadow-sm flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 mb-4 border border-orange-100">
                                    <i class="ph ph-share-network text-[24px]"></i>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Share with Others</h4>
                                <p class="text-[12px] text-[#64748B] leading-relaxed">Invite your colleagues and community.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex items-center justify-center mb-12">
                        <a href="my-tickets.html" class="bg-primary-600 hover:bg-primary-700 text-white px-10 py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px] flex items-center gap-2">
                            <i class="ph ph-squares-four text-lg"></i> Go to My Dashboard
                        </a>
                    </div>

                    <!-- Need Help Banner -->
                    <div class="border border-green-200 rounded-2xl bg-[#F0FDF4] p-5 flex items-center justify-between mt-auto shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#16A34A] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="ph-fill ph-shield-check text-[20px]"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[#14532D] text-[15px] mb-1">Need help?</div>
                                <div class="text-[13px] text-[#166534] font-medium">If you have any questions, contact our support team.</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 pr-2">
                            <a href="mailto:support@eproexpo.com" class="flex items-center gap-2 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-envelope-simple text-[18px]"></i> support@eproexpo.com
                            </a>
                            <div class="w-px h-5 bg-green-200"></div>
                            <a href="tel:+919876543210" class="flex items-center gap-2 text-primary-600 font-bold text-[13px] hover:underline">
                                <i class="ph ph-phone text-[18px]"></i> +91 98765 43210
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Right: Sidebars -->
                <div class="w-full lg:w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Your Ticket For Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Your Ticket for</h3>
                        <div class="flex gap-4">
                            <div id="sidebar-exh-image" class="w-[70px] h-[70px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                            <div class="flex flex-col">
                                <div id="sidebar-exh-name" class="font-bold text-[#1E1B4B] text-[13px] mb-1.5">Global Tech Summit 2024</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] mb-1.5 font-medium">
                                    <i class="ph ph-calendar-blank text-[14px]"></i>
                                    <span id="sidebar-exh-dates">May 15 – May 17, 2024</span>
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-snug">
                                    <i class="ph ph-map-pin text-[14px] mt-0.5"></i>
                                    <span id="sidebar-exh-venue">Jio World Convention Centre, Mumbai, India</span>
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
                                <span id="sidebar-booking-id" class="font-bold text-[#1E293B]">GTS-240515-000123</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Attendee Name</span>
                                <span id="sidebar-name" class="font-bold text-[#1E293B]">John Doe</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Email</span>
                                <span id="sidebar-email" class="font-bold text-[#1E293B]">john.doe@email.com</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                <span class="text-gray-500 font-medium">Ticket Type</span>
                                <span id="sidebar-pass-type" class="font-bold text-[#1E293B]">Free Visitor Pass</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Ticket Count</span>
                                <span class="font-bold text-[#1E293B]">1</span>
                            </div>
                        </div>
                    </div>

                    <!-- Can't find the email Box -->
                    <div class="border border-indigo-100 rounded-2xl bg-indigo-50/50 p-6 shadow-sm text-center">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2 text-left">Can't find the email?</h3>
                        <p class="text-[13px] text-[#475569] font-medium leading-relaxed text-left mb-5">Check your spam or junk folder.<br>If you still can't find it,</p>
                        <button class="w-full border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-3 rounded-xl font-bold transition-all text-[14px] flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-arrows-clockwise text-[18px]"></i> Resend E-Ticket
                        </button>
                    </div>

                    <!-- Stay Connected Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Stay Connected</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-5">Follow us on social media for the latest updates and event highlights.</p>
                        <div class="flex items-center gap-3 text-[22px] text-gray-400">
                            <a href="#" class="hover:text-[#1877F2] transition-colors"><i class="ph-fill ph-facebook-logo"></i></a>
                            <a href="#" class="hover:text-[#1DA1F2] transition-colors"><i class="ph-fill ph-twitter-logo"></i></a>
                            <a href="#" class="hover:text-[#0A66C2] transition-colors"><i class="ph-fill ph-linkedin-logo"></i></a>
                            <a href="#" class="hover:text-[#E4405F] transition-colors"><i class="ph-fill ph-instagram-logo"></i></a>
                            <a href="#" class="hover:text-[#FF0000] transition-colors"><i class="ph-fill ph-youtube-logo"></i></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            let bookingId = urlParams.get('booking_id') || localStorage.getItem('lastBookingId') || 'GTS-240515-000123';
            let exhId = urlParams.get('id') || localStorage.getItem('activeExhibitionId') || '1';

            // Fetch details from backend via helper
            const visitor = await ExhibitionAPI.getTicketDetails(bookingId);
            const ex = await ExhibitionAPI.getExhibition(exhId);

            if (visitor) {
                document.getElementById('success-email').textContent = visitor.email;
                document.getElementById('sidebar-booking-id').textContent = visitor.booking_id;
                document.getElementById('sidebar-name').textContent = `${visitor.first_name} ${visitor.last_name}`;
                document.getElementById('sidebar-email').textContent = visitor.email;
                document.getElementById('sidebar-pass-type').textContent = visitor.pass_type || 'Free Visitor Pass';
            }

            if (ex) {
                document.getElementById('success-exh-name').textContent = ex.name;
                document.getElementById('sidebar-exh-name').textContent = ex.name;
                
                let dateStr = 'May 15 – May 17, 2026';
                if (ex.start_date && ex.end_date) {
                    const start = new Date(ex.start_date);
                    const end = new Date(ex.end_date);
                    dateStr = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} – ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                }
                document.getElementById('sidebar-exh-dates').textContent = dateStr;
                document.getElementById('sidebar-exh-venue').textContent = ex.venue;

                if (ex.banner_url) {
                    const sidebarImg = document.getElementById('sidebar-exh-image');
                    if (sidebarImg) {
                        sidebarImg.style.backgroundImage = `url('${ex.banner_url}')`;
                    }
                }
            }
        });
    </script>
</body>
</html>
