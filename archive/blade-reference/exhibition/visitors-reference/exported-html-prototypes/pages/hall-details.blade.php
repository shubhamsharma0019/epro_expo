<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Hall Details</title>
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
                        primary: { 50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE', 500: '#8B5CF6', 600: '#4A22E0', 700: '#3D1CBA', 800: '#2E159F' },
                        map: { available: '#DCFCE7', booked: '#E0E7FF', premium: '#FEE2E2', amenities: '#DBEAFE' }
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
            
            <a href="halls.html" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-bold text-[13px] mb-6">
                <i class="ph-bold ph-arrow-left"></i> Back to Halls
            </a>

            <div class="flex flex-col gap-8 max-w-[1500px] w-full">
                
                <!-- Main Hall Details Area -->
                <div class="w-full flex flex-col">
                    
                    <!-- Hero Hall Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-6 shadow-sm mb-8 flex flex-col gap-6">
                        <div class="flex flex-col lg:flex-row gap-8">
                        <div class="w-full lg:w-[400px] h-[260px] rounded-[16px] relative overflow-hidden shrink-0">
                            <img id="dyn-hall-img" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80" alt="Hall" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-[#4A22E0] text-white text-[13px] font-bold px-4 py-1.5 rounded-md shadow-sm" id="dyn-hall-badge">Hall 1</div>
                        </div>

                        <div class="flex-1 flex flex-col pt-1">
                            <h1 id="dyn-hall-title" class="text-[28px] font-bold text-[#1E1B4B] mb-2 tracking-tight">Hall 1 – AI & IA</h1>
                            <p id="dyn-hall-subtitle" class="text-[14px] text-gray-500 font-medium mb-5">Artificial Intelligence & Intelligent Automation solutions.</p>
                            
                            <p id="dyn-hall-desc" class="text-[13px] text-gray-600 leading-relaxed mb-6 pr-4">Explore the latest in AI, machine learning, robotic process automation, and intelligent systems that are transforming industries.</p>

                            <div class="flex items-center gap-6 text-[12px] font-bold text-gray-600 mb-6">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full border border-gray-100 flex items-center justify-center text-primary-600"><i class="ph ph-tag text-[18px]"></i></div>
                                    <div>
                                        <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Category</div>
                                        <div id="dyn-stat-cat" class="text-[12px] text-[#1E1B4B]">Technology</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full border border-gray-100 flex items-center justify-center text-primary-600"><i class="ph ph-bounding-box text-[18px]"></i></div>
                                    <div>
                                        <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Total Area</div>
                                        <div id="dyn-stat-area" class="text-[12px] text-[#1E1B4B]">12,500 sqm</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full border border-gray-100 flex items-center justify-center text-primary-600"><i class="ph ph-users text-[18px]"></i></div>
                                    <div>
                                        <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Exhibitors</div>
                                        <div id="dyn-stat-exhibitors" class="text-[12px] text-[#1E1B4B]">45+</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full border border-gray-100 flex items-center justify-center text-primary-600"><i class="ph ph-storefront text-[18px]"></i></div>
                                    <div>
                                        <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Booths</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-auto w-full">
                                <button onclick="window.location.href='view-floor-map.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[1.1] shadow-sm">
                                    <i class="ph ph-map-trifold text-[16px]"></i> View Floor Map
                                </button>
                                <button class="border border-primary-200 text-primary-600 hover:bg-primary-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph ph-bookmark-simple text-[16px]"></i> Add to My Visits
                                </button>
                                <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[0.9] shadow-sm">
                                    <i class="ph ph-share-network text-[16px]"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-8 border-b border-gray-100 mb-6 px-2">
                        <button class="text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">Overview</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Exhibitors (45+)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Products (350+)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Featured Exhibitors</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Amenities</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Access & Info</button>
                    </div>

                    <!-- Floor Map Visual -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm mb-12 relative overflow-hidden hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#1E1B4B] text-[18px]">Floor Map</h3>
                            
                            <div class="flex items-center gap-2">
                                <button class="border border-gray-200 rounded-lg px-4 py-2 flex items-center justify-between min-w-[120px] text-[12px] font-bold text-gray-700 hover:bg-gray-50">
                                    <i class="ph ph-user text-[16px] mr-2"></i> Level 1 <i class="ph ph-caret-down text-gray-400 ml-auto"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <!-- Legends -->
                            <div class="w-[140px] shrink-0 flex flex-col gap-4 pt-4 border-r border-gray-100 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded border border-green-200 bg-map-available"></div>
                                    <span class="text-[12px] font-medium text-gray-600">Available</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded border border-indigo-200 bg-map-booked"></div>
                                    <span class="text-[12px] font-medium text-gray-600">Booked</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded border border-yellow-200 bg-yellow-100"></div>
                                    <span class="text-[12px] font-medium text-gray-600">Reserved</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded border border-red-200 bg-map-premium"></div>
                                    <span class="text-[12px] font-medium text-gray-600">Premium</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded border border-blue-200 bg-map-amenities"></div>
                                    <span class="text-[12px] font-medium text-gray-600">Amenities</span>
                                </div>
                                <div class="flex items-center gap-3 mt-2">
                                    <i class="ph-bold ph-arrow-right text-red-500"></i>
                                    <span class="text-[12px] font-medium text-gray-600">Entrance / Exit</span>
                                </div>

                                <button class="mt-auto border border-primary-200 text-primary-600 bg-white hover:bg-primary-50 py-2 rounded-lg font-bold text-[12px] flex items-center justify-center gap-2">
                                    <i class="ph ph-download-simple text-[16px]"></i> Download Map
                                </button>
                            </div>

                            <!-- Interactive Map Area -->
                            <div class="flex-1 border-2 border-gray-300 rounded-lg p-6 relative bg-[#FAFAFA] min-h-[400px] flex items-center justify-center">
                                
                                <!-- Entrance Labels -->
                                <div class="absolute top-[-10px] left-1/2 -translate-x-1/2 bg-white px-2 text-[10px] font-bold text-gray-800 tracking-wider">MAIN ENTRANCE <i class="ph-bold ph-arrow-down text-red-500 ml-1"></i></div>
                                <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 bg-white px-2 text-[10px] font-bold text-gray-800 tracking-wider"><i class="ph-bold ph-arrow-up text-red-500 mr-1"></i> SERVICE ENTRANCE</div>

                                <!-- Grid Map -->
                                <div class="grid grid-cols-6 gap-3 w-full h-full relative">
                                    
                                    <!-- Row 1 -->
                                    <div class="bg-map-amenities border border-blue-200 rounded-md flex items-center justify-center text-blue-600"><i class="ph-fill ph-toilet text-[24px]"></i></div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">101</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">102</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">103</div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">104</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">105</div>
                                    
                                    <!-- Row 2 -->
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">107</div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">108</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">109</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">110</div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">111</div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">114</div>

                                    <!-- Row 3 (Premium) -->
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">115</div>
                                    <div class="col-span-2 bg-map-premium border border-red-200 rounded-md flex flex-col items-center justify-center h-16">
                                        <div class="text-[14px] font-bold text-red-800">116</div>
                                        <div class="text-[8px] font-bold text-red-600 tracking-wider">PREMIUM</div>
                                    </div>
                                    <div class="col-span-2 bg-map-premium border border-red-200 rounded-md flex flex-col items-center justify-center h-16">
                                        <div class="text-[14px] font-bold text-red-800">117</div>
                                        <div class="text-[8px] font-bold text-red-600 tracking-wider">PREMIUM</div>
                                    </div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">119</div>

                                    <!-- Row 4 -->
                                    <div class="bg-map-amenities border border-blue-200 rounded-md flex items-center justify-center text-blue-600"><i class="ph-fill ph-coffee text-[24px]"></i></div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">120</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">121</div>
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16">122</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">123</div>
                                    <div class="bg-map-booked border border-indigo-200 rounded-md flex items-center justify-center text-[13px] font-bold text-indigo-800 h-16">124</div>

                                </div>

                                <!-- Map Tools -->
                                <div class="absolute right-[-20px] top-1/2 -translate-y-1/2 flex flex-col gap-2 bg-white shadow-md border border-gray-100 rounded-lg p-1 z-10 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-50 rounded"><i class="ph ph-plus"></i></button>
                                    <div class="w-6 h-px bg-gray-200 mx-auto"></div>
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-50 rounded"><i class="ph ph-minus"></i></button>
                                    <div class="w-6 h-px bg-gray-200 mx-auto"></div>
                                    <button class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-50 rounded"><i class="ph ph-corners-out"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="text-[12px] text-gray-500 flex items-center gap-1.5"><i class="ph ph-info text-[16px]"></i> Click on any booth to view details</div>
                            <a href="view-floor-map.html" class="text-[13px] font-bold text-[#4A22E0] hover:text-[#3D1CBA] flex items-center gap-1">View All Booths <i class="ph ph-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Information Row -->
                <div class="flex flex-col gap-6 w-full mb-12">
                    
                    <!-- Top Row: Hall Info & Exhibitors -->
                    <div class="flex flex-col lg:flex-row gap-6 w-full">
                        <!-- Hall Information -->
                        <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-5">Hall Information</h3>
                        <div class="flex flex-col gap-5">
                            <div class="flex gap-3">
                                <i class="ph ph-map-pin text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Location</div>
                                    <div class="text-[12px] text-gray-500 font-medium">Exhibition Center, Level 1</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="ph ph-clock text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Open Hours</div>
                                    <div class="text-[12px] text-gray-500 font-medium leading-relaxed">May 15 – May 17, 2024<br>10:00 AM – 06:00 PM (IST)</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="ph ph-squares-four text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B] mb-1.5">Facilities</div>
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <i class="ph ph-wifi-high text-[16px]"></i>
                                        <i class="ph ph-wheelchair text-[16px]"></i>
                                        <i class="ph ph-coffee text-[16px]"></i>
                                        <i class="ph ph-first-aid text-[16px]"></i>
                                        <i class="ph ph-info text-[16px]"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="ph ph-buildings text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Nearby Amenities</div>
                                    <div class="text-[12px] text-gray-500 font-medium leading-relaxed">Food Court, Lounge, Parking, ATM</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="ph ph-user text-[20px] text-primary-500 shrink-0"></i>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Access</div>
                                    <div class="text-[12px] text-gray-500 font-medium">Entry from Main Lobby (Level 1)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Exhibitors -->
                    <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px]">Top Exhibitors</h3>
                            <a href="view-floor-map.html" class="text-[12px] font-bold text-[#4A22E0] hover:text-[#3D1CBA] flex items-center gap-1">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <div onclick="window.location.href='exhibitor-details.html?id=101'" class="flex items-center gap-3 border-b border-gray-100 pb-4 cursor-pointer hover:bg-gray-50 p-2 -mx-2 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-[#0F172A] rounded-lg flex items-center justify-center text-white font-bold text-[14px] shrink-0">TN</div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">TechNext Solutions Pvt. Ltd.</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Booth 101</div>
                                </div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] cursor-pointer"></i>
                            </div>
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white shrink-0"><i class="ph-fill ph-chart-bar text-[20px]"></i></div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">InnovaAI Labs</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Booth 116</div>
                                </div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] cursor-pointer"></i>
                            </div>
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-[14px] shrink-0">DM</div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">DataMind Analytics</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Booth 110</div>
                                </div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] cursor-pointer"></i>
                            </div>
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                                <div class="w-10 h-10 bg-sky-900 rounded-lg flex items-center justify-center text-white shrink-0"><i class="ph-fill ph-cloud text-[20px]"></i></div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">CloudSphere Tech</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Booth 123</div>
                                </div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] cursor-pointer"></i>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-blue-400 shrink-0"><i class="ph-fill ph-hexagon text-[20px]"></i></div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">SmartVision Systems</div>
                                    <div class="text-[11px] text-gray-500 font-medium">Booth 105</div>
                                </div>
                                <i class="ph ph-bookmark-simple text-primary-500 text-[18px] cursor-pointer"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Box (Bottom) -->
                <div class="w-full bg-[#4A22E0] rounded-[24px] p-6 text-white shadow-sm flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center shrink-0 hidden sm:flex">
                            <i class="ph-bold ph-headset text-[28px]"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="font-bold text-[20px] mb-1">Need Help?</h3>
                            <p class="text-[13px] text-primary-100">Our support team is always available on the exhibition floor to assist you with navigation, booth finding, or any general inquiries.</p>
                        </div>
                    </div>
                    <button class="bg-white text-[#4A22E0] hover:bg-gray-50 px-8 py-3.5 rounded-xl font-bold text-[14px] transition-colors flex items-center justify-center gap-2 shadow-sm shrink-0">
                        Contact Support
                    </button>
                </div>

            </div>
            
        </div>
    </main>

    <script>
        const hallsData = {
            "hall1": {
                badge: "Hall 1",
                title: "Hall 1 – AI & IA",
                subtitle: "Artificial Intelligence & Intelligent Automation solutions.",
                desc: "Explore the latest in AI, machine learning, robotic process automation, and intelligent systems that are transforming industries.",
                img: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80",
                cat: "Technology",
                area: "12,500 sqm",
                exhibitors: "45+",
                booths: "350+"
            },
            "hall2": {
                badge: "Hall 2",
                title: "Hall 2 – Cloud & DevOps",
                subtitle: "Cloud computing, DevOps, and infrastructure solutions.",
                desc: "Discover next-generation cloud platforms, containerization strategies, and robust DevOps pipelines accelerating digital transformation.",
                img: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80",
                cat: "Infrastructure",
                area: "10,000 sqm",
                exhibitors: "38+",
                booths: "280+"
            },
            "hall3": {
                badge: "Hall 3",
                title: "Hall 3 – Green Energy",
                subtitle: "Renewable energy, sustainability, and environmental solutions.",
                desc: "Connect with leaders in solar, wind, and sustainable manufacturing working towards a zero-carbon, greener future.",
                img: "https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80",
                cat: "Sustainability",
                area: "11,200 sqm",
                exhibitors: "32+",
                booths: "220+"
            },
            "hall4": {
                badge: "Hall 4",
                title: "Hall 4 – Manufacturing",
                subtitle: "Smart manufacturing, robotics, and industrial automation.",
                desc: "Experience live demonstrations of heavy machinery, smart factory layouts, and collaborative robotics on the exhibition floor.",
                img: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80",
                cat: "Industrial",
                area: "14,000 sqm",
                exhibitors: "40+",
                booths: "310+"
            }
        };

        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const hallId = params.get("id") || "hall1";
            const data = hallsData[hallId] || hallsData["hall1"];

            document.getElementById("dyn-hall-badge").textContent = data.badge;
            document.getElementById("dyn-hall-title").textContent = data.title;
            document.getElementById("dyn-hall-subtitle").textContent = data.subtitle;
            document.getElementById("dyn-hall-desc").textContent = data.desc;
            document.getElementById("dyn-hall-img").src = data.img;
            
            document.getElementById("dyn-stat-cat").textContent = data.cat;
            document.getElementById("dyn-stat-area").textContent = data.area;
            document.getElementById("dyn-stat-exhibitors").textContent = data.exhibitors;
            document.getElementById("dyn-stat-booths").textContent = data.booths;
        });
    </script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
