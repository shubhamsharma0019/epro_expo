<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Booth Inventory</title>
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
        @include('backend.admin.shared.sidebar')
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
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Booth Inventory</h1>
                        <p class="text-gray-500 text-[14px]">Manage all booths, check availability and view inventory across exhibitions.</p>
                    </div>
                    <div>
                        <button onclick="window.location.href='15_add_booth.html'" class="flex items-center justify-center gap-2 bg-[#3723db] hover:bg-[#2515a6] text-white px-5 py-2.5 rounded-[10px] text-[14px] font-semibold shadow-md transition-all w-full sm:w-auto">
                            <i class="ph-bold ph-plus text-lg"></i> Add Booth
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Total Booths -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-cube text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">2,450</span>
                            <span class="text-[12px] text-gray-500 font-medium">Total Booths</span>
                        </div>
                    </div>
                    
                    <!-- Available -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">1,320</span>
                            <span class="text-[12px] text-gray-500 font-medium">Available</span>
                        </div>
                    </div>
                    
                    <!-- Booked -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-calendar-check text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">980</span>
                            <span class="text-[12px] text-gray-500 font-medium">Booked</span>
                        </div>
                    </div>
                    
                    <!-- Reserved / Held -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-x-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">120</span>
                            <span class="text-[12px] text-gray-500 font-medium">Reserved / Held</span>
                        </div>
                    </div>
                    
                    <!-- Maintenance -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F5F3FF] text-[#8B5CF6] flex items-center justify-center shrink-0">
                            <i class="ph ph-cube text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">30</span>
                            <span class="text-[12px] text-gray-500 font-medium">Maintenance</span>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                    <div class="relative w-full lg:w-[280px]">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search booths..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-full text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-[150px]">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Exhibitions</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-[130px]">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Pavilions</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-[120px]">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Halls</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-[120px]">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Status</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <button class="flex items-center justify-center gap-2 bg-white border border-gray-200 text-[#3723db] px-4 py-2.5 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-gray-50 transition-colors w-full sm:w-[100px]">
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
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Booth No. <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Exhibition <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Pavilion <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Hall <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Category <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Size (sq.m) <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Status <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700 w-max">Availability <i class="ph ph-caret-up-down text-[10px]"></i></div></th>
                                    <th class="px-3 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px]">
                                
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">A-101</span>
                                            <span class="bg-gray-100 text-gray-600 rounded px-1.5 py-0.5 text-[10px] font-semibold border border-gray-200">Corner</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                            <span class="text-[12px] text-gray-500">May 15 - May 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/us.png" alt="USA" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">USA Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall A - Level 1</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Standard</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">9 (3m x 3m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">A-102</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                            <span class="text-[12px] text-gray-500">May 15 - May 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/us.png" alt="USA" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">USA Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall A - Level 1</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Premium</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">18 (3m x 6m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Booked</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Booked</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">B-205</span>
                                            <span class="bg-gray-100 text-gray-600 rounded px-1.5 py-0.5 text-[10px] font-semibold border border-gray-200">Island</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                            <span class="text-[12px] text-gray-500">Jun 10 - Jun 12, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/de.png" alt="Germany" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">Germany Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall B - Level 2</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Island</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">36 (6m x 6m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">B-206</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                            <span class="text-[12px] text-gray-500">Jun 10 - Jun 12, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/de.png" alt="Germany" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">Germany Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall B - Level 2</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Standard</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">9 (3m x 3m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#EFF6FF] text-[#3B82F6] rounded border border-[#bfdbfe] text-[12px] font-bold">Reserved</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#EFF6FF] text-[#3B82F6] rounded border border-[#bfdbfe] text-[12px] font-bold">Reserved</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">C-301</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Healthcare Innovation Expo</span>
                                            <span class="text-[12px] text-gray-500">Jul 20 - Jul 22, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/eu.png" alt="EU" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">European Union Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall C - Level 1</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Premium</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">18 (3m x 6m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Booked</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Booked</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">D-110</span>
                                            <span class="bg-gray-100 text-gray-600 rounded px-1.5 py-0.5 text-[10px] font-semibold border border-gray-200">Corner</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Retail & E-commerce Expo</span>
                                            <span class="text-[12px] text-gray-500">Mar 12 - Mar 13, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/in.png" alt="India" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">India Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall D - Level 1</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Standard</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">12 (4m x 3m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">E-410</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Smart Manufacturing Expo</span>
                                            <span class="text-[12px] text-gray-500">Apr 05 - Apr 07, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/cn.png" alt="China" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">China Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall E - Level 2</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Premium</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">24 (4m x 6m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#F5F3FF] text-[#8B5CF6] rounded border border-[#ddd6fe] text-[12px] font-bold">Maintenance</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#F5F3FF] text-[#8B5CF6] rounded border border-[#ddd6fe] text-[12px] font-bold">Maintenance</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#0B132C]">F-201</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C] text-[13px]">Future of Education Conference</span>
                                            <span class="text-[12px] text-gray-500">Aug 15 - Aug 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/gb.png" alt="UK" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">UK Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Hall F - Level 1</td>
                                    <td class="px-3 py-3 text-gray-700 font-medium text-[13px]">Standard</td>
                                    <td class="px-3 py-3 text-gray-700 text-[13px]">9 (3m x 3m)</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Available</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-3 py-3 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                        <div>Showing 1 to 8 of 2,450 booths</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">3</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-[38px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors px-2">306</button>
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


