<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Company Approval</title>
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

        <!-- Page Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar">
<div class="mx-6 lg:mx-8 mt-6 bg-[#F4F2FF] border border-[#E6E1FF] rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4"><div><h3 class="text-[#0B132C] font-bold">KYC Verification data added</h3><p class="text-[13px] text-gray-600 mt-1">GST, PAN, CIN, certificate upload, approval remarks aur risk flags verify karne ke liye new KYC module open karein.</p></div><a href="{{ url('/admin/05_kyc_verification') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#3723db] text-white text-[13px] font-semibold hover:bg-[#2b1bb7] transition-colors">Open Module <i class="ph ph-arrow-right ml-2"></i></a></div>

            <div class="max-w-[1400px] mx-auto">
                
                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Company Approval</h1>
                        <p class="text-gray-500 text-[14px]">Review and approve new company registrations.</p>
                    </div>
                    <div>
                        <button class="flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-[10px] text-[14px] font-semibold shadow-sm hover:bg-gray-50 transition-colors w-full sm:w-auto">
                            <i class="ph ph-funnel text-lg text-[#3723db]"></i> Filters
                        </button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex gap-8 border-b border-gray-200 mb-8 overflow-x-visible">
                    <button class="px-1 py-3 border-b-2 border-[#3723db] text-[#3723db] font-semibold text-[14px] whitespace-normal">Pending (14)</button>
                    <button class="px-1 py-3 border-b-2 border-transparent text-gray-500 font-medium text-[14px] hover:text-gray-700 hover:border-gray-300 transition-colors whitespace-normal">Approved (120)</button>
                    <button class="px-1 py-3 border-b-2 border-transparent text-gray-500 font-medium text-[14px] hover:text-gray-700 hover:border-gray-300 transition-colors whitespace-normal">Rejected (8)</button>
                </div>
                
                <!-- Table Section -->
                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm overflow-hidden mb-8">
                    <div class="overflow-x-visible">
                        <table class="w-full text-left border-collapse whitespace-normal">
                            <thead>
                                <tr class="text-[13px] text-gray-500 font-semibold border-b border-gray-100 bg-white">
                                    <th class="px-3 py-3">Company</th>
                                    <th class="px-3 py-3">Contact Person</th>
                                    <th class="px-3 py-3">Email</th>
                                    <th class="px-3 py-3">Phone</th>
                                    <th class="px-3 py-3">Registered On</th>
                                    <th class="px-3 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px]">
                                <!-- Row 1 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-blue-50 text-blue-500 flex items-center justify-center font-bold text-xl shrink-0"><i class="ph-bold ph-text-t"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">TechNova Solutions</span>
                                                <span class="text-[12px] text-gray-500">Innovating the future together.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">John Doe</span>
                                            <span class="text-[12px] text-gray-500">Founder & CEO</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">john.doe@technova.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 98765 43210</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 16, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0"><i class="ph-fill ph-globe"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">Global Tech Summit 2024</span>
                                                <span class="text-[12px] text-gray-500">Bringing tech leaders together.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Alice Johnson</span>
                                            <span class="text-[12px] text-gray-500">Event Manager</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">alice.johnson@gts2024.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 91234 56789</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 15, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-blue-500 text-white flex items-center justify-center font-bold text-[22px] shrink-0">F</div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">FutureSoft Pvt. Ltd.</span>
                                                <span class="text-[12px] text-gray-500">Software solutions for tomorrow.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Robert Brown</span>
                                            <span class="text-[12px] text-gray-500">Head of Business</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">robert.brown@futuresoft.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 99887 76655</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 14, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-[#10B981] text-white flex items-center justify-center font-bold text-[20px] shrink-0">IN</div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">Innovent Corp.</span>
                                                <span class="text-[12px] text-gray-500">Ideas that drive innovation.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Victor Ruiz</span>
                                            <span class="text-[12px] text-gray-500">Co-Founder</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">victor.ruiz@innovent.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 90909 09090</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 13, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-blue-50 text-blue-500 flex items-center justify-center text-[26px] shrink-0"><i class="ph-fill ph-cloud"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">CloudSync Inc.</span>
                                                <span class="text-[12px] text-gray-500">Cloud solutions, simplified.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Emily Davis</span>
                                            <span class="text-[12px] text-gray-500">Operations Head</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">emily.davis@cloudsync.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 88888 12345</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 12, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-teal-50 text-teal-500 flex items-center justify-center text-[26px] shrink-0"><i class="ph-fill ph-gear"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">Smart Manufacturing Expo</span>
                                                <span class="text-[12px] text-gray-500">Empowering manufacturing.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Michael Lee</span>
                                            <span class="text-[12px] text-gray-500">Marketing Director</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">michael.lee@smexpo.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 77777 22222</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 11, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-green-50 text-green-500 flex items-center justify-center text-[26px] shrink-0"><i class="ph-fill ph-dna"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">BioTech Global</span>
                                                <span class="text-[12px] text-gray-500">Advancing life sciences.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Sophia Martinez</span>
                                            <span class="text-[12px] text-gray-500">CEO</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">sophia.martinez@biotech.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 66666 33333</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 10, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Row 8 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-[#3723db] text-white flex items-center justify-center font-bold text-[22px] shrink-0">N</div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">NextGen Innovations</span>
                                                <span class="text-[12px] text-gray-500">Next generation technology.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Daniel Kim</span>
                                            <span class="text-[12px] text-gray-500">Product Head</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">daniel.kim@nextgen.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 55555 44444</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 9, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 9 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-green-50 text-green-500 flex items-center justify-center text-[26px] shrink-0"><i class="ph-fill ph-leaf"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">Green Energy Solutions</span>
                                                <span class="text-[12px] text-gray-500">Powering a sustainable future.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">Laura Wilson</span>
                                            <span class="text-[12px] text-gray-500">Business Development</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">laura.wilson@greenenergy.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 44444 55555</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 8, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 10 -->
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-[10px] bg-pink-50 text-pink-500 flex items-center justify-center text-[26px] shrink-0"><i class="ph-fill ph-heartbeat"></i></div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-[#0B132C] text-[14px]">HealthTech World</span>
                                                <span class="text-[12px] text-gray-500">Technology for better health.</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-[#0B132C]">James Taylor</span>
                                            <span class="text-[12px] text-gray-500">Director</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">james.taylor@healthtech.com</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">+91 33333 66666</td>
                                    <td class="px-3 py-3 text-[#475569] font-medium text-[13px]">May 7, 2024</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-green-500 text-green-600 rounded-[8px] text-[13px] font-bold hover:bg-green-50 transition-colors">
                                                <i class="ph-bold ph-check-circle text-[15px]"></i> Approve
                                            </button>
                                            <button class="flex items-center gap-1.5 px-3 py-1.5 border border-red-500 text-red-600 rounded-[8px] text-[13px] font-bold hover:bg-red-50 transition-colors">
                                                <i class="ph-bold ph-x-circle text-[15px]"></i> Reject
                                            </button>
                                            <button class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border border-gray-200 text-gray-500 hover:text-[#3723db] hover:border-[#3723db] transition-colors"><i class="ph-bold ph-dots-three-vertical text-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-3 py-3 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 border-t border-gray-100">
                        <div>Showing 1 to 10 of 14 pending companies</div>
                        <div class="flex items-center gap-1.5">
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left"></i></button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md bg-[#F4F2FF] text-[#3723db] border border-[#3723db] font-bold">1</button>
                            <button class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-gray-200 hover:bg-gray-50 transition-colors">2</button>
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


