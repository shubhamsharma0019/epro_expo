<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Basic Details - eproexpo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#5B32F6',
                            light: '#F4F1FF',
                        },
                        textMain: '#1C1364',
                        textMuted: '#6B7280',
                        borderLight: '#E5E7EB'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom select styling to match image */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
        .custom-date {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
    </style>
</head>
<body class="bg-white text-textMain font-sans flex min-h-screen">
    <div id="sidebar-container" class="z-50 relative"></div>
    
    <main class="ml-[280px] flex-1 bg-white min-h-screen">
        <!-- Top Nav -->
        <header class="flex justify-between items-center px-10 py-6 border-b border-gray-100">
            <div class="flex gap-8">
                <a href="#" class="text-sm font-medium text-textMain">Explore Events</a>
                <a href="#" class="text-sm font-medium text-textMain">Exhibitions</a>
                <a href="#" class="text-sm font-medium text-primary">Products</a>
                <a href="#" class="text-sm font-medium text-textMain">Jobs</a>
                <a href="#" class="text-sm font-medium text-textMain">Resources</a>
                <a href="#" class="text-sm font-medium text-textMain">Pricing</a>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-1 text-sm font-medium cursor-pointer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    EN
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/150?img=11" alt="John Doe" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <h4 class="text-sm font-semibold">John Doe</h4>
                        <p class="text-xs text-textMuted">Organizer</p>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
        </header>

        <div class="px-10 py-8 max-w-[1100px]">
            <!-- Header Title -->
            <div class="mb-10">
                <h1 class="text-[22px] font-bold tracking-tight text-textMain mb-1">Event Basic Details</h1>
                <p class="text-[14px] text-textMuted text-[#5B6B8A]">Fill in the essential information about your event.</p>
            </div>

            <form class="flex flex-col gap-8">
                <!-- Row 1: Name, Category, Sub-Category -->
                <div class="grid grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Event Name <span class="text-red-500">*</span></label>
                        <input type="text" value="Global Innovation Summit 2024" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Event Category <span class="text-red-500">*</span></label>
                        <select class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                            <option>Technology</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Event Sub-Category</label>
                        <select class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                            <option>AI & Machine Learning</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Dates, Timezone -->
                <div class="grid grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Start Date <span class="text-red-500">*</span></label>
                        <input type="text" value="May 15, 2024" class="custom-date px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm cursor-pointer" readonly />
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">End Date <span class="text-red-500">*</span></label>
                        <input type="text" value="May 17, 2024" class="custom-date px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm cursor-pointer" readonly />
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Time Zone</label>
                        <select class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                            <option>(GMT +05:30) Asia/Kolkata</option>
                        </select>
                    </div>
                </div>

                <!-- Row 3: Event Mode -->
                <div class="flex flex-col gap-4 mt-2">
                    <label class="text-[13px] font-bold text-textMain">Event Mode <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-8">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div class="w-4 h-4 rounded-full border border-primary flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                            </div>
                            <span class="text-[14px] text-textMain">In-Person</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            </div>
                            <span class="text-[14px] text-textMain">Virtual</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center">
                            </div>
                            <span class="text-[14px] text-textMain">Hybrid</span>
                        </label>
                    </div>
                </div>

                <!-- Row 4: Venue & Website -->
                <div class="grid grid-cols-[1.2fr_1fr] gap-6 mt-2">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Venue / Location <span class="text-red-500">*</span></label>
                        <input type="text" value="Grand Convention Center, San Francisco, CA, USA" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[13px] font-bold text-textMain">Event Website</label>
                        <input type="text" value="https://globalinnovate.com" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                    </div>
                </div>

                <!-- Row 5: Description -->
                <div class="flex flex-col gap-2.5 mt-2 relative">
                    <label class="text-[13px] font-bold text-textMain">Short Description <span class="text-red-500">*</span></label>
                    <textarea rows="4" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm resize-none">Global Innovation Summit brings together technology leaders, innovators, and investors to explore the future of AI, Cloud, and Emerging Technologies.</textarea>
                    <span class="absolute bottom-3 right-4 text-[11px] text-gray-400 font-medium">143/200</span>
                </div>

                <!-- Row 6: Organizer Contact Section -->
                <div class="mt-6">
                    <h3 class="text-[15px] font-bold text-textMain mb-5">Organizer Contact</h3>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Name</label>
                            <input type="text" value="John Doe" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Email</label>
                            <input type="text" value="john.doe@techwave.com" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Phone</label>
                            <input type="text" value="+1 (415) 586-0189" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end mt-4">
                    <a href="event-branding.html" class="bg-primary text-white px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#4a26d1] transition-colors">Save & Continue</a>
                </div>
            </form>
            
        </div>
    </main>

    <script src="sidebar.js"></script>
    <script src="app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Set 'Events' as active dynamically after app.js loads the sidebar
            setTimeout(() => {
                const navItems = document.querySelectorAll('#sidebar-container a');
                navItems.forEach(n => {
                    // Reset all
                    n.classList.remove('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                    n.classList.add('text-[#1C1364]', 'font-medium');
                    const svg = n.querySelector('svg');
                    if(svg) svg.classList.replace('text-[#5B32F6]', 'text-[#1C1364]');
                    
                    // Activate Events
                    if(n.textContent.trim() === 'Events') {
                        n.classList.remove('text-[#1C1364]', 'font-medium');
                        n.classList.add('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                        if(svg) svg.classList.replace('text-[#1C1364]', 'text-[#5B32F6]');
                    }
                });
            }, 100);
        });
    </script>
</body>
</html>
