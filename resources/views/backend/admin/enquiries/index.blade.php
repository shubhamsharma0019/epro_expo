<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Enquiries / Leads</title>
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
                <div>
                    <h1 class="text-[20px] font-bold text-[#0B132C]">Enquiries / Leads</h1>
                    <p class="text-gray-500 text-[13px]">Manage all enquiries and leads.</p>
                </div>
            </div>
            
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
<div class="mx-6 lg:mx-8 mt-6 bg-[#F4F2FF] border border-[#E6E1FF] rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4"><div><h3 class="text-[#0B132C] font-bold">Lead Management upgraded</h3><p class="text-[13px] text-gray-600 mt-1">A dedicated page is available for booth-wise lead capture, lead score, follow-up status, and conversion tracking.</p></div><a href="{{ url('/admin/25_lead_management') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#3723db] text-white text-[13px] font-semibold hover:bg-[#2b1bb7] transition-colors">Open Module <i class="ph ph-arrow-right ml-2"></i></a></div>

            <div class="max-w-[1600px] mx-auto">
                
                <!-- Action Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div class="relative w-full sm:w-auto">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search enquiries..." class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg w-full sm:w-[320px] text-[14px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all text-gray-700 shadow-sm">
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 bg-white rounded-lg text-[13px] font-semibold text-gray-600 shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph ph-funnel text-lg text-[#3723db]"></i>
                            Filters
                        </button>
                        <button class="flex items-center gap-2 bg-[#3723db] border border-[#3723db] px-5 py-2 rounded-lg text-[13px] font-semibold text-white shadow-sm hover:bg-[#2b1aa5] transition-colors">
                            <i class="ph ph-plus-circle text-lg"></i>
                            Add Enquiry
                        </button>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                    <!-- Total Enquiries -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-envelope-simple text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Enquiries</p>
                            <h3 class="text-[22px] font-bold text-[#0B132C]">12,450</h3>
                        </div>
                    </div>
                    
                    <!-- New Enquiries -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F5F3FF] text-[#8B5CF6] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-robot text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[12px] text-gray-500 font-medium mb-0.5">New Enquiries</p>
                            <h3 class="text-[22px] font-bold text-[#0B132C]">2,340</h3>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-files text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[12px] text-gray-500 font-medium mb-0.5">In Progress</p>
                            <h3 class="text-[22px] font-bold text-[#0B132C]">4,120</h3>
                        </div>
                    </div>

                    <!-- Converted -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-check-circle text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[12px] text-gray-500 font-medium mb-0.5">Converted</p>
                            <h3 class="text-[22px] font-bold text-[#0B132C]">4,860</h3>
                        </div>
                    </div>

                    <!-- Closed -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-[10px] bg-[#F8FAFC] text-[#64748B] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-list-dashes text-[24px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[12px] text-gray-500 font-medium mb-0.5">Closed</p>
                            <h3 class="text-[22px] font-bold text-[#0B132C]">1,130</h3>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-[12px] border border-gray-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-visible">
                        <table class="w-full text-left border-collapse whitespace-normal">
                            <thead>
                                <tr class="bg-white border-b border-gray-200 text-[12px] text-gray-500 font-semibold tracking-wide">
                                    <th class="py-4 px-6 font-medium">Enquiry ID</th>
                                    <th class="py-4 px-6 font-medium">Name</th>
                                    <th class="py-4 px-6 font-medium">Company</th>
                                    <th class="py-4 px-6 font-medium">Subject</th>
                                    <th class="py-4 px-6 font-medium">Source</th>
                                    <th class="py-4 px-6 font-medium">Date</th>
                                    <th class="py-4 px-6 font-medium">Status</th>
                                    <th class="py-4 px-6 font-medium">Owner</th>
                                    <th class="py-4 px-6 font-medium text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px]">
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1250</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Rohit Sharma</td>
                                    <td class="py-3.5 px-6 text-gray-600">TechNova Solutions</td>
                                    <td class="py-3.5 px-6 text-gray-600">Booth Booking Enquiry</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E8F0FE] text-[#1A73E8] rounded-md text-[11px] font-semibold">Website</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 16, 2024 10:30 AM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#EFF6FF] text-[#2563EB] rounded-md text-[11px] font-semibold">In Progress</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">John Doe</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1249</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Anjali Singh</td>
                                    <td class="py-3.5 px-6 text-gray-600">Global Tech Summit</td>
                                    <td class="py-3.5 px-6 text-gray-600">Partnership Opportunity</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded-md text-[11px] font-semibold">Email</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 16, 2024 09:15 AM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#F5F3FF] text-[#8B5CF6] rounded-md text-[11px] font-semibold">New</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Priya+Nair&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Priya Nair</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1248</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Suresh Patel</td>
                                    <td class="py-3.5 px-6 text-gray-600">Future AI Conference</td>
                                    <td class="py-3.5 px-6 text-gray-600">Speaking Slot Request</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#F3E8FF] text-[#9333EA] rounded-md text-[11px] font-semibold">Phone</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024 04:45 PM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#EFF6FF] text-[#2563EB] rounded-md text-[11px] font-semibold">In Progress</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Arjun+Mehta&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Arjun Mehta</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1247</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Neha Verma</td>
                                    <td class="py-3.5 px-6 text-gray-600">SmartTech Pvt. Ltd.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Sponsorship Enquiry</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E8F0FE] text-[#1A73E8] rounded-md text-[11px] font-semibold">Website</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024 02:20 PM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#F5F3FF] text-[#8B5CF6] rounded-md text-[11px] font-semibold">New</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Neha+Verma&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Neha Verma</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 5 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1246</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Arjun Mehta</td>
                                    <td class="py-3.5 px-6 text-gray-600">InnovateX Corp.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Exhibition Participation</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold">Referral</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 15, 2024 11:05 AM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-md text-[11px] font-semibold">Qualified</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Rohit+Sharma&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Rohit Sharma</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 6 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1245</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Priya Nair</td>
                                    <td class="py-3.5 px-6 text-gray-600">HealthCare Leaders</td>
                                    <td class="py-3.5 px-6 text-gray-600">Visitor Registration</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#FFE4E6] text-[#E11D48] rounded-md text-[11px] font-semibold">Social Media</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024 06:30 PM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold">Converted</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Vikram+Joshi&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Vikram Joshi</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 7 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1244</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Vikram Joshi</td>
                                    <td class="py-3.5 px-6 text-gray-600">CloudSync Inc.</td>
                                    <td class="py-3.5 px-6 text-gray-600">Product Demo Request</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded-md text-[11px] font-semibold">Email</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024 03:10 PM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#EFF6FF] text-[#2563EB] rounded-md text-[11px] font-semibold">In Progress</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Kavita+Reddy&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Kavita Reddy</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 8 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1243</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Kavita Reddy</td>
                                    <td class="py-3.5 px-6 text-gray-600">NextGen Energy</td>
                                    <td class="py-3.5 px-6 text-gray-600">Media Partnership</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E8F0FE] text-[#1A73E8] rounded-md text-[11px] font-semibold">Website</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 14, 2024 10:00 AM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#F5F3FF] text-[#8B5CF6] rounded-md text-[11px] font-semibold">New</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Suresh+Patel&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Suresh Patel</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 9 -->
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1242</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Rahul Khanna</td>
                                    <td class="py-3.5 px-6 text-gray-600">CloudTech Solutions</td>
                                    <td class="py-3.5 px-6 text-gray-600">Bulk Booking Enquiry</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E6FBF0] text-[#10B981] rounded-md text-[11px] font-semibold">Email</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 13, 2024 04:25 PM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-md text-[11px] font-semibold">Converted</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Anjali+Singh&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Anjali Singh</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 10 -->
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-6 font-medium text-[#3723db]">ENQ-2024-1241</td>
                                    <td class="py-3.5 px-6 font-medium text-gray-800">Sneha Iyer</td>
                                    <td class="py-3.5 px-6 text-gray-600">BuildTech Expo</td>
                                    <td class="py-3.5 px-6 text-gray-600">General Information</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#E0E7FF] text-[#4F46E5] rounded-md text-[11px] font-semibold">Walk-in</span>
                                    </td>
                                    <td class="py-3.5 px-6 text-gray-600">May 13, 2024 11:50 AM</td>
                                    <td class="py-3.5 px-6">
                                        <span class="px-2.5 py-1 bg-[#F1F5F9] text-[#64748B] rounded-md text-[11px] font-semibold">Closed</span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=Rahul+Khanna&background=random" class="w-6 h-6 rounded-full" alt="avatar">
                                            <span class="text-gray-700 font-medium">Rahul Khanna</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-[#3723db] hover:bg-[#F4F2FF] hover:border-[#3723db] transition-colors"><i class="ph ph-eye"></i></button>
                                            <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors"><i class="ph ph-dots-three-vertical"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-3 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4">
                        <div>Showing 1 to 10 of 12,450 enquiries</div>
                        <div class="flex gap-1.5">
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded bg-[#3723db] text-white border border-[#3723db] font-bold shadow-sm">1</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">2</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">3</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">4</button>
                            <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">5</button>
                            <span class="w-[32px] h-[32px] flex items-center justify-center text-gray-400">...</span>
                            <button class="w-[45px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">1245</button>
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
