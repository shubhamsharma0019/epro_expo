<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Exhibition Management</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FC;
        }
        /* Custom scrollbar for main area */
        .main-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .main-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .main-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
        .main-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }
    
        /* Enterprise responsive fixes: prevent side scroll while keeping all data visible */
        html, body { max-width: 100%; overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        main, header, section, .main-scrollbar { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        input, select, textarea { max-width: 100%; }
        table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        th, td { white-space: normal !important; overflow-wrap: anywhere; word-break: break-word; vertical-align: top; }
        thead th { line-height: 1.25; letter-spacing: .02em; }
        .overflow-x-visible, .overflow-x-visible { overflow-x: visible !important; }
        .whitespace-normal { white-space: normal !important; }
        .no-scrollbar { scrollbar-width: none; }
        @media (max-width: 1280px) {
            .main-scrollbar { padding-left: 1rem !important; padding-right: 1rem !important; }
            th, td { padding-left: .75rem !important; padding-right: .75rem !important; font-size: 12px !important; }
            header input { width: 240px !important; }
            .tracking-wider { letter-spacing: .02em !important; }
        }
        @media (max-width: 1024px) {
            .lg\:flex-row { flex-direction: column !important; }
            .lg\:items-end { align-items: flex-start !important; }
            th, td { padding-left: .55rem !important; padding-right: .55rem !important; font-size: 11.5px !important; }
            .gap-6 { gap: 1rem !important; }
        }

    
        /* Blade alignment fixes: keep layout clean without horizontal page scroll */
        html, body { max-width: 100%; overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        main, header, section, .main-scrollbar, .grid, .flex-1 { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        input, select, textarea { max-width: 100%; }
        .max-w-\[1400px\] { max-width: min(1400px, 100%) !important; }
        .overflow-x-auto, .overflow-x-visible { overflow-x: hidden !important; }
        table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        th, td { white-space: normal !important; overflow-wrap: anywhere; word-break: break-word; vertical-align: top; }
        thead th { line-height: 1.25; letter-spacing: .02em; }
        @media (max-width: 768px) {
            header { padding-left: 1rem !important; padding-right: 1rem !important; }
            .px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
            .p-8, .lg\:p-8 { padding: 1rem !important; }
        }
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden m-0 p-0 text-[#1E293B]">
    
    <!-- Sidebar Container -->
    <div class="w-[260px] bg-[#0b132c] h-full shrink-0 hidden sm:block">
        @include('admin.shared.sidebar')
    </div>
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full min-w-0 bg-white">
        
        <!-- Topbar -->
        <header class="h-[76px] bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0 relative z-10">
            <!-- Left Side -->
            <div class="flex items-center gap-6">
                
                <div class="relative hidden sm:block">
                    <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" placeholder="Search anything..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-[320px] text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                </div>
            </div>
            
            <!-- Right Side -->
            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-gray-600 transition-colors sm:hidden">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">8</span>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-chat-circle-dots text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-blue-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">2</span>
                </button>
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=3723db&color=fff" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                    <div class="flex flex-col text-left hidden sm:flex">
                        <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                        <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                    </div>
                </button>
            </div>
        </header>

        <!-- Page Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar">
            <div class="max-w-[1400px] mx-auto">
                
                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Exhibition Management</h1>
                        <p class="text-gray-500 text-[14px]">Manage all exhibitions on the platform.</p>
                    </div>
                    <div>
                        <button onclick="window.location.href='08_add_exhibition.html'" class="flex items-center justify-center gap-2 bg-[#3723db] hover:bg-[#2515a6] text-white px-5 py-2.5 rounded-[10px] text-[14px] font-semibold shadow-md transition-all w-full sm:w-auto">
                            <i class="ph-bold ph-plus text-lg"></i> Add Exhibition
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Total Exhibitions -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-calendar-blank text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">89</span>
                            <span class="text-[12px] text-gray-500 font-medium">Total Exhibitions</span>
                        </div>
                    </div>
                    
                    <!-- Published -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">48</span>
                            <span class="text-[12px] text-gray-500 font-medium">Published</span>
                        </div>
                    </div>
                    
                    <!-- Upcoming -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-clock text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">14</span>
                            <span class="text-[12px] text-gray-500 font-medium">Upcoming</span>
                        </div>
                    </div>
                    
                    <!-- Draft -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-archive-box text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">9</span>
                            <span class="text-[12px] text-gray-500 font-medium">Draft</span>
                        </div>
                    </div>
                    
                    <!-- Past Exhibitions -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-cube text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">18</span>
                            <span class="text-[12px] text-gray-500 font-medium">Past Exhibitions</span>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                    <div class="relative w-full lg:w-auto">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search exhibitions..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-full lg:w-[320px] text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Status</option>
                                <option>Published</option>
                                <option>Upcoming</option>
                                <option>Draft</option>
                                <option>Past</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-auto">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Categories</option>
                                <option>Technology</option>
                                <option>Environment</option>
                                <option>Healthcare</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-lg px-3 py-2.5 shadow-sm w-full sm:w-auto">
                            <input type="text" placeholder="Start Date" class="w-[85px] text-[14px] text-gray-600 focus:outline-none bg-transparent" readonly>
                            <i class="ph ph-arrow-right text-gray-400 text-sm"></i>
                            <input type="text" placeholder="End Date" class="w-[80px] text-[14px] text-gray-600 focus:outline-none bg-transparent" readonly>
                            <i class="ph ph-calendar-blank text-gray-400 text-lg ml-1"></i>
                        </div>
                        <button class="flex items-center justify-center gap-2 bg-white border border-gray-200 text-[#3723db] px-4 py-2.5 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-gray-50 transition-colors w-full sm:w-auto">
                            <i class="ph ph-funnel text-lg"></i> Filters
                        </button>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm overflow-hidden mb-8">
                    <div class="overflow-x-visible">
                        <table class="w-full text-left border-collapse whitespace-normal">
                            <thead>
                                <tr class="text-[13px] text-gray-500 font-semibold border-b border-gray-100 bg-white">
                                    <th class="px-3 py-3">Exhibition Name</th>
                                    <th class="px-3 py-3 flex items-center gap-1 cursor-pointer hover:text-gray-700">Category <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-3 py-3">Venue</th>
                                    <th class="px-3 py-3 flex items-center gap-1 cursor-pointer hover:text-gray-700">Start Date <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-3 py-3 flex items-center gap-1 cursor-pointer hover:text-gray-700">End Date <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-3 py-3">Status</th>
                                    <th class="px-3 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px]">
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/tech1/120/90" alt="Global Tech Summit" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Global Tech Summit 2024</span>
                                                <span class="text-[12px] text-gray-500">The future of technology and innovation.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#F4F2FF] text-[#3723db] rounded border border-[#e9e4ff] text-[12px] font-bold">Technology</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Tech Expo Center,</span>
                                            <span class="text-gray-500 text-[12px]">New York, USA</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">May 15, 2024</span>
                                            <span class="text-gray-500 text-[12px]">10:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">May 17, 2024</span>
                                            <span class="text-gray-500 text-[12px]">06:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Published</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/env1/120/90" alt="Sustainable World Expo" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Sustainable World Expo</span>
                                                <span class="text-[12px] text-gray-500">Building a better and sustainable future.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Environment</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Green Arena,</span>
                                            <span class="text-gray-500 text-[12px]">London, UK</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jun 10, 2024</span>
                                            <span class="text-gray-500 text-[12px]">09:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jun 12, 2024</span>
                                            <span class="text-gray-500 text-[12px]">05:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Upcoming</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/health1/120/90" alt="Healthcare Innovation" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Healthcare Innovation Expo</span>
                                                <span class="text-[12px] text-gray-500">Innovations shaping the future of healthcare.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6F5FF] text-[#0095FF] rounded border border-[#bae6fd] text-[12px] font-bold">Healthcare</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Health Hub Center,</span>
                                            <span class="text-gray-500 text-[12px]">Berlin, Germany</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jul 20, 2024</span>
                                            <span class="text-gray-500 text-[12px]">09:30 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jul 22, 2024</span>
                                            <span class="text-gray-500 text-[12px]">05:30 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Upcoming</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/manuf1/120/90" alt="Smart Manufacturing Expo" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Smart Manufacturing Expo</span>
                                                <span class="text-[12px] text-gray-500">Advanced solutions for modern industries.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Manufacturing</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Industrial World,</span>
                                            <span class="text-gray-500 text-[12px]">Chicago, USA</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Apr 05, 2024</span>
                                            <span class="text-gray-500 text-[12px]">10:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Apr 07, 2024</span>
                                            <span class="text-gray-500 text-[12px]">06:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Published</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/edu1/120/90" alt="Future of Education Conference" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Future of Education Conference</span>
                                                <span class="text-[12px] text-gray-500">Reimagining education for tomorrow.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#F4F2FF] text-[#3723db] rounded border border-[#e9e4ff] text-[12px] font-bold">Education</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">EduCon Center,</span>
                                            <span class="text-gray-500 text-[12px]">Singapore</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Aug 15, 2024</span>
                                            <span class="text-gray-500 text-[12px]">09:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Aug 17, 2024</span>
                                            <span class="text-gray-500 text-[12px]">05:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#e2e8f0] text-[12px] font-bold">Draft</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/biz1/120/90" alt="Retail & E-commerce Expo" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Retail & E-commerce Expo</span>
                                                <span class="text-[12px] text-gray-500">Empowering retail through digital transformation.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6F5FF] text-[#0095FF] rounded border border-[#bae6fd] text-[12px] font-bold">Business</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Commerce Center,</span>
                                            <span class="text-gray-500 text-[12px]">Dubai, UAE</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Mar 12, 2024</span>
                                            <span class="text-gray-500 text-[12px]">10:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Mar 13, 2024</span>
                                            <span class="text-gray-500 text-[12px]">05:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Published</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/real1/120/90" alt="Real Estate & Property Show" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">Real Estate & Property Show</span>
                                                <span class="text-[12px] text-gray-500">Connecting people to better properties.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#FFE6EB] text-[#FF3B6A] rounded border border-[#fecdd3] text-[12px] font-bold">Real Estate</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Property Arena,</span>
                                            <span class="text-gray-500 text-[12px]">Sydney, Australia</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Feb 28, 2024</span>
                                            <span class="text-gray-500 text-[12px]">09:30 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Mar 01, 2024</span>
                                            <span class="text-gray-500 text-[12px]">05:30 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#e2e8f0] text-[12px] font-bold">Past</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-9 rounded-md overflow-hidden shrink-0 shadow-sm">
                                                <img src="https://picsum.photos/seed/agri1/120/90" alt="AgriTech Expo 2024" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-[#0B132C] text-[14px]">AgriTech Expo 2024</span>
                                                <span class="text-[12px] text-gray-500">Technology driven agriculture solutions.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Agriculture</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Agri Expo Center,</span>
                                            <span class="text-gray-500 text-[12px]">New Delhi, India</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jan 18, 2024</span>
                                            <span class="text-gray-500 text-[12px]">10:00 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-[#0B132C] font-medium text-[13px]">Jan 20, 2024</span>
                                            <span class="text-gray-500 text-[12px]">06:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-3 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#e2e8f0] text-[12px] font-bold">Past</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-3 py-3 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                        <div>Showing 1 to 8 of 89 exhibitions</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">3</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">4</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">5</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">12</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <!-- Sidebar Script -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            loadSidebar('sidebar-container');
        });
    </script>
</body>
</html>


