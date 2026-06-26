<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Booth Setup Review</title>
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
<div class="mx-6 lg:mx-8 mt-6 bg-[#F4F2FF] border border-[#E6E1FF] rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4"><div><h3 class="text-[#0B132C] font-bold">Booth Engineering Review added</h3><p class="text-[13px] text-gray-600 mt-1">Handles stall design PDF, 3D render, electrical load, furniture, hanging structure, and fire safety review here.</p></div><a href="{{ url('/admin/19_booth_engineering_review') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#3723db] text-white text-[13px] font-semibold hover:bg-[#2b1bb7] transition-colors">Open Module <i class="ph ph-arrow-right ml-2"></i></a></div>

            <div class="max-w-[1400px] mx-auto">
                
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Booth Setup Review</h1>
                    <p class="text-gray-500 text-[14px]">Review booth setup requests submitted by exhibitors and take necessary actions.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Total Requests -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-calendar-check text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] text-gray-500 font-medium mb-0.5">Total Requests</span>
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none">128</span>
                        </div>
                    </div>
                    
                    <!-- Under Review -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-clock text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] text-[#FF8A00] font-medium mb-0.5">Under Review</span>
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none">38</span>
                        </div>
                    </div>
                    
                    <!-- Approved -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] text-[#10B981] font-medium mb-0.5">Approved</span>
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none">62</span>
                        </div>
                    </div>
                    
                    <!-- Changes Requested -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-x-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] text-[#FF3B6A] font-medium mb-0.5">Changes Requested</span>
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none">18</span>
                        </div>
                    </div>
                    
                    <!-- Rejected -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-prohibit text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[12px] text-[#FF3B6A] font-medium mb-0.5">Rejected</span>
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none">10</span>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                    <div class="relative w-full lg:w-[360px]">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search by booth no, exhibitor, exhibition..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-full text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-[160px]">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Exhibitions</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-[140px]">
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
                        <div class="relative w-full sm:w-[130px]">
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-normal">
                            <thead>
                                <tr class="text-[13px] text-gray-500 font-semibold border-b border-gray-100 bg-white">
                                    <th class="px-3 py-3">
                                        <div class="flex items-center gap-2 cursor-pointer hover:text-gray-700">Request ID <i class="ph-bold ph-caret-up-down text-[14px]"></i></div>
                                    </th>
                                    <th class="px-3 py-3">
                                        <div class="flex items-center gap-2 cursor-pointer hover:text-gray-700">Exhibitor / Company <i class="ph-bold ph-caret-up-down text-[14px]"></i></div>
                                    </th>
                                    <th class="px-3 py-3">
                                        <div class="flex items-center gap-2 cursor-pointer hover:text-gray-700">Exhibition <i class="ph-bold ph-caret-up-down text-[14px]"></i></div>
                                    </th>
                                    <th class="px-3 py-3">Booth No.</th>
                                    <th class="px-3 py-3">Hall</th>
                                    <th class="px-3 py-3">
                                        <div class="flex items-center gap-2 cursor-pointer hover:text-gray-700">Submitted On <i class="ph-bold ph-caret-up-down text-[14px]"></i></div>
                                    </th>
                                    <th class="px-3 py-3">
                                        <div class="flex items-center gap-2 cursor-pointer hover:text-gray-700">Status <i class="ph-bold ph-caret-up-down text-[14px]"></i></div>
                                    </th>
                                    <th class="px-3 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px]">
                                
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0128</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">TechNova Solutions Pvt. Ltd.</span>
                                            <span class="text-[12px] text-gray-500">john@technova.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                            <span class="text-[12px] text-gray-500">May 15 - May 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">A-101</span>
                                            <span class="text-[12px] text-gray-500">18 sqm (Standard)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall A - Level 1</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 28, 2024</span>
                                            <span class="text-[12px] text-gray-500">10:30 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Under Review</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0127</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">Innovatech Global</span>
                                            <span class="text-[12px] text-gray-500">info@innovatech.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                            <span class="text-[12px] text-gray-500">May 15 - May 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">A-201</span>
                                            <span class="text-[12px] text-gray-500">9 sqm (Corner)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall A - Level 1</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 27, 2024</span>
                                            <span class="text-[12px] text-gray-500">04:15 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Approved</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>
                                
                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0126</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">Future Systems Inc.</span>
                                            <span class="text-[12px] text-gray-500">contact@futuresys.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                            <span class="text-[12px] text-gray-500">Jun 10 - Jun 12, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">B-205</span>
                                            <span class="text-[12px] text-gray-500">36 sqm (Island)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall B - Level 2</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 25, 2024</span>
                                            <span class="text-[12px] text-gray-500">11:20 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFE6EB] text-[#FF3B6A] rounded border border-[#fecdd3] text-[12px] font-bold">Changes Requested</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>
                                
                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0125</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">Green Planet Pvt. Ltd.</span>
                                            <span class="text-[12px] text-gray-500">hello@greenplanet.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                            <span class="text-[12px] text-gray-500">Jun 10 - Jun 12, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">B-206</span>
                                            <span class="text-[12px] text-gray-500">9 sqm (Standard)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall B - Level 2</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 24, 2024</span>
                                            <span class="text-[12px] text-gray-500">02:45 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Under Review</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>
                                
                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0124</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">MediCare Innovations</span>
                                            <span class="text-[12px] text-gray-500">sales@medicare.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Healthcare Innovation Expo</span>
                                            <span class="text-[12px] text-gray-500">Jul 20 - Jul 22, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">C-301</span>
                                            <span class="text-[12px] text-gray-500">36 sqm (Premium)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall C - Level 1</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 23, 2024</span>
                                            <span class="text-[12px] text-gray-500">09:10 AM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Approved</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>
                                
                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0122</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">AutoNext Technologies</span>
                                            <span class="text-[12px] text-gray-500">contact@autonext.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Smart Manufacturing Expo</span>
                                            <span class="text-[12px] text-gray-500">Apr 05 - Apr 07, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">E-410</span>
                                            <span class="text-[12px] text-gray-500">24 sqm (Premium)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall E - Level 2</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 20, 2024</span>
                                            <span class="text-[12px] text-gray-500">01:05 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#CBD5E1] text-[12px] font-bold">Rejected</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>
                                
                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <span class="font-bold text-[#3723db]">SET-2024-0121</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">EduFuture Pvt. Ltd.</span>
                                            <span class="text-[12px] text-gray-500">support@edufuture.com</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Future of Education Conf.</span>
                                            <span class="text-[12px] text-gray-500">Aug 15 - Aug 17, 2024</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[13px]">F-201</span>
                                            <span class="text-[12px] text-gray-500">9 sqm (Standard)</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium text-[13px]">Hall F - Level 1</td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-[#0B132C] text-[13px]">Apr 19, 2024</span>
                                            <span class="text-[12px] text-gray-500">12:00 PM</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-1 bg-[#FFE6EB] text-[#FF3B6A] rounded border border-[#fecdd3] text-[12px] font-bold">Changes Requested</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <a href="{{ url('/admin/18_booth_setup_review_details') }}" class="w-[32px] h-[32px] inline-flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-3 py-3 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                        <div>Showing 1 to 8 of 128 requests</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">3</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">16</button>
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


