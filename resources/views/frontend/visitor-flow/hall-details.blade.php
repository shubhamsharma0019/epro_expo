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
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

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
                                        <div id="dyn-stat-booths" class="text-[12px] text-[#1E1B4B]"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-auto w-full">
                                <button onclick="window.location.href='view-floor-map.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[1.1] shadow-sm">
                                    <i class="ph ph-map-trifold text-[16px]"></i> View Floor Map
                                </button>
                                <button id="dyn-bookmark-btn" onclick="toggleHallBookmark()" class="border border-primary-200 text-primary-600 hover:bg-primary-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph ph-bookmark-simple text-[16px]"></i> Add to My Visits
                                </button>
                                <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[0.9] shadow-sm">
                                    <i class="ph ph-share-network text-[16px]"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row gap-8 border-b border-gray-100 mb-6 px-2 select-none">
                        <button onclick="switchTab('overview', this)" class="tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">Overview</button>
                        <button onclick="switchTab('exhibitors', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Exhibitors (0)</button>
                        <button onclick="switchTab('products', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Products (0)</button>
                        <button onclick="switchTab('featured', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Featured Exhibitors</button>
                        <button onclick="switchTab('amenities', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Amenities</button>
                        <button onclick="switchTab('access', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Access & Info</button>
                    </div>

                    <div id="tab-panels-container" class="w-full">
                        <!-- Overview Panel -->
                        <div id="panel-overview" class="tab-panel flex flex-col w-full">
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

                                <div class="flex flex-col md:flex-row gap-6">
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
                                        <div id="dyn-floor-map-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 w-full h-full relative">
                                            <!-- Dynamically loaded -->
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

                            <!-- Bottom Information Row -->
                            <div class="flex flex-col lg:flex-row gap-6 w-full mb-12">
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
                                    
                                    <div id="dyn-top-exhibitors" class="flex flex-col gap-4">
                                        <!-- Dynamically loaded -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exhibitors Panel -->
                        <div id="panel-exhibitors" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Exhibitors in this Hall</h2>
                            <div id="dyn-exhibitors-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Products Panel -->
                        <div id="panel-products" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Product Catalogues & Brochures</h2>
                            <div id="dyn-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Featured Exhibitors Panel -->
                        <div id="panel-featured" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Featured & Bookmarked Exhibitors</h2>
                            <div id="dyn-featured-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Amenities Panel -->
                        <div id="panel-amenities" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Facilities & Amenities in this Hall</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-left">
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-wifi-high"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">High-Speed Wi-Fi</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">Available throughout the hall. Connect to "EproExpo_FreeWiFi" with your booking reference ID.</p>
                                </div>
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-toilet"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Restrooms & Washrooms</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">Male, female, and accessible restrooms are located at the back-left corner of the hall near Service Gate B.</p>
                                </div>
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-first-aid"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">First-Aid Desk</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">Medical assistance desk and emergency care is active next to Entrance 1. Direct helpline: +91 99999-12345.</p>
                                </div>
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-coffee"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Cafeteria & Lounge</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">Grab a coffee, sandwich, or hot meals at our premium partner food courts located in the central passageway.</p>
                                </div>
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-info"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Information Kiosk</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">Get directions, print e-tickets, or find details about schedule, keynotes, and other halls.</p>
                                </div>
                                <div class="border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-all bg-gray-50/50">
                                    <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mb-4 text-[24px]">
                                        <i class="ph-bold ph-credit-card"></i>
                                    </div>
                                    <h4 class="font-bold text-[#1E1B4B] text-[15px] mb-1">ATM Machine</h4>
                                    <p class="text-[12px] text-gray-500 leading-relaxed">ATM services are available right outside the lobby entrance next to security clearance.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Access & Info Panel -->
                        <div id="panel-access" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Hall Access, Timings & Guide</h2>
                            <div class="space-y-6 text-left">
                                <div class="flex gap-4 items-start">
                                    <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center shrink-0"><i class="ph ph-map-pin text-[18px]"></i></div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px]">Physical Address & Access Points</h4>
                                        <p class="text-[12px] text-gray-500 mt-1 leading-relaxed">Exhibition Convention Centre, Level 1. Entry is allowed through Main Gate 1 & 2 for registered delegates. Exhibitor setup is accessible via Service Ramp 4.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center shrink-0"><i class="ph ph-clock text-[18px]"></i></div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px]">Visitor Timing Details</h4>
                                        <p class="text-[12px] text-gray-500 mt-1 leading-relaxed">The hall opens daily at 10:00 AM and closes at 06:00 PM. Registered visitors are advised to complete badge scanning at the registration counters before entering.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center shrink-0"><i class="ph ph-shield-check text-[18px]"></i></div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px]">Safety & Security Guidelines</h4>
                                        <p class="text-[12px] text-gray-500 mt-1 leading-relaxed">All visitors must keep their e-ticket badges visible. Smoking, firearms, and hazardous materials are strictly prohibited. Emergency exits are clearly marked on the floor map layout.</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center shrink-0"><i class="ph ph-question text-[18px]"></i></div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px]">Need Emergency Assistance?</h4>
                                        <p class="text-[12px] text-gray-500 mt-1 leading-relaxed">If you face any issues, visit the Information kiosk or reach out to security personnel on the floor. For remote support, contact our organizers desk via the Help Desk tab.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help Box (Bottom) -->
                    <div class="w-full bg-[#4A22E0] rounded-[24px] p-6 text-white shadow-sm flex flex-col sm:flex-row justify-between items-center gap-6 mb-12">
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


    <script src="exhibition-api.js"></script>
    <script>
        let isBookmarked = false;
        const params = new URLSearchParams(window.location.search);
        const hallId = params.get("id") || "hall1";
        const bookingId = localStorage.getItem('lastBookingId');
        const activeExhibitionId = localStorage.getItem('activeExhibitionId') || '1';

        function switchTab(tabId, el) {
            // Hide all panels
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            // Show target panel
            const targetPanel = document.getElementById(`panel-${tabId}`);
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }

            // Update tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900";
            });
            el.className = "tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]";
        }

        async function updateBookmarkUI() {
            const btn = document.getElementById("dyn-bookmark-btn");
            const btnHtml = isBookmarked 
                ? `<i class="ph-fill ph-bookmark-simple text-[16px] text-primary-500"></i> Remove from Visits`
                : `<i class="ph ph-bookmark-simple text-[16px]"></i> Add to My Visits`;
            if (btn) btn.innerHTML = btnHtml;
        }

        async function toggleHallBookmark() {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'hall', hallId);
            isBookmarked = (res.status === 'added');
            updateBookmarkUI();
        }

        // Layout representing grid items on the floor map
        const floorMapLayout = [
            { type: 'amenity', icon: 'ph-fill ph-toilet text-[24px]', bg: 'bg-map-amenities border border-blue-200 text-blue-600' },
            { type: 'booth', number: '01' },
            { type: 'booth', number: '02' },
            { type: 'booth', number: '03' },
            { type: 'booth', number: '04' },
            { type: 'booth', number: '05' },
            
            { type: 'booth', number: '07' },
            { type: 'booth', number: '08' },
            { type: 'booth', number: '09' },
            { type: 'booth', number: '10' },
            { type: 'booth', number: '11' },
            { type: 'booth', number: '14' },
            
            { type: 'booth', number: '15' },
            { type: 'premium', number: '16', colSpan: 2 },
            { type: 'premium', number: '17', colSpan: 2 },
            { type: 'booth', number: '19' },
            
            { type: 'amenity', icon: 'ph-fill ph-coffee text-[24px]', bg: 'bg-map-amenities border border-blue-200 text-blue-600' },
            { type: 'booth', number: '20' },
            { type: 'booth', number: '21' },
            { type: 'booth', number: '22' },
            { type: 'booth', number: '23' },
            { type: 'booth', number: '24' }
        ];

        document.addEventListener("DOMContentLoaded", async () => {
            const data = await ExhibitionAPI.getHall(hallId);

            document.getElementById("dyn-hall-badge").textContent = data.badge;
            document.getElementById("dyn-hall-title").textContent = data.title;
            document.getElementById("dyn-hall-subtitle").textContent = data.subtitle;
            document.getElementById("dyn-hall-desc").textContent = data.description || data.desc;
            document.getElementById("dyn-hall-img").src = data.image_url || data.img;
            
            document.getElementById("dyn-stat-cat").textContent = data.category || data.cat;
            document.getElementById("dyn-stat-area").textContent = data.area;
            document.getElementById("dyn-stat-exhibitors").textContent = data.exhibitors_count || data.exhibitors;
            document.getElementById("dyn-stat-booths").textContent = data.booths_count || data.booths;

            // Load bookmarks and update UI
            if (bookingId) {
                const bookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                isBookmarked = bookmarks.some(b => b.bookmarkable_type === 'hall' && b.bookmarkable_id === hallId);
                updateBookmarkUI();
            }

            // Fetch exhibitors for active exhibition
            const allExhibitors = await ExhibitionAPI.getExhibitors(activeExhibitionId);
            // Filter by hall name match (e.g. Hall 1)
            const hallExhibitors = allExhibitors.filter(exh => 
                exh.hall_name && exh.hall_name.toLowerCase().includes(data.badge.toLowerCase())
            );

            // Update Tab Count for Exhibitors
            const tabBtnExhibitors = document.querySelector('.tab-btn[onclick*="exhibitors"]');
            if (tabBtnExhibitors) {
                tabBtnExhibitors.textContent = `Exhibitors (${hallExhibitors.length})`;
            }

            // Populate Top Exhibitors list in Overview Panel
            const topExhibitorsContainer = document.getElementById("dyn-top-exhibitors");
            if (topExhibitorsContainer) {
                if (hallExhibitors.length === 0) {
                    topExhibitorsContainer.innerHTML = `<div class="text-[12px] text-gray-400">No exhibitors.</div>`;
                } else {
                    let userBookmarks = [];
                    if (bookingId) {
                        userBookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                    }
                    
                    let html = '';
                    hallExhibitors.forEach(exh => {
                        const isBookmarkedExh = userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id);
                        const bookmarkIconClass = isBookmarkedExh ? 'ph-fill ph-bookmark-simple text-primary-600' : 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700';
                        
                        html += `
                            <div class="flex items-center gap-3 border-b border-gray-100 pb-4 hover:bg-gray-50 p-2 -mx-2 rounded-lg transition-colors cursor-pointer" onclick="window.location.href='exhibitor-details.html?id=${exh.id}'">
                                <div class="w-10 h-10 ${exh.logo_color || 'bg-primary-600'} rounded-lg flex items-center justify-center text-white shrink-0 font-bold text-[14px]">
                                    ${exh.logo_text}
                                </div>
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">${exh.name}</div>
                                    <div class="text-[11px] text-gray-500 font-medium">${exh.booth_number || 'Booth'}</div>
                                </div>
                                <div class="p-1 cursor-pointer" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                                    <i class="${bookmarkIconClass} text-[18px]"></i>
                                </div>
                            </div>
                        `;
                    });
                    topExhibitorsContainer.innerHTML = html;
                }
            }

            // Render interactive Floor Map
            const mapContainer = document.getElementById("dyn-floor-map-grid");
            if (mapContainer) {
                // Get hall number prefix (e.g. Hall 1 -> 1, Hall 2 -> 2)
                const hallNum = data.badge.replace(/\D/g, '') || '1';
                let html = '';

                floorMapLayout.forEach(item => {
                    if (item.type === 'amenity') {
                        html += `<div class="${item.bg} rounded-md flex items-center justify-center h-16"><i class="${item.icon}"></i></div>`;
                    } else {
                        const boothNum = `${hallNum}${item.number}`;
                        // Find if there is an exhibitor in this booth
                        const exh = hallExhibitors.find(e => e.booth_number && e.booth_number.replace(/\D/g, '') === boothNum);

                        if (exh) {
                            // Booked Booth
                            html += `
                                <div onclick="window.location.href='exhibitor-details.html?id=${exh.id}'" class="bg-map-booked border border-indigo-300 rounded-md flex flex-col items-center justify-center text-indigo-900 h-16 cursor-pointer hover:border-primary-500 transition-colors ${item.colSpan ? 'col-span-' + item.colSpan : ''}">
                                    <div class="text-[11px] font-bold">${boothNum}</div>
                                    <div class="text-[9px] font-bold truncate max-w-full px-1">${exh.logo_text}</div>
                                </div>
                            `;
                        } else {
                            if (item.type === 'premium') {
                                // Premium available booth
                                html += `
                                    <div class="bg-map-premium border border-red-200 rounded-md flex flex-col items-center justify-center h-16 ${item.colSpan ? 'col-span-' + item.colSpan : ''}">
                                        <div class="text-[14px] font-bold text-red-800">${boothNum}</div>
                                        <div class="text-[8px] font-bold text-red-600 tracking-wider">PREMIUM</div>
                                    </div>
                                `;
                            } else {
                                // Available standard booth
                                html += `
                                    <div class="bg-map-available border border-green-200 rounded-md flex items-center justify-center text-[13px] font-bold text-green-800 h-16 ${item.colSpan ? 'col-span-' + item.colSpan : ''}">
                                        ${boothNum}
                                    </div>
                                `;
                            }
                        }
                    }
                });

                mapContainer.innerHTML = html;
            }

            // Fetch and set up Products tab details
            let hallProducts = [];
            for (const exh of hallExhibitors) {
                const products = await ExhibitionAPI.getProducts(exh.id);
                const mappedProducts = products.map(p => ({
                    ...p,
                    exhibitorName: exh.name,
                    logoColor: exh.logo_color,
                    logoText: exh.logo_text
                }));
                hallProducts = hallProducts.concat(mappedProducts);
            }

            const tabBtnProducts = document.querySelector('.tab-btn[onclick*="products"]');
            if (tabBtnProducts) {
                tabBtnProducts.textContent = `Products (${hallProducts.length})`;
            }

            // Populate Products grid
            const productsGrid = document.getElementById("dyn-products-grid");
            if (productsGrid) {
                if (hallProducts.length === 0) {
                    productsGrid.innerHTML = `<div class="text-gray-400 text-sm py-8 col-span-3 text-center bg-gray-50 rounded-xl">No products catalogued in this hall yet.</div>`;
                } else {
                    let html = '';
                    hallProducts.forEach(p => {
                        const fallbackImg = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=400&q=80';
                        html += `
                            <div class="border border-gray-150 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col h-[360px] hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <div class="h-40 bg-gray-100 relative shrink-0">
                                    <img src="${p.image_url || fallbackImg}" alt="${p.name}" class="w-full h-full object-cover">
                                    ${p.price ? `<span class="absolute top-3 right-3 bg-white text-primary-600 font-bold px-2.5 py-1 rounded-md text-[11px] shadow-sm">₹${parseFloat(p.price).toLocaleString('en-IN')}</span>` : ''}
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <span class="text-[9px] font-bold text-primary-600 uppercase tracking-wider mb-1">${p.exhibitorName}</span>
                                    <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1 line-clamp-1">${p.name}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed line-clamp-3 mb-4">${p.description || ''}</p>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-600">
                                        <span class="text-gray-400 font-medium">${p.downloads_count || 0} downloads</span>
                                        ${p.document_url ? `<a href="${p.document_url}" target="_blank" class="text-primary-600 hover:underline flex items-center gap-1"><i class="ph ph-download-simple"></i> Brochure</a>` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    productsGrid.innerHTML = html;
                }
            }

            // Populate Exhibitors grid
            const exhibitorsGrid = document.getElementById("dyn-exhibitors-grid");
            if (exhibitorsGrid) {
                if (hallExhibitors.length === 0) {
                    exhibitorsGrid.innerHTML = `<div class="text-gray-400 text-sm py-8 col-span-3 text-center bg-gray-50 rounded-xl">No exhibitors registered in this hall yet.</div>`;
                } else {
                    let userBookmarks = [];
                    if (bookingId) {
                        userBookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                    }
                    let html = '';
                    hallExhibitors.forEach(exh => {
                        const isBookmarkedExh = userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id);
                        const bookmarkIconClass = isBookmarkedExh ? 'ph-fill ph-bookmark-simple text-primary-600' : 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700';
                        
                        html += `
                            <div class="border border-gray-150 rounded-2xl p-5 bg-white shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col h-[220px]">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold ${exh.logo_color || 'bg-primary-600'} text-[14px] shrink-0">
                                            ${exh.logo_text}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#1E1B4B] text-[15px] line-clamp-1">${exh.name}</h4>
                                            <p class="text-[11px] text-primary-600 font-semibold uppercase tracking-wider">${exh.booth_number || 'Booth'}</p>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer p-1" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                                        <i class="${bookmarkIconClass} text-[20px]"></i>
                                    </div>
                                </div>
                                <p class="text-[12px] text-gray-500 font-medium line-clamp-3 leading-relaxed mb-4 flex-1">${exh.description || ''}</p>
                                <div class="flex items-center justify-between text-[11px] font-bold text-gray-600 pt-3 border-t border-gray-50 mt-auto">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500">${exh.category || 'AI & Automation'}</span>
                                    <a href="exhibitor-details.html?id=${exh.id}" class="text-primary-600 hover:underline flex items-center gap-1">Profile <i class="ph ph-caret-right"></i></a>
                                </div>
                            </div>
                        `;
                    });
                    exhibitorsGrid.innerHTML = html;
                }
            }

            // Populate Featured/Bookmarked Grid
            const featuredGrid = document.getElementById("dyn-featured-grid");
            if (featuredGrid) {
                let userBookmarks = [];
                if (bookingId) {
                    userBookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                }
                const bookmarkedExhibitorsInHall = hallExhibitors.filter(exh => 
                    userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id)
                );

                if (bookmarkedExhibitorsInHall.length === 0) {
                    // Fallback to top exhibitors if no bookmarks exist
                    const featuredList = hallExhibitors.slice(0, 2);
                    if (featuredList.length === 0) {
                        featuredGrid.innerHTML = `<div class="text-gray-400 text-sm py-8 col-span-3 text-center bg-gray-50 rounded-xl p-8">No featured exhibitors found. Bookmark exhibitors to view them here!</div>`;
                    } else {
                        let html = '';
                        featuredList.forEach(exh => {
                            const isBookmarkedExh = userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id);
                            const bookmarkIconClass = isBookmarkedExh ? 'ph-fill ph-bookmark-simple text-primary-600' : 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700';
                            html += `
                                <div class="border border-amber-250 rounded-2xl p-5 bg-gradient-to-br from-amber-50/20 to-white shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col h-[220px] relative overflow-hidden">
                                    <div class="absolute top-0 right-0 bg-amber-500 text-white text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-bl-lg">TOP</div>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold ${exh.logo_color || 'bg-primary-600'} text-[14px] shrink-0">
                                                ${exh.logo_text}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-[#1E1B4B] text-[15px] line-clamp-1">${exh.name}</h4>
                                                <p class="text-[11px] text-primary-600 font-semibold uppercase tracking-wider">${exh.booth_number || 'Booth'}</p>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer p-1" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                                            <i class="${bookmarkIconClass} text-[20px]"></i>
                                        </div>
                                    </div>
                                    <p class="text-[12px] text-gray-500 font-medium line-clamp-3 leading-relaxed mb-4 flex-1">${exh.description || ''}</p>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-gray-600 pt-3 border-t border-gray-50 mt-auto">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500">${exh.category || 'AI & Automation'}</span>
                                        <a href="exhibitor-details.html?id=${exh.id}" class="text-primary-600 hover:underline flex items-center gap-1">Profile <i class="ph ph-caret-right"></i></a>
                                    </div>
                                </div>
                            `;
                        });
                        featuredGrid.innerHTML = html;
                    }
                } else {
                    let html = '';
                    bookmarkedExhibitorsInHall.forEach(exh => {
                        html += `
                            <div class="border border-gray-150 rounded-2xl p-5 bg-white shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col h-[220px]">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold ${exh.logo_color || 'bg-primary-600'} text-[14px] shrink-0">
                                            ${exh.logo_text}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#1E1B4B] text-[15px] line-clamp-1">${exh.name}</h4>
                                            <p class="text-[11px] text-primary-600 font-semibold uppercase tracking-wider">${exh.booth_number || 'Booth'}</p>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer p-1" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                                        <i class="ph-fill ph-bookmark-simple text-primary-600 text-[20px]"></i>
                                    </div>
                                </div>
                                <p class="text-[12px] text-gray-500 font-medium line-clamp-3 leading-relaxed mb-4 flex-1">${exh.description || ''}</p>
                                <div class="flex items-center justify-between text-[11px] font-bold text-gray-600 pt-3 border-t border-gray-50 mt-auto">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500">${exh.category || 'AI & Automation'}</span>
                                    <a href="exhibitor-details.html?id=${exh.id}" class="text-primary-600 hover:underline flex items-center gap-1">Profile <i class="ph ph-caret-right"></i></a>
                                </div>
                            </div>
                        `;
                    });
                    featuredGrid.innerHTML = html;
                }
            }
        });

        // Helper to toggle exhibitor bookmark from list
        async function toggleExhibitorBookmark(iconEl, exhibitorId) {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', exhibitorId);
            const icon = iconEl.querySelector('i');
            if (res.status === 'added') {
                icon.className = 'ph-fill ph-bookmark-simple text-primary-600 text-[18px]';
            } else {
                icon.className = 'ph ph-bookmark-simple text-primary-500 hover:text-primary-700 text-[18px]';
            }
        }
    </script>
    <script src="script.js"></script>
</body>
</html>
