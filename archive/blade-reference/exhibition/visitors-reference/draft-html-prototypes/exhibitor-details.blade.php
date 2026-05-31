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
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-gray-50 to-[#F5F3FF]">
            
            <a href="view-floor-map.html" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Hall 1 - AI & IA
            </a>

            <div class="flex gap-8 max-w-[1500px]">
                
                <!-- Left: Main Exhibitor Details Area -->
                <div class="flex-1 flex flex-col min-w-[800px]">
                    
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
                                <i class="ph ph-bookmark-simple text-primary-600 hover:text-primary-700 text-[24px] cursor-pointer transition-colors"></i>
                            </div>
                            
                            <div class="mb-5">
                                <span id="exh-category" class="bg-primary-50 text-primary-600 border border-primary-100 text-[11px] font-bold px-3 py-1.5 rounded-full inline-block">AI & Automation</span>
                            </div>
                            
                            <p id="exh-desc" class="text-[13px] text-gray-600 leading-relaxed mb-6 pr-4">Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.</p>

                            <div class="grid grid-cols-3 gap-y-4 gap-x-8 text-[12px] font-medium text-gray-600 mb-6">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-map-pin text-primary-500 text-[18px]"></i>
                                    <div>
                                        <div id="exh-location" class="text-[#1E1B4B]">Hall 1 - AI & IA</div>
                                        <div id="exh-booth" class="text-gray-400 text-[11px]">Booth 101</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-globe text-primary-500 text-[18px]"></i>
                                    <a id="exh-website" href="#" class="text-[#1E1B4B] hover:text-primary-600 transition-colors">www.technext.com</a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-users text-primary-500 text-[18px]"></i>
                                    <span id="exh-employees" class="text-[#1E1B4B]">45+ Employees</span>
                                </div>
                                <div class="col-start-2 flex items-center gap-2">
                                    <i class="ph ph-envelope-simple text-primary-500 text-[18px]"></i>
                                    <a id="exh-email" href="#" class="text-[#1E1B4B] hover:text-primary-600 transition-colors">info@technext.com</a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <img src="https://flagcdn.com/in.svg" alt="India" class="w-4 h-3 object-cover rounded-sm border border-gray-200">
                                    <span id="exh-country" class="text-[#1E1B4B]">India</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-auto">
                                <button class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 flex-[1.2] shadow-sm">
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
                    <div class="flex gap-8 border-b border-gray-200 mb-8 px-2">
                        <button class="text-[#4A22E0] font-bold text-[14px] pb-4 border-b-2 border-[#4A22E0]">Overview</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Products (12)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Documents (8)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Team (6)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Videos (3)</button>
                        <button class="text-gray-500 font-medium text-[14px] pb-4 border-b-2 border-transparent hover:text-gray-900 transition-colors">Exhibitor News (4)</button>
                    </div>

                    <!-- About Section -->
                    <div class="mb-12">
                        <h3 id="exh-about-name" class="font-bold text-[#1E1B4B] text-[16px] mb-4">About TechNext Solutions</h3>
                        <div class="flex gap-8 items-start">
                            <div class="flex-1 text-[13px] text-gray-600 leading-relaxed">
                                <p id="exh-about" class="mb-4">TechNext Solutions is a leading provider of AI, machine learning, and intelligent automation solutions. We help businesses transform operations, enhance customer experiences, and drive data-informed decisions.</p>
                                <p id="exh-about2" class="mb-4">Our end-to-end services include AI consulting, custom software development, RPA, computer vision, and predictive analytics.</p>
                                <button class="text-[#4A22E0] font-bold flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">See More <i class="ph ph-caret-down"></i></button>
                            </div>
                            
                            <div class="w-[450px] shrink-0 bg-primary-50/50 rounded-[24px] p-6 grid grid-cols-2 gap-6 border border-primary-50">
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
                        <div class="grid grid-cols-4 gap-6">
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

                    <!-- Products & Solutions -->
                    <div class="pb-20">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px]">Our Products & Solutions</h3>
                            <a href="#" class="text-[13px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View All Products <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-5">
                            <!-- Product 1 -->
                            <div class="border border-gray-100 rounded-[16px] bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="h-[120px] bg-[#020617] flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center"></div>
                                    <div class="relative z-10 text-blue-400 font-bold text-[24px] tracking-wider text-center">TNX <br><span class="text-blue-200 opacity-50 text-[14px]">Platform</span></div>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2">TNX AI Platform</h4>
                                    <p class="text-[11px] text-gray-500 leading-relaxed mb-4">End-to-end AI platform for model building, training & deployment.</p>
                                    <a href="#" class="text-[12px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View Product <i class="ph ph-arrow-right"></i></a>
                                </div>
                            </div>
                            
                            <!-- Product 2 -->
                            <div class="border border-gray-100 rounded-[16px] bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="h-[120px] bg-[#020617] flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center"></div>
                                    <div class="relative z-10 text-cyan-400 font-bold text-[24px] tracking-wider text-center">TNX <br><span class="text-cyan-200 opacity-50 text-[14px]">RPA Suite</span></div>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2">TNX RPA Suite</h4>
                                    <p class="text-[11px] text-gray-500 leading-relaxed mb-4">Robotic process automation solution to streamline business workflows.</p>
                                    <a href="#" class="text-[12px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View Product <i class="ph ph-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Product 3 -->
                            <div class="border border-gray-100 rounded-[16px] bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="h-[120px] bg-[#020617] flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center"></div>
                                    <div class="relative z-10 text-indigo-400 font-bold text-[24px] tracking-wider text-center">TNX <br><span class="text-indigo-200 opacity-50 text-[14px]">VisionPro</span></div>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2">TNX VisionPro</h4>
                                    <p class="text-[11px] text-gray-500 leading-relaxed mb-4">Computer vision API for real-time object detection and analytics.</p>
                                    <a href="#" class="text-[12px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View Product <i class="ph ph-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Product 4 -->
                            <div class="border border-gray-100 rounded-[16px] bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="h-[120px] bg-[#020617] flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center"></div>
                                    <div class="relative z-10 text-teal-400 font-bold text-[24px] tracking-wider text-center">TNX <br><span class="text-teal-200 opacity-50 text-[14px]">Insights</span></div>
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-2">TNX Insights</h4>
                                    <p class="text-[11px] text-gray-500 leading-relaxed mb-4">Advanced analytics platform for predictive business insights.</p>
                                    <a href="#" class="text-[12px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View Product <i class="ph ph-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="w-[320px] shrink-0 flex flex-col gap-6">
                    
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
                            <button class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
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

    <script src="script.js"></script>
</body>
</html>

