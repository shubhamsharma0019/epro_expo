<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Event Dashboard | eproexpo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link rel="preload" as="style" href="http://localhost/build/assets/app-DteJTPcP.css" /><link rel="modulepreload" as="script" href="http://localhost/build/assets/app-CcNNqum8.js" /><link rel="stylesheet" href="http://localhost/build/assets/app-DteJTPcP.css" /><script type="module" src="http://localhost/build/assets/app-CcNNqum8.js"></script>    <style>
        @media (min-width: 1024px) {
            #company-event-sidebar {
                box-sizing: border-box;
                width: 348px;
            }

            .company-event-flow-main {
                margin-left: 348px;
            }
        }
    </style>
</head>

<body class="company-event-flow overflow-x-hidden bg-white font-sans text-[#1C1364] antialiased">
    <div id="company-event-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#1C1364]/35 lg:hidden"></div>

    <aside id="company-event-sidebar" class="fixed inset-y-0 left-0 z-50 box-border flex h-screen w-[280px] max-w-[86vw] -translate-x-full flex-col overflow-hidden border-r border-gray-100 bg-white px-6 py-8 shadow-[2px_0_10px_rgba(0,0,0,0.02)] transition-transform duration-200 lg:translate-x-0">
    <div class="mb-10 flex shrink-0 items-center justify-between gap-3 pl-2">
        <a href="http://localhost/company/event-company-flow/dashboard" class="flex min-w-0 items-center gap-3 no-underline">
            <svg class="h-10 w-10 shrink-0" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 8.5C15.0964 8.5 9.5 14.0964 9.5 21C9.5 27.9036 15.0964 33.5 22 33.5C25.8643 33.5 29.3175 31.7454 31.621 28.9868" stroke="url(#companyEventLogoGradient)" stroke-width="7" stroke-linecap="round" />
                <circle cx="32" cy="11" r="3.5" fill="#FF8A00" />
                <defs>
                    <linearGradient id="companyEventLogoGradient" x1="9.5" y1="33.5" x2="31" y2="8.5" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#5B32F6" />
                        <stop offset="1" stop-color="#FF3366" />
                    </linearGradient>
                </defs>
            </svg>
            <span class="truncate text-[24px] font-bold tracking-tight text-[#1C1364]">eproexpo</span>
        </a>
        <button type="button" data-company-event-sidebar-close class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-[#1C1364] hover:bg-[#F8F9FA] lg:hidden" aria-label="Close event menu">
            <i class="ph ph-x text-2xl"></i>
        </button>
    </div>

    <nav class="flex min-h-0 flex-1 flex-col gap-1.5 overflow-y-auto overflow-x-hidden [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                                <a href="http://localhost/company/event-company-flow/dashboard"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-squares-four shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Dashboard</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/create"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-calendar-plus shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Create Event</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/basic-details"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-note-pencil shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Basic Details</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/branding"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-palette shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Branding</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/ticket-setup"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-ticket shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Tickets / Passes</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/preview"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-eye shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Preview</span>
            </a>
                                <a href="http://localhost/company/event-company-flow/submit-review"  class="flex min-w-0 items-center gap-4 rounded-xl px-4 py-3.5 text-[15px] transition-colors font-medium text-[#1C1364] hover:bg-[#F8F9FA]">
                <i class="ph ph-paper-plane-tilt shrink-0 text-[21px] text-[#1C1364]"></i>
                <span class="truncate">Submit Review</span>
            </a>
            </nav>

    <div class="mt-6 shrink-0 rounded-2xl border border-gray-100 bg-[#FCFCFD] p-5">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F4F1FF] text-[#5B32F6]">
            <i class="ph ph-headset text-2xl"></i>
        </div>
        <h4 class="mb-1 text-[15px] font-bold text-[#1C1364]">Need Help?</h4>
        <p class="mb-4 text-[13px] leading-relaxed text-gray-500">We're here to help you with your events.</p>
        <a href="http://localhost/company/settings" class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#5B32F6] bg-white py-2.5 text-[14px] font-semibold text-[#5B32F6] transition-colors hover:bg-[#F4F1FF]">
            <i class="ph ph-phone text-lg"></i>
            Contact Support
        </a>
    </div>
</aside>

    <button type="button" data-company-event-sidebar-open class="fixed left-4 top-4 z-30 grid h-11 w-11 place-items-center rounded-xl border border-gray-100 bg-white text-[#1C1364] shadow-sm lg:hidden" aria-label="Open event menu">
        <i class="ph ph-list text-2xl"></i>
    </button>

    <main class="company-event-flow-main min-h-screen min-w-0 overflow-x-hidden bg-white">
        
        
        <div class=" w-full max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10">
<header class="flex flex-col gap-5 lg:flex-row lg:justify-between lg:items-center mb-10">
            <div class="flex flex-wrap gap-4 sm:gap-6">
                <a href="http://localhost/events" class="text-sm font-medium text-gray-500 hover:text-gray-900">Explore Events</a>
                <a href="http://localhost/exhibitions" class="text-sm font-medium text-gray-500 hover:text-gray-900">Exhibitions</a>
                <a href="http://localhost#features" class="text-sm font-medium text-gray-500 hover:text-gray-900">Products</a>
                <a href="http://localhost#features" class="text-sm font-medium text-gray-500 hover:text-gray-900">Jobs</a>
                <a href="http://localhost#about" class="text-sm font-medium text-gray-500 hover:text-gray-900">Resources</a>
                <a href="http://localhost#pricing" class="text-sm font-medium text-gray-500 hover:text-gray-900">Pricing</a>
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
            <h1 class="text-2xl font-bold mb-2">Event Company Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, John! Here's what's happening with your company events.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-[#F4F1FF] text-[#5B32F6]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Total Events</div>
                    <div class="text-2xl font-bold mb-2">0</div>
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
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Ticket Types</div>
                    <div class="text-2xl font-bold mb-2">0</div>
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
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Sessions</div>
                    <div class="text-2xl font-bold mb-2">0</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        32.8%
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-[#F4F1FF] text-[#5B32F6]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Pending Approvals</div>
                    <div class="text-2xl font-bold mb-2">0</div>
                    <a href="#" class="text-[13px] text-[#5B32F6] font-medium hover:underline inline-block mt-1">View all</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 mb-6 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_280px]">
            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-semibold">Upcoming Events</h3>
                    <a href="#" class="text-[13px] text-[#5B32F6] font-medium hover:underline">View all events</a>
                </div>
                <div class="flex flex-col gap-4">
                                            <div class="rounded-lg border border-dashed border-gray-200 p-5 text-center text-sm text-gray-500">
                            No company events yet.
                        </div>
                                    </div>
                <div class="text-center mt-5">
                    <a href="#" class="text-[13px] text-[#5B32F6] font-medium hover:underline">View all events</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-6 bg-white relative">
                <div class="flex justify-between items-center mb-5 relative z-10 bg-white">
                    <h3 class="text-base font-semibold">Recent Activity</h3>
                    <a href="#" class="text-[13px] text-[#5B32F6] font-medium hover:underline">View all activity</a>
                </div>
                <div class="relative pl-[14px]">
                    <div class="absolute left-[29px] top-4 bottom-4 w-0 border-l-2 border-dashed border-gray-200 z-0"></div>
                    <div class="flex gap-4 mb-6 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-[#F4F1FF] text-[#5B32F6] flex items-center justify-center shrink-0 border-[3px] border-white">
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
                        <div class="w-8 h-8 rounded-full bg-[#F4F1FF] text-[#5B32F6] flex items-center justify-center shrink-0 border-[3px] border-white">
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
                        <div class="w-8 h-8 rounded-full bg-[#F4F1FF] text-[#5B32F6] flex items-center justify-center shrink-0 border-[3px] border-white">
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
                        <div class="w-8 h-8 rounded-full bg-[#F4F1FF] text-[#5B32F6] flex items-center justify-center shrink-0 border-[3px] border-white">
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
                        <div class="w-8 h-8 rounded-full bg-[#F4F1FF] text-[#5B32F6] flex items-center justify-center shrink-0 border-[3px] border-white">
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
                    <a href="#" class="text-[13px] text-[#5B32F6] font-medium hover:underline">View all activity</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <h3 class="text-base font-semibold mb-5">Quick Actions</h3>
                <div class="flex flex-col gap-3">
                    <a href="http://localhost/company/event-company-flow/create" class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Create New Event
                    </a>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        View All Events
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Manage Registrations
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Add Speaker
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        Upload Resources
                    </button>
                    <button class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg text-[13px] font-medium text-gray-900 hover:bg-gray-50 transition-colors w-full text-left">
                        <svg class="text-[#5B32F6] shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        Event Analytics
                    </button>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-xl bg-white relative mt-10">
            <h3 class="absolute -top-3 left-6 bg-white px-2 font-semibold text-[15px]">At a Glance</h3>
            <div class="grid grid-cols-1 gap-8 py-8 px-6 sm:grid-cols-2 lg:grid-cols-4 lg:px-12">
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-[#5B32F6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Exhibitors</h4>
                        <p class="text-2xl font-bold">76</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-[#5B32F6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Speakers</h4>
                        <p class="text-2xl font-bold">48</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-[#5B32F6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Sessions</h4>
                        <p class="text-2xl font-bold">92</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-[#5B32F6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Countries</h4>
                        <p class="text-2xl font-bold">24</p>
                    </div>
                </div>
            </div>
        </div>
</div>
    </main>

        <script>
        (() => {
            const sidebar = document.getElementById('company-event-sidebar');
            const overlay = document.getElementById('company-event-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-company-event-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-company-event-sidebar-close]');

            const openSidebar = () => {
                sidebar?.classList.remove('-translate-x-full');
                overlay?.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar?.classList.add('-translate-x-full');
                overlay?.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openButtons.forEach((button) => button.addEventListener('click', openSidebar));
            closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        })();
    </script>
</body>

</html>
