<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Backup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FC;
        }
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden m-0 p-0 text-[#1E293B]">
    <div id="sidebar-container" class="w-[260px] bg-[#0b132c] h-full shrink-0 hidden sm:block"></div>

    <main class="flex-1 flex flex-col h-full min-w-0">
        <header class="h-[76px] bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-[22px] font-bold text-[#0B132C]">Backup</h1>
                <p class="text-[13px] text-gray-500 mt-1">System backup and restore controls.</p>
            </div>
        </header>

        <section class="flex-1 overflow-y-auto p-8">
            <div class="bg-white border border-gray-100 rounded-[12px] p-6 shadow-sm max-w-3xl">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-[10px] bg-[#EEF2FF] text-[#3723db] flex items-center justify-center shrink-0">
                        <i class="ph ph-database text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-[18px] font-bold text-[#0B132C]">Backup Page Placeholder</h2>
                        <p class="text-[14px] text-gray-500 mt-2 leading-6">The admin flow export referenced this page from the sidebar, but the original zip did not include a backup screen. This placeholder keeps the navigation complete until the final UI is added.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../assets/js/sidebar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadSidebar('sidebar-container');
        });
    </script>
</body>
</html>
