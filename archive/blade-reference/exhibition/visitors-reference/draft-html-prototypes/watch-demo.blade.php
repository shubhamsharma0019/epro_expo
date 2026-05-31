<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Watch Demo</title>
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
            
            <a href="exhibitor-details.html" class="inline-flex items-center gap-2 text-[#4A22E0] hover:text-[#3D1CBA] font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Company
            </a>
            
            <div class="mb-6">
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Watch Demo</h1>
                <p class="text-[13px] text-gray-500 font-medium">Explore product demos and presentations from the exhibitor.</p>
            </div>

            <div class="flex gap-8 max-w-[1500px]">
                
                <!-- Left: Video Area -->
                <div class="flex-1 flex flex-col min-w-[800px]">
                    
                    <!-- Company Info Bar -->
                    <div class="border border-gray-100 rounded-2xl bg-white p-4 shadow-sm flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-lg bg-[#0F172A] relative flex flex-col items-center justify-center shrink-0 shadow-inner">
                            <div class="text-blue-500 text-[18px] font-bold leading-none">TN</div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-1.5">
                                <h2 class="text-[15px] font-bold text-[#1E1B4B] tracking-tight">TechNext Solutions Pvt. Ltd.</h2>
                                <span class="bg-[#0D9488]/10 text-[#0D9488] text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Featured Exhibitor</span>
                            </div>
                            
                            <div class="flex items-center gap-4 text-[11px] font-medium text-gray-600">
                                <div>
                                    <span class="bg-primary-50 text-primary-600 font-bold px-2 py-0.5 rounded mr-3">AI & Automation</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-map-pin text-primary-500 text-[14px]"></i>
                                    <span class="text-[#1E1B4B]">Hall 1 – AI & IA, Booth 101</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-globe text-primary-500 text-[14px]"></i>
                                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors">www.technext.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <a href="exhibitor-details.html" class="border border-gray-200 text-[#4A22E0] hover:bg-primary-50 px-4 py-2 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                View Company Profile <i class="ph-bold ph-arrow-up-right"></i>
                            </a>
                            <button class="w-9 h-9 rounded-lg border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 flex items-center justify-center transition-colors shadow-sm">
                                <i class="ph-bold ph-dots-three-vertical text-[18px]"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Video Player Container -->
                    <div class="border border-gray-100 rounded-[20px] bg-[#020617] overflow-hidden shadow-md relative mb-6">
                        
                        <!-- Video Mock Background -->
                        <div class="aspect-video w-full relative">
                            <!-- Background Pattern/Image -->
                            <div class="absolute inset-0 opacity-50 bg-[url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center mix-blend-luminosity"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#020617] via-[#020617]/80 to-transparent"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 z-10 flex gap-2">
                                <div class="bg-[#4A22E0] text-white text-[11px] font-bold px-3 py-1 rounded">Featured Demo</div>
                            </div>
                            <div class="absolute top-4 right-4 z-10">
                                <button class="bg-black/50 hover:bg-black/70 backdrop-blur-sm border border-white/10 text-white px-3 py-1.5 rounded-lg text-[12px] font-bold transition-colors flex items-center gap-2">
                                    <i class="ph-bold ph-share-network"></i> Share
                                </button>
                            </div>
                            
                            <!-- Mock Video Content Overlay -->
                            <div class="absolute inset-0 flex items-center px-16 z-10">
                                <div>
                                    <h1 class="text-white text-[64px] font-bold leading-none tracking-tight mb-2">TNX</h1>
                                    <h2 class="text-[#8B5CF6] text-[48px] font-bold leading-none tracking-tight mb-6">AI Platform</h2>
                                    <p class="text-gray-300 text-[16px] font-medium tracking-wide">Intelligent. Automated. Future Ready.</p>
                                </div>
                            </div>
                            
                            <!-- Floating Tech Graphic (right side) -->
                            <div class="absolute right-16 top-1/2 -translate-y-1/2 z-10 opacity-80 mix-blend-screen pointer-events-none">
                                <img src="https://cdn-icons-png.flaticon.com/512/8637/8637099.png" alt="Brain AI" class="w-[300px] h-auto filter hue-rotate-180 brightness-150 contrast-125">
                            </div>

                            <!-- Video Controls Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent z-20">
                                <!-- Progress Bar -->
                                <div class="w-full h-1 bg-white/20 rounded-full mb-4 cursor-pointer relative">
                                    <div class="absolute left-0 top-0 bottom-0 w-[45%] bg-[#8B5CF6] rounded-full"></div>
                                    <div class="absolute left-[45%] top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full shadow-lg transform -translate-x-1/2"></div>
                                </div>
                                
                                <div class="flex items-center justify-between text-white">
                                    <div class="flex items-center gap-4">
                                        <button class="hover:text-[#8B5CF6] transition-colors"><i class="ph-fill ph-play text-[24px]"></i></button>
                                        <button class="hover:text-[#8B5CF6] transition-colors"><i class="ph-fill ph-speaker-high text-[24px]"></i></button>
                                        <span class="text-[12px] font-medium ml-2">0:00 / 6:45</span>
                                    </div>
                                    <div class="flex items-center gap-5">
                                        <button class="hover:text-[#8B5CF6] transition-colors text-[18px]"><i class="ph-bold ph-closed-captioning"></i></button>
                                        <button class="hover:text-[#8B5CF6] transition-colors text-[14px] font-bold">1x</button>
                                        <button class="hover:text-[#8B5CF6] transition-colors text-[20px]"><i class="ph-fill ph-gear"></i></button>
                                        <button class="hover:text-[#8B5CF6] transition-colors text-[20px]"><i class="ph-bold ph-corners-out"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Meta Data & Actions -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm mb-8 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <div class="flex items-start justify-between gap-8 mb-5">
                            <div>
                                <h2 class="text-[20px] font-bold text-[#1E1B4B] mb-3">TNX AI Platform – Product Demo</h2>
                                <p class="text-[13px] text-gray-600 leading-relaxed max-w-[700px]">Discover how TNX AI Platform helps enterprises automate workflows, gain actionable insights, and accelerate business growth with the power of AI.</p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <button class="border border-gray-200 text-[#4A22E0] hover:bg-primary-50 px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <i class="ph-bold ph-bookmark-simple text-[18px]"></i> Save for Later
                                </button>
                                <button onclick="window.location.href='request-meeting.html'" class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-5 py-2.5 rounded-lg font-bold text-[13px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <i class="ph-bold ph-calendar-plus text-[18px]"></i> Request Meeting
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6 text-[12px] font-medium text-gray-500">
                            <div class="flex items-center gap-1.5"><i class="ph-bold ph-clock text-[16px]"></i> 6:45 mins</div>
                            <div class="flex items-center gap-1.5"><i class="ph-bold ph-calendar-blank text-[16px]"></i> May 10, 2024</div>
                            <div class="flex items-center gap-1.5"><i class="ph-bold ph-eye text-[16px]"></i> 1,245 Views</div>
                        </div>
                    </div>

                    <!-- More Demos Section -->
                    <div class="pb-12">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px]">More Demos from TechNext Solutions Pvt. Ltd.</h3>
                            <div class="flex items-center gap-2">
                                <button class="w-8 h-8 rounded-full border border-gray-200 text-gray-400 hover:text-gray-800 hover:bg-white flex items-center justify-center transition-colors shadow-sm bg-gray-50">
                                    <i class="ph-bold ph-caret-left"></i>
                                </button>
                                <button class="w-8 h-8 rounded-full border border-gray-200 text-primary-600 hover:bg-white flex items-center justify-center transition-colors shadow-sm bg-white">
                                    <i class="ph-bold ph-caret-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            <!-- Demo 1 -->
                            <div class="group cursor-pointer">
                                <div class="aspect-video bg-[#020617] rounded-xl relative overflow-hidden mb-3">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center group-hover:scale-105 transition-transform duration-500"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white group-hover:bg-[#4A22E0] group-hover:border-[#4A22E0] transition-all">
                                            <i class="ph-fill ph-play text-[18px] ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">5:12</div>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 leading-tight group-hover:text-primary-600 transition-colors">TNX RPA Suite Overview</h4>
                                <div class="flex items-center gap-2 text-[10px] font-medium text-gray-500">
                                    <span>May 8, 2024</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>982 Views</span>
                                </div>
                            </div>

                            <!-- Demo 2 -->
                            <div class="group cursor-pointer">
                                <div class="aspect-video bg-[#020617] rounded-xl relative overflow-hidden mb-3">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center group-hover:scale-105 transition-transform duration-500"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white group-hover:bg-[#4A22E0] group-hover:border-[#4A22E0] transition-all">
                                            <i class="ph-fill ph-play text-[18px] ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">4:30</div>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 leading-tight group-hover:text-primary-600 transition-colors">Intelligent Automation in Action</h4>
                                <div class="flex items-center gap-2 text-[10px] font-medium text-gray-500">
                                    <span>May 6, 2024</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>765 Views</span>
                                </div>
                            </div>

                            <!-- Demo 3 -->
                            <div class="group cursor-pointer">
                                <div class="aspect-video bg-[#020617] rounded-xl relative overflow-hidden mb-3">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center group-hover:scale-105 transition-transform duration-500"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white group-hover:bg-[#4A22E0] group-hover:border-[#4A22E0] transition-all">
                                            <i class="ph-fill ph-play text-[18px] ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">7:18</div>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 leading-tight group-hover:text-primary-600 transition-colors">Data Insights & Analytics</h4>
                                <div class="flex items-center gap-2 text-[10px] font-medium text-gray-500">
                                    <span>May 3, 2024</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>1,102 Views</span>
                                </div>
                            </div>

                            <!-- Demo 4 -->
                            <div class="group cursor-pointer">
                                <div class="aspect-video bg-[#020617] rounded-xl relative overflow-hidden mb-3">
                                    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=400&auto=format&fit=crop')] bg-cover bg-center group-hover:scale-105 transition-transform duration-500"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white group-hover:bg-[#4A22E0] group-hover:border-[#4A22E0] transition-all">
                                            <i class="ph-fill ph-play text-[18px] ml-1"></i>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">3:45</div>
                                </div>
                                <h4 class="font-bold text-[#1E1B4B] text-[13px] mb-1.5 leading-tight group-hover:text-primary-600 transition-colors">TNX Platform – Key Features</h4>
                                <div class="flex items-center gap-2 text-[10px] font-medium text-gray-500">
                                    <span>Apr 30, 2024</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>689 Views</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar: Details Area -->
                <div class="w-[320px] shrink-0 flex flex-col gap-6 pb-12">
                    
                    <!-- Demo Details Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-5 border-b border-gray-100 pb-4">Demo Details</h3>
                        
                        <div class="flex flex-col gap-4 mb-5">
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-calendar-blank text-[16px]"></i></div>
                                <div class="text-[12px] font-bold text-[#1E1B4B] mt-0.5">May 10, 2024</div>
                            </div>
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-clock text-[16px]"></i></div>
                                <div class="text-[12px] font-bold text-[#1E1B4B] mt-0.5">11:00 AM IST (GMT +05:30)</div>
                            </div>
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-user text-[16px]"></i></div>
                                <div>
                                    <div class="text-[11px] text-gray-500 font-bold mb-0.5">Presented by</div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Rahul Sharma</div>
                                    <div class="text-[10px] text-gray-500 font-medium">Product Manager</div>
                                </div>
                            </div>
                        </div>

                        <button class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph-bold ph-calendar-plus text-[16px]"></i> Add to My Schedule
                        </button>
                    </div>

                    <!-- About This Demo -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-3">About This Demo</h3>
                        <p class="text-[12px] text-gray-600 leading-relaxed mb-3">In this demo, learn how the TNX AI Platform streamlines operations, reduces manual efforts, and delivers real-time insights to help you make smarter decisions.</p>
                        <button class="text-[#4A22E0] font-bold text-[11px] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">Show More <i class="ph ph-caret-down"></i></button>
                    </div>

                    <!-- Resources -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-4">Resources</h3>
                        
                        <div class="flex flex-col gap-4 mb-5">
                            <!-- Doc 1 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[24px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[11px] font-bold text-[#1E1B4B] leading-tight hover:text-primary-600 cursor-pointer transition-colors">TNX AI Platform Datasheet.pdf</div>
                                    <div class="text-[9px] text-gray-500 font-medium mt-0.5">2.4 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-7 h-7 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[14px]"></i></button>
                            </div>
                            
                            <!-- Doc 2 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[24px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[11px] font-bold text-[#1E1B4B] leading-tight hover:text-primary-600 cursor-pointer transition-colors">TNX Platform Brochure.pdf</div>
                                    <div class="text-[9px] text-gray-500 font-medium mt-0.5">3.1 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-7 h-7 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[14px]"></i></button>
                            </div>

                            <!-- Doc 3 -->
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-pdf text-red-500 text-[24px] shrink-0"></i>
                                <div class="flex-1">
                                    <div class="text-[11px] font-bold text-[#1E1B4B] leading-tight hover:text-primary-600 cursor-pointer transition-colors">Use Case – Manufacturing.pdf</div>
                                    <div class="text-[9px] text-gray-500 font-medium mt-0.5">1.8 MB</div>
                                </div>
                                <button class="text-primary-600 hover:bg-primary-50 w-7 h-7 rounded flex items-center justify-center transition-colors shrink-0"><i class="ph-bold ph-download-simple text-[14px]"></i></button>
                            </div>
                        </div>

                        <a href="resources.html" class="text-[11px] font-bold text-[#4A22E0] flex items-center gap-1 hover:text-[#3D1CBA] transition-colors">View All Resources <i class="ph ph-arrow-right"></i></a>
                    </div>

                    <!-- Need Help -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[14px] mb-2">Need Help?</h3>
                        <p class="text-[11px] text-gray-500 font-medium mb-4">Our team is here to help you.</p>
                        <button class="w-full border border-[#4A22E0] text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-lg font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph-bold ph-chat-circle-text text-[16px]"></i> Start Live Chat
                        </button>
                    </div>

                </div>

            </div>
            
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
