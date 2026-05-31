<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview in Visitor | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
</head>
<body class="bg-[#F9FAFB] text-gray-900 font-sans">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-[240px] bg-white border-r border-gray-100 flex flex-col z-20">
        <!-- Logo -->
        <div class="h-[80px] flex items-center px-6 border-b border-gray-100">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2C8.26801 2 2 8.26801 2 16C2 23.732 8.26801 30 16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2ZM16 28C9.37258 28 4 22.6274 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16C28 22.6274 22.6274 28 16 28Z" fill="#3D1B9B"/>
                    <path d="M22.5 11C22.5 12.3807 21.3807 13.5 20 13.5C18.6193 13.5 17.5 12.3807 17.5 11C17.5 9.61929 18.6193 8.5 20 8.5C21.3807 8.5 22.5 9.61929 22.5 11Z" fill="#F43F5E"/>
                    <path d="M13.5 21C13.5 22.3807 12.3807 23.5 11 23.5C9.61929 23.5 8.5 22.3807 8.5 21C8.5 19.6193 9.61929 18.5 11 18.5C12.3807 18.5 13.5 19.6193 13.5 21Z" fill="#F59E0B"/>
                </svg>
                <span class="text-[20px] font-bold text-[#1E1B4B]">epro<span class="text-[#3D1B9B]">expo</span></span>
            </div>
        </div>
        
        <!-- Menu Items -->
        <nav class="flex-1 mt-6 px-4 space-y-1 overflow-y-auto">
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Positions
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                Halls
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Book Booths
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                My Bookings
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Leads
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Products
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Media
            </a>
            <a href="#" class="flex items-center px-4 py-3 bg-[#F5F3FF] text-[#3D1B9B] transition-colors rounded-xl mb-1 font-bold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Sessions
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Support
            </a>
            
            <div class="mt-8 mb-4 border-t border-gray-100"></div>
            
            <a href="#" class="flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-4 font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </a>
        </nav>
    </aside>

    <!-- Top Navigation -->
    <header class="fixed top-0 left-[240px] right-0 h-[80px] bg-white border-b border-gray-100 flex items-center justify-between px-8 z-20">
        <!-- Center Nav -->
        <nav class="flex space-x-8">
            <a href="#" class="text-[#1E1B4B] font-bold text-[14px]">Explore Events</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Positions</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Halls</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Booths</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Features</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Pricing</a>
            <a href="#" class="text-[#6B7280] hover:text-[#1E1B4B] font-medium text-[14px]">Resources</a>
        </nav>
        
        <!-- Right Icons -->
        <div class="flex items-center space-x-6">
            <div class="flex items-center cursor-pointer">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                <span class="text-[#1E1B4B] font-bold text-[14px] mr-1">EN</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="flex items-center pl-6 border-l border-gray-200">
                <img src="./assets/images/avatar.png" alt="Profile" class="w-10 h-10 rounded-full border border-gray-200">
                <div class="ml-3">
                    <p class="text-[#1E1B4B] font-bold text-[14px] leading-tight">John Doe</p>
                    <p class="text-[#6B7280] text-[12px]">Exhibitor</p>
                </div>
                <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-[240px] pt-[80px] min-h-screen bg-[#F9FAFB] p-8">
        
        <div class="w-full max-w-[1200px] mx-auto bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            
            <!-- Top Header for Booth -->
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h2 class="text-[#1E1B4B] font-bold text-[20px]">Booth 12A</h2>
                </div>
                <button class="flex items-center px-5 py-2 border border-[#4C1D95] text-[#4C1D95] font-bold text-[14px] rounded-lg hover:bg-[#F5F3FF] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Preview in Visitor
                </button>
            </div>

            <!-- Banner Section -->
            <div class="w-full h-[320px] relative">
                <img src="./assets/images/booth_banner.png" alt="Booth Banner" class="w-full h-full object-cover">
            </div>

            <!-- Profile Info Section -->
            <div class="relative px-8 pb-6 border-b border-gray-100">
                
                <!-- Floating Logo Box -->
                <div class="absolute -top-16 left-8 w-32 h-32 bg-white rounded-2xl shadow-md border border-gray-100 flex items-center justify-center overflow-hidden z-10 p-4">
                    <div class="text-center leading-tight">
                        <span class="text-[#1E1B4B] font-black text-[22px] tracking-tight block">OMNIT</span>
                        <span class="text-[#1E1B4B] font-black text-[22px] tracking-tight block">WAVE</span>
                    </div>
                </div>

                <!-- Info and Buttons -->
                <div class="ml-[150px] pt-5 flex justify-between items-start">
                    <div>
                        <h1 class="text-[24px] font-bold text-[#1E1B4B] mb-1">Omnit Wave Technologies</h1>
                        <p class="text-[#6B7280] text-[14px] mb-2">Hall 1 - Tech & Innovation</p>
                        <div class="flex items-center">
                            <span class="text-[#1E1B4B] font-bold text-[14px] mr-3">Booth 12A</span>
                            <span class="bg-[#ECFDF5] text-[#059669] px-2.5 py-0.5 rounded-full text-[11px] font-bold flex items-center">
                                <span class="w-1.5 h-1.5 bg-[#059669] rounded-full mr-1.5"></span>
                                Live
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button class="bg-[#4C1D95] text-white px-4 py-2.5 rounded-lg font-bold text-[13px] flex items-center hover:bg-[#3b1774] transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Book Meeting
                        </button>
                        <button class="bg-white border border-gray-200 text-[#4C1D95] px-4 py-2.5 rounded-lg font-bold text-[13px] flex items-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Live Chat
                        </button>
                        <button class="bg-white border border-gray-200 text-[#4C1D95] px-4 py-2.5 rounded-lg font-bold text-[13px] flex items-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Brochure
                        </button>
                        <button class="bg-white border border-gray-200 text-[#4C1D95] px-4 py-2.5 rounded-lg font-bold text-[13px] flex items-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Watch Demo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="px-8 border-b border-gray-100 flex space-x-8">
                <a href="#" class="border-b-2 border-[#4C1D95] py-4 text-[14px] font-bold text-[#4C1D95]">Overview</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Products (3)</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Documents (4)</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Catalogues (2)</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Media (12)</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Team (4)</a>
                <a href="#" class="border-b-2 border-transparent py-4 text-[14px] font-medium text-gray-500 hover:text-gray-700">Sessions (4)</a>
            </div>

            <!-- Lower Content Area -->
            <div class="p-8">
                <p class="text-[#4B5563] text-[14px] leading-relaxed mb-8 max-w-5xl">
                    Omnit Wave Technologies delivers intelligent solutions that combine AI, IoT, and automation to help businesses innovate, optimize, and grow. Our technologies are trusted by global enterprises across industries.
                </p>

                <div class="grid grid-cols-12 gap-6">
                    
                    <!-- Row 1: Featured Products (span 7) & Top Documents (span 5) -->
                    
                    <!-- Featured Products -->
                    <div class="col-span-7 border border-gray-100 rounded-xl p-6">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Featured Products</h3>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <!-- Product 1 -->
                            <div class="border border-gray-100 rounded-lg overflow-hidden flex flex-col">
                                <div class="h-[100px] w-full bg-blue-900 overflow-hidden relative">
                                    <img src="./assets/images/booth_banner.png" alt="AI Platform" class="w-full h-full object-cover">
                                </div>
                                <div class="p-3 flex-1 bg-white">
                                    <h4 class="text-[#1E1B4B] font-bold text-[13px] mb-1">AI Platform</h4>
                                    <p class="text-[#6B7280] text-[11px] leading-tight">Intelligent analytics and automation.</p>
                                </div>
                            </div>
                            <!-- Product 2 -->
                            <div class="border border-gray-100 rounded-lg overflow-hidden flex flex-col">
                                <div class="h-[100px] w-full bg-blue-900 overflow-hidden relative">
                                    <img src="./assets/images/booth_banner.png" alt="IoT Gateway" class="w-full h-full object-cover">
                                </div>
                                <div class="p-3 flex-1 bg-white">
                                    <h4 class="text-[#1E1B4B] font-bold text-[13px] mb-1">IoT Gateway</h4>
                                    <p class="text-[#6B7280] text-[11px] leading-tight">Secure connectivity at scale.</p>
                                </div>
                            </div>
                            <!-- Product 3 -->
                            <div class="border border-gray-100 rounded-lg overflow-hidden flex flex-col">
                                <div class="h-[100px] w-full bg-blue-900 overflow-hidden relative">
                                    <img src="./assets/images/booth_banner.png" alt="Smart Automation" class="w-full h-full object-cover">
                                </div>
                                <div class="p-3 flex-1 bg-white">
                                    <h4 class="text-[#1E1B4B] font-bold text-[13px] mb-1">Smart Automation Suite</h4>
                                    <p class="text-[#6B7280] text-[11px] leading-tight">End to end process automation.</p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline">View All Products &gt;</a>
                    </div>

                    <!-- Top Documents -->
                    <div class="col-span-5 border border-gray-100 rounded-xl p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Top Documents</h3>
                            <div class="space-y-0">
                                <!-- Doc 1 -->
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        <span class="text-[#1E1B4B] font-bold text-[13px]">Company Profile</span>
                                    </div>
                                    <span class="text-[#6B7280] text-[12px]">PDF • 2.1 MB</span>
                                </div>
                                <!-- Doc 2 -->
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        <span class="text-[#1E1B4B] font-bold text-[13px]">Product Brochure</span>
                                    </div>
                                    <span class="text-[#6B7280] text-[12px]">PDF • 2.4 MB</span>
                                </div>
                                <!-- Doc 3 -->
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        <span class="text-[#1E1B4B] font-bold text-[13px]">Case Study 2024</span>
                                    </div>
                                    <span class="text-[#6B7280] text-[12px]">PDF • 1.8 MB</span>
                                </div>
                                <!-- Doc 4 -->
                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        <span class="text-[#1E1B4B] font-bold text-[13px]">Data Sheet</span>
                                    </div>
                                    <span class="text-[#6B7280] text-[12px]">PDF • 1.2 MB</span>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-4">View All Documents &gt;</a>
                    </div>

                    <!-- Row 2: Team (span 3), Sessions (span 4), Enquiry (span 5) -->

                    <!-- Team Highlights -->
                    <div class="col-span-3 border border-gray-100 rounded-xl p-6 h-full">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Team Highlights</h3>
                        <div class="flex -space-x-4 mb-4 justify-center py-4">
                            <img class="w-14 h-14 rounded-full border-2 border-white relative z-10" src="./assets/images/avatar.png" alt="Team 1">
                            <img class="w-14 h-14 rounded-full border-2 border-white relative z-20" src="./assets/images/avatar.png" alt="Team 2">
                            <img class="w-14 h-14 rounded-full border-2 border-white relative z-30" src="./assets/images/avatar.png" alt="Team 3">
                            <img class="w-14 h-14 rounded-full border-2 border-white relative z-40" src="./assets/images/avatar.png" alt="Team 4">
                        </div>
                    </div>

                    <!-- Upcoming Sessions -->
                    <div class="col-span-4 border border-gray-100 rounded-xl p-6 flex flex-col justify-between h-full">
                        <div>
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Upcoming Sessions</h3>
                            
                            <div class="space-y-6">
                                <!-- Session 1 -->
                                <div class="flex items-start">
                                    <div class="w-8 h-8 rounded bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center mr-4 flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[#6B7280] text-[12px] mb-1">May 11, 11:00 AM</p>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px] leading-tight">OMNIT WAVE - Products Deep Dive</h4>
                                    </div>
                                </div>

                                <!-- Session 2 -->
                                <div class="flex items-start">
                                    <div class="w-8 h-8 rounded bg-[#F5F3FF] text-[#6D28D9] flex items-center justify-center mr-4 flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[#6B7280] text-[12px] mb-1">May 14, 03:00 PM</p>
                                        <h4 class="text-[#1E1B4B] font-bold text-[13px] leading-tight">Intelligent Solutions for Smart Industries</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="text-[#4C1D95] text-[13px] font-bold text-center block w-full hover:underline mt-6">View All Sessions &gt;</a>
                    </div>

                    <!-- Send Enquiry -->
                    <div class="col-span-5 border border-gray-100 rounded-xl p-6 h-full flex flex-col">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Send Enquiry</h3>
                        <form class="flex-1 flex flex-col space-y-3">
                            <input type="text" placeholder="Your Name" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] placeholder-gray-400 text-[#1E1B4B]">
                            <input type="email" placeholder="Work Email" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] placeholder-gray-400 text-[#1E1B4B]">
                            <input type="text" placeholder="Company" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] placeholder-gray-400 text-[#1E1B4B]">
                            <textarea placeholder="Your Message..." class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] placeholder-gray-400 text-[#1E1B4B] flex-1 resize-none min-h-[80px]"></textarea>
                            <button type="button" class="w-full bg-[#4C1D95] text-white py-2.5 rounded-lg font-bold text-[14px] hover:bg-[#3b1774] transition-colors mt-2">
                                Send Message
                            </button>
                        </form>
                    </div>

                </div>

            </div>
            
            <!-- Bottom Action Buttons -->
            <div class="flex justify-end mt-10 border-t border-gray-100 pt-8 pb-4">
                <a href="publish.html" class="bg-[#4C1D95] text-white px-8 py-3 rounded-lg font-bold text-[14px] flex items-center hover:bg-[#3b1774] shadow-md transition-colors">
                    Save & Continue
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

    </main>

</body>
</html>
