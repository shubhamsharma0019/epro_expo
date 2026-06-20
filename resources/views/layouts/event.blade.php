<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'EproExpo Events')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
</head>

<body class="event-app m-0 overflow-x-hidden bg-[#FBFAFE] font-sans">
    <div id="event-sidebar-overlay" class="fixed inset-0 z-20 hidden bg-[#071044]/40 lg:hidden"></div>
    @include('components.frontend.event-sidebar')

    <div class="relative flex min-h-screen flex-col lg:ml-[232px]">
        @include('components.frontend.event-header')

        @yield('content')
    </div>

    @stack('scripts')
    <script>
        function initializePartial(targetId) {
            if (targetId === "sidebar") {
                const menuItems = document.querySelectorAll("#sidebar [data-nav-item]");

                menuItems.forEach((item) => {
                    item.addEventListener("click", () => {
                        menuItems.forEach((link) => {
                            link.classList.remove("is-active", "bg-[#F3EEFF]", "text-[#5B35D5]");
                            link.classList.add("text-[#3B406A]");
                        });

                        item.classList.add("is-active", "bg-[#F3EEFF]", "text-[#5B35D5]");
                        item.classList.remove("text-[#3B406A]");
                    });
                });
            }

            if (targetId === "header") {
                const profileBtn = document.getElementById("profileDropdownBtn");
                const profileDropdown = document.getElementById("profileDropdown");
                const menuToggle = document.getElementById("menuToggle");
                const sidebar = document.querySelector("#sidebar aside");
                const sidebarOverlay = document.getElementById("event-sidebar-overlay");

                if (profileBtn && profileDropdown) {
                    profileBtn.addEventListener("click", (event) => {
                        event.stopPropagation();
                        profileDropdown.classList.toggle("hidden");
                    });

                    window.addEventListener("click", (event) => {
                        if (!profileBtn.contains(event.target)) {
                            profileDropdown.classList.add("hidden");
                        }
                    });
                }

                const openSidebar = () => {
                    sidebar?.classList.remove("-translate-x-full");
                    sidebarOverlay?.classList.remove("hidden");
                    document.body.classList.add("overflow-hidden");
                };

                const closeSidebar = () => {
                    sidebar?.classList.add("-translate-x-full");
                    sidebarOverlay?.classList.add("hidden");
                    document.body.classList.remove("overflow-hidden");
                };

                if (menuToggle) {
                    menuToggle.addEventListener("click", openSidebar);
                }

                sidebarOverlay?.addEventListener("click", closeSidebar);

                window.addEventListener("resize", () => {
                    if (window.innerWidth >= 1024) {
                        sidebar?.classList.remove("-translate-x-full");
                        sidebarOverlay?.classList.add("hidden");
                        document.body.classList.remove("overflow-hidden");
                    } else {
                        sidebar?.classList.add("-translate-x-full");
                    }
                });
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            initializePartial("sidebar");
            initializePartial("header");
        });
    </script>
</body>

</html>
