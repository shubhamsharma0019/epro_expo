/**
 * Loads the sidebar HTML into a designated container and initializes its interactivity.
 * Usage: call `loadSidebar('container-id')`
 */
async function loadSidebar(containerId) {
    try {
        const response = await fetch('sidebar.html');
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const html = await response.text();
        document.getElementById(containerId).innerHTML = html;
        
        initializeSidebarInteractions();
        setActiveSidebarItem();
    } catch (error) {
        console.error('Error loading sidebar:', error);
        document.getElementById(containerId).innerHTML = '<div class="p-4 text-red-500">Failed to load sidebar. Please ensure you are running this through a local server (like VS Code Live Server) due to CORS restrictions on file:// URLs.</div>';
    }
}

function initializeSidebarInteractions() {
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown > button');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            const menu = toggle.nextElementSibling;
            const arrow = toggle.querySelector('.dropdown-arrow');
            
            // Toggle current
            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    });
}

function setActiveSidebarItem() {
    const currentPath = window.location.pathname.split('/').pop() || 'admin_dashboard.html';
    const container = document.getElementById('sidebar-container');
    if (!container) return;

    // Reset Dashboard state
    const dashLink = container.querySelector('a[href="admin_dashboard.html"]');
    if (dashLink) {
        if (currentPath === 'admin_dashboard.html') {
            dashLink.classList.add('bg-[#2b228b]', 'text-white');
            dashLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            dashLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            dashLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Users link state
    const usersLink = container.querySelector('a[href="users.html"]');
    if (usersLink) {
        if (currentPath === 'users.html') {
            usersLink.classList.add('bg-[#2b228b]', 'text-white');
            usersLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            usersLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            usersLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Tickets link state
    const ticketsLink = container.querySelector('a[href="tickets.html"]');
    if (ticketsLink) {
        if (currentPath === 'tickets.html') {
            ticketsLink.classList.add('bg-[#2b228b]', 'text-white');
            ticketsLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            ticketsLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            ticketsLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Enquiries link state
    const enquiriesLink = container.querySelector('a[href="enquiries.html"]');
    if (enquiriesLink) {
        if (currentPath === 'enquiries.html') {
            enquiriesLink.classList.add('bg-[#2b228b]', 'text-white');
            enquiriesLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            enquiriesLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            enquiriesLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Payments link state
    const paymentsLink = container.querySelector('a[href="payments.html"]');
    if (paymentsLink) {
        if (currentPath === 'payments.html') {
            paymentsLink.classList.add('bg-[#2b228b]', 'text-white');
            paymentsLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            paymentsLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            paymentsLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Reports link state
    const reportsLink = container.querySelector('a[href="reports.html"]');
    if (reportsLink) {
        if (currentPath === 'reports.html') {
            reportsLink.classList.add('bg-[#2b228b]', 'text-white');
            reportsLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            reportsLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            reportsLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Notifications link state
    const notificationsLink = container.querySelector('a[href="notifications.html"]');
    if (notificationsLink) {
        if (currentPath === 'notifications.html') {
            notificationsLink.classList.add('bg-[#2b228b]', 'text-white');
            notificationsLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            notificationsLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            notificationsLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }



    // Handle Support link state
    const supportLink = container.querySelector('a[href="support.html"]');
    if (supportLink) {
        if (currentPath === 'support.html') {
            supportLink.classList.add('bg-[#2b228b]', 'text-white');
            supportLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            supportLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            supportLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle CMS Management link state
    const cmsLink = container.querySelector('a[href="cms.html"]');
    if (cmsLink) {
        if (currentPath === 'cms.html') {
            cmsLink.classList.add('bg-[#2b228b]', 'text-white');
            cmsLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
        } else {
            cmsLink.classList.remove('bg-[#2b228b]', 'text-white', 'shadow-md');
            cmsLink.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
        }
    }

    // Handle Company dropdown items
    if (currentPath === 'companies.html' || currentPath === 'company_approval.html' || currentPath === 'add_company.html') {
        const companyDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Company'));
        if (companyDropdown) {
            const toggle = companyDropdown.querySelector('button');
            const menu = companyDropdown.querySelector('.dropdown-menu');
            const arrow = companyDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const activeLink = menu.querySelector(`a[data-path="${currentPath}"]`);
            if (activeLink) {
                // Remove default inactive classes
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                // Add active classes depending on the page type (e.g. Add Company has a different bg in the mockup, but we'll use a unified active state)
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                
                // Animate the dot
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }

    // Handle Exhibitions dropdown items
    if (currentPath === 'exhibitions.html' || currentPath === 'add_exhibition.html') {
        const exhDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Exhibitions'));
        if (exhDropdown) {
            const toggle = exhDropdown.querySelector('button');
            const menu = exhDropdown.querySelector('.dropdown-menu');
            const arrow = exhDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const activeLink = menu.querySelector(`a[data-path="${currentPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }

    // Handle Pavilions dropdown items
    if (currentPath === 'pavilions.html' || currentPath === 'add_pavilion.html') {
        const pavDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Pavilions'));
        if (pavDropdown) {
            const toggle = pavDropdown.querySelector('button');
            const menu = pavDropdown.querySelector('.dropdown-menu');
            const arrow = pavDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const activeLink = menu.querySelector(`a[data-path="${currentPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }

    // Handle Halls dropdown items
    if (currentPath === 'halls.html' || currentPath === 'add_hall.html') {
        const hallsDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Halls'));
        if (hallsDropdown) {
            const toggle = hallsDropdown.querySelector('button');
            const menu = hallsDropdown.querySelector('.dropdown-menu');
            const arrow = hallsDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const activeLink = menu.querySelector(`a[data-path="${currentPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }

    // Handle Booths dropdown items
    if (currentPath === 'booths.html' || currentPath === 'add_booth.html' || currentPath === 'booth_management.html' || currentPath === 'booth_setup_review.html' || currentPath === 'booth_setup_review_details.html') {
        const boothsDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Booths'));
        if (boothsDropdown) {
            const toggle = boothsDropdown.querySelector('button');
            const menu = boothsDropdown.querySelector('.dropdown-menu');
            const arrow = boothsDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const targetPath = currentPath === 'booth_setup_review_details.html' ? 'booth_setup_review.html' : currentPath;
            const activeLink = menu.querySelector(`a[data-path="${targetPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }
    // Handle Event Management dropdown items
    if (currentPath === 'events.html' || currentPath === 'event_setup_review.html' || currentPath === 'event_approval.html') {
        const eventsDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Event Management'));
        if (eventsDropdown) {
            const toggle = eventsDropdown.querySelector('button');
            const menu = eventsDropdown.querySelector('.dropdown-menu');
            const arrow = eventsDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const targetPath = currentPath === 'event_approval.html' ? 'event_setup_review.html' : currentPath;
            const activeLink = menu.querySelector(`a[data-path="${targetPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }

    // Handle Settings dropdown items
    if (currentPath === 'settings.html' || currentPath === 'roles.html' || currentPath === 'activity_logs.html' || currentPath === 'system_settings.html' || currentPath === 'backup.html') {
        const settingsDropdown = Array.from(container.querySelectorAll('.sidebar-dropdown')).find(el => el.textContent.includes('Settings'));
        if (settingsDropdown) {
            const toggle = settingsDropdown.querySelector('button');
            const menu = settingsDropdown.querySelector('.dropdown-menu');
            const arrow = settingsDropdown.querySelector('.dropdown-arrow');
            
            // Expand the menu
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            toggle.classList.add('bg-[#3723db]', 'text-white');
            toggle.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
            
            // Highlight the specific active link
            const activeLink = menu.querySelector(`a[data-path="${currentPath}"]`);
            if (activeLink) {
                activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
                activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
                const dot = activeLink.querySelector('.indicator-dot');
                if (dot) {
                    dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
                    dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]', '-ml-[0.5px]');
                }
            }
        }
    }
}
