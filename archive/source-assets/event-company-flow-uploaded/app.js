document.addEventListener('DOMContentLoaded', () => {
    // Inject the sidebar HTML from sidebar.js
    const container = document.getElementById('sidebar-container');
    if (container && typeof sidebarHTML !== 'undefined') {
        container.innerHTML = sidebarHTML;
        
        // Re-attach event listeners for sidebar items if needed
        const navItems = container.querySelectorAll('a');
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                // Remove active classes from all
                navItems.forEach(n => {
                    n.classList.remove('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                    n.classList.add('text-[#1C1364]', 'hover:bg-[#F8F9FA]', 'font-medium');
                    const svg = n.querySelector('svg');
                    if(svg) svg.classList.replace('text-[#5B32F6]', 'text-[#1C1364]');
                });
                
                // Add active classes to clicked item
                this.classList.remove('text-[#1C1364]', 'hover:bg-[#F8F9FA]', 'font-medium');
                this.classList.add('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                const svg = this.querySelector('svg');
                if(svg) svg.classList.replace('text-[#1C1364]', 'text-[#5B32F6]');
            });
        });
        // Sidebar Toggle Logic for Responsive Layout
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarMenu = document.getElementById('sidebar-menu');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const closeBtn = document.getElementById('sidebar-close-btn');

        function openSidebar() {
            if (sidebarMenu && sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => {
                    sidebarOverlay.classList.remove('opacity-0');
                    sidebarMenu.classList.remove('-translate-x-full');
                }, 10);
            }
        }

        function closeSidebar() {
            if (sidebarMenu && sidebarOverlay) {
                sidebarOverlay.classList.add('opacity-0');
                sidebarMenu.classList.add('-translate-x-full');
                setTimeout(() => {
                    sidebarOverlay.classList.add('hidden');
                }, 300);
            }
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    } else {
        console.error('Sidebar container or sidebarHTML not found.');
    }
});
