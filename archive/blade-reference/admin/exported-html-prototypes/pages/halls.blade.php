<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Hall Management</title>
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
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Hall Management</h1>
                        <p class="text-gray-500 text-[14px]">Manage all halls across exhibitions.</p>
                    </div>
                    <div>
                        <button onclick="window.location.href='add_hall.html'" class="flex items-center justify-center gap-2 bg-[#3723db] hover:bg-[#2515a6] text-white px-5 py-2.5 rounded-[10px] text-[14px] font-semibold shadow-md transition-all w-full sm:w-auto">
                            <i class="ph-bold ph-plus text-lg"></i> Add Hall
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Total Halls -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-buildings text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">52</span>
                            <span class="text-[12px] text-gray-500 font-medium">Total Halls</span>
                        </div>
                    </div>
                    
                    <!-- Active -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#E6FBF0] text-[#10B981] flex items-center justify-center shrink-0">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">40</span>
                            <span class="text-[12px] text-gray-500 font-medium">Active</span>
                        </div>
                    </div>
                    
                    <!-- Upcoming -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF5E6] text-[#FF8A00] flex items-center justify-center shrink-0">
                            <i class="ph ph-clock text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">6</span>
                            <span class="text-[12px] text-gray-500 font-medium">Upcoming</span>
                        </div>
                    </div>
                    
                    <!-- Inactive -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFE6EB] text-[#FF3B6A] flex items-center justify-center shrink-0">
                            <i class="ph ph-pause-circle text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">4</span>
                            <span class="text-[12px] text-gray-500 font-medium">Inactive</span>
                        </div>
                    </div>
                    
                    <!-- Draft -->
                    <div class="bg-white rounded-[12px] border border-gray-100 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-cube text-[24px]"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[22px] font-bold text-[#0B132C] leading-none mb-1">2</span>
                            <span class="text-[12px] text-gray-500 font-medium">Draft</span>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                    <div class="relative w-full lg:w-auto">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search halls..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-full lg:w-[320px] text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Exhibitions</option>
                                <option>Global Tech Summit</option>
                                <option>Sustainable World Expo</option>
                            </select>
                            <i class="ph ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                        </div>
                        <div class="relative w-full sm:w-auto">
                            <select class="appearance-none bg-white border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-[14px] text-gray-600 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer w-full shadow-sm">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>Upcoming</option>
                                <option>Inactive</option>
                                <option>Draft</option>
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="text-[13px] text-gray-500 font-semibold border-b border-gray-100 bg-white">
                                    <th class="px-6 py-4">Hall Name</th>
                                    <th class="px-6 py-4 flex items-center gap-1 cursor-pointer hover:text-gray-700">Exhibition <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-6 py-4 flex items-center gap-1 cursor-pointer hover:text-gray-700">Pavilion <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-6 py-4 flex items-center gap-1 cursor-pointer hover:text-gray-700">Location <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-6 py-4 flex items-center gap-1 cursor-pointer hover:text-gray-700">Capacity <i class="ph ph-caret-up-down text-[10px]"></i></th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px]">
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall A - Level 1</span>
                                            <span class="text-[12px] text-gray-500">Main exhibition hall</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/us.png" alt="USA" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">USA Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">Main Building, Level 1</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">2,500 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Active</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall B - Level 2</span>
                                            <span class="text-[12px] text-gray-500">Technology & Innovation</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Global Tech Summit 2024</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/de.png" alt="Germany" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">Germany Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">Main Building, Level 2</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">2,000 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Active</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall C - Level 1</span>
                                            <span class="text-[12px] text-gray-500">Sustainability Zone</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/eu.png" alt="EU" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">European Union Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">East Wing, Level 1</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">1,800 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Upcoming</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall D - Level 2</span>
                                            <span class="text-[12px] text-gray-500">Green Solutions</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Sustainable World Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/in.png" alt="India" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">India Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">East Wing, Level 2</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">1,600 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Active</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall E - Level 1</span>
                                            <span class="text-[12px] text-gray-500">Healthcare Innovations</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Healthcare Innovation Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/jp.png" alt="Japan" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">Japan Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">West Wing, Level 1</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">1,500 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded border border-[#fed7aa] text-[12px] font-bold">Upcoming</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall F - Level 2</span>
                                            <span class="text-[12px] text-gray-500">Medical Equipment</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Healthcare Innovation Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/ae.png" alt="UAE" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">UAE Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">West Wing, Level 2</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">1,400 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#FFE6EB] text-[#FF3B6A] rounded border border-[#fecdd3] text-[12px] font-bold">Inactive</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall G - Level 1</span>
                                            <span class="text-[12px] text-gray-500">Smart Manufacturing</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Smart Manufacturing Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/cn.png" alt="China" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">China Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">South Wing, Level 1</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">2,200 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#E6FBF0] text-[#10B981] rounded border border-[#bbf7d0] text-[12px] font-bold">Active</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-eye text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph ph-pencil-simple text-lg"></i></button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[#0B132C] text-[14px]">Hall H - Level 2</span>
                                            <span class="text-[12px] text-gray-500">Industrial Automation</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#0B132C] text-[13px]">Smart Manufacturing Expo</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-3.5 overflow-hidden rounded-[2px] border border-gray-200 shrink-0">
                                                <img src="https://flagcdn.com/w20/gb.png" alt="UK" class="w-full h-full object-cover">
                                            </div>
                                            <span class="text-gray-700 font-medium text-[13px]">UK Pavilion</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <i class="ph ph-map-pin text-[16px]"></i>
                                            <span class="text-[13px]">South Wing, Level 2</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[#0B132C] font-medium text-[13px]">1,900 sqm</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-[#F1F5F9] text-[#64748B] rounded border border-[#e2e8f0] text-[12px] font-bold">Draft</span>
                                    </td>
                                    <td class="px-6 py-4">
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
                    <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                        <div>Showing 1 to 8 of 52 halls</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">3</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">4</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">5</button>
                            <span class="px-1 text-gray-400">...</span>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">7</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <!-- Sidebar Script -->
    <script src="../assets/js/sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadSidebar('sidebar-container');
        });
    </script>
</body>
</html>


