<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - All Booths</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE', 500: '#8B5CF6', 600: '#4A22E0', 700: '#3D1CBA', 800: '#2E159F' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAFAFA; }
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
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-gray-50 to-[#EDE9FE]">
            
            <a href="halls.html" class="inline-flex items-center gap-2 text-[#4A22E0] hover:text-[#3D1CBA] font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Hall
            </a>

            <div class="flex gap-8 max-w-[1500px]">
                
                <!-- Left: Main Content Area -->
                <div class="flex-1 flex flex-col min-w-[800px]">
                    
                    <!-- Hero Hall Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-5 shadow-sm mb-8 flex items-center gap-6">
                        <div class="w-[200px] h-[140px] rounded-[16px] relative overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80" alt="Hall" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 flex flex-col pt-1">
                            <div class="mb-2">
                                <span class="bg-[#4A22E0] text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wide">Hall 1</span>
                            </div>
                            <h1 class="text-[24px] font-bold text-[#1E1B4B] mb-1.5 tracking-tight">Hall 1 – AI & IA</h1>
                            <p class="text-[12px] text-gray-500 font-medium mb-4">Artificial Intelligence & Intelligent Automation solutions.</p>
                            
                            <div class="flex items-center gap-8 text-[11px] text-gray-600 font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-users text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">45+</span>
                                        <span>Exhibitors</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-newspaper-clipping text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">350+</span>
                                        <span>Products</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-bounding-box text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">12,500 sqm</span>
                                        <span>Total Area</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-storefront text-primary-500 text-[18px]"></i>
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-bold text-[#1E1B4B] text-[13px]">350+</span>
                                        <span>Booths</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons on far right -->
                        <div class="flex items-center gap-3 shrink-0 ml-auto mr-2">
                            <button class="border border-primary-200 text-[#4A22E0] hover:bg-primary-50 px-5 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                <i class="ph-bold ph-map-trifold text-[16px]"></i> View Floor Map
                            </button>
                            <button class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                <i class="ph-bold ph-bookmark-simple text-[16px]"></i> Add to My Visits
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-8 border-b border-gray-100 mb-6 px-2">
                        <button class="text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">All Booths</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Featured Exhibitors</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">By Category</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">By A - Z</button>
                    </div>

                    <!-- Search and Sort -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="relative w-[380px]">
                            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                            <input type="text" placeholder="Search by company name or booth number..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-[13px] font-medium focus:outline-none focus:border-primary-500 bg-white shadow-sm">
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <button class="w-8 h-8 rounded text-[#4A22E0] bg-primary-50 flex items-center justify-center shadow-sm">
                                    <i class="ph ph-squares-four text-[18px]"></i>
                                </button>
                                <button class="w-8 h-8 rounded text-gray-400 hover:text-gray-600 flex items-center justify-center transition-colors">
                                    <i class="ph ph-list-dashes text-[18px]"></i>
                                </button>
                            </div>
                            <button class="border border-gray-200 bg-white rounded-lg px-4 py-2 flex items-center justify-between min-w-[160px] text-[13px] font-bold text-gray-700 hover:bg-gray-50 shadow-sm">
                                Sort by: A - Z <i class="ph ph-caret-down text-gray-400"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Booths Grid -->
                    <div class="grid grid-cols-4 gap-4 pb-20">
                        <!-- Booth 101 -->
                        <div onclick="window.location.href='exhibitor-details.html?id=101'" class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 101</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] hover:text-primary-600 transition-colors"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#0F172A] flex items-center justify-center shrink-0 shadow-sm overflow-hidden mt-1">
                                    <div class="text-white text-[16px] font-bold flex flex-col items-center leading-none"><i class="ph-bold ph-cpu mb-0.5"></i> TechNext</div>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">TechNext Solutions Pvt. Ltd.</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">AI & Automation solutions for enterprises.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">AI & Automation</span>
                            </div>
                        </div>

                        <!-- Booth 102 -->
                        <div onclick="window.location.href='exhibitor-details.html?id=102'" class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 102</div>
                                <i class="ph ph-bookmark-simple text-indigo-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-indigo-600 flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-chart-bar text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">InnovaAI Labs</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Building intelligent models for real-world impact.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-indigo-50 border border-indigo-100 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Machine Learning</span>
                            </div>
                        </div>

                        <!-- Booth 103 -->
                        <div onclick="window.location.href='exhibitor-details.html?id=103'" class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 103</div>
                                <i class="ph ph-bookmark-simple text-blue-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-blue-600 flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-[18px] mt-1">
                                    <i class="ph-fill ph-database text-[20px] mr-1"></i> DataMind
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">DataMind Analytics</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Data analytics platforms for smarter decisions.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Data & Analytics</span>
                            </div>
                        </div>

                        <!-- Booth 104 -->
                        <div onclick="window.location.href='exhibitor-details.html?id=104'" class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-sky-50 text-sky-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 104</div>
                                <i class="ph ph-bookmark-simple text-sky-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#0F172A] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-cloud text-[24px] text-sky-400"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">CloudSphere Tech</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Scalable cloud solutions for modern businesses.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-sky-50 border border-sky-100 text-sky-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Cloud Computing</span>
                            </div>
                        </div>

                        <!-- Booth 105 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 105</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#0F172A] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-hexagon text-[28px] text-blue-400"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">SmartVision Systems</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Computer vision solutions for industry automation.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Computer Vision</span>
                            </div>
                        </div>
                        
                        <!-- Booth 106 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 106</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#0D9488] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-circles-three text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">Aivo Matrix</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">AI-powered chatbots and automation platform.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">AI & Automation</span>
                            </div>
                        </div>

                        <!-- Booth 107 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 107</div>
                                <i class="ph ph-bookmark-simple text-orange-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#F97316] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-robot text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">RoboticsCore</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Industrial robotics and smart factory solutions.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-orange-50 border border-orange-100 text-orange-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Robotics</span>
                            </div>
                        </div>

                        <!-- Booth 108 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 108</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#1E1B4B] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-fill ph-brain text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">NeuralSoft</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Deep learning applications for business growth.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">AI & Automation</span>
                            </div>
                        </div>
                        
                        <!-- Booth 109 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 109</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#059669] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-bold ph-share-network text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">CognifyAI</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Next-gen AI for predictive insights.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">AI & Automation</span>
                            </div>
                        </div>
                        
                        <!-- Booth 110 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 110</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#0F172A] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-bold ph-hexagon text-[24px] text-[#A855F7]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">InsightEdge</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Advanced analytics and AI consulting.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Data & Analytics</span>
                            </div>
                        </div>
                        
                        <!-- Booth 111 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 111</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#4A22E0] flex items-center justify-center shrink-0 shadow-sm text-white mt-1">
                                    <i class="ph-bold ph-robot text-[24px]"></i>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">AutoPilot RPA</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">RPA solutions to streamline business.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Robotics</span>
                            </div>
                        </div>
                        
                        <!-- Booth 112 -->
                        <div class="bg-white border border-gray-100 rounded-[16px] p-4 flex flex-col h-[220px] shadow-sm hover:shadow-md transition-shadow relative hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <div class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm">Booth 112</div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px]"></i>
                            </div>
                            <div class="flex gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-[#1D4ED8] flex items-center justify-center shrink-0 shadow-sm text-white font-bold text-[24px] mt-1">
                                    V
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-tight mb-1">VisionNova</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-snug">Empowering machines to see and understand.</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="bg-primary-50 border border-primary-100 text-primary-600 text-[10px] font-bold px-2 py-1 rounded inline-block">Computer Vision</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
