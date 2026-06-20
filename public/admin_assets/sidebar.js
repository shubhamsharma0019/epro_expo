/** Shared sidebar loader + generic active state */
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
    document.getElementById(containerId).innerHTML = '<div class="p-4 text-red-500">Failed to load sidebar. Please run through a local server like VS Code Live Server.</div>';
  }
}

function initializeSidebarInteractions() {
  document.querySelectorAll('.sidebar-dropdown > button').forEach(toggle => {
    toggle.addEventListener('click', () => {
      const menu = toggle.nextElementSibling;
      const arrow = toggle.querySelector('.dropdown-arrow');
      if (menu) menu.classList.toggle('hidden');
      if (arrow) arrow.classList.toggle('rotate-180');
    });
  });
}

function setActiveSidebarItem() {
  const currentPath = window.location.pathname.split('/').pop() || 'admin_dashboard.html';
  const container = document.getElementById('sidebar-container');
  if (!container) return;

  container.querySelectorAll('a').forEach(a => {
    a.classList.remove('bg-[#2b228b]', 'bg-white/10', 'text-white', 'font-semibold', 'font-medium', 'shadow-md');
    if (!a.closest('.dropdown-menu')) a.classList.add('hover:bg-white/5', 'text-[#a0aabf]');
  });

  const activeLink = container.querySelector(`a[href="${currentPath}"], a[data-path="${currentPath}"]`);
  if (!activeLink) return;

  if (activeLink.closest('.dropdown-menu')) {
    activeLink.classList.remove('text-[#a0aabf]', 'hover:text-white', 'hover:bg-white/5');
    activeLink.classList.add('text-white', 'bg-white/10', 'font-medium');
    const dot = activeLink.querySelector('.indicator-dot');
    if (dot) {
      dot.classList.remove('bg-white/30', 'group-hover:bg-white/50', 'w-[4px]', 'h-[4px]');
      dot.classList.add('bg-[#a855f7]', 'shadow-[0_0_8px_#a855f7]', 'w-[5px]', 'h-[5px]');
    }
    const dropdown = activeLink.closest('.sidebar-dropdown');
    const menu = dropdown.querySelector('.dropdown-menu');
    const button = dropdown.querySelector('button');
    const arrow = dropdown.querySelector('.dropdown-arrow');
    if (menu) menu.classList.remove('hidden');
    if (arrow) arrow.classList.add('rotate-180');
    if (button) {
      button.classList.add('bg-[#3723db]', 'text-white');
      button.classList.remove('text-[#a0aabf]', 'hover:bg-white/5');
    }
  } else {
    activeLink.classList.add('bg-[#2b228b]', 'text-white', 'shadow-md');
    activeLink.classList.remove('hover:bg-white/5', 'text-[#a0aabf]');
  }
}
