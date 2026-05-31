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
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            <div class="flex gap-8 max-w-[1400px] mx-auto">
                
                <!-- Left: Main Lobby Area -->
                <div class="flex-1 flex flex-col min-w-[650px]">
                    
                    <!-- Hero Banner -->
                    <div class="rounded-[24px] bg-[#0A0D26] text-white p-10 relative overflow-hidden mb-8 h-[300px] flex flex-col justify-center">
                        <!-- Abstract globe background image -->
                        <div class="absolute right-0 top-0 bottom-0 w-[60%] bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80')] bg-cover bg-left opacity-40 mix-blend-screen mix-blend-lighten mask-image-linear-left"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0A0D26] via-[#0A0D26]/80 to-transparent"></div>
                        
                        <div class="relative z-10 max-w-[60%]">
                            <h3 class="text-[16px] text-indigo-100 font-medium mb-1">Welcome to</h3>
                            <h1 class="text-[32px] font-bold tracking-tight mb-2">Global Tech Summit 2024</h1>
                            <p class="text-[16px] text-indigo-200 mb-6 font-medium">Innovate. Connect. Transform.</p>
                            
                            <div class="flex flex-col gap-2.5 text-[14px] font-medium text-indigo-100">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-calendar-blank text-[18px]"></i> May 15 – May 17, 2024
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="ph ph-map-pin text-[18px] mt-0.5"></i> 
                                    <span class="leading-snug">Jio World Convention Centre,<br>Mumbai, India</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timer Box -->
                        <div class="absolute bottom-8 right-10 z-10 flex flex-col items-end">
                            <div class="text-[12px] font-bold text-indigo-100 mb-2 uppercase tracking-wider w-full text-left pl-1">Event Ends In</div>
                            <div class="flex gap-2">
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-14 h-16">
                                    <span class="text-[20px] font-bold leading-tight">02</span>
                                    <span class="text-[10px] text-indigo-200 uppercase">Days</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-14 h-16">
                                    <span class="text-[20px] font-bold leading-tight">14</span>
                                    <span class="text-[10px] text-indigo-200 uppercase">Hours</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-14 h-16">
                                    <span class="text-[20px] font-bold leading-tight">36</span>
                                    <span class="text-[10px] text-indigo-200 uppercase">Mins</span>
                                </div>
                                <div class="timer-box rounded-lg flex flex-col items-center justify-center w-14 h-16">
                                    <span class="text-[20px] font-bold leading-tight">45</span>
                                    <span class="text-[10px] text-indigo-200 uppercase">Secs</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Grid -->
                    <div class="grid grid-cols-5 gap-4 mb-10">
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
                        
                        <div class="flex gap-4 mb-4">
                            <!-- Exhibitor 1 -->
                            <a href="pavilions.html" class="flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-colors block hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center text-blue-600">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full"><path d="M12 2L2 22h20L12 2zm0 4.5l6.5 13h-13L12 6.5z"/></svg>
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px]">TechVision</div>
                            </a>
                            <!-- Exhibitor 2 -->
                            <a href="pavilions.html" class="flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-colors block hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center text-blue-400">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4s1.79-4 4-4h.71C7.37 7.69 9.48 6 12 6c3.04 0 5.5 2.46 5.5 5.5v.5H19c1.66 0 3 1.34 3 3s-1.34 3-3 3z"/></svg>
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px]">CloudSphere</div>
                            </a>
                            <!-- Exhibitor 3 -->
                            <a href="pavilions.html" class="flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-colors block hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center text-indigo-600">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px]">InnovaSoft</div>
                            </a>
                            <!-- Exhibitor 4 -->
                            <a href="pavilions.html" class="flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-colors block hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center text-purple-600 text-[32px] font-black font-sans">
                                    N
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px]">NextGen AI</div>
                            </a>
                            <!-- Exhibitor 5 -->
                            <a href="pavilions.html" class="flex-1 border border-gray-100 rounded-xl bg-white p-4 shadow-sm flex flex-col items-center text-center relative group cursor-pointer hover:border-primary-200 transition-colors block hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <i class="ph ph-star absolute top-3 right-3 text-gray-300 hover:text-yellow-400 text-[18px]"></i>
                                <div class="w-12 h-12 mb-3 flex items-center justify-center text-green-600">
                                    <i class="ph-bold ph-planet text-[40px]"></i>
                                </div>
                                <div class="font-bold text-[#1E1B4B] text-[13px]">DataCore</div>
                            </a>
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
                <div class="w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Profile Summary Box -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm flex flex-col">
                        <div class="flex items-center gap-4 mb-4 border-b border-gray-50 pb-4">
                            <img src="https://i.pravatar.cc/150?u=a042581f4e29026024d" alt="John Doe" class="w-14 h-14 rounded-full object-cover border border-gray-100">
                            <div>
                                <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-0.5">John Doe</h3>
                                <p class="text-[13px] text-gray-500 font-medium">Visitor</p>
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
                        
                        <div class="space-y-3 mb-5">
                            <!-- Event 1 -->
                            <div class="flex items-start gap-4 border-b border-gray-50 pb-3">
                                <div class="flex flex-col items-center shrink-0 w-10 text-center mt-0.5">
                                    <div class="font-bold text-[#1E293B] text-[13px]">10:00</div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase">AM</div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-[#1E1B4B] text-[13px] mb-1">Future of AI & Automation</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Main Stage</div>
                                </div>
                                <button class="text-primary-500 hover:text-primary-700 mt-1">
                                    <i class="ph ph-bookmark-simple text-[18px]"></i>
                                </button>
                            </div>
                            <!-- Event 2 -->
                            <div class="flex items-start gap-4 border-b border-gray-50 pb-3">
                                <div class="flex flex-col items-center shrink-0 w-10 text-center mt-0.5">
                                    <div class="font-bold text-[#1E293B] text-[13px]">01:30</div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase">PM</div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-[#1E1B4B] text-[13px] mb-1">Cloud Security Best Practices</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Tech Hall 2</div>
                                </div>
                                <button class="text-primary-500 hover:text-primary-700 mt-1">
                                    <i class="ph ph-bookmark-simple text-[18px]"></i>
                                </button>
                            </div>
                            <!-- Event 3 -->
                            <div class="flex items-start gap-4">
                                <div class="flex flex-col items-center shrink-0 w-10 text-center mt-0.5">
                                    <div class="font-bold text-[#1E293B] text-[13px]">03:30</div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase">PM</div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-[#1E1B4B] text-[13px] mb-1 leading-snug">Panel Discussion: Tech Leaders</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Summit Lounge</div>
                                </div>
                                <button class="text-primary-500 hover:text-primary-700 mt-1">
                                    <i class="ph ph-bookmark-simple text-[18px]"></i>
                                </button>
                            </div>
                        </div>

                        <button class="w-full border border-gray-200 text-primary-600 bg-white hover:bg-gray-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-calendar-check text-[18px]"></i> Go to My Schedule
                        </button>
                    </div>

                    <!-- Announcements -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Event Announcements</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="relative shrink-0 mt-0.5">
                                    <img src="https://i.pravatar.cc/150?u=sam" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                    <div class="absolute -top-2 -left-2 bg-primary-600 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full uppercase">New</div>
                                </div>
                                <p class="text-[12px] text-[#1E293B] font-medium leading-relaxed">Don't miss the Keynote by Sam Altman on May 16!</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center border border-red-100 shrink-0 mt-0.5">
                                    <i class="ph-fill ph-rocket-launch text-[20px]"></i>
                                </div>
                                <p class="text-[12px] text-[#1E293B] font-medium leading-relaxed">Visit the Innovation Pavilion to explore 100+ new products.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Quick Links</h3>
                        
                        <div class="space-y-1">
                            <a href="#" class="flex items-center justify-between py-2 text-[#1E293B] hover:text-primary-600 group">
                                <div class="flex items-center gap-3">
                                    <i class="ph ph-download-simple text-[18px] text-primary-500"></i>
                                    <span class="text-[13px] font-bold">Download Event Guide</span>
                                </div>
                                <i class="ph ph-caret-right text-gray-400 group-hover:text-primary-600"></i>
                            </a>
                            <a href="#" class="flex items-center justify-between py-2 text-[#1E293B] hover:text-primary-600 group">
                                <div class="flex items-center gap-3">
                                    <i class="ph ph-wifi-high text-[18px] text-primary-500"></i>
                                    <span class="text-[13px] font-bold">Wi-Fi Information</span>
                                </div>
                                <i class="ph ph-caret-right text-gray-400 group-hover:text-primary-600"></i>
                            </a>
                            <a href="#" class="flex items-center justify-between py-2 text-[#1E293B] hover:text-primary-600 group">
                                <div class="flex items-center gap-3">
                                    <i class="ph ph-question text-[18px] text-primary-500"></i>
                                    <span class="text-[13px] font-bold">Help Desk</span>
                                </div>
                                <i class="ph ph-caret-right text-gray-400 group-hover:text-primary-600"></i>
                            </a>
                            <a href="#" class="flex items-center justify-between py-2 text-[#1E293B] hover:text-primary-600 group">
                                <div class="flex items-center gap-3">
                                    <i class="ph ph-info text-[18px] text-primary-500"></i>
                                    <span class="text-[13px] font-bold">FAQs</span>
                                </div>
                                <i class="ph ph-caret-right text-gray-400 group-hover:text-primary-600"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
