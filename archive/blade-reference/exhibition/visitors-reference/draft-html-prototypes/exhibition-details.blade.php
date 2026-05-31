<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Global Tech Summit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 500: '#5A32FA', 600: '#4A22E0' }
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
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-12 py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Back button -->
            <a href="exhibitions.html" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibitions
            </a>

            <!-- Header Section -->
            <div class="flex items-start justify-between mb-8">
                <div class="flex gap-6">
                    <!-- Image -->
                    <div class="w-[150px] h-[150px] rounded-2xl bg-cover bg-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.05)]" style="background-image: url('https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=400&q=80');"></div>
                    
                    <!-- Info -->
                    <div class="flex flex-col justify-center">
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-3">Global Tech Summit 2024</h1>
                        
                        <div class="flex items-center gap-5 text-[#475569] text-[14px] font-medium mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ph ph-calendar-blank text-[18px]"></i>
                                <span>May 15 – May 17, 2024</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <div class="flex items-center gap-2">
                                <i class="ph ph-clock text-[18px]"></i>
                                <span>09:00 AM – 06:00 PM (IST)</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 text-[#475569] text-[14px] font-medium mb-5">
                            <i class="ph ph-map-pin text-[18px]"></i>
                            <span>Jio World Convention Centre, Mumbai, India</span>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Technology</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Innovation</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">AI & ML</span>
                            <span class="border border-indigo-200 text-indigo-700 bg-white rounded-lg px-4 py-1.5 text-[12px] font-bold tracking-wide">Cloud</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 border border-gray-200 bg-white text-indigo-600 hover:bg-gray-50 rounded-xl px-5 py-2.5 font-bold text-[14px] transition-colors shadow-sm">
                        <i class="ph ph-share-network text-[20px] font-bold"></i> Share
                    </button>
                    <button class="flex items-center justify-center border border-gray-200 bg-white text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 rounded-xl w-[44px] h-[44px] transition-colors shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <i class="ph ph-heart text-[22px]"></i>
                    </button>
                </div>
            </div>

            <!-- Description -->
            <p class="text-[#64748B] text-[15px] font-medium leading-relaxed max-w-[850px] mb-8">
                Global Tech Summit brings together industry leaders, innovators, researchers, and tech enthusiasts to shape the future of technology and digital transformation.
            </p>

            <!-- Stats Row -->
            <div class="border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 flex items-center justify-around bg-white max-w-full">
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        120+
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Companies</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        8+
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Countries</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        14
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Speakers</div>
                </div>
                <div class="w-px h-12 bg-gray-100"></div>
                <div class="text-center flex-1">
                    <div class="text-[32px] font-bold text-[#1E1B4B] mb-1 relative inline-block">
                        50+
                        <span class="absolute -right-3 top-2.5 w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                    </div>
                    <div class="text-[14px] text-[#64748B] font-bold">Sessions</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-8 flex gap-8">
                <button class="pb-4 text-[15px] font-bold text-indigo-700 border-b-[3px] border-indigo-700 -mb-[1.5px]">Overview</button>
                <button class="pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 transition-colors">Agenda</button>
                <button class="pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 transition-colors">Speakers</button>
                <button class="pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 transition-colors">Sponsors</button>
                <button class="pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 transition-colors">Floor Plan</button>
                <button class="pb-4 text-[15px] font-bold text-gray-500 hover:text-gray-900 transition-colors">FAQs</button>
            </div>

            <!-- Split Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_1.3fr] gap-6 pb-10">
                
                <!-- Left: What to Expect -->
                <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">What to Expect</h2>
                    
                    <div class="space-y-6 mb-8 flex-1">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i class="ph ph-star text-[20px]"></i>
                            </div>
                            <span class="text-[14px] text-[#475569] font-semibold">Explore innovative solutions</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i class="ph ph-users text-[20px]"></i>
                            </div>
                            <span class="text-[14px] text-[#475569] font-semibold">Live product demos</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i class="ph ph-user-circle text-[20px]"></i>
                            </div>
                            <span class="text-[14px] text-[#475569] font-semibold">Network with industry leaders</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i class="ph ph-presentation-chart text-[20px]"></i>
                            </div>
                            <span class="text-[14px] text-[#475569] font-semibold">Panel discussions & keynotes</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i class="ph ph-certificate text-[20px]"></i>
                            </div>
                            <span class="text-[14px] text-[#475569] font-semibold">One-to-one meetings</span>
                        </div>
                    </div>
                    
                    <a href="pass-selection.html" class="w-full inline-block text-center bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-xl font-bold shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all text-[15px]">
                        Get Visitor Pass
                    </a>
                </div>

                <!-- Right: Participating Companies -->
                <div class="border border-gray-100 rounded-[20px] p-7 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white flex flex-col">
                    <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-7">Participating Companies</h2>
                    
                    <!-- Logos Grid -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" alt="IBM" class="h-6 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg" alt="Microsoft" class="h-5 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0e/Intel_logo_%282020%29.svg" alt="Intel" class="h-5 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/21/Nvidia_logo.svg" alt="Nvidia" class="h-4 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg" alt="AWS" class="h-6 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google" class="h-6 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Dell_logo_2016.svg" alt="Dell" class="h-4 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg" alt="Cisco" class="h-6 opacity-90">
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl h-[70px] flex items-center justify-center p-3 shadow-[0_2px_8px_rgba(0,0,0,0.03)] hover:border-gray-200 transition-colors hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b2/Bosch_logo.svg" alt="Bosch" class="h-6 opacity-90">
                        </div>
                    </div>

                    <!-- Inner Stats Row -->
                    <div class="border border-gray-100 rounded-xl shadow-[0_2px_8px_rgba(0,0,0,0.02)] py-5 px-2 mt-auto flex items-center justify-around bg-white">
                        <div class="text-center">
                            <div class="text-[17px] font-bold text-indigo-700 mb-0.5">120+</div>
                            <div class="text-[12px] text-[#64748B] font-bold">Exhibitors</div>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div class="text-center">
                            <div class="text-[17px] font-bold text-indigo-700 mb-0.5">8+</div>
                            <div class="text-[12px] text-[#64748B] font-bold">Countries</div>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div class="text-center">
                            <div class="text-[17px] font-bold text-indigo-700 mb-0.5">30K</div>
                            <div class="text-[12px] text-[#64748B] font-bold">Visitors</div>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div class="text-center">
                            <div class="text-[17px] font-bold text-indigo-700 mb-0.5">150+</div>
                            <div class="text-[12px] text-[#64748B] font-bold">Media</div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
