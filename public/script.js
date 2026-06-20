// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    
    // Function to load external HTML components if empty
    async function loadComponentIfEmpty(id, file) {
        const container = document.getElementById(id);
        if (!container) return;
        
        // If container already has content (pre-rendered via @include), skip fetch
        if (container.children.length > 0 || container.innerHTML.trim() !== '') {
            return;
        }
        
        try {
            const response = await fetch(file);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const html = await response.text();
            container.innerHTML = html;
        } catch (error) {
            console.error(`Error loading ${file}:`, error);
        }
    }

    // Load Sidebar and Header if empty, then run post-load layout & nav styling
    Promise.all([
        loadComponentIfEmpty('sidebar-container', 'sidebar.html'),
        loadComponentIfEmpty('header-container', 'header.html')
    ]).then(() => {
        // Highlight active nav link based on current page
        const currentPath = window.location.pathname;
        const filename = currentPath.split('/').pop().toLowerCase() || 'home.html';
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const pathData = link.getAttribute('data-path');
            if (pathData && (filename.includes(pathData) || (pathData === 'hall' && (filename === 'view-floor-map.html' || filename === 'exhibitor-details.html')))) {
                link.className = "nav-link flex items-center gap-4 mx-4 px-4 py-2.5 rounded-xl font-bold text-[13px] transition-colors";
                link.style.backgroundColor = "#F5F3FF"; // primary-50
                link.style.color = "#4A22E0"; // primary-600
                // Show the indicator
                const indicator = link.previousElementSibling;
                if (indicator && indicator.classList.contains('nav-indicator')) {
                    indicator.classList.remove('hidden');
                }
                // Update icon class if needed
                const icon = link.querySelector('.nav-icon');
                if (icon) {
                    icon.classList.remove('ph');
                    icon.classList.add('ph-bold');
                }
            }
        });

        // Make sidebar-container responsive dynamically
        const sidebarContainer = document.getElementById('sidebar-container');
        if (sidebarContainer) {
            sidebarContainer.className = "hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white";
        }

        // Adjust scrollable content wrapper padding and spacing dynamically for mobile
        const scrollableWrapper = document.querySelector('main div.overflow-y-auto');
        if (scrollableWrapper) {
            scrollableWrapper.classList.remove('px-12', 'px-8', 'p-8');
            scrollableWrapper.classList.add('px-4', 'py-6', 'md:px-12', 'md:py-8', 'pb-8');
        }

        console.log('Components loaded and responsive features initialized successfully.');
    });

    // Carousel scrolling logic
    const carousel = document.getElementById('carousel');
    const scrollRightBtn = document.getElementById('scrollRight');

    if (carousel && scrollRightBtn) {
        scrollRightBtn.addEventListener('click', () => {
            // Scroll by one card width + gap (approx 334px)
            carousel.scrollBy({ left: 334, behavior: 'smooth' });
        });
        
        // Hide button if scrolled to the very end
        carousel.addEventListener('scroll', () => {
            const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;
            if (carousel.scrollLeft >= maxScrollLeft - 10) {
                scrollRightBtn.style.opacity = '0';
                scrollRightBtn.style.pointerEvents = 'none';
            } else {
                scrollRightBtn.style.opacity = '1';
                scrollRightBtn.style.pointerEvents = 'auto';
            }
        });
    }
});
const exhibitors = {
    "101": {
        id: "101",
        name: "TechNext Solutions Pvt. Ltd.",
        subtitle: "TechNext",
        subtitle2: "Solutions",
        logoColor: "bg-blue-500",
        logoText: "TN",
        category: "AI & Automation",
        description: "Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 101",
        website: "www.technext.com",
        employees: "45+ Employees",
        email: "info@technext.com",
        country: "India",
        about: "TechNext Solutions is a leading provider of AI, machine learning, and intelligent automation solutions. We help businesses transform operations, enhance customer experiences, and drive data-informed decisions.",
        about2: "Our end-to-end services include AI consulting, custom software development, RPA, computer vision, and predictive analytics.",
        repName: "Rahul Sharma",
        repTitle: "Business Development Manager",
        repEmail: "rahul.sharma@technext.com",
        repPhone: "+91 98765 43210",
        repImg: "https://randomuser.me/api/portraits/men/32.jpg"
    },
    "102": {
        id: "102",
        name: "InnovaAI Labs",
        subtitle: "InnovaAI",
        subtitle2: "Labs",
        logoColor: "bg-indigo-600",
        logoText: '<i class="ph-fill ph-chart-bar"></i>',
        category: "Machine Learning",
        description: "Building intelligent models for real-world impact and actionable data analytics.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 102",
        website: "www.innovaalabs.com",
        employees: "20+ Employees",
        email: "contact@innovaalabs.com",
        country: "United States",
        about: "InnovaAI Labs specializes in deep learning and natural language processing to solve complex industry problems.",
        about2: "We partner with top enterprises to deploy scalable machine learning models.",
        repName: "Sarah Jenkins",
        repTitle: "Lead Data Scientist",
        repEmail: "sarah.j@innovaalabs.com",
        repPhone: "+1 555-0198",
        repImg: "https://randomuser.me/api/portraits/women/44.jpg"
    },
    "103": {
        id: "103",
        name: "DataMind Analytics",
        subtitle: "DataMind",
        subtitle2: "Analytics",
        logoColor: "bg-blue-600",
        logoText: '<i class="ph-fill ph-database mr-1"></i> DM',
        category: "Data & Analytics",
        description: "Data analytics platforms for smarter decisions and operational intelligence.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 103",
        website: "www.datamind.io",
        employees: "150+ Employees",
        email: "hello@datamind.io",
        country: "United Kingdom",
        about: "DataMind Analytics is the leading big data platform for high-velocity transaction environments.",
        about2: "Empowering teams with real-time dashboards, predictive models, and self-service BI.",
        repName: "David Chen",
        repTitle: "VP of Sales",
        repEmail: "david.c@datamind.io",
        repPhone: "+44 20 7123 4567",
        repImg: "https://randomuser.me/api/portraits/men/62.jpg"
    },
    "104": {
        id: "104",
        name: "CloudSphere Tech",
        subtitle: "CloudSphere",
        subtitle2: "Tech",
        logoColor: "bg-[#0F172A]",
        logoText: '<i class="ph-fill ph-cloud text-sky-400"></i>',
        category: "Cloud Computing",
        description: "Scalable cloud solutions for modern businesses.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 104",
        website: "www.cloudsphere.tech",
        employees: "80+ Employees",
        email: "support@cloudsphere.tech",
        country: "Canada",
        about: "CloudSphere Tech provides secure and scalable cloud infrastructure for enterprises globally.",
        about2: "We help companies migrate, manage, and optimize their cloud environments.",
        repName: "Elena Rodriguez",
        repTitle: "Cloud Solutions Architect",
        repEmail: "elena.r@cloudsphere.tech",
        repPhone: "+1 416 555 0192",
        repImg: "https://randomuser.me/api/portraits/women/68.jpg"
    }
};

function initExhibitorDetails() {
    if (!window.location.pathname.includes('exhibitor-details.html')) return;

    const urlParams = new URLSearchParams(window.location.search);
    const exhibitorId = urlParams.get('id') || '101';
    const data = exhibitors[exhibitorId] || exhibitors['101'];

    const elements = {
        'exh-name': data.name,
        'exh-subtitle': data.subtitle,
        'exh-subtitle2': data.subtitle2,
        'exh-category': data.category,
        'exh-desc': data.description,
        'exh-location': data.location,
        'exh-booth': data.booth,
        'exh-booth-badge': data.booth,
        'exh-website': data.website,
        'exh-employees': data.employees,
        'exh-email': data.email,
        'exh-country': data.country,
        'exh-about': data.about,
        'exh-about2': data.about2,
        'exh-rep-name': data.repName,
        'exh-rep-title': data.repTitle,
        'exh-rep-email-text': data.repEmail,
        'exh-rep-phone': data.repPhone,
        'exh-about-name': 'About ' + data.subtitle
    };

    for (const [id, value] of Object.entries(elements)) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    }
    
    const logoEl = document.getElementById('exh-logo-text');
    if (logoEl) logoEl.innerHTML = data.logoText;

    const logoContainer = document.getElementById('exh-logo-container');
    if (logoContainer) {
        logoContainer.className = 'w-20 h-20 rounded-lg flex items-center justify-center mb-3 ' + data.logoColor;
    }

    const repImg = document.getElementById('exh-rep-img');
    if (repImg) repImg.src = data.repImg;
    
    const websiteLink = document.getElementById('exh-website');
    if (websiteLink) websiteLink.href = 'https://' + data.website;
    
    const emailLink = document.getElementById('exh-email');
    if (emailLink) emailLink.href = 'mailto:' + data.email;
}

document.addEventListener('DOMContentLoaded', () => {
    initExhibitorDetails();
    setupVisitsButtons();
});

// My Visits LocalStorage Management Helpers
function isVisited(type, id) {
    let visits = JSON.parse(localStorage.getItem('my_visits') || '[]');
    return visits.some(v => v.type === type && v.id === id);
}

function toggleVisitItem(type, id, title, subtitle, imageUrl, extra) {
    let visits = JSON.parse(localStorage.getItem('my_visits') || '[]');
    const idx = visits.findIndex(v => v.type === type && v.id === id);
    if (idx !== -1) {
        visits.splice(idx, 1);
        localStorage.setItem('my_visits', JSON.stringify(visits));
        showToast("Removed from My Visits");
        return false;
    } else {
        visits.push({ type, id, title, subtitle, imageUrl, extra });
        localStorage.setItem('my_visits', JSON.stringify(visits));
        showToast("Added to My Visits!");
        return true;
    }
}

function showToast(message) {
    let toast = document.getElementById('custom-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.className = 'fixed bottom-6 right-6 z-[100] bg-[#1E1B4B] text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-[13px] font-bold transition-all duration-300 opacity-0 transform translate-y-2';
        document.body.appendChild(toast);
    }
    toast.innerHTML = `<i class="ph-bold ph-check-circle text-green-400 text-[18px]"></i> <span>${message}</span>`;
    toast.classList.remove('opacity-0', 'translate-y-2');
    toast.classList.add('opacity-100', 'translate-y-0');
    
    setTimeout(() => {
        toast.classList.remove('opacity-100', 'translate-y-0');
        toast.classList.add('opacity-0', 'translate-y-2');
    }, 3000);
}

function updateButtonState(btn, active) {
    const icon = btn.querySelector('i');
    if (active) {
        btn.innerHTML = `<i class="ph-fill ph-bookmark-simple text-[18px]"></i> Remove from Visits`;
        btn.classList.add('bg-red-50', 'text-red-600', 'border-red-200');
        btn.classList.remove('bg-[#4A22E0]', 'text-white', 'text-primary-600');
    } else {
        btn.innerHTML = `<i class="ph ph-bookmark-simple text-[18px]"></i> Add to My Visits`;
        btn.classList.remove('bg-red-50', 'text-red-600', 'border-red-200');
    }
}

function updateIconState(icon, active) {
    if (active) {
        icon.className = icon.className.replace('ph ', 'ph-fill ').replace('text-primary-500', 'text-primary-600');
        if (!icon.className.includes('ph-fill')) {
            icon.className = 'ph-fill ph-bookmark-simple text-primary-600 text-[18px] cursor-pointer';
        }
    } else {
        icon.className = icon.className.replace('ph-fill ', 'ph ').replace('text-primary-600', 'text-primary-500');
    }
}

function setupVisitsButtons() {
    const urlParams = new URLSearchParams(window.location.search);
    const path = window.location.pathname.toLowerCase();
    
    let type = '';
    let id = '';
    let getTitle = () => '';
    let getSubtitle = () => '';
    let getImageUrl = () => '';
    let getExtra = () => '';

    if (path.includes('pavilion-details')) {
        type = 'pavilion';
        id = urlParams.get('id') || 'tech';
        getTitle = () => document.getElementById('dyn-title')?.textContent || '';
        getSubtitle = () => document.getElementById('dyn-subtitle')?.textContent || '';
        getImageUrl = () => {
            const bg = document.getElementById('dyn-hero-bg')?.style.backgroundImage;
            return bg ? bg.slice(5, -2).replace(/['"]/g, '') : '';
        };
        getExtra = () => document.getElementById('dyn-hero-badge')?.textContent || '';
    } else if (path.includes('hall-details')) {
        type = 'hall';
        id = urlParams.get('id') || 'hall1';
        getTitle = () => document.getElementById('dyn-hall-title')?.textContent || '';
        getSubtitle = () => document.getElementById('dyn-hall-subtitle')?.textContent || '';
        getImageUrl = () => document.getElementById('dyn-hall-img')?.src || '';
        getExtra = () => document.getElementById('dyn-hall-badge')?.textContent || '';
    } else if (path.includes('exhibitor-details')) {
        type = 'exhibitor';
        id = urlParams.get('id') || '101';
        getTitle = () => document.getElementById('exh-name')?.textContent || '';
        getSubtitle = () => document.getElementById('exh-category')?.textContent || '';
        getImageUrl = () => '';
        getExtra = () => document.getElementById('exh-booth')?.textContent || '';
    }

    // Bind to details page buttons
    const visitButtons = Array.from(document.querySelectorAll('button')).filter(btn => 
        btn.textContent.includes('Add to My Visits') || btn.textContent.includes('Remove from Visits')
    );

    visitButtons.forEach(btn => {
        if (type && id) {
            const active = isVisited(type, id);
            updateButtonState(btn, active);
            
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const isAdded = toggleVisitItem(type, id, getTitle(), getSubtitle(), getImageUrl(), getExtra());
                updateButtonState(btn, isAdded);
            });
        }
    });

    // Bind to inline card bookmark icons
    const bookmarkIcons = Array.from(document.querySelectorAll('.ph-bookmark-simple, .ph-fill.ph-bookmark-simple'));
    bookmarkIcons.forEach(icon => {
        icon.classList.add('cursor-pointer');
        icon.style.transition = 'transform 0.2s';
        
        let card = icon.closest('.border') || icon.closest('.group') || icon.closest('.flex');
        if (card) {
            let cardNameEl = card.querySelector('h4, .font-bold') || card.querySelector('h3');
            let cardSubtitleEl = card.querySelector('p, .text-gray-500');
            let cardExtraEl = card.querySelector('.font-bold.text-primary-600, .bg-primary-50, .text-primary-600');
            
            if (cardNameEl) {
                const cardName = cardNameEl.textContent.trim();
                const cardId = cardName.toLowerCase().replace(/[^a-z0-9]/g, '');
                const cardType = 'exhibitor';
                
                const active = isVisited(cardType, cardId);
                updateIconState(icon, active);

                icon.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const title = cardName;
                    const subtitle = cardSubtitleEl ? cardSubtitleEl.textContent.trim() : '';
                    const extra = cardExtraEl ? cardExtraEl.textContent.trim() : '';
                    const isAdded = toggleVisitItem(cardType, cardId, title, subtitle, '', extra);
                    updateIconState(icon, isAdded);
                });
            }
        }
    });
}

