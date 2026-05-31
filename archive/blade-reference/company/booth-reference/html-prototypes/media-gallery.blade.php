<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Gallery | eproexpo</title>
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
                
                <!-- Step 1-5: Inactive/Completed -->
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

                <!-- Step 6: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">6</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Media</span>
                </div>

                <!-- Step 7-11: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Team</span>
                </div>
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
            <div class="w-full max-w-[1400px] mx-auto bg-white">
                
                <!-- Title Section -->
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Media Gallery</h1>
                <p class="text-[#6B7280] text-[15px] mb-8">Upload and manage images and videos to showcase your brand.</p>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-8">
                    <nav class="flex space-x-8">
                        <a href="#" class="border-b-2 border-[#3D1B9B] py-3 px-1 text-[15px] font-bold text-[#3D1B9B]">All Media</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[15px] font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Images (12)</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[15px] font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Videos (6)</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[15px] font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Documents (3)</a>
                        <a href="#" class="border-b-2 border-transparent py-3 px-1 text-[15px] font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">360° (2)</a>
                    </nav>
                </div>

                <!-- Top Grid Section (Upload + Stats) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
                    
                    <!-- Drag & Drop Area -->
                    <div class="lg:col-span-8 border-2 border-dashed border-[#8B5CF6] rounded-xl bg-white flex flex-col items-center justify-center text-center p-8 min-h-[240px]">
                        <div class="mb-4 text-[#3D1B9B]">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h3 class="text-[#1E1B4B] font-bold text-[16px] mb-2">Drag & drop files here or <span class="text-[#3D1B9B] cursor-pointer">click to upload</span></h3>
                        <p class="text-[#6B7280] text-[13px] mb-6">Supports: JPG, PNG, MP4, MOV up to 500MB</p>
                        <button class="px-6 py-2.5 border border-[#3D1B9B] rounded-lg text-[#3D1B9B] font-semibold text-[14px] hover:bg-purple-50 transition-colors bg-white">
                            Choose Files
                        </button>
                    </div>

                    <!-- Right Column Stats & Tips -->
                    <div class="lg:col-span-4 flex flex-col gap-4">
                        <!-- Storage Usage -->
                        <div class="border border-gray-100 rounded-xl bg-white p-5 shadow-sm">
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Storage Usage</h3>
                            <div class="flex justify-between items-end mb-2">
                                <p class="text-[14px]"><span class="font-bold text-[#1E1B4B]">2.3 GB</span> <span class="text-gray-500">/ 10 GB used</span></p>
                                <span class="text-[#1E1B4B] font-bold text-[14px]">23%</span>
                            </div>
                            <div class="w-full bg-[#F3F4F6] rounded-full h-2">
                                <div class="bg-[#3D1B9B] h-2 rounded-full" style="width: 23%"></div>
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="border border-gray-100 rounded-xl bg-white p-5 shadow-sm flex-1">
                            <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-3">Quick Tips</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <span class="text-[#3D1B9B] mr-2">•</span>
                                    <span class="text-[#4B5563] text-[13px]">Use high-resolution images (1920x1080)</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#3D1B9B] mr-2">•</span>
                                    <span class="text-[#4B5563] text-[13px]">Videos under 2 minutes perform best</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#3D1B9B] mr-2">•</span>
                                    <span class="text-[#4B5563] text-[13px]">Add alt text for better accessibility</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Recent Media Header Controls -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-[#1E1B4B] font-bold text-[18px]">Recent Media</h2>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Filter By -->
                        <div class="flex items-center">
                            <span class="text-gray-500 text-[13px] mr-2 font-medium">Filter By:</span>
                            <div class="relative w-[130px]">
                                <select class="block w-full pl-3 pr-8 py-1.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] font-medium appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                    <option>All Media</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div class="flex items-center">
                            <span class="text-gray-500 text-[13px] mr-2 font-medium">Sort By:</span>
                            <div class="relative w-[100px]">
                                <select class="block w-full pl-3 pr-8 py-1.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[13px] font-medium appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white cursor-pointer">
                                    <option>Latest</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- View Toggles -->
                        <div class="flex space-x-2">
                            <button class="w-9 h-9 flex items-center justify-center border border-[#3D1B9B] bg-[#F5F3FF] text-[#3D1B9B] rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </button>
                            <button class="w-9 h-9 flex items-center justify-center border border-gray-200 bg-white text-gray-400 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Media Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    
                    <!-- Item 1 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <img src="./assets/images/booth_banner.png" alt="Company Booth Front" class="w-full h-full object-cover">
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Image</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Company Booth Front</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 10, 2024 • 1.3 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 124</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#0F172A] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Product Showcase" class="w-full h-full object-cover opacity-80 mix-blend-screen">
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Image</div>
                            <!-- Duration Overlay (AI Artifact matched) -->
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[11px] font-bold px-1.5 py-0.5 rounded">01:15</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Product Showcase</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 9, 2024 • 2.4 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 98</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#050f29] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Booth Overview" class="w-full h-full object-cover opacity-60">
                                <!-- Center Play Button -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-black/40 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                        <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Image</div>
                            <!-- Duration Overlay -->
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[11px] font-bold px-1.5 py-0.5 rounded">01:15</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Booth Overview Wide</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 8, 2024 • 4.1 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 310</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#0a1638] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="360 Tour" class="w-full h-full object-cover opacity-70">
                                <!-- Center 360 Icon -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center border-2 border-white/50 bg-black/20 backdrop-blur-sm">
                                        <span class="text-white font-bold text-[14px]">360°</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">360°</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">360° Booth Tour</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 7, 2024 • 6.4 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 256</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 5 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#1e293b] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Team at Work" class="w-full h-full object-cover opacity-80 mix-blend-multiply">
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Image</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Team at Work</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 6, 2024 • 1.8 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 86</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 6 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#334155] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Product Clean-up" class="w-full h-full object-cover opacity-60 mix-blend-multiply grayscale">
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Video</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Product Clean-up</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 5, 2024 • 2.1 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 67</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 7 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#0a1532] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Demo Walkthrough" class="w-full h-full object-cover opacity-50">
                                <!-- Center Play Button -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-black/40 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                        <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Video</div>
                            <!-- Duration Overlay -->
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-[11px] font-bold px-1.5 py-0.5 rounded">02:10</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Demo Walkthrough</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 5, 2024 • 32.1 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 142</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                    <!-- Item 8 -->
                    <div class="border border-gray-100 rounded-xl bg-white overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative h-40 w-full overflow-hidden">
                            <div class="w-full h-full bg-[#1e293b] flex items-center justify-center relative">
                                <img src="./assets/images/booth_banner.png" alt="Factory Tour" class="w-full h-full object-cover opacity-70 mix-blend-multiply">
                            </div>
                            <!-- Badge -->
                            <div class="absolute top-2 left-2 bg-[#4C1D95] text-white text-[10px] font-bold px-2.5 py-1 rounded">Image</div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[#1E1B4B] font-bold text-[14px] truncate mb-1">Factory Tour</h4>
                            <p class="text-gray-500 text-[12px] mb-3">May 4, 2024 • 8.2 MB</p>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-500 text-[12px] font-medium">Views: 198</p>
                                <button class="text-gray-400 hover:text-[#3D1B9B]"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8 pb-4">
                    <!-- Navigates to Team Members and marks step 6 complete -->
                    <a href="team-members.html" onclick="if(window.markStepCompleted) window.markStepCompleted(6);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- Script to set active sidebar item specifically for this page to match the screenshot -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // We want to force the sidebar to show "Media" as active.
            // Wait for components.js to render the sidebar.
            setTimeout(() => {
                // Remove active styling from any existing links
                document.querySelectorAll('#sidebar-nav a').forEach(link => {
                    link.className = 'flex items-center px-4 py-3 text-[#6B7280] hover:bg-gray-50 hover:text-[#3D1B9B] transition-colors rounded-xl mb-1 font-medium';
                });
                
                // Try to find the Media link if it exists (it might not if components.js wasn't updated)
                const mediaLink = document.querySelector('#sidebar-nav a[data-page="media"]');
                if(mediaLink) {
                    mediaLink.className = 'flex items-center px-4 py-3 bg-[#F5F3FF] text-[#3D1B9B] font-bold rounded-xl mb-1 relative overflow-hidden';
                }
            }, 500);
        });
    </script>

</body>
</html>
