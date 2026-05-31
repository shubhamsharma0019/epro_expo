<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - eproexpo</title>
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
    
    <main class="ml-[280px] flex-1 bg-white min-h-screen">
        <!-- Top Nav -->
        <header class="flex justify-between items-center px-10 py-6 border-b border-gray-100">
            <div class="flex gap-8">
                <a href="#" class="text-sm font-medium text-textMain">Explore Events</a>
                <a href="#" class="text-sm font-medium text-textMain">Exhibitions</a>
                <a href="#" class="text-sm font-medium text-textMain">Products</a>
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

        <div class="px-10 py-8">
            <!-- Header Title -->
            <div class="mb-8">
                <h1 class="text-[24px] font-bold tracking-tight text-[#1C1364] mb-1">Create New Event</h1>
                <p class="text-[14px] text-textMuted">Choose how you want to create your event.</p>
            </div>

            <!-- Main Card -->
            <div class="border border-gray-100 rounded-[20px] p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                
                <!-- Section 1 -->
                <div class="mb-10">
                    
                    <h3 class="text-[15px] font-bold mb-4">Choose Event Type</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="border border-gray-100 rounded-2xl p-5 hover:border-primary cursor-pointer transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <h4 class="text-[14px] font-bold mb-2">In-Person Event</h4>
                            <p class="text-[13px] text-textMuted leading-relaxed">Host an event at a physical location</p>
                        </div>
                        
                        <div class="border border-gray-100 rounded-2xl p-5 hover:border-primary cursor-pointer transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                            </div>
                            <h4 class="text-[14px] font-bold mb-2">Virtual Event</h4>
                            <p class="text-[13px] text-textMuted leading-relaxed">Host an event online with live or recorded sessions</p>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 hover:border-primary cursor-pointer transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            </div>
                            <h4 class="text-[14px] font-bold mb-2">Hybrid Event</h4>
                            <p class="text-[13px] text-textMuted leading-relaxed">Combine in-person and virtual participation</p>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 hover:border-primary cursor-pointer transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><polygon points="10 8 16 10 10 12 10 8"></polygon><line x1="12" y1="17" x2="12" y2="21"></line><line x1="8" y1="21" x2="16" y2="21"></line></svg>
                            </div>
                            <h4 class="text-[14px] font-bold mb-2">Demo and Webinar</h4>
                            <p class="text-[13px] text-textMuted leading-relaxed">Present demos or conduct webinars online</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2 -->
                <div class="mb-10">
                    <h3 class="text-[15px] font-bold mb-4">Start from Template</h3>
                    <div class="grid grid-cols-5 gap-4">
                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow bg-white">
                            <div class="w-10 h-10 rounded-lg bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <h4 class="text-[13px] font-bold mb-2">Tech Conference</h4>
                            <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">Modern tech conference template</p>
                            <button class="w-full py-2 border border-gray-100 text-primary text-[13px] font-semibold rounded-lg hover:border-primary transition-colors">Use Template</button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow bg-white">
                            <div class="w-10 h-10 rounded-lg bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h4 class="text-[13px] font-bold mb-2">Expo / Trade Show</h4>
                            <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">Exhibition & trade show template</p>
                            <button class="w-full py-2 border border-gray-100 text-primary text-[13px] font-semibold rounded-lg hover:border-primary transition-colors">Use Template</button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow bg-white">
                            <div class="w-10 h-10 rounded-lg bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            </div>
                            <h4 class="text-[13px] font-bold mb-2">Webinar Series</h4>
                            <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">Multi-session webinar template</p>
                            <button class="w-full py-2 border border-gray-100 text-primary text-[13px] font-semibold rounded-lg hover:border-primary transition-colors">Use Template</button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow bg-white">
                            <div class="w-10 h-10 rounded-lg bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                            </div>
                            <h4 class="text-[13px] font-bold mb-2">Networking Event</h4>
                            <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">Networking & meetup template</p>
                            <button class="w-full py-2 border border-gray-100 text-primary text-[13px] font-semibold rounded-lg hover:border-primary transition-colors">Use Template</button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow bg-white">
                            <div class="w-10 h-10 rounded-lg bg-primary-light text-primary flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line><path d="M9 16l2 2 4-4"></path></svg>
                            </div>
                            <h4 class="text-[13px] font-bold mb-2">Custom Event</h4>
                            <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">Start with a blank event</p>
                            <button class="w-full py-2 border border-gray-100 text-primary text-[13px] font-semibold rounded-lg hover:border-primary transition-colors">Use Template</button>
                        </div>
                    </div>
                </div>

                <!-- Section 3 -->
                <div class="mb-4">
                    <h3 class="text-[15px] font-bold mb-4">Event Category</h3>
                    <div class="flex flex-wrap gap-3">
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Technology</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Healthcare</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Education</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Finance</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Marketing</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Manufacturing</button>
                        <button class="px-5 py-2.5 border border-gray-100 text-primary text-[13px] font-semibold rounded-[10px] hover:border-primary transition-colors bg-white">Other</button>
                    </div>
                </div>

            </div>

            <!-- Action Area -->
            <div class="flex justify-end mt-6">
                <a href="event-basic-details.html" class="bg-primary text-white px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#4a26d1] transition-colors">Save & Continue</a>
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
