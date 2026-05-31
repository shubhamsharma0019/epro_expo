<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Booth | eproexpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/components.js" defer></script>
    <style>
        /* Custom Squircle for numbers */
        .squircle {
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans">

    <!-- Sidebar and Top Navigation Components -->
    <div id="sidebar-container"></div>
    <div id="topnav-container"></div>

    <main class="ml-[240px] pt-[80px] min-h-screen p-8 bg-white">
        <div class="w-full mx-auto max-w-[1400px]">
            
            <!-- Page Header and Progress -->
            <div class="flex justify-between items-start mb-10">
                <div class="flex items-start">
                    <!-- Booth Icon -->
                    <div class="mt-1 mr-4 text-[#3D1B9B]">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L4 9v11a1 1 0 001 1h4v-6h6v6h4a1 1 0 001-1V9l-8-6z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-[28px] font-bold text-[#1E1B4B] mb-2 tracking-tight">Setup Your Booth</h1>
                        <p class="text-[#6B7280] text-[15px]">Complete all the steps below to publish your booth and go live.</p>
                    </div>
                </div>
                
                <!-- Overall Progress Card -->
                <div class="w-[360px] border border-gray-200 rounded-xl p-4 shadow-sm bg-white">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[15px] font-bold text-[#1E1B4B]">Overall Progress</span>
                        <span class="text-[15px] font-bold text-[#1E1B4B]" id="overall-progress-text">0%</span>
                    </div>
                    <div class="w-full bg-[#F3F4F6] rounded-full h-2.5">
                        <div class="bg-[#3D1B9B] h-2.5 rounded-full" id="overall-progress-bar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Steps List Container -->
            <div class="border border-gray-200 rounded-2xl bg-white mb-10 flex flex-col overflow-hidden" id="steps-list-container">
                <!-- Dynamically rendered by components.js -->
            </div>

            <!-- Action Buttons Footer -->
            <div class="flex justify-between items-center pb-12">
                <a href="booking-details.html" class="flex items-center text-[#3D1B9B] font-bold text-[15px] hover:underline transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Booking
                </a>
                <a href="company-profile.html" class="px-8 py-3.5 bg-[#3D1B9B] rounded-lg text-white font-bold text-[15px] hover:bg-[#31167D] transition-colors inline-flex items-center shadow-md">
                    Continue Setup <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </main>
</body>
</html>
