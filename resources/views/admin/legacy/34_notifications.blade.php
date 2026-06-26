<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Notifications</title>
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
        
        /* Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3723db;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #3723db;
        }
        .toggle-checkbox:checked + .toggle-label:after {
            transform: translateX(100%);
            border-color: white;
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
        <header class="h-[76px] bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-8 shrink-0 relative z-10">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[20px] font-bold text-[#0B132C]">Notifications</h1>
                <p class="text-gray-500 text-[13px] mt-0.5">Stay updated with important alerts and activities.</p>
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

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-[#F8F9FC]">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Page Top Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <h2 class="text-[16px] font-bold text-[#0B132C]">Filters</h2>
                    <div class="flex items-center gap-3">
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph ph-check-circle text-lg text-gray-500"></i>
                            Mark all as read
                        </button>
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph ph-gear text-lg text-gray-500"></i>
                            Notification Settings
                        </button>
                    </div>
                </div>

                <!-- Main Layout Grid -->
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <!-- Left Sidebar (Filters) -->
                    <div class="w-full lg:w-[280px] shrink-0 flex flex-col gap-6">
                        <!-- Filter List -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-3">
                            <ul class="space-y-1">
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] bg-[#F4F2FF] text-[#3723db] transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-bell text-lg"></i>
                                            <span class="font-semibold text-[13px]">All Notifications</span>
                                        </div>
                                        <span class="bg-[#E5E0FF] text-[#3723db] text-[11px] font-bold px-2 py-0.5 rounded-full">12</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-gear text-lg text-gray-400 group-hover:text-gray-600"></i>
                                            <span class="font-medium text-[13px]">System</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">3</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-users text-lg text-[#10B981]"></i>
                                            <span class="font-medium text-[13px]">Enquiries / Leads</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">2</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-calendar-blank text-lg text-[#3B82F6]"></i>
                                            <span class="font-medium text-[13px]">Bookings</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">2</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-currency-circle-dollar text-lg text-[#F59E0B]"></i>
                                            <span class="font-medium text-[13px]">Payments / Invoices</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">2</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-presentation-chart text-lg text-[#8B5CF6]"></i>
                                            <span class="font-medium text-[13px]">Exhibitions</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">1</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-users-three text-lg text-[#06B6D4]"></i>
                                            <span class="font-medium text-[13px]">Meetings</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">1</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-ticket text-lg text-[#3B82F6]"></i>
                                            <span class="font-medium text-[13px]">Tickets / Passes</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">1</span>
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full flex items-center justify-between px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <i class="ph ph-lifebuoy text-lg text-[#EF4444]"></i>
                                            <span class="font-medium text-[13px]">Support / Helpdesk</span>
                                        </div>
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-2 py-0.5 rounded-full">0</span>
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="mt-6 mb-4 px-4 flex items-center justify-between">
                                <span class="text-[13px] font-semibold text-gray-700">Unread Only</span>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                    <label for="toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                            
                            <div class="px-2 mt-6 mb-2">
                                <button class="w-full flex items-center gap-2 justify-center py-2.5 rounded-[8px] text-[#EF4444] text-[13px] font-semibold hover:bg-red-50 transition-colors">
                                    <i class="ph ph-trash text-lg"></i>
                                    Clear All Notifications
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Content (Notifications List) -->
                    <div class="flex-1 bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col overflow-hidden">
                        
                        <!-- List Header -->
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-[15px] font-bold text-[#0B132C]">All Notifications (12)</h2>
                            <button class="flex items-center gap-1.5 text-[12px] text-gray-500 font-medium hover:text-gray-800 transition-colors">
                                Sort by: <span class="font-bold text-[#0B132C]">Newest First</span> <i class="ph-bold ph-caret-down text-[10px]"></i>
                            </button>
                        </div>
                        
                        <!-- Notifications List -->
                        <div class="flex-1 overflow-y-auto">
                            
                            <!-- Item 1 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF] ml-3">
                                    <i class="ph ph-user-plus text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">New Enquiry Received</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Rohit Sharma from TechNova Solutions submitted a new booth booking enquiry.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">2 mins ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>
                            
                            <!-- Item 2 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-[#D1FAE5] ml-3">
                                    <i class="ph ph-file-text text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">Payment Received</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Payment of ₹1,20,000 received from TechNova Solutions (INV-2024-1567).</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">15 mins ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 3 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0 border border-[#DBEAFE] ml-3">
                                    <i class="ph ph-calendar-plus text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">New Booth Booking</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Global Tech Solutions booked a booth in Global Tech Summit 2024.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">30 mins ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 4 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0 border border-[#FFEDD5] ml-3">
                                    <i class="ph ph-power text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">Invoice Overdue</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Invoice INV-2024-1563 is overdue. Please follow up for payment.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">1 hour ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 5 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF] ml-3">
                                    <i class="ph ph-users-three text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">Meeting Scheduled</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">A meeting has been scheduled with Anjali Singh on May 17, 2024 at 11:00 AM.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">2 hours ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 6 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0 border border-[#DBEAFE] ml-3">
                                    <i class="ph ph-ticket text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">New Ticket Booking</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Priya Nair booked 2 tickets for Future AI Conference.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">3 hours ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 7 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-[#D1FAE5] ml-3">
                                    <i class="ph ph-check-circle text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">System Update</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">Your system update was completed successfully.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">5 hours ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>

                            <!-- Item 8 -->
                            <div class="flex items-start gap-4 p-5 border-b border-gray-50 hover:bg-gray-50/50 transition-colors relative group">
                                <div class="absolute left-2.5 top-8 w-2 h-2 rounded-full bg-[#3723db]"></div>
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#FEF2F2] text-[#EF4444] flex items-center justify-center shrink-0 border border-[#FEE2E2] ml-3">
                                    <i class="ph ph-lifebuoy text-[20px]"></i>
                                </div>
                                <div class="flex-1 min-w-0 pt-0.5">
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">New Support Ticket</h3>
                                    <p class="text-[13px] text-gray-500 pr-8">A new support ticket #TK-2081 has been created by Rahul Khanna.</p>
                                </div>
                                <div class="flex flex-col items-end gap-3 shrink-0">
                                    <span class="text-[12px] text-gray-400 font-medium">1 day ago</span>
                                    <button class="text-gray-400 hover:text-gray-800"><i class="ph-bold ph-dots-three text-lg"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="px-3 py-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4">
                            <div>Showing 1 to 8 of 12 notifications</div>
                            <div class="flex gap-1.5">
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded bg-[#3723db] text-white border border-[#3723db] font-bold shadow-sm">1</button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">2</button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right text-gray-400"></i></button>
                            </div>
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
