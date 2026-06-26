<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - CMS Management</title>
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
        
        .action-btn {
            @apply w-[28px] h-[28px] flex items-center justify-center rounded-[6px] border bg-white transition-colors;
        }
        .action-btn-primary {
            @apply border-[#E5E0FF] text-[#3723db] hover:bg-[#F4F2FF];
        }
        .action-btn-danger {
            @apply border-[#FEE2E2] text-[#EF4444] hover:bg-[#FEF2F2];
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
        <header class="bg-white border-b border-gray-100 flex flex-col xl:flex-row items-start xl:items-center justify-between px-6 lg:px-8 py-5 shrink-0 relative z-10 gap-4 xl:gap-0">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[20px] font-bold text-[#0B132C]">CMS Management</h1>
                <p class="text-gray-500 text-[13px] mt-0.5">Manage and organize website content, pages, and CMS modules.</p>
            </div>
            
            <!-- Right Side: Search, Filters, Add Button, Notifications, Profile -->
            <div class="flex flex-wrap items-center gap-4">
                
                <!-- Search -->
                <div class="relative w-[280px]">
                    <i class="ph ph-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" placeholder="Search pages, sections or modules..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-[8px] text-[13px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-colors shadow-sm">
                </div>
                
                <!-- Filters -->
                <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="ph ph-faders text-lg text-gray-500"></i>
                    Filters
                </button>
                
                <!-- Add New -->
                <button class="flex items-center gap-2 bg-[#3723db] text-white px-4 py-2 rounded-[8px] text-[13px] font-semibold shadow-sm hover:bg-[#2b1aa5] transition-colors">
                    <i class="ph ph-plus text-lg"></i>
                    Add New
                </button>
                
                <div class="hidden sm:block h-8 w-px bg-gray-200 mx-1"></div>
                
                <!-- Notifications & Profile -->
                <div class="flex items-center gap-5">
                    <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="ph ph-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">12</span>
                    </button>
                    
                    <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3723db&color=fff" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                        <div class="flex flex-col text-left hidden sm:flex">
                            <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                            <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                        </div>
                    </button>
                </div>
            </div>
        </header>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-[#F8F9FC]">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Top 5 Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6 mb-6">
                    
                    <!-- Total Pages -->
                    <div class="bg-white p-4 lg:p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                            <i class="ph ph-file-text text-[20px] lg:text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] lg:text-[13px] text-gray-500 font-medium mb-1">Total Pages</p>
                            <h3 class="text-[20px] lg:text-[24px] font-bold text-[#0B132C] leading-none mb-2">45</h3>
                            <div class="text-[10px] lg:text-[11px] text-gray-500 font-medium">
                                Published: 38 <span class="mx-1"></span> Draft: 7
                            </div>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="bg-white p-4 lg:p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-[10px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-[#D1FAE5]">
                            <i class="ph ph-list-bullets text-[20px] lg:text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] lg:text-[13px] text-gray-500 font-medium mb-1">Menu Items</p>
                            <h3 class="text-[20px] lg:text-[24px] font-bold text-[#0B132C] leading-none mb-2">32</h3>
                            <div class="text-[10px] lg:text-[11px] text-gray-500 font-medium">
                                Active: 28 <span class="mx-1"></span> Inactive: 4
                            </div>
                        </div>
                    </div>

                    <!-- Banners / Sliders -->
                    <div class="bg-white p-4 lg:p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-[10px] bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0 border border-[#DBEAFE]">
                            <i class="ph ph-image text-[20px] lg:text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] lg:text-[13px] text-gray-500 font-medium mb-1">Banners / Sliders</p>
                            <h3 class="text-[20px] lg:text-[24px] font-bold text-[#0B132C] leading-none mb-2">12</h3>
                            <div class="text-[10px] lg:text-[11px] text-gray-500 font-medium">
                                Active: 10 <span class="mx-1"></span> Inactive: 2
                            </div>
                        </div>
                    </div>

                    <!-- Content Blocks -->
                    <div class="bg-white p-4 lg:p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-[10px] bg-[#FEF2F2] text-[#EF4444] flex items-center justify-center shrink-0 border border-[#FEE2E2]">
                            <i class="ph ph-cube text-[20px] lg:text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] lg:text-[13px] text-gray-500 font-medium mb-1">Content Blocks</p>
                            <h3 class="text-[20px] lg:text-[24px] font-bold text-[#0B132C] leading-none mb-2">68</h3>
                            <div class="text-[10px] lg:text-[11px] text-gray-500 font-medium">
                                Published: 54 <span class="mx-1"></span> Draft: 14
                            </div>
                        </div>
                    </div>

                    <!-- Media Files -->
                    <div class="bg-white p-4 lg:p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-3 lg:gap-4">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                            <i class="ph ph-image-square text-[20px] lg:text-[24px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] lg:text-[13px] text-gray-500 font-medium mb-1">Media Files</p>
                            <h3 class="text-[20px] lg:text-[24px] font-bold text-[#0B132C] leading-none mb-2">156</h3>
                            <div class="text-[10px] lg:text-[11px] text-gray-500 font-medium">
                                Images: 120 <span class="mx-1"></span> Files: 36
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Main Grid Layout -->
                <div class="flex flex-col xl:flex-row gap-6 h-[calc(100vh-270px)] min-h-[700px]">
                    
                    <!-- Left Side: Table Area -->
                    <div class="flex-1 bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col overflow-hidden min-w-0">
                        
                        <!-- Tabs -->
                        <div class="px-6 border-b border-gray-100 flex gap-6 overflow-x-visible no-scrollbar flex-wrap pt-4">
                            <button class="pb-3 tab-active text-[13px] whitespace-normal px-1">Pages</button>
                            <button class="pb-3 tab-inactive text-[13px] whitespace-normal px-1">Menus</button>
                            <button class="pb-3 tab-inactive text-[13px] whitespace-normal px-1">Banners / Sliders</button>
                            <button class="pb-3 tab-inactive text-[13px] whitespace-normal px-1">Content Blocks</button>
                            <button class="pb-3 tab-inactive text-[13px] whitespace-normal px-1">Media Library</button>
                            <button class="pb-3 tab-inactive text-[13px] whitespace-normal px-1">SEO Settings</button>
                        </div>

                        <!-- Action Bar -->
                        <div class="px-3 py-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <!-- Search -->
                            <div class="relative w-full sm:w-[280px]">
                                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                                <input type="text" placeholder="Search pages..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-[8px] text-[13px] focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-colors shadow-sm">
                            </div>
                            <!-- Right Actions -->
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <div class="relative w-full sm:w-auto">
                                    <select class="w-full sm:w-[130px] appearance-none bg-white border border-gray-200 text-gray-700 text-[13px] rounded-[8px] px-3 py-2 pr-8 shadow-sm focus:outline-none focus:border-[#3723db]">
                                        <option>All Status</option>
                                        <option>Published</option>
                                        <option>Draft</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-semibold text-[#3723db] shadow-sm hover:bg-gray-50 transition-colors whitespace-normal">
                                    Bulk Actions
                                    <i class="ph-bold ph-dots-three ml-1"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Table Wrapper -->
                        <div class="flex-1 overflow-x-visible overflow-y-auto main-scrollbar w-full border-t border-gray-100">
                            <table class="w-full text-left border-collapse min-w-[900px]">
                                <thead>
                                    <tr class="text-[12px] text-gray-500 border-b border-gray-50 bg-white sticky top-0 z-10">
                                        <th class="px-3 py-3 font-semibold w-[40px]"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></th>
                                        <th class="px-2 py-4 font-semibold w-[220px]">Page Title</th>
                                        <th class="px-4 py-4 font-semibold w-[160px]">URL / Slug</th>
                                        <th class="px-4 py-4 font-semibold w-[140px]">Template</th>
                                        <th class="px-4 py-4 font-semibold w-[100px]">Status</th>
                                        <th class="px-4 py-4 font-semibold w-[140px]">Last Updated</th>
                                        <th class="px-4 py-4 font-semibold w-[140px]">Updated By</th>
                                        <th class="px-3 py-3 font-semibold w-[160px]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px]">
                                    
                                    <!-- Row 1 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="flex items-center gap-1.5 font-bold text-[#0B132C]">
                                                <i class="ph-fill ph-house text-[#3723db] text-[15px]"></i> Home
                                            </div>
                                            <div class="text-gray-500 text-[11px] mt-0.5 ml-[21px]">Homepage of the website</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/</td>
                                        <td class="px-4 py-4 text-gray-600">Home v1</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 31, 2024</div>
                                            <div class="text-gray-500 text-[11px]">10:30 AM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Anjali Singh</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 2 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">About Us</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">About company information</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/about-us</td>
                                        <td class="px-4 py-4 text-gray-600">Default</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 30, 2024</div>
                                            <div class="text-gray-500 text-[11px]">04:15 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Rohit Sharma</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Row 3 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Exhibitions</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">List of all exhibitions</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/exhibitions</td>
                                        <td class="px-4 py-4 text-gray-600">Exhibitions v1</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 30, 2024</div>
                                            <div class="text-gray-500 text-[11px]">03:20 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Priya Nair</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 4 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Exhibition Details</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Single exhibition details page</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/exhibitions/[slug]</td>
                                        <td class="px-4 py-4 text-gray-600">Exhibition Details</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 31, 2024</div>
                                            <div class="text-gray-500 text-[11px]">09:45 AM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Vikram Kumar</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Row 5 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Booths</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Browse all booths</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/booths</td>
                                        <td class="px-4 py-4 text-gray-600">Booths v1</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 29, 2024</div>
                                            <div class="text-gray-500 text-[11px]">11:00 AM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Anjali Singh</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 6 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Pricing</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Pricing and packages</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/pricing</td>
                                        <td class="px-4 py-4 text-gray-600">Pricing v1</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#FFF7ED] text-[#EA580C] rounded-[6px] text-[11px] font-bold">Draft</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 28, 2024</div>
                                            <div class="text-gray-500 text-[11px]">02:10 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Neha Verma</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 7 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">FAQ</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Frequently asked questions</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/faq</td>
                                        <td class="px-4 py-4 text-gray-600">Default</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 27, 2024</div>
                                            <div class="text-gray-500 text-[11px]">05:40 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Arun Patel</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 8 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Terms & Conditions</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Terms and conditions</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/terms-conditions</td>
                                        <td class="px-4 py-4 text-gray-600">Legal</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 26, 2024</div>
                                            <div class="text-gray-500 text-[11px]">01:15 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Sandeep Rao</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 9 -->
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Privacy Policy</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Privacy policy page</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/privacy-policy</td>
                                        <td class="px-4 py-4 text-gray-600">Legal</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 26, 2024</div>
                                            <div class="text-gray-500 text-[11px]">12:05 PM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Neha Verma</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Row 10 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-3 py-3"><input type="checkbox" class="rounded border-gray-300 text-[#3723db] focus:ring-[#3723db]"></td>
                                        <td class="px-2 py-4">
                                            <div class="font-bold text-[#0B132C]">Contact Us</div>
                                            <div class="text-gray-500 text-[11px] mt-0.5">Contact information page</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">/contact-us</td>
                                        <td class="px-4 py-4 text-gray-600">Contact v1</td>
                                        <td class="px-4 py-4"><span class="px-2.5 py-1 bg-[#ECFDF5] text-[#10B981] rounded-[6px] text-[11px] font-bold">Published</span></td>
                                        <td class="px-4 py-4">
                                            <div class="text-gray-600">May 31, 2024</div>
                                            <div class="text-gray-500 text-[11px]">10:00 AM</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">Anjali Singh</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <button class="action-btn action-btn-primary"><i class="ph ph-pencil-simple text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-eye text-[15px]"></i></button>
                                                <button class="action-btn action-btn-primary"><i class="ph ph-copy text-[15px]"></i></button>
                                                <button class="action-btn action-btn-danger"><i class="ph ph-trash text-[15px]"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="px-3 py-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-[13px] text-gray-500 font-medium gap-4 bg-white">
                            <div>Showing 1 to 10 of 45 pages</div>
                            <div class="flex gap-1.5 items-center">
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-left text-gray-400"></i></button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded bg-[#3723db] text-white border border-[#3723db] font-bold shadow-sm">1</button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">2</button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">3</button>
                                <span class="px-1 text-gray-400">...</span>
                                <button class="w-[36px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors text-gray-600">5</button>
                                <button class="w-[32px] h-[32px] flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 transition-colors"><i class="ph-bold ph-caret-right text-gray-400"></i></button>
                            </div>
                        </div>

                    </div>

                    <!-- Right Side: Sidebar Widgets -->
                    <div class="w-full xl:w-[320px] shrink-0 flex flex-col gap-6">
                        
                        <!-- Quick Actions -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                            <h3 class="text-[15px] font-bold text-[#0B132C] mb-4">Quick Actions</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="#" class="flex items-center justify-between p-3 rounded-[10px] hover:bg-[#F4F2FF] transition-colors group">
                                        <div class="flex items-center gap-3 text-[#3723db]">
                                            <div class="w-8 h-8 rounded-[8px] bg-[#F4F2FF] group-hover:bg-white flex items-center justify-center border border-[#E5E0FF] transition-colors">
                                                <i class="ph ph-file-text text-[18px]"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C]">Add New Page</span>
                                        </div>
                                        <i class="ph-bold ph-caret-right text-gray-400"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between p-3 rounded-[10px] hover:bg-[#F4F2FF] transition-colors group">
                                        <div class="flex items-center gap-3 text-[#3723db]">
                                            <div class="w-8 h-8 rounded-[8px] bg-[#F4F2FF] group-hover:bg-white flex items-center justify-center border border-[#E5E0FF] transition-colors">
                                                <i class="ph ph-list-bullets text-[18px]"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C]">Add Menu Item</span>
                                        </div>
                                        <i class="ph-bold ph-caret-right text-gray-400"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between p-3 rounded-[10px] hover:bg-[#F4F2FF] transition-colors group">
                                        <div class="flex items-center gap-3 text-[#3723db]">
                                            <div class="w-8 h-8 rounded-[8px] bg-[#F4F2FF] group-hover:bg-white flex items-center justify-center border border-[#E5E0FF] transition-colors">
                                                <i class="ph ph-image text-[18px]"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C]">Add Banner / Slider</span>
                                        </div>
                                        <i class="ph-bold ph-caret-right text-gray-400"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between p-3 rounded-[10px] hover:bg-[#F4F2FF] transition-colors group">
                                        <div class="flex items-center gap-3 text-[#3723db]">
                                            <div class="w-8 h-8 rounded-[8px] bg-[#F4F2FF] group-hover:bg-white flex items-center justify-center border border-[#E5E0FF] transition-colors">
                                                <i class="ph ph-cube text-[18px]"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C]">Add Content Block</span>
                                        </div>
                                        <i class="ph-bold ph-caret-right text-gray-400"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between p-3 rounded-[10px] hover:bg-[#F4F2FF] transition-colors group">
                                        <div class="flex items-center gap-3 text-[#3723db]">
                                            <div class="w-8 h-8 rounded-[8px] bg-[#F4F2FF] group-hover:bg-white flex items-center justify-center border border-[#E5E0FF] transition-colors">
                                                <i class="ph ph-folder text-[18px]"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C]">Media Library</span>
                                        </div>
                                        <i class="ph-bold ph-caret-right text-gray-400"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Content Overview -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                            <h3 class="text-[15px] font-bold text-[#0B132C] mb-6">Content Overview</h3>
                            
                            <div class="flex items-center justify-center gap-6">
                                <!-- Donut Chart SVG -->
                                <div class="relative w-[110px] h-[110px] shrink-0">
                                    <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                        <!-- Background Circle (Trash 0% not really visible, let's just make base circle) -->
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#E2E8F0" stroke-width="4"></circle>
                                        <!-- Draft (15.6%) -->
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#F59E0B" stroke-width="4" stroke-dasharray="100 0" stroke-dashoffset="0"></circle>
                                        <!-- Published (84.4%) -->
                                        <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#10B981" stroke-width="4" stroke-dasharray="84.4 15.6" stroke-dashoffset="0"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-[11px] text-gray-500 font-medium leading-none mb-1">Total</span>
                                        <span class="text-[20px] font-bold text-[#0B132C] leading-none">45</span>
                                    </div>
                                </div>
                                
                                <!-- Legend -->
                                <div class="space-y-3 text-[12px]">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-[#10B981]"></div>
                                            <span class="text-[#0B132C] font-semibold">Published</span>
                                        </div>
                                        <span class="text-gray-500 text-[11px]">38 (84.4%)</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-[#F59E0B]"></div>
                                            <span class="text-[#0B132C] font-semibold">Draft</span>
                                        </div>
                                        <span class="text-gray-500 text-[11px]">7 (15.6%)</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-[#94A3B8]"></div>
                                            <span class="text-[#0B132C] font-semibold">Trash</span>
                                        </div>
                                        <span class="text-gray-500 text-[11px]">0 (0%)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 flex-1 flex flex-col">
                            <h3 class="text-[15px] font-bold text-[#0B132C] mb-5">Recent Activity</h3>
                            
                            <div class="space-y-4 flex-1">
                                <!-- Activity 1 -->
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                                        <i class="ph ph-house text-[14px]"></i>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-semibold text-[#0B132C]">Homepage updated</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">May 31, 2024 10:30 AM</div>
                                    </div>
                                </div>
                                
                                <!-- Activity 2 -->
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                                        <i class="ph ph-image text-[14px]"></i>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-semibold text-[#0B132C]">New banner added</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">May 31, 2024 09:20 AM</div>
                                    </div>
                                </div>
                                
                                <!-- Activity 3 -->
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                                        <i class="ph ph-file-text text-[14px]"></i>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-semibold text-[#0B132C]">Pricing page created</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">May 28, 2024 02:10 PM</div>
                                    </div>
                                </div>
                                
                                <!-- Activity 4 -->
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-[#E5E0FF]">
                                        <i class="ph ph-file-text text-[14px]"></i>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-semibold text-[#0B132C]">FAQ page updated</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">May 27, 2024 05:40 PM</div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="w-full mt-4 py-2 bg-white border border-[#E5E0FF] text-[#3723db] rounded-[8px] text-[13px] font-bold hover:bg-[#F4F2FF] transition-colors">
                                View All Activity
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
