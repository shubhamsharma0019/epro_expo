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
        
        .badge { display: flex; align-items: center; gap: 8px; border: 1px solid #F1F5F9; border-radius: 8px; padding: 10px 16px; background-color: white; font-size: 12px; font-weight: 600; color: #475569; }
        .badge i { color: #10B981; font-size: 16px; }
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
                
                <!-- Left: Pavilion Details Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
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
                                <button onclick="window.location.href='halls.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[1.1] shadow-sm">
                                    <i class="ph ph-buildings text-[16px]"></i> View Halls
                                </button>
                                <button id="dyn-bookmark-btn" onclick="togglePavilionBookmark()" class="border border-primary-200 text-primary-600 hover:bg-primary-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph ph-bookmark-simple text-[16px] text-primary-500"></i> Add to My Visits
                                </button>
                                <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-2.5 rounded-lg font-bold text-[12px] whitespace-nowrap transition-colors flex items-center justify-center gap-2 flex-[0.9] shadow-sm">
                                    <i class="ph ph-share-network text-[16px]"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row gap-8 border-b border-gray-100 mb-8 px-2 select-none">
                        <button onclick="switchTab('overview', this)" class="tab-btn text-primary-600 font-bold text-[14px] pb-4 border-b-2 border-primary-600">Overview</button>
                        <button onclick="switchTab('exhibitors', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Exhibitors (0)</button>
                        <button onclick="switchTab('products', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Products (0)</button>
                        <button onclick="switchTab('sessions', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Sessions (0)</button>
                        <button onclick="switchTab('resources', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Resources</button>
                        <button onclick="switchTab('floorplan', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900">Floor Plan</button>
                    </div>

                    <div id="tab-panels-container">
                        <!-- Overview Panel -->
                        <div id="panel-overview" class="tab-panel flex flex-col">
                            <!-- Overview Content -->
                            <div class="flex flex-col lg:flex-row gap-8 mb-12">
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
                                <div class="w-full lg:w-[280px] shrink-0 bg-[#FAFAFC] rounded-2xl p-6 flex flex-col gap-5 border border-gray-100/50">
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
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 text-left">
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
                                
                                <div id="dyn-featured-exhibitors" class="flex gap-4 w-full overflow-x-auto pb-4 no-scrollbar">
                                    <!-- Dynamically loaded -->
                                </div>
                            </div>
                        </div>

                        <!-- Exhibitors Panel -->
                        <div id="panel-exhibitors" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Exhibitors in this Pavilion</h2>
                            <div id="dyn-exhibitors-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Products Panel -->
                        <div id="panel-products" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Featured Products & Innovations</h2>
                            <div id="dyn-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Sessions Panel -->
                        <div id="panel-sessions" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Pavilion Sessions & Live Events</h2>
                            <div id="dyn-sessions-list" class="space-y-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Resources Panel -->
                        <div id="panel-resources" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Downloadable Catalogues & Brochures</h2>
                            <div id="dyn-resources-list" class="space-y-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Floor Plan Panel -->
                        <div id="panel-floorplan" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Pavilion Halls & Booth Layout</h2>
                            <div id="dyn-halls-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right: Sidebars -->
                <div class="w-full lg:w-[340px] shrink-0 flex flex-col gap-6">
                    
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
                        
                        <div id="dyn-top-exhibitors" class="space-y-4">
                            <!-- Dynamically loaded -->
                        </div>
                    </div>

                    <!-- Resources -->
                    <div class="bg-white rounded-2xl p-6 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Resources</h3>
                            <a href="#" class="text-primary-600 font-bold text-[12px] hover:underline flex items-center gap-1">View All <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                        
                        <div id="dyn-resources" class="space-y-4">
                            <!-- Dynamically loaded -->
                        </div>
                    </div>

                    <!-- CTA Box -->
                    <div class="bg-primary-700 rounded-[20px] p-6 shadow-md relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="font-bold text-white text-[15px] mb-1">Don't miss anything!</h3>
                            <p class="text-[12px] text-primary-100 font-medium leading-relaxed mb-5">Add this pavilion to your visits and get personalized recommendations.</p>
                             <button id="dyn-cta-bookmark-btn" onclick="togglePavilionBookmark()" class="w-full bg-white text-primary-700 hover:bg-gray-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="h-8"></div>
        </div>      </div>
    <script src="exhibition-api.js"></script>
    <script>
        let isBookmarked = false;
        const params = new URLSearchParams(window.location.search);
        const pavilionId = params.get("id") || "tech";
        const bookingId = localStorage.getItem('lastBookingId');
        const activeExhibitionId = localStorage.getItem('activeExhibitionId') || '1';

        // Mappings of pavilion to exhibitor category
        function getPavilionCategories(pavId) {
            if (pavId === 'tech') return ['AI & Automation', 'Machine Learning', 'Data & Analytics', 'Cloud Computing'];
            if (pavId === 'manufacturing') return ['Manufacturing', 'Pharma'];
            if (pavId === 'smart') return ['Smart Manufacturing', 'Industrial IoT', 'Robotics'];
            if (pavId === 'green') return ['Green Energy', 'Sustainability', 'Renewable Energy'];
            if (pavId === 'startups') return ['Startups', 'Innovation'];
            return [];
        }

        // Mappings of pavilion to hall names (for filtering agenda sessions)
        function getPavilionHalls(pavId) {
            if (pavId === 'tech') return ['Keynote Hall A', 'Seminar Room 1', 'Seminar Room 2'];
            if (pavId === 'manufacturing') return ['Hall 4', 'Seminar Room 1'];
            if (pavId === 'smart') return ['Hall 4', 'Keynote Hall A'];
            if (pavId === 'green') return ['Hall 3', 'Seminar Room 2'];
            if (pavId === 'startups') return ['Hall 2', 'Seminar Room 1'];
            return [];
        }

        // Mappings of pavilion to physical hall IDs
        function getPavilionHallIds(pavId) {
            if (pavId === 'tech') return ['hall1', 'hall2'];
            if (pavId === 'manufacturing') return ['hall4'];
            if (pavId === 'smart') return ['hall4'];
            if (pavId === 'green') return ['hall3'];
            if (pavId === 'startups') return ['hall2'];
            return [];
        }

        // Switch tabs dynamically
        function switchTab(tabId, el) {
            // Hide all tab panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            
            // Show target tab panel
            const targetPanel = document.getElementById(`panel-${tabId}`);
            if (targetPanel) targetPanel.classList.remove('hidden');

            // Reset active tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = 'tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900';
            });

            // Set current tab button active styles
            el.className = 'tab-btn text-primary-600 font-bold text-[14px] pb-4 border-b-2 border-primary-600';
        }

        async function updateBookmarkUI() {
            const btn = document.getElementById("dyn-bookmark-btn");
            const ctaBtn = document.getElementById("dyn-cta-bookmark-btn");
            
            const btnHtml = isBookmarked 
                ? `<i class="ph-fill ph-bookmark-simple text-[16px] text-primary-500"></i> Remove from Visits`
                : `<i class="ph ph-bookmark-simple text-[16px] text-primary-500"></i> Add to My Visits`;
                
            const ctaBtnHtml = isBookmarked
                ? `<i class="ph-fill ph-bookmark-simple text-[18px]"></i> Remove from Visits`
                : `<i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits`;

            if (btn) btn.innerHTML = btnHtml;
            if (ctaBtn) ctaBtn.innerHTML = ctaBtnHtml;
        }

        async function togglePavilionBookmark() {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'pavilion', pavilionId);
            isBookmarked = (res.status === 'added');
            updateBookmarkUI();
        }

        // Helper to toggle exhibitor bookmark from lists
        async function toggleExhibitorBookmark(iconEl, exhibitorId) {
            if (!bookingId) {
                alert("Please select a pass and register first to save items to your visits!");
                window.location.href = "pass-selection.html";
                return;
            }
            const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', exhibitorId);
            const icon = iconEl.querySelector('i');
            if (res.status === 'added') {
                icon.className = 'ph-fill ph-bookmark-simple text-primary-600 text-[20px]';
            } else {
                icon.className = 'ph ph-bookmark-simple text-primary-300 group-hover:text-primary-600 text-[20px]';
            }
        }

        document.addEventListener("DOMContentLoaded", async () => {
            const data = await ExhibitionAPI.getPavilion(pavilionId);

            document.getElementById("dyn-title").textContent = data.title;
            document.getElementById("dyn-hero-badge").textContent = data.badge;
            document.getElementById("dyn-subtitle").textContent = data.subtitle;
            document.getElementById("dyn-desc").textContent = data.description || data.desc;
            document.getElementById("dyn-hero-bg").style.backgroundImage = `url('${data.image_url || data.bgImg}')`;
            document.getElementById("dyn-stat-companies").textContent = data.companies_count || data.companies;
            document.getElementById("dyn-stat-products").textContent = data.products_count || data.products;
            document.getElementById("dyn-stat-visitors").textContent = data.visitors_count || data.visitors;
            document.getElementById("dyn-cat").textContent = data.category;
            document.getElementById("dyn-about-desc").innerHTML = data.about_desc || data.aboutDesc;

            // Load bookmarks and update UI
            if (bookingId) {
                const bookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                isBookmarked = bookmarks.some(b => b.bookmarkable_type === 'pavilion' && b.bookmarkable_id === pavilionId);
                updateBookmarkUI();
            }

            // Fetch and filter exhibitors
            const allExhibitors = await ExhibitionAPI.getExhibitors(activeExhibitionId);
            const categories = getPavilionCategories(pavilionId);
            const filteredExhibitors = allExhibitors.filter(exh => categories.includes(exh.category));

            // Update Tab Count
            const tabBtnExhibitors = document.querySelector('.tab-btn[onclick*="exhibitors"]');
            if (tabBtnExhibitors) {
                tabBtnExhibitors.textContent = `Exhibitors (${filteredExhibitors.length})`;
            }

            // Populate Featured Exhibitors (in Overview Tab)
            const featuredContainer = document.getElementById("dyn-featured-exhibitors");
            if (featuredContainer) {
                if (filteredExhibitors.length === 0) {
                    featuredContainer.innerHTML = `<div class="text-[13px] text-gray-500 py-4">No exhibitors registered in this pavilion yet.</div>`;
                } else {
                    let html = '';
                    filteredExhibitors.forEach(exh => {
                        html += `
                            <div onclick="window.location.href='exhibitor-details.html?id=${exh.id}'" class="flex-1 min-w-[220px] max-w-[280px] bg-white border border-gray-100 rounded-[20px] p-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col items-start cursor-pointer hover:border-primary-200 transition-colors">
                                <div class="flex items-center gap-3 mb-8 w-full">
                                    <div class="w-12 h-12 ${exh.logo_color || 'bg-primary-600'} rounded-xl flex items-center justify-center shrink-0">
                                        <div class="text-white text-[10px] text-center font-bold">${exh.logo_text}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] leading-snug truncate">${exh.name}</h4>
                                        <p class="text-[10px] text-gray-500 font-medium mt-1">${exh.category}</p>
                                    </div>
                                </div>
                                <div class="font-bold text-primary-600 text-[12px] mt-auto">${exh.booth_number || 'Booth'}</div>
                            </div>
                        `;
                    });
                    featuredContainer.innerHTML = html;
                }
            }

            // Populate Exhibitors Grid (in Exhibitors Tab)
            const exhibitorsGrid = document.getElementById("dyn-exhibitors-grid");
            if (exhibitorsGrid) {
                if (filteredExhibitors.length === 0) {
                    exhibitorsGrid.innerHTML = `<div class="text-gray-400 text-sm">No exhibitors in this pavilion yet.</div>`;
                } else {
                    let html = '';
                    filteredExhibitors.forEach(exh => {
                        html += `
                            <div onclick="window.location.href='exhibitor-details.html?id=${exh.id}'" class="border border-gray-100 rounded-2xl bg-white p-6 shadow-sm flex flex-col hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-pointer">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold ${exh.logo_color || 'bg-primary-600'} text-[14px] shrink-0">
                                        ${exh.logo_text}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-[#1E1B4B] text-[15px] truncate">${exh.name}</h4>
                                        <p class="text-[11px] text-primary-600 font-semibold uppercase tracking-wider">${exh.booth_number || 'Booth'}</p>
                                    </div>
                                </div>
                                <p class="text-[12px] text-gray-500 font-medium line-clamp-3 leading-relaxed mb-4 flex-1">${exh.description || ''}</p>
                                <div class="flex items-center justify-between text-[11px] font-bold text-gray-600 pt-3 border-t border-gray-50 mt-auto">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-500">${exh.category}</span>
                                    <span class="text-primary-600 flex items-center gap-1">Profile <i class="ph ph-caret-right"></i></span>
                                </div>
                            </div>
                        `;
                    });
                    exhibitorsGrid.innerHTML = html;
                }
            }

            // Populate Top Exhibitors List (in Right Sidebar)
            const topContainer = document.getElementById("dyn-top-exhibitors");
            if (topContainer) {
                if (filteredExhibitors.length === 0) {
                    topContainer.innerHTML = `<div class="text-[12px] text-gray-400">No exhibitors.</div>`;
                } else {
                    // Load user bookmarks to show dynamic bookmark icons on exhibitors
                    let userBookmarks = [];
                    if (bookingId) {
                        userBookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                    }
                    
                    let html = '';
                    filteredExhibitors.forEach(exh => {
                        const isBookmarkedExh = userBookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exh.id);
                        const bookmarkIconClass = isBookmarkedExh ? 'ph-fill ph-bookmark-simple text-primary-600' : 'ph ph-bookmark-simple text-primary-300 group-hover:text-primary-600';
                        
                        html += `
                            <div class="flex items-center justify-between group cursor-pointer" onclick="window.location.href='exhibitor-details.html?id=${exh.id}'">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg ${exh.logo_color || 'bg-primary-600'} flex items-center justify-center shrink-0">
                                        <div class="text-white text-[8px] text-center font-bold">${exh.logo_text}</div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[13px] mb-0.5 group-hover:text-primary-600 transition-colors">${exh.name}</div>
                                        <div class="text-[11px] text-gray-500 font-medium">${exh.booth_number || 'Booth'}</div>
                                    </div>
                                </div>
                                <div class="cursor-pointer p-1" onclick="event.stopPropagation(); toggleExhibitorBookmark(this, ${exh.id})">
                                    <i class="${bookmarkIconClass} text-[20px]"></i>
                                </div>
                            </div>
                        `;
                    });
                    topContainer.innerHTML = html;
                }
            }

            // Fetch products/brochures for resources list & products tab
            let brochures = [];
            for (const exh of filteredExhibitors) {
                const products = await ExhibitionAPI.getProducts(exh.id);
                const mappedProducts = products.map(p => ({ ...p, exhibitorName: exh.name }));
                brochures = brochures.concat(mappedProducts);
            }

            // Update Tab Count for Products
            const tabBtnProducts = document.querySelector('.tab-btn[onclick*="products"]');
            if (tabBtnProducts) {
                tabBtnProducts.textContent = `Products (${brochures.length})`;
            }

            // Populate Products Grid (in Products Tab)
            const productsGrid = document.getElementById("dyn-products-grid");
            if (productsGrid) {
                if (brochures.length === 0) {
                    productsGrid.innerHTML = `<div class="text-gray-400 text-sm">No products listed in this pavilion yet.</div>`;
                } else {
                    let html = '';
                    brochures.forEach(p => {
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
                                        <span class="text-gray-400 font-medium">${p.downloads_count} downloads</span>
                                        ${p.document_url ? `<a href="${p.document_url}" target="_blank" class="text-primary-600 hover:underline flex items-center gap-1"><i class="ph ph-download-simple"></i> Brochure</a>` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    productsGrid.innerHTML = html;
                }
            }

            // Populate Resources List (in Right Sidebar Panel)
            const sidebarResourcesContainer = document.getElementById("dyn-resources");
            if (sidebarResourcesContainer) {
                const docsOnly = brochures.filter(p => p.document_url);
                if (docsOnly.length === 0) {
                    sidebarResourcesContainer.innerHTML = `<div class="text-[12px] text-gray-400">No resources available.</div>`;
                } else {
                    let html = '';
                    docsOnly.slice(0, 4).forEach(b => {
                        html += `
                            <div class="flex items-start justify-between group cursor-pointer" onclick="window.open('${b.document_url}', '_blank')">
                                <div class="flex items-start gap-3">
                                    <i class="ph ph-file-pdf text-[#EF4444] text-[24px] shrink-0 mt-0.5"></i>
                                    <div>
                                        <div class="font-bold text-[#1E293B] text-[12px] mb-0.5 leading-snug group-hover:text-primary-600 transition-colors">${b.name}</div>
                                        <div class="text-[10px] text-gray-500 font-medium">PDF Document • ${(b.downloads_count % 3 + 1.5).toFixed(1)} MB</div>
                                    </div>
                                </div>
                                <i class="ph ph-download-simple text-primary-500 group-hover:text-primary-700 text-[18px] shrink-0 mt-1"></i>
                            </div>
                        `;
                    });
                    sidebarResourcesContainer.innerHTML = html;
                }
            }

            // Populate Resources List (in Resources Tab Panel)
            const resourcesTabList = document.getElementById("dyn-resources-list");
            if (resourcesTabList) {
                const docsOnly = brochures.filter(p => p.document_url);
                if (docsOnly.length === 0) {
                    resourcesTabList.innerHTML = `<div class="text-gray-400 text-sm">No downloadable catalogues or brochures listed in this pavilion.</div>`;
                } else {
                    let html = '';
                    docsOnly.forEach(b => {
                        html += `
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50 hover:bg-white hover:border-primary-100 hover:shadow-sm transition-all duration-300 group cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300" onclick="window.open('${b.document_url}', '_blank')">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center text-red-500 shrink-0">
                                        <i class="ph ph-file-pdf text-[28px]"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1 leading-snug group-hover:text-primary-600 transition-colors">${b.name}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium">Provided by ${b.exhibitorName} • PDF Document • ${(b.downloads_count % 3 + 1.5).toFixed(1)} MB</p>
                                    </div>
                                </div>
                                <button class="bg-white border border-gray-200 text-primary-600 hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] flex items-center gap-2 shadow-sm transition-colors">
                                    <i class="ph ph-download-simple"></i> Download
                                </button>
                            </div>
                        `;
                    });
                    resourcesTabList.innerHTML = html;
                }
            }

            // Populate Sessions Tab
            const agenda = await ExhibitionAPI.getAgenda(activeExhibitionId);
            const pavHalls = getPavilionHalls(pavilionId);
            const filteredSessions = agenda.filter(s => pavHalls.some(h => s.hall_name.toLowerCase().includes(h.toLowerCase())));

            // Update Tab Count for Sessions
            const tabBtnSessions = document.querySelector('.tab-btn[onclick*="sessions"]');
            if (tabBtnSessions) {
                tabBtnSessions.textContent = `Sessions (${filteredSessions.length})`;
            }

            const sessionsList = document.getElementById("dyn-sessions-list");
            if (sessionsList) {
                if (filteredSessions.length === 0) {
                    sessionsList.innerHTML = `<div class="text-gray-400 text-sm">No conference sessions or keynotes scheduled in this pavilion.</div>`;
                } else {
                    let html = '';
                    filteredSessions.forEach(session => {
                        html += `
                            <div class="flex gap-6 items-start pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                <div class="w-[120px] shrink-0">
                                    <div class="text-primary-600 font-bold text-[14px] mb-0.5">${session.start_time}</div>
                                    <div class="text-gray-400 font-semibold text-[11px] uppercase">${session.end_time}</div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1.5">${session.title}</h3>
                                    <p class="text-gray-500 text-[13px] leading-relaxed mb-3">${session.description || ''}</p>
                                    <div class="flex flex-wrap gap-4 text-[12px] font-semibold text-gray-600">
                                        <div class="flex items-center gap-1.5"><i class="ph ph-user text-primary-500 text-[16px]"></i> ${session.speaker_name}</div>
                                        <div class="flex items-center gap-1.5"><i class="ph ph-map-pin text-primary-500 text-[16px]"></i> ${session.hall_name}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    sessionsList.innerHTML = html;
                }
            }

            // Populate Floor Plan Halls list
            const allHalls = await ExhibitionAPI.getHalls();
            const hallIds = getPavilionHallIds(pavilionId);
            const filteredHalls = allHalls.filter(h => hallIds.includes(h.id));

            const hallsGrid = document.getElementById("dyn-halls-grid");
            if (hallsGrid) {
                if (filteredHalls.length === 0) {
                    hallsGrid.innerHTML = `<div class="text-gray-400 text-sm">No exhibition halls mapped for this pavilion.</div>`;
                } else {
                    let html = '';
                    filteredHalls.forEach(hall => {
                        html += `
                            <div onclick="window.location.href='hall-details.html?id=${hall.id}'" class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="h-28 relative">
                                    <img src="${hall.image_url}" class="w-full h-full object-cover">
                                    <div class="absolute top-2 left-2 bg-[#4A22E0] text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">${hall.badge}</div>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 truncate">${hall.title}</h4>
                                    <p class="text-[11px] text-gray-500 font-medium line-clamp-2 leading-relaxed mb-3 flex-1">${hall.subtitle}</p>
                                    <div class="flex items-center justify-between text-[11px] font-bold text-indigo-700">
                                        <span>${hall.exhibitors_count} Exhibitors</span>
                                        <i class="ph ph-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    hallsGrid.innerHTML = html;
                }
            }
        });
    </script>
    <script src="script.js"></script>
</body>
</html>
