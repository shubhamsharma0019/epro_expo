<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Reports / Analytics</title>
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
        
        <!-- Top Header Area -->
        <header class="bg-white border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 lg:px-8 py-5 shrink-0 relative z-10 gap-4 sm:gap-0">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[24px] font-bold text-[#0B132C] mb-1">Reports / Analytics</h1>
                <p class="text-gray-500 text-[14px]">Track platform performance and key insights.</p>
            </div>
            
            <!-- Right Side: Date Picker, Export, Profile -->
            <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                <!-- Date Picker -->
                <div class="flex items-center bg-white border border-gray-200 rounded-[8px] px-3 py-2 shadow-sm">
                    <i class="ph ph-calendar-blank text-gray-400 text-lg mr-2"></i>
                    <span class="text-[13px] text-gray-700 font-medium mr-3">May 01, 2024 - May 31, 2024</span>
                    <i class="ph ph-calendar-blank text-gray-400 text-lg"></i>
                </div>
                
                <!-- Export -->
                <button class="flex items-center gap-2 bg-white border border-gray-200 px-4 py-2 rounded-[8px] text-[13px] font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <i class="ph ph-export text-lg"></i>
                    Export
                </button>
                
                <div class="hidden sm:block h-8 w-px bg-gray-200 mx-1"></div>
                
                <!-- Notifications & Profile -->
                <div class="flex items-center gap-5">
                    <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="ph ph-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">3</span>
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

        <!-- Tabs Section -->
        <div class="bg-white px-6 lg:px-8 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar">
                <button class="py-4 px-1 tab-active whitespace-nowrap text-[14px]">Overview</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Sales</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Enquiries</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Exhibitions</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Booths</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Tickets</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Meetings</button>
                <button class="py-4 px-1 tab-inactive whitespace-nowrap text-[14px]">Users</button>
            </div>
        </div>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-white">
            <div class="max-w-[1600px] mx-auto">
                
                <!-- Top 5 Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-6">
                    
                    <!-- Total Revenue -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                                <i class="ph ph-currency-inr text-[20px]"></i>
                            </div>
                            <div>
                                <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Revenue</p>
                                <h3 class="text-[20px] font-bold text-[#0B132C]">₹ 12,45,000</h3>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-gray-400 font-medium flex items-center">
                            <span class="text-[#10B981] flex items-center mr-1.5 font-semibold"><i class="ph-bold ph-arrow-up mr-0.5"></i>15.4%</span> vs Apr 01 - Apr 30, 2024
                        </div>
                    </div>

                    <!-- Total Invoices -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                                <i class="ph ph-file-text text-[20px]"></i>
                            </div>
                            <div>
                                <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Invoices</p>
                                <h3 class="text-[20px] font-bold text-[#0B132C]">124</h3>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-gray-400 font-medium flex items-center">
                            <span class="text-[#10B981] flex items-center mr-1.5 font-semibold"><i class="ph-bold ph-arrow-up mr-0.5"></i>12.6%</span> vs Apr 01 - Apr 30, 2024
                        </div>
                    </div>

                    <!-- Total Enquiries -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                                <i class="ph ph-envelope-simple text-[20px]"></i>
                            </div>
                            <div>
                                <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Enquiries</p>
                                <h3 class="text-[20px] font-bold text-[#0B132C]">1,245</h3>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-gray-400 font-medium flex items-center">
                            <span class="text-[#10B981] flex items-center mr-1.5 font-semibold"><i class="ph-bold ph-arrow-up mr-0.5"></i>18.7%</span> vs Apr 01 - Apr 30, 2024
                        </div>
                    </div>

                    <!-- Total Bookings -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                                <i class="ph ph-calendar-check text-[20px]"></i>
                            </div>
                            <div>
                                <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Bookings</p>
                                <h3 class="text-[20px] font-bold text-[#0B132C]">256</h3>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-gray-400 font-medium flex items-center">
                            <span class="text-[#10B981] flex items-center mr-1.5 font-semibold"><i class="ph-bold ph-arrow-up mr-0.5"></i>10.2%</span> vs Apr 01 - Apr 30, 2024
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white p-5 rounded-[12px] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4 mb-2">
                            <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                                <i class="ph ph-users text-[20px]"></i>
                            </div>
                            <div>
                                <p class="text-[12px] text-gray-500 font-medium mb-0.5">Total Users</p>
                                <h3 class="text-[20px] font-bold text-[#0B132C]">3,250</h3>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-gray-400 font-medium flex items-center">
                            <span class="text-[#10B981] flex items-center mr-1.5 font-semibold"><i class="ph-bold ph-arrow-up mr-0.5"></i>8.3%</span> vs Apr 01 - Apr 30, 2024
                        </div>
                    </div>
                </div>

                <!-- 3 Column Charts Section -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
                    
                    <!-- Revenue Overview (Line Chart) -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 class="text-[15px] font-bold text-[#0B132C] mb-1">Revenue Overview</h2>
                                <div class="flex items-center gap-2 text-[11px] text-gray-500 font-medium">
                                    <div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-[#3723db]"></div> Revenue (₹)</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[14px] font-bold text-[#0B132C]">₹ 12,45,000</span>
                                    <span class="text-[11px] text-[#10B981] font-bold flex items-center"><i class="ph-bold ph-arrow-up mr-0.5"></i>15.4%</span>
                                </div>
                                <button class="flex items-center gap-1.5 text-[11px] border border-gray-200 rounded px-2 py-1 text-gray-500 font-medium hover:bg-gray-50 transition-colors">
                                    Monthly <i class="ph-bold ph-caret-down text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="w-full h-[200px] relative">
                            <!-- SVG Chart Emulation -->
                            <svg viewBox="0 0 400 200" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                                <!-- Y Axis -->
                                <text x="0" y="20" class="text-[9px] font-semibold fill-gray-400">1.5M</text>
                                <text x="0" y="60" class="text-[9px] font-semibold fill-gray-400">1.25M</text>
                                <text x="0" y="100" class="text-[9px] font-semibold fill-gray-400">1.0M</text>
                                <text x="0" y="140" class="text-[9px] font-semibold fill-gray-400">750K</text>
                                <text x="0" y="180" class="text-[9px] font-semibold fill-gray-400">500K</text>
                                
                                <!-- Grid lines -->
                                <line x1="30" y1="16" x2="400" y2="16" stroke="#f8fafc" stroke-width="1" />
                                <line x1="30" y1="56" x2="400" y2="56" stroke="#f8fafc" stroke-width="1" />
                                <line x1="30" y1="96" x2="400" y2="96" stroke="#f8fafc" stroke-width="1" />
                                <line x1="30" y1="136" x2="400" y2="136" stroke="#f8fafc" stroke-width="1" />
                                <line x1="30" y1="176" x2="400" y2="176" stroke="#f8fafc" stroke-width="1" />
                                
                                <defs>
                                    <filter id="shadow">
                                        <feDropShadow dx="0" dy="4" stdDeviation="4" flood-opacity="0.1" />
                                    </filter>
                                </defs>
                                
                                <!-- Line Path -->
                                <!-- Data points: Dec(40,160), Jan(100,100), Feb(160,130), Mar(220,70), Apr(280,40), May(340,30) -->
                                <path d="M40 160 L100 120 L160 140 L220 80 L280 60 L340 30" fill="none" stroke="#3723db" stroke-width="2" />
                                
                                <!-- Dots -->
                                <circle cx="40" cy="160" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="100" cy="120" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="160" cy="140" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="220" cy="80" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="280" cy="60" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="340" cy="30" r="3.5" fill="#3723db" stroke="white" stroke-width="2" /> <!-- Solid active dot -->
                                
                                <!-- X Axis Labels -->
                                <text x="40" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Dec '23</text>
                                <text x="100" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Jan '24</text>
                                <text x="160" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Feb '24</text>
                                <text x="220" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Mar '24</text>
                                <text x="280" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Apr '24</text>
                                <text x="340" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">May '24</text>
                                
                                <!-- Tooltip -->
                                <rect x="305" y="-10" width="70" height="35" rx="6" fill="white" filter="url(#shadow)" stroke="#f1f5f9" stroke-width="1" />
                                <text x="340" y="3" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">May '24</text>
                                <text x="340" y="16" class="text-[10px] font-bold fill-[#0B132C]" text-anchor="middle">₹ 12,45,000</text>
                            </svg>
                        </div>
                    </div>

                    <!-- Enquiries Trend (Line Chart) -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 class="text-[15px] font-bold text-[#0B132C] mb-1">Enquiries Trend</h2>
                                <div class="flex items-center gap-2 text-[11px] text-gray-500 font-medium">
                                    <div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-[#3723db]"></div> Total Enquiries</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[14px] font-bold text-[#0B132C]">1,245</span>
                                </div>
                                <button class="flex items-center gap-1.5 text-[11px] border border-gray-200 rounded px-2 py-1 text-gray-500 font-medium hover:bg-gray-50 transition-colors">
                                    Monthly <i class="ph-bold ph-caret-down text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="w-full h-[200px] relative">
                            <!-- SVG Chart Emulation -->
                            <svg viewBox="0 0 400 200" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                                <!-- Y Axis -->
                                <text x="0" y="20" class="text-[9px] font-semibold fill-gray-400">1.5K</text>
                                <text x="0" y="60" class="text-[9px] font-semibold fill-gray-400">1.2K</text>
                                <text x="0" y="100" class="text-[9px] font-semibold fill-gray-400">900</text>
                                <text x="0" y="140" class="text-[9px] font-semibold fill-gray-400">600</text>
                                <text x="0" y="180" class="text-[9px] font-semibold fill-gray-400">300</text>
                                
                                <!-- Grid lines -->
                                <line x1="25" y1="16" x2="400" y2="16" stroke="#f8fafc" stroke-width="1" />
                                <line x1="25" y1="56" x2="400" y2="56" stroke="#f8fafc" stroke-width="1" />
                                <line x1="25" y1="96" x2="400" y2="96" stroke="#f8fafc" stroke-width="1" />
                                <line x1="25" y1="136" x2="400" y2="136" stroke="#f8fafc" stroke-width="1" />
                                <line x1="25" y1="176" x2="400" y2="176" stroke="#f8fafc" stroke-width="1" />
                                
                                <!-- Line Path -->
                                <!-- Data points: Dec(40,150), Jan(100,100), Feb(160,110), Mar(220,70), Apr(280,100), May(340,30) -->
                                <path d="M40 150 L100 110 L160 110 L220 70 L280 100 L340 30" fill="none" stroke="#3723db" stroke-width="2" />
                                
                                <!-- Dots -->
                                <circle cx="40" cy="150" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="100" cy="110" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="160" cy="110" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="220" cy="70" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="280" cy="100" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                <circle cx="340" cy="30" r="3.5" fill="white" stroke="#3723db" stroke-width="2" />
                                
                                <!-- X Axis Labels -->
                                <text x="40" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Dec '23</text>
                                <text x="100" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Jan '24</text>
                                <text x="160" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Feb '24</text>
                                <text x="220" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Mar '24</text>
                                <text x="280" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">Apr '24</text>
                                <text x="340" y="200" class="text-[9px] font-semibold fill-gray-400" text-anchor="middle">May '24</text>
                            </svg>
                        </div>
                    </div>

                    <!-- Enquiries by Source (Donut Chart) -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6 flex flex-col">
                        <h2 class="text-[15px] font-bold text-[#0B132C] mb-6">Enquiries by Source</h2>
                        
                        <div class="flex-1 flex flex-col sm:flex-row items-center justify-center gap-6">
                            <!-- SVG Donut Chart -->
                            <div class="relative w-[140px] h-[140px]">
                                <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                                    <!-- Website (45%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#3B82F6" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="138.16" /> <!-- 45% of 251.2 = 113.04. Offset = 251.2 - 113.04 = 138.16 -->
                                    <!-- Email (25%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#10B981" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="188.4" transform="rotate(162 50 50)" /> <!-- 25% of 251.2 = 62.8. Offset = 251.2 - 62.8 = 188.4. Rotate 45% = 162deg -->
                                    <!-- Phone (15%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#F59E0B" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="213.52" transform="rotate(252 50 50)" /> <!-- 15% of 251.2 = 37.68. Offset = 213.52. Rotate (45+25) 70% = 252deg -->
                                    <!-- Social Media (10%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#EF4444" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="226.08" transform="rotate(306 50 50)" /> <!-- 10% = 25.12. Offset=226.08. Rotate 85% = 306deg -->
                                    <!-- Referral (5%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#8B5CF6" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="238.64" transform="rotate(342 50 50)" /> <!-- 5% = 12.56. Offset=238.64. Rotate 95% = 342deg -->
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-[18px] font-bold text-[#0B132C]">1,245</span>
                                    <span class="text-[10px] text-gray-500 font-medium">Total</span>
                                </div>
                            </div>
                            
                            <!-- Legend -->
                            <div class="flex flex-col gap-2.5 w-full sm:w-auto mt-4 sm:mt-0">
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-4">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-[#3B82F6]"></div> Website</div>
                                    <span class="font-bold text-[#0B132C]">45%</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-4">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></div> Email</div>
                                    <span class="font-bold text-[#0B132C]">25%</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-4">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></div> Phone</div>
                                    <span class="font-bold text-[#0B132C]">15%</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-4">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-[#EF4444]"></div> Social Media</div>
                                    <span class="font-bold text-[#0B132C]">10%</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-4">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6]"></div> Referral</div>
                                    <span class="font-bold text-[#0B132C]">5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle 6 Stat Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
                    
                    <!-- Exhibitions -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#F4F2FF] text-[#3723db] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-flag-banner text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Exhibitions</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">32</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>6.7%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>

                    <!-- Companies -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#E0F2FE] text-[#0284C7] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-buildings text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Companies</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">120</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>9.1%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>

                    <!-- Booths -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-package text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Booths</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">432</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>11.3%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>

                    <!-- Tickets Sold -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-ticket text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Tickets Sold</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">2,450</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>14.8%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>

                    <!-- Meetings -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#F3E8FF] text-[#9333EA] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-users-three text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Meetings</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">356</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>13.5%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>

                    <!-- Users / Visitors -->
                    <div class="bg-white p-4 rounded-[12px] border border-gray-100 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-[8px] bg-[#E0E7FF] text-[#4F46E5] flex items-center justify-center shrink-0 border border-gray-50">
                            <i class="ph ph-users text-[20px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] text-gray-500 font-medium mb-0.5 truncate">Users / Visitors</p>
                            <div class="flex items-baseline gap-1.5">
                                <h3 class="text-[16px] font-bold text-[#0B132C]">3,250</h3>
                                <span class="text-[9px] text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i>8.3%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-0.5 truncate">vs Apr 01 - Apr 30, 2024</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section (3 Columns) -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 pb-8">
                    
                    <!-- Top Performing Exhibitions -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col h-[340px]">
                        <div class="p-5 pb-4 border-b border-gray-50">
                            <h2 class="text-[15px] font-bold text-[#0B132C]">Top Performing Exhibitions</h2>
                        </div>
                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="text-[11px] text-gray-400 border-b border-gray-50 bg-gray-50/30">
                                        <th class="px-5 py-3 font-semibold">Exhibition</th>
                                        <th class="px-5 py-3 font-semibold">Revenue (₹)</th>
                                        <th class="px-5 py-3 font-semibold">Bookings</th>
                                        <th class="px-5 py-3 font-semibold">Growth</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[12px]">
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#0B132C]">Global Tech Summit 2024</td>
                                        <td class="px-5 py-3 text-gray-600">₹ 4,20,000</td>
                                        <td class="px-5 py-3 text-gray-600">98</td>
                                        <td class="px-5 py-3"><span class="text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i> 18.6%</span></td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#0B132C]">Future AI Conference</td>
                                        <td class="px-5 py-3 text-gray-600">₹ 2,85,000</td>
                                        <td class="px-5 py-3 text-gray-600">72</td>
                                        <td class="px-5 py-3"><span class="text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i> 16.2%</span></td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#0B132C]">Healthcare Leaders Summit</td>
                                        <td class="px-5 py-3 text-gray-600">₹ 2,10,000</td>
                                        <td class="px-5 py-3 text-gray-600">45</td>
                                        <td class="px-5 py-3"><span class="text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i> 12.4%</span></td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#0B132C]">Smart Tech Expo 2024</td>
                                        <td class="px-5 py-3 text-gray-600">₹ 1,60,000</td>
                                        <td class="px-5 py-3 text-gray-600">32</td>
                                        <td class="px-5 py-3"><span class="text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i> 9.8%</span></td>
                                    </tr>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#0B132C]">Sustainability World Expo</td>
                                        <td class="px-5 py-3 text-gray-600">₹ 90,000</td>
                                        <td class="px-5 py-3 text-gray-600">22</td>
                                        <td class="px-5 py-3"><span class="text-[#10B981] font-bold"><i class="ph-bold ph-arrow-up"></i> 7.6%</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-50 text-center">
                            <a href="#" class="text-[12px] font-bold text-[#3723db] hover:underline flex items-center justify-center gap-1">View all exhibitions <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Revenue by Category -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col h-[340px]">
                        <div class="p-5 pb-2 flex justify-between items-center">
                            <h2 class="text-[15px] font-bold text-[#0B132C]">Revenue by Category</h2>
                            <button class="flex items-center gap-1.5 text-[11px] border border-gray-200 rounded px-2 py-1 text-gray-500 font-medium hover:bg-gray-50 transition-colors">
                                This Month <i class="ph-bold ph-caret-down text-[10px]"></i>
                            </button>
                        </div>
                        <div class="flex-1 flex flex-col sm:flex-row items-center justify-center p-4 gap-6">
                            <!-- SVG Donut Chart -->
                            <div class="relative w-[140px] h-[140px] shrink-0">
                                <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                                    <!-- Booth Bookings (45%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#3B82F6" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="138.16" />
                                    <!-- Sponsorships (25%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#10B981" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="188.4" transform="rotate(162 50 50)" />
                                    <!-- Tickets / Passes (15%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#F59E0B" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="213.52" transform="rotate(252 50 50)" />
                                    <!-- Meetings (10%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#EF4444" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="226.08" transform="rotate(306 50 50)" />
                                    <!-- Others (5%) -->
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="#8B5CF6" stroke-width="20" stroke-dasharray="251.2" stroke-dashoffset="238.64" transform="rotate(342 50 50)" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-[14px] font-bold text-[#0B132C]">₹ 12,45,000</span>
                                    <span class="text-[10px] text-gray-500 font-medium">Total</span>
                                </div>
                            </div>
                            
                            <!-- Legend -->
                            <div class="flex flex-col gap-2.5 w-full">
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0"><div class="w-2.5 h-2.5 rounded-full bg-[#3B82F6] shrink-0"></div> <span class="truncate">Booth Bookings</span></div>
                                    <div class="flex items-center gap-3 shrink-0"><span class="font-bold text-[#0B132C]">45%</span> <span class="text-gray-400 w-[55px] text-right">₹ 5,60,000</span></div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0"><div class="w-2.5 h-2.5 rounded-full bg-[#10B981] shrink-0"></div> <span class="truncate">Sponsorships</span></div>
                                    <div class="flex items-center gap-3 shrink-0"><span class="font-bold text-[#0B132C]">25%</span> <span class="text-gray-400 w-[55px] text-right">₹ 3,10,000</span></div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0"><div class="w-2.5 h-2.5 rounded-full bg-[#F59E0B] shrink-0"></div> <span class="truncate">Tickets / Passes</span></div>
                                    <div class="flex items-center gap-3 shrink-0"><span class="font-bold text-[#0B132C]">15%</span> <span class="text-gray-400 w-[55px] text-right">₹ 1,85,000</span></div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0"><div class="w-2.5 h-2.5 rounded-full bg-[#EF4444] shrink-0"></div> <span class="truncate">Meetings</span></div>
                                    <div class="flex items-center gap-3 shrink-0"><span class="font-bold text-[#0B132C]">10%</span> <span class="text-gray-400 w-[55px] text-right">₹ 1,25,000</span></div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-600 gap-2">
                                    <div class="flex items-center gap-1.5 min-w-0"><div class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6] shrink-0"></div> <span class="truncate">Others</span></div>
                                    <div class="flex items-center gap-3 shrink-0"><span class="font-bold text-[#0B132C]">5%</span> <span class="text-gray-400 w-[55px] text-right">₹ 65,000</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-50 text-center mt-auto">
                            <a href="#" class="text-[12px] font-bold text-[#3723db] hover:underline flex items-center justify-center gap-1">View detailed report <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm flex flex-col h-[340px] xl:col-span-1 sm:col-span-2">
                        <div class="p-5 pb-4 border-b border-gray-50 flex justify-between items-center">
                            <h2 class="text-[15px] font-bold text-[#0B132C]">Recent Transactions</h2>
                            <a href="#" class="text-[12px] font-bold text-[#3723db] hover:underline">View all</a>
                        </div>
                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="text-[11px] text-gray-400 border-b border-gray-50 bg-gray-50/30">
                                        <th class="px-5 py-3 font-semibold">Invoice ID</th>
                                        <th class="px-5 py-3 font-semibold">Customer / Company</th>
                                        <th class="px-5 py-3 font-semibold">Amount</th>
                                        <th class="px-5 py-3 font-semibold">Status</th>
                                        <th class="px-5 py-3 font-semibold">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[12px]">
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#3723db]">INV-2024-1567</td>
                                        <td class="px-5 py-3 text-gray-800 font-medium">TechNova Solutions</td>
                                        <td class="px-5 py-3 text-[#0B132C] font-semibold">₹ 1,20,000</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 bg-[#ECFDF5] text-[#10B981] rounded text-[10px] font-bold uppercase">Paid</span></td>
                                        <td class="px-5 py-3 text-gray-500">May 16, 2024</td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#3723db]">INV-2024-1566</td>
                                        <td class="px-5 py-3 text-gray-800 font-medium">Global Tech Solutions</td>
                                        <td class="px-5 py-3 text-[#0B132C] font-semibold">₹ 1,50,000</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 bg-[#ECFDF5] text-[#10B981] rounded text-[10px] font-bold uppercase">Paid</span></td>
                                        <td class="px-5 py-3 text-gray-500">May 16, 2024</td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#3723db]">INV-2024-1565</td>
                                        <td class="px-5 py-3 text-gray-800 font-medium">Future AI Conference</td>
                                        <td class="px-5 py-3 text-[#0B132C] font-semibold">₹ 75,000</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 bg-[#ECFDF5] text-[#10B981] rounded text-[10px] font-bold uppercase">Paid</span></td>
                                        <td class="px-5 py-3 text-gray-500">May 15, 2024</td>
                                    </tr>
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#3723db]">INV-2024-1564</td>
                                        <td class="px-5 py-3 text-gray-800 font-medium">SmartTech Pvt. Ltd.</td>
                                        <td class="px-5 py-3 text-[#0B132C] font-semibold">₹ 90,000</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 bg-[#FFF7ED] text-[#EA580C] rounded text-[10px] font-bold uppercase">Pending</span></td>
                                        <td class="px-5 py-3 text-gray-500">May 15, 2024</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-[#3723db]">INV-2024-1563</td>
                                        <td class="px-5 py-3 text-gray-800 font-medium">InnovateX Corp.</td>
                                        <td class="px-5 py-3 text-[#0B132C] font-semibold">₹ 60,000</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 bg-[#FEF2F2] text-[#EF4444] rounded text-[10px] font-bold uppercase">Overdue</span></td>
                                        <td class="px-5 py-3 text-gray-500">May 15, 2024</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-50 text-center mt-auto hidden xl:block">
                            <!-- Hidden link to keep heights even if needed, or maybe just matching design -->
                            <a href="#" class="text-[12px] font-bold text-[#3723db] hover:underline flex items-center justify-center gap-1">View all transactions <i class="ph-bold ph-arrow-right"></i></a>
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
