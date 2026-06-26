<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Design</title>
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3b18ff',
                        'primary-light': '#f4f2ff',
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex justify-center items-center min-h-screen p-10 font-outfit">

    <aside class="w-80 bg-white border border-gray-100 flex flex-col px-5 py-6 rounded-3xl shadow-sm">
        <ul class="flex flex-col gap-3 list-none">
            <li>
                <a href="#" class="group menu-item-active flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 active:bg-primary-light active:text-primary bg-primary-light text-primary">
                    <i class="ph ph-squares-four text-2xl mr-5 text-primary transition-colors duration-200"></i>
                    <span class="text-base font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-bank text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Pavallions</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-calendar-check text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">My Bookings</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-user-list text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Enquires / Leads</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-storefront text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Manage Booths / Edit Booths</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-users text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Meeting Request</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-chart-bar text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-receipt text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Payments / Invoices</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <div class="relative flex items-center">
                        <i class="ph ph-bell text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                        <div class="absolute w-2.5 h-2.5 bg-red-600 rounded-full border-2 border-white top-0 right-5"></div>
                    </div>
                    <span class="text-base font-medium">Notification</span>
                </a>
            </li>
            <li class="mt-3">
                <a href="#" class="flex items-center px-5 py-4 rounded-xl text-gray-900 no-underline transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                    <i class="ph ph-sign-out text-2xl mr-5 text-gray-900 transition-colors duration-200"></i>
                    <span class="text-base font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </aside>

</body>
</html>
