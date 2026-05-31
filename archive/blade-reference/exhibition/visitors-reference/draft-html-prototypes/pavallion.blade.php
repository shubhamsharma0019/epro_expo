<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pavilions - ExpoExpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#302b8a', // Dark purple/indigo
                        secondary: '#4f46e5', // Lighter purple
                        accent: '#f3f4f6', // Light gray bg
                        active: '#f4f2ff', // Active sidebar bg
                        textDark: '#111827',
                        textMuted: '#6b7280'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for main content */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 4px;
        }
    </style>
</head>
<body class="text-[#1E293B] font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Container -->
    <div id="sidebar-container" class="h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FAFAFA]">
        
        <!-- Header Container -->
        <div id="header-container" class="flex-shrink-0 z-10 w-full relative"></div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-10 bg-[#FAFAFA] bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-[32px] font-bold text-[#1E1B4B] mb-2">Pavilions</h1>
                <p class="text-[14px] text-gray-500 font-medium">Explore curated pavilions showcasing industries and innovations.</p>
            </div>

            <!-- Hero Banner -->
            <div class="w-full rounded-[24px] overflow-hidden relative mb-12 h-[260px] flex flex-col justify-center px-16 shadow-[0_8px_30px_rgb(0,0,0,0.12)]">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center"></div>
                <!-- Dark gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0B0F2A] via-[#0B0F2A]/90 to-transparent"></div>
                
                <div class="relative z-10 max-w-[50%]">
                    <h2 class="text-[36px] font-bold text-white mb-4 tracking-tight leading-tight">Discover. Connect. Grow.</h2>
                    <p class="text-[16px] text-indigo-100 font-medium leading-relaxed">Explore industry-focused pavilions<br>and connect with the future.</p>
                </div>
            </div>

            <!-- Pavilion Categories -->
            <div class="mb-12">
                <h3 class="font-bold text-[#1E1B4B] text-[18px] mb-6">Pavilion Categories</h3>
                <div class="grid grid-cols-6 gap-4">
                    <!-- Category 1 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-primary-600 mb-4 border border-indigo-100/50">
                            <i class="ph ph-cpu text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">Technology & AI</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Innovate the future with intelligent solutions</p>
                        <div class="text-[11px] font-bold text-primary-600">8+ Companies</div>
                    </div>
                    <!-- Category 2 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-4 border border-blue-100/50">
                            <i class="ph ph-factory text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">Manufacturing<br>& Pharma</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Advancing manufacturing and healthcare</p>
                        <div class="text-[11px] font-bold text-blue-600">65+ Companies</div>
                    </div>
                    <!-- Category 3 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 mb-4 border border-purple-100/50">
                            <i class="ph ph-robot text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">Smart<br>Manufacturing</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Automation, robotics and IIoT solutions</p>
                        <div class="text-[11px] font-bold text-purple-600">60+ Companies</div>
                    </div>
                    <!-- Category 4 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 mb-4 border border-green-100/50">
                            <i class="ph ph-plant text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">Green Energy</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Sustainable energy for a better tomorrow</p>
                        <div class="text-[11px] font-bold text-green-600">50+ Companies</div>
                    </div>
                    <!-- Category 5 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center text-pink-600 mb-4 border border-pink-100/50">
                            <i class="ph ph-rocket-launch text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">Startups</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Empowering startups to build the future</p>
                        <div class="text-[11px] font-bold text-pink-600">60+ Companies</div>
                    </div>
                    <!-- View All -->
                    <div class="bg-white border border-gray-100 rounded-[20px] p-6 shadow-[0_2px_15px_rgba(0,0,0,0.02)] hover:border-primary-200 transition-colors cursor-pointer flex flex-col h-full">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 mb-4 border border-gray-200">
                            <i class="ph-bold ph-dots-three text-[24px]"></i>
                        </div>
                        <h4 class="font-bold text-[#1E1B4B] text-[14px] mb-2 leading-snug">View All</h4>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 flex-1">Explore all pavilion categories</p>
                        <i class="ph-bold ph-arrow-right text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Featured Pavilions -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-[#1E1B4B] text-[18px]">Featured Pavilions</h3>
                    <a href="exhibitions.html" class="text-primary-600 font-bold text-[13px] hover:underline flex items-center gap-1">View All Pavilions <i class="ph-bold ph-arrow-right"></i></a>
                </div>

                <div class="grid grid-cols-5 gap-4">
                    <!-- Featured 1 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col h-full hover:-translate-y-1 transition-transform">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80" alt="Technology" class="w-full h-36 object-cover border-b border-gray-100">
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] leading-tight flex-1">Technology & AI</h4>
                                <span class="text-[10px] font-bold text-primary-600 shrink-0">8+ Companies</span>
                            </div>
                            <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-6 flex-1">Explore AI, analytics, and next-gen tech solutions shaping industries.</p>
                            <a href="pavilion-details.html?id=tech" class="w-full border border-primary-200 text-primary-600 rounded-lg py-2.5 font-bold text-[13px] hover:bg-primary-50 transition-colors text-center block">Explore Pavilion</a>
                        </div>
                    </div>
                    <!-- Featured 2 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col h-full hover:-translate-y-1 transition-transform">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=400&q=80" alt="Manufacturing" class="w-full h-36 object-cover border-b border-gray-100">
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] leading-tight flex-1">Manufacturing & Pharma</h4>
                            </div>
                            <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-6 flex-1">Discover innovations in manufacturing and pharmaceutical industries.</p>
                            <a href="pavilion-details.html?id=manufacturing" class="w-full border border-primary-200 text-primary-600 rounded-lg py-2.5 font-bold text-[13px] hover:bg-primary-50 transition-colors text-center block">Explore Pavilion</a>
                        </div>
                    </div>
                    <!-- Featured 3 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col h-full hover:-translate-y-1 transition-transform">
                        <img src="https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&w=400&q=80" alt="Smart" class="w-full h-36 object-cover border-b border-gray-100">
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] leading-tight flex-1">Smart Manufacturing</h4>
                            </div>
                            <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-6 flex-1">Experience smart factories, automation, and industrial IoT.</p>
                            <a href="pavilion-details.html?id=smart" class="w-full border border-primary-200 text-primary-600 rounded-lg py-2.5 font-bold text-[13px] hover:bg-primary-50 transition-colors text-center block">Explore Pavilion</a>
                        </div>
                    </div>
                    <!-- Featured 4 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col h-full hover:-translate-y-1 transition-transform">
                        <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=400&q=80" alt="Green" class="w-full h-36 object-cover border-b border-gray-100">
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] leading-tight flex-1">Green Energy</h4>
                                <span class="text-[10px] font-bold text-primary-600 shrink-0">50+ Companies</span>
                            </div>
                            <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-6 flex-1">Find sustainable energy solutions for a greener planet.</p>
                            <a href="pavilion-details.html?id=green" class="w-full border border-primary-200 text-primary-600 rounded-lg py-2.5 font-bold text-[13px] hover:bg-primary-50 transition-colors text-center block">Explore Pavilion</a>
                        </div>
                    </div>
                    <!-- Featured 5 -->
                    <div class="bg-white border border-gray-100 rounded-[20px] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col h-full hover:-translate-y-1 transition-transform">
                        <img src="https://images.unsplash.com/photo-1559136555-9ce7b5fda016?auto=format&fit=crop&w=400&q=80" alt="Startups" class="w-full h-36 object-cover border-b border-gray-100">
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="font-bold text-[#1E1B4B] text-[15px] leading-tight flex-1">Startups</h4>
                                <span class="text-[10px] font-bold text-primary-600 shrink-0">60+ Companies</span>
                            </div>
                            <p class="text-[12px] text-gray-500 font-medium leading-relaxed mb-6 flex-1">Meet innovative startups and future disruptors.</p>
                            <a href="pavilion-details.html?id=startups" class="w-full border border-primary-200 text-primary-600 rounded-lg py-2.5 font-bold text-[13px] hover:bg-primary-50 transition-colors text-center block">Explore Pavilion</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
