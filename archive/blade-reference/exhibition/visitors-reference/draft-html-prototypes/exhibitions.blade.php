<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Exhibitions</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#5A32FA',
                            600: '#4A22E0',
                        }
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

        .card-img-1 { background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=800&q=80'); }
        .card-img-2 { background-image: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80'); }
        .card-img-3 { background-image: url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=800&q=80'); }
        .card-img-4 { background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80'); }
        .card-img-5 { background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80'); }
        .card-img-6 { background-image: url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80'); }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 shadow-sm bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-10 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Search & Filters -->
            <div class="flex items-center gap-4 mb-8">
                <div class="flex-1 bg-white border border-gray-200 rounded-xl p-3 flex items-center shadow-[0_2px_10px_rgba(0,0,0,0.02)] focus-within:border-primary-500 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <i class="ph ph-magnifying-glass text-[20px] text-gray-400 ml-2 mr-3"></i>
                    <input type="text" placeholder="Search exhibitions..." class="flex-1 outline-none text-gray-700 text-[15px] placeholder-gray-400 bg-transparent">
                </div>
                <button class="bg-white border border-gray-200 hover:bg-gray-50 text-[#334155] px-6 py-3.5 rounded-xl font-semibold shadow-[0_2px_10px_rgba(0,0,0,0.02)] transition-all flex items-center gap-2 text-[14px]">
                    <i class="ph ph-funnel text-[20px] text-primary-500 font-bold"></i>
                    Filters
                </button>
            </div>

            <!-- Title & Subtitle -->
            <div class="mb-6">
                <h1 class="text-[24px] font-bold text-[#1E1B4B] tracking-tight mb-1.5">All Exhibitions</h1>
                <p class="text-[14px] text-[#64748B] font-medium">Showing 1–6 of 24 exhibitions</p>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-10">
                
                <!-- Card 1 -->
                <a href="exhibition-details.html" class="block border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col cursor-pointer">
                    <div class="h-[180px] card-img-1 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">Global Tech Summit 2024</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>May 15 – 17, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Mumbai, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>120+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col">
                    <div class="h-[180px] card-img-2 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">Future of AI Expo</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>Jun 10 – 12, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Bengaluru, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>80+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col">
                    <div class="h-[180px] card-img-3 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">Sustainability World Expo</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>Aug 8 – 10, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Pune, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>85+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col">
                    <div class="h-[180px] card-img-4 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">Healthcare Innovation Expo</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>Jul 2 – 4, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Delhi, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>110+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col">
                    <div class="h-[180px] card-img-5 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">Smart Manufacturing Expo</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>Sep 18 – 20, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Chennai, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>115+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white hover:shadow-lg transition-shadow flex flex-col">
                    <div class="h-[180px] card-img-6 bg-cover bg-center"></div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-[#1E293B] text-[17px] mb-4">FinTech Future Summit</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>Oct 15 – 17, 2024</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-map-pin text-[18px]"></i>
                                <span>Hyderabad, India</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#475569] text-[14px] font-medium">
                                <i class="ph ph-users-three text-[18px]"></i>
                                <span>90+ Companies</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <span class="text-[#16A34A] text-[14px] font-bold">Free Pass</span>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </main>

    <!-- Main Logic Script -->
    <script src="script.js"></script>
</body>
</html>
