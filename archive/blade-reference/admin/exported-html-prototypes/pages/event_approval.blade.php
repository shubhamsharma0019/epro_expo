<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Event Setup Review Details</title>
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
        
        /* Custom styling for radio buttons */
        .custom-radio {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid #CBD5E1;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            cursor: pointer;
            outline: none;
        }
        .custom-radio:checked {
            border-color: currentColor;
        }
        .custom-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background-color: currentColor;
            border-radius: 50%;
        }
        
        /* Timeline styling */
        .timeline-line {
            position: absolute;
            left: 4px;
            top: 20px;
            bottom: -10px;
            width: 1px;
            background-color: #E2E8F0;
            z-index: 0;
        }
        .timeline-item:last-child .timeline-line {
            display: none;
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
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">6</span>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-chat-circle-dots text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-blue-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">3</span>
                </button>
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                    <div class="flex flex-col text-left hidden sm:flex">
                        <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                        <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                    </div>
                </button>
            </div>
        </header>

        <!-- Page Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-[24px] font-bold text-[#0B132C] mb-1.5">Event Setup Review Details</h1>
                        <div class="text-[13px] text-gray-500 font-medium flex items-center gap-2">
                            <span>Event Setup Review</span> <span class="text-gray-400">&rsaquo;</span> <span class="text-[#3723db] font-semibold">Review Details</span>
                        </div>
                        
                        <!-- Badges row -->
                        <div class="flex items-center gap-4 mt-4">
                            <span class="px-3 py-1 bg-[#FFF5E6] text-[#FF8A00] border border-[#fed7aa] rounded-md text-[12px] font-bold">Under Review</span>
                            <span class="text-[13px] text-gray-600 font-medium">Request ID: <span class="font-bold text-[#3723db]">EVT-REV-2024-048</span></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="event_setup_review.html" class="flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg text-[13px] font-bold shadow-sm hover:bg-gray-50 transition-colors">
                            <i class="ph-bold ph-arrow-left"></i> Back to List
                        </a>
                        <button class="flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-[13px] font-bold shadow-sm hover:bg-gray-50 transition-colors">
                            More Actions <i class="ph-bold ph-caret-down text-[12px]"></i>
                        </button>
                    </div>
                </div>

                <!-- Main Layout Grid -->
                <div class="flex flex-col gap-6 items-start">
                    
                    <!-- LEFT COLUMN (Main Content) -->
                    <div class="w-full xl:flex-1 flex flex-col gap-6">
                        
                        <!-- Event Information Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                            <h3 class="text-[14px] font-bold text-[#0B132C] mb-5">Event Information</h3>
                            
                            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
                                <!-- Left Details -->
                                <div class="flex gap-4 lg:w-[45%]">
                                    <div class="w-[56px] h-[56px] rounded-[10px] bg-[#0B132C] text-white flex flex-col items-center justify-center shrink-0 font-bold leading-none text-[10px] tracking-wide shadow-sm mt-1">
                                        <span>TECH</span>
                                        <span>SUMMIT</span>
                                    </div>
                                    <div class="flex flex-col gap-3">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="text-[16px] font-bold text-[#0B132C]">Global Tech Summit 2024</h4>
                                                <span class="px-2 py-0.5 bg-[#F4F2FF] text-[#3723db] rounded text-[10px] font-bold border border-[#e0d8ff]">Technology</span>
                                            </div>
                                            <p class="text-[12px] text-gray-500 font-medium">Organized by TechNova Solutions Pvt. Ltd.</p>
                                        </div>
                                        
                                        <div class="flex flex-col gap-1.5 text-[12px] text-gray-600">
                                            <div class="flex items-center gap-1"><span class="text-gray-400 w-4"><i class="ph-fill ph-envelope-simple"></i></span> info@technova.com</div>
                                            <div class="flex items-center gap-1"><span class="text-gray-400 w-4"><i class="ph-fill ph-phone"></i></span> +1 555-123-4567</div>
                                        </div>
                                        
                                        <a href="#" class="text-[#3723db] text-[12px] font-bold flex items-center gap-1 mt-1 hover:underline">
                                            View Organizer Profile <i class="ph-bold ph-arrow-up-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Right Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 flex-1">
                                    <div class="flex gap-2">
                                        <i class="ph ph-map-pin text-gray-400 text-[16px] mt-0.5"></i>
                                        <div>
                                            <div class="text-[12px] text-gray-500 mb-0.5">Venue</div>
                                            <div class="text-[13px] font-semibold text-[#0B132C]">Hall A, Convention Center</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <i class="ph ph-users text-gray-400 text-[16px] mt-0.5"></i>
                                        <div>
                                            <div class="text-[12px] text-gray-500 mb-0.5">Expected Visitors</div>
                                            <div class="text-[13px] font-semibold text-[#0B132C]">2,500+</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <i class="ph ph-calendar-blank text-gray-400 text-[16px] mt-0.5"></i>
                                        <div>
                                            <div class="text-[12px] text-gray-500 mb-0.5">Date & Time</div>
                                            <div class="text-[13px] font-semibold text-[#0B132C] leading-tight">May 15 - May 17, 2024<br>9:00 AM - 6:00 PM</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <i class="ph ph-bookmark-simple text-gray-400 text-[16px] mt-0.5"></i>
                                        <div>
                                            <div class="text-[12px] text-gray-500 mb-0.5">Event Type</div>
                                            <div class="text-[13px] font-semibold text-[#0B132C]">Conference</div>
                                        </div>
                                    </div>

                                    <div class="flex gap-2 sm:col-span-2">
                                        <i class="ph ph-calendar-check text-gray-400 text-[16px] mt-0.5"></i>
                                        <div>
                                            <div class="text-[12px] text-gray-500 mb-0.5">Submitted On</div>
                                            <div class="text-[13px] font-semibold text-[#0B132C]">May 14, 2024 10:30 AM</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs Navigation -->
                        <div class="flex overflow-x-auto border-b border-gray-200 hide-scrollbar mt-2">
                            <button class="px-5 py-3 text-[13px] font-bold text-[#3723db] border-b-2 border-[#3723db] whitespace-nowrap">Event Setup Details</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Agenda & Sessions</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Speakers</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Sponsors</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Promotion Plan</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Documents & Media</button>
                            <button class="px-5 py-3 text-[13px] font-medium text-gray-500 hover:text-gray-800 whitespace-nowrap transition-colors">Additional Information</button>
                        </div>

                        <!-- Tab Content: Event Setup Details -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                
                                <!-- Left Column (Summary) -->
                                <div>
                                    <h3 class="text-[14px] font-bold text-[#0B132C] mb-5">Event Setup Summary</h3>
                                    
                                    <div class="flex flex-col gap-4 text-[13px]">
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Setup Theme</div>
                                            <div class="text-[#0B132C] font-semibold">Modern & Professional</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Stage Setup</div>
                                            <div class="text-[#0B132C] font-semibold">Center Stage with LED Screen</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Seating Arrangement</div>
                                            <div class="text-[#0B132C] font-semibold">Theatre Style</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Booth Layout</div>
                                            <div class="text-[#0B132C] font-semibold">50 Booths (5x5 sqm each)</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Audio / Visual</div>
                                            <div class="text-[#0B132C] font-semibold">Professional AV with Mics, Projectors</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Internet</div>
                                            <div class="text-[#0B132C] font-semibold">High-speed Wi-Fi</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Key Features</div>
                                            <div class="text-[#0B132C] font-semibold">
                                                <ul class="list-disc pl-4 space-y-1">
                                                    <li>3-Day Conference</li>
                                                    <li>20+ Expert Speakers</li>
                                                    <li>Panel Discussions</li>
                                                    <li>Networking Sessions</li>
                                                    <li>Product Showcase</li>
                                                    <li>Live Demos</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="flex mt-2">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Power Requirement</div>
                                            <div class="text-[#0B132C] font-semibold">25 KW</div>
                                        </div>
                                        <div class="flex">
                                            <div class="w-[140px] text-gray-500 font-medium shrink-0">Special Requirements</div>
                                            <div class="text-[#0B132C] font-semibold">Hanging banner (2m x 6m),<br>Extra power outlets near stage</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column (Description & Compliance) -->
                                <div class="flex flex-col gap-8">
                                    <div>
                                        <h3 class="text-[14px] font-bold text-[#0B132C] mb-3">Setup Description</h3>
                                        <p class="text-[13px] text-gray-600 leading-relaxed">
                                            We are setting up a world-class technology conference with keynote sessions, panel discussions, and product showcases. The event will bring together industry leaders, innovators, and technology enthusiasts.
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-[14px] font-bold text-[#0B132C] mb-4">Compliance Checklist</h3>
                                        
                                        <div class="flex flex-col gap-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Fire Safety Compliance</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Electrical Safety</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Emergency Exits</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Accessibility Compliance</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Venue Rules & Regulations</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Insurance</span>
                                                <span class="px-2 py-0.5 bg-[#E6FBF0] text-[#10B981] rounded text-[10px] font-bold">Compliant</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-[13px] text-gray-700 font-medium">Other Requirements</span>
                                                <span class="px-2 py-0.5 bg-[#FFF5E6] text-[#FF8A00] rounded text-[10px] font-bold">Pending</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                        <h4 class="text-[12px] font-bold text-[#0B132C] mb-1.5">Notes from Organizer</h4>
                                        <p class="text-[12px] text-gray-600">We have attached the layout plan, technical requirements, and promotional materials for your review.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom row: Layout Preview & Attachments -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Layout Preview -->
                            <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                <h3 class="text-[14px] font-bold text-[#0B132C] mb-4">Event Layout Preview</h3>
                                <div class="rounded-xl overflow-hidden border border-gray-200">
                                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Layout Preview" class="w-full h-[180px] object-cover">
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                <h3 class="text-[14px] font-bold text-[#0B132C] mb-4">Attachments & Documents</h3>
                                
                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    <!-- Doc 1 -->
                                    <div class="border border-gray-200 rounded-lg overflow-hidden group cursor-pointer hover:border-[#3723db] transition-colors relative">
                                        <div class="h-[80px] bg-gray-100 relative">
                                            <img src="https://images.unsplash.com/photo-1560439514-4e9645039924?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Layout" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                                <div class="w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-[#3723db]">
                                                    <i class="ph-bold ph-download-simple"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 text-center bg-white border-t border-gray-200">
                                            <span class="text-[10px] font-bold text-[#0B132C] truncate block">Event Layout Plan.pdf</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Doc 2 -->
                                    <div class="border border-gray-200 rounded-lg overflow-hidden group cursor-pointer hover:border-[#3723db] transition-colors relative">
                                        <div class="h-[80px] bg-gray-100 relative">
                                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Tech Reqs" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                                <div class="w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-[#3723db]">
                                                    <i class="ph-bold ph-download-simple"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 text-center bg-white border-t border-gray-200">
                                            <span class="text-[10px] font-bold text-[#0B132C] truncate block">Technical Requirements.pdf</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Doc 3 -->
                                    <div class="border border-gray-200 rounded-lg overflow-hidden group cursor-pointer hover:border-[#3723db] transition-colors relative">
                                        <div class="h-[80px] bg-gray-100 relative">
                                            <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Promo" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                                <div class="w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-[#3723db]">
                                                    <i class="ph-bold ph-download-simple"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 text-center bg-white border-t border-gray-200">
                                            <span class="text-[10px] font-bold text-[#0B132C] truncate block">Promotion Banner.jpg</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <a href="#" class="text-[12px] font-bold text-[#3723db] hover:underline">View All Documents (5)</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- BOTTOM ROW (Review Sidebar moved down) -->
                    <div class="w-full shrink-0 grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Review Actions Card -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 w-full">
                            <h3 class="text-[14px] font-bold text-[#0B132C] mb-5">Review Actions</h3>
                            
                            <form>
                                <div class="mb-5">
                                    <label class="block text-[12px] font-bold text-[#0B132C] mb-3">Review Status <span class="text-red-500">*</span></label>
                                    
                                    <div class="flex flex-col gap-3">
                                        <!-- Approve -->
                                        <label class="flex items-start gap-3 p-3 border border-[#10B981] bg-[#E6FBF0]/50 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" name="review_status" class="custom-radio text-[#10B981] mt-0.5" checked>
                                            <div class="flex flex-col">
                                                <span class="text-[13px] font-bold text-[#10B981] flex items-center gap-1.5"><i class="ph-fill ph-check-circle"></i> Approve</span>
                                                <span class="text-[11px] text-gray-500 mt-0.5">Event setup is approved and meets all requirements.</span>
                                            </div>
                                        </label>
                                        
                                        <!-- Reject -->
                                        <label class="flex items-start gap-3 p-3 border border-gray-200 hover:border-gray-300 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" name="review_status" class="custom-radio text-[#FF3B6A] mt-0.5">
                                            <div class="flex flex-col">
                                                <span class="text-[13px] font-bold text-[#FF3B6A] flex items-center gap-1.5"><i class="ph-fill ph-x-circle"></i> Reject</span>
                                                <span class="text-[11px] text-gray-500 mt-0.5">Event setup does not meet requirements.</span>
                                            </div>
                                        </label>
                                        
                                        <!-- Request Changes -->
                                        <label class="flex items-start gap-3 p-3 border border-gray-200 hover:border-gray-300 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" name="review_status" class="custom-radio text-[#3723db] mt-0.5">
                                            <div class="flex flex-col">
                                                <span class="text-[13px] font-bold text-[#3723db] flex items-center gap-1.5"><i class="ph-fill ph-info"></i> Request Changes</span>
                                                <span class="text-[11px] text-gray-500 mt-0.5">Require changes before approval.</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-5">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="text-[12px] font-bold text-[#0B132C]">Review Comments <span class="text-red-500">*</span></label>
                                        <span class="text-[10px] text-gray-400 font-medium">0 / 500</span>
                                    </div>
                                    <textarea placeholder="Enter your comments..." class="w-full bg-white border border-gray-200 rounded-lg p-3 text-[13px] text-gray-700 focus:outline-none focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db] transition-all resize-none h-[100px] shadow-sm"></textarea>
                                </div>
                                
                                <div class="mb-6">
                                    <label class="block text-[12px] font-bold text-[#0B132C] mb-2">Review Attachments (Optional)</label>
                                    <div class="border-2 border-dashed border-gray-200 rounded-lg bg-gray-50 p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-100 transition-colors">
                                        <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-[#3723db] mb-2">
                                            <i class="ph ph-cloud-arrow-up text-[20px]"></i>
                                        </div>
                                        <span class="text-[12px] text-gray-600 font-medium mb-1">Drag & drop files here or click to upload</span>
                                        <span class="text-[10px] text-gray-400">PDF, DOC, JPG, PNG (Max. 10MB each)</span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-3">
                                        <button type="button" class="flex-1 bg-white border border-gray-200 text-gray-700 py-2.5 rounded-lg text-[13px] font-bold shadow-sm hover:bg-gray-50 transition-colors">Cancel</button>
                                        <button type="button" class="flex-1 bg-white border border-[#3723db] text-[#3723db] py-2.5 rounded-lg text-[13px] font-bold shadow-sm hover:bg-[#F4F2FF] transition-colors">Save as Draft</button>
                                    </div>
                                    <button type="button" class="w-full bg-[#3723db] hover:bg-[#2515a6] text-white py-2.5 rounded-lg text-[13px] font-bold shadow-md transition-all">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Organizer Contact -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 w-full flex flex-col">
                            <h3 class="text-[14px] font-bold text-[#0B132C] mb-4">Organizer Contact</h3>
                            
                            <div class="flex items-center gap-3 mb-4">
                                <img src="https://i.pravatar.cc/150?img=11" alt="John Smith" class="w-12 h-12 rounded-full object-cover shadow-sm">
                                <div>
                                    <div class="text-[14px] font-bold text-[#0B132C]">John Smith</div>
                                    <div class="text-[12px] text-gray-500">Event Manager</div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-2.5 text-[12px] text-gray-600 mb-4 flex-1">
                                <div class="flex items-center gap-2"><i class="ph-fill ph-envelope-simple text-gray-400 text-[14px]"></i> john@technova.com</div>
                                <div class="flex items-center gap-2"><i class="ph-fill ph-phone text-gray-400 text-[14px]"></i> +1 555-123-4567</div>
                            </div>
                            
                            <button class="w-full flex items-center justify-center gap-2 bg-white border border-gray-200 text-gray-700 py-2 rounded-lg text-[13px] font-bold shadow-sm hover:bg-gray-50 transition-colors mt-auto">
                                <i class="ph ph-chat-circle-dots text-[16px]"></i> Send Message
                            </button>
                        </div>
                        
                        <!-- Review History -->
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 w-full">
                            <h3 class="text-[14px] font-bold text-[#0B132C] mb-5">Review History</h3>
                            
                            <div class="relative pl-6 space-y-6">
                                <!-- Timeline Item 1 -->
                                <div class="timeline-item relative">
                                    <div class="timeline-line"></div>
                                    <div class="absolute -left-[29px] top-1 w-2.5 h-2.5 rounded-full bg-[#FF8A00] ring-4 ring-[#FFF5E6] z-10"></div>
                                    
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[13px] font-bold text-[#FF8A00]">Under Review</span>
                                        <span class="text-[10px] text-gray-400 font-medium">May 14, 2024 10:30 AM</span>
                                        <span class="text-[12px] text-gray-600 mt-1">Submitted by John Smith</span>
                                    </div>
                                </div>
                                
                                <!-- Timeline Item 2 -->
                                <div class="timeline-item relative">
                                    <div class="timeline-line"></div>
                                    <div class="absolute -left-[29px] top-1 w-2.5 h-2.5 rounded-full bg-gray-300 ring-4 ring-gray-100 z-10"></div>
                                    
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[13px] font-bold text-gray-600">Draft</span>
                                        <span class="text-[10px] text-gray-400 font-medium">May 13, 2024 04:20 PM</span>
                                        <span class="text-[12px] text-gray-600 mt-1">Saved as draft by John Smith</span>
                                    </div>
                                </div>
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


