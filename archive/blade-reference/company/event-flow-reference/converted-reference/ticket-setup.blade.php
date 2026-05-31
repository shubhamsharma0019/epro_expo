<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets / Pass Setup - eproexpo</title>
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
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-textMain font-sans flex min-h-screen">
    <div id="sidebar-container" class="z-50 relative"></div>
    
    <main class="ml-[280px] flex-1 bg-white min-h-screen flex flex-col">
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

        <div class="px-10 py-8 max-w-[1250px] w-full flex flex-col">
            <!-- Add Ticket Button (Header and subtitle removed as requested) -->
            <div class="flex justify-end mb-6">
                <button class="bg-[#4C10D0] text-white px-5 py-2.5 rounded-lg text-[13px] font-semibold flex items-center gap-2 hover:bg-[#3d0ba8] transition-colors shadow-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add Ticket Type
                </button>
            </div>

            <!-- Table -->
            <div class="border border-gray-200 rounded-[16px] bg-white overflow-hidden mb-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 bg-white">
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[25%]">Ticket Type</th>
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[15%]">Price (USD)</th>
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[15%]">Quantity</th>
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[18%]">Sales Start</th>
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[18%]">Sales End</th>
                            <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[9%] text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] text-[#1C1364] font-medium">
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6 font-bold">Early Bird Pass</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">$99.00</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">500</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">Apr 01, 2024</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">Apr 30, 2024</td>
                            <td class="py-5 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button class="text-[#4C10D0] hover:text-primary transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button class="text-[#EF4444] hover:text-red-600 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6 font-bold">General Admission</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">$199.00</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">1,000</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 01, 2024</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 15, 2024</td>
                            <td class="py-5 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button class="text-[#4C10D0] hover:text-primary transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button class="text-[#EF4444] hover:text-red-600 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6 font-bold">VIP Pass</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">$399.00</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">200</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 01, 2024</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 17, 2024</td>
                            <td class="py-5 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button class="text-[#4C10D0] hover:text-primary transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button class="text-[#EF4444] hover:text-red-600 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6 font-bold">Student Pass</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">$49.00</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">300</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 01, 2024</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 17, 2024</td>
                            <td class="py-5 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button class="text-[#4C10D0] hover:text-primary transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button class="text-[#EF4444] hover:text-red-600 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6 font-bold">Exhibitor Pass</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">$0.00</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">Unlimited</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 01, 2024</td>
                            <td class="py-5 px-6 text-[#5B6B8A] font-medium">May 17, 2024</td>
                            <td class="py-5 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <button class="text-[#4C10D0] hover:text-primary transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button class="text-[#EF4444] hover:text-red-600 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Settings Cards (Side by side) -->
            <div class="grid grid-cols-2 gap-8 mb-10">
                
                <!-- Attendee Information Fields -->
                <div class="border border-gray-200 rounded-[16px] p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-6">Attendee Information Fields</h3>
                    <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded bg-[#4C10D0] text-white flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Full Name</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded bg-[#4C10D0] text-white flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Company</span>
                        </label>
                        
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded bg-[#4C10D0] text-white flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Email Address</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded bg-[#4C10D0] text-white flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Job Title</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded bg-[#4C10D0] text-white flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Phone Number</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-5 h-5 rounded border border-gray-300 bg-white group-hover:border-[#4C10D0] transition-colors shrink-0"></div>
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Country</span>
                        </label>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="border border-gray-200 rounded-[16px] p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-6">Additional Settings</h3>
                    <div class="flex flex-col gap-6">
                        <!-- Setting 1 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Allow group registrations</span>
                            <div class="relative w-10 h-5 bg-[#4C10D0] rounded-full cursor-pointer">
                                <div class="absolute right-[2px] top-[2px] w-4 h-4 bg-white rounded-full transition-transform"></div>
                            </div>
                        </div>
                        <!-- Setting 2 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Show remaining ticket count</span>
                            <div class="relative w-10 h-5 bg-[#4C10D0] rounded-full cursor-pointer">
                                <div class="absolute right-[2px] top-[2px] w-4 h-4 bg-white rounded-full transition-transform"></div>
                            </div>
                        </div>
                        <!-- Setting 3 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Waiting list</span>
                            <div class="relative w-10 h-5 bg-gray-200 rounded-full cursor-pointer">
                                <div class="absolute left-[2px] top-[2px] w-4 h-4 bg-white rounded-full transition-transform border border-gray-100 shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Actions -->
            <div class="flex justify-end gap-3 mt-auto pt-4">
                <a href="event-branding.html" class="px-8 py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-semibold hover:bg-gray-50 transition-colors shadow-sm inline-block">Back</a>
                <a href="event-preview.html" class="bg-[#4C10D0] text-white px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#3d0ba8] transition-colors inline-block">Save & Continue</a>
            </div>

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
