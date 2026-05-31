<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Demos & Sessions | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-[#F9FAFB] text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen bg-[#F9FAFB] pb-12">
        
        <!-- Horizontal Steps Navigation -->
        <div class="w-full border-b border-gray-100 bg-white sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Steps 1-8: Inactive/Completed -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">1</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Profile</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">2</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Branding</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">3</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Products</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">4</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Documents</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">5</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Catalogues</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">6</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Media</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Team</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Meetings</span>
                </div>

                <!-- Step 9: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-[#F5F3FF] flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">9</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Sessions</span>
                </div>

                <!-- Steps 10-11: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">10</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Preview</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">11</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Publish</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="w-full max-w-[1400px] mx-auto border border-gray-100 rounded-2xl p-8 bg-white shadow-sm">
                
                <!-- Title & Action Section -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Live Demos & Sessions</h1>
                        <p class="text-[#6B7280] text-[15px]">Create and manage live demos, webinars, and product sessions.</p>
                    </div>
                    <button class="bg-[#4C1D95] text-white px-6 py-2.5 rounded-lg font-bold text-[14px] hover:bg-[#3b1774] transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                        Create New Session
                    </button>
                </div>

                <!-- Tabs & Filters -->
                <div class="flex justify-between items-end border-b border-gray-200 mb-6 pb-2">
                    <nav class="flex space-x-8">
                        <a href="#" class="border-b-2 border-[#4C1D95] py-3 px-1 text-[14px] font-bold text-[#4C1D95] mb-[-10px]">All Sessions</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[14px] font-medium text-gray-500 hover:text-gray-700 mb-[-10px]">Upcoming (4)</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[14px] font-medium text-gray-500 hover:text-gray-700 mb-[-10px]">Live (1)</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[14px] font-medium text-gray-500 hover:text-gray-700 mb-[-10px]">Completed (3)</a>
                    </nav>
                    <div class="flex items-center pb-2">
                        <span class="text-gray-500 text-[13px] mr-2 font-medium">Sort by:</span>
                        <div class="relative w-[140px]">
                            <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] font-medium appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                <option>Upcoming</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="border border-gray-100 rounded-xl bg-white overflow-hidden mb-6">
                    
                    <!-- Header Row -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4"><span class="text-[#1E1B4B] font-bold text-[14px]">Session Details</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Date & Time</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Speaker</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Type</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Attendees</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Status</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Actions</span></div>
                    </div>

                    <!-- Item 1: OMNIT WAVE -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">OMNIT WAVE - Product Deep Dive</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">Explore key features and real-world use cases.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 17, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">11:00 AM – 11:45 AM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Rahul Mehta</p>
                            <p class="text-[#6B7280] text-[12px]">Product Specialist</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] border border-[#DDD6FE] text-[#6D28D9] font-bold text-[11px] rounded-md">Live Demo</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">42</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EEF2FF] border border-[#C7D2FE] text-[#4338CA] font-bold text-[11px] rounded-md">Upcoming</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 2: Intelligent Solutions -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Intelligent Solutions for Smart Industries</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">How AI drives tech-forward operations.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 18, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">10:00 AM – 10:45 AM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Vikram Rao</p>
                            <p class="text-[#6B7280] text-[12px]">Solutions Architect</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EFF6FF] border border-[#BFDBFE] text-[#2563EB] font-bold text-[11px] rounded-md">Webinar</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">48</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EEF2FF] border border-[#C7D2FE] text-[#4338CA] font-bold text-[11px] rounded-md">Upcoming</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 3: Customer Success Stories -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#FFFBEB] text-[#D97706] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Customer Success Stories</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">Real world results from our customers.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 18, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">12:30 PM – 1:30 PM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Rahul Mehta</p>
                            <p class="text-[#6B7280] text-[12px]">BD Manager</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#FEF3C7] border border-[#FDE68A] text-[#D97706] font-bold text-[11px] rounded-md">Talk</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">31</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EEF2FF] border border-[#C7D2FE] text-[#4338CA] font-bold text-[11px] rounded-md">Upcoming</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 4: Ask the Experts -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Ask the Experts - Live Q&A</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">Get your questions answered live.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 18, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">04:00 PM – 04:45 PM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Priya Nair</p>
                            <p class="text-[#6B7280] text-[12px]">Marketing Manager</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EFF6FF] border border-[#BFDBFE] text-[#2563EB] font-bold text-[11px] rounded-md">Q&A</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">25</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#ECFDF5] border border-[#A7F3D0] text-[#059669] font-bold text-[11px] rounded-md">Live</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 5: Platform Walkthrough -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Platform Walkthrough</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">A quick tour of the platform.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 16, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">11:00 AM – 11:30 AM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Ananya Singh</p>
                            <p class="text-[#6B7280] text-[12px]">Product Specialist</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] border border-[#DDD6FE] text-[#6D28D9] font-bold text-[11px] rounded-md">Live Demo</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">56</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#ECFDF5] border border-[#A7F3D0] text-[#059669] font-bold text-[11px] rounded-md">Completed</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 6: Innovation Showcase -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5">
                        <div class="col-span-4 flex items-center pr-2">
                            <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Innovation Showcase</h4>
                                <p class="text-[#6B7280] text-[13px] truncate">Highlighting the latest innovations.</p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1">May 15, 2024</p>
                            <p class="text-[#6B7280] text-[12px]">01:00 PM – 01:45 PM</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#4B5563] text-[13px] mb-1 font-medium">Vikram Rao</p>
                            <p class="text-[#6B7280] text-[12px]">Solutions Architect</p>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#EFF6FF] border border-[#BFDBFE] text-[#2563EB] font-bold text-[11px] rounded-md">Webinar</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px] font-medium">72</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="inline-flex px-3 py-1 bg-[#ECFDF5] border border-[#A7F3D0] text-[#059669] font-bold text-[11px] rounded-md">Completed</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#4338CA] hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer / Pagination -->
                <div class="flex justify-between items-center pb-4">
                    <p class="text-[#6B7280] text-[14px]">Showing 1 to 6 of 6 sessions</p>
                    <div class="flex space-x-2">
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-[#4C1D95] text-white font-bold text-[13px]">
                            1
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Bottom Action Buttons for next step (adding to match flow) -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8">
                    <!-- Navigates to Preview and marks step 9 complete -->
                    <a href="preview.html" onclick="if(window.markStepCompleted) window.markStepCompleted(9);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
