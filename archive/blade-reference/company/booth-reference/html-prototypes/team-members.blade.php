<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen bg-white pb-12">
        
        <!-- Horizontal Steps Navigation -->
        <div class="w-full border-b border-gray-100 bg-white sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Step 1-6: Inactive/Completed -->
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

                <!-- Step 7: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Team</span>
                </div>

                <!-- Step 8-11: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Meetings</span>
                </div>
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">9</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Sessions</span>
                </div>
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
                
                <!-- Title & Header Actions Section -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Team Members</h1>
                        <p class="text-[#6B7280] text-[15px]">Add your team members who will represent your company at the event.</p>
                    </div>
                    <button class="bg-[#4C1D95] text-white px-6 py-2.5 rounded-lg font-semibold text-[14px] hover:bg-[#3b1774] transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Team Member
                    </button>
                </div>

                <!-- Table Section -->
                <div class="border border-gray-100 rounded-xl bg-white overflow-hidden">
                    
                    <!-- Header Row -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6 border-b border-gray-100">
                        <div class="col-span-4"><span class="text-[#1E1B4B] font-bold text-[14px]">Member</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Role & Expertise</span></div>
                        <div class="col-span-3"><span class="text-[#1E1B4B] font-bold text-[14px]">Contact</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Availability</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Actions</span></div>
                    </div>

                    <!-- Item 1: Rahul Mehta -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 mr-4 flex-shrink-0">
                                <img src="./assets/images/avatar.png" alt="Rahul Mehta" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Rahul Mehta</h4>
                                <p class="text-[#6B7280] text-[13px]">Business Development<br>Manager</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-start">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] text-[#6D28D9] font-bold text-[11px] rounded-md">Business Dev</span>
                            <span class="inline-flex px-3 py-1 bg-white border border-gray-200 text-[#6B7280] font-medium text-[11px] rounded-md">Partnerships</span>
                        </div>
                        <div class="col-span-3 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">rahul.mehta@omnitwave.com</p>
                            <p class="text-[#4B5563] text-[13px]">+1 (415) 555-0123</p>
                        </div>
                        <div class="col-span-2 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">May 12 – May 17, 2024</p>
                            <p class="text-[#4B5563] text-[13px]">10:00 AM – 6:00 PM</p>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#6D28D9] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 2: Ananya Singh -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 mr-4 flex-shrink-0">
                                <img src="./assets/images/avatar.png" alt="Ananya Singh" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Ananya Singh</h4>
                                <p class="text-[#6B7280] text-[13px]">Product Specialist</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-start">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] text-[#6D28D9] font-bold text-[11px] rounded-md">Product Demo</span>
                            <span class="inline-flex px-3 py-1 bg-white border border-gray-200 text-[#6B7280] font-medium text-[11px] rounded-md">Technical</span>
                        </div>
                        <div class="col-span-3 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">ananya.singh@omnitwave.com</p>
                            <p class="text-[#4B5563] text-[13px]">+1 (415) 555-0187</p>
                        </div>
                        <div class="col-span-2 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">May 11 – May 17, 2024</p>
                            <p class="text-[#4B5563] text-[13px]">09:00 AM – 5:00 PM</p>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#6D28D9] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 3: Vikram Rao -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 mr-4 flex-shrink-0">
                                <img src="./assets/images/avatar.png" alt="Vikram Rao" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Vikram Rao</h4>
                                <p class="text-[#6B7280] text-[13px]">Solutions Architect</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-start">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] text-[#6D28D9] font-bold text-[11px] rounded-md">Solutions</span>
                            <span class="inline-flex px-3 py-1 bg-white border border-gray-200 text-[#6B7280] font-medium text-[11px] rounded-md">Consulting</span>
                        </div>
                        <div class="col-span-3 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">vikram.rao@omnitwave.com</p>
                            <p class="text-[#4B5563] text-[13px]">+1 (415) 555-0165</p>
                        </div>
                        <div class="col-span-2 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">May 11 – May 17, 2024</p>
                            <p class="text-[#4B5563] text-[13px]">11:00 AM – 7:00 PM</p>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#6D28D9] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 4: Priya Nair -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6 border-b border-gray-100">
                        <div class="col-span-4 flex items-center pr-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 mr-4 flex-shrink-0">
                                <img src="./assets/images/avatar.png" alt="Priya Nair" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Priya Nair</h4>
                                <p class="text-[#6B7280] text-[13px]">Marketing Manager</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-start">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] text-[#6D28D9] font-bold text-[11px] rounded-md">Marketing</span>
                            <span class="inline-flex px-3 py-1 bg-white border border-gray-200 text-[#6B7280] font-medium text-[11px] rounded-md">Content</span>
                        </div>
                        <div class="col-span-3 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">priya.nair@omnitwave.com</p>
                            <p class="text-[#4B5563] text-[13px]">+1 (415) 555-0110</p>
                        </div>
                        <div class="col-span-2 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">May 12 – May 16, 2024</p>
                            <p class="text-[#4B5563] text-[13px]">10:00 AM – 4:00 PM</p>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#6D28D9] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 5: Arjun Das -->
                    <div class="grid grid-cols-12 gap-4 items-center p-6">
                        <div class="col-span-4 flex items-center pr-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 mr-4 flex-shrink-0">
                                <img src="./assets/images/avatar.png" alt="Arjun Das" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[14px] mb-0.5">Arjun Das</h4>
                                <p class="text-[#6B7280] text-[13px]">Customer Success Lead</p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-start">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] text-[#6D28D9] font-bold text-[11px] rounded-md">Customer Success</span>
                            <span class="inline-flex px-3 py-1 bg-white border border-gray-200 text-[#6B7280] font-medium text-[11px] rounded-md">Client Relations</span>
                        </div>
                        <div class="col-span-3 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">arjun.das@omnitwave.com</p>
                            <p class="text-[#4B5563] text-[13px]">+1 (415) 555-0144</p>
                        </div>
                        <div class="col-span-2 pr-2">
                            <p class="text-[#4B5563] text-[13px] mb-1.5">May 13 – May 17, 2024</p>
                            <p class="text-[#4B5563] text-[13px]">09:00 AM – 6:00 PM</p>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#6D28D9] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-[#EF4444] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Bar -->
                <div class="mt-8 border border-gray-100 rounded-xl bg-[#FAFAFA] p-6 flex flex-col md:flex-row justify-between items-center gap-6">
                    <!-- Total Members -->
                    <div class="flex items-center w-full md:w-1/3 border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0 md:pr-6">
                        <div class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#3D1B9B] mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[13px] mb-1">Total Members</p>
                            <p class="text-[#1E1B4B] font-bold text-[24px] leading-none">5</p>
                        </div>
                    </div>

                    <!-- Active For Event -->
                    <div class="flex items-center w-full md:w-1/3 border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0 md:px-6">
                        <div class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#10B981] mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 3l-1.5 1.5M17.5 4.5L16 3M21 8l-1.5-1.5M17.5 6.5L16 8"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[13px] mb-1">Active For Event</p>
                            <p class="text-[#1E1B4B] font-bold text-[24px] leading-none">5</p>
                        </div>
                    </div>

                    <!-- Time Zone -->
                    <div class="flex items-center w-full md:w-1/3 md:pl-6">
                        <div class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#3D1B9B] mr-4 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[#6B7280] text-[13px] mb-1">Time Zone</p>
                            <p class="text-[#1E1B4B] font-bold text-[15px]">(GMT +05:30) Asia/Kolkata</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8 pb-4">
                    <!-- Navigates to Meetings and marks step 7 complete -->
                    <a href="meetings.html" onclick="if(window.markStepCompleted) window.markStepCompleted(7);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
