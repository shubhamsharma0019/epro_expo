<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents | eproexpo</title>
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
                
                <!-- Step 3: Inactive style for screenshot match -->
                <div class="flex items-center px-3 py-1.5 border border-gray-200 rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-[13px] mr-2">3</div>
                    <span class="text-gray-400 font-semibold text-[14px] mr-1">Products</span>
                </div>
                
                <!-- Step 4: Active -->
                <div class="flex items-center px-3 py-1.5 border border-[#3D1B9B] rounded-full bg-white flex-shrink-0">
                    <div class="w-6 h-6 rounded-full bg-[#3D1B9B] text-white flex items-center justify-center font-bold text-[13px] mr-2">4</div>
                    <span class="text-[#3D1B9B] font-bold text-[14px] mr-1">Documents</span>
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
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-2">Upload Documents</h1>
                <p class="text-[#6B7280] text-[15px] mb-8">Upload important documents to share with attendees.</p>

                <!-- Drag & Drop Area -->
                <div class="w-full border-2 border-dashed border-[#8B5CF6] rounded-xl bg-white mb-10 py-16 flex flex-col items-center justify-center text-center">
                    <div class="mb-4 text-[#3D1B9B]">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-[#1E1B4B] font-bold text-[16px] mb-2">Drag & drop files here or <span class="text-[#3D1B9B]">click to browse</span></h3>
                    <p class="text-[#6B7280] text-[13px] mb-6">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (Max. 10MB each)</p>
                    <button class="px-6 py-2.5 border border-[#3D1B9B] rounded-lg text-[#3D1B9B] font-semibold text-[14px] hover:bg-purple-50 transition-colors">
                        Browse Files
                    </button>
                </div>

                <!-- Documents List Table -->
                <div class="border border-gray-100 rounded-xl overflow-hidden bg-white mb-6">
                    
                    <!-- Table Header -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100 bg-white">
                        <div class="col-span-4"><span class="text-[#1E1B4B] font-bold text-[14px]">Uploaded Documents</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Type</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Visibility</span></div>
                        <div class="col-span-2"><span class="text-[#1E1B4B] font-bold text-[14px]">Size</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Downloads</span></div>
                        <div class="col-span-1 text-center"><span class="text-[#1E1B4B] font-bold text-[14px]">Actions</span></div>
                    </div>

                    <!-- Item 1 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">Company Brochure 2024</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Public</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">3.2 MB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">142</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">Product Catalog</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Public</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">6.1 MB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">98</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">Company Profile</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Public</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">2.4 MB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">76</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">ISO 9001 Certificate</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Public</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">1.1 MB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">41</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 5 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5 border-b border-gray-100">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">Data Security Whitepaper</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 border border-emerald-200 text-[#10B981] font-semibold text-[12px] rounded-md">Public</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">1.8 MB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">63</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Item 6 -->
                    <div class="grid grid-cols-12 gap-4 items-center p-5">
                        <div class="col-span-4 flex items-center">
                            <svg class="w-6 h-6 text-[#8B5CF6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9h1.5m1.5 0H15m-6 4h6m-6 4h6"></path></svg>
                            <span class="text-[#4B5563] text-[14px] font-medium truncate pr-4">Partnership Certificate</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">PDF</span>
                        </div>
                        <div class="col-span-2">
                            <span class="inline-flex px-3 py-1 bg-[#F5F3FF] border border-[#DDD6FE] text-[#6D28D9] font-bold text-[12px] rounded-md">Private</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[#4B5563] text-[14px]">800 KB</span>
                        </div>
                        <div class="col-span-1 text-center">
                            <span class="text-[#4B5563] text-[14px]">12</span>
                        </div>
                        <div class="col-span-1 flex justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Footer Text -->
                <div class="mt-4">
                    <p class="text-[#6B7280] text-[14px]">Showing 1 to 6 of 6 documents</p>
                </div>

                <!-- Bottom Action Buttons -->
                <div class="flex justify-end mt-10 border-t border-gray-100 pt-8">
                    <!-- Navigates to Upload Catalogues and marks step 4 complete -->
                    <a href="upload-catalogues.html" onclick="if(window.markStepCompleted) window.markStepCompleted(4);" class="px-8 py-3 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
