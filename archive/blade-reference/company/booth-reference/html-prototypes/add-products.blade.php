<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | eproexpo</title>
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
                
                <!-- Step 1: Inactive style for screenshot match -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">1</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Profile</span>
                </div>
                
                <!-- Step 2: Inactive style for screenshot match -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">2</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Branding</span>
                </div>
                
                <!-- Step 3: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">3</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Products</span>
                </div>
                
                <!-- Step 4: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">4</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Documents</span>
                </div>

                <!-- Step 5: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">5</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Catalogues</span>
                </div>

                <!-- Step 6: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">6</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Media</span>
                </div>

                <!-- Step 7: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">7</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Team</span>
                </div>

                <!-- Step 8: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">8</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Meetings</span>
                </div>

                <!-- Step 9: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">9</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Sessions</span>
                </div>

                <!-- Step 10: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">10</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Preview</span>
                </div>

                <!-- Step 11: Inactive -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">11</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Publish</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="w-full max-w-[1400px] mx-auto border border-gray-100 rounded-2xl p-8 bg-white shadow-sm">
                
                <!-- Title Section -->
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Products</h1>
                <p class="text-[#6B7280] text-[15px] mb-8">Add products or services to showcase in your booth.</p>

                <!-- Top Controls -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto flex-1">
                        <!-- Search -->
                        <div class="relative w-full md:w-[320px]">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg text-gray-900 text-[14px] focus:ring-[#3D1B9B] focus:border-[#3D1B9B] outline-none" placeholder="Search products...">
                        </div>
                        
                        <!-- Filter -->
                        <div class="relative w-full md:w-[240px]">
                            <select class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] font-medium appearance-none focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] focus:border-[#3D1B9B] bg-white cursor-pointer">
                                <option>All Categories</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add Button -->
                    <button class="w-full md:w-auto px-6 py-2.5 bg-[#3D1B9B] text-white rounded-lg font-bold text-[14px] hover:bg-[#31167D] transition-colors flex items-center justify-center">
                        Add Product <span class="ml-2 text-lg leading-none">+</span>
                    </button>
                </div>

                <!-- Products List -->
                <div class="border border-gray-100 rounded-xl overflow-hidden bg-white">
                    
                    <!-- Item 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center p-6 border-b border-gray-100">
                        <div class="md:col-span-6 flex items-center space-x-5">
                            <img src="./assets/images/booth_banner.png" class="w-28 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-100" alt="Product Image">
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[15px] mb-1">AI Predictive Analytics Platform</h4>
                                <p class="text-[#6B7280] text-[13px] leading-relaxed pr-4">Real-time analytics and forecasting platform powered by machine learning.</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Category</p>
                            <p class="text-[#3D1B9B] font-semibold text-[14px]">Software</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Status</p>
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Published</span>
                        </div>
                        <div class="md:col-span-1">
                            <p class="text-[#6B7280] text-[13px] mb-1">Views</p>
                            <p class="text-[#1E1B4B] font-bold text-[16px]">245</p>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button class="text-[#3D1B9B] hover:bg-purple-50 p-2 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center p-6 border-b border-gray-100">
                        <div class="md:col-span-6 flex items-center space-x-5">
                            <img src="./assets/images/booth_banner.png" class="w-28 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-100" alt="Product Image">
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[15px] mb-1">Smart Automation Suite</h4>
                                <p class="text-[#6B7280] text-[13px] leading-relaxed pr-4">End-to-end automation for business process optimization.</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Category</p>
                            <p class="text-[#3D1B9B] font-semibold text-[14px]">Solution</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Status</p>
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Published</span>
                        </div>
                        <div class="md:col-span-1">
                            <p class="text-[#6B7280] text-[13px] mb-1">Views</p>
                            <p class="text-[#1E1B4B] font-bold text-[16px]">189</p>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button class="text-[#3D1B9B] hover:bg-purple-50 p-2 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center p-6 border-b border-gray-100">
                        <div class="md:col-span-6 flex items-center space-x-5">
                            <img src="./assets/images/booth_banner.png" class="w-28 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-100" alt="Product Image">
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[15px] mb-1">Data Insight Dashboard</h4>
                                <p class="text-[#6B7280] text-[13px] leading-relaxed pr-4">Interactive dashboards with actionable business insights.</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Category</p>
                            <p class="text-[#3D1B9B] font-semibold text-[14px]">Software</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Status</p>
                            <span class="inline-flex px-5 py-1 bg-[#F9FAFB] border border-[#D1D5DB] text-[#3D1B9B] font-bold text-[12px] rounded-md">Draft</span>
                        </div>
                        <div class="md:col-span-1">
                            <p class="text-[#6B7280] text-[13px] mb-1">Views</p>
                            <p class="text-[#1E1B4B] font-bold text-[16px]">98</p>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button class="text-[#3D1B9B] hover:bg-purple-50 p-2 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center p-6 border-b border-gray-100">
                        <div class="md:col-span-6 flex items-center space-x-5">
                            <img src="./assets/images/booth_banner.png" class="w-28 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-100" alt="Product Image">
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[15px] mb-1">Cloud Integration Services</h4>
                                <p class="text-[#6B7280] text-[13px] leading-relaxed pr-4">Seamless cloud integration for scalable and secure operations.</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Category</p>
                            <p class="text-[#3D1B9B] font-semibold text-[14px]">Service</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Status</p>
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Published</span>
                        </div>
                        <div class="md:col-span-1">
                            <p class="text-[#6B7280] text-[13px] mb-1">Views</p>
                            <p class="text-[#1E1B4B] font-bold text-[16px]">132</p>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button class="text-[#3D1B9B] hover:bg-purple-50 p-2 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 5 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center p-6">
                        <div class="md:col-span-6 flex items-center space-x-5">
                            <img src="./assets/images/booth_banner.png" class="w-28 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-100" alt="Product Image">
                            <div>
                                <h4 class="text-[#1E1B4B] font-bold text-[15px] mb-1">AI Chatbot Assistant</h4>
                                <p class="text-[#6B7280] text-[13px] leading-relaxed pr-4">Intelligent chatbot solution for customer engagement and support.</p>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Category</p>
                            <p class="text-[#3D1B9B] font-semibold text-[14px]">Solution</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[#6B7280] text-[13px] mb-1">Status</p>
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Published</span>
                        </div>
                        <div class="md:col-span-1">
                            <p class="text-[#6B7280] text-[13px] mb-1">Views</p>
                            <p class="text-[#1E1B4B] font-bold text-[16px]">210</p>
                        </div>
                        <div class="md:col-span-1 flex justify-end">
                            <button class="text-[#3D1B9B] hover:bg-purple-50 p-2 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-8 pt-4">
                    <p class="text-[#6B7280] text-[14px]">Showing 1 to 5 of 5 products</p>
                    <div class="flex items-center space-x-2">
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#F3F4F6] text-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#3D1B9B] text-white font-semibold text-[14px]">
                            1
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#F3F4F6] text-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8">
                    <!-- Navigates to Upload Documents and marks step 3 complete -->
                    <a href="upload-documents.html" onclick="if(window.markStepCompleted) window.markStepCompleted(3);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
