(function () {
    function normalizePath(path) {
        return path.replace(/\/+$/, '') || '/';
    }

    function initializeSidebarInteractions() {
        document.querySelectorAll('.sidebar-dropdown > button').forEach((toggle) => {
            if (toggle.dataset.bound === '1') {
                return;
            }

            toggle.dataset.bound = '1';
            toggle.addEventListener('click', () => {
                const menu = toggle.nextElementSibling;
                const arrow = toggle.querySelector('.dropdown-arrow');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            });
        });
    }

    function setActiveSidebarItem() {
        const currentPath = normalizePath(window.location.pathname);
        const sidebar = document.querySelector('#admin-sidebar, aside');
        if (!sidebar) {
            return;
        }

        sidebar.querySelectorAll('a').forEach((link) => {
            link.classList.remove('bg-[#2b228b]', 'bg-white/10', 'text-white', 'font-semibold', 'shadow-md');
            if (!link.closest('.dropdown-menu')) {
                link.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
            }
        });

        let activeLink = null;
        sidebar.querySelectorAll('a[href]').forEach((link) => {
            const href = link.getAttribute('href');
            if (!href || href === '#' || href.includes('backup.html')) {
                return;
            }

            let linkPath;
            try {
                linkPath = normalizePath(new URL(href, window.location.origin).pathname);
            } catch (error) {
                return;
            }

            if (linkPath === currentPath) {
                activeLink = link;
            }
        });

        if (!activeLink) {
            let bestMatch = null;
            sidebar.querySelectorAll('a[href]').forEach((link) => {
                const href = link.getAttribute('href');
                if (!href || href === '#' || href.includes('backup.html')) {
                    return;
                }
                let linkPath;
                try {
                    linkPath = normalizePath(new URL(href, window.location.origin).pathname);
                } catch (error) {
                    return;
                }
                if (linkPath !== '/' && currentPath.startsWith(linkPath) && (!bestMatch || linkPath.length > bestMatch.path.length)) {
                    bestMatch = { link, path: linkPath };
                }
            });
            activeLink = bestMatch?.link ?? null;
        }

        if (!activeLink) {
            return;
        }

        if (activeLink.closest('.dropdown-menu')) {
            activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
            activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');

            const dot = activeLink.querySelector('.indicator-dot');
            if (dot) {
                dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]');
            }

            const dropdown = activeLink.closest('.sidebar-dropdown');
            const menu = dropdown?.querySelector('.dropdown-menu');
            const button = dropdown?.querySelector('button');
            const arrow = dropdown?.querySelector('.dropdown-arrow');

            if (menu) {
                menu.classList.remove('hidden');
            }
            if (arrow) {
                arrow.classList.add('rotate-180');
            }
            if (button) {
                button.classList.add('bg-[#3723db]', 'text-white');
                button.classList.remove('text-[#a0aabf]', 'hover:bg-white/5');
            }
        } else {
            activeLink.classList.add('bg-[#2b228b]', 'text-white', 'shadow-md');
            activeLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initializeSidebarInteractions();
        setActiveSidebarItem();
    });
})();
