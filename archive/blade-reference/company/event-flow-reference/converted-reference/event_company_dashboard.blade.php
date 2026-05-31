<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard - eproexpo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#5B32F6',
                            light: '#F3F0FF',
                        },
                        success: {
                            DEFAULT: '#10B981',
                            light: '#ECFDF5',
                        },
                        warning: {
                            DEFAULT: '#F59E0B',
                            light: '#FFFBEB',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-900 font-sans flex min-h-screen">
    <div id="sidebar-container"></div>
    
    <main class="ml-[280px] flex-1 py-8 px-10 max-w-[1200px]">
        <header class="flex justify-between items-center mb-10">
            <div class="flex gap-6">
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Explore Events</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Exhibitions</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Products</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Jobs</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Resources</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900">Pricing</a>
            </div>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-1 text-sm font-medium cursor-pointer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    EN
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/150?img=11" alt="John Doe" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h4 class="text-sm font-semibold">John Doe</h4>
                        <p class="text-xs text-gray-500">Organizer</p>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
        </header>

        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-2">Company Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, John! Here's what's happening with your events.</p>
        </div>

        <div class="grid grid-cols-4 gap-5 mb-6">
            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Total Events</div>
                    <div class="text-2xl font-bold mb-2">12</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        6.2% vs month
                    </div>
                </div>
            </div>
            
            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-success-light text-success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Registrations</div>
                    <div class="text-2xl font-bold mb-2">1,842</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        18.4%
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-warning-light text-warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Revenue</div>
                    <div class="text-2xl font-bold mb-2">$125,680</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        32.8%
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Pending Approvals</div>
                    <div class="text-2xl font-bold mb-2">8</div>
                    <a href="#" class="text-[13px] text-primary font-medium hover:underline inline-block mt-1">View all</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-[1fr_1fr_280px] gap-5 mb-6">
            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-semibold">Upcoming Events</h3>
                    <a href="#" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex gap-4">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=200&h=120&fit=crop" alt="Global Tech Summit" class="w-[90px] h-[60px] rounded-lg object-cover bg-gray-200 shrink-0">
                        <div>
                            <h4 class="text-sm font-semibold mb-1">Global Tech Summit 2024</h4>
                            <p class="text-xs text-gray-500 mb-1">May 15 - 17, 2024</p>
                            <span class="text-xs text-gray-500">1,245 Registrations</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=200&h=120&fit=crop" alt="Future of AI Expo" class="w-[90px] h-[60px] rounded-lg object-cover bg-gray-200 shrink-0">
                        <div>
                            <h4 class="text-sm font-semibold mb-1">Future of AI Expo</h4>
                            <p class="text-xs text-gray-500 mb-1">Jun 20 - 22, 2024</p>
                            <span class="text-xs text-gray-500">842 Registrations</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?w=200&h=120&fit=crop" alt="HealthTech Connect" class="w-[90px] h-[60px] rounded-lg object-cover bg-gray-200 shrink-0">
                        <div>
                            <h4 class="text-sm font-semibold mb-1">HealthTech Connect</h4>
                            <p class="text-xs text-gray-500 mb-1">Aug 10 - 11, 2024</p>
                            <span class="text-xs text-gray-500">1,105 Registrations</span>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="#" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-6 bg-white relative">
                <div class="flex justify-between items-center mb-5 relative z-10 bg-white">
                    <h3 class="text-base font-semibold">Recent Activity</h3>
                    <a href="#" class="text-[13px] text-primary font-medium hover:underline">View all activity</a>
                </div>
                <div class="relative pl-[14px]">
                    <div class="absolute left-[29px] top-4 bottom-4 w-0 border-l-2 border-dashed border-gray-200 z-0"></div>
                    <div class="flex gap-4 mb-6 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <div class="flex-1 mt-1">
                            <div class="flex justify-between mb-1">
                                <h4 class="text-[13px] font-semibold">New registration</h4>
                                <span class="text-xs text-gray-500">10 min ago</span>
                            </div>
                            <div class="text-xs text-gray-500">John Smith registered for Tech Summit 2024</div>
                        </div>
                    </div>
                    <div class="flex gap-4 mb-6 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                        <div class="flex-1 mt-1">
                            <div class="flex justify-between mb-1">
                                <h4 class="text-[13px] font-semibold">Sponsorship request</h4>
                                <span class="text-xs text-gray-500">20 min ago</span>
                            </div>
                            <div class="text-xs text-gray-500">TechNext Solutions requested sponsorship</div>
                        </div>
                    </div>
                    <div class="flex gap-4 mb-6 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </div>
                        <div class="flex-1 mt-1">
                            <div class="flex justify-between mb-1">
                                <h4 class="text-[13px] font-semibold">Session update</h4>
                                <span class="text-xs text-gray-500">1 hour ago</span>
                            </div>
                            <div class="text-xs text-gray-500">AI in Healthcare session updated</div>
                        </div>
                    </div>
                    <div class="flex gap-4 mb-6 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                        </div>
                        <div class="flex-1 mt-1">
                            <div class="flex justify-between mb-1">
                                <h4 class="text-[13px] font-semibold">Payment received</h4>
                                <span class="text-xs text-gray-500">2 hours ago</span>
                            </div>
                            <div class="text-xs text-gray-500">$5,680 payment from David Tech</div>
                        </div>
                    </div>
                    <div class="flex gap-4 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        <div class="flex-1 mt-1">
                            <div class="flex justify-between mb-1">
                                <h4 class="text-[13px] font-semibold">Booth approval</h4>
                                <span class="text-xs text-gray-500">3 hours ago</span>
                            </div>
                            <div class="text-xs text-gray-500">Innovate Labs booth has been approved</div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-6">
                    <a href="#" class="text-[13px] text-primary font-medium hover:underline">View all activity</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <h3 class="text-base font-semibold mb-5">Quick Actions</h3>
                <div class="flex flex-col gap-3">
                    <a href="create-event.html" class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Create New Event
                    </a>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        View All Events
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Manage Registrations
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Add Speaker
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        Upload Resources
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-primary shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        Event Analytics
                    </button>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-xl bg-white relative mt-10">
            <h3 class="absolute -top-3 left-6 bg-white px-2 font-semibold text-[15px]">At a Glance</h3>
            <div class="flex justify-between py-8 px-12">
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Exhibitors</h4>
                        <p class="text-2xl font-bold">76</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Speakers</h4>
                        <p class="text-2xl font-bold">48</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Sessions</h4>
                        <p class="text-2xl font-bold">92</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Countries</h4>
                        <p class="text-2xl font-bold">24</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="sidebar.js"></script>
    <script src="app.js"></script>
</body>
</html>
