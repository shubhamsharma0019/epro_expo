<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Activity Logs</title>
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

        /* Tabs styling */
        .tab-active {
            color: #3723db;
            border-bottom: 2px solid #3723db;
            font-weight: 700;
        }
        .tab-inactive {
            color: #64748B;
            border-bottom: 2px solid transparent;
            font-weight: 500;
        }
        .tab-inactive:hover {
            color: #0B132C;
            border-bottom: 2px solid #E2E8F0;
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
    <main class="flex-1 flex flex-col h-full min-w-0">
        
        <!-- Top Header Area -->
        <header class="bg-white border-b border-gray-100 flex flex-col xl:flex-row items-start xl:items-center justify-between px-6 lg:px-8 py-5 shrink-0 relative z-10 gap-4 xl:gap-0">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[20px] font-bold text-[#0B132C]">Activity Logs</h1>
                <p class="text-gray-500 text-[13px] mt-0.5">Track all user activities and system events.</p>
            </div>
            
            <!-- Right Side: Date Picker, Filters, Export, Profile -->
            <div class="flex flex-wrap items-center gap-4">
                
                <!-- Date Picker -->
                <div class="flex items-center bg-white border border-gray-200 rounded-[8px] px-3 py-2 shadow-sm cursor-pointer hover:bg-gray-50 transition-colors">
                    <i class="ph ph-calendar-blank text-gray-500 text-lg mr-2"></i>
                    <span class="text-[13px] text-gray-700 font-medium mr-2">May 01, 2024 - May 31, 2024</span>
                    <i class="ph-bold ph-caret-down text-gray-400 text-xs"></i>
                </div>
                
                <!-- Filters -->
                <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="ph ph-faders text-lg text-gray-500"></i>
                    Filters
                </button>
                
                <!-- Export -->
                <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="ph ph-export text-lg text-gray-500"></i>
                    Export
                </button>
                
                <div class="hidden sm:block h-8 w-px bg-gray-200 mx-1"></div>
                
                <!-- Notifications & Profile -->
                <div class="flex items-center gap-5">
                    <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="ph ph-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">12</span>
                    </button>
                    
                    <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3723db&color=fff" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                        <div class="flex flex-col text-left hidden sm:flex">
                            <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                            <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                        </div>
                    </button>
                </div>
            </div>
        </header>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-[#F8F9FC]">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Top 4 Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    <!-- Total Activities -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                            <i class="ph ph-file-text text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Total Activities</p>
                            <h3 class="text-[24px] font-bold text-[#0B132C] leading-none mb-2">2,456</h3>
                            <div class="text-[11px] text-gray-400 font-medium flex items-center whitespace-normal overflow-hidden text-ellipsis">
                                <span class="text-[#10B981] flex items-center mr-1 font-bold"><i class="ph-bold ph-arrow-up mr-0.5"></i>12.5%</span> vs Apr 01 - Apr 30, 2024
                            </div>
                        </div>
                    </div>

                    <!-- Successful Activities -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[10px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-[#D1FAE5]">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Successful Activities</p>
                            <h3 class="text-[24px] font-bold text-[#0B132C] leading-none mb-2">2,210</h3>
                            <div class="text-[11px] text-gray-400 font-medium flex items-center whitespace-normal overflow-hidden text-ellipsis">
                                <span class="text-[#10B981] flex items-center mr-1 font-bold"><i class="ph-bold ph-arrow-up mr-0.5"></i>11.8%</span> vs Apr 01 - Apr 30, 2024
                            </div>
                        </div>
                    </div>

                    <!-- Failed Activities -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0 border border-[#FFEDD5]">
                            <i class="ph ph-warning text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Failed Activities</p>
                            <h3 class="text-[24px] font-bold text-[#0B132C] leading-none mb-2">146</h3>
                            <div class="text-[11px] text-gray-400 font-medium flex items-center whitespace-normal overflow-hidden text-ellipsis">
                                <span class="text-[#10B981] flex items-center mr-1 font-bold"><i class="ph-bold ph-arrow-up mr-0.5"></i>8.2%</span> vs Apr 01 - Apr 30, 2024
                            </div>
                        </div>
                    </div>

                    <!-- Active Users -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                            <i class="ph ph-users text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Active Users</p>
                            <h3 class="text-[24px] font-bold text-[#0B132C] leading-none mb-2">32</h3>
                            <div class="text-[11px] text-gray-400 font-medium flex items-center whitespace-normal overflow-hidden text-ellipsis">
                                <span class="text-[#10B981] flex items-center mr-1 font-bold"><i class="ph-bold ph-arrow-up mr-0.5"></i>14.3%</span> vs Apr 01 - Apr 30, 2024
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Main Content Box -->
                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
                    
                    <!-- Tabs & Search Header -->
                    <div class="px-6 flex flex-col lg:flex-row lg:items-center justify-between border-b border-gray-100 gap-4 pt-4 lg:pt-0 lg:h-[72px]">
                        
                        <!-- Tabs -->
                        <div class="flex items-center gap-6 overflow-x-visible no-scrollbar lg:pt-0 pt-2 flex-wrap h-auto">
                            <button class="h-full pb-3 lg:pb-0 border-b-[3px] border-[#3723db] text-[#3723db] font-bold text-[14px] whitespace-normal pt-1">All Activities</button>
                            <button class="h-full pb-3 lg:pb-0 border-b-[3px] border-transparent text-gray-500 hover:text-[#0B132C] font-semibold text-[14px] whitespace-normal transition-colors pt-1">User Activities</button>
                            <button class="h-full pb-3 lg:pb-0 border-b-[3px] border-transparent text-gray-500 hover:text-[#0B132C] font-semibold text-[14px] whitespace-normal transition-colors pt-1">System Events</button>
                            <button class="h-full pb-3 lg:pb-0 border-b-[3px] border-transparent text-gray-500 hover:text-[#0B132C] font-semibold text-[14px] whitespace-normal transition-colors pt-1">Security Events</button>
                        </div>
                        
                        <!-- Search -->
                        <div class="relative w-full lg:w-[320px] pb-4 lg:pb-0">
                            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg lg:mt-0 -mt-2"></i>
                            <input type="text" placeholder="Search activities..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-[8px] text-[13px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-colors">
                        </div>
                    </div>
                    
                    <!-- Table Section -->
                    <div class="flex-1 overflow-x-visible w-full">
                        <table class="w-full text-left border-collapse min-w-[1100px]">
                            <thead>
                                <tr class="text-[12px] text-gray-500 border-b border-gray-50 bg-white">
                                    <th class="px-3 py-3 font-semibold w-[160px]">Date & Time</th>
                                    <th class="px-3 py-3 font-semibold w-[220px]">User</th>
                                    <th class="px-3 py-3 font-semibold w-[140px]">Action</th>
                                    <th class="px-3 py-3 font-semibold w-[160px]">Module</th>
                                    <th class="px-3 py-3 font-semibold">Description</th>
                                    <th class="px-3 py-3 font-semibold w-[140px]">IP Address</th>
                                    <th class="px-3 py-3 font-semibold w-[120px]">Status</th>
                                    <th class="px-3 py-3 w-[60px]"></th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px]">
                                
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">10:45:32 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#3723db] text-white flex items-center justify-center text-[12px] font-bold shrink-0">AS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Anjali Singh</div>
                                                <div class="text-gray-500 text-[11px]">anjali@technova.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Created</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Booth Booking</td>
                                    <td class="px-3 py-3 text-gray-600">Created a new booth booking for Global Tech Summit 2024</td>
                                    <td class="px-3 py-3 text-gray-600">103.21.244.10</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">10:32:18 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#EF4444] text-white flex items-center justify-center text-[12px] font-bold shrink-0">RS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Rohit Sharma</div>
                                                <div class="text-gray-500 text-[11px]">rohit@technova.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#EFF6FF] text-[#3B82F6] rounded-[6px] text-[11px] font-bold">Updated</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Company</td>
                                    <td class="px-3 py-3 text-gray-600">Updated company information for TechNova Solutions</td>
                                    <td class="px-3 py-3 text-gray-600">103.21.244.10</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">10:15:07 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#10B981] text-white flex items-center justify-center text-[12px] font-bold shrink-0">PS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Priya Nair</div>
                                                <div class="text-gray-500 text-[11px]">priya@futureai.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Created</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Enquiry / Leads</td>
                                    <td class="px-3 py-3 text-gray-600">Created a new enquiry from Future AI Conference</td>
                                    <td class="px-3 py-3 text-gray-600">103.45.67.89</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">09:58:41 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#EF4444] text-white flex items-center justify-center text-[12px] font-bold shrink-0">VK</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Vikram Kumar</div>
                                                <div class="text-gray-500 text-[11px]">vikram@globaltech.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#FEF2F2] text-[#EF4444] rounded-[6px] text-[11px] font-bold">Deleted</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Ticket</td>
                                    <td class="px-3 py-3 text-gray-600">Deleted ticket INV-2024-1542</td>
                                    <td class="px-3 py-3 text-gray-600">103.31.45.22</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">09:41:12 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#3723db] text-white flex items-center justify-center text-[12px] font-bold shrink-0">AS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Anjali Singh</div>
                                                <div class="text-gray-500 text-[11px]">anjali@technova.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#F4F2FF] text-[#3723db] rounded-[6px] text-[11px] font-bold">Downloaded</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Invoice</td>
                                    <td class="px-3 py-3 text-gray-600">Downloaded invoice INV-2024-1556</td>
                                    <td class="px-3 py-3 text-gray-600">103.21.244.10</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">09:20:33 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#8B5CF6] text-white flex items-center justify-center text-[12px] font-bold shrink-0">MJ</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Michael Johnson</div>
                                                <div class="text-gray-500 text-[11px]">michael@globaltech.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#EFF6FF] text-[#3B82F6] rounded-[6px] text-[11px] font-bold">Login</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Authentication</td>
                                    <td class="px-3 py-3 text-gray-600">User logged in to the system</td>
                                    <td class="px-3 py-3 text-gray-600">122.176.32.11</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">09:10:55 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#10B981] text-white flex items-center justify-center text-[12px] font-bold shrink-0">PS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Priya Nair</div>
                                                <div class="text-gray-500 text-[11px]">priya@futureai.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#EFF6FF] text-[#3B82F6] rounded-[6px] text-[11px] font-bold">Updated</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Payment</td>
                                    <td class="px-3 py-3 text-gray-600">Updated payment status for INV-2024-1555</td>
                                    <td class="px-3 py-3 text-gray-600">103.45.67.89</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">08:50:21 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#F59E0B] text-white flex items-center justify-center text-[12px] font-bold shrink-0">RK</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Rahul Khanna</div>
                                                <div class="text-gray-500 text-[11px]">rahul@innovatex.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#FEF2F2] text-[#EF4444] rounded-[6px] text-[11px] font-bold">Failed Login</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Authentication</td>
                                    <td class="px-3 py-3 text-gray-600">Failed login attempt</td>
                                    <td class="px-3 py-3 text-gray-600">185.199.108.25</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#EF4444] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#EF4444]"></div> Failed</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 9 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">08:35:16 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#3723db] text-white flex items-center justify-center text-[12px] font-bold shrink-0">AS</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Anjali Singh</div>
                                                <div class="text-gray-500 text-[11px]">anjali@technova.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-[6px] text-[11px] font-bold">Assigned</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Meeting</td>
                                    <td class="px-3 py-3 text-gray-600">Assigned a meeting to Rohit Sharma</td>
                                    <td class="px-3 py-3 text-gray-600">103.21.244.10</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                                <!-- Row 10 -->
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-6 h-6 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="ph ph-clock text-[14px]"></i>
                                            </div>
                                            <div>
                                                <div class="text-[#0B132C] font-medium">May 31, 2024</div>
                                                <div class="text-gray-500 text-[11px] mt-0.5">08:12:09 AM</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#8B5CF6] text-white flex items-center justify-center text-[12px] font-bold shrink-0">MJ</div>
                                            <div>
                                                <div class="text-[#0B132C] font-semibold text-[13px]">Michael Johnson</div>
                                                <div class="text-gray-500 text-[11px]">michael@globaltech.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Created</span></td>
                                    <td class="px-3 py-3 text-[#0B132C] font-medium">Exhibition</td>
                                    <td class="px-3 py-3 text-gray-600">Created exhibition - Healthcare Leaders Summit</td>
                                    <td class="px-3 py-3 text-gray-600">122.176.32.11</td>
                                    <td class="px-3 py-3"><span class="flex items-center gap-1.5 text-[#10B981] font-medium text-[13px]"><div class="w-2 h-2 rounded-full bg-[#10B981]"></div> Success</span></td>
                                    <td class="px-3 py-3 text-center"><button class="text-gray-400 hover:text-[#0B132C] transition-colors"><i class="ph-bold ph-dots-three text-lg"></i></button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Footer -->
                    <div class="px-3 py-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4">
                        <div>Showing 1 to 10 of 2,456 activities</div>
                        <div class="flex gap-1.5 items-center">
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded bg-[#3723db] text-white border border-[#3723db] font-bold shadow-sm">1</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">2</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">3</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-[36px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">246</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right text-gray-400"></i></button>
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
