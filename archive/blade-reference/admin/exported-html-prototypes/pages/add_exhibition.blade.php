<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Add Exhibition</title>
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
                        <h1 class="text-[26px] font-bold text-[#0B132C] mb-1.5">Add Exhibition</h1>
                        <p class="text-gray-500 text-[14px]">Create a new exhibition and publish it on the platform.</p>
                    </div>
                    <div class="flex items-center gap-2 text-[13px]">
                        <a href="exhibitions.html" class="text-gray-500 hover:text-[#3723db] transition-colors">Exhibitions</a>
                        <i class="ph ph-caret-right text-gray-400 text-[10px]"></i>
                        <span class="text-[#0B132C] font-medium">Add Exhibition</span>
                    </div>
                </div>

                <!-- Form Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    
                    <!-- Left Column -->
                    <div class="flex flex-col gap-6">
                        
                        <!-- Exhibition Information -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-calendar-blank text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Exhibition Information</h2>
                                    <p class="text-gray-500 text-[13px]">Add basic details about the exhibition.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exhibition Name <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter exhibition name" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select category</option>
                                                <option>Technology</option>
                                                <option>Environment</option>
                                                <option>Healthcare</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Tagline / Subtitle</label>
                                        <input type="text" placeholder="Enter tagline or subtitle" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Short Description <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <textarea placeholder="Enter short description" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 h-[100px] resize-none"></textarea>
                                            <span class="absolute bottom-2.5 right-3 text-[11px] text-gray-400">0 / 250</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 3 -->
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <textarea placeholder="Enter detailed description about the exhibition" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 h-[140px] resize-none"></textarea>
                                        <span class="absolute bottom-2.5 right-3 text-[11px] text-gray-400">0 / 2000</span>
                                    </div>
                                </div>
                                
                                <!-- Row 4 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Website</label>
                                        <div class="relative">
                                            <i class="ph ph-globe absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                            <input type="text" placeholder="https://www.exhibition.com" class="w-full bg-white border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Email</label>
                                        <div class="relative">
                                            <i class="ph ph-envelope-simple absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                            <input type="email" placeholder="info@exhibition.com" class="w-full bg-white border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Phone Number</label>
                                        <div class="flex gap-2">
                                            <div class="relative w-[75px] shrink-0">
                                                <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg pl-2 pr-6 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all cursor-pointer shadow-sm">
                                                    <option>+91</option>
                                                    <option>+1</option>
                                                    <option>+44</option>
                                                </select>
                                                <i class="ph ph-caret-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[12px]"></i>
                                            </div>
                                            <input type="text" placeholder="Enter phone number" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media & Documents -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-image text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Media & Documents</h2>
                                    <p class="text-gray-500 text-[13px]">Upload images, banner and other documents.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Banner Image -->
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Banner Image <span class="text-red-500">*</span></label>
                                        <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-8 px-4 text-center cursor-pointer transition-colors group">
                                            <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] mb-3 group-hover:scale-110 transition-transform">
                                                <i class="ph ph-upload-simple text-lg"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C] mb-1">Upload Banner</span>
                                            <span class="text-[11px] text-gray-400">Recommended size 1920x600px</span>
                                            <span class="text-[11px] text-gray-400">PNG, JPG or WebP. Max size 2MB</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Exhibition Image / Logo -->
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exhibition Image / Logo</label>
                                        <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-8 px-4 text-center cursor-pointer transition-colors group">
                                            <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] mb-3 group-hover:scale-110 transition-transform">
                                                <i class="ph ph-upload-simple text-lg"></i>
                                            </div>
                                            <span class="text-[13px] font-semibold text-[#0B132C] mb-1">Upload Image</span>
                                            <span class="text-[11px] text-gray-400">Recommended size 512x512px</span>
                                            <span class="text-[11px] text-gray-400">PNG, JPG or WebP. Max size 1MB</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Brochure (PDF) -->
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Brochure (PDF)</label>
                                    <div class="border border-dashed border-gray-300 rounded-[12px] bg-gray-50/50 hover:bg-gray-50 flex flex-col items-center justify-center py-8 px-4 text-center cursor-pointer transition-colors group">
                                        <div class="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-[#3723db] mb-3 group-hover:scale-110 transition-transform">
                                            <i class="ph ph-cloud-arrow-up text-lg"></i>
                                        </div>
                                        <span class="text-[13px] font-semibold text-[#0B132C] mb-1">Upload Brochure</span>
                                        <span class="text-[11px] text-gray-400">PDF file only. Max size 5MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Right Column -->
                    <div class="flex flex-col gap-6">
                        
                        <!-- Date & Time -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-clock text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Date & Time</h2>
                                    <p class="text-gray-500 text-[13px]">Set the exhibition schedule.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select start date" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 pr-10">
                                            <i class="ph ph-calendar-blank absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Start Time <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select start time" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 pr-10">
                                            <i class="ph ph-clock absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">End Date <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select end date" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 pr-10">
                                            <i class="ph ph-calendar-blank absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">End Time <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" placeholder="Select end time" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400 pr-10">
                                            <i class="ph ph-clock absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Venue Information -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-map-pin text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Venue Information</h2>
                                    <p class="text-gray-500 text-[13px]">Add venue details of the exhibition.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Venue Name <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter venue name" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Venue Address <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter venue full address" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter city" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">State / Province <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter state / province" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Country <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select country</option>
                                                <option>United States</option>
                                                <option>United Kingdom</option>
                                                <option>India</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 3 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Postal Code</label>
                                        <input type="text" placeholder="Enter postal code" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Google Map Link</label>
                                        <div class="relative">
                                            <i class="ph ph-link absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                            <input type="text" placeholder="https://maps.google.com/..." class="w-full bg-white border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 lg:p-8">
                            <div class="flex items-start gap-4 mb-8">
                                <div class="w-[42px] h-[42px] rounded-[10px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0">
                                    <i class="ph ph-info text-[22px]"></i>
                                </div>
                                <div>
                                    <h2 class="text-[#0B132C] text-[16px] font-bold mb-0.5">Additional Information</h2>
                                    <p class="text-gray-500 text-[13px]">Add other relevant details.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Row 1 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exhibition Type</label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer">
                                                <option value="" disabled selected>Select type</option>
                                                <option>B2B</option>
                                                <option>B2C</option>
                                                <option>Hybrid</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Organizer</label>
                                        <input type="text" placeholder="Enter organizer name" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Expected Visitors</label>
                                        <input type="text" placeholder="Enter expected visitors" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Exhibitor Count (Expected)</label>
                                        <input type="text" placeholder="Enter expected exhibitors" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Ticket / Registration Link</label>
                                        <div class="relative">
                                            <i class="ph ph-link absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[16px]"></i>
                                            <input type="text" placeholder="https://registration.com" class="w-full bg-white border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-[14px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm placeholder-gray-400">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 3: Status & Publish -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-end">
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select class="w-full appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-900 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all shadow-sm cursor-pointer font-medium">
                                                <option>Draft</option>
                                                <option>Published</option>
                                                <option>Upcoming</option>
                                            </select>
                                            <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-medium text-gray-700 mb-1.5">Publish</label>
                                        <div class="flex items-center gap-3 h-[42px]">
                                            <!-- Toggle Switch UI -->
                                            <div class="w-[36px] h-[20px] bg-[#3723db] rounded-full relative cursor-pointer shadow-inner">
                                                <div class="w-3.5 h-3.5 bg-white rounded-full absolute top-[3px] right-[3px] shadow-sm"></div>
                                            </div>
                                            <span class="text-[13px] text-gray-600 font-medium">Publish this exhibition immediately</span>
                                        </div>
                                    </div>
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
                        Add Exhibition
                    </button>
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


