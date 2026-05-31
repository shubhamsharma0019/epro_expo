document.addEventListener('DOMContentLoaded', () => {
    // Inject the sidebar HTML from sidebar.js
    const container = document.getElementById('sidebar-container');
    if (container && typeof sidebarHTML !== 'undefined') {
        container.innerHTML = sidebarHTML;
        
        // Re-attach event listeners for sidebar items if needed
        const navItems = container.querySelectorAll('a');
        const currentPage = window.location.pathname.split('/').pop() || 'event_company_dashboard.html';
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#') {
                    e.preventDefault();
                }
            });

            const href = item.getAttribute('href');
            const isDashboard = currentPage === 'event_company_dashboard.html' && href === 'event_company_dashboard.html';
            const isEventFlow = currentPage !== 'event_company_dashboard.html' && href === 'create-event.html';
            const svg = item.querySelector('svg');

            item.classList.remove('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
            item.classList.add('text-[#1C1364]', 'hover:bg-[#F8F9FA]', 'font-medium');
            if (svg) svg.classList.replace('text-[#5B32F6]', 'text-[#1C1364]');

            if (isDashboard || isEventFlow) {
                item.classList.remove('text-[#1C1364]', 'hover:bg-[#F8F9FA]', 'font-medium');
                item.classList.add('bg-[#F4F1FF]', 'text-[#5B32F6]', 'font-semibold');
                if (svg) svg.classList.replace('text-[#1C1364]', 'text-[#5B32F6]');
            }
        });
    } else {
        console.error('Sidebar container or sidebarHTML not found.');
    }
});
