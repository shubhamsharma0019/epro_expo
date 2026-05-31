<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - My Tickets</title>
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
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-8 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <div class="flex flex-col lg:flex-row gap-8 max-w-[1200px] mx-auto">
                
                <!-- Left: Dashboard Area -->
                <div class="flex-1 flex flex-col">
                    
                    <h1 class="text-[20px] font-bold text-[#1E1B4B] mb-4">My Tickets / Dashboard</h1>
                    
                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 border-b border-gray-200 mb-6">
                        <div class="pb-3 border-b-2 border-primary-600 font-bold text-primary-600 text-[14px] cursor-pointer">My Tickets</div>
                        <div class="pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Past Tickets</div>
                        <div class="pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Cancelled Tickets</div>
                    </div>

                    <!-- Upcoming Event Ticket Card -->
                    <div id="upcoming-ticket-card" class="border border-gray-200 rounded-2xl bg-white p-6 shadow-sm mb-8 relative">
                        <!-- Active Pill -->
                        <div class="absolute top-6 right-6 bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[12px] font-bold">Active</div>
                        
                        <h2 class="font-bold text-[#1E1B4B] text-[16px] mb-4">Upcoming Event Ticket</h2>
                        
                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <!-- Left Event Info -->
                            <a href="lobby.html" class="flex gap-5 flex-1 border-r border-gray-100 pr-6 group cursor-pointer">
                                <div class="w-[120px] h-[120px] rounded-xl bg-cover bg-center border border-gray-100 shadow-sm flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                                <div class="flex flex-col pt-1">
                                    <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-2 group-hover:text-primary-600 transition-colors">Global Tech Summit 2024</h3>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[13px] font-medium mb-1.5">
                                        <i class="ph ph-calendar-blank text-[15px]"></i>
                                        <span>May 15 – May 17, 2024</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[13px] font-medium mb-1.5">
                                        <i class="ph ph-clock text-[15px]"></i>
                                        <span>09:00 AM – 06:00 PM (IST)</span>
                                    </div>
                                    <div class="flex items-start gap-1.5 text-gray-500 text-[13px] font-medium leading-snug">
                                        <i class="ph ph-map-pin text-[15px] mt-0.5"></i>
                                        <span>Jio World Convention Centre, Mumbai, India</span>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Right Booking Info -->
                            <div class="w-full max-w-[280px] bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between">
                                <div class="flex flex-col flex-1 text-[12px]">
                                    <div class="font-bold text-[#1E293B] text-[13px] mb-3">Free Visitor Pass</div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-500 font-medium">Booking ID</span>
                                        <span class="font-bold text-[#1E293B]">GTS-240515-000123</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-500 font-medium">Ticket Count</span>
                                        <span class="font-bold text-[#1E293B]">1</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Attendee</span>
                                        <span class="font-bold text-[#1E293B]">Aarav Sharma</span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center ml-4 border-l border-gray-200 pl-4">
                                    <div class="w-[60px] h-[60px] bg-white border border-gray-200 rounded-lg p-1 mb-2 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=GTS-240515-000123" class="w-full h-full object-contain">
                                    </div>
                                    <a href="e-ticket.html" class="text-primary-600 font-bold text-[11px] hover:underline whitespace-nowrap">View E-Ticket</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="e-ticket.html" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-sm transition-all text-[13px] flex items-center gap-2">
                                <i class="ph ph-ticket text-[18px]"></i> View E-Ticket
                            </a>
                            <div class="flex border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm hover:bg-gray-50 transition-colors cursor-pointer text-primary-600">
                                <div class="px-4 py-2.5 font-bold text-[13px] flex items-center gap-2 border-r border-gray-200">
                                    <i class="ph ph-download-simple text-[18px]"></i> Download
                                </div>
                                <div class="px-3 py-2.5 flex items-center justify-center">
                                    <i class="ph ph-caret-down text-[14px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- All Tickets Search/Filter -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-[#1E1B4B] text-[16px]">All Tickets</h2>
                        <div class="flex items-center gap-3">
                            <div class="relative w-full max-w-[350px]">
                                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                                <input type="text" placeholder="Search by event name or booking ID..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-[13px] outline-none focus:border-primary-500">
                            </div>
                            <button class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-semibold text-[13px] flex items-center gap-2 shadow-sm transition-colors">
                                <i class="ph ph-funnel text-[16px]"></i> Filters
                            </button>
                        </div>
                    </div>

                    <!-- Tickets List -->
                    <div id="tickets-list" class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-6 flex flex-col hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        
                        <!-- Row 1 -->
                        <div class="p-5 flex items-center border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <div class="w-[80px] h-[80px] rounded-lg bg-cover bg-center border border-gray-100 mr-5 shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=200&q=80');"></div>
                            
                            <div class="flex-1 min-w-[200px] pr-4">
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1.5">Global Tech Summit 2024</h4>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] font-medium mb-1">
                                    <i class="ph ph-calendar-blank text-[13px]"></i> May 15 – May 17, 2024
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-tight">
                                    <i class="ph ph-map-pin text-[13px] mt-0.5"></i> Jio World Convention Centre,<br>Mumbai, India
                                </div>
                            </div>
                            
                            <div class="w-[150px] flex flex-col gap-3 text-[12px]">
                                <div>
                                    <div class="text-gray-500 font-medium">Booking ID</div>
                                    <div class="font-bold text-[#1E293B]">GTS-240515-000123</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 font-medium">Ticket Count</div>
                                    <div class="font-bold text-[#1E293B]">1</div>
                                </div>
                            </div>

                            <div class="w-[150px] flex flex-col gap-3 text-[12px]">
                                <div>
                                    <div class="text-gray-500 font-medium">Ticket Type</div>
                                    <div class="font-bold text-[#1E293B]">Free Visitor Pass</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 font-medium">Attendee</div>
                                    <div class="font-bold text-[#1E293B]">Aarav Sharma</div>
                                </div>
                            </div>

                            <div class="w-[100px] flex justify-center">
                                <div class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[11px] font-bold">Active</div>
                            </div>

                            <div class="w-[140px] flex items-center justify-end gap-2 pl-4">
                                <a href="e-ticket.html" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors shadow-sm">View E-Ticket</a>
                                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors shadow-sm">
                                    <i class="ph-bold ph-dots-three-vertical text-[16px]"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="p-5 flex items-center hover:bg-gray-50 transition-colors">
                            <div class="w-[80px] h-[80px] rounded-lg bg-cover bg-center border border-gray-100 mr-5 shrink-0" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=200&q=80');"></div>
                            
                            <div class="flex-1 min-w-[200px] pr-4">
                                <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1.5">Sustainability World Expo 2024</h4>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[12px] font-medium mb-1">
                                    <i class="ph ph-calendar-blank text-[13px]"></i> Jun 10 – Jun 12, 2024
                                </div>
                                <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-tight">
                                    <i class="ph ph-map-pin text-[13px] mt-0.5"></i> Pragati Maidan, New Delhi, India
                                </div>
                            </div>
                            
                            <div class="w-[150px] flex flex-col gap-3 text-[12px]">
                                <div>
                                    <div class="text-gray-500 font-medium">Booking ID</div>
                                    <div class="font-bold text-[#1E293B]">SWE-240610-000045</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 font-medium">Ticket Count</div>
                                    <div class="font-bold text-[#1E293B]">1</div>
                                </div>
                            </div>

                            <div class="w-[150px] flex flex-col gap-3 text-[12px]">
                                <div>
                                    <div class="text-gray-500 font-medium">Ticket Type</div>
                                    <div class="font-bold text-[#1E293B]">Business Visitor Pass</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 font-medium">Attendee</div>
                                    <div class="font-bold text-[#1E293B]">Aarav Sharma</div>
                                </div>
                            </div>

                            <div class="w-[100px] flex justify-center">
                                <div class="bg-orange-50 text-orange-600 border border-orange-100 px-3 py-1 rounded-full text-[11px] font-bold">Completed</div>
                            </div>

                            <div class="w-[140px] flex items-center justify-end gap-2 pl-4">
                                <button class="border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors shadow-sm">View E-Ticket</button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors shadow-sm">
                                    <i class="ph-bold ph-dots-three-vertical text-[16px]"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-between pb-8 text-[13px]">
                        <div class="text-gray-500 font-medium">Showing 1 to 2 of 6 tickets</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 shadow-sm"><i class="ph ph-caret-left"></i></button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary-600 text-white font-bold shadow-[0_2px_8px_rgba(90,50,250,0.25)]">1</button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 shadow-sm font-semibold">2</button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 shadow-sm font-semibold">3</button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 shadow-sm"><i class="ph ph-caret-right"></i></button>
                        </div>
                    </div>

                </div>

                <!-- Right: Sidebars -->
                <div class="w-full lg:w-[300px] shrink-0 flex flex-col gap-5 lg:pt-[52px]">
                    
                    <!-- Upcoming Events -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[14px]">Upcoming Events</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline">View All</a>
                        </div>
                        
                        <div class="flex gap-3 mb-5 pb-5 border-b border-gray-50">
                            <div class="w-[50px] h-[50px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=200&q=80');"></div>
                            <div class="flex flex-col">
                                <div class="font-bold text-[#1E1B4B] text-[12px] mb-1">Global Tech Summit 2024</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[11px] mb-1 font-medium">
                                    <i class="ph ph-calendar-blank text-[12px]"></i> May 15 – May 17, 2024
                                </div>
                                <div class="flex items-start gap-1 text-gray-500 text-[11px] font-medium leading-tight">
                                    <i class="ph ph-map-pin text-[12px] mt-0.5"></i> Jio World Convention Centre, Mumbai, India
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-[50px] h-[50px] rounded-lg bg-cover bg-center border border-gray-100 flex-shrink-0" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=200&q=80');"></div>
                            <div class="flex flex-col">
                                <div class="font-bold text-[#1E1B4B] text-[12px] mb-1">Sustainability World Expo 2024</div>
                                <div class="flex items-center gap-1.5 text-gray-500 text-[11px] mb-1 font-medium">
                                    <i class="ph ph-calendar-blank text-[12px]"></i> Jun 10 – Jun 12, 2024
                                </div>
                                <div class="flex items-start gap-1 text-gray-500 text-[11px] font-medium leading-tight">
                                    <i class="ph ph-map-pin text-[12px] mt-0.5"></i> Pragati Maidan, New Delhi, India
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[14px] mb-4">Quick Actions</h3>
                        
                        <div class="space-y-4">
                            <a href="{{ url('/exhibitions') }}" class="flex items-center gap-3 group cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-primary-600 flex items-center justify-center shrink-0 group-hover:bg-primary-100 transition-colors">
                                    <i class="ph-bold ph-calendar-blank text-[14px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[13px]">Browse All Exhibitions</div>
                                    <div class="text-[11px] text-gray-500">Explore upcoming events</div>
                                </div>
                            </a>
                            <a href="#" class="flex items-center gap-3 group cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-primary-600 flex items-center justify-center shrink-0 group-hover:bg-primary-100 transition-colors">
                                    <i class="ph-bold ph-handshake text-[14px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[13px]">My Meetings</div>
                                    <div class="text-[11px] text-gray-500">View your scheduled meetings</div>
                                </div>
                            </a>
                            <a href="#" class="flex items-center gap-3 group cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-primary-600 flex items-center justify-center shrink-0 group-hover:bg-primary-100 transition-colors">
                                    <i class="ph-bold ph-user-focus text-[14px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[13px]">My Visits</div>
                                    <div class="text-[11px] text-gray-500">See exhibitors you plan to visit</div>
                                </div>
                            </a>
                            <a href="#" class="flex items-center gap-3 group cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 text-primary-600 flex items-center justify-center shrink-0 group-hover:bg-primary-100 transition-colors">
                                    <i class="ph-bold ph-bell text-[14px]"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E293B] text-[13px]">Notifications</div>
                                    <div class="text-[11px] text-gray-500">Check your latest updates</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Need Help? Box -->
                    <div class="border border-gray-100 rounded-2xl bg-[#FAFAFA] p-5 shadow-sm text-center">
                        <h3 class="font-bold text-[#1E1B4B] text-[14px] mb-1.5 text-left">Need Help?</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed text-left mb-4">If you have any questions, our support team is here to help you.</p>
                        
                        <div class="flex flex-col gap-2 mb-4">
                            <a href="mailto:support@eproexpo.com" class="flex items-center gap-2 text-primary-600 font-bold text-[12px] hover:underline">
                                <i class="ph ph-envelope-simple text-[16px]"></i> support@eproexpo.com
                            </a>
                            <a href="tel:+919876543210" class="flex items-center gap-2 text-primary-600 font-bold text-[12px] hover:underline">
                                <i class="ph ph-phone text-[16px]"></i> +91 98765 43210
                            </a>
                        </div>
                        
                        <button class="w-full border border-primary-200 bg-white text-primary-600 hover:bg-primary-50 py-2.5 rounded-lg font-bold transition-all text-[13px] shadow-sm">
                            Contact Support
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script src="exhibition-api.js"></script>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const tickets = await ExhibitionAPI.getTickets();
            const ticketsListContainer = document.getElementById('tickets-list');
            const upcomingCardContainer = document.getElementById('upcoming-ticket-card');

            const getHallName = (pavilionId) => {
                const mapping = {
                    'tech': 'Hall 1 – AI & IA',
                    'manufacturing': 'Hall 4 – Manufacturing',
                    'smart': 'Hall 4 – Manufacturing',
                    'green': 'Hall 3 – Green Energy',
                    'startups': 'Hall 2 – Cloud & DevOps'
                };
                return mapping[pavilionId] || 'Hall 1 – AI & IA';
            };

            if (tickets && tickets.length > 0) {
                // Clear default rows
                if (ticketsListContainer) ticketsListContainer.innerHTML = '';
                
                // Get the first ticket as upcoming
                const upcomingTicket = tickets[0];
                const exh = await ExhibitionAPI.getExhibition(upcomingTicket.exhibition_id || 1);

                if (upcomingCardContainer && exh) {
                    let dateStr = 'May 15 – May 17, 2026';
                    if (exh.start_date && exh.end_date) {
                        const start = new Date(exh.start_date);
                        const end = new Date(exh.end_date);
                        dateStr = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} – ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                    }
                    upcomingCardContainer.innerHTML = `
                        <!-- Active Pill -->
                        <div class="absolute top-6 right-6 bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[12px] font-bold">
                            ${upcomingTicket.checkin_status ? 'Checked In' : 'Active'}
                        </div>
                        
                        <h2 class="font-bold text-[#1E1B4B] text-[16px] mb-4">Upcoming Event Ticket</h2>
                        
                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <!-- Left Event Info -->
                            <a href="lobby.html?booking_id=${upcomingTicket.booking_id}&id=${exh.id}" class="flex gap-5 flex-1 border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0 pr-0 md:pr-6 group cursor-pointer">
                                <div class="w-[120px] h-[120px] rounded-xl bg-cover bg-center border border-gray-100 shadow-sm flex-shrink-0" style="background-image: url('${exh.banner_url || 'https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80'}');"></div>
                                <div class="flex flex-col pt-1">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-primary-600 mb-1">Selected Exhibition</div>
                                    <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-2 group-hover:text-primary-600 transition-colors">${exh.name}</h3>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[13px] font-medium mb-1.5">
                                        <i class="ph ph-calendar-blank text-[15px]"></i>
                                        <span>${dateStr}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-gray-500 text-[13px] font-medium mb-1.5">
                                        <i class="ph ph-clock text-[15px]"></i>
                                        <span>09:00 AM – 06:00 PM (IST)</span>
                                    </div>
                                    <div class="flex items-start gap-1.5 text-gray-500 text-[13px] font-medium leading-snug">
                                        <i class="ph ph-map-pin text-[15px] mt-0.5"></i>
                                        <span>${exh.venue}</span>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Right Booking Info -->
                            <div class="w-full md:w-full max-w-[320px] bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between">
                                <div class="flex flex-col flex-1 text-[12px] gap-1.5">
                                    <div class="font-bold text-[#1E293B] text-[13px] mb-1">${upcomingTicket.pass_type}</div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Booking ID</span>
                                        <span class="font-bold text-[#1E293B]">${upcomingTicket.booking_id}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Attendee</span>
                                        <span class="font-bold text-[#1E293B]">${upcomingTicket.first_name} ${upcomingTicket.last_name}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Selected Hall</span>
                                        <span class="font-bold text-[#1E293B] text-primary-600">${getHallName(upcomingTicket.pavilion_id)}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Booked Price</span>
                                        <span class="font-bold text-[#1E293B]">${upcomingTicket.amount > 0 ? '₹' + parseFloat(upcomingTicket.amount).toLocaleString('en-IN') : 'Free'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-medium">Pay Status</span>
                                        <span class="font-bold ${upcomingTicket.payment_status === 'completed' ? 'text-green-600' : 'text-orange-500'} capitalize">${upcomingTicket.payment_status || 'completed'}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center ml-3 border-l border-gray-200 pl-3">
                                    <div class="w-[60px] h-[60px] bg-white border border-gray-200 rounded-lg p-1 mb-2 hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.open('https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${upcomingTicket.booking_id}', '_blank')">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${upcomingTicket.booking_id}" class="w-full h-full object-contain" title="Click to view full QR">
                                    </div>
                                    <a href="e-ticket.html?booking_id=${upcomingTicket.booking_id}&id=${exh.id}" class="text-primary-600 font-bold text-[11px] hover:underline whitespace-nowrap">View E-Ticket</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="e-ticket.html?booking_id=${upcomingTicket.booking_id}&id=${exh.id}" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-sm transition-all text-[13px] flex items-center gap-2">
                                <i class="ph ph-ticket text-[18px]"></i> View E-Ticket
                            </a>
                            <button id="upcoming-download-btn" class="px-4 py-2.5 border border-gray-200 rounded-lg bg-white shadow-sm hover:bg-gray-50 transition-colors font-bold text-[13px] text-primary-600 flex items-center gap-2">
                                <i class="ph ph-download-simple text-[18px]"></i> Download QR
                            </button>
                        </div>
                    `;
 
                    document.getElementById('upcoming-download-btn').addEventListener('click', () => {
                        window.open(`https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${upcomingTicket.booking_id}`, '_blank');
                    });
                }
 
                // Render tickets in list
                for (let i = 0; i < tickets.length; i++) {
                    const ticket = tickets[i];
                    const ticketExh = await ExhibitionAPI.getExhibition(ticket.exhibition_id || 1);
 
                    if (ticketsListContainer && ticketExh) {
                        let dateStr = 'May 15 – May 17, 2026';
                        if (ticketExh.start_date && ticketExh.end_date) {
                            const start = new Date(ticketExh.start_date);
                            const end = new Date(ticketExh.end_date);
                            dateStr = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} – ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                        }
 
                        const borderClass = i === tickets.length - 1 ? '' : 'border-b border-gray-100';
                        const statusColor = ticket.checkin_status ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-green-50 text-green-600 border-green-100';
                        const statusLabel = ticket.checkin_status ? 'Checked In' : 'Active';
 
                        const rowHtml = `
                            <div class="p-5 flex flex-col lg:flex-row lg:items-center ${borderClass} hover:bg-gray-50 transition-colors gap-5">
                                <div class="flex items-center w-full lg:w-auto">
                                    <div class="w-[80px] h-[80px] rounded-lg bg-cover bg-center border border-gray-100 mr-4 shrink-0" style="background-image: url('${ticketExh.banner_url || 'https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80'}');"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-primary-600 mb-0.5">Selected Exhibition</div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1.5 truncate" title="${ticketExh.name}">${ticketExh.name}</h4>
                                        <div class="flex items-center gap-1.5 text-gray-500 text-[12px] font-medium mb-1">
                                            <i class="ph ph-calendar-blank text-[13px]"></i> ${dateStr}
                                        </div>
                                        <div class="flex items-start gap-1.5 text-gray-500 text-[12px] font-medium leading-tight">
                                            <i class="ph ph-map-pin text-[13px] mt-0.5"></i> ${ticketExh.venue}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:flex lg:items-center lg:justify-between lg:flex-1 gap-4 w-full text-[12px]">
                                    <div>
                                        <div class="text-gray-500 font-medium mb-0.5">Booking ID</div>
                                        <div class="font-bold text-[#1E293B] mb-2">${ticket.booking_id}</div>
                                        <div class="text-gray-500 font-medium mb-0.5">Attendee</div>
                                        <div class="font-bold text-[#1E293B]">${ticket.first_name} ${ticket.last_name}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500 font-medium mb-0.5">Selected Hall</div>
                                        <div class="font-bold text-[#1E293B] text-primary-600">${getHallName(ticket.pavilion_id)}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500 font-medium mb-0.5">Ticket Type</div>
                                        <div class="font-bold text-[#1E293B] mb-2">${ticket.pass_type}</div>
                                        <div class="text-gray-500 font-medium mb-0.5">Booked Price</div>
                                        <div class="font-bold text-[#1E293B]">${ticket.amount > 0 ? '₹' + parseFloat(ticket.amount).toLocaleString('en-IN') : 'Free'} (${ticket.payment_status || 'completed'})</div>
                                    </div>

                                    <div class="flex flex-col items-center gap-1 shrink-0">
                                        <div class="w-[50px] h-[50px] bg-white border border-gray-200 rounded p-0.5 hover:scale-105 transition-transform cursor-pointer" onclick="window.open('https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${ticket.booking_id}', '_blank')">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${ticket.booking_id}" class="w-full h-full object-contain" title="Click to view full QR">
                                        </div>
                                        <span class="text-[9px] text-gray-400 font-bold font-mono">Scan QR</span>
                                    </div>

                                    <div class="flex items-center justify-start lg:justify-center">
                                        <div class="${statusColor} border px-3 py-1 rounded-full text-[11px] font-bold">${statusLabel}</div>
                                    </div>

                                    <div class="flex items-center justify-end gap-2 w-full lg:w-auto mt-2 lg:mt-0">
                                        <a href="e-ticket.html?booking_id=${ticket.booking_id}&id=${ticketExh.id}" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors shadow-sm whitespace-nowrap">View E-Ticket</a>
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors shadow-sm">
                                            <i class="ph-bold ph-dots-three-vertical text-[16px]"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        ticketsListContainer.insertAdjacentHTML('beforeend', rowHtml);
                    }
                }

                // Update summary pagination label
                const paginationLabel = document.querySelector('.text-gray-500.font-medium');
                if (paginationLabel) {
                    paginationLabel.textContent = `Showing 1 to ${tickets.length} of ${tickets.length} tickets`;
                }
            }
        });
    </script>
</body>
</html>
