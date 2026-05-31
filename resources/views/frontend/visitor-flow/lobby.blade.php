<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Event Lobby</title>
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
        body { background-color: #FAFAFA; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .timer-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
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
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            <div class="flex flex-col lg:flex-row gap-8 max-w-[1400px] mx-auto">
                
                <!-- Left: Main Lobby Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
                    <!-- Hero Banner -->
                    <div class="rounded-[24px] bg-[#0A0D26] text-white p-6 md:p-10 relative overflow-hidden mb-8 min-h-[300px] flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                        <!-- Abstract globe background image -->
                        <div id="lobby-hero-bg" class="absolute right-0 top-0 bottom-0 w-[100%] lg:w-[60%] bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80')] bg-cover bg-center lg:bg-left opacity-35 lg:opacity-40 mix-blend-screen mix-blend-lighten z-0"></div>
                        <div class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-[#0A0D26] via-[#0A0D26]/90 to-[#0A0D26]/40 lg:to-transparent z-0"></div>
                        
                        <div class="relative z-10 max-w-full lg:max-w-[60%]">
                            <h3 class="text-[14px] md:text-[16px] text-indigo-100 font-medium mb-1">Welcome to</h3>
                            <h1 id="lobby-exh-title" class="text-[24px] md:text-[32px] font-bold tracking-tight mb-2 leading-tight">Global Tech Summit 2024</h1>
                            <p class="text-[14px] md:text-[16px] text-indigo-200 mb-4 md:mb-6 font-medium">Innovate. Connect. Transform.</p>
                            
                            <div class="flex flex-col gap-2 text-[13px] md:text-[14px] font-medium text-indigo-100">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-calendar-blank text-[18px]"></i> <span id="lobby-exh-dates">May 15 – May 17, 2024</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="ph ph-map-pin text-[18px] mt-0.5"></i> 
                                    <span id="lobby-exh-venue" class="leading-snug">Jio World Convention Centre,<br>Mumbai, India</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timer Box -->
                        <div class="relative lg:absolute lg:bottom-8 lg:right-10 z-10 flex flex-col items-start lg:items-end mt-4 lg:mt-0">
                            <div class="text-[11px] md:text-[12px] font-bold text-indigo-100 mb-2 uppercase tracking-wider pl-1">Event Ends In</div>
                            <div class="flex gap-2">
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-12 h-14 md:w-14 md:h-16">
                                    <span class="text-[18px] md:text-[20px] font-bold leading-tight">02</span>
                                    <span class="text-[9px] md:text-[10px] text-indigo-200 uppercase">Days</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-12 h-14 md:w-14 md:h-16">
                                    <span class="text-[18px] md:text-[20px] font-bold leading-tight">14</span>
                                    <span class="text-[9px] md:text-[10px] text-indigo-200 uppercase">Hours</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-12 h-14 md:w-14 md:h-16">
                                    <span class="text-[18px] md:text-[20px] font-bold leading-tight">36</span>
                                    <span class="text-[9px] md:text-[10px] text-indigo-200 uppercase">Mins</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-12 h-14 md:w-14 md:h-16">
                                    <span class="text-[18px] md:text-[20px] font-bold leading-tight">45</span>
                                    <span class="text-[9px] md:text-[10px] text-indigo-200 uppercase">Secs</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-10">
                        <div class="border border-gray-100 rounded-2xl bg-white p-5 flex flex-col items-center text-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 border border-indigo-100">
                                <i class="ph ph-users-four text-[24px]"></i>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1">Exhibitors</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Explore exhibitors and sponsors</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl bg-white p-5 flex flex-col items-center text-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center mb-3 border border-primary-100">
                                <i class="ph ph-cube text-[24px]"></i>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1">Products</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Discover innovative products</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl bg-white p-5 flex flex-col items-center text-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 border border-blue-100">
                                <i class="ph ph-calendar-check text-[24px]"></i>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1">Sessions</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">View all sessions and agenda</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl bg-white p-5 flex flex-col items-center text-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mb-3 border border-orange-100">
                                <i class="ph ph-user text-[24px]"></i>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1">Speakers</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Meet our industry experts</p>
                        </div>
                        <div class="border border-gray-100 rounded-2xl bg-white p-5 flex flex-col items-center text-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-md hover:-translate-y-1 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-3 border border-purple-100">
                                <i class="ph ph-users-three text-[24px]"></i>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1">Networking</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Connect and network</p>
                        </div>
                    </div>

                    <!-- Featured Exhibitors -->
                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px]">Featured Exhibitors</h3>
                            <a href="#" class="text-primary-600 font-bold text-[13px] hover:underline flex items-center gap-1">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div id="lobby-featured-exhibitors" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-4">
                            <!-- Populated Dynamically -->
                            <div class="text-[12px] text-gray-500 text-center py-4 w-full">Loading exhibitors...</div>
                        </div>

                        <!-- Pagination Dots -->
                        <div class="flex items-center justify-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-primary-600"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                        </div>
                    </div>

                    <!-- Recommended For You -->
                    <div>
                        <div class="flex items-center gap-6 mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px]">Recommended for You</h3>
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-1.5 rounded-full bg-primary-600 text-white font-bold text-[12px]">All</button>
                                <button class="px-4 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-medium text-[12px] hover:bg-gray-50">Exhibitors</button>
                                <button class="px-4 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-medium text-[12px] hover:bg-gray-50">Products</button>
                                <button class="px-4 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-medium text-[12px] hover:bg-gray-50">Sessions</button>
                                <button class="px-4 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-medium text-[12px] hover:bg-gray-50">People</button>
                            </div>
                        </div>

                        <div class="space-y-4 pb-8">
                            <!-- Rec 1 -->
                            <div class="border border-gray-100 rounded-xl bg-white p-5 flex items-center justify-between shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-[#0A0D26] flex items-center justify-center text-blue-500 overflow-hidden shrink-0">
                                        <!-- abstract lines -->
                                        <div class="w-full h-full bg-[url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=100&q=80')] bg-cover mix-blend-screen opacity-50"></div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-1.5">AI Revolution in Enterprise</div>
                                        <div class="flex items-center gap-3 text-[12px]">
                                            <span class="font-bold text-[#1E293B]">TechVision</span>
                                            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500 font-semibold">Booth B-12</span>
                                        </div>
                                        <p class="text-[12px] text-gray-500 mt-1.5">Next-gen AI solutions for smarter business outcomes.</p>
                                    </div>
                                </div>
                                <a href="pavallion.html" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-5 py-2 rounded-lg font-bold text-[13px] transition-colors shadow-sm text-center">Visit Booth</a>
                            </div>

                            <!-- Rec 2 -->
                            <div class="border border-gray-100 rounded-xl bg-white p-5 flex items-center justify-between shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4s1.79-4 4-4h.71C7.37 7.69 9.48 6 12 6c3.04 0 5.5 2.46 5.5 5.5v.5H19c1.66 0 3 1.34 3 3s-1.34 3-3 3z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E1B4B] text-[14px] mb-1.5">Cloud Infrastructure 360</div>
                                        <div class="flex items-center gap-3 text-[12px]">
                                            <span class="font-bold text-[#1E293B]">CloudSphere</span>
                                            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500 font-semibold">Booth C-08</span>
                                        </div>
                                        <p class="text-[12px] text-gray-500 mt-1.5">Scalable, secure and reliable cloud solutions.</p>
                                    </div>
                                </div>
                                <a href="pavallion.html" class="border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 px-5 py-2 rounded-lg font-bold text-[13px] transition-colors shadow-sm text-center">Visit Booth</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Sidebars (Profile, Schedule, Announcements) -->
                <div class="w-full lg:w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Profile Summary Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm flex flex-col">
                        <div class="flex items-center gap-4 mb-4 border-b border-gray-50 pb-4">
                            <img id="lobby-profile-avatar" src="https://i.pravatar.cc/150?u=a042581f4e29026024d" alt="Aarav Sharma" class="w-14 h-14 rounded-full object-cover border border-gray-100">
                            <div>
                                <h3 id="lobby-profile-name" class="font-bold text-[#1E1B4B] text-[16px] mb-0.5">Aarav Sharma</h3>
                                <p id="lobby-profile-role" class="text-[13px] text-gray-500 font-medium">Visitor</p>
                            </div>
                        </div>
                        <a href="e-ticket.html" class="w-full border border-primary-200 text-primary-600 bg-primary-50/50 hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-ticket text-[18px]"></i> View E-Ticket
                        </a>
                    </div>

                    <!-- My Schedule -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">My Schedule</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div id="lobby-schedule" class="space-y-3 mb-5">
                            <div class="text-[12px] text-gray-500 text-center py-4 w-full">Loading schedule...</div>
                        </div>

                        <a href="pavallion.html" class="w-full border border-gray-200 text-primary-600 bg-white hover:bg-gray-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-calendar-check text-[18px]"></i> Book Meeting Slots
                        </a>
                    </div>

                    <!-- Announcements -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Event Announcements</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div id="lobby-announcements" class="space-y-4">
                            <div class="text-[12px] text-gray-500 text-center py-4 w-full">Loading announcements...</div>
                        </div>
                    </div>

                    <!-- Quick Links / FAQs -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Frequently Asked Questions</h3>
                        
                        <div id="lobby-faqs" class="space-y-2">
                            <div class="text-[12px] text-gray-500 text-center py-4 w-full">Loading FAQs...</div>
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
            let exhId = urlParams.get('id') || localStorage.getItem('activeExhibitionId') || '1';

            // Load Exhibition details dynamically
            try {
                const ex = await ExhibitionAPI.getExhibition(exhId);
                if (ex) {
                    const titleEl = document.getElementById('lobby-exh-title');
                    const datesEl = document.getElementById('lobby-exh-dates');
                    const venueEl = document.getElementById('lobby-exh-venue');
                    const bgEl = document.getElementById('lobby-hero-bg');
                    
                    if (titleEl) titleEl.textContent = ex.name;
                    if (venueEl) venueEl.textContent = ex.venue;
                    
                    if (bgEl && ex.banner_url) {
                        bgEl.style.backgroundImage = `url('${ex.banner_url}')`;
                    }
                    
                    let dateStr = 'May 15 – May 17, 2026';
                    if (ex.start_date && ex.end_date) {
                        const start = new Date(ex.start_date);
                        const end = new Date(ex.end_date);
                        dateStr = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} – ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                    }
                    if (datesEl) datesEl.textContent = dateStr;
                    
                    // Start countdown timer to end date
                    if (ex.end_date) {
                        startTimer(ex.end_date);
                    }
                }
            } catch (err) {
                console.warn('Error loading exhibition details:', err);
            }

            // Countdown Timer Logic
            function startTimer(endDateStr) {
                const endDate = new Date(endDateStr + 'T18:00:00'); // Assume 6 PM
                
                const timerSpanDays = document.querySelector('.timer-box:nth-child(1) span:first-child');
                const timerSpanHours = document.querySelector('.timer-box:nth-child(2) span:first-child');
                const timerSpanMins = document.querySelector('.timer-box:nth-child(3) span:first-child');
                const timerSpanSecs = document.querySelector('.timer-box:nth-child(4) span:first-child');
                
                function updateTimer() {
                    const now = new Date();
                    const diff = endDate - now;
                    
                    if (diff <= 0) {
                        if(timerSpanDays) timerSpanDays.textContent = '00';
                        if(timerSpanHours) timerSpanHours.textContent = '00';
                        if(timerSpanMins) timerSpanMins.textContent = '00';
                        if(timerSpanSecs) timerSpanSecs.textContent = '00';
                        return;
                    }
                    
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const secs = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    if(timerSpanDays) timerSpanDays.textContent = String(days).padStart(2, '0');
                    if(timerSpanHours) timerSpanHours.textContent = String(hours).padStart(2, '0');
                    if(timerSpanMins) timerSpanMins.textContent = String(mins).padStart(2, '0');
                    if(timerSpanSecs) timerSpanSecs.textContent = String(secs).padStart(2, '0');
                }
                
                updateTimer();
                setInterval(updateTimer, 1000);
            }

            // Load Visitor Profile dynamically
            const bookingId = localStorage.getItem('lastBookingId');
            if (bookingId) {
                try {
                    const visitor = await ExhibitionAPI.getTicketDetails(bookingId);
                    if (visitor) {
                        const nameEl = document.getElementById('lobby-profile-name');
                        const roleEl = document.getElementById('lobby-profile-role');
                        const avatarEl = document.getElementById('lobby-profile-avatar');
                        
                        if (nameEl) nameEl.textContent = `${visitor.first_name} ${visitor.last_name}`;
                        if (roleEl) roleEl.textContent = visitor.job_title || 'Visitor';
                        if (avatarEl) avatarEl.src = `https://i.pravatar.cc/150?u=${visitor.email}`;
                    }
                } catch (err) {
                    console.warn('Error loading visitor details for lobby:', err);
                }
            }

            // Load Featured Exhibitors
            try {
                const exhibitors = await ExhibitionAPI.getExhibitors(exhId);
                const container = document.getElementById('lobby-featured-exhibitors');
                if (container) {
                    if (!exhibitors || exhibitors.length === 0) {
                        container.innerHTML = `<div class="text-[12px] text-gray-500 text-center py-4 w-full">No exhibitors available.</div>`;
                    } else {
                        container.innerHTML = '';
                        // Limit to 5 featured exhibitors
                        exhibitors.slice(0, 5).forEach(exh => {
                            const card = document.createElement('a');
                            card.href = `exhibitor-details.html?id=${exh.id}`;
                            card.className = 'flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-md block';
                            card.innerHTML = `
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center rounded-lg text-white font-bold ${exh.logo_color || 'bg-primary-600'} text-[15px]">
                                    ${exh.logo_text || 'EX'}
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px] line-clamp-1">${exh.name}</div>
                            `;
                            container.appendChild(card);
                        });
                    }
                }
            } catch (err) {
                console.error('Error loading exhibitors for lobby:', err);
            }

            // Load Announcements
            try {
                const announcements = await ExhibitionAPI.getAnnouncements(exhId);
                const aContainer = document.getElementById('lobby-announcements');
                if (aContainer) {
                    if (!announcements || announcements.length === 0) {
                        aContainer.innerHTML = `<div class="text-[12px] text-gray-500 text-center py-4 w-full">No announcements today.</div>`;
                    } else {
                        aContainer.innerHTML = '';
                        announcements.forEach(a => {
                            const item = document.createElement('div');
                            item.className = 'flex items-start gap-3 border-b border-gray-50 pb-3 last:border-0 last:pb-0';
                            
                            const isAlert = a.type === 'alert' || a.type === 'warning';
                            const iconOrImg = isAlert 
                                ? `<div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center border border-red-100 shrink-0 mt-0.5"><i class="ph-fill ph-rocket-launch text-[20px]"></i></div>`
                                : `<div class="relative shrink-0 mt-0.5">
                                     <img src="${a.author_avatar || 'https://i.pravatar.cc/150?u=' + a.id}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                     <div class="absolute -top-2 -left-2 bg-primary-600 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full uppercase">Feed</div>
                                   </div>`;
                            
                            item.innerHTML = `
                                ${iconOrImg}
                                <div class="flex-1">
                                    <div class="text-[12px] text-[#1E293B] font-bold mb-0.5">${a.title}</div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">${a.content}</p>
                                </div>
                            `;
                            aContainer.appendChild(item);
                        });
                    }
                }
            } catch (e) {
                console.error('Error loading announcements:', e);
            }

            // Load Schedule (Meetings)
            try {
                const sContainer = document.getElementById('lobby-schedule');
                if (sContainer) {
                    if (!bookingId) {
                        sContainer.innerHTML = `<div class="text-[12px] text-gray-500 text-center py-4 w-full">Please register to see your meeting schedule.</div>`;
                    } else {
                        const meetings = await ExhibitionAPI.getMeetings(bookingId);
                        if (!meetings || meetings.length === 0) {
                            sContainer.innerHTML = `
                                <div class="text-center py-4">
                                    <p class="text-[12px] text-gray-500 mb-2">No meetings requested yet.</p>
                                </div>
                            `;
                        } else {
                            sContainer.innerHTML = '';
                            meetings.forEach(m => {
                                const timeStr = m.meeting_time || '10:00 AM';
                                const [timeVal, ampVal] = timeStr.split(' ');
                                const exhibitorName = m.exhibitor ? m.exhibitor.name : 'Exhibitor Booth';
                                const hallVal = m.exhibitor ? (m.exhibitor.hall_name || 'Exhibition Hall') : 'Exhibition Hall';
                                
                                const item = document.createElement('div');
                                item.className = 'flex items-start gap-4 border-b border-gray-50 pb-3 last:border-0 last:pb-0';
                                item.innerHTML = `
                                    <div class="flex flex-col items-center shrink-0 w-12 text-center mt-0.5">
                                        <div class="font-bold text-[#1E293B] text-[13px]">${timeVal || '10:00'}</div>
                                        <div class="text-[9px] text-gray-500 font-bold uppercase">${ampVal || 'AM'}</div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-bold text-[#1E1B4B] text-[13px] mb-0.5">${m.purpose || 'Product Demonstration'}</div>
                                        <div class="text-[11px] text-gray-500 font-medium">${exhibitorName} (${hallVal})</div>
                                        <span class="inline-block mt-1 px-2 py-0.5 text-[9px] rounded-full font-bold uppercase ${m.status === 'approved' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600'}">${m.status}</span>
                                    </div>
                                `;
                                sContainer.appendChild(item);
                            });
                        }
                    }
                }
            } catch (e) {
                console.error('Error loading schedule:', e);
            }

            // Load FAQs
            try {
                const faqs = await ExhibitionAPI.getFaqs(exhId);
                const fContainer = document.getElementById('lobby-faqs');
                if (fContainer) {
                    if (!faqs || faqs.length === 0) {
                        fContainer.innerHTML = `<div class="text-[12px] text-gray-500 text-center py-4 w-full">No FAQs listed yet.</div>`;
                    } else {
                        fContainer.innerHTML = '';
                        faqs.forEach((faq, index) => {
                            const item = document.createElement('div');
                            item.className = 'border-b border-gray-50 pb-2 last:border-0 last:pb-0';
                            item.innerHTML = `
                                <button class="w-full flex items-center justify-between py-2 text-left text-[#1E293B] hover:text-primary-600 transition-colors font-bold text-[13px] faq-btn">
                                    <div class="flex items-center gap-2">
                                        <i class="ph ${faq.icon || 'ph-question'} text-[16px] text-primary-500"></i>
                                        <span>${faq.question}</span>
                                    </div>
                                    <i class="ph ph-caret-down text-gray-400 faq-caret"></i>
                                </button>
                                <div class="faq-ans hidden pl-6 pb-2 text-[12px] text-gray-500 leading-relaxed">
                                    ${faq.answer}
                                </div>
                            `;
                            
                            const btn = item.querySelector('.faq-btn');
                            const ans = item.querySelector('.faq-ans');
                            const caret = item.querySelector('.faq-caret');
                            btn.addEventListener('click', () => {
                                const isHidden = ans.classList.contains('hidden');
                                document.querySelectorAll('.faq-ans').forEach(a => a.classList.add('hidden'));
                                document.querySelectorAll('.faq-caret').forEach(c => c.className = 'ph ph-caret-down text-gray-400');
                                
                                if (isHidden) {
                                    ans.classList.remove('hidden');
                                    caret.className = 'ph ph-caret-up text-primary-500';
                                }
                            });
                            
                            fContainer.appendChild(item);
                        });
                    }
                }
            } catch (e) {
                console.error('Error loading FAQs:', e);
            }
        });
    </script>
</body>
</html>
