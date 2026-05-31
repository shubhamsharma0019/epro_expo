<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Branding - eproexpo</title>
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

        <div class="px-10 py-8 max-w-[1250px]">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-[24px] font-bold tracking-tight text-[#1C1364] mb-1">Event Branding</h1>
                <p class="text-[14px] text-textMuted text-[#5B6B8A]">Customize how your event looks across the platform.</p>
            </div>

            <!-- Two Columns Layout -->
            <div class="grid grid-cols-[380px_1fr] gap-10">
                
                <!-- Left Column -->
                <div class="flex flex-col gap-6">
                    <!-- Row 1: Logo & Colors -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Logo -->
                        <div>
                            <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Event Logo</h3>
                            <div class="border border-gray-200 rounded-[12px] p-4 flex flex-col items-center justify-center mb-3 h-[120px] bg-white">
                                <div class="w-14 h-14 bg-[#F4F1FF] rounded-lg flex items-center justify-center text-[#4C10D0] font-bold text-[15px] text-center leading-tight">GIS<br>2024</div>
                            </div>
                            <p class="text-[11px] text-center text-gray-400 font-medium mb-3">PNG, JPG (Max 2MB)</p>
                            <button class="w-full py-2 border border-[#5B32F6] text-[#5B32F6] text-[13px] font-semibold rounded-[8px] hover:bg-[#F4F1FF] transition-colors">Upload Logo</button>
                        </div>
                        
                        <!-- Brand Colors -->
                        <div>
                            <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Brand Colors</h3>
                            <div class="flex flex-col gap-[14px]">
                                <!-- Primary Color -->
                                <div class="flex items-center justify-between">
                                    <span class="text-[12px] text-gray-600 font-medium">Primary Color</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-[22px] h-[22px] rounded bg-[#4C10D0]"></div>
                                        <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">#4C10D0</div>
                                    </div>
                                </div>
                                <!-- Secondary Color -->
                                <div class="flex items-center justify-between">
                                    <span class="text-[12px] text-gray-600 font-medium">Secondary Color</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-[22px] h-[22px] rounded bg-[#00B894]"></div>
                                        <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">#00B894</div>
                                    </div>
                                </div>
                                <!-- Accent Color -->
                                <div class="flex items-center justify-between">
                                    <span class="text-[12px] text-gray-600 font-medium">Accent Color</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-[22px] h-[22px] rounded bg-[#FF8A00]"></div>
                                        <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">#FF8A00</div>
                                    </div>
                                </div>
                                <!-- Text Color -->
                                <div class="flex items-center justify-between">
                                    <span class="text-[12px] text-gray-600 font-medium">Text Color</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-[22px] h-[22px] rounded bg-[#0F172A]"></div>
                                        <div class="border border-gray-200 rounded px-2 py-1 text-[11px] font-medium text-gray-600 w-[68px] text-center tracking-wide">#0F172A</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Banner & Themes -->
                    <div class="grid grid-cols-2 gap-6 mt-2">
                        <!-- Banner Image -->
                        <div>
                            <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Banner Image</h3>
                            <div class="border border-gray-200 rounded-[12px] overflow-hidden mb-3 h-[85px] bg-[#1A0A4A] relative flex items-center shadow-sm">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#4C10D0]/80 to-[#2c0980]/50"></div>
                                <span class="relative text-white font-bold text-[10px] leading-[1.2] pl-3">GLOBAL<br>INNOVATION<br>SUMMIT 2024</span>
                            </div>
                            <p class="text-[11px] text-center text-gray-400 font-medium mb-3">PNG, JPG (Recommended 1920x640)</p>
                            <button class="w-full py-2 border border-[#5B32F6] text-[#5B32F6] text-[13px] font-semibold rounded-[8px] hover:bg-[#F4F1FF] transition-colors">Change Banner</button>
                        </div>
                        
                        <!-- Theme Sections -->
                        <div>
                            <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Theme Sections</h3>
                            <div class="flex flex-col gap-[10px] mt-1">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Header & Banner</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Event Details</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Speakers</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Sessions</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Sponsors</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-[16px] h-[16px] rounded-full bg-[#10B981] text-white flex items-center justify-center shrink-0"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                    <span class="text-[13px] text-[#1C1364] font-medium">Footer</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Text & Buttons Specs -->
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <!-- Text -->
                        <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between bg-white shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                            <div class="flex flex-col gap-2">
                                <span class="text-[12px] font-bold text-[#1C1364]">Text</span>
                                <span class="text-[15px] text-[#1C1364] font-medium">Aa</span>
                            </div>
                            <span class="text-[14px] font-bold text-[#1C1364] self-end mb-0.5">16</span>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between bg-white shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                            <div class="flex flex-col gap-2">
                                <span class="text-[12px] font-bold text-[#1C1364]">Buttons</span>
                                <div class="w-10 h-8 bg-[#4C10D0] rounded flex items-center justify-center text-white text-[13px] font-medium">Aa</div>
                            </div>
                            <span class="text-[14px] font-bold text-[#1C1364] self-end mb-0.5">32</span>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column (Live Preview Card) -->
                <div class="flex flex-col">
                    <h3 class="text-[14px] font-bold text-[#1C1364] mb-3">Live Preview</h3>
                    <div class="border border-gray-200 rounded-[16px] overflow-hidden shadow-[0_2px_12px_rgba(0,0,0,0.03)] bg-white h-full flex flex-col">
                        
                        <!-- Card Banner -->
                        <div class="relative bg-[#1A0A4A] h-[260px] px-8 py-8 flex flex-col justify-between overflow-hidden shrink-0">
                            <!-- Background abstract graphic -->
                            <div class="absolute inset-0 opacity-50">
                                <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 100 100">
                                    <path d="M-10,60 Q40,30 110,80" fill="none" stroke="#A78BFA" stroke-width="0.3"/>
                                    <path d="M-10,80 Q50,0 110,60" fill="none" stroke="#A78BFA" stroke-width="0.1"/>
                                    <line x1="30" y1="0" x2="70" y2="100" stroke="#A78BFA" stroke-width="0.1"/>
                                    <line x1="70" y1="0" x2="30" y2="100" stroke="#A78BFA" stroke-width="0.1"/>
                                </svg>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#1A0A4A] to-transparent"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="relative z-10 text-white flex flex-col h-full">
                                <div class="font-bold text-[18px] leading-tight mb-auto">GIS<br>2024</div>
                                <div class="mt-auto">
                                    <h2 class="text-[28px] font-bold leading-tight mb-2 tracking-wide">GLOBAL INNOVATION<br>SUMMIT 2024</h2>
                                    <p class="text-[13px] text-gray-200 mb-5 font-medium">May 15 - 17, 2024 | San Francisco, CA</p>
                                    <button class="bg-[#5B32F6] text-white px-6 py-2.5 rounded-[6px] text-[13px] font-semibold hover:bg-[#4a26d1] transition-colors border-none shadow-sm">Explore Event</button>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-8 flex-1">
                            <h3 class="text-[15px] font-bold text-[#4C10D0] mb-3">About the Event</h3>
                            <p class="text-[13px] text-[#5B6B8A] leading-relaxed mb-8">Global Innovation Summit brings together technology leaders, innovators, and investors to explore the future of AI, Cloud, and Emerging Technologies.</p>

                            <h3 class="text-[15px] font-bold text-[#4C10D0] mb-5">Event Highlights</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <!-- Highlight 1 -->
                                <div class="flex items-start gap-3">
                                    <svg class="text-[#4C10D0] shrink-0 mt-0.5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1C1364] mb-0.5">3 Days</div>
                                        <div class="text-[11px] text-[#5B6B8A] whitespace-nowrap">May 15 - 17, 2024</div>
                                    </div>
                                </div>
                                <!-- Highlight 2 -->
                                <div class="flex items-start gap-3 border-l border-gray-100 pl-4">
                                    <svg class="text-[#4C10D0] shrink-0 mt-0.5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1C1364] mb-0.5">Grand Convention Center</div>
                                        <div class="text-[11px] text-[#5B6B8A] whitespace-nowrap">San Francisco, CA, USA</div>
                                    </div>
                                </div>
                                <!-- Highlight 3 -->
                                <div class="flex items-start gap-3 border-l border-gray-100 pl-4">
                                    <svg class="text-[#4C10D0] shrink-0 mt-0.5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1C1364] mb-0.5">1,500+</div>
                                        <div class="text-[11px] text-[#5B6B8A] whitespace-nowrap">Expected Attendees</div>
                                    </div>
                                </div>
                                <!-- Highlight 4 -->
                                <div class="flex items-start gap-3 border-l border-gray-100 pl-4">
                                    <svg class="text-[#4C10D0] shrink-0 mt-0.5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1C1364] mb-0.5">40+</div>
                                        <div class="text-[11px] text-[#5B6B8A]">Speakers</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-[#4C10D0] px-8 py-5 flex items-center justify-between shrink-0">
                            <span class="text-[12px] text-gray-200">© 2024 Global Innovation Summit. All rights reserved.</span>
                            <div class="flex items-center gap-5 text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="flex justify-end gap-3 mt-10">
                <a href="event-basic-details.html" class="px-8 py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-semibold hover:bg-gray-50 transition-colors shadow-sm inline-block">Back</a>
                <a href="ticket-setup.html" class="bg-[#5B32F6] text-white px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#4a26d1] transition-colors inline-block">Save & Continue</a>
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
