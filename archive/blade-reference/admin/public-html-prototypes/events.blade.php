<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Event Management</title>
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
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden m-0 p-0 text-[#1E293B]">
    
    <!-- Sidebar Container -->
    <div id="sidebar-container" class="w-[260px] bg-[#0b132c] h-full shrink-0 hidden sm:block"></div>
    
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
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">6</span>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-chat-circle-dots text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-blue-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">3</span>
                </button>
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                    <div class="flex flex-col text-left hidden sm:flex">
                        <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                        <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                    </div>
                </button>
            </div>
        </header>

        <!-- Page Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Event Management</h1>
                        <p class="text-gray-500 text-[14px]">Manage all events, sessions, speakers, and related activities.</p>
                    </div>
                    <div>
                        <button class="flex items-center justify-center gap-2 bg-[#3723db] hover:bg-[#2515a6] text-white px-5 py-2.5 rounded-[10px] text-[14px] font-semibold shadow-md transition-all w-full sm:w-auto">
                            <i class="ph-bold ph-plus text-lg"></i> Create Event
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                    <!-- Total Events -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-calendar-blank text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">24</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Total Events</span>
                        </div>
                    </div>
                    
                    <!-- Upcoming Events -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-check-circle text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">10</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Upcoming Events</span>
                        </div>
                    </div>
                    
                    <!-- Ongoing Events -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-clock text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">8</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Ongoing Events</span>
                        </div>
                    </div>
                    
                    <!-- Completed Events -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-x-circle text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">6</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Completed Events</span>
                        </div>
                    </div>
                    
                    <!-- Total Speakers -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-users text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">76</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Total Speakers</span>
                        </div>
                    </div>

                    <!-- Total Registrations -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-4 xl:p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-[42px] h-[42px] rounded-lg bg-[#F1F5F9] text-[#475569] flex items-center justify-center shrink-0">
                            <i class="ph ph-ticket text-[20px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[20px] font-bold text-[#0B132C] leading-none mb-1">3,250</span>
                            <span class="text-[11px] xl:text-[12px] text-gray-500 font-medium whitespace-nowrap">Total Registrations</span>
                        </div>
                    </div>
                </div>

                <!-- Main Layout Grid (2 Columns: Content & Sidebar) -->
                <div class="flex flex-col xl:flex-row gap-6 items-start">
                    
                    <!-- LEFT COLUMN (Main Content) -->
                    <div class="w-full xl:flex-1 flex flex-col gap-6">
                        
                        <!-- Filters & Search -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                            <div class="relative w-full lg:w-[280px]">
                                <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                                <input type="text" placeholder="Search events by name, category, venue..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg w-full text-[13px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                                <div class="relative w-full sm:w-[130px]">
                                    <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-[13px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                        <option>All Categories</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                                <div class="relative w-full sm:w-[120px]">
                                    <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-[13px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                        <option>All Status</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                                <div class="relative w-full sm:w-[120px]">
                                    <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-[13px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                        <option>All Venues</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                                <div class="relative w-full sm:w-[170px]">
                                    <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg px-3 py-2 text-[12px] text-gray-500 cursor-pointer shadow-sm hover:border-[#3723db] transition-colors">
                                        <span>Start Date &nbsp;&rarr;&nbsp; End Date</span>
                                        <i class="ph ph-calendar-blank text-gray-400 text-[14px]"></i>
                                    </div>
                                </div>
                                <button class="flex items-center justify-center gap-1.5 bg-white border border-gray-200 text-[#3723db] px-3 py-2 rounded-lg text-[13px] font-semibold shadow-sm hover:bg-gray-50 transition-colors w-full sm:w-[90px]">
                                    <i class="ph ph-funnel text-[16px]"></i> Filters
                                </button>
                            </div>
                        </div>
                        
                        <!-- Table Section -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse whitespace-nowrap">
                                    <thead>
                                        <tr class="text-[12px] text-gray-500 font-semibold border-b border-gray-100 bg-white">
                                            <th class="px-5 py-4">Event Name</th>
                                            <th class="px-5 py-4">Category</th>
                                            <th class="px-5 py-4">Venue</th>
                                            <th class="px-5 py-4">Start Date</th>
                                            <th class="px-5 py-4">End Date</th>
                                            <th class="px-5 py-4">Registrations</th>
                                            <th class="px-5 py-4">Status</th>
                                            <th class="px-5 py-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[13px]">
                                        
                                        <!-- Row 1 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#0B132C] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>TECH</span>
                                                        <span>SUMMIT</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Global Tech Summit 2024</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Technology</td>
                                            <td class="px-5 py-3 text-gray-600">Hall A, Convention Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">May 15, 2024</span>
                                                    <span class="text-[11px] text-gray-500">9:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">May 17, 2024</span>
                                                    <span class="text-[11px] text-gray-500">6:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">1,245</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[11px] font-bold">Upcoming</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#10B981] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>SUSTAINABLE</span>
                                                        <span>EXPO</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Sustainable World Expo</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Environment</td>
                                            <td class="px-5 py-3 text-gray-600">Hall B, Expo Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Jun 10, 2024</span>
                                                    <span class="text-[11px] text-gray-500">10:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Jun 12, 2024</span>
                                                    <span class="text-[11px] text-gray-500">5:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">856</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[11px] font-bold">Upcoming</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#3B82F6] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>HEALTHCARE</span>
                                                        <span>FORUM</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Healthcare Innovation Forum</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Healthcare</td>
                                            <td class="px-5 py-3 text-gray-600">Hall C, Convention Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Jul 20, 2024</span>
                                                    <span class="text-[11px] text-gray-500">9:30 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Jul 20, 2024</span>
                                                    <span class="text-[11px] text-gray-500">4:30 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">432</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[11px] font-bold">Ongoing</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 4 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#6366F1] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>AI &</span>
                                                        <span>ROBOTICS</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">AI & Robotics Conference</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Technology</td>
                                            <td class="px-5 py-3 text-gray-600">Hall A, Convention Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Apr 25, 2024</span>
                                                    <span class="text-[11px] text-gray-500">9:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Apr 25, 2024</span>
                                                    <span class="text-[11px] text-gray-500">6:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">980</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[11px] font-bold">Completed</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 5 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#3723db] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>EDUCATION</span>
                                                        <span>SUMMIT</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Future of Education Summit</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Education</td>
                                            <td class="px-5 py-3 text-gray-600">Hall D, Expo Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Mar 15, 2024</span>
                                                    <span class="text-[11px] text-gray-500">9:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Mar 16, 2024</span>
                                                    <span class="text-[11px] text-gray-500">5:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">670</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[11px] font-bold">Completed</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 6 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#F59E0B] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>RETAIL</span>
                                                        <span>EXPO</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Retail & E-commerce Expo</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Business</td>
                                            <td class="px-5 py-3 text-gray-600">Hall B, Expo Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Feb 20, 2024</span>
                                                    <span class="text-[11px] text-gray-500">10:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Feb 22, 2024</span>
                                                    <span class="text-[11px] text-gray-500">5:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">510</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[11px] font-bold">Completed</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 7 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#1E293B] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>CYBER</span>
                                                        <span>SECURITY</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Cybersecurity Summit</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Technology</td>
                                            <td class="px-5 py-3 text-gray-600">Hall C, Convention Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Aug 18, 2024</span>
                                                    <span class="text-[11px] text-gray-500">9:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Aug 18, 2024</span>
                                                    <span class="text-[11px] text-gray-500">5:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">-</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#CBD5E1] text-[11px] font-bold">Draft</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 8 -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-[34px] h-[34px] rounded-md bg-[#0F172A] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[8px] tracking-wide shadow-sm">
                                                        <span>SMART</span>
                                                        <span>MFG</span>
                                                    </div>
                                                    <span class="font-bold text-[#0B132C]">Smart Manufacturing Expo</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-gray-600 font-medium">Manufacturing</td>
                                            <td class="px-5 py-3 text-gray-600">Hall E, Expo Center</td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Sep 10, 2024</span>
                                                    <span class="text-[11px] text-gray-500">10:00 AM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-[#0B132C]">Sep 12, 2024</span>
                                                    <span class="text-[11px] text-gray-500">5:00 PM</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 font-medium text-[#0B132C]">-</td>
                                            <td class="px-5 py-3">
                                                <span class="px-2.5 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#CBD5E1] text-[11px] font-bold">Draft</span>
                                            </td>
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-[15px]"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="px-5 py-3 flex flex-col sm:flex-row items-center justify-between text-[12px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                                <div>Showing 1 to 8 of 24 events</div>
                                <div class="flex items-center gap-1.5">
                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">3</button>
                                    <button class="w-[28px] h-[28px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Sidebar Script -->
    <script src="sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadSidebar('sidebar-container');
        });
    </script>
</body>
</html>


