<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Pavilion Details</title>
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
        
        .badge { display: flex; items-center; gap: 8px; border: 1px solid #F1F5F9; border-radius: 8px; padding: 10px 16px; background-color: white; font-size: 12px; font-weight: 600; color: #475569; }
        .badge i { color: #10B981; font-size: 16px; }
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
                
                <!-- Left: Pavilion Details Area -->
                <div class="flex-1 flex flex-col min-w-[700px]">
                    
                    <a href="pavallion.html" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-bold text-[13px] mb-6 self-start">
                        <i class="ph-bold ph-arrow-left"></i> Back to Pavilions
                    </a>

                    <!-- Hero Pavilion Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] mb-8 flex flex-col lg:flex-row gap-8">
                        <div id="dyn-hero-bg" class="w-full lg:w-[400px] h-[260px] rounded-[16px] bg-[url('https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80')] bg-cover bg-center shrink-0 relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-900/30"></div>
                            <span id="dyn-hero-badge" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white font-bold text-2xl whitespace-nowrap tracking-wider drop-shadow-md">AI SOLUTIONS</span>
                        </div>

                        <div class="flex-1 flex flex-col pt-1">
                            <div class="mb-3">
                                <span class="bg-primary-600 text-white text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded">PAVILION</span>
                            </div>
                            <h1 id="dyn-title" class="text-[28px] font-bold text-[#1E1B4B] mb-2 tracking-tight">Technology & AI</h1>
                            <p id="dyn-subtitle" class="text-[14px] text-gray-500 font-medium mb-6">Innovate the future with intelligent solutions</p>
                            
                            <p id="dyn-desc" class="text-[13px] text-gray-600 leading-relaxed mb-8 pr-4">Step into the future with breakthrough technologies in artificial intelligence, machine learning, automation, data analytics, and next-gen enterprise solutions.</p>

                            <div class="flex items-center gap-6 text-[12px] font-bold text-gray-600 mb-8">
                                <div class="flex items-center gap-1.5"><i class="ph ph-users-three text-[20px] text-primary-500"></i> <span id="dyn-stat-companies">8+ Companies</span></div>
                                <div class="flex items-center gap-1.5"><i class="ph ph-cube text-[20px] text-primary-500"></i> <span id="dyn-stat-products">120+ Products</span></div>
                                <div class="flex items-center gap-1.5"><i class="ph ph-users text-[20px] text-primary-500"></i> <span id="dyn-stat-visitors">2,500+ Visitors</span></div>
                            </div>

                            <div class="flex items-center gap-2 mt-auto w-full">
                                <button onclick="window.location.href='view-floor-map.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[1.1] shadow-sm">
                                    <i class="ph ph-map-trifold text-[16px]"></i> View Floor Map
                                </button>
                                <button class="border border-primary-200 text-primary-600 hover:bg-primary-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph ph-bookmark-simple text-[16px] text-primary-500"></i> Add to My Visits
                                </button>
                                <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[0.9] shadow-sm">
                                    <i class="ph ph-share-network text-[16px]"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-8 border-b border-gray-100 mb-8 px-2">
                        <button class="text-primary-600 font-bold text-[14px] pb-4 border-b-2 border-primary-600">Overview</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Exhibitors (8)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Products (120+)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Sessions (6)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Resources</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Floor Plan</button>
                    </div>

                    <!-- Overview Content -->
                    <div class="flex gap-8 mb-12">
                        <!-- About -->
                        <div class="flex-1">
                            <h2 class="font-bold text-[#1E1B4B] text-[18px] mb-4">About This Pavilion</h2>
                            <div id="dyn-about-desc">
                                <p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">
                                    The Technology & AI Pavilion brings together leading innovators and solution providers who are transforming industries through artificial intelligence, machine learning, data analytics, cloud computing, and intelligent automation.
                                </p>
                                <p class="text-[13px] text-gray-600 leading-relaxed pr-6">
                                    Explore cutting-edge solutions, connect with experts, and discover how emerging technologies can drive growth and efficiency for your business.
                                </p>
                            </div>
                        </div>

                        <!-- Stats Box -->
                        <div class="w-[280px] shrink-0 bg-[#FAFAFC] rounded-2xl p-6 flex flex-col gap-5 border border-gray-100/50">
                            <div class="flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary-600 shadow-sm shrink-0 border border-gray-100">
                                    <i class="ph ph-tag text-[18px]"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-[#1E1B4B] mb-0.5">Category</div>
                                    <div id="dyn-cat" class="text-[11px] text-gray-500 font-medium">Technology</div>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary-600 shadow-sm shrink-0 border border-gray-100">
                                    <i class="ph ph-buildings text-[18px]"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-[#1E1B4B] mb-0.5">Companies</div>
                                    <div class="text-[11px] text-gray-500 font-medium">8+</div>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary-600 shadow-sm shrink-0 border border-gray-100">
                                    <i class="ph ph-cube text-[18px]"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-[#1E1B4B] mb-0.5">Products</div>
                                    <div class="text-[11px] text-gray-500 font-medium">120+</div>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary-600 shadow-sm shrink-0 border border-gray-100">
                                    <i class="ph ph-users text-[18px]"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-[#1E1B4B] mb-0.5">Visitors</div>
                                    <div class="text-[11px] text-gray-500 font-medium">2,500+</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Highlights -->
                    <div class="mb-12">
                        <h2 class="font-bold text-[#1E1B4B] text-[18px] mb-6">Highlights</h2>
                        <div class="grid grid-cols-5 gap-4 text-left">
                            <div>
                                <i class="ph ph-lightbulb text-[28px] text-primary-500 mb-3"></i>
                                <h4 class="font-bold text-[#1E1B4B] text-[12px] mb-1.5">Innovative Solutions</h4>
                                <p class="text-[10px] text-gray-500 leading-relaxed pr-2 font-medium">Explore next-gen AI & technology solutions</p>
                            </div>
                            <div>
                                <i class="ph ph-users text-[28px] text-primary-500 mb-3"></i>
                                <h4 class="font-bold text-[#1E1B4B] text-[12px] mb-1.5">Industry Leaders</h4>
                                <p class="text-[10px] text-gray-500 leading-relaxed pr-2 font-medium">Meet top technology companies & experts</p>
                            </div>
                            <div>
                                <i class="ph ph-rocket text-[28px] text-primary-500 mb-3"></i>
                                <h4 class="font-bold text-[#1E1B4B] text-[12px] mb-1.5">Live Demos</h4>
                                <p class="text-[10px] text-gray-500 leading-relaxed pr-2 font-medium">Experience live demos and product showcases</p>
                            </div>
                            <div>
                                <i class="ph ph-chart-line-up text-[28px] text-primary-500 mb-3"></i>
                                <h4 class="font-bold text-[#1E1B4B] text-[12px] mb-1.5">Business Growth</h4>
                                <p class="text-[10px] text-gray-500 leading-relaxed pr-2 font-medium">Discover solutions to accelerate your growth</p>
                            </div>
                            <div>
                                <i class="ph ph-share-network text-[28px] text-primary-500 mb-3"></i>
                                <h4 class="font-bold text-[#1E1B4B] text-[12px] mb-1.5">Networking</h4>
                                <p class="text-[10px] text-gray-500 leading-relaxed pr-2 font-medium">Connect with peers & build valuable partnerships</p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Exhibitors -->
                    <div class="mb-12 relative">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="font-bold text-[#1E1B4B] text-[18px]">Featured Exhibitors</h2>
                            <a href="#" class="text-primary-600 font-bold text-[13px] hover:underline flex items-center gap-1">View All Exhibitors <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="flex gap-4">
                            <!-- Card 1 -->
                            <div class="flex-1 bg-white border border-gray-100 rounded-[20px] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-start cursor-pointer hover:border-primary-200 transition-colors">
                                <div class="flex items-center gap-3 mb-8 w-full">
                                    <div class="w-12 h-12 bg-[#0B0F2A] rounded-xl flex items-center justify-center shrink-0">
                                        <div class="text-white text-[8px] text-center font-bold">TechNext<br>Solutions</div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-snug">TechNext Solutions<br>Pvt. Ltd.</h4>
                                        <p class="text-[10px] text-gray-500 font-medium mt-1">AI & Automation</p>
                                    </div>
                                </div>
                                <div class="font-bold text-primary-600 text-[12px] mt-auto">Booth T101</div>
                            </div>
                            
                            <!-- Card 2 -->
                            <div class="flex-1 bg-white border border-gray-100 rounded-[20px] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-start cursor-pointer hover:border-primary-200 transition-colors">
                                <div class="flex items-center gap-3 mb-8 w-full">
                                    <div class="w-12 h-12 bg-[#5A32FA] rounded-xl flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-chart-bar text-white text-[24px]"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-snug">InnovaAI Labs</h4>
                                        <p class="text-[10px] text-gray-500 font-medium mt-1">Machine Learning</p>
                                    </div>
                                </div>
                                <div class="font-bold text-primary-600 text-[12px] mt-auto">Booth T102</div>
                            </div>
                            
                            <!-- Card 3 -->
                            <div class="flex-1 bg-white border border-gray-100 rounded-[20px] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-start cursor-pointer hover:border-primary-200 transition-colors">
                                <div class="flex items-center gap-3 mb-8 w-full">
                                    <div class="w-12 h-12 bg-[#0EA5E9] rounded-xl flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-database text-white text-[24px]"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-snug">DataMind Analytics</h4>
                                        <p class="text-[10px] text-gray-500 font-medium mt-1">Data & Analytics</p>
                                    </div>
                                </div>
                                <div class="font-bold text-primary-600 text-[12px] mt-auto">Booth T103</div>
                            </div>
                            
                            <!-- Card 4 -->
                            <div class="flex-1 bg-white border border-gray-100 rounded-[20px] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-start cursor-pointer hover:border-primary-200 transition-colors">
                                <div class="flex items-center gap-3 mb-8 w-full">
                                    <div class="w-12 h-12 bg-[#0284C7] rounded-xl flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-cloud text-white text-[24px]"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-snug">CloudSphere Tech</h4>
                                        <p class="text-[10px] text-gray-500 font-medium mt-1">Cloud Computing</p>
                                    </div>
                                </div>
                                <div class="font-bold text-primary-600 text-[12px] mt-auto">Booth T104</div>
                            </div>

                            <button class="absolute -right-4 top-1/2 mt-4 bg-white border border-gray-200 shadow-md w-10 h-10 rounded-full flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="ph ph-caret-right text-[20px]"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Right: Sidebars -->
                <div class="w-[340px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Pavilion Info -->
                    <div class="bg-white rounded-2xl p-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-6">Pavilion Info</h3>
                        
                        <div class="flex flex-col gap-5">
                            <div class="flex items-start gap-4">
                                <i class="ph ph-map-pin text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B] mb-0.5">Location</div>
                                    <div class="text-[12px] text-gray-500 font-medium">Hall 1 - A</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <i class="ph ph-clock text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B] mb-0.5">Open Hours</div>
                                    <div class="text-[12px] text-gray-500 font-medium">May 15 – May 17, 2024<br>10:00 AM – 06:00 PM (IST)</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <i class="ph ph-users text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B] mb-0.5">Organized By</div>
                                    <div class="text-[12px] text-gray-500 font-medium">eproexpo</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <i class="ph ph-tag text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B] mb-0.5">Tags</div>
                                    <div class="text-[12px] text-gray-500 font-medium leading-relaxed">AI, Machine Learning, Automation, Data Analytics, Cloud, IoT</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Exhibitors -->
                    <div class="bg-white rounded-2xl p-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Top Exhibitors</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- 1 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#0B0F2A] flex items-center justify-center shrink-0">
                                        <div class="text-white text-[6px] text-center font-bold">TechNext<br>Solutions</div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">TechNext Solutions Pvt. Ltd.</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Booth T101</div>
                                    </div>
                                </div>
                                <div class="text-primary-300 group-hover:text-primary-600 transition-colors">
                                    <i class="ph ph-bookmark-simple text-[20px]"></i>
                                </div>
                            </div>
                            <!-- 2 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#5A32FA] flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-chart-bar text-white text-[20px]"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">InnovaAI Labs</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Booth T102</div>
                                    </div>
                                </div>
                                <div class="text-primary-300 group-hover:text-primary-600 transition-colors">
                                    <i class="ph ph-bookmark-simple text-[20px]"></i>
                                </div>
                            </div>
                            <!-- 3 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#0EA5E9] flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-database text-white text-[20px]"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">DataMind Analytics</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Booth T103</div>
                                    </div>
                                </div>
                                <div class="text-primary-300 group-hover:text-primary-600 transition-colors">
                                    <i class="ph ph-bookmark-simple text-[20px]"></i>
                                </div>
                            </div>
                            <!-- 4 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#0284C7] flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-cloud text-white text-[20px]"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">CloudSphere Tech</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Booth T104</div>
                                    </div>
                                </div>
                                <div class="text-primary-300 group-hover:text-primary-600 transition-colors">
                                    <i class="ph ph-bookmark-simple text-[20px]"></i>
                                </div>
                            </div>
                            <!-- 5 -->
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#0F172A] flex items-center justify-center shrink-0">
                                        <i class="ph-fill ph-eye text-white text-[20px]"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">SmartVision Systems</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Booth T105</div>
                                    </div>
                                </div>
                                <div class="text-primary-300 group-hover:text-primary-600 transition-colors">
                                    <i class="ph ph-bookmark-simple text-[20px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resources -->
                    <div class="bg-white rounded-2xl p-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Resources</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start justify-between group cursor-pointer">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-file-pdf text-[#EF4444] text-[24px] shrink-0 mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[12px] mb-0.5 leading-snug group-hover:text-primary-600 transition-colors">AI in Enterprise: Trends & Insights</div>
                                        <div class="text-[10px] text-gray-500 font-medium">PDF Document • 2.4 MB</div>
                                    </div>
                                </div>
                                <i class="ph ph-download-simple text-primary-500 group-hover:text-primary-700 text-[18px] shrink-0 mt-1"></i>
                            </div>
                            
                            <div class="flex items-start justify-between group cursor-pointer">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-file-pdf text-[#EF4444] text-[24px] shrink-0 mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[12px] mb-0.5 leading-snug group-hover:text-primary-600 transition-colors">The Future of Automation</div>
                                        <div class="text-[10px] text-gray-500 font-medium">PDF Document • 3.1 MB</div>
                                    </div>
                                </div>
                                <i class="ph ph-download-simple text-primary-500 group-hover:text-primary-700 text-[18px] shrink-0 mt-1"></i>
                            </div>
                            
                            <div class="flex items-start justify-between group cursor-pointer">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-file-pdf text-[#EF4444] text-[24px] shrink-0 mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[12px] mb-0.5 leading-snug group-hover:text-primary-600 transition-colors">Data Analytics Best Practices</div>
                                        <div class="text-[10px] text-gray-500 font-medium">PDF Document • 1.8 MB</div>
                                    </div>
                                </div>
                                <i class="ph ph-download-simple text-primary-500 group-hover:text-primary-700 text-[18px] shrink-0 mt-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Box -->
                    <div class="bg-primary-700 rounded-[20px] p-6 shadow-md relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="font-bold text-white text-[15px] mb-1">Don't miss anything!</h3>
                            <p class="text-[12px] text-primary-100 font-medium leading-relaxed mb-5">Add this pavilion to your visits and get personalized recommendations.</p>
                            <button class="w-full bg-white text-primary-700 hover:bg-gray-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="h-8"></div>
        </div>      </div>
    <script>
        const pavilionsData = {
            "tech": {
                title: "Technology & AI",
                badge: "AI SOLUTIONS",
                subtitle: "Innovate the future with intelligent solutions",
                desc: "Step into the future with breakthrough technologies in artificial intelligence, machine learning, automation, data analytics, and next-gen enterprise solutions.",
                bgImg: "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80",
                companies: "8+ Companies",
                products: "120+ Products",
                visitors: "2,500+ Visitors",
                category: "Technology",
                aboutDesc: `<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Technology & AI Pavilion brings together leading innovators and solution providers who are transforming industries through artificial intelligence, machine learning, data analytics, cloud computing, and intelligent automation.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore cutting-edge solutions, connect with experts, and discover how emerging technologies can drive growth and efficiency for your business.</p>`
            },
            "manufacturing": {
                title: "Manufacturing & Pharma",
                badge: "MANUFACTURING",
                subtitle: "Discover innovations in manufacturing and pharmaceutical industries.",
                desc: "Explore the latest in automated production lines, pharmaceutical research, and industrial automation shaping the future of global supply chains.",
                bgImg: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80",
                companies: "20+ Companies",
                products: "350+ Products",
                visitors: "4,200+ Visitors",
                category: "Manufacturing",
                aboutDesc: `<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Manufacturing & Pharma Pavilion showcases state-of-the-art production technologies and pharmaceutical breakthroughs.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Join industry leaders to explore automated manufacturing, quality control tech, and innovative supply chain solutions.</p>`
            },
            "smart": {
                title: "Smart Manufacturing",
                badge: "SMART FACTORY",
                subtitle: "Experience smart factories, automation, and industrial IoT.",
                desc: "Dive into the world of Industry 4.0 with live demonstrations of IoT devices, smart sensors, and fully automated robotics systems.",
                bgImg: "https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&w=800&q=80",
                companies: "15+ Companies",
                products: "200+ Products",
                visitors: "3,100+ Visitors",
                category: "Industrial IoT",
                aboutDesc: `<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Smart Manufacturing Pavilion is dedicated to the evolution of factories and production environments through connectivity.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Discover IoT solutions, advanced robotics, and real-time data analytics designed to maximize industrial efficiency.</p>`
            },
            "green": {
                title: "Green Energy",
                badge: "SUSTAINABILITY",
                subtitle: "Find sustainable energy solutions for a greener planet.",
                desc: "Discover solutions for a greener and sustainable tomorrow. Explore renewable energy sources, green tech, and ESG solutions.",
                bgImg: "https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80",
                companies: "50+ Companies",
                products: "85+ Products",
                visitors: "5,000+ Visitors",
                category: "Renewable Energy",
                aboutDesc: `<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Green Energy Pavilion brings together innovative companies focused on building a better, more sustainable future.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore products, solutions, and insights driving sustainability across industries, including solar, wind, and circular economy.</p>`
            },
            "startups": {
                title: "Startups",
                badge: "INNOVATION",
                subtitle: "Meet innovative startups and future disruptors.",
                desc: "Connect with the brightest minds and rising companies that are disrupting traditional industries with fresh ideas and agile execution.",
                bgImg: "https://images.unsplash.com/photo-1559136555-9ce7b5fda016?auto=format&fit=crop&w=800&q=80",
                companies: "60+ Companies",
                products: "150+ Products",
                visitors: "6,500+ Visitors",
                category: "Startups",
                aboutDesc: `<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Startups Pavilion is a buzzing hub of innovation, featuring young companies with groundbreaking technologies and solutions.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Network with founders, experience raw innovation, and discover the next big disruptors before they hit the mainstream market.</p>`
            }
        };

        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const pavilionId = params.get("id") || "tech";
            const data = pavilionsData[pavilionId] || pavilionsData["tech"];

            document.getElementById("dyn-title").textContent = data.title;
            document.getElementById("dyn-hero-badge").textContent = data.badge;
            document.getElementById("dyn-subtitle").textContent = data.subtitle;
            document.getElementById("dyn-desc").textContent = data.desc;
            document.getElementById("dyn-hero-bg").style.backgroundImage = `url('${data.bgImg}')`;
            document.getElementById("dyn-stat-companies").textContent = data.companies;
            document.getElementById("dyn-stat-products").textContent = data.products;
            document.getElementById("dyn-stat-visitors").textContent = data.visitors;
            document.getElementById("dyn-cat").textContent = data.category;
            document.getElementById("dyn-about-desc").innerHTML = data.aboutDesc;
        });
    </script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
