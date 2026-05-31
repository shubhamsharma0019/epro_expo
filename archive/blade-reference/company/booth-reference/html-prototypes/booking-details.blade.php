<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
</head>
<body class="bg-[#F8F9FC] text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen p-8">
        <div class="w-full mx-auto space-y-6">
            
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-[28px] font-bold text-[#1E1B4B] mb-2 tracking-tight">Booking Details</h1>
                <p class="text-gray-500 text-[15px]">View your booking information and invoice details.</p>
            </div>

            <!-- Top Cards Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Booth Preview -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 flex flex-col h-[400px]">
                    <h2 class="text-xl font-bold text-[#1E1B4B] mb-6">Booth Preview</h2>
                    <div class="flex-1 flex items-center justify-center bg-white">
                        <img src="./assets/images/booth_banner.png" alt="Booth Preview" class="max-w-full max-h-full object-contain">
                    </div>
                </div>

                <!-- Exhibition Info -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 flex flex-col h-[400px]">
                    <h2 class="text-xl font-bold text-[#1E1B4B] mb-8">Exhibition Info</h2>
                    <div class="space-y-10">
                        <div class="grid grid-cols-[100px_1fr] gap-12 items-start">
                            <span class="text-gray-600 text-[15px]">Event</span>
                            <span class="font-bold text-[#3D1B9B] text-[15px]">Innovation Expo 2024</span>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] gap-12 items-start">
                            <span class="text-gray-600 text-[15px]">Dates</span>
                            <span class="font-bold text-[#3D1B9B] text-[15px]">May 12 – May 17, 2024 (6 Days)</span>
                        </div>
                        <div class="grid grid-cols-[100px_1fr] gap-12 items-start">
                            <span class="text-gray-600 text-[15px]">Venue</span>
                            <div class="flex flex-col">
                                <span class="font-bold text-[#3D1B9B] text-[15px]">Biswa Bangla Mela Prangan,</span>
                                <span class="font-bold text-[#3D1B9B] text-[15px] mt-1">Kolkata, India</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Card Full Width -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 w-full">
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <p class="text-[14px] text-gray-600 mb-3">Pavilion</p>
                        <p class="font-bold text-[#1E1B4B] text-[15px]">Innovation Pavilion</p>
                    </div>
                    <div>
                        <p class="text-[14px] text-gray-600 mb-3">Hall</p>
                        <p class="font-bold text-[#1E1B4B] text-[15px]">Hall 1 – Tech & Innovation</p>
                    </div>
                    <div>
                        <p class="text-[14px] text-gray-600 mb-3">Booth No.</p>
                        <p class="font-bold text-[#1E1B4B] text-[15px]">12A</p>
                    </div>
                    <div>
                        <p class="text-[14px] text-gray-600 mb-3">Booth Size</p>
                        <p class="font-bold text-[#1E1B4B] text-[15px]">3m x 3m (9 sqm)</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Selected Services -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 flex flex-col h-full relative pb-16">
                    <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Selected Services (4)</h2>
                    <div class="space-y-5">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-[18px] h-[18px] bg-[#3D1B9B] rounded flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="font-bold text-[#1E1B4B] text-[14px]">Featured Listing</span>
                            </div>
                            <span class="font-bold text-[#1E1B4B] text-[15px]">$99</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-[18px] h-[18px] bg-[#3D1B9B] rounded flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="font-bold text-[#1E1B4B] text-[14px]">Email Campaign</span>
                            </div>
                            <span class="font-bold text-[#1E1B4B] text-[15px]">$149</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-[18px] h-[18px] bg-[#3D1B9B] rounded flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="font-bold text-[#1E1B4B] text-[14px]">Booth Cleaning (Daily)</span>
                            </div>
                            <span class="font-bold text-[#1E1B4B] text-[15px]">$49</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="w-[18px] h-[18px] bg-[#3D1B9B] rounded flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="font-bold text-[#1E1B4B] text-[14px]">Extra Power Supply</span>
                            </div>
                            <span class="font-bold text-[#1E1B4B] text-[15px]">$79</span>
                        </div>
                    </div>
                    <a href="#" class="absolute bottom-8 left-8 text-[#3D1B9B] font-bold text-[14px] hover:underline">View All Services</a>
                </div>

                <!-- Dates & Times -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 flex flex-col h-full">
                    <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Dates & Times</h2>
                    <div class="space-y-6">
                        <div>
                            <p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Setup Time</p>
                            <p class="text-gray-600 text-[14px]">May 12, 2024 | 8:00 AM – 4:00 PM</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Show Time</p>
                            <p class="text-gray-600 text-[14px]">May 13 – May 17, 2024 | 10:00 AM – 6:00 PM</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#3D1B9B] text-[15px] mb-2">Last Day</p>
                            <p class="text-gray-600 text-[14px]">May 17, 2024 | 10:00 AM – 4:00 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Payment & Status -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-8 flex flex-col h-full relative pb-16">
                    <h2 class="text-lg font-bold text-[#1E1B4B] mb-6">Payment & Status</h2>
                    <div class="space-y-5">
                        <div class="flex justify-between items-center">
                            <span class="text-[#1E1B4B] text-[15px]">Payment Status</span>
                            <span class="px-4 py-1.5 bg-[#E8F5E9] border border-[#A5D6A7] text-[#2E7D32] text-[13px] font-medium rounded-md">Paid</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#1E1B4B] text-[15px]">Booking Status</span>
                            <span class="px-4 py-1.5 bg-[#E8F5E9] border border-[#A5D6A7] text-[#2E7D32] text-[13px] font-medium rounded-md">Confirmed</span>
                        </div>
                        <div class="pt-2">
                            <p class="text-[#1E1B4B] text-[15px] mb-1">Invoice / Booking ID</p>
                            <p class="text-gray-600 text-[14px]">EXPO2024/INV/12A-001</p>
                        </div>
                        <div class="pt-1">
                            <p class="text-[#1E1B4B] text-[15px] mb-1">Amount Paid</p>
                            <p class="font-bold text-[#1E1B4B] text-[16px]">$457.00</p>
                        </div>
                    </div>
                    <a href="#" class="absolute bottom-8 left-8 text-[#3D1B9B] font-bold text-[14px] hover:underline">View Payment Receipt</a>
                </div>
            </div>

            <!-- Action Buttons at bottom -->
            <div class="flex justify-end gap-6 pt-6 mb-8 w-full md:w-2/3 ml-auto">
                <button class="w-1/2 py-3.5 border-2 border-[#E5E7EB] rounded-lg text-[#3D1B9B] font-bold text-[15px] hover:bg-gray-50 flex justify-center items-center transition-colors">
                    Download Invoice <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </button>
                <a href="setup-booth.html" class="w-1/2 py-3.5 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] flex justify-center items-center transition-colors">
                    Setup Booth <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </main>
</body>
</html>
