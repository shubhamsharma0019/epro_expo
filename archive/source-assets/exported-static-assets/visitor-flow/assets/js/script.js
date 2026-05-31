// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    
    // Function to load external HTML components
    async function loadComponent(id, file) {
        try {
            const response = await fetch(file);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const html = await response.text();
            const container = document.getElementById(id);
            if (container) {
                container.innerHTML = html;
            }
        } catch (error) {
            console.error(`Error loading ${file}:`, error);
        }
    }

    // Load Sidebar and Header simultaneously
    Promise.all([
        loadComponent('sidebar-container', '../partials/sidebar.html'),
        loadComponent('header-container', '../partials/header.html')
    ]).then(() => {
        // Highlight active nav link based on current page
        const currentPath = window.location.pathname;
        const filename = currentPath.split('/').pop().toLowerCase() || 'home.html';
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const pathData = link.getAttribute('data-path');
            if (pathData && filename.includes(pathData)) {
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

        console.log('Components loaded successfully.');
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
    },
    "105": {
        id: "105",
        name: "SmartVision Systems",
        subtitle: "SmartVision",
        subtitle2: "Systems",
        logoColor: "bg-[#0F172A]",
        logoText: '<i class="ph-fill ph-hexagon text-blue-400"></i>',
        category: "Computer Vision",
        description: "Computer vision solutions for industry automation.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 105",
        website: "www.smartvision.systems",
        employees: "60+ Employees",
        email: "hello@smartvision.systems",
        country: "India",
        about: "SmartVision Systems builds computer vision products for inspection, safety, and industrial automation.",
        about2: "Their solutions help factories detect defects, monitor operations, and improve quality with real-time visual intelligence.",
        repName: "Priya Mehta",
        repTitle: "Product Lead",
        repEmail: "priya@smartvision.systems",
        repPhone: "+91 98765 44110",
        repImg: "https://randomuser.me/api/portraits/women/50.jpg"
    },
    "106": {
        id: "106",
        name: "Aivo Matrix",
        subtitle: "Aivo",
        subtitle2: "Matrix",
        logoColor: "bg-[#0D9488]",
        logoText: '<i class="ph-fill ph-circles-three"></i>',
        category: "AI & Automation",
        description: "AI-powered chatbots and automation platform.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 106",
        website: "www.aivomatrix.com",
        employees: "35+ Employees",
        email: "connect@aivomatrix.com",
        country: "Singapore",
        about: "Aivo Matrix helps teams automate support, sales, and operations with conversational AI.",
        about2: "The platform connects workflows, knowledge bases, and analytics into one automation layer.",
        repName: "Arjun Rao",
        repTitle: "Solutions Consultant",
        repEmail: "arjun@aivomatrix.com",
        repPhone: "+65 8123 4567",
        repImg: "https://randomuser.me/api/portraits/men/46.jpg"
    },
    "107": {
        id: "107",
        name: "RoboticsCore",
        subtitle: "RoboticsCore",
        subtitle2: "",
        logoColor: "bg-[#F97316]",
        logoText: '<i class="ph-fill ph-robot"></i>',
        category: "Robotics",
        description: "Industrial robotics and smart factory solutions.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 107",
        website: "www.roboticscore.io",
        employees: "90+ Employees",
        email: "info@roboticscore.io",
        country: "Germany",
        about: "RoboticsCore designs robotic automation systems for manufacturing, logistics, and inspection.",
        about2: "Their modular robots and control software support smart factory transformation.",
        repName: "Lena Fischer",
        repTitle: "Regional Sales Manager",
        repEmail: "lena@roboticscore.io",
        repPhone: "+49 30 5550 1288",
        repImg: "https://randomuser.me/api/portraits/women/32.jpg"
    },
    "108": {
        id: "108",
        name: "NeuralSoft",
        subtitle: "NeuralSoft",
        subtitle2: "",
        logoColor: "bg-[#1E1B4B]",
        logoText: '<i class="ph-fill ph-brain"></i>',
        category: "AI & Automation",
        description: "Deep learning applications for business growth.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 108",
        website: "www.neuralsoft.ai",
        employees: "120+ Employees",
        email: "hello@neuralsoft.ai",
        country: "United States",
        about: "NeuralSoft develops deep learning products for forecasting, personalization, and decision intelligence.",
        about2: "Their AI applications are built for enterprise scale and measurable business outcomes.",
        repName: "Michael Turner",
        repTitle: "AI Strategy Director",
        repEmail: "michael@neuralsoft.ai",
        repPhone: "+1 415 555 0144",
        repImg: "https://randomuser.me/api/portraits/men/18.jpg"
    },
    "109": {
        id: "109",
        name: "CognifyAI",
        subtitle: "CognifyAI",
        subtitle2: "",
        logoColor: "bg-[#059669]",
        logoText: '<i class="ph-bold ph-share-network"></i>',
        category: "AI & Automation",
        description: "Next-gen AI for predictive insights.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 109",
        website: "www.cognifyai.com",
        employees: "55+ Employees",
        email: "team@cognifyai.com",
        country: "United Kingdom",
        about: "CognifyAI turns operational data into predictive insights for business teams.",
        about2: "Their products help companies anticipate demand, risk, and performance trends.",
        repName: "Oliver Smith",
        repTitle: "Partnerships Lead",
        repEmail: "oliver@cognifyai.com",
        repPhone: "+44 20 7788 0190",
        repImg: "https://randomuser.me/api/portraits/men/51.jpg"
    },
    "110": {
        id: "110",
        name: "InsightEdge",
        subtitle: "InsightEdge",
        subtitle2: "",
        logoColor: "bg-[#0F172A]",
        logoText: '<i class="ph-bold ph-hexagon text-[#A855F7]"></i>',
        category: "Data & Analytics",
        description: "Advanced analytics and AI consulting.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 110",
        website: "www.insightedge.ai",
        employees: "75+ Employees",
        email: "contact@insightedge.ai",
        country: "Canada",
        about: "InsightEdge provides analytics platforms and AI consulting for high-growth organizations.",
        about2: "Their teams deliver dashboards, data products, and machine learning workflows.",
        repName: "Nora Wilson",
        repTitle: "Analytics Consultant",
        repEmail: "nora@insightedge.ai",
        repPhone: "+1 604 555 0130",
        repImg: "https://randomuser.me/api/portraits/women/22.jpg"
    },
    "111": {
        id: "111",
        name: "AutoPilot RPA",
        subtitle: "AutoPilot",
        subtitle2: "RPA",
        logoColor: "bg-[#4A22E0]",
        logoText: '<i class="ph-bold ph-robot"></i>',
        category: "Robotics",
        description: "RPA solutions to streamline business.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 111",
        website: "www.autopilotrpa.com",
        employees: "48+ Employees",
        email: "sales@autopilotrpa.com",
        country: "India",
        about: "AutoPilot RPA automates repetitive business tasks across finance, HR, and operations.",
        about2: "Their automation bots integrate with existing tools and reduce manual processing.",
        repName: "Karan Gupta",
        repTitle: "Automation Specialist",
        repEmail: "karan@autopilotrpa.com",
        repPhone: "+91 99887 77665",
        repImg: "https://randomuser.me/api/portraits/men/29.jpg"
    },
    "112": {
        id: "112",
        name: "VisionNova",
        subtitle: "VisionNova",
        subtitle2: "",
        logoColor: "bg-[#1D4ED8]",
        logoText: 'V',
        category: "Computer Vision",
        description: "Empowering machines to see and understand.",
        location: "Hall 1 - AI & IA",
        booth: "Booth 112",
        website: "www.visionnova.ai",
        employees: "40+ Employees",
        email: "hello@visionnova.ai",
        country: "Australia",
        about: "VisionNova creates computer vision models for retail, logistics, and manufacturing teams.",
        about2: "Their platform turns camera feeds into real-time operational insights.",
        repName: "Emma Clarke",
        repTitle: "Customer Success Manager",
        repEmail: "emma@visionnova.ai",
        repPhone: "+61 2 5550 0191",
        repImg: "https://randomuser.me/api/portraits/women/58.jpg"
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
});
