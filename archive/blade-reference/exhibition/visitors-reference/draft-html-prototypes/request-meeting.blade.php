<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo - Request a Meeting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE', 500: '#8B5CF6', 600: '#4A22E0', 700: '#3D1CBA', 800: '#2E159F' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAFAFA; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 relative bg-gradient-to-br from-gray-50 to-[#EDE9FE]">
            
            <a href="exhibitor-details.html" class="inline-flex items-center gap-2 text-[#4A22E0] hover:text-[#3D1CBA] font-bold text-[13px] mb-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Company
            </a>
            
            <div class="mb-8">
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Request a Meeting</h1>
                <p class="text-[13px] text-gray-500 font-medium">Fill in the details below to send a meeting request.</p>
            </div>

            <div class="flex gap-8 max-w-[1500px]">
                
                <!-- Left: Form Area -->
                <div class="flex-1 flex flex-col min-w-[700px] gap-8">
                    
                    <!-- Company Info Card -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-5 shadow-sm flex items-center gap-6">
                        <div class="w-[100px] h-[100px] rounded-[16px] bg-[#0F172A] relative flex flex-col items-center justify-center shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mb-1.5">
                                <div class="text-white text-[18px] font-bold">TN</div>
                            </div>
                            <div class="text-white font-bold text-[11px] tracking-wide">TechNext</div>
                            <div class="text-gray-400 text-[8px] tracking-widest uppercase mt-0.5">Solutions</div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-2">
                                <h2 class="text-[20px] font-bold text-[#1E1B4B] tracking-tight">TechNext Solutions Pvt. Ltd.</h2>
                                <span class="bg-[#0D9488]/10 text-[#0D9488] text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Featured Exhibitor</span>
                            </div>
                            
                            <div class="mb-4">
                                <span class="bg-primary-50 text-primary-600 text-[10px] font-bold px-2.5 py-1 rounded inline-block">AI & Automation</span>
                            </div>

                            <div class="flex items-center gap-8 text-[12px] font-medium text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-map-pin text-primary-500 text-[18px]"></i>
                                    <div>
                                        <div class="text-[#1E1B4B]">Hall 1 - AI & IA</div>
                                        <div class="text-gray-400 text-[11px]">Booth 101</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-users text-primary-500 text-[18px]"></i>
                                    <div>
                                        <div class="text-[#1E1B4B]">45+</div>
                                        <div class="text-gray-400 text-[11px]">Employees</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-globe text-primary-500 text-[18px]"></i>
                                    <a href="#" class="text-gray-500 hover:text-primary-600 transition-colors">www.technext.com</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Select Date & Time -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-8 shadow-sm">
                        <div class="mb-6">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-1">1. Select Date & Time</h3>
                            <p class="text-[12px] text-gray-500 font-medium">Choose your preferred date and time slot for the meeting.</p>
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <div class="relative w-[280px]">
                                <i class="ph ph-calendar-blank absolute left-4 top-1/2 -translate-y-1/2 text-primary-600 text-[18px]"></i>
                                <select class="w-full border border-gray-200 rounded-xl pl-12 pr-10 py-3 text-[13px] font-bold text-[#1E1B4B] appearance-none focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm cursor-pointer">
                                    <option>May 15 – May 17, 2024</option>
                                </select>
                                <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[16px] pointer-events-none"></i>
                            </div>
                            <div class="text-[11px] text-gray-500 font-medium flex items-center gap-1.5">
                                <i class="ph ph-globe-hemisphere-west text-[14px]"></i> All times are in IST (GMT+05:30)
                            </div>
                        </div>

                        <!-- Date Tabs -->
                        <div class="flex gap-4 border-b border-gray-100 mb-6">
                            <button class="flex-1 py-3 text-center border-b-2 border-[#4A22E0] bg-[#F5F3FF] rounded-t-xl text-[#4A22E0] font-bold text-[13px] transition-colors">May 15, Wed</button>
                            <button class="flex-1 py-3 text-center border-b-2 border-transparent text-gray-500 font-medium text-[13px] hover:text-[#1E1B4B] transition-colors">May 16, Thu</button>
                            <button class="flex-1 py-3 text-center border-b-2 border-transparent text-gray-500 font-medium text-[13px] hover:text-[#1E1B4B] transition-colors">May 17, Fri</button>
                        </div>

                        <!-- Time Slots Grid -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">10:00 AM – 10:30 AM</button>
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">10:30 AM – 11:00 AM</button>
                            <button class="border-2 border-[#4A22E0] rounded-xl py-3 text-center text-[13px] font-bold text-[#4A22E0] bg-[#F5F3FF] shadow-sm">11:00 AM – 11:30 AM</button>
                            
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">11:30 AM – 12:00 PM</button>
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">02:00 PM – 02:30 PM</button>
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">02:30 PM – 03:00 PM</button>
                            
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">03:00 PM – 03:30 PM</button>
                            <button class="border border-gray-200 rounded-xl py-3 text-center text-[13px] font-medium text-gray-600 hover:border-[#4A22E0] hover:text-[#4A22E0] transition-colors bg-white">04:00 PM – 04:30 PM</button>
                        </div>

                        <!-- Legend -->
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-sm bg-[#A7F3D0]"></div>
                                <span class="text-[12px] text-gray-500 font-medium">Available</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-sm bg-gray-200"></div>
                                <span class="text-[12px] text-gray-500 font-medium">Unavailable</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Add Meeting Details -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-8 shadow-sm">
                        <div class="mb-6">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-1">2. Add Meeting Details</h3>
                            <p class="text-[12px] text-gray-500 font-medium">Let the exhibitor know the purpose and context of your meeting.</p>
                        </div>

                        <div class="flex gap-6">
                            <div class="flex-1">
                                <label class="block text-[12px] font-bold text-[#1E1B4B] mb-2">Meeting Purpose <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[13px] font-medium text-gray-700 appearance-none focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm cursor-pointer">
                                        <option value="" disabled>Select purpose</option>
                                        <option value="Product Demonstration" selected>Product Demonstration</option>
                                        <option value="Partnership Inquiry">Partnership Inquiry</option>
                                        <option value="General Networking">General Networking</option>
                                        <option value="Pricing & Quotes">Pricing & Quotes</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[16px] pointer-events-none"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="block text-[12px] font-bold text-[#1E1B4B] mb-2">Additional Notes (Optional)</label>
                                <div class="relative">
                                    <textarea rows="3" placeholder="Add any specific topics or questions you would like to discuss..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[13px] font-medium text-gray-700 focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm resize-none"></textarea>
                                    <div class="absolute bottom-3 right-4 text-[10px] text-gray-400 font-medium">0/500</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Invite Team Members -->
                    <div class="border border-gray-100 rounded-[24px] bg-white p-8 shadow-sm">
                        <div class="mb-6">
                            <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-1">3. Invite Team Members (Optional)</h3>
                            <p class="text-[12px] text-gray-500 font-medium">Invite your team members to join this meeting.</p>
                        </div>

                        <div class="relative w-[360px] mb-4">
                            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]"></i>
                            <input type="text" placeholder="Search team members..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-[13px] font-medium focus:outline-none focus:border-[#4A22E0] bg-white shadow-sm">
                        </div>

                        <div class="flex flex-col gap-3">
                            <!-- Selected Member -->
                            <div class="w-[360px] border border-gray-200 rounded-xl p-3 flex items-center justify-between bg-white shadow-sm">
                                <div class="flex items-center gap-3">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Jane Smith" class="w-8 h-8 rounded-full object-cover">
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1E1B4B]">Jane Smith</div>
                                        <div class="text-[11px] text-gray-500 font-medium">Marketing Manager</div>
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-red-500 transition-colors w-6 h-6 flex items-center justify-center rounded-full hover:bg-red-50">
                                    <i class="ph ph-x text-[14px]"></i>
                                </button>
                            </div>
                            
                            <button class="w-[360px] flex items-center gap-2 text-[#4A22E0] font-bold text-[12px] hover:text-[#3D1CBA] transition-colors px-2 py-1">
                                <i class="ph-bold ph-plus"></i> Add More Members
                            </button>
                        </div>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="flex items-center justify-between pt-4 pb-12">
                        <button class="border border-gray-200 text-gray-700 hover:bg-gray-50 px-8 py-3 rounded-xl font-bold text-[14px] transition-colors shadow-sm">
                            Cancel
                        </button>
                        <button class="bg-[#4A22E0] hover:bg-[#3D1CBA] text-white px-8 py-3 rounded-xl font-bold text-[14px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i class="ph-bold ph-paper-plane-tilt text-[18px]"></i> Send Meeting Request
                        </button>
                    </div>

                </div>

                <!-- Right Sidebar: Summary Area -->
                <div class="w-[360px] shrink-0 flex flex-col gap-6 pb-12">
                    
                    <!-- Meeting Summary Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-6 border-b border-gray-100 pb-4">Meeting Summary</h3>
                        
                        <div class="flex flex-col gap-5 mb-6">
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-calendar-blank text-[18px]"></i></div>
                                <div class="text-[13px] font-bold text-[#1E1B4B]">May 15, 2024 (Wednesday)</div>
                            </div>
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-clock text-[18px]"></i></div>
                                <div>
                                    <div class="text-[13px] font-bold text-[#1E1B4B]">11:00 AM – 11:30 AM (30 mins)</div>
                                    <div class="text-[11px] text-gray-500 font-medium mt-0.5">IST (GMT+05:30)</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="text-primary-500 shrink-0 mt-0.5"><i class="ph-bold ph-map-pin text-[18px]"></i></div>
                                <div class="text-[13px] font-bold text-[#1E1B4B]">Booth 101, Hall 1 – AI & IA</div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-5 mb-5">
                            <h4 class="text-[12px] font-bold text-[#1E1B4B] mb-3">Meeting Purpose</h4>
                            <span class="bg-primary-50 text-primary-600 font-bold text-[11px] px-3 py-1.5 rounded-full inline-block">Product Demonstration</span>
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <h4 class="text-[12px] font-bold text-[#1E1B4B] mb-3">Team Members</h4>
                            <div class="flex items-center gap-3">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Jane Smith" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">Jane Smith</div>
                                    <div class="text-[10px] text-gray-500 font-medium">Marketing Manager</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About the Company Card -->
                    <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                        <h3 class="font-bold text-[#1E1B4B] text-[16px] mb-5">About the Company</h3>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-[#0F172A] rounded-xl flex items-center justify-center shadow-sm shrink-0">
                                <div class="text-blue-500 text-[18px] font-bold">TN</div>
                            </div>
                            <h4 class="font-bold text-[#1E1B4B] text-[14px] leading-tight">TechNext Solutions Pvt. Ltd.</h4>
                        </div>
                        
                        <p class="text-[12px] text-gray-600 leading-relaxed mb-6">Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.</p>
                        
                        <div class="bg-gray-50/50 rounded-[16px] p-4 flex flex-col gap-4 border border-gray-100 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="text-primary-500"><i class="ph-bold ph-users text-[18px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">45+</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Employees</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-primary-500"><i class="ph-bold ph-calendar-blank text-[18px]"></i></div>
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">2018</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Founded</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <img src="https://flagcdn.com/in.svg" alt="India" class="w-5 h-3.5 object-cover rounded-sm border border-gray-200">
                                <div>
                                    <div class="text-[12px] font-bold text-[#1E1B4B]">India</div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Headquarters</div>
                                </div>
                            </div>
                        </div>

                        <a href="exhibitor-details.html" class="w-full border border-gray-200 text-[#4A22E0] hover:bg-primary-50 py-2.5 rounded-xl font-bold text-[12px] transition-colors flex items-center justify-center gap-2 shadow-sm">
                            View Company Profile <i class="ph-bold ph-arrow-up-right"></i>
                        </a>
                    </div>

                    <!-- Guidelines Card -->
                    <div class="bg-[#F5F3FF] rounded-[24px] p-6 text-[#1E1B4B] shadow-sm border border-[#EDE9FE]">
                        <h3 class="font-bold text-[14px] flex items-center gap-2 mb-4">
                            <i class="ph-bold ph-info text-[#4A22E0] text-[18px]"></i> Meeting Request Guidelines
                        </h3>
                        <ul class="text-[12px] font-medium text-gray-600 flex flex-col gap-3">
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check text-[#4A22E0] mt-0.5"></i> Exhibitor will review your request and respond.
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check text-[#4A22E0] mt-0.5"></i> Please be professional and respectful.
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-bold ph-check text-[#4A22E0] mt-0.5"></i> You will be notified once the request is accepted.
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
            
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
