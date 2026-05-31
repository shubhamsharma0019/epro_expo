<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Payments / Invoices</title>
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
        
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tab specific styles */
        .tab-active {
            color: #3723db;
            border-bottom: 2px solid #3723db;
            font-weight: 600;
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
        
        <!-- Topbar -->
        <header class="h-[76px] bg-white border-b border-gray-100 flex items-center justify-end px-8 shrink-0 relative z-10">
            <!-- Right Side -->
            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">3</span>
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
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-white">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Page Header & Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-[22px] font-bold text-[#0B132C] mb-1">Payments / Invoices</h1>
                        <p class="text-gray-500 text-[14px]">View all payments and manage invoices.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2.5 rounded-[10px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph ph-funnel text-lg"></i>
                            Filters
                        </button>
                        <button class="flex items-center gap-2 bg-[#3723db] border border-[#3723db] px-5 py-2.5 rounded-[10px] text-[13px] font-semibold text-white shadow-sm hover:bg-[#2b1aa5] transition-colors">
                            <i class="ph ph-plus-circle text-lg"></i>
                            Create Invoice
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    
                    <!-- Total Invoices -->
                    <div class="bg-white p-5 rounded-[16px] border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                        <div class="w-[52px] h-[52px] rounded-[12px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                            <i class="ph ph-file-text text-[28px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Total Invoices</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-[24px] font-bold text-[#0B132C]">4,80,000</h3>
                            </div>
                            <p class="text-[12px] text-gray-400 mt-0.5">All Time</p>
                        </div>
                    </div>

                    <!-- Paid Amount -->
                    <div class="bg-white p-5 rounded-[16px] border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                        <div class="w-[52px] h-[52px] rounded-[12px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-currency-inr text-[28px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Paid Amount</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-[24px] font-bold text-[#0B132C]">₹ 4,20,000</h3>
                            </div>
                            <p class="text-[12px] text-[#10B981] font-semibold mt-0.5">87.5% <span class="text-gray-400 font-normal">of Total</span></p>
                        </div>
                    </div>

                    <!-- Pending Amount -->
                    <div class="bg-white p-5 rounded-[16px] border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                        <div class="w-[52px] h-[52px] rounded-[12px] bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-power text-[28px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Pending Amount</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-[24px] font-bold text-[#0B132C]">₹ 60,000</h3>
                            </div>
                            <p class="text-[12px] text-[#EA580C] font-semibold mt-0.5">12.5% <span class="text-gray-400 font-normal">of Total</span></p>
                        </div>
                    </div>

                    <!-- Overdue Amount -->
                    <div class="bg-white p-5 rounded-[16px] border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                        <div class="w-[52px] h-[52px] rounded-[12px] bg-[#FEF2F2] text-[#EF4444] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-file-x text-[28px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Overdue Amount</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-[24px] font-bold text-[#0B132C]">₹ 20,000</h3>
                            </div>
                            <p class="text-[12px] text-[#EF4444] font-semibold mt-0.5">4.1% <span class="text-gray-400 font-normal">of Total</span></p>
                        </div>
                    </div>
                    
                </div>

                <!-- Main Section -->
                <div class="bg-white rounded-[16px] border border-gray-200 shadow-sm overflow-hidden mb-8">
                    
                    <!-- Tabs and Date Picker -->
                    <div class="px-6 border-b border-gray-100 flex flex-col xl:flex-row xl:items-center justify-between gap-4 pt-2">
                        
                        <!-- Tabs -->
                        <div class="flex items-center gap-6 overflow-x-auto no-scrollbar">
                            <button class="py-4 px-1 tab-active whitespace-nowrap text-[14px]">All Invoices</button>
                            <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Paid</button>
                            <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Pending</button>
                            <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Overdue</button>
                            <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Cancelled</button>
                            <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Draft</button>
                        </div>

                        <!-- Date & Export -->
                        <div class="flex items-center gap-3 pb-4 xl:pb-0">
                            <div class="flex items-center bg-white border border-gray-200 rounded-[8px] px-3 py-2 shadow-sm">
                                <span class="text-[13px] text-gray-700 font-medium mr-3">May 01, 2024 - May 31, 2024</span>
                                <i class="ph ph-calendar-blank text-gray-400 text-lg"></i>
                            </div>
                            <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                                <i class="ph ph-export text-lg text-gray-500"></i>
                                Export
                            </button>
                        </div>
                    </div>

                    <!-- Search within Table -->
                    <div class="p-5 border-b border-gray-100">
                        <div class="relative w-full sm:w-[360px]">
                            <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                            <input type="text" placeholder="Search invoices..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-[8px] w-full text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-white border-b border-gray-100 text-[12px] text-gray-500 font-semibold tracking-wide">
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Invoice ID <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Company <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Event / Exhibition <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Invoice Date <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Due Date <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium"><div class="flex items-center gap-1 cursor-pointer hover:text-gray-700">Amount <i class="ph ph-caret-up-down text-[10px] text-gray-400"></i></div></th>
                                    <th class="py-4 px-6 font-medium text-center">Status</th>
                                    <th class="py-4 px-6 font-medium text-center">Payment Status</th>
                                    <th class="py-4 px-6 font-medium text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px]">
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1567</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">TechNova Solutions</td>
                                    <td class="py-3.5 px-6 text-gray-600">Global Tech Summit 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 16, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 30, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹1,20,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1566</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">Global Tech Solutions</td>
                                    <td class="py-3.5 px-6 text-gray-600">Global Tech Summit 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 16, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 30, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹1,50,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1565</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">Future AI Conference</td>
                                    <td class="py-3.5 px-6 text-gray-600">Future AI Conference</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 29, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹75,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1564</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">SmartTech Pvt. Ltd.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Smart Tech Expo 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 29, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹90,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Pending</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Pending</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1563</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">InnovateX Corp.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Healthcare Leaders Summit</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 29, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹60,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FEF2F2] text-[#EF4444] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Overdue</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FEF2F2] text-[#EF4444] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Overdue</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1562</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">HealthCare Leaders</td>
                                    <td class="py-3.5 px-6 text-gray-600">Healthcare Leaders Summit</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 28, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹1,10,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1561</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">CloudSync Inc.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Cloud Tech Solutions 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 28, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹95,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1560</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">NextGen Energy</td>
                                    <td class="py-3.5 px-6 text-gray-600">Sustainability World Expo</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 28, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹80,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Pending</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Pending</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 9 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1559</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">CloudTech Solutions</td>
                                    <td class="py-3.5 px-6 text-gray-600">Cloud Tech Solutions 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 13, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 27, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹1,30,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Paid</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 10 -->
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">INV-2024-1558</td>
                                    <td class="py-3.5 px-6 text-gray-800 font-medium">BuildTech Expo</td>
                                    <td class="py-3.5 px-6 text-gray-600">BuildTech Expo 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 13, 2024</td>
                                    <td class="py-3.5 px-6 text-gray-600">May 27, 2024</td>
                                    <td class="py-3.5 px-6 font-semibold text-[#0B132C]">₹70,000</td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#F8FAFC] text-[#64748B] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Cancelled</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-center">
                                        <span class="px-2.5 py-1 bg-[#F8FAFC] text-[#64748B] rounded-md text-[11px] font-semibold inline-block min-w-[70px]">Cancelled</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-download-simple"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4">
                        <div>Showing 1 to 10 of 4,80,000 invoices</div>
                        <div class="flex gap-1.5">
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded bg-[#3723db] text-white border border-[#3723db] font-bold shadow-sm">1</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">2</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">3</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">4</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">5</button>
                            <span class="w-[32px] h-[32px] flex items-center justify-center text-gray-400">...</span>
                            <button class="w-[50px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">48000</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right text-gray-400"></i></button>
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
