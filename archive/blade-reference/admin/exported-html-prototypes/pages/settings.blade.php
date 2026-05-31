<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Settings</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FC;
        }
        .main-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .main-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .main-scrollbar::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }
        .main-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }
        
        /* Toggle Switch Custom Styling */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3723db;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #3723db;
        }
        .toggle-checkbox:checked + .toggle-label:after {
            transform: translateX(100%);
            border-color: white;
        }
        .toggle-label {
            transition: background-color 0.2s ease-in;
        }
        .toggle-label:after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.2s ease-in;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Custom Input Styling */
        .settings-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 13px;
            color: #334155;
            transition: all 0.2s;
            background-color: white;
        }
        .settings-input:focus {
            outline: none;
            border-color: #3723db;
            box-shadow: 0 0 0 3px rgba(55, 35, 219, 0.1);
        }
        .settings-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden m-0 p-0 text-[#1E293B]">
    
    <!-- Sidebar Container -->
    <div id="sidebar-container" class="w-[260px] bg-[#0b132c] h-full shrink-0 hidden sm:block"></div>
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full min-w-0">
        
        <!-- Top Header Area -->
        <header class="h-[76px] bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-8 shrink-0 relative z-10">
            <!-- Left Side: Title & Subtitle -->
            <div>
                <h1 class="text-[20px] font-bold text-[#0B132C]">Settings</h1>
                <p class="text-gray-500 text-[13px] mt-0.5">Manage platform settings and preferences.</p>
            </div>
            
            <!-- Right Side: Search, Bell, Profile -->
            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </button>
                <button class="relative text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ph ph-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">12</span>
                </button>
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <button class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=3723db&color=fff" alt="Profile" class="w-9 h-9 rounded-full object-cover shadow-sm">
                    <div class="flex flex-col text-left hidden sm:flex">
                        <span class="text-[13px] font-bold text-[#0B132C]">Admin User</span>
                        <span class="text-[11px] text-gray-500 font-medium">Super Admin</span>
                    </div>
                </button>
            </div>
        </header>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-6 lg:p-8 main-scrollbar bg-[#F8F9FC]">
            <div class="max-w-[1600px] mx-auto">
                
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <!-- Left Sidebar (Settings Menu) -->
                    <div class="w-full lg:w-[280px] shrink-0 flex flex-col h-[calc(100vh-140px)]">
                        <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-4 flex-1 flex flex-col">
                            <h2 class="text-[14px] font-bold text-[#0B132C] mb-4 px-3">Settings Menu</h2>
                            
                            <!-- Menu List -->
                            <div class="flex-1 overflow-y-auto main-scrollbar pr-2">
                                <ul class="space-y-1">
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] bg-[#F4F2FF] text-[#3723db] transition-colors font-semibold text-[13px]">
                                            <i class="ph ph-gear text-lg"></i>
                                            General Settings
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-envelope-simple text-lg text-gray-400"></i>
                                            Email Settings
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-credit-card text-lg text-gray-400"></i>
                                            Payment Settings
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-bell text-lg text-gray-400"></i>
                                            Notification Settings
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-magnifying-glass text-lg text-gray-400"></i>
                                            SEO Settings
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-share-network text-lg text-gray-400"></i>
                                            Social Media
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-wrench text-lg text-gray-400"></i>
                                            Maintenance Mode
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-puzzle-piece text-lg text-gray-400"></i>
                                            Integrations
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-file-text text-lg text-gray-400"></i>
                                            Audit Logs
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-clock-counter-clockwise text-lg text-gray-400"></i>
                                            Activity Logs
                                        </button>
                                    </li>
                                    <li>
                                        <button class="w-full flex items-center gap-3 px-4 py-2.5 rounded-[8px] text-gray-600 hover:bg-gray-50 transition-colors font-medium text-[13px]">
                                            <i class="ph ph-info text-lg text-gray-400"></i>
                                            System Info
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Need Help Box -->
                            <div class="mt-6 bg-[#F8F9FC] rounded-[12px] p-4 text-center border border-gray-100">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#3723db] mx-auto mb-3 shadow-sm">
                                    <i class="ph ph-headset text-xl"></i>
                                </div>
                                <h3 class="text-[14px] font-bold text-[#0B132C] mb-1">Need Help?</h3>
                                <p class="text-[12px] text-gray-500 mb-4 px-2">Visit our help center or contact support.</p>
                                <button class="w-full py-2 border border-[#3723db] text-[#3723db] rounded-[8px] text-[12px] font-semibold hover:bg-[#F4F2FF] transition-colors">
                                    Visit Help Center
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Content (Settings Form) -->
                    <div class="flex-1 flex flex-col gap-6">
                        
                        <!-- Header Area -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-[18px] font-bold text-[#0B132C]">General Settings</h2>
                                <p class="text-gray-500 text-[13px] mt-0.5">Manage your platform name, logo, contact details and other general settings.</p>
                            </div>
                            <button class="bg-[#3723db] text-white px-5 py-2.5 rounded-[8px] text-[13px] font-semibold shadow-sm hover:bg-[#2b1aa5] transition-colors shrink-0">
                                Save Changes
                            </button>
                        </div>
                        
                        <!-- Form Cards Container -->
                        <div class="flex flex-col gap-6">
                            
                            <!-- Platform Information -->
                            <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                <h3 class="text-[15px] font-bold text-[#0B132C] mb-5">Platform Information</h3>
                                
                                <div class="flex flex-col xl:flex-row gap-8">
                                    <!-- Left side inputs -->
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                        
                                        <div class="md:col-span-2">
                                            <label class="settings-label">Platform Name</label>
                                            <input type="text" class="settings-input" value="EproExpo">
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="settings-label">Tagline</label>
                                            <input type="text" class="settings-input" value="Complete platform control, approval, monitoring, payments and reports flow">
                                        </div>
                                        
                                        <div>
                                            <label class="settings-label">Website URL</label>
                                            <input type="text" class="settings-input" value="https://eproexpo.com">
                                        </div>
                                        
                                        <div>
                                            <label class="settings-label">Date Format</label>
                                            <div class="relative">
                                                <select class="settings-input appearance-none cursor-pointer">
                                                    <option>May 31, 2024</option>
                                                    <option>31/05/2024</option>
                                                    <option>2024-05-31</option>
                                                </select>
                                                <i class="ph-bold ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="settings-label">Time Zone</label>
                                            <div class="relative">
                                                <select class="settings-input appearance-none cursor-pointer">
                                                    <option>(GMT+05:30) Asia/Kolkata</option>
                                                    <option>(GMT+00:00) UTC</option>
                                                    <option>(GMT-05:00) Eastern Time</option>
                                                </select>
                                                <i class="ph-bold ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="settings-label">Time Format</label>
                                            <div class="relative">
                                                <select class="settings-input appearance-none cursor-pointer">
                                                    <option>10:30 AM</option>
                                                    <option>10:30</option>
                                                    <option>22:30</option>
                                                </select>
                                                <i class="ph-bold ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <!-- Right side logo -->
                                    <div class="w-full xl:w-[280px] shrink-0">
                                        <label class="settings-label mb-2">Platform Logo</label>
                                        <div class="border border-gray-200 rounded-[12px] bg-gray-50/50 p-6 flex items-center justify-center mb-3 h-[140px]">
                                            <div class="bg-white rounded-[8px] p-4 shadow-sm flex items-center gap-3">
                                                <svg viewBox="0 0 100 100" class="w-[32px] h-[32px] shrink-0" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <linearGradient id="logoGradSetting" x1="0%" y1="100%" x2="100%" y2="0%">
                                                            <stop offset="0%" stop-color="#3723db"/>
                                                            <stop offset="100%" stop-color="#3723db"/>
                                                        </linearGradient>
                                                    </defs>
                                                    <path d="M 80 50 L 20 50 A 30 30 0 0 1 80 50 A 30 30 0 0 1 65 76" stroke="url(#logoGradSetting)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                                                </svg>
                                                <span class="text-[#0B132C] text-[20px] font-bold tracking-wide">eproexpo</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button class="flex-1 flex items-center justify-center gap-2 py-2 border border-gray-200 text-[#3723db] text-[13px] font-semibold rounded-[8px] hover:bg-gray-50 transition-colors">
                                                <i class="ph ph-upload-simple text-lg"></i>
                                                Change Logo
                                            </button>
                                            <button class="w-10 h-10 flex items-center justify-center border border-gray-200 text-gray-400 rounded-[8px] hover:bg-red-50 hover:text-red-500 transition-colors hover:border-red-200 shrink-0">
                                                <i class="ph ph-trash text-lg"></i>
                                            </button>
                                        </div>
                                        <p class="text-[11px] text-gray-400 text-center mt-3">PNG or JPG (max. 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                <h3 class="text-[15px] font-bold text-[#0B132C] mb-5">Contact Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div class="lg:col-span-1">
                                        <label class="settings-label">Email Address</label>
                                        <input type="email" class="settings-input" value="support@eproexpo.com">
                                    </div>
                                    <div class="lg:col-span-1">
                                        <label class="settings-label">Phone Number</label>
                                        <input type="text" class="settings-input" value="+91 98765 43210">
                                    </div>
                                    <div class="lg:col-span-2">
                                        <label class="settings-label">Address</label>
                                        <input type="text" class="settings-input" value="5th Floor, Tech Park, Hyderabad, Telangana, India">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Other Settings -->
                            <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                <h3 class="text-[15px] font-bold text-[#0B132C] mb-6">Other Settings</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                                    
                                    <!-- Toggle Item 1 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle1" id="toggle1" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                            <label for="toggle1" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle1" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Allow User Registration</label>
                                            <p class="text-[12px] text-gray-500">Allow new users to register on the platform.</p>
                                        </div>
                                    </div>

                                    <!-- Toggle Item 4 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle4" id="toggle4" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                            <label for="toggle4" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle4" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Email Notifications</label>
                                            <p class="text-[12px] text-gray-500">Enable email notifications for important updates.</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Toggle Item 2 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle2" id="toggle2" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                            <label for="toggle2" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle2" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Email Verification</label>
                                            <p class="text-[12px] text-gray-500">Require email verification for new users.</p>
                                        </div>
                                    </div>

                                    <!-- Toggle Item 5 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle5" id="toggle5" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                            <label for="toggle5" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle5" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Data Analytics</label>
                                            <p class="text-[12px] text-gray-500">Allow collection of analytics data.</p>
                                        </div>
                                    </div>

                                    <!-- Toggle Item 3 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle3" id="toggle3" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" />
                                            <label for="toggle3" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle3" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Maintenance Mode</label>
                                            <p class="text-[12px] text-gray-500">Enable maintenance mode for the platform.</p>
                                        </div>
                                    </div>

                                    <!-- Toggle Item 6 -->
                                    <div class="flex items-start gap-4">
                                        <div class="relative inline-block w-[36px] mt-0.5 align-middle select-none transition duration-200 ease-in shrink-0">
                                            <input type="checkbox" name="toggle6" id="toggle6" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 top-0 left-0" checked/>
                                            <label for="toggle6" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <div>
                                            <label for="toggle6" class="text-[13px] font-bold text-[#0B132C] cursor-pointer block mb-0.5">Cookies</label>
                                            <p class="text-[12px] text-gray-500">Allow cookies to enhance user experience.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <!-- Default Language and Currency (Bottom) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Default Language -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                    <h3 class="text-[15px] font-bold text-[#0B132C] mb-4">Default Language</h3>
                                    <label class="settings-label">Select Default Language</label>
                                    <div class="relative">
                                        <select class="settings-input appearance-none cursor-pointer">
                                            <option>English (US)</option>
                                            <option>Spanish</option>
                                            <option>French</option>
                                        </select>
                                        <i class="ph-bold ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>
                                </div>
                                
                                <!-- Currency -->
                                <div class="bg-white rounded-[16px] border border-gray-100 shadow-sm p-6">
                                    <h3 class="text-[15px] font-bold text-[#0B132C] mb-4">Currency</h3>
                                    <label class="settings-label">Select Currency</label>
                                    <div class="relative">
                                        <select class="settings-input appearance-none cursor-pointer">
                                            <option>INR (₹) - Indian Rupee</option>
                                            <option>USD ($) - US Dollar</option>
                                            <option>EUR (€) - Euro</option>
                                        </select>
                                        <i class="ph-bold ph-caret-down absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    
    <!-- Sidebar Script -->
    <script src="../assets/js/sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadSidebar('sidebar-container');
        });
    </script>
</body>
</html>
