<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Preview - eproexpo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#5B32F6',
                            light: '#F4F1FF',
                        },
                        textMain: '#1C1364',
                        textMuted: '#6B7280',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#FAFBFC] text-textMain font-sans flex min-h-screen">
    <div id="sidebar-container" class="z-50 relative"></div>
    
    <main class="ml-[280px] flex-1 min-h-screen flex flex-col">
        <!-- Top Nav -->
        <header class="bg-white flex justify-between items-center px-10 py-6 border-b border-gray-100 shrink-0">
            <div class="flex gap-8">
                <a href="#" class="text-[13px] font-medium text-textMain">Explore Events</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Exhibitions</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Products</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Jobs</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Resources</a>
                <a href="#" class="text-[13px] font-medium text-textMain">Pricing</a>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-1 text-[13px] font-medium cursor-pointer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    EN
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/150?img=11" alt="John Doe" class="w-9 h-9 rounded-full object-cover">
                    <div>
                        <h4 class="text-[13px] font-bold">John Doe</h4>
                        <p class="text-[11px] text-textMuted font-medium">Organizer</p>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
        </header>

        <div class="px-10 py-8 max-w-[1250px] w-full flex flex-col mx-auto flex-1 pb-20">
            
            <!-- Header (Heading removed as requested, keeping right actions) -->
            <div class="flex justify-between items-center mb-6">
                <div></div> <!-- Empty div to take the space of the removed header -->
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-4 text-[#1C1364] font-bold text-[14px]">
                        Preview Mode
                        <div class="flex items-center gap-3 text-[#4C10D0]">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            <svg class="text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        </div>
                    </div>
                    <a href="submit-review.html" class="bg-white border border-[#4C10D0] text-[#4C10D0] px-5 py-2 rounded-lg text-[13px] font-bold flex items-center gap-2 hover:bg-[#F4F1FF] transition-colors shadow-sm">
                        View as Attendee
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Banner -->
            <div class="relative w-full h-[280px] rounded-[16px] overflow-hidden mb-6 shadow-sm">
                <!-- Background Image -->
                <img src="https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=1200&q=80" alt="San Francisco Skyline" class="absolute inset-0 w-full h-full object-cover">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0D0B2E] via-[#0D0B2E]/80 to-transparent"></div>

                <!-- Banner Content -->
                <div class="absolute inset-0 p-10 flex flex-col justify-center">
                    <div class="text-white mb-6">
                        <div class="text-[20px] font-bold leading-tight mb-2">GIS<br>2024</div>
                        <h1 class="text-[32px] font-bold tracking-tight mb-2">GLOBAL INNOVATION SUMMIT 2024</h1>
                        <p class="text-[16px] font-medium text-gray-200">May 15 - 17, 2024 | San Francisco, CA</p>
                    </div>
                    <div class="flex gap-4">
                        <button class="bg-[#4C10D0] text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-[#3d0ba8] transition-colors shadow-sm">Buy Tickets</button>
                        <button class="bg-transparent border border-white text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-white/10 transition-colors">Become a Sponsor</button>
                    </div>
                </div>
            </div>

            <!-- Info Bar -->
            <div class="bg-white border border-gray-100 rounded-[12px] p-6 flex items-center justify-between shadow-sm mb-6">
                <!-- Item 1 -->
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-[#4C10D0]">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-[#1C1364] text-[14px]">3 Days</span>
                        <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5">May 15 - 17, 2024</span>
                    </div>
                </div>
                
                <div class="w-px h-10 bg-gray-100"></div>

                <!-- Item 2 -->
                <div class="flex items-center gap-4 flex-1 pl-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-[#4C10D0]">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-[#1C1364] text-[14px]">Grand Convention Center</span>
                        <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5">San Francisco, CA, USA</span>
                    </div>
                </div>

                <div class="w-px h-10 bg-gray-100"></div>

                <!-- Item 3 -->
                <div class="flex items-center gap-4 flex-1 pl-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-[#4C10D0]">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-[#1C1364] text-[14px]">1,500+</span>
                        <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5">Expected Attendees</span>
                    </div>
                </div>

                <div class="w-px h-10 bg-gray-100"></div>

                <!-- Item 4 -->
                <div class="flex items-center gap-4 flex-1 pl-8">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-[#4C10D0]">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-[#1C1364] text-[14px]">40+</span>
                        <span class="text-[#5B6B8A] text-[12px] font-medium mt-0.5">Speakers</span>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex items-center gap-10 border-b border-gray-200 mb-8 px-4">
                <a href="#" class="pb-4 font-bold text-[#4C10D0] border-b-2 border-[#4C10D0] text-[14px]">About</a>
                <a href="#" class="pb-4 font-bold text-[#1C1364] hover:text-[#4C10D0] transition-colors text-[14px]">Speakers</a>
                <a href="#" class="pb-4 font-bold text-[#1C1364] hover:text-[#4C10D0] transition-colors text-[14px]">Agenda</a>
                <a href="#" class="pb-4 font-bold text-[#1C1364] hover:text-[#4C10D0] transition-colors text-[14px]">Sponsors</a>
                <a href="#" class="pb-4 font-bold text-[#1C1364] hover:text-[#4C10D0] transition-colors text-[14px]">Venue</a>
                <a href="#" class="pb-4 font-bold text-[#1C1364] hover:text-[#4C10D0] transition-colors text-[14px]">Resources</a>
            </div>

            <!-- Main Content Layout -->
            <div class="grid grid-cols-[1fr_350px] gap-8">
                
                <!-- Left Content: Featured Speakers -->
                <div class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)] h-fit">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-[16px] font-bold text-[#1C1364]">Featured Speakers</h3>
                        <a href="#" class="text-[13px] font-bold text-[#4C10D0] flex items-center gap-1 hover:underline">
                            View all speakers
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-4 gap-6">
                        <!-- Speaker 1 -->
                        <div class="flex flex-col items-center text-center">
                            <img src="https://i.pravatar.cc/150?img=5" alt="Dr. Sarah Johnson" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-transparent hover:border-[#4C10D0] transition-colors cursor-pointer">
                            <h4 class="text-[14px] font-bold text-[#1C1364] mb-1">Dr. Sarah Johnson</h4>
                            <p class="text-[12px] text-[#5B6B8A] font-medium leading-tight">Chair & CEO,<br>TechNova</p>
                        </div>
                        <!-- Speaker 2 -->
                        <div class="flex flex-col items-center text-center">
                            <img src="https://i.pravatar.cc/150?img=11" alt="Michael Chen" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-transparent hover:border-[#4C10D0] transition-colors cursor-pointer">
                            <h4 class="text-[14px] font-bold text-[#1C1364] mb-1">Michael Chen</h4>
                            <p class="text-[12px] text-[#5B6B8A] font-medium leading-tight">CTO,<br>CloudSphere</p>
                        </div>
                        <!-- Speaker 3 -->
                        <div class="flex flex-col items-center text-center">
                            <img src="https://i.pravatar.cc/150?img=9" alt="Emily Rodriguez" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-transparent hover:border-[#4C10D0] transition-colors cursor-pointer">
                            <h4 class="text-[14px] font-bold text-[#1C1364] mb-1">Emily Rodriguez</h4>
                            <p class="text-[12px] text-[#5B6B8A] font-medium leading-tight">Head of Data,<br>DataWinds</p>
                        </div>
                        <!-- Speaker 4 -->
                        <div class="flex flex-col items-center text-center">
                            <img src="https://i.pravatar.cc/150?img=12" alt="James Wilson" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-transparent hover:border-[#4C10D0] transition-colors cursor-pointer">
                            <h4 class="text-[14px] font-bold text-[#1C1364] mb-1">James Wilson</h4>
                            <p class="text-[12px] text-[#5B6B8A] font-medium leading-tight">Founder & CEO,<br>InnovaX</p>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Tickets -->
                <div class="bg-white border border-gray-100 rounded-[16px] p-8 shadow-[0_2px_10px_rgba(0,0,0,0.01)] h-fit flex flex-col">
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-6">Tickets</h3>
                    
                    <div class="flex flex-col gap-6">
                        <!-- Early Bird -->
                        <div class="flex flex-col pb-6 border-b border-gray-100">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-[#1C1364] text-[14px]">Early Bird Pass</span>
                                <span class="font-bold text-[#1C1364] text-[14px]">$99</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1 text-[12px] font-medium text-[#5B6B8A]">
                                    Ends in 
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <span class="text-[12px] font-medium text-[#5B6B8A]">10 days 20h</span>
                            </div>
                        </div>

                        <!-- General Admission -->
                        <div class="flex items-center justify-between pb-6 border-b border-gray-100">
                            <span class="font-bold text-[#1C1364] text-[14px]">General Admission</span>
                            <span class="font-bold text-[#1C1364] text-[14px]">$199</span>
                        </div>

                        <!-- VIP Pass -->
                        <div class="flex items-center justify-between mb-6">
                            <span class="font-bold text-[#1C1364] text-[14px]">VIP Pass</span>
                            <span class="font-bold text-[#1C1364] text-[14px]">$299</span>
                        </div>

                        <!-- Buy Button -->
                        <button class="w-full bg-[#4C10D0] text-white py-3.5 rounded-lg text-[14px] font-bold hover:bg-[#3d0ba8] transition-colors shadow-sm">
                            Buy Tickets
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="sidebar.js"></script>
    <script src="app.js"></script>
</body>
</html>
