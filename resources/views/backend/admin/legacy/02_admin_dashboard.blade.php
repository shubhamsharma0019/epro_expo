<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Admin Dashboard</title>
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
    <main class="flex-1 flex flex-col h-full min-w-0">
        
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
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
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

        <!-- Dashboard Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar">
            <div class="max-w-[1400px] mx-auto">
                
                <!-- Dashboard Header -->
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1">Welcome back, Admin 👋</h1>
                        <p class="text-gray-500 text-[14px]">Here's what's happening with your platform today.</p>
                    </div>
                    <div>
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2.5 rounded-lg text-[13px] font-medium text-gray-600 shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph ph-calendar-blank text-lg text-gray-400"></i>
                            Date Range: <span class="text-gray-800 font-semibold ml-1">May 10 – May 16, 2024</span>
                            <i class="ph ph-caret-down text-xs ml-1 text-gray-400"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    
                    <!-- Stat 1 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">120</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Companies</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center shrink-0">
                            <i class="ph ph-buildings text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">{{ \App\Domain\Visitor\Models\VisitorTicket::query()->count() }}</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Tickets</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-ticket text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">32</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Published Events</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#EFF2FF] text-[#3B66FF] flex items-center justify-center shrink-0">
                            <i class="ph ph-calendar-check text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">8.9</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Published Exhibitions</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-cube text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 5 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">12,450</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Visitors</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center shrink-0">
                            <i class="ph ph-users-three text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 6 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">4,80,000</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Revenue</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-currency-circle-dollar text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 7 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0B132C] mb-1">256</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Meetings</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#EFF2FF] text-[#3B66FF] flex items-center justify-center shrink-0">
                            <i class="ph ph-user-plus text-[28px]"></i>
                        </div>
                    </div>

                    <!-- Stat 8 -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-2xl font-bold text-[#FF3B6A] mb-1">432</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Total Enquiries</p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-chat-circle-question text-[28px]"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="mb-8">
                    <h2 class="text-[17px] font-bold text-[#0B132C] mb-4">Quick Actions</h2>
                    <div class="flex flex-wrap gap-3">
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-buildings text-lg"></i> Add New Company
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-calendar-blank text-lg"></i> New Exhibition
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-flag text-lg"></i> New Pavilion
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-package text-lg"></i> New Booth
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-ticket text-lg"></i> New Event
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-tag text-lg"></i> New Pass
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-user-plus text-lg"></i> New User
                        </button>
                        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:shadow-md hover:bg-[#F4F2FF] hover:border-[#F4F2FF] transition-all">
                            <i class="ph ph-paper-plane-tilt text-lg"></i> Mass Notification
                        </button>
                    </div>
                </div>
                
                <!-- Bottom Section (Table & Chart) -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 pb-12">
                    
                    <!-- Table Section -->
                    <div class="bg-white rounded-[20px] border border-gray-100 shadow-sm p-6 xl:col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-[17px] font-bold text-[#0B132C]">Recent Companies</h2>
                            <a href="#" class="text-[13px] font-bold text-[#3723db] flex items-center gap-1 hover:underline">View All <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="overflow-x-visible">
                            <table class="w-full text-left border-collapse whitespace-normal">
                                <thead>
                                    <tr class="text-[13px] text-gray-400 border-b border-gray-100">
                                        <th class="pb-3 font-semibold">Company Name</th>
                                        <th class="pb-3 font-semibold">Contact Person</th>
                                        <th class="pb-3 font-semibold">Status</th>
                                        <th class="pb-3 font-semibold">Registered On</th>
                                        <th class="pb-3 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-[14px]">
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-semibold text-[#0B132C]">TechNova Solutions</td>
                                        <td class="py-4 text-gray-500 font-medium">John Doe</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded-full text-[12px] font-bold">Approved</span>
                                        </td>
                                        <td class="py-4 text-gray-500 font-medium">May 16, 2024</td>
                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-[#0B132C] p-1"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-semibold text-[#0B132C]">Global Tech Summit 2024</td>
                                        <td class="py-4 text-gray-500 font-medium">Alice Johnson</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded-full text-[12px] font-bold">Pending</span>
                                        </td>
                                        <td class="py-4 text-gray-500 font-medium">May 15, 2024</td>
                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-[#0B132C] p-1"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-semibold text-[#0B132C]">FutureSoft Pvt. Ltd.</td>
                                        <td class="py-4 text-gray-500 font-medium">Robert Brown</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded-full text-[12px] font-bold">Approved</span>
                                        </td>
                                        <td class="py-4 text-gray-500 font-medium">May 14, 2024</td>
                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-[#0B132C] p-1"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-semibold text-[#0B132C]">Innovent Corp.</td>
                                        <td class="py-4 text-gray-500 font-medium">Victor Ruiz</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded-full text-[12px] font-bold">Pending</span>
                                        </td>
                                        <td class="py-4 text-gray-500 font-medium">May 13, 2024</td>
                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-[#0B132C] p-1"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-semibold text-[#0B132C]">CloudSync Inc.</td>
                                        <td class="py-4 text-gray-500 font-medium">Emily Davis</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 bg-[#FFE6EB] text-[#FF3B6A] rounded-full text-[12px] font-bold">Rejected</span>
                                        </td>
                                        <td class="py-4 text-gray-500 font-medium">May 12, 2024</td>
                                        <td class="py-4 text-right">
                                            <button class="text-gray-400 hover:text-[#0B132C] p-1"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 text-[13px] text-gray-500 font-medium gap-4">
                            <div>Showing 1 to 5 of 120 companies</div>
                            <div class="flex gap-1.5">
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg bg-[#F4F2FF] text-[#3723db] border border-[#F4F2FF] font-bold shadow-sm">1</button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors hidden sm:flex">3</button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors hidden sm:flex">4</button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">5</button>
                                <button class="w-[30px] h-[30px] flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right text-gray-400"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart Section -->
                    <div class="bg-white rounded-[20px] border border-gray-100 shadow-sm p-6 xl:col-span-1 flex flex-col">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-[17px] font-bold text-[#0B132C]">Visitor Overview</h2>
                            <a href="#" class="text-[13px] font-bold text-[#3723db] flex items-center gap-1 hover:underline">View Report <i class="ph ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="flex justify-between mb-8 pb-4 border-b border-gray-50">
                            <div>
                                <div class="text-[11px] text-gray-400 font-semibold mb-1 uppercase tracking-wider">Total Visitors</div>
                                <div class="text-[16px] font-bold text-[#3723db]">12,450</div>
                            </div>
                            <div>
                                <div class="text-[11px] text-gray-400 font-semibold mb-1 uppercase tracking-wider">This Week</div>
                                <div class="text-[15px] font-bold text-[#10B981]">+2,450</div>
                            </div>
                            <div class="hidden sm:block xl:hidden">
                                <div class="text-[11px] text-gray-400 font-semibold mb-1 uppercase tracking-wider">This Month</div>
                                <div class="text-[15px] font-bold text-[#10B981]">+8,230</div>
                            </div>
                        </div>
                        
                        <!-- SVG Chart Emulation -->
                        <div class="flex-1 w-full min-h-[220px] relative mt-2">
                            <svg viewBox="0 0 400 220" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                                <!-- Axes labels (Y) -->
                                <text x="0" y="20" class="text-[10px] font-semibold fill-gray-400">15K</text>
                                <text x="0" y="80" class="text-[10px] font-semibold fill-gray-400">10K</text>
                                <text x="0" y="140" class="text-[10px] font-semibold fill-gray-400">5K</text>
                                <text x="0" y="200" class="text-[10px] font-semibold fill-gray-400">0</text>
                                
                                <!-- Grid lines -->
                                <line x1="25" y1="15" x2="400" y2="15" stroke="#f1f5f9" stroke-width="1.5" />
                                <line x1="25" y1="75" x2="400" y2="75" stroke="#f1f5f9" stroke-width="1.5" />
                                <line x1="25" y1="135" x2="400" y2="135" stroke="#f1f5f9" stroke-width="1.5" />
                                <line x1="25" y1="195" x2="400" y2="195" stroke="#f1f5f9" stroke-width="1.5" />
                                
                                <defs>
                                    <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#3723db" stop-opacity="0.15" />
                                        <stop offset="100%" stop-color="#3723db" stop-opacity="0" />
                                    </linearGradient>
                                    <filter id="shadow">
                                        <feDropShadow dx="0" dy="4" stdDeviation="4" flood-opacity="0.1" />
                                    </filter>
                                </defs>
                                
                                <!-- Chart Area -->
                                <path d="M50 160 L100 120 L150 150 L200 110 L250 145 L300 95 L350 40 L390 60 L390 195 L50 195 Z" fill="url(#chartGrad)" />
                                
                                <!-- Chart Line -->
                                <path d="M50 160 L100 120 L150 150 L200 110 L250 145 L300 95 L350 40 L390 60" fill="none" stroke="#3723db" stroke-width="2.5" />
                                
                                <!-- Dots -->
                                <circle cx="50" cy="160" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="100" cy="120" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="150" cy="150" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="200" cy="110" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="250" cy="145" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="300" cy="95" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="350" cy="40" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                <circle cx="390" cy="60" r="4.5" fill="#3723db" stroke="white" stroke-width="1.5" />
                                
                                <!-- X axis labels -->
                                <text x="50" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 10</text>
                                <text x="100" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 11</text>
                                <text x="150" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 12</text>
                                <text x="200" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 13</text>
                                <text x="250" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 14</text>
                                <text x="300" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 15</text>
                                <text x="350" y="218" class="text-[10px] font-semibold fill-gray-400" text-anchor="middle">May 16</text>
                                
                                <!-- Tooltip over May 16 -->
                                <rect x="345" y="5" width="70" height="38" rx="6" fill="white" filter="url(#shadow)" stroke="#f1f5f9" stroke-width="1" />
                                <text x="380" y="21" class="text-[11px] font-bold fill-[#0B132C]" text-anchor="middle">12,450</text>
                                <text x="380" y="34" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">May 16, 2024</text>
                            </svg>
                        </div>
                    </div>
                </div>
                

                <!-- Added Enterprise Admin Modules -->
                <div class="mt-8 mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-[#0B132C]">Enterprise Admin Control Modules</h2>
                            <p class="text-[13px] text-gray-500 mt-1">Flow diagrams ke according missing 10 admin modules yahan add kiye gaye hain.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
<a href="{{ url('/admin/25_lead_management') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-funnel text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Lead Management</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/26_meeting_management') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-calendar-plus text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Meeting Management</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/24_visitor_checkin_analytics') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-qr-code text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Check-in Analytics</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/05_kyc_verification') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-shield-check text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">KYC Verification</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/29_refund_management') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-arrow-u-down-left text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Refund Management</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/19_booth_engineering_review') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-hard-hat text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Booth Engineering</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/23_event_logistics_review') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-clipboard-text text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Event Logistics</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/09_exhibition_lifecycle') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-git-branch text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Lifecycle Tracking</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/32_occupancy_analytics') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-chart-donut text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Occupancy Analytics</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a><a href="{{ url('/admin/31_revenue_breakdown_reports') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:-translate-y-0.5 transition-all"><div class="w-11 h-11 rounded-xl bg-[#F4F2FF] text-[#5A42E9] flex items-center justify-center mb-3"><i class="ph ph-chart-bar text-2xl"></i></div><h3 class="text-[14px] font-bold text-[#0B132C]">Revenue Reports</h3><p class="text-[11px] text-gray-500 mt-1">Open module</p></a>
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


