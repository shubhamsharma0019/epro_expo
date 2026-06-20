<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3b18ff',
                        'primary-light': '#f4f2ff',
                        success: '#10B981',
                        'success-light': '#D1FAE5',
                        warning: '#F59E0B',
                        'warning-light': '#FEF3C7',
                        purple: '#8B5CF6',
                        'purple-light': '#EDE9FE',
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-outfit text-gray-900 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-80 bg-white border-r border-gray-100 flex flex-col z-30 px-5 py-6 shadow-sm">
        <div class="flex h-[88px] items-center px-3 mb-4">
            <a href="dashboard.html" class="flex items-center gap-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 via-[#5b2eff] to-[#246BFF] font-bold text-white">e</div>
                <span class="text-[25px] font-semibold tracking-[-0.04em] text-gray-900">epro<span class="text-[#246BFF]">expo</span></span>
            </a>
        </div>
        <ul class="flex flex-col gap-3 list-none">
            <li>
                <a href="dashboard.html" class="group menu-item-active flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 active:bg-primary-light active:text-primary bg-primary-light text-primary">
                    <i class="ph ph-squares-four text-2xl mr-5 text-primary transition-colors duration-200"></i>
                    <span class="text-base font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-bank text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Pavallions</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-calendar-check text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">My Bookings</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-user-list text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Enquires / Leads</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-storefront text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Manage Booths / Edit Booths</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-users text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Meeting Request</span>
                </a>
            </li>
            <li>
                <a href="analytics.html" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-chart-bar text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-receipt text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Payments / Invoices</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <div class="relative flex items-center">
                        <i class="ph ph-bell text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                        <div class="absolute w-2.5 h-2.5 bg-red-600 rounded-full border-2 border-white top-0 right-5"></div>
                    </div>
                    <span class="text-base font-medium">Notification</span>
                </a>
            </li>
            <li class="mt-3">
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-sign-out text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="flex-1 ml-80 flex flex-col min-h-screen">
        <!-- Top Navigation -->
        <header class="h-[80px] border-b border-gray-100 flex items-center justify-between px-8 bg-white z-20 sticky top-0">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        </div>
        
        <div class="flex items-center space-x-6">
            <button class="text-gray-500 hover:text-gray-900 transition-colors">
                <i class="ph ph-magnifying-glass text-2xl"></i>
            </button>
            <button class="text-gray-500 hover:text-gray-900 transition-colors relative">
                <i class="ph ph-bell text-2xl"></i>
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="flex items-center cursor-pointer">
                <img src="https://i.pravatar.cc/150?img=11" alt="John Doe" class="w-9 h-9 rounded-full object-cover">
                <span class="ml-3 font-semibold text-gray-900 text-sm">John Doe</span>
                <i class="ph ph-caret-down text-gray-500 ml-2"></i>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-8 max-w-[1400px] mx-auto w-full">
        
        <!-- Welcome Section -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-[28px] font-bold text-gray-900 mb-1 flex items-center gap-2">
                    Welcome back, John Doe! 👋
                </h2>
                <p class="text-gray-500 text-[15px]">Here's what's happening with your exhibition.</p>
            </div>
            
            <div class="relative min-w-[240px]">
                <select class="w-full appearance-none bg-white border border-gray-200 text-gray-700 py-3 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent font-medium shadow-sm">
                    <option>Global Tech Summit 2024</option>
                    <option>AI Expo 2025</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <i class="ph ph-caret-down"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Booths -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-storefront text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[13px] font-medium mb-1">Total Booths</p>
                        <h3 class="text-[28px] font-bold text-gray-900 leading-none">3</h3>
                    </div>
                </div>
                <div class="text-gray-500 text-[13px] font-medium mt-2">
                    Active
                </div>
            </div>

            <!-- Total Visitors -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-success-light text-success flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[13px] font-medium mb-1">Total Visitors</p>
                        <h3 class="text-[28px] font-bold text-gray-900 leading-none">1,248</h3>
                    </div>
                </div>
                <div class="flex items-center text-success font-bold text-[13px] mt-2">
                    <i class="ph ph-arrow-up mr-1"></i> 12.5%
                </div>
            </div>

            <!-- Total Leads -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-warning-light text-warning flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-user-list text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[13px] font-medium mb-1">Total Leads</p>
                        <h3 class="text-[28px] font-bold text-gray-900 leading-none">356</h3>
                    </div>
                </div>
                <div class="flex items-center text-success font-bold text-[13px] mt-2">
                    <i class="ph ph-arrow-up mr-1"></i> 8.3%
                </div>
            </div>

            <!-- Upcoming Meetings -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-light text-purple flex items-center justify-center flex-shrink-0">
                        <i class="ph ph-users-three text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[13px] font-medium mb-1">Upcoming Meetings</p>
                        <h3 class="text-[28px] font-bold text-gray-900 leading-none">12</h3>
                    </div>
                </div>
                <div class="text-gray-500 text-[13px] font-medium mt-2 hover:text-primary cursor-pointer transition-colors">
                    View All
                </div>
            </div>

        </div>

        <!-- Middle Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Booth Performance Chart -->
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Booth Performance</h3>
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent font-medium shadow-sm">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <i class="ph ph-caret-down text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Placeholder -->
                <div class="flex-1 w-full h-[280px] relative mt-4">
                    <div class="absolute inset-0 flex flex-col justify-between pb-8">
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">1.25K</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">1K</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">750</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">500</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">250</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                        <div class="flex items-center w-full">
                            <span class="text-gray-400 text-xs w-10 text-right mr-4 font-medium">0</span>
                            <div class="flex-1 border-b border-gray-50"></div>
                        </div>
                    </div>

                    <!-- Line SVG -->
                    <div class="absolute inset-0 pl-14 pr-4 pb-8 top-2 h-[250px] w-full">
                        <svg class="w-full h-full overflow-visible" viewBox="0 0 700 200" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="gradientArea" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#3b18ff" stop-opacity="0.15" />
                                    <stop offset="100%" stop-color="#3b18ff" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <!-- Fill Area -->
                            <polygon points="20,160 120,110 220,120 320,60 420,110 520,80 620,40 620,200 20,200" fill="url(#gradientArea)" />
                            <!-- Line -->
                            <polyline points="20,160 120,110 220,120 320,60 420,110 520,80 620,40" fill="none" stroke="#3b18ff" stroke-width="2.5" />
                            <!-- Points -->
                            <circle cx="20" cy="160" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="120" cy="110" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="220" cy="120" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="320" cy="60" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="420" cy="110" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="520" cy="80" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                            <circle cx="620" cy="40" r="4.5" fill="#3b18ff" stroke="white" stroke-width="2" />
                        </svg>
                    </div>

                    <!-- X-axis labels -->
                    <div class="absolute bottom-0 left-14 right-4 flex justify-between">
                        <span class="text-gray-400 text-[11px] font-medium ml-[-5px]">May 10</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-10px]">May 11</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-15px]">May 12</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-20px]">May 13</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-25px]">May 14</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-30px]">May 15</span>
                        <span class="text-gray-400 text-[11px] font-medium ml-[-10px]">May 16</span>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Recent Notifications</h3>
                    <a href="#" class="text-primary font-bold text-sm hover:underline">View All</a>
                </div>
                
                <div class="space-y-6 flex-1">
                    <!-- Notification 1 -->
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center flex-shrink-0 mr-4">
                            <i class="ph ph-user-plus text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-gray-900 text-sm font-bold">New lead received</h4>
                                <span class="text-gray-400 text-[11px] font-medium whitespace-nowrap ml-2">10 min ago</span>
                            </div>
                            <p class="text-gray-500 text-xs">TechNext Solutions has shown interest.</p>
                        </div>
                    </div>
                    
                    <hr class="border-gray-50">

                    <!-- Notification 2 -->
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center flex-shrink-0 mr-4">
                            <i class="ph ph-calendar-plus text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-gray-900 text-sm font-bold">Meeting request received</h4>
                                <span class="text-gray-400 text-[11px] font-medium whitespace-nowrap ml-2">20 min ago</span>
                            </div>
                            <p class="text-gray-500 text-xs">John Smith requested a meeting.</p>
                        </div>
                    </div>

                    <hr class="border-gray-50">

                    <!-- Notification 3 -->
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center flex-shrink-0 mr-4">
                            <i class="ph ph-check-circle text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-gray-900 text-sm font-bold">Booth approved</h4>
                                <span class="text-gray-400 text-[11px] font-medium whitespace-nowrap ml-2">1 hour ago</span>
                            </div>
                            <p class="text-gray-500 text-xs">Your booth has been approved.</p>
                        </div>
                    </div>

                    <hr class="border-gray-50">

                    <!-- Notification 4 -->
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center flex-shrink-0 mr-4">
                            <i class="ph ph-file-text text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-gray-900 text-sm font-bold">Payment received</h4>
                                <span class="text-gray-400 text-[11px] font-medium whitespace-nowrap ml-2">2 hours ago</span>
                            </div>
                            <p class="text-gray-500 text-xs">Payment of ₹19,999 received successfully.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <button class="flex items-center justify-center gap-3 py-4 px-6 border border-gray-100 rounded-xl hover:border-primary hover:bg-primary-light transition-colors text-gray-900 font-bold text-sm">
                    <i class="ph ph-storefront text-xl text-primary"></i>
                    Book Pavilion
                </button>
                
                <button class="flex items-center justify-center gap-3 py-4 px-6 border border-gray-100 rounded-xl hover:border-primary hover:bg-primary-light transition-colors text-gray-900 font-bold text-sm">
                    <i class="ph ph-pencil-simple text-xl text-primary"></i>
                    Edit Booth
                </button>

                <button class="flex items-center justify-center gap-3 py-4 px-6 border border-gray-100 rounded-xl hover:border-primary hover:bg-primary-light transition-colors text-gray-900 font-bold text-sm">
                    <i class="ph ph-chart-bar text-xl text-primary"></i>
                    View Analytics
                </button>

                <button class="flex items-center justify-center gap-3 py-4 px-6 border border-gray-100 rounded-xl hover:border-primary hover:bg-primary-light transition-colors text-gray-900 font-bold text-sm">
                    <i class="ph ph-user-list text-xl text-primary"></i>
                    Open Leads
                </button>

            </div>
        </div>

    </main>

    </div>

</body>
</html>
