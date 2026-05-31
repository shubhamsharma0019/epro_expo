<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Halls</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: { 50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE', 500: '#8B5CF6', 600: '#4A22E0', 700: '#6D28D9' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-white relative">
        <div class="p-8 pb-20 w-full max-w-[1400px] mx-auto flex-1">
            
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-[32px] font-bold text-[#1E1B4B] mb-1">Halls</h1>
                <p class="text-[14px] text-gray-500 font-medium">Explore all exhibition halls and discover what's inside.</p>
            </div>

            <!-- Hero Banner -->
            <div class="w-full h-[220px] rounded-2xl relative overflow-hidden mb-6 bg-[url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A]/80 to-[#0F172A]/40"></div>
                <div class="relative z-10 flex flex-col h-full justify-center p-10 max-w-lg">
                    <h2 class="text-white text-[32px] font-bold mb-3 tracking-tight leading-tight">Explore<br>Exhibition Halls</h2>
                    <p class="text-gray-200 text-[14px] font-medium mb-6 leading-relaxed">Navigate through halls to find pavilions,<br>companies and product showcases.</p>
                    <button class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-6 py-2.5 rounded-lg font-bold text-[13px] flex items-center gap-2 w-max transition-colors">
                        <i class="ph ph-map-trifold text-[18px]"></i> View Floor Map
                    </button>
                </div>
            </div>

            <!-- Filters Row -->
            <div class="flex flex-wrap items-center gap-4 mb-8">
                <!-- Dropdown -->
                <button class="border border-gray-200 rounded-lg px-4 py-2.5 flex items-center justify-between min-w-[140px] text-[13px] font-bold text-gray-700 hover:bg-gray-50 bg-white">
                    <div class="flex items-center gap-2"><i class="ph ph-buildings text-[18px]"></i> All Halls</div>
                    <i class="ph ph-caret-down text-gray-400"></i>
                </button>

                <!-- Search -->
                <div class="flex-1 relative min-w-[250px]">
                    <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                    <input type="text" placeholder="Search halls or categories..." class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2.5 text-[13px] font-medium focus:outline-none focus:border-primary-500 bg-white">
                </div>

                <!-- Filters -->
                <button class="border border-gray-200 rounded-lg px-4 py-2.5 flex items-center gap-2 text-[13px] font-bold text-gray-700 hover:bg-gray-50 bg-white">
                    <i class="ph ph-tag text-[18px]"></i> Category <i class="ph ph-caret-down text-gray-400 ml-1"></i>
                </button>
                <button class="border border-gray-200 rounded-lg px-4 py-2.5 flex items-center gap-2 text-[13px] font-bold text-gray-700 hover:bg-gray-50 bg-white">
                    <i class="ph ph-shield-check text-[18px]"></i> Capacity <i class="ph ph-caret-down text-gray-400 ml-1"></i>
                </button>
                <button class="border border-gray-200 rounded-lg px-4 py-2.5 flex items-center gap-2 text-[13px] font-bold text-gray-700 hover:bg-gray-50 bg-white">
                    <i class="ph ph-star text-[18px]"></i> Amenities <i class="ph ph-caret-down text-gray-400 ml-1"></i>
                </button>
                
                <div class="w-px h-8 bg-gray-200 mx-1"></div>
                
                <div class="flex items-center gap-2 text-[13px] font-bold text-gray-700 mr-2">
                    Sort by: A - Z <i class="ph ph-caret-down text-gray-400"></i>
                </div>

                <div class="flex items-center gap-1">
                    <button class="w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center border border-primary-100">
                        <i class="ph ph-squares-four text-[20px]"></i>
                    </button>
                    <button class="w-10 h-10 rounded-lg text-gray-400 hover:bg-gray-50 flex items-center justify-center border border-transparent hover:border-gray-200 transition-colors">
                        <i class="ph ph-list-dashes text-[20px]"></i>
                    </button>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-4 gap-4 mb-8">
                <!-- Stat 1 -->
                <div class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 bg-[#FAFAFC]">
                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-primary-600 border border-gray-100">
                        <i class="ph ph-buildings text-[22px]"></i>
                    </div>
                    <div>
                        <div class="font-bold text-[18px] text-[#1E1B4B]">26+</div>
                        <div class="text-[12px] font-medium text-gray-500">Halls</div>
                    </div>
                </div>
                <!-- Stat 2 -->
                <div class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 bg-[#FAFAFC]">
                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-primary-600 border border-gray-100">
                        <i class="ph ph-users-three text-[22px]"></i>
                    </div>
                    <div>
                        <div class="font-bold text-[18px] text-[#1E1B4B]">120+</div>
                        <div class="text-[12px] font-medium text-gray-500">Exhibitors</div>
                    </div>
                </div>
                <!-- Stat 3 -->
                <div class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 bg-[#FAFAFC]">
                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-primary-600 border border-gray-100">
                        <i class="ph ph-desktop text-[22px]"></i>
                    </div>
                    <div>
                        <div class="font-bold text-[18px] text-[#1E1B4B]">2,500+</div>
                        <div class="text-[12px] font-medium text-gray-500">Companies</div>
                    </div>
                </div>
                <!-- Stat 4 -->
                <div class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 bg-[#FAFAFC]">
                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-primary-600 border border-gray-100">
                        <i class="ph ph-calendar-blank text-[22px]"></i>
                    </div>
                    <div>
                        <div class="font-bold text-[13px] text-[#1E1B4B]">May 15 – May 17, 2024</div>
                        <div class="text-[12px] font-medium text-gray-500">Event Dates</div>
                    </div>
                </div>
            </div>

            <!-- Halls Grid -->
            <div class="grid grid-cols-4 gap-6">
                <!-- Hall 1 -->
                <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col hover:-translate-y-1 transition-transform">
                    <div class="h-[160px] relative">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 bg-[#4A22E0] text-white text-[12px] font-bold px-3 py-1 rounded-md shadow-sm">Hall 1</div>
                        <div class="absolute bottom-3 right-3 bg-white text-[#4A22E0] text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">A & IA</div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Hall 1 – AI & IA</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Artificial Intelligence & Intelligent Automation solutions.</p>
                        
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-users text-gray-400"></i> 45+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Exhibitors</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-desktop text-gray-400"></i> 350+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Companies</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-bank text-gray-400"></i> 8</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Pavilions</div>
                            </div>
                        </div>
                        
                        <a href="hall-details.html?id=hall1" class="w-full bg-[#4A22E0] hover:bg-[#3D1CBA] text-white text-[13px] font-bold py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                            Explore Hall <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Hall 2 -->
                <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col hover:-translate-y-1 transition-transform">
                    <div class="h-[160px] relative">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 bg-[#D946EF] text-white text-[12px] font-bold px-3 py-1 rounded-md shadow-sm">Hall 2</div>
                        <div class="absolute bottom-3 right-3 bg-white text-[#D946EF] text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">Cloud</div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Hall 2 – Cloud & DevOps</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Cloud computing, DevOps, and infrastructure solutions.</p>
                        
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-users text-gray-400"></i> 38+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Exhibitors</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-desktop text-gray-400"></i> 280+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Companies</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-bank text-gray-400"></i> 6</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Pavilions</div>
                            </div>
                        </div>
                        
                        <a href="hall-details.html?id=hall2" class="w-full border border-[#D946EF] text-[#C026D3] hover:bg-[#FDF4FF] text-[13px] font-bold py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                            Explore Hall <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Hall 3 -->
                <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col hover:-translate-y-1 transition-transform">
                    <div class="h-[160px] relative">
                        <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 bg-[#F97316] text-white text-[12px] font-bold px-3 py-1 rounded-md shadow-sm">Hall 3</div>
                        <div class="absolute bottom-3 right-3 bg-white text-[#F97316] text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">Green</div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Hall 3 – Green Energy</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Renewable energy, sustainability, and environmental solutions.</p>
                        
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-users text-gray-400"></i> 32+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Exhibitors</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-desktop text-gray-400"></i> 220+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Companies</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-bank text-gray-400"></i> 5</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Pavilions</div>
                            </div>
                        </div>
                        
                        <a href="hall-details.html?id=hall3" class="w-full border border-[#F97316] text-[#EA580C] hover:bg-[#FFF7ED] text-[13px] font-bold py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                            Explore Hall <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Hall 4 -->
                <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col hover:-translate-y-1 transition-transform">
                    <div class="h-[160px] relative">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 bg-[#0D9488] text-white text-[12px] font-bold px-3 py-1 rounded-md shadow-sm">Hall 4</div>
                        <div class="absolute bottom-3 right-3 bg-white text-[#0D9488] text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">Manufacturing</div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-[#1E1B4B] text-[15px] mb-2">Hall 4 – Manufacturing</h3>
                        <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Smart manufacturing, robotics, and industrial automation.</p>
                        
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-users text-gray-400"></i> 40+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Exhibitors</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-desktop text-gray-400"></i> 310+</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Companies</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1.5 text-[13px] font-bold text-[#1E1B4B]"><i class="ph ph-bank text-gray-400"></i> 7</div>
                                <div class="text-[10px] text-gray-500 font-medium mt-0.5">Pavilions</div>
                            </div>
                        </div>
                        
                        <a href="hall-details.html?id=hall4" class="w-full border border-[#0D9488] text-[#0F766E] hover:bg-[#F0FDFA] text-[13px] font-bold py-2.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                            Explore Hall <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="h-10"></div> <!-- Bottom padding -->
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
