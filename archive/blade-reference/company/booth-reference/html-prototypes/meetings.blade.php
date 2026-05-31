<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Meeting Availability | eproexpo</title>
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
        <div class="w-full border-b border-gray-100 bg-[#F9FAFB] sticky top-[80px] z-10 px-8 py-4">
            <div class="flex items-center space-x-3 overflow-x-auto pb-1 scrollbar-hide">
                
                <!-- Steps 1-7: Inactive/Completed -->
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

                <!-- Step 8: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-[#F5F3FF] flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Meetings</span>
                </div>

                <!-- Steps 9-11: Inactive -->
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
                
                <!-- Title Section -->
                <div class="mb-8">
                    <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Setup Meeting Availability</h1>
                    <p class="text-[#6B7280] text-[15px]">Define your available time slots for meetings during the event.</p>
                </div>

                <!-- Top Row (Calendar & Available Days) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                    
                    <!-- Select Dates Card -->
                    <div class="md:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Select Dates</h3>
                        
                        <!-- Calendar Header -->
                        <div class="flex justify-between items-center mb-6 px-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <span class="text-[#1E1B4B] font-bold text-[14px]">May 2024</span>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>

                        <!-- Days of week -->
                        <div class="grid grid-cols-7 text-center mb-4">
                            <div class="text-[13px] text-gray-400 font-medium">Su</div>
                            <div class="text-[13px] text-gray-400 font-medium">Mo</div>
                            <div class="text-[13px] text-gray-400 font-medium">Tu</div>
                            <div class="text-[13px] text-gray-400 font-medium">We</div>
                            <div class="text-[13px] text-gray-400 font-medium">Th</div>
                            <div class="text-[13px] text-gray-400 font-medium">Fr</div>
                            <div class="text-[13px] text-gray-400 font-medium">Sa</div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="grid grid-cols-7 text-center gap-y-4 text-[14px] font-medium mb-8">
                            <!-- Row 1 -->
                            <div class="text-gray-300 py-1.5">28</div>
                            <div class="text-gray-300 py-1.5">29</div>
                            <div class="text-gray-300 py-1.5">30</div>
                            <div class="text-[#1E1B4B] py-1.5">1</div>
                            <div class="text-[#1E1B4B] py-1.5">2</div>
                            <div class="text-[#1E1B4B] py-1.5">3</div>
                            <div class="text-[#1E1B4B] py-1.5">4</div>

                            <!-- Row 2 -->
                            <div class="text-[#1E1B4B] py-1.5">5</div>
                            <div class="text-[#1E1B4B] py-1.5">6</div>
                            <div class="text-[#1E1B4B] py-1.5">7</div>
                            <div class="text-[#1E1B4B] py-1.5">8</div>
                            <div class="text-[#1E1B4B] py-1.5">9</div>
                            <div class="text-[#1E1B4B] py-1.5">10</div>
                            <div class="py-1.5 flex justify-center">
                                <div class="w-8 h-8 rounded-full bg-[#4C1D95] text-white flex items-center justify-center">11</div>
                            </div>

                            <!-- Row 3 (Selected Range) -->
                            <div class="bg-[#4C1D95] text-white py-1.5 rounded-l-full">12</div>
                            <div class="bg-[#4C1D95] text-white py-1.5">13</div>
                            <div class="bg-[#4C1D95] text-white py-1.5">14</div>
                            <div class="bg-[#4C1D95] text-white py-1.5">15</div>
                            <div class="bg-[#4C1D95] text-white py-1.5">16</div>
                            <div class="bg-[#4C1D95] text-white py-1.5 rounded-r-full">17</div>
                            <div class="text-[#1E1B4B] py-1.5">18</div>

                            <!-- Row 4 -->
                            <div class="text-[#1E1B4B] py-1.5">19</div>
                            <div class="text-[#1E1B4B] py-1.5">20</div>
                            <div class="text-[#1E1B4B] py-1.5">21</div>
                            <div class="text-[#1E1B4B] py-1.5">22</div>
                            <div class="text-[#1E1B4B] py-1.5">23</div>
                            <div class="text-[#1E1B4B] py-1.5">24</div>
                            <div class="text-[#1E1B4B] py-1.5">25</div>

                            <!-- Row 5 -->
                            <div class="text-[#1E1B4B] py-1.5">26</div>
                            <div class="text-[#1E1B4B] py-1.5">27</div>
                            <div class="text-[#1E1B4B] py-1.5">28</div>
                            <div class="text-[#1E1B4B] py-1.5">29</div>
                            <div class="text-[#1E1B4B] py-1.5">30</div>
                            <div class="text-[#1E1B4B] py-1.5">31</div>
                            <div class="text-gray-300 py-1.5">1</div>
                        </div>

                        <!-- Calendar Legend -->
                        <div class="flex items-center space-x-6 text-[13px] px-2">
                            <div class="flex items-center">
                                <div class="w-3.5 h-3.5 rounded-sm bg-[#4C1D95] mr-2"></div>
                                <span class="text-[#6B7280]">Selected Range</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3.5 h-3.5 rounded-sm bg-[#E5E7EB] mr-2"></div>
                                <span class="text-[#6B7280]">Unavailable</span>
                            </div>
                        </div>
                    </div>

                    <!-- Available Days Card -->
                    <div class="md:col-span-7 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Available Days</h3>
                        
                        <div class="flex-1 flex flex-col justify-between">
                            <!-- Sunday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 border border-gray-300 rounded flex items-center justify-center mr-3"></div>
                                    <span class="text-[#4B5563] text-[14px]">Sunday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-gray-400 text-[13px] appearance-none focus:outline-none bg-white cursor-not-allowed">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Monday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-[#4C1D95] rounded flex items-center justify-center mr-3">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[#1E1B4B] text-[14px] font-medium">Monday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuesday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-[#4C1D95] rounded flex items-center justify-center mr-3">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[#1E1B4B] text-[14px] font-medium">Tuesday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Wednesday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-[#4C1D95] rounded flex items-center justify-center mr-3">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[#1E1B4B] text-[14px] font-medium">Wednesday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Thursday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-[#4C1D95] rounded flex items-center justify-center mr-3">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[#1E1B4B] text-[14px] font-medium">Thursday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Friday -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-[#4C1D95] rounded flex items-center justify-center mr-3">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[#1E1B4B] text-[14px] font-medium">Friday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Saturday -->
                            <div class="flex items-center justify-between py-3">
                                <label class="flex items-center cursor-pointer">
                                    <div class="w-5 h-5 border border-gray-300 rounded flex items-center justify-center mr-3"></div>
                                    <span class="text-[#4B5563] text-[14px]">Saturday</span>
                                </label>
                                <div class="relative w-[180px]">
                                    <select class="block w-full pl-3 pr-8 py-2 border border-gray-200 rounded-lg text-gray-400 text-[13px] appearance-none focus:outline-none bg-white cursor-not-allowed">
                                        <option>09:00 AM – 06:00 PM</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row (Settings, Time Slots, Summary) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    
                    <!-- Meeting Settings Card -->
                    <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Meeting Settings</h3>
                        
                        <!-- Meeting Type -->
                        <div class="mb-5">
                            <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Meeting Type</label>
                            <div class="flex space-x-2">
                                <button class="flex-1 flex items-center justify-center border border-[#4C1D95] bg-[#F5F3FF] text-[#4C1D95] rounded-lg py-2 text-[13px] font-bold">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Video
                                </button>
                                <button class="flex-1 flex items-center justify-center border border-gray-200 bg-white text-gray-500 rounded-lg py-2 text-[13px] font-medium hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Audio
                                </button>
                                <button class="flex-1 flex items-center justify-center border border-gray-200 bg-white text-gray-500 rounded-lg py-2 text-[13px] font-medium hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Chat
                                </button>
                            </div>
                        </div>

                        <!-- Slot Duration -->
                        <div class="mb-5">
                            <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Slot Duration</label>
                            <div class="relative">
                                <select class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                    <option>30 Minutes</option>
                                    <option>15 Minutes</option>
                                    <option>45 Minutes</option>
                                    <option>60 Minutes</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Buffer Time -->
                        <div class="mb-5">
                            <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Buffer Time</label>
                            <div class="relative">
                                <select class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                    <option>10 Minutes</option>
                                    <option>5 Minutes</option>
                                    <option>15 Minutes</option>
                                    <option>0 Minutes</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Assign to Team Member -->
                        <div>
                            <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Assign to Team Member</label>
                            <div class="relative">
                                <select class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                    <option>Any Available Member</option>
                                    <option>Rahul Mehta</option>
                                    <option>Ananya Singh</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Time Slots Card -->
                    <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Daily Time Slots</h3>
                        
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            
                            <!-- Morning -->
                            <div>
                                <div class="text-center mb-3">
                                    <h4 class="text-[#1E1B4B] font-bold text-[11px]">Morning</h4>
                                    <p class="text-gray-400 text-[9px] uppercase tracking-wide">09:00 AM – 12:00 PM</p>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">09:00 AM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">09:30 AM</button>
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">10:00 AM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">10:30 AM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">11:00 AM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">11:30 AM</button>
                                </div>
                            </div>

                            <!-- Afternoon -->
                            <div>
                                <div class="text-center mb-3">
                                    <h4 class="text-[#1E1B4B] font-bold text-[11px]">Afternoon</h4>
                                    <p class="text-gray-400 text-[9px] uppercase tracking-wide">12:00 PM – 05:00 PM</p>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">12:00 PM</button>
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">12:30 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">01:00 PM</button>
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">01:30 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">02:00 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">02:30 PM</button>
                                </div>
                            </div>

                            <!-- Evening -->
                            <div>
                                <div class="text-center mb-3">
                                    <h4 class="text-[#1E1B4B] font-bold text-[11px]">Evening</h4>
                                    <p class="text-gray-400 text-[9px] uppercase tracking-wide">05:00 PM – 08:00 PM</p>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">05:00 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">05:30 PM</button>
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">06:00 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">06:30 PM</button>
                                    <button class="w-full py-1.5 bg-[#4C1D95] text-white text-[12px] font-bold rounded">07:00 PM</button>
                                    <button class="w-full py-1.5 border border-gray-200 text-[#1E1B4B] text-[12px] font-medium rounded hover:border-[#4C1D95]">07:30 PM</button>
                                </div>
                            </div>
                        </div>

                        <!-- Slots Legend -->
                        <div class="flex items-center space-x-6 text-[12px] mt-auto pt-4">
                            <div class="flex items-center">
                                <div class="w-3.5 h-3.5 rounded bg-[#4C1D95] mr-2"></div>
                                <span class="text-[#6B7280]">Available</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3.5 h-3.5 rounded border border-gray-300 mr-2"></div>
                                <span class="text-[#6B7280]">Unavailable</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Summary Card -->
                    <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Selected Summary</h3>
                            
                            <div class="space-y-4">
                                <!-- Dates -->
                                <div class="flex justify-between items-start border-b border-gray-50 pb-4">
                                    <span class="text-[#6B7280] text-[13px]">Dates</span>
                                    <div class="text-right">
                                        <p class="text-[#4B5563] text-[13px] mb-1">May 11 – May 17, 2024</p>
                                        <p class="text-gray-400 text-[12px]">7 Days</p>
                                    </div>
                                </div>
                                
                                <!-- Daily Slots -->
                                <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                    <span class="text-[#6B7280] text-[13px]">Daily Slots</span>
                                    <span class="text-[#4B5563] text-[13px]">22 Slots</span>
                                </div>

                                <!-- Slot Duration -->
                                <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                    <span class="text-[#6B7280] text-[13px]">Slot Duration</span>
                                    <span class="text-[#4B5563] text-[13px]">30 Minutes</span>
                                </div>

                                <!-- Buffer Time -->
                                <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                    <span class="text-[#6B7280] text-[13px]">Buffer Time</span>
                                    <span class="text-[#4B5563] text-[13px]">10 Minutes</span>
                                </div>

                                <!-- Total Availability -->
                                <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                    <span class="text-[#6B7280] text-[13px]">Total Availability</span>
                                    <span class="text-[#4B5563] text-[13px]">11:00 Hours</span>
                                </div>

                                <!-- Assigned To -->
                                <div class="flex justify-between items-start pb-4">
                                    <span class="text-[#6B7280] text-[13px] flex-shrink-0 mr-4">Assigned To</span>
                                    <span class="text-[#4B5563] text-[13px] text-right">All Teams (GMT +05:30 Asia/Kolkata)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-6">
                            <button class="w-full bg-[#4C1D95] text-white py-3 rounded-lg font-bold text-[14px] hover:bg-[#3b1774] transition-colors">
                                Save Availability
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Bottom Action Buttons for next step (Requested by user) -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8">
                    <!-- Navigates to Sessions and marks step 8 complete -->
                    <a href="sessions.html" onclick="if(window.markStepCompleted) window.markStepCompleted(8);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
