<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ExpoExpo</title>
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
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background: linear-gradient(135deg, #0f1545 0%, #202b80 100%);
            position: relative;
            overflow: hidden;
        }
        /* Subtle glow effects in background like in the design */
        .hero-bg::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 100%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.4) 0%, rgba(0,0,0,0) 70%);
            pointer-events: none;
        }
    </style>
</head>
<body class="flex h-screen bg-gray-50 text-gray-800 overflow-hidden">

    <!-- Sidebar Placeholder -->
    <div id="sidebar-container" class="h-full"></div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 bg-white">
        
        <!-- Top Header Placeholder -->
        <div id="header-container" class="w-full z-10 relative bg-white"></div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8  bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            
            <!-- Hero Section -->
            <div class="hero-bg rounded-2xl px-6 py-16 md:py-20 text-center text-white mb-10 shadow-lg">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Discover. Connect. Grow.</h1>
                <p class="text-indigo-200 text-lg mb-10">Explore the world of innovations</p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto flex items-center bg-white rounded-lg p-1 shadow-xl">
                    <i class="fas fa-search text-gray-400 ml-4 mr-3 text-lg"></i>
                    <input type="text" placeholder="Search exhibitions, companies, products..." class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none py-3 px-2 text-base w-full">
                    <button onclick="window.location.href='exhibitions.html'" class="bg-secondary hover:bg-indigo-700 text-white px-8 py-3 rounded-md font-medium transition-colors whitespace-nowrap">
                        Explore Exhibitions
                    </button>
                </div>
            </div>

            <!-- Featured Exhibitions Section -->
            <div class="flex items-center justify-between mb-6 px-1">
                <h2 class="text-xl font-bold text-gray-800">Featured Exhibitions</h2>
                <a href="exhibitions.html" class="text-secondary text-sm font-semibold hover:underline">View All</a>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card 1 -->
                <div onclick="window.location.href='exhibitions.html'" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Global Tech Summit" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Global Tech Summit 2024</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="far fa-calendar-alt w-4 text-center text-gray-400"></i>
                                <span class="font-medium">May 15 - 17, 2024</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="fas fa-map-marker-alt w-4 text-center text-gray-400"></i>
                                <span>Mumbai, India</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div onclick="window.location.href='exhibitions.html'" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Future of AI Expo" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Future of AI Expo</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="far fa-calendar-alt w-4 text-center text-gray-400"></i>
                                <span class="font-medium">Jun 10 - 12, 2024</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="fas fa-map-marker-alt w-4 text-center text-gray-400"></i>
                                <span>Bengaluru, India</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div onclick="window.location.href='exhibitions.html'" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sustainability World Expo" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Sustainability World Expo</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="far fa-calendar-alt w-4 text-center text-gray-400"></i>
                                <span class="font-medium">Aug 20 - 22, 2024</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 gap-3">
                                <i class="fas fa-map-marker-alt w-4 text-center text-gray-400"></i>
                                <span>Pune, India</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="h-8"></div>
        </div>
    </main>

    <script src="../assets/js/script.js"></script>
</body>
</html>
