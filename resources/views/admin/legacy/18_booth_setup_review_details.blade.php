<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Booth Setup Review</title>
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
        
        /* Custom Radio Buttons */
        .custom-radio input[type="radio"]:checked + div {
            border-color: #10B981;
        }
        .custom-radio input[type="radio"]:checked + div .inner-circle {
            background-color: #10B981;
            transform: scale(1);
        }
        .custom-radio input[type="radio"] + div .inner-circle {
            transform: scale(0);
            transition: transform 0.2s ease-in-out;
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
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Booth Setup Review</h1>
                        <p class="text-gray-500 text-[14px] mb-4">Review the booth setup details submitted by the exhibitor and take necessary action.</p>
                        
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] rounded-full text-[12px] font-bold border border-[#fed7aa]">Under Review</span>
                            <span class="text-[14px] text-gray-500">Request ID: <span class="font-bold text-[#3723db]">SET-2024-0128</span></span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-4">
                        <div class="flex items-center gap-2 text-[13px]">
                            <a href="#" class="text-gray-500 hover:text-[#3723db] transition-colors">Booths</a>
                            <i class="ph ph-caret-right text-gray-400 text-[10px]"></i>
                            <a href="#" class="text-gray-500 hover:text-[#3723db] transition-colors">Booth Setup Review</a>
                            <i class="ph ph-caret-right text-gray-400 text-[10px]"></i>
                            <span class="text-[#0B132C] font-medium">Review Details</span>
                        </div>
                        
                        <div class="flex items-center gap-3 mt-2 md:mt-6">
                            <a href="{{ url('/admin/17_booth_setup_review') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-[10px] text-[13px] font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                                <i class="ph ph-arrow-left text-lg"></i> Back to List
                            </a>
                            <div class="relative">
                                <button class="flex items-center gap-2 px-4 py-2.5 rounded-[10px] text-[13px] font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                                    More Actions <i class="ph ph-caret-down text-gray-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Layout Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
                    
                    <!-- LEFT WRAPPER (Col Span 2) -->
                    <div class="xl:col-span-2 flex flex-col gap-6">
                        
                        <!-- Exhibitor & Booth Information Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-6">Exhibitor & Booth Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Company Details -->
                                <div class="flex items-start gap-4">
                                    <div class="w-[60px] h-[60px] rounded-[12px] bg-[#0B132C] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-tight text-[12px] shadow-sm">
                                        <span>TECH</span>
                                        <span class="text-[#3723db]">NOVA</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <h3 class="text-[#0B132C] font-bold text-[15px] mb-1">TechNova Solutions Pvt. Ltd.</h3>
                                        <a href="mailto:john@technova.com" class="text-gray-500 text-[13px] hover:text-[#3723db] transition-colors mb-0.5">john@technova.com</a>
                                        <span class="text-gray-500 text-[13px] mb-3">+1 555-123-4567</span>
                                        <a href="#" class="text-[#3723db] text-[13px] font-medium flex items-center gap-1 hover:underline">
                                            View Exhibitor Profile <i class="ph ph-arrow-square-out"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Booth Info Details -->
                                <div class="grid grid-cols-1 gap-y-3 pl-0 md:pl-8 md:border-l border-gray-100">
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-envelope-simple text-[16px]"></i> Exhibition
                                        </div>
                                        <div class="text-[#0B132C] font-medium">Global Tech Summit 2024</div>
                                    </div>
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-flag text-[16px]"></i> Pavilion
                                        </div>
                                        <div class="text-[#0B132C] font-medium">USA Pavilion</div>
                                    </div>
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-buildings text-[16px]"></i> Hall
                                        </div>
                                        <div class="text-[#0B132C] font-medium">Hall A - Level 1</div>
                                    </div>
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-bounding-box text-[16px]"></i> Booth No.
                                        </div>
                                        <div class="text-[#0B132C] font-medium">A-101</div>
                                    </div>
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-arrows-out text-[16px]"></i> Booth Size
                                        </div>
                                        <div class="text-[#0B132C] font-medium">18 sqm (Standard)</div>
                                    </div>
                                    <div class="flex items-center text-[13px]">
                                        <div class="w-24 text-gray-500 flex items-center gap-2 shrink-0">
                                            <i class="ph ph-calendar-blank text-[16px]"></i> Submitted On
                                        </div>
                                        <div class="text-[#0B132C] font-medium">Apr 28, 2024 10:30 AM</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabbed Content Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col">
                            <!-- Tabs -->
                            <div class="flex items-center gap-6 px-6 lg:px-8 border-b border-gray-100 overflow-x-visible main-scrollbar whitespace-normal">
                                <button class="py-4 text-[14px] font-semibold text-[#3723db] border-b-2 border-[#3723db]">Booth Setup Details</button>
                                <button class="py-4 text-[14px] font-medium text-gray-500 hover:text-gray-800 transition-colors">Booth Layout</button>
                                <button class="py-4 text-[14px] font-medium text-gray-500 hover:text-gray-800 transition-colors">Images & Documents</button>
                                <button class="py-4 text-[14px] font-medium text-gray-500 hover:text-gray-800 transition-colors">Additional Information</button>
                                <button class="py-4 text-[14px] font-medium text-gray-500 hover:text-gray-800 transition-colors">Activity Log</button>
                            </div>
                            
                            <!-- Tab Content -->
                            <div class="p-6 lg:p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    
                                    <!-- Left Content (Booth Setup Summary) -->
                                    <div class="space-y-6">
                                        <h3 class="text-[15px] font-bold text-[#0B132C]">Booth Setup Summary</h3>
                                        
                                        <div class="space-y-4">
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Booth Type</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Standard</div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Booth Category</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Technology</div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Setup Type</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Shell Scheme</div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Design Theme</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Modern & Minimal</div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0 mt-1">Colors</div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="px-2 py-1 rounded bg-[#1E3A8A] text-white text-[11px] font-bold">#1E3A8A</span>
                                                    <span class="px-2 py-1 rounded bg-[#10B981] text-white text-[11px] font-bold">#10B981</span>
                                                    <span class="px-2 py-1 rounded bg-[#F3F4F6] text-[#1E293B] border border-gray-200 text-[11px] font-bold">#F3F4F6</span>
                                                </div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0 mt-0.5">Key Features</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">
                                                    <ul class="list-disc pl-4 space-y-1.5 text-gray-600">
                                                        <li>Product Display Area</li>
                                                        <li>Meeting Area (4 Seater)</li>
                                                        <li>Storage Counter</li>
                                                        <li>Branding Wall with LED Screen</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Power Requirement</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">5 KW</div>
                                            </div>
                                            <div class="flex items-start border-b border-gray-50 pb-4">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0">Internet Requirement</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Yes</div>
                                            </div>
                                            <div class="flex items-start pb-2">
                                                <div class="w-[140px] text-[13px] text-gray-500 shrink-0 mt-0.5">Special Requirements</div>
                                                <div class="text-[13px] text-[#0B132C] font-medium">Hanging banner (3m x 1m), Water connection</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Content (Description & Compliance) -->
                                    <div class="space-y-8">
                                        <!-- Description -->
                                        <div>
                                            <h3 class="text-[15px] font-bold text-[#0B132C] mb-3">Booth Setup Description</h3>
                                            <p class="text-[13px] text-gray-600 leading-relaxed">
                                                We are setting up an interactive product showcase area with demo counters, a meeting space for clients, and a branded backdrop with LED screen for presentations.
                                            </p>
                                        </div>

                                        <!-- Checklist -->
                                        <div>
                                            <h3 class="text-[15px] font-bold text-[#0B132C] mb-4">Checklist & Compliance</h3>
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[13px] text-[#0B132C] font-medium">Fire Safety Compliance</span>
                                                    <span class="px-2 py-0.5 rounded bg-[#E6FBF0] text-[#10B981] text-[11px] font-bold">Compliant</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[13px] text-[#0B132C] font-medium">Electrical Safety</span>
                                                    <span class="px-2 py-0.5 rounded bg-[#E6FBF0] text-[#10B981] text-[11px] font-bold">Compliant</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[13px] text-[#0B132C] font-medium">Structural Safety</span>
                                                    <span class="px-2 py-0.5 rounded bg-[#E6FBF0] text-[#10B981] text-[11px] font-bold">Compliant</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[13px] text-[#0B132C] font-medium">Exhibition Guidelines</span>
                                                    <span class="px-2 py-0.5 rounded bg-[#E6FBF0] text-[#10B981] text-[11px] font-bold">Compliant</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[13px] text-[#0B132C] font-medium">Other Requirements</span>
                                                    <span class="px-2 py-0.5 rounded bg-[#FFF5E6] text-[#FF8A00] text-[11px] font-bold">Pending</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notes -->
                                        <div class="bg-[#F8F9FC] border border-gray-100 rounded-[12px] p-5">
                                            <h3 class="text-[13px] font-bold text-[#0B132C] mb-2">Notes from Exhibitor</h3>
                                            <p class="text-[13px] text-gray-600">
                                                We will require early access on May 14 for setup.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- RIGHT WRAPPER (Col Span 1) -->
                    <div class="xl:col-span-1 flex flex-col gap-6">
                        
                        <!-- Admin Review Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-6">Admin Review</h2>
                            
                            <!-- Alert -->
                            <div class="bg-[#EFF6FF] border border-[#bfdbfe] rounded-[10px] p-4 flex items-start gap-3 mb-6">
                                <i class="ph ph-info text-[#3B82F6] text-[18px] mt-0.5 shrink-0"></i>
                                <p class="text-[13px] text-[#3B82F6] font-medium">
                                    Please review the booth setup details, layout, images and documents carefully before approving or rejecting.
                                </p>
                            </div>
                            
                            <form>
                                <!-- Review Status -->
                                <div class="mb-6">
                                    <label class="block text-[13px] font-bold text-[#0B132C] mb-3">Review Status <span class="text-red-500">*</span></label>
                                    <div class="space-y-4">
                                        <!-- Approve -->
                                        <label class="flex items-start gap-3 cursor-pointer group custom-radio">
                                            <input type="radio" name="reviewStatus" value="approve" class="hidden" checked>
                                            <div class="w-[18px] h-[18px] rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                                                <div class="w-2.5 h-2.5 rounded-full inner-circle"></div>
                                            </div>
                                            <div>
                                                <span class="block text-[14px] font-bold text-[#10B981] mb-0.5">Approve</span>
                                                <span class="block text-[12px] text-gray-500">Booth setup is approved and meets all requirements.</span>
                                            </div>
                                        </label>
                                        
                                        <!-- Reject -->
                                        <label class="flex items-start gap-3 cursor-pointer group custom-radio">
                                            <input type="radio" name="reviewStatus" value="reject" class="hidden">
                                            <div class="w-[18px] h-[18px] rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                                                <div class="w-2.5 h-2.5 rounded-full bg-transparent inner-circle"></div>
                                            </div>
                                            <div>
                                                <span class="block text-[14px] font-bold text-[#EF4444] mb-0.5">Reject</span>
                                                <span class="block text-[12px] text-gray-500">Booth setup does not meet requirements.</span>
                                            </div>
                                        </label>

                                        <!-- Request Changes -->
                                        <label class="flex items-start gap-3 cursor-pointer group custom-radio">
                                            <input type="radio" name="reviewStatus" value="request_changes" class="hidden">
                                            <div class="w-[18px] h-[18px] rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                                                <div class="w-2.5 h-2.5 rounded-full bg-transparent inner-circle"></div>
                                            </div>
                                            <div>
                                                <span class="block text-[14px] font-bold text-[#3B82F6] mb-0.5">Request Changes</span>
                                                <span class="block text-[12px] text-gray-500">Require changes before approval.</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Comments -->
                                <div class="mb-6">
                                    <label class="block text-[13px] font-bold text-[#0B132C] mb-2">Review Comments <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <textarea placeholder="Enter your comments..." class="w-full bg-white border border-gray-200 rounded-lg px-4 py-3 text-[13px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 h-[100px] resize-none"></textarea>
                                        <span class="absolute bottom-2.5 right-3 text-[11px] text-gray-400">0 / 500</span>
                                    </div>
                                </div>
                                
                                <!-- Attachments -->
                                <div class="mb-8">
                                    <label class="block text-[13px] font-bold text-[#0B132C] mb-2">Review Attachments (Optional)</label>
                                    <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-6 px-4 text-center cursor-pointer transition-colors group">
                                        <i class="ph ph-cloud-arrow-up text-[28px] text-[#3723db] mb-2 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-[13px] text-gray-600 mb-1">Drag & drop files here or click to upload</span>
                                        <span class="text-[10px] text-gray-400">PDF, DOC, JPG, PNG (Max 10MB each)</span>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center gap-3 w-full">
                                    <button type="button" class="flex-1 px-4 py-3 rounded-[10px] text-[13px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm text-center">
                                        Cancel
                                    </button>
                                    <button type="button" class="flex-1 px-4 py-3 rounded-[10px] text-[13px] font-bold text-[#3723db] bg-[#F4F2FF] border border-[#F4F2FF] hover:bg-[#e9e4ff] transition-colors shadow-sm text-center">
                                        Save as Draft
                                    </button>
                                    <button type="button" class="flex-1 px-4 py-3 rounded-[10px] text-[13px] font-bold text-white bg-[#3723db] hover:bg-[#2515a6] transition-colors shadow-sm text-center">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Exhibitor Contact Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                            <h2 class="text-[#0B132C] text-[16px] font-bold mb-5">Exhibitor Contact</h2>
                            
                            <div class="flex items-center gap-4 mb-5">
                                <img src="https://i.pravatar.cc/150?img=11" alt="John Smith" class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-100">
                                <div>
                                    <h3 class="text-[#0B132C] font-bold text-[14px]">John Smith</h3>
                                    <p class="text-gray-500 text-[12px] font-medium">Exhibition Manager</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <a href="mailto:john@technova.com" class="flex items-center gap-3 text-[13px] text-gray-600 hover:text-[#3723db] transition-colors">
                                    <div class="w-6 h-6 rounded-md bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                                        <i class="ph ph-envelope-simple text-[14px] text-gray-500"></i>
                                    </div>
                                    john@technova.com
                                </a>
                                <a href="tel:+15551234567" class="flex items-center gap-3 text-[13px] text-gray-600 hover:text-[#3723db] transition-colors">
                                    <div class="w-6 h-6 rounded-md bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                                        <i class="ph ph-phone text-[14px] text-gray-500"></i>
                                    </div>
                                    +1 555-123-4567
                                </a>
                            </div>
                            
                            <button class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-[10px] text-[13px] font-bold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                                <i class="ph ph-chat-circle-dots text-[16px]"></i> Send Message
                            </button>
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


