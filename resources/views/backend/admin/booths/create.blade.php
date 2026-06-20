<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Add Booth</title>
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
    <main class="flex-1 flex flex-col h-full min-w-0 bg-[#F8F9FC]">
        
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
                
                <!-- Page Header & Breadcrumbs -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Add Booth</h1>
                        <p class="text-gray-500 text-[14px]">Create a new booth and add it to hall inventory.</p>
                    </div>
                    <div class="flex items-center gap-2 text-[13px]">
                        <a href="{{ url('/admin/14_booths') }}" class="text-gray-500 hover:text-[#3723db] transition-colors">Booths</a>
                        <i class="ph ph-caret-right text-gray-400 text-[10px]"></i>
                        <span class="text-[#0B132C] font-medium">Add Booth</span>
                    </div>
                </div>

                <!-- 3-Column Layout -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
                    
                    <!-- LEFT COLUMN -->
                    <div class="flex flex-col gap-6">
                        
                        <!-- Booth Information -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-buildings text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Booth Information</h2>
                                    <p class="text-gray-500 text-[13px]">Add basic details about the booth.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1 -->
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Booth Number / Code <span class="text-red-500">*</span></label>
                                    <input type="text" placeholder="Enter booth number or code" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    <p class="text-[12px] text-gray-400 mt-1.5">E.g. A-101, B205</p>
                                </div>

                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Booth Category <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select category</option>
                                                <option>Standard</option>
                                                <option>Premium</option>
                                                <option>Island</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exhibition <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select exhibition</option>
                                                <option>Global Tech Summit</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Pavilion <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select pavilion</option>
                                                <option>USA Pavilion</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Hall <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select hall</option>
                                                <option>Hall A</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 4 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Level / Floor <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select level / floor</option>
                                                <option>Level 1</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Booth Type <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select booth type</option>
                                                <option>Corner</option>
                                                <option>Island</option>
                                                <option>Inline</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        <p class="text-[12px] text-gray-400 mt-1.5">E.g. Corner, Island, Inline</p>
                                    </div>
                                </div>

                                <!-- Row 5 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Row (Optional)</label>
                                        <input type="text" placeholder="Enter row (e.g. A, B, C)" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Column (Optional)</label>
                                        <input type="text" placeholder="Enter column (e.g. 01, 02)" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                </div>
                                
                                <!-- Row 6 -->
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Tagline / Subtitle (Optional)</label>
                                    <input type="text" placeholder="Enter tagline or subtitle for booth" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                </div>
                                
                                <!-- Row 7 -->
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Short Description (Optional)</label>
                                    <div class="relative">
                                        <textarea placeholder="Enter short description about the booth" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 h-[100px] resize-none"></textarea>
                                        <span class="absolute bottom-2.5 right-3 text-[11px] text-gray-400">0 / 250</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability & Status -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-calendar-check text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Availability & Status</h2>
                                    <p class="text-gray-500 text-[13px]">Set availability and status for the booth.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-900 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer font-medium">
                                                <option>Available</option>
                                                <option>Booked</option>
                                                <option>Reserved</option>
                                                <option>Maintenance</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Availability <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-900 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer font-medium">
                                                <option>Available</option>
                                                <option>Unavailable</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Available From</label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select date" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 cursor-pointer" readonly>
                                            <i class="ph ph-calendar-blank absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Available To</label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select date" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 cursor-pointer" readonly>
                                            <i class="ph ph-calendar-blank absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- WRAPPER FOR MIDDLE AND RIGHT COLUMNS -->
                    <div class="xl:col-span-2 flex flex-col gap-6">
                        
                        <!-- Top part of wrapper: Middle and Right columns -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                            
                            <!-- MIDDLE COLUMN -->
                            <div class="flex flex-col gap-6">
                                
                                <!-- Location Information -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                                    <div class="flex items-start gap-4 mb-8">
                                        <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                            <i class="ph ph-map-pin text-[22px]"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Location</h2>
                                            <p class="text-gray-500 text-[13px]">Add location details of the booth.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Location / Position <span class="text-red-500">*</span></label>
                                            <input type="text" placeholder="Enter location or position (e.g., Near Entrance)" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exact Position (Optional)</label>
                                            <input type="text" placeholder="Enter exact position in the hall" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Map Location (Optional)</label>
                                            <input type="text" placeholder="Enter map location or address" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                        <div>
                                            <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Google Map Link (Optional)</label>
                                            <div class="relative">
                                                <i class="ph ph-link absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                                <input type="text" placeholder="https://maps.google.com/..." class="w-full bg-white border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booth Images & Documents -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                                    <div class="flex items-start gap-4 mb-8">
                                        <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                            <i class="ph ph-image text-[22px]"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Booth Images & Documents</h2>
                                            <p class="text-gray-500 text-[13px]">Upload images and documents.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Booth Image <span class="text-red-500">*</span></label>
                                                <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-6 px-4 text-center cursor-pointer transition-colors group">
                                                    <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] mb-3 group-hover:scale-110 transition-transform">
                                                        <i class="ph ph-upload-simple text-lg"></i>
                                                    </div>
                                                    <span class="text-[13px] font-semibold text-[#0B132C] mb-1">Upload Image</span>
                                                    <span class="text-[10px] text-gray-400">PNG, JPG or WebP. Max size 2MB</span>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Booth Layout Plan (Optional)</label>
                                                <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-6 px-4 text-center cursor-pointer transition-colors group">
                                                    <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] mb-3 group-hover:scale-110 transition-transform">
                                                        <i class="ph ph-upload-simple text-lg"></i>
                                                    </div>
                                                    <span class="text-[13px] font-semibold text-[#0B132C] mb-1">Upload Layout Plan</span>
                                                    <span class="text-[10px] text-gray-400">PNG, JPG or PDF. Max size 5MB</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Additional Documents (Optional)</label>
                                            <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-6 px-4 text-center cursor-pointer transition-colors group w-full">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] group-hover:scale-110 transition-transform">
                                                        <i class="ph ph-upload-simple text-lg"></i>
                                                    </div>
                                                    <div class="flex flex-col text-left">
                                                        <span class="text-[13px] font-semibold text-[#0B132C]">Upload Documents</span>
                                                        <span class="text-[11px] text-gray-400">PDF, DOC, XLS or PPT. Max size 10MB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <!-- RIGHT COLUMN -->
                            <div class="flex flex-col gap-6">
                                
                                <!-- Size & Capacity -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                                    <div class="flex items-start gap-4 mb-8">
                                        <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                            <i class="ph ph-bounding-box text-[22px]"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Size & Capacity</h2>
                                            <p class="text-gray-500 text-[13px]">Add size and capacity details.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <!-- Row 1 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Size (sq.m) <span class="text-red-500">*</span></label>
                                                <input type="text" placeholder="Enter size in sq.m" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                                <p class="text-[12px] text-gray-400 mt-1.5">E.g. 9</p>
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Dimension (L × W × H)</label>
                                                <input type="text" placeholder="Enter dimensions" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                                <p class="text-[12px] text-gray-400 mt-1.5">E.g. 3m x 3m x 3m</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Row 2 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Capacity (sq.m) <span class="text-red-500">*</span></label>
                                                <input type="text" placeholder="Enter capacity in sq.m" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Maximum Staff (Optional)</label>
                                                <input type="text" placeholder="Enter max staff allowed" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                        </div>
                                        
                                        <!-- Row 3 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Minimum Booths (Optional)</label>
                                                <input type="text" placeholder="Enter minimum booths" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Maximum Booths (Optional)</label>
                                                <input type="text" placeholder="Enter maximum booths" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                                    <div class="flex items-start gap-4 mb-8">
                                        <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                            <i class="ph ph-tag text-[22px]"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Pricing</h2>
                                            <p class="text-gray-500 text-[13px]">Set pricing and tax details for the booth.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <!-- Row 1 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Price Per Sq.m <span class="text-red-500">*</span></label>
                                                <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm focus-within:border-[#3723db] focus-within:ring-1 focus-within:ring-[#3723db] transition-all bg-white">
                                                    <div class="relative border-r border-gray-200 w-[75px] shrink-0 bg-gray-50">
                                                        <select class="w-full h-full appearance-none bg-transparent pl-3 pr-5 py-2.5 text-[14px] text-gray-700 focus:outline-none cursor-pointer">
                                                            <option>USD</option>
                                                            <option>EUR</option>
                                                        </select>
                                                        <i class="ph ph-caret-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[12px]"></i>
                                                    </div>
                                                    <input type="text" placeholder="Enter price" class="flex-1 w-full px-3 py-2.5 text-[14px] text-gray-700 focus:outline-none placeholder-gray-400">
                                                </div>
                                                <p class="text-[12px] text-gray-400 mt-1.5">Price per square meter</p>
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Total Price (Auto)</label>
                                                <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm bg-gray-50 opacity-80">
                                                    <div class="border-r border-gray-200 w-[75px] shrink-0 flex items-center px-3 py-2.5 text-[14px] text-gray-500 font-medium bg-gray-100">
                                                        USD
                                                    </div>
                                                    <input type="text" value="0.00" class="flex-1 w-full px-3 py-2.5 text-[14px] text-gray-500 font-medium bg-transparent focus:outline-none" disabled>
                                                </div>
                                                <p class="text-[12px] text-gray-400 mt-1.5">Calculated automatically</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Row 2 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Currency</label>
                                                <div class="relative">
                                                    <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                        <option value="" disabled selected>Select currency</option>
                                                        <option>USD</option>
                                                        <option>EUR</option>
                                                    </select>
                                                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Tax (%) (Optional)</label>
                                                <input type="text" placeholder="Enter tax percentage" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                        </div>

                                        <!-- Row 3 -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Discount (%) (Optional)</label>
                                                <input type="text" placeholder="Enter discount percentage" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                            </div>
                                            <div>
                                                <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Final Price (Auto)</label>
                                                <div class="flex border border-gray-200 rounded-lg overflow-hidden shadow-sm bg-gray-50 opacity-80">
                                                    <div class="border-r border-gray-200 w-[75px] shrink-0 flex items-center px-3 py-2.5 text-[14px] text-gray-500 font-medium bg-gray-100">
                                                        USD
                                                    </div>
                                                    <input type="text" value="0.00" class="flex-1 w-full px-3 py-2.5 text-[14px] text-gray-500 font-medium bg-transparent focus:outline-none" disabled>
                                                </div>
                                                <p class="text-[12px] text-gray-400 mt-1.5">Calculated automatically</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <!-- Additional Information (Spans full width of the middle + right layout) -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-info text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Additional Information</h2>
                                    <p class="text-gray-500 text-[13px]">Add any other relevant information.</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Display Order</label>
                                    <input type="text" placeholder="Enter display order" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    <p class="text-[12px] text-gray-400 mt-1.5">Lower numbers show first</p>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Notes (Optional)</label>
                                    <div class="relative">
                                        <textarea placeholder="Enter any additional notes" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 h-[80px] resize-none"></textarea>
                                        <span class="absolute bottom-2.5 right-3 text-[11px] text-gray-400">0 / 500</span>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-start md:pt-8">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <div class="relative flex items-center justify-center w-5 h-5 mt-0.5">
                                            <input type="checkbox" class="peer sr-only" checked>
                                            <div class="w-5 h-5 border border-gray-300 rounded bg-white peer-checked:bg-[#3723db] peer-checked:border-[#3723db] transition-colors shadow-sm"></div>
                                            <i class="ph-bold ph-check absolute text-white text-[12px] opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[14px] font-bold text-[#0B132C]">Publish Booth Immediately</span>
                                            <span class="text-[12px] text-gray-500 mt-0.5">Make booth visible in the system</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Bar -->
                <div class="mt-8 flex items-center justify-end gap-4">
                    <button class="px-6 py-2.5 rounded-[10px] text-[14px] font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                        Cancel
                    </button>
                    <button class="px-6 py-2.5 rounded-[10px] text-[14px] font-semibold text-[#3723db] bg-[#F4F2FF] border border-[#F4F2FF] hover:bg-[#e9e4ff] transition-colors shadow-sm">
                        Save as Draft
                    </button>
                    <button class="px-6 py-2.5 rounded-[10px] text-[14px] font-semibold text-white bg-[#3723db] hover:bg-[#2515a6] transition-colors shadow-md">
                        Add Booth
                    </button>
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


