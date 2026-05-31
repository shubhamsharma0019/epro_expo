<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Roles & Permissions</title>
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

        /* Tiny Table Toggle Switch */
        .table-toggle {
            appearance: none;
            width: 28px;
            height: 16px;
            background-color: #E2E8F0;
            border-radius: 9999px;
            position: relative;
            cursor: pointer;
            outline: none;
            transition: background-color 0.2s;
        }
        .table-toggle::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 12px;
            height: 12px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .table-toggle:checked {
            background-color: #3723db;
        }
        .table-toggle:checked::after {
            transform: translateX(12px);
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
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden m-0 p-0 text-[#1E293B]">
    
    <!-- Sidebar Container -->
    <div id="sidebar-container" class="w-[260px] bg-[#0b132c] h-full shrink-0 hidden sm:block"></div>
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full min-w-0">
        
        <!-- Top Header Area -->
        <header class="bg-white border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 lg:px-8 py-5 shrink-0 relative z-10 gap-4 sm:gap-0">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[20px] font-bold text-[#0B132C]">Roles & Permissions</h1>
                <p class="text-gray-500 text-[13px] mt-0.5">Manage user roles and set permissions.</p>
            </div>
            
            <!-- Right Side: Search, Bell, Profile -->
            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">12</span>
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

        <!-- Top Actions Below Header -->
        <div class="px-6 lg:px-8 py-4 flex items-center justify-end gap-3 shrink-0 bg-[#F8F9FC]">
            <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                <i class="ph ph-info text-lg text-gray-500"></i>
                Permission Guidelines
            </button>
            <button class="flex items-center gap-2 bg-[#3723db] text-white px-4 py-2 rounded-[8px] text-[13px] font-semibold shadow-sm hover:bg-[#2b1aa5] transition-colors">
                <i class="ph ph-plus text-lg"></i>
                Add Role
            </button>
        </div>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 lg:px-8 pb-8 main-scrollbar bg-[#F8F9FC]">
            <div class="max-w-[1600px] mx-auto">
                
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <!-- Left Sidebar (Roles List) -->
                    <div class="w-full lg:w-[300px] shrink-0 flex flex-col h-[calc(100vh-160px)]">
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-4 flex-1 flex flex-col">
                            
                            <!-- Header & Search -->
                            <div class="mb-5 px-1">
                                <h2 class="text-[15px] font-bold text-[#0B132C]">Roles</h2>
                                <p class="text-[12px] text-gray-500 mt-0.5 mb-4">Create and manage roles for your team.</p>
                                
                                <div class="relative">
                                    <i class="ph ph-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                                    <input type="text" placeholder="Search roles..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-[8px] text-[13px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-colors">
                                </div>
                            </div>
                            
                            <!-- Roles List -->
                            <div class="flex-1 overflow-y-auto main-scrollbar pr-1">
                                <ul class="space-y-1.5">
                                    <!-- Super Admin (Active) -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] bg-[#F4F2FF] border border-[#E5E0FF] group cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#E5E0FF] text-[#3723db] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-shield-check text-[16px]"></i>
                                                </div>
                                                <span class="font-bold text-[13px] text-[#3723db]">Super Admin</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-white text-[#3723db] border border-[#E5E0FF] text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">1</span>
                                                <button class="text-[#3723db] hover:text-[#2b1aa5] transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <!-- Admin -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-shield text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Admin</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">3</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Manager -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-user-gear text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Manager</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">5</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Sales Executive -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-user text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Sales Executive</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">8</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Support Agent -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#F3E8FF] text-[#9333EA] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-headset text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Support Agent</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">4</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Finance -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#FEF9C3] text-[#EAB308] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-currency-circle-dollar text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Finance</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">3</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Viewer -->
                                    <li>
                                        <div class="w-full flex items-center justify-between px-3 py-3 rounded-[10px] hover:bg-gray-50 transition-colors group cursor-pointer border border-transparent hover:border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#F1F5F9] text-[#64748B] flex items-center justify-center shrink-0">
                                                    <i class="ph-fill ph-eye text-[16px]"></i>
                                                </div>
                                                <span class="font-semibold text-[13px] text-[#0B132C]">Viewer</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-500 text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full">6</span>
                                                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Add Role Button -->
                            <div class="pt-4 px-1 mt-2">
                                <button class="w-full py-2.5 border-2 border-dashed border-[#E5E0FF] text-[#3723db] rounded-[10px] text-[13px] font-bold hover:bg-[#F4F2FF] transition-colors flex items-center justify-center gap-2">
                                    <i class="ph-bold ph-plus text-lg"></i>
                                    Add Role
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Content (Role Details & Permissions) -->
                    <div class="flex-1 bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
                        
                        <!-- Role Header Area -->
                        <div class="px-8 pt-8 pb-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-3">
                                    <h2 class="text-[20px] font-bold text-[#0B132C]">Super Admin</h2>
                                    <span class="bg-[#F4F2FF] text-[#3723db] text-[11px] font-bold px-2.5 py-1 rounded-full border border-[#E5E0FF]">System Role</span>
                                </div>
                                <button class="flex items-center gap-2 border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="ph ph-pencil-simple text-lg text-gray-500"></i>
                                    Edit Role
                                </button>
                            </div>
                            <p class="text-[13px] text-gray-500">Has full access to all modules and settings.</p>
                        </div>
                        
                        <!-- Tabs -->
                        <div class="px-8 border-b border-gray-100 flex gap-6">
                            <button class="pb-3 px-1 tab-active text-[13px]">Permissions</button>
                            <button class="pb-3 px-1 tab-inactive text-[13px]">Users (1)</button>
                            <button class="pb-3 px-1 tab-inactive text-[13px]">Role Details</button>
                        </div>
                        
                        <!-- Permissions Table Section -->
                        <div class="flex-1 overflow-y-auto p-8 main-scrollbar">
                            
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <h3 class="text-[15px] font-bold text-[#0B132C]">Module Permissions</h3>
                                    <p class="text-[13px] text-gray-500 mt-0.5">Configure access permissions for each module.</p>
                                </div>
                                <div class="flex items-center gap-4 text-[12px] font-bold text-[#3723db]">
                                    <button class="hover:text-[#2b1aa5] flex items-center gap-1"><i class="ph-bold ph-caret-down"></i> Expand All</button>
                                    <button class="hover:text-[#2b1aa5] flex items-center gap-1"><i class="ph-bold ph-caret-up"></i> Collapse All</button>
                                </div>
                            </div>
                            
                            <!-- Permissions Table -->
                            <div class="w-full overflow-x-auto pb-4">
                                <table class="w-full text-left min-w-[800px] border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-100">
                                            <th class="py-3 px-4 font-semibold text-[12px] text-gray-500 w-[240px]">Module</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">View</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Add</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Edit</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Delete</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Export</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Import</th>
                                            <th class="py-3 px-2 font-semibold text-[12px] text-gray-500 text-center w-[80px]">Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[13px]">
                                        
                                        <!-- Row: Dashboard -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-chart-pie-slice text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Dashboard</span>
                                                        <span class="text-[11px] text-gray-500">View dashboard and analytics</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Companies -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-buildings text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Companies</span>
                                                        <span class="text-[11px] text-gray-500">Manage companies and profiles</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Exhibitions -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-calendar-blank text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Exhibitions</span>
                                                        <span class="text-[11px] text-gray-500">Manage exhibitions and events</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Booths -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-package text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Booths</span>
                                                        <span class="text-[11px] text-gray-500">Manage booths and allocations</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Bookings -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-calendar-check text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Bookings</span>
                                                        <span class="text-[11px] text-gray-500">Manage booth bookings</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Halls -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-buildings text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Halls</span>
                                                        <span class="text-[11px] text-gray-500">Manage halls and floor plans</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Users / Visitors -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-users text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Users / Visitors</span>
                                                        <span class="text-[11px] text-gray-500">Manage users and visitors</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Tickets / Passes -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#FEF2F2] text-[#EF4444] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-ticket text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Tickets / Passes</span>
                                                        <span class="text-[11px] text-gray-500">Manage tickets and passes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Meetings -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#FEF9C3] text-[#EAB308] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-users-three text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Meetings</span>
                                                        <span class="text-[11px] text-gray-500">Manage meetings and networking</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Enquiries / Leads -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-envelope-simple text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Enquiries / Leads</span>
                                                        <span class="text-[11px] text-gray-500">Manage enquiries and leads</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Payments / Invoices -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-currency-circle-dollar text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Payments / Invoices</span>
                                                        <span class="text-[11px] text-gray-500">Manage payments and invoices</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Reports / Analytics -->
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#F3E8FF] text-[#9333EA] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-chart-bar text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Reports / Analytics</span>
                                                        <span class="text-[11px] text-gray-500">Access reports and analytics</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                        <!-- Row: Settings -->
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#F1F5F9] text-[#64748B] flex items-center justify-center shrink-0">
                                                        <i class="ph ph-gear text-[18px]"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-[#0B132C] block">Settings</span>
                                                        <span class="text-[11px] text-gray-500">Manage system settings</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                            <td class="py-4 px-2 text-center"><input type="checkbox" class="table-toggle" checked></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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
