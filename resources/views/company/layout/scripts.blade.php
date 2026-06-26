<script>
    (() => {
        const sidebar = document.getElementById('company-sidebar');
        const overlay = document.getElementById('company-sidebar-overlay');
        const openButtons = document.querySelectorAll('[data-company-sidebar-open]');
        const closeButtons = document.querySelectorAll('[data-company-sidebar-close]');

        const openSidebar = () => {
            sidebar?.classList.remove('-translate-x-full');
            overlay?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        const closeSidebar = () => {
            sidebar?.classList.add('-translate-x-full');
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        openButtons.forEach((button) => button.addEventListener('click', openSidebar));
        closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
        overlay?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    })();
</script>
@include('company.layout.notification-badge-script')
