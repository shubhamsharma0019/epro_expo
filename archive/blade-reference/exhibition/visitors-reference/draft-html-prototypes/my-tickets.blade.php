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
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-8 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <div class="flex gap-8 max-w-[1200px] mx-auto">
                
                <!-- Left: Dashboard Area -->
                <div class="flex-1 flex flex-col">
                    
                    <h1 class="text-[20px] font-bold text-[#1E1B4B] mb-4">My Tickets / Dashboard</h1>
                    
                    <!-- Tabs -->
                    <div class="flex items-center gap-8 border-b border-gray-200 mb-6">
                        <div class="pb-3 border-b-2 border-primary-600 font-bold text-primary-600 text-[14px] cursor-pointer">My Tickets</div>
                        <div class="pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Past Tickets</div>
                        <div class="pb-3 text-gray-500 font-medium text-[14px] hover:text-gray-700 cursor-pointer transition-colors">Cancelled Tickets</div>
                    </div>

                    <!-- Upcoming Event Ticket Card -->
                    <div class="border border-gray-200 rounded-2xl bg-white p-6 shadow-sm mb-8 relative">
                        <!-- Active Pill -->
                        <div class="absolute top-6 right-6 bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[12px] font-bold">Active</div>
                        
                        <h2 class="font-bold text-[#1E1B4B] text-[16px] mb-4">Upcoming Event Ticket</h2>
                        
                        <div class="flex gap-6 mb-6">
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
                            <div class="w-[280px] bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between">
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
                                        <span class="font-bold text-[#1E293B]">John Doe</span>
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
                            <div class="relative w-[350px]">
                                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                                <input type="text" placeholder="Search by event name or booking ID..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-[13px] outline-none focus:border-primary-500">
                            </div>
                            <button class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-semibold text-[13px] flex items-center gap-2 shadow-sm transition-colors">
                                <i class="ph ph-funnel text-[16px]"></i> Filters
                            </button>
                        </div>
                    </div>

                    <!-- Tickets List -->
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-6 flex flex-col hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        
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
                                    <div class="font-bold text-[#1E293B]">John Doe</div>
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
                                    <div class="font-bold text-[#1E293B]">John Doe</div>
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
                <div class="w-[300px] shrink-0 flex flex-col gap-5 pt-[52px]">
                    
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
                            <a href="exhibitions.html" class="flex items-center gap-3 group cursor-pointer">
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

    <script src="script.js"></script>
</body>
</html>
