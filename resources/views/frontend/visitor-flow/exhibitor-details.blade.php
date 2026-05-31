<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Exhibitor Details</title>
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
    <div id="sidebar-container" class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white">@include('frontend.visitor-flow.sidebar')</div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative">@include('frontend.visitor-flow.header')</div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-gray-50 to-[#F5F3FF]">
            
            <a href="view-floor-map.html" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Hall 1 - AI & IA
            </a>

            <div class="flex flex-col lg:flex-row gap-8 max-w-[1500px]">
                
                <!-- Left: Main Exhibitor Details Area -->
                <div class="flex-1 flex flex-col min-w-0 w-full">
                    
                    <!-- Hero Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-6 shadow-sm mb-8 flex flex-col lg:flex-row gap-8">
                        <div class="w-full lg:w-[350px] h-[240px] rounded-[16px] bg-[#0F172A] relative flex items-center justify-center shrink-0">
                            <div class="absolute top-4 right-4 bg-[#0D9488] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Featured Exhibitor</div>
                            <div id="exh-booth-badge" class="absolute bottom-4 left-4 bg-white text-[#4A22E0] text-[12px] font-bold px-4 py-1.5 rounded-md shadow-sm">Booth 101</div>
                            <div class="flex flex-col items-center">
                                <div id="exh-logo-container" class="w-20 h-20 bg-blue-500 rounded-lg flex items-center justify-center mb-3">
                                    <div id="exh-logo-text" class="text-white text-[32px] font-bold">TN</div>
                                </div>
                                <div id="exh-subtitle" class="text-white font-bold text-[20px] tracking-wide">TechNext</div>
                                <div id="exh-subtitle2" class="text-gray-400 text-[12px] tracking-widest uppercase mt-1">Solutions</div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col pt-1">
                            <div class="flex justify-between items-start mb-3">
                                <h1 id="exh-name" class="text-[28px] font-bold text-[#1E1B4B] tracking-tight">TechNext Solutions Pvt. Ltd.</h1>
                                <i id="exh-bookmark-icon" class="ph ph-bookmark-simple text-primary-600 hover:text-primary-700 text-[24px] cursor-pointer transition-colors"></i>
                            </div>
                            
                            <div class="mb-5">
                                <span id="exh-category" class="bg-primary-50 text-primary-600 border border-primary-100 text-[11px] font-bold px-3 py-1.5 rounded-full inline-block">AI & Automation</span>
                            </div>
                            
                            <p id="exh-desc" class="text-[13px] text-gray-600 leading-relaxed mb-6 pr-4">Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-[12px] font-medium text-gray-600 mb-6">
                                <div class="flex items-center gap-2.5">
                                    <i class="ph ph-map-pin text-primary-500 text-[18px] shrink-0"></i>
                                    <div>
                                        <div id="exh-location" class="text-[#1E1B4B]">Hall 1 - AI & IA</div>
                                        <div id="exh-booth" class="text-gray-400 text-[11px]">Booth 101</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <i class="ph ph-globe text-primary-500 text-[18px] shrink-0"></i>
                                    <a id="exh-website" href="#" class="text-[#1E1B4B] hover:text-primary-600 transition-colors truncate">www.technext.com</a>
                                </div>
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <i class="ph ph-envelope-simple text-primary-500 text-[18px] shrink-0"></i>
                                    <a id="exh-email" href="#" class="text-[#1E1B4B] hover:text-primary-600 transition-colors truncate">info@technext.com</a>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <i class="ph ph-users text-primary-500 text-[18px] shrink-0"></i>
                                    <span id="exh-employees" class="text-[#1E1B4B]">45+ Employees</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <img id="exh-flag" src="https://flagcdn.com/in.svg" alt="India" class="w-5 h-3.5 object-cover rounded-sm border border-gray-200 shrink-0">
                                    <span id="exh-country" class="text-[#1E1B4B]">India</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-auto">
                                <button id="exh-bookmark-btn-1" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-[1.2] shadow-sm">
                                    <i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits
                                </button>
                                <button onclick="window.location.href='watch-demo.html'" class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph-bold ph-play-circle text-[18px]"></i> Watch Demo
                                </button>
                                <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-1 shadow-sm">
                                    <i class="ph ph-share-network text-[18px]"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col lg:flex-row gap-8 border-b border-gray-200 mb-8 px-2 select-none">
                        <button onclick="switchTab('overview', this)" class="tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">Overview</button>
                        <button onclick="switchTab('products', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Products (0)</button>
                        <button onclick="switchTab('documents', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Documents (0)</button>
                        <button onclick="switchTab('team', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Team (0)</button>
                        <button onclick="switchTab('videos', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Videos (0)</button>
                        <button onclick="switchTab('news', this)" class="tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Exhibitor News (0)</button>
                    </div>

                    <div id="tab-panels-container" class="w-full">
                        <!-- Overview Panel -->
                        <div id="panel-overview" class="tab-panel flex flex-col w-full">
                            <!-- About Section -->
                            <div class="mb-12">
                                <h3 id="exh-about-name" class="font-bold text-[#1E1B4B] text-[16px] mb-4">About TechNext Solutions</h3>
                                <div class="flex flex-col lg:flex-row gap-8 items-start">
                                    <div class="flex-1 text-[13px] text-gray-600 leading-relaxed">
                                        <p id="exh-about" class="mb-4">TechNext Solutions is a leading provider of AI, machine learning, and intelligent automation solutions. We help businesses transform operations, enhance customer experiences, and drive data-informed decisions.</p>
                                        <p id="exh-about2" class="mb-4">Our end-to-end services include AI consulting, custom software development, RPA, computer vision, and predictive analytics.</p>
                                        <button class="text-[#4A22E0] font-bold flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">See More <i class="ph ph-caret-down"></i></button>
                                    </div>
                                    
                                    <div class="w-full lg:w-[450px] shrink-0 bg-primary-50/50 rounded-[24px] p-6 grid grid-cols-1 sm:grid-cols-2 gap-6 border border-primary-50">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary-600 shadow-sm border border-primary-50 hover:-translate-y-1 hover:shadow-md transition-all duration-300"><i class="ph-bold ph-users text-[20px]"></i></div>
                                            <div>
                                                <div class="font-bold text-[#1E1B4B] text-[15px]">45+</div>
                                                <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wide">Employees</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary-600 shadow-sm border border-primary-50 hover:-translate-y-1 hover:shadow-md transition-all duration-300"><i class="ph-bold ph-calendar-blank text-[20px]"></i></div>
                                            <div>
                                                <div class="font-bold text-[#1E1B4B] text-[15px]">2018</div>
                                                <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wide">Founded</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary-600 shadow-sm border border-primary-50 hover:-translate-y-1 hover:shadow-md transition-all duration-300"><i class="ph-bold ph-kanban text-[20px]"></i></div>
                                            <div>
                                                <div class="font-bold text-[#1E1B4B] text-[15px]">350+</div>
                                                <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wide">Projects Completed</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary-600 shadow-sm border border-primary-50 hover:-translate-y-1 hover:shadow-md transition-all duration-300"><i class="ph-bold ph-globe-hemisphere-west text-[20px]"></i></div>
                                            <div>
                                                <div class="font-bold text-[#1E1B4B] text-[15px]">18+</div>
                                                <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wide">Countries Served</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- What We Do -->
                            <div class="mb-12">
                                <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-6">What We Do</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                    <div>
                                        <div class="text-primary-600 mb-3"><i class="ph-bold ph-brain text-[28px]"></i></div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2 leading-tight">AI & Machine Learning</h4>
                                        <p class="text-[12px] text-gray-500 leading-relaxed">Build intelligent models that learn and adapt.</p>
                                    </div>
                                    <div>
                                        <div class="text-primary-600 mb-3"><i class="ph-bold ph-cpu text-[28px]"></i></div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2 leading-tight">Intelligent Automation</h4>
                                        <p class="text-[12px] text-gray-500 leading-relaxed">Automate workflows and boost operational efficiency.</p>
                                    </div>
                                    <div>
                                        <div class="text-primary-600 mb-3"><i class="ph-bold ph-eye text-[28px]"></i></div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2 leading-tight">Computer Vision</h4>
                                        <p class="text-[12px] text-gray-500 leading-relaxed">Enable machines to see and understand.</p>
                                    </div>
                                    <div>
                                        <div class="text-primary-600 mb-3"><i class="ph-bold ph-chart-bar text-[28px]"></i></div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2 leading-tight">Data Analytics</h4>
                                        <p class="text-[12px] text-gray-500 leading-relaxed">Turn data into actionable business insights.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Grid Preview (Top 4) -->
                            <div class="pb-20">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="font-bold text-[#1E1B4B] text-[16px]">Our Products & Solutions</h3>
                                    <button onclick="switchTab('products', document.querySelector('.tab-btn[onclick*=\'products\']'))" class="text-[13px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View All Products <i class="ph ph-arrow-right"></i></button>
                                </div>
                                <div id="dyn-overview-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                                    <!-- Loaded dynamically -->
                                </div>
                            </div>
                        </div>

                        <!-- Products Panel -->
                        <div id="panel-products" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Exhibitor Products & Solutions</h2>
                            <div id="dyn-products-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Documents Panel -->
                        <div id="panel-documents" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Brochures & Downloadable PDF Documents</h2>
                            <div id="dyn-documents-list" class="space-y-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Team Panel -->
                        <div id="panel-team" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Meet the Team</h2>
                            <div id="dyn-team-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- Videos Panel -->
                        <div id="panel-videos" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Demo Videos & Showcases</h2>
                            <div id="dyn-videos-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>

                        <!-- News Panel -->
                        <div id="panel-news" class="tab-panel hidden border border-gray-100 rounded-[20px] p-8 shadow-[0_2px_15px_rgba(0,0,0,0.02)] bg-white mb-10 flex flex-col w-full">
                            <h2 class="text-[18px] font-bold text-[#1E1B4B] mb-6">Exhibitor News & Announcements</h2>
                            <div id="dyn-news-list" class="space-y-6">
                                <!-- Loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="w-full lg:w-[320px] shrink-0 flex flex-col gap-6">
                    
                    <!-- Interested CTA -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-1">Interested in this exhibitor?</h3>
                        <p class="text-[12px] text-gray-500 mb-5">Connect and explore opportunities.</p>
                        
                        <div class="flex flex-col gap-3">
                            <button onclick="window.location.href='watch-demo.html'" class="w-full bg-[#4A22E0] hover:bg-[#3D1CBA] text-white py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph-bold ph-play-circle text-[18px]"></i> Watch Demo
                            </button>
                            <button class="w-full border border-gray-200 text-gray-700 hover:bg-gray-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph ph-chat-circle-text text-[18px]"></i> Send Message
                            </button>
                            <button id="exh-bookmark-btn-2" class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits
                            </button>
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Company Information</h3>
                        
                        <div class="flex flex-col gap-5">
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 shrink-0"><i class="ph-bold ph-map-pin text-[14px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Headquarters</div>
                                    <div class="text-[11px] text-gray-500 font-medium mt-0.5">Bengaluru, Karnataka, India</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 shrink-0"><i class="ph-bold ph-calendar-blank text-[14px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Year Established</div>
                                    <div class="text-[11px] text-gray-500 font-medium mt-0.5">2018</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 shrink-0"><i class="ph-bold ph-buildings text-[14px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Company Type</div>
                                    <div class="text-[11px] text-gray-500 font-medium mt-0.5">Private Limited</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 shrink-0"><i class="ph-bold ph-share-network text-[14px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Social Media</div>
                                    <div class="flex items-center gap-3 mt-2 text-gray-400">
                                        <i class="fa-brands fa-linkedin-in hover:text-[#0077b5] cursor-pointer text-[14px] transition-colors border border-gray-200 rounded-full w-6 h-6 flex items-center justify-center hover:border-[#0077b5]"></i>
                                        <i class="fa-brands fa-twitter hover:text-[#1DA1F2] cursor-pointer text-[14px] transition-colors border border-gray-200 rounded-full w-6 h-6 flex items-center justify-center hover:border-[#1DA1F2]"></i>
                                        <i class="fa-brands fa-facebook-f hover:text-[#4267B2] cursor-pointer text-[14px] transition-colors border border-gray-200 rounded-full w-6 h-6 flex items-center justify-center hover:border-[#4267B2]"></i>
                                        <i class="fa-brands fa-youtube hover:text-[#FF0000] cursor-pointer text-[14px] transition-colors border border-gray-200 rounded-full w-6 h-6 flex items-center justify-center hover:border-[#FF0000]"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Representative -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5">Representative</h3>
                        
                        <div class="flex items-start gap-4 mb-5">
                            <img id="exh-rep-img" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Representative" class="w-12 h-12 rounded-full object-cover shadow-sm">
                            <div>
                                <h4 id="exh-rep-name" class="font-bold text-[#1E1B4B] text-[13px]">Rahul Sharma</h4>
                                <div id="exh-rep-title" class="text-[11px] text-gray-500 font-medium mb-2.5">Business Development Manager</div>
                                <div class="flex flex-col gap-2 text-[11px] text-gray-600">
                                    <div class="flex items-center gap-2 hover:text-primary-600 cursor-pointer transition-colors"><i class="ph-bold ph-envelope-simple text-primary-500"></i> <span id="exh-rep-email-text">rahul.sharma@technext.com</span></div>
                                    <div class="flex items-center gap-2 hover:text-primary-600 cursor-pointer transition-colors"><i class="ph-bold ph-phone text-primary-500"></i> <span id="exh-rep-phone">+91 98765 43210</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph ph-chat-circle-text text-[16px]"></i> Connect
                        </button>
                    </div>

                    <!-- Brochures & Documents -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[15px]">Brochures & Documents</h3>
                            <a href="resources.html" class="text-[12px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <!-- Doc 1 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[28px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[12px] font-bold text-[#1E1B4B] leading-tight">Company Profile 2024</div>
                                    <div class="text-[10px] text-gray-500 font-medium mt-0.5">PDF Document • 2.4 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-8 h-8 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[16px]"></i></button>
                            </div>
                            
                            <!-- Doc 2 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[28px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[12px] font-bold text-[#1E1B4B] leading-tight">AI Solutions Overview</div>
                                    <div class="text-[10px] text-gray-500 font-medium mt-0.5">PDF Document • 3.1 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-8 h-8 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[16px]"></i></button>
                            </div>
                            
                            <!-- Doc 3 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[28px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[12px] font-bold text-[#1E1B4B] leading-tight">Case Studies</div>
                                    <div class="text-[10px] text-gray-500 font-medium mt-0.5">PDF Document • 1.8 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-8 h-8 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[16px]"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </main>
    <script src="exhibition-api.js"></script>
    <script>
        function switchTab(tabId, el) {
            // Hide all tab panels
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            // Show target panel
            const activePanel = document.getElementById(`panel-${tabId}`);
            if (activePanel) {
                activePanel.classList.remove('hidden');
            }

            // Reset tab button styling
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors";
            });
            el.className = "tab-btn text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]";
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const exhibitorId = urlParams.get('id') || '101';
            
            // Fetch exhibitor details dynamically
            const data = await ExhibitionAPI.getExhibitor(exhibitorId);
            if (!data) return;

            // Split name to form a clean subtitle/logo representation
            const nameWords = data.name.split(' ');
            const sub = nameWords[0] || '';
            const sub2 = nameWords.slice(1).join(' ') || '';

            const elements = {
                'exh-name': data.name,
                'exh-subtitle': sub,
                'exh-subtitle2': sub2,
                'exh-category': data.category,
                'exh-desc': data.description,
                'exh-location': data.hall_name || 'Hall 1 - AI & IA',
                'exh-booth': data.booth_number || 'Booth 101',
                'exh-booth-badge': data.booth_number || 'Booth 101',
                'exh-website': data.website || 'www.exhibitor.com',
                'exh-employees': '45+ Employees',
                'exh-email': data.email || 'contact@exhibitor.com',
                'exh-country': data.country || 'India',
                'exh-about': data.description,
                'exh-about2': 'We look forward to demonstrating our cutting-edge capabilities and discussing potential partnerships with you at the exhibition.',
                'exh-rep-name': data.rep_name || 'Rahul Sharma',
                'exh-rep-title': data.rep_title || 'Representative',
                'exh-rep-email-text': data.rep_email || 'rep@exhibitor.com',
                'exh-rep-phone': data.rep_phone || '+91 98765 43210',
                'exh-about-name': 'About ' + sub
            };

            for (const [id, value] of Object.entries(elements)) {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            }
            
            // Set dynamic logo color class and logo text
            if (data.logo_color) {
                const logoContainer = document.getElementById('exh-logo-container');
                if (logoContainer) {
                    logoContainer.className = 'w-20 h-20 rounded-lg flex items-center justify-center mb-3 ' + data.logo_color;
                }
            }
            if (data.logo_text) {
                const logoTextEl = document.getElementById('exh-logo-text');
                if (logoTextEl) logoTextEl.innerHTML = data.logo_text;
            }

            if (data.rep_img_url) {
                const repImg = document.getElementById('exh-rep-img');
                if (repImg) repImg.src = data.rep_img_url;
            }
            
            // Set dynamic country flag
            const flagImg = document.getElementById('exh-flag');
            if (flagImg && data.country) {
                const countryLower = data.country.toLowerCase();
                let flagUrl = 'https://flagcdn.com/in.svg'; // Default
                if (countryLower.includes('united states') || countryLower.includes('us')) {
                    flagUrl = 'https://flagcdn.com/us.svg';
                } else if (countryLower.includes('united kingdom') || countryLower.includes('uk')) {
                    flagUrl = 'https://flagcdn.com/gb.svg';
                } else if (countryLower.includes('germany')) {
                    flagUrl = 'https://flagcdn.com/de.svg';
                } else if (countryLower.includes('canada')) {
                    flagUrl = 'https://flagcdn.com/ca.svg';
                }
                flagImg.src = flagUrl;
                flagImg.alt = data.country;
            }
            
            const websiteLink = document.getElementById('exh-website');
            if (websiteLink && data.website) {
                websiteLink.href = data.website.startsWith('http') ? data.website : 'https://' + data.website;
            }
            
            const emailLink = document.getElementById('exh-email');
            if (emailLink && data.email) {
                emailLink.href = 'mailto:' + data.email;
            }

            // Adjust back link text to match hall name
            const backLink = document.querySelector('main a[href="view-floor-map.html"]');
            if (backLink && data.hall_name) {
                backLink.innerHTML = `<i class="ph-bold ph-arrow-left"></i> Back to ${data.hall_name}`;
            }

            // Bind Send Message button to Request Meeting page instead
            const btnContainers = document.querySelectorAll('button');
            btnContainers.forEach(btn => {
                if (btn.textContent && btn.textContent.includes('Send Message')) {
                    btn.innerHTML = '<i class="ph ph-calendar-check text-[18px]"></i> Request Meeting';
                    btn.className = 'w-full bg-[#4A22E0] hover:bg-[#3D1CBA] text-white py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm';
                    btn.onclick = () => {
                        window.location.href = `request-meeting.html?id=${exhibitorId}`;
                    };
                }
                
                if (btn.textContent && btn.textContent.includes('Watch Demo')) {
                    btn.onclick = () => {
                        window.location.href = `watch-demo.html?id=${exhibitorId}`;
                    };
                }
            });

            // Fetch and set up Products tab details
            const products = await ExhibitionAPI.getProducts(exhibitorId);

            // Update Tab Count for Products
            const tabBtnProducts = document.querySelector('.tab-btn[onclick*="products"]');
            if (tabBtnProducts) {
                tabBtnProducts.textContent = `Products (${products.length})`;
            }

            // Populate Overview products preview (first 4 items)
            const overviewProductsGrid = document.getElementById("dyn-overview-products-grid");
            if (overviewProductsGrid) {
                if (products.length === 0) {
                    overviewProductsGrid.innerHTML = `<div class="text-gray-400 text-[12px]">No products catalogued.</div>`;
                } else {
                    let html = '';
                    products.slice(0, 4).forEach(p => {
                        const fallbackImg = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=400&q=80';
                        html += `
                            <div class="border border-gray-150 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col h-[280px]">
                                <div class="h-28 bg-gray-100 relative shrink-0">
                                    <img src="${p.image_url || fallbackImg}" alt="${p.name}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1 line-clamp-1">${p.name}</h4>
                                    <p class="text-[11px] text-gray-500 leading-normal line-clamp-3 mb-4">${p.description || ''}</p>
                                    ${p.price ? `<span class="mt-auto text-[11px] font-bold text-primary-600">₹${parseFloat(p.price).toLocaleString('en-IN')}</span>` : ''}
                                </div>
                            </div>
                        `;
                    });
                    overviewProductsGrid.innerHTML = html;
                }
            }

            // Populate Products grid in Products Panel
            const productsGrid = document.getElementById("dyn-products-grid");
            if (productsGrid) {
                if (products.length === 0) {
                    productsGrid.innerHTML = `<div class="text-gray-400 text-sm py-8 col-span-3 text-center bg-gray-50 rounded-xl">No products catalogued yet.</div>`;
                } else {
                    let html = '';
                    products.forEach(p => {
                        const fallbackImg = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=400&q=80';
                        html += `
                            <div class="border border-gray-150 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col h-[340px] hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                                <div class="h-40 bg-gray-100 relative shrink-0">
                                    <img src="${p.image_url || fallbackImg}" alt="${p.name}" class="w-full h-full object-cover">
                                    ${p.price ? `<span class="absolute top-3 right-3 bg-white text-primary-600 font-bold px-2.5 py-1 rounded-md text-[11px] shadow-sm">₹${parseFloat(p.price).toLocaleString('en-IN')}</span>` : ''}
                                </div>
                                <div class="p-5 flex flex-col flex-1">
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

            // Fetch and set up Documents (those with document_url)
            const docBrochures = products.filter(p => p.document_url);
            const tabBtnDocs = document.querySelector('.tab-btn[onclick*="documents"]');
            if (tabBtnDocs) {
                tabBtnDocs.textContent = `Documents (${docBrochures.length})`;
            }

            const docsList = document.getElementById("dyn-documents-list");
            if (docsList) {
                if (docBrochures.length === 0) {
                    docsList.innerHTML = `<div class="text-gray-400 text-sm py-8 text-center bg-gray-50 rounded-xl">No downloadable documents listed.</div>`;
                } else {
                    let html = '';
                    docBrochures.forEach(b => {
                        html += `
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50 hover:bg-white hover:border-primary-100 hover:shadow-sm transition-all duration-300 group cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300" onclick="window.open('${b.document_url}', '_blank')">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center text-red-500 shrink-0">
                                        <i class="ph ph-file-pdf text-[28px]"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-1 leading-snug group-hover:text-primary-600 transition-colors">${b.name}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium">PDF Document • ${(b.downloads_count % 3 + 1.5).toFixed(1)} MB</p>
                                    </div>
                                </div>
                                <button class="bg-white border border-gray-200 text-primary-600 hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] flex items-center gap-2 shadow-sm transition-colors">
                                    <i class="ph ph-download-simple"></i> Download
                                </button>
                            </div>
                        `;
                    });
                    docsList.innerHTML = html;
                }
            }

            // Team setup (1 DB representative + 2 mock profiles)
            const teamMembers = [
                { name: data.rep_name || 'Rahul Sharma', title: data.rep_title || 'Representative', email: data.rep_email || 'rep@exhibitor.com', phone: data.rep_phone || '+91 98765 43210', img: data.rep_img_url || 'https://randomuser.me/api/portraits/men/32.jpg', type: 'Lead' },
                { name: 'Jane Doe', title: 'Technical Director', email: 'jane.d@exhibitor.com', phone: '+91 98765 11111', img: 'https://randomuser.me/api/portraits/women/62.jpg', type: 'Engineering' },
                { name: 'John Smith', title: 'Solutions Architect', email: 'john.s@exhibitor.com', phone: '+91 98765 22222', img: 'https://randomuser.me/api/portraits/men/44.jpg', type: 'Architecture' }
            ];

            const tabBtnTeam = document.querySelector('.tab-btn[onclick*="team"]');
            if (tabBtnTeam) {
                tabBtnTeam.textContent = `Team (${teamMembers.length})`;
            }

            const teamGrid = document.getElementById("dyn-team-grid");
            if (teamGrid) {
                let html = '';
                teamMembers.forEach(member => {
                    html += `
                        <div class="border border-gray-150 rounded-2xl p-5 bg-white shadow-sm flex flex-col items-center text-center h-[260px] hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                            <span class="absolute top-3 left-3 bg-primary-50 text-primary-600 text-[9px] font-bold px-2 py-0.5 rounded">${member.type}</span>
                            <img src="${member.img}" alt="${member.name}" class="w-16 h-16 rounded-full object-cover shadow-sm mb-3">
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-0.5">${member.name}</h4>
                            <p class="text-[11px] text-gray-500 font-medium mb-3">${member.title}</p>
                            <div class="mt-auto w-full pt-3 border-t border-gray-50 flex flex-col gap-1.5 text-[10px] text-gray-600 font-semibold">
                                <div class="flex items-center justify-center gap-1.5"><i class="ph ph-envelope-simple text-primary-500"></i> ${member.email}</div>
                                <div class="flex items-center justify-center gap-1.5"><i class="ph ph-phone text-primary-500"></i> ${member.phone}</div>
                            </div>
                        </div>
                    `;
                });
                teamGrid.innerHTML = html;
            }

            // Fetch and set up Videos tab details
            const videos = await ExhibitionAPI.getExhibitorVideos(exhibitorId);
            const tabBtnVideos = document.querySelector('.tab-btn[onclick*="videos"]');
            if (tabBtnVideos) {
                tabBtnVideos.textContent = `Videos (${videos.length})`;
            }

            const videosGrid = document.getElementById("dyn-videos-grid");
            if (videosGrid) {
                if (videos.length === 0) {
                    videosGrid.innerHTML = `<div class="text-gray-400 text-sm py-8 col-span-3 text-center bg-gray-50 rounded-xl">No demo videos available.</div>`;
                } else {
                    let html = '';
                    videos.forEach(v => {
                        const fallbackVideoImg = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=400&q=80';
                        html += `
                            <div onclick="window.location.href='watch-demo.html?id=${exhibitorId}'" class="border border-gray-150 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col h-[260px] hover:-translate-y-1 hover:shadow-md transition-all duration-300 cursor-pointer relative group">
                                <div class="h-36 bg-gray-900 relative shrink-0 flex items-center justify-center">
                                    <img src="${v.thumbnail_url || fallbackVideoImg}" alt="${v.title}" class="w-full h-full object-cover opacity-75">
                                    <div class="absolute w-12 h-12 rounded-full bg-white/90 flex items-center justify-center text-primary-600 shadow-md group-hover:scale-110 transition-transform"><i class="ph-fill ph-play text-[20px]"></i></div>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1 line-clamp-1 group-hover:text-primary-600 transition-colors">${v.title}</h4>
                                    <p class="text-[11px] text-gray-500 leading-normal line-clamp-2">${v.description || ''}</p>
                                    <span class="mt-auto text-[10px] text-gray-400 font-bold">${v.duration || '02:30'}</span>
                                </div>
                            </div>
                        `;
                    });
                    videosGrid.innerHTML = html;
                }
            }

            // Exhibitor News setup (2 mock articles/announcements)
            const newsArticles = [
                { title: 'TechNext unveils new Enterprise AI Platform', summary: 'Today at EproExpo, we announced the launch of our next-gen enterprise intelligence core offering predictive process models and smart pipeline automation.', date: 'May 16, 2026' },
                { title: 'Strategic partnership announced with InnovaAI Labs', summary: 'We are glad to announce a mutual B2B analytics consulting partnership to build optimized logistics models for global manufacturing environments.', date: 'May 15, 2026' }
            ];

            const tabBtnNews = document.querySelector('.tab-btn[onclick*="news"]');
            if (tabBtnNews) {
                tabBtnNews.textContent = `Exhibitor News (${newsArticles.length})`;
            }

            const newsList = document.getElementById("dyn-news-list");
            if (newsList) {
                let html = '';
                newsArticles.forEach(item => {
                    html += `
                        <div class="p-5 border border-gray-100 rounded-xl bg-gray-50/50 hover:bg-white hover:border-primary-100 hover:shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <span class="text-[10px] text-primary-600 font-bold uppercase tracking-wider">${item.date}</span>
                            <h4 class="font-bold text-[#1E1B4B] text-[15px] mt-1 mb-2">${item.title}</h4>
                            <p class="text-[12px] text-gray-500 leading-relaxed font-medium">${item.summary}</p>
                        </div>
                    `;
                });
                newsList.innerHTML = html;
            }

            // Bookmark State & Interactivity
            const bookingId = localStorage.getItem('lastBookingId');
            if (bookingId) {
                try {
                    let bookmarks = await ExhibitionAPI.getBookmarks(bookingId);
                    let isBookmarked = bookmarks.some(b => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == exhibitorId);
                    
                    updateBookmarkUI(isBookmarked);

                    const elementsToBind = [
                        document.getElementById('exh-bookmark-icon'),
                        document.getElementById('exh-bookmark-btn-1'),
                        document.getElementById('exh-bookmark-btn-2')
                    ];

                    elementsToBind.forEach(el => {
                        if (el) {
                            el.addEventListener('click', async (e) => {
                                e.stopPropagation();
                                const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', exhibitorId);
                                if (res) {
                                    isBookmarked = res.status === 'added';
                                    updateBookmarkUI(isBookmarked);
                                }
                            });
                        }
                    });

                } catch (err) {
                    console.error('Error handling bookmark logic:', err);
                }
            }

            function updateBookmarkUI(bookmarked) {
                const iconEl = document.getElementById('exh-bookmark-icon');
                const btn1 = document.getElementById('exh-bookmark-btn-1');
                const btn2 = document.getElementById('exh-bookmark-btn-2');

                if (bookmarked) {
                    if (iconEl) iconEl.className = 'ph-fill ph-bookmark text-primary-600 hover:text-primary-700 text-[24px] cursor-pointer transition-colors';
                    if (btn1) {
                        btn1.innerHTML = '<i class="ph-fill ph-bookmark text-[18px]"></i> Remove from Visits';
                        btn1.className = 'bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-[1.2] shadow-sm';
                    }
                    if (btn2) {
                        btn2.innerHTML = '<i class="ph-fill ph-bookmark text-[18px]"></i> Remove from Visits';
                        btn2.className = 'w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm';
                    }
                } else {
                    if (iconEl) iconEl.className = 'ph ph-bookmark-simple text-primary-600 hover:text-primary-700 text-[24px] cursor-pointer transition-colors';
                    if (btn1) {
                        btn1.innerHTML = '<i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits';
                        btn1.className = 'bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-[1.2] shadow-sm';
                    }
                    if (btn2) {
                        btn2.innerHTML = '<i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits';
                        btn2.className = 'w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm';
                    }
                }
            }
        });
    </script>
    <script src="script.js"></script>
</body>
</html>
