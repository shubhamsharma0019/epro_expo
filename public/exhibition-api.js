// EproExpo Exhibition Visitor Flow - API Integration Helper
const EXHIBITION_API_BASE = '/api/exhibitions';

// Mock Data for Offline Fallbacks
const MOCK_EXHIBITIONS = [
    {
        id: 1,
        name: 'Global Tech Summit 2024',
        start_date: '2026-05-15',
        end_date: '2026-05-17',
        venue: 'Jio World Convention Centre, Mumbai, India',
        description: 'Experience next-generation tech breakthroughs in enterprise systems and engineering.',
        companies_count: 120,
        banner_url: 'https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=800&q=80'
    },
    {
        id: 2,
        name: 'Future of AI Expo',
        start_date: '2026-06-10',
        end_date: '2026-06-12',
        venue: 'Bengaluru Convention Centre, Bengaluru, India',
        description: 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
        companies_count: 80,
        banner_url: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80'
    },
    {
        id: 3,
        name: 'Sustainability World Expo',
        start_date: '2026-08-08',
        end_date: '2026-08-10',
        venue: 'Pune International Exhibition Centre, Pune, India',
        description: 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
        companies_count: 85,
        banner_url: 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80'
    }
];

const MOCK_EXHIBITORS = [
    {
        id: 101,
        exhibition_id: 1,
        hall_name: 'Hall 1 - AI & IA',
        booth_number: 'Booth 101',
        name: 'TechNext Solutions Pvt. Ltd.',
        category: 'AI & Automation',
        description: 'Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.',
        website: 'www.technext.com',
        email: 'info@technext.com',
        country: 'India',
        rep_name: 'Rahul Sharma',
        rep_title: 'Business Development Manager',
        rep_email: 'rahul.sharma@technext.com',
        rep_phone: '+91 98765 43210',
        rep_img_url: 'https://randomuser.me/api/portraits/men/32.jpg',
        logo_color: 'bg-blue-500',
        logo_text: 'TN'
    },
    {
        id: 102,
        exhibition_id: 1,
        hall_name: 'Hall 1 - AI & IA',
        booth_number: 'Booth 102',
        name: 'InnovaAI Labs',
        category: 'Machine Learning',
        description: 'Building intelligent models for real-world impact and actionable data analytics.',
        website: 'www.innovaalabs.com',
        email: 'contact@innovaalabs.com',
        country: 'United States',
        rep_name: 'Sarah Jenkins',
        rep_title: 'Lead Data Scientist',
        rep_email: 'sarah.j@innovaalabs.com',
        rep_phone: '+1 555-0198',
        rep_img_url: 'https://randomuser.me/api/portraits/women/44.jpg',
        logo_color: 'bg-indigo-600',
        logo_text: '<i class="ph-fill ph-chart-bar"></i>'
    },
    {
        id: 103,
        exhibition_id: 1,
        hall_name: 'Hall 1 - AI & IA',
        booth_number: 'Booth 103',
        name: 'DataMind Analytics',
        category: 'Data & Analytics',
        description: 'Data analytics platforms for smarter decisions and operational intelligence.',
        website: 'www.datamind.io',
        email: 'hello@datamind.io',
        country: 'United Kingdom',
        rep_name: 'David Chen',
        rep_title: 'VP of Sales',
        rep_email: 'david.c@datamind.io',
        rep_phone: '+44 20 7123 4567',
        rep_img_url: 'https://randomuser.me/api/portraits/men/62.jpg',
        logo_color: 'bg-blue-600',
        logo_text: '<i class="ph-fill ph-database mr-1"></i> DM'
    },
    {
        id: 104,
        exhibition_id: 1,
        hall_name: 'Hall 1 - AI & IA',
        booth_number: 'Booth 104',
        name: 'CloudSphere Tech',
        category: 'Cloud Computing',
        description: 'Scalable cloud solutions for modern businesses.',
        website: 'www.cloudsphere.tech',
        email: 'support@cloudsphere.tech',
        country: 'Canada',
        rep_name: 'Elena Rodriguez',
        rep_title: 'Cloud Solutions Architect',
        rep_email: 'elena.r@cloudsphere.tech',
        rep_phone: '+1 416 555 0192',
        rep_img_url: 'https://randomuser.me/api/portraits/women/68.jpg',
        logo_color: 'bg-[#0F172A]',
        logo_text: '<i class="ph-fill ph-cloud text-sky-400"></i>'
    }
];

const MOCK_PAVILIONS = [
    {
        id: 'tech',
        title: 'Technology & AI',
        badge: 'AI SOLUTIONS',
        subtitle: 'Innovate the future with intelligent solutions',
        description: 'Step into the future with breakthrough technologies in artificial intelligence, machine learning, automation, data analytics, and next-gen enterprise solutions.',
        image_url: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
        companies_count: '8+ Companies',
        products_count: '120+ Products',
        visitors_count: '2,500+ Visitors',
        category: 'Technology',
        about_desc: '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Technology & AI Pavilion brings together leading innovators and solution providers who are transforming industries through artificial intelligence, machine learning, data analytics, cloud computing, and intelligent automation.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore cutting-edge solutions, connect with experts, and discover how emerging technologies can drive growth and efficiency for your business.</p>'
    },
    {
        id: 'manufacturing',
        title: 'Manufacturing & Pharma',
        badge: 'MANUFACTURING',
        subtitle: 'Discover innovations in manufacturing and pharmaceutical industries.',
        description: 'Explore the latest in automated production lines, pharmaceutical research, and industrial automation shaping the future of global supply chains.',
        image_url: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
        companies_count: '20+ Companies',
        products_count: '350+ Products',
        visitors_count: '4,200+ Visitors',
        category: 'Manufacturing',
        about_desc: '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Manufacturing & Pharma Pavilion showcases state-of-the-art production technologies and pharmaceutical breakthroughs.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Join industry leaders to explore automated manufacturing, quality control tech, and innovative supply chain solutions.</p>'
    },
    {
        id: 'smart',
        title: 'Smart Manufacturing',
        badge: 'SMART FACTORY',
        subtitle: 'Experience smart factories, automation, and industrial IoT.',
        description: 'Dive into the world of Industry 4.0 with live demonstrations of IoT devices, smart sensors, and fully automated robotics systems.',
        image_url: 'https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&w=800&q=80',
        companies_count: '15+ Companies',
        products_count: '200+ Products',
        visitors_count: '3,100+ Visitors',
        category: 'Industrial IoT',
        about_desc: '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Smart Manufacturing Pavilion is dedicated to the evolution of factories and production environments through connectivity.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Discover IoT solutions, advanced robotics, and real-time data analytics designed to maximize industrial efficiency.</p>'
    },
    {
        id: 'green',
        title: 'Green Energy',
        badge: 'SUSTAINABILITY',
        subtitle: 'Find sustainable energy solutions for a greener planet.',
        description: 'Discover solutions for a greener and sustainable tomorrow. Explore renewable energy sources, green tech, and ESG solutions.',
        image_url: 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
        companies_count: '50+ Companies',
        products_count: '85+ Products',
        visitors_count: '5,000+ Visitors',
        category: 'Renewable Energy',
        about_desc: '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Green Energy Pavilion brings together innovative companies focused on building a better, more sustainable future.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore products, solutions, and insights driving sustainability across industries, including solar, wind, and circular economy.</p>'
    },
    {
        id: 'startups',
        title: 'Startups',
        badge: 'INNOVATION',
        subtitle: 'Meet innovative startups and future disruptors.',
        description: 'Connect with the brightest minds and rising companies that are disrupting traditional industries with fresh ideas and agile execution.',
        image_url: 'https://images.unsplash.com/photo-1559136555-9ce7b5fda016?auto=format&fit=crop&w=800&q=80',
        companies_count: '60+ Companies',
        products_count: '150+ Products',
        visitors_count: '6,500+ Visitors',
        category: 'Startups',
        about_desc: '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Startups Pavilion is a buzzing hub of innovation, featuring young companies with groundbreaking technologies and solutions.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Network with founders, experience raw innovation, and discover the next big disruptors before they hit the mainstream market.</p>'
    }
];

const MOCK_HALLS = [
    {
        id: 'hall1',
        badge: 'Hall 1',
        title: 'Hall 1 – AI & IA',
        subtitle: 'Artificial Intelligence & Intelligent Automation solutions.',
        description: 'Explore the latest in AI, machine learning, robotic process automation, and intelligent systems that are transforming industries.',
        image_url: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
        category: 'Technology',
        area: '12,500 sqm',
        exhibitors_count: '45+',
        booths_count: '350+'
    },
    {
        id: 'hall2',
        badge: 'Hall 2',
        title: 'Hall 2 – Cloud & DevOps',
        subtitle: 'Cloud computing, DevOps, and infrastructure solutions.',
        description: 'Discover next-generation cloud platforms, containerization strategies, and robust DevOps pipelines accelerating digital transformation.',
        image_url: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80',
        category: 'Infrastructure',
        area: '10,000 sqm',
        exhibitors_count: '38+',
        booths_count: '280+'
    },
    {
        id: 'hall3',
        badge: 'Hall 3',
        title: 'Hall 3 – Green Energy',
        subtitle: 'Renewable energy, sustainability, and environmental solutions.',
        description: 'Connect with leaders in solar, wind, and sustainable manufacturing working towards a zero-carbon, greener future.',
        image_url: 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
        category: 'Sustainability',
        area: '11,200 sqm',
        exhibitors_count: '32+',
        booths_count: '220+'
    },
    {
        id: 'hall4',
        badge: 'Hall 4',
        title: 'Hall 4 – Manufacturing',
        subtitle: 'Smart manufacturing, robotics, and industrial automation.',
        description: 'Experience live demonstrations of heavy machinery, smart factory layouts, and collaborative robotics on the exhibition floor.',
        image_url: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
        category: 'Industrial',
        area: '14,000 sqm',
        exhibitors_count: '40+',
        booths_count: '310+'
    }
];

// Helper Functions
const ExhibitionAPI = {
    // 1. Fetch all exhibitions
    async getExhibitions() {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Exhibitions API connection failed, using mock exhibitions fallback.');
            return MOCK_EXHIBITIONS;
        }
    },

    // 2. Fetch specific exhibition details
    async getExhibition(id) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${id}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Exhibition API details failed for id: ${id}, using mock fallback.`);
            const normalizedId = isNaN(id) ? id : parseInt(id);
            if (typeof normalizedId === 'string') {
                return MOCK_EXHIBITIONS.find(ex => ex.name.toLowerCase().includes(normalizedId.toLowerCase())) || MOCK_EXHIBITIONS[0];
            }
            return MOCK_EXHIBITIONS.find(ex => ex.id === normalizedId) || MOCK_EXHIBITIONS[0];
        }
    },

    // 3. Fetch exhibitors for a specific exhibition
    async getExhibitors(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/exhibitors`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Exhibitors API connection failed, using mock booths fallback.');
            return MOCK_EXHIBITORS.filter(exh => exh.exhibition_id === parseInt(exhibitionId)) || MOCK_EXHIBITORS;
        }
    },

    // 4. Fetch specific exhibitor booth card
    async getExhibitor(exhibitorId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/exhibitors/${exhibitorId}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Exhibitor API failed for id: ${exhibitorId}, using mock fallback.`);
            return MOCK_EXHIBITORS.find(ex => ex.id === parseInt(exhibitorId)) || MOCK_EXHIBITORS[0];
        }
    },

    // 5. Submit visitor details registration
    async registerVisitor(exhibitionId, visitorData) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(visitorData)
            });
            if (response.ok) {
                const result = await response.json();
                return result.visitor;
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Visitor registration API connection failed, creating client mock profile.');
            // Client-side local mock registration profile
            const randomNum = Math.floor(100000 + Math.random() * 900000);
            const bookingId = 'EXP-260528-' + randomNum;
            const visitor = {
                ...visitorData,
                booking_id: bookingId,
                payment_status: visitorData.amount > 0 ? 'pending' : 'completed',
                checkin_status: false,
                checkin_time: null
            };
            // Save to client offline db
            let offlineBookings = JSON.parse(localStorage.getItem('offline_visitor_bookings') || '[]');
            offlineBookings.push(visitor);
            localStorage.setItem('offline_visitor_bookings', JSON.stringify(offlineBookings));
            return visitor;
        }
    },

    // 6. Confirm payment status updates
    async confirmPayment(bookingId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/visitors/${bookingId}/payment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const result = await response.json();
                return result.visitor;
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Payment API connection failed, confirming locally.');
            // Check offline storage first
            let offlineBookings = JSON.parse(localStorage.getItem('offline_visitor_bookings') || '[]');
            const idx = offlineBookings.findIndex(b => b.booking_id === bookingId);
            if (idx !== -1) {
                offlineBookings[idx].payment_status = 'completed';
                localStorage.setItem('offline_visitor_bookings', JSON.stringify(offlineBookings));
                return offlineBookings[idx];
            }
            return { booking_id: bookingId, payment_status: 'completed' };
        }
    },

    // 6a. Get all registered tickets
    async getTickets() {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/visitors/tickets`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Get tickets API failed, loading from local offline database.');
            let offlineBookings = JSON.parse(localStorage.getItem('offline_visitor_bookings') || '[]');
            return offlineBookings;
        }
    },

    // 7. Get ticket details
    async getTicketDetails(bookingId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/visitors/tickets/${bookingId}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Ticket details API connection failed, searching client offline database.');
            let offlineBookings = JSON.parse(localStorage.getItem('offline_visitor_bookings') || '[]');
            const booking = offlineBookings.find(b => b.booking_id === bookingId);
            if (booking) return booking;
            
            // Hard fallback if not registered yet
            return {
                booking_id: bookingId,
                first_name: 'John',
                last_name: 'Doe',
                email: 'john.doe@email.com',
                mobile: '+91 98765 43210',
                job_title: 'Product Manager',
                company: 'TechNext Solutions Pvt. Ltd.',
                country: 'India',
                state: 'Maharashtra',
                city: 'Mumbai',
                industry: 'Technology',
                company_size: '51 - 200 Employees',
                business_address: '401, Infinity Tower, Mindspace, Malad West',
                pass_type: 'Free Visitor Pass',
                amount: 0.00,
                payment_status: 'completed',
                checkin_status: false,
                checkin_time: null
            };
        }
    },

    // 8. Submit Check-in
    async checkIn(bookingId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/visitors/${bookingId}/check-in`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const result = await response.json();
                return result.visitor;
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Check-in API connection failed, completing check-in locally.');
            const now = new Date();
            const timeStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' at ' + now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            
            let offlineBookings = JSON.parse(localStorage.getItem('offline_visitor_bookings') || '[]');
            const idx = offlineBookings.findIndex(b => b.booking_id === bookingId);
            if (idx !== -1) {
                offlineBookings[idx].checkin_status = true;
                offlineBookings[idx].checkin_time = timeStr;
                localStorage.setItem('offline_visitor_bookings', JSON.stringify(offlineBookings));
                return offlineBookings[idx];
            }
            return { booking_id: bookingId, checkin_status: true, checkin_time: timeStr };
        }
    },

    // 9. Request a business meeting slot
    async requestMeeting(meetingData) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/meetings/request`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(meetingData)
            });
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Request meeting API connection failed, registering locally.');
            const meeting = {
                id: Math.floor(1000 + Math.random() * 9000),
                ...meetingData,
                status: 'pending'
            };
            let offlineMeetings = JSON.parse(localStorage.getItem('offline_visitor_meetings') || '[]');
            offlineMeetings.push(meeting);
            localStorage.setItem('offline_visitor_meetings', JSON.stringify(offlineMeetings));
            return { message: 'Meeting requested successfully (Local Override)', meeting: meeting };
        }
    },

    // 10. List meetings
    async getMeetings(bookingId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/meetings/list?booking_id=${bookingId}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('List meetings API failed, loading from local offline database.');
            let offlineMeetings = JSON.parse(localStorage.getItem('offline_visitor_meetings') || '[]');
            return offlineMeetings.filter(m => m.booking_id === bookingId);
        }
    },

    // 11. Fetch all halls
    async getHalls() {
        try {
            const response = await fetch('/api/halls');
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Halls API failed, using mock fallback.');
            return MOCK_HALLS;
        }
    },

    // 12. Fetch specific hall
    async getHall(id) {
        try {
            const response = await fetch(`/api/halls/${id}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Hall API failed for id: ${id}, using mock fallback.`);
            return MOCK_HALLS.find(h => h.id === id) || MOCK_HALLS[0];
        }
    },

    // 13. Fetch all pavilions
    async getPavilions() {
        try {
            const response = await fetch('/api/pavilions');
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn('Pavilions API failed, using mock fallback.');
            return MOCK_PAVILIONS;
        }
    },

    // 14. Fetch specific pavilion
    async getPavilion(id) {
        try {
            const response = await fetch(`/api/pavilions/${id}`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Pavilion API failed for id: ${id}, using mock fallback.`);
            return MOCK_PAVILIONS.find(p => p.id === id) || MOCK_PAVILIONS[0];
        }
    },

    // 15. Fetch exhibitor videos
    async getExhibitorVideos(exhibitorId) {
        try {
            const response = await fetch(`/api/exhibitors/${exhibitorId}/videos`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Exhibitor videos API failed for id: ${exhibitorId}`);
            return [];
        }
    },

    // 16. Fetch ticket tiers for an exhibition
    async getTicketTiers(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/ticket-tiers`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Ticket tiers API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [
                { id: 1, exhibition_id: exhibitionId, name: 'Free Visitor Pass', price: 0.00, benefits: 'Access to AI & Automation pavilions, standard sessions entry, digital certificate' },
                { id: 2, exhibition_id: exhibitionId, name: 'Business Pass', price: 999.00, benefits: 'Access to all pavilions, B2B matchmaking lounges, standard speaker sessions, catalog book' },
                { id: 3, exhibition_id: exhibitionId, name: 'VIP All-Access Pass', price: 2499.00, benefits: 'Priority check-in, VIP lounge access, invite-only keynote, VIP networking dinner' }
            ];
        }
    },

    // 17. Fetch products/brochures for an exhibitor
    async getProducts(exhibitorId) {
        try {
            const response = await fetch(`/api/exhibitors/${exhibitorId}/products`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Products API failed for exhibitorId: ${exhibitorId}, using fallback.`);
            return [];
        }
    },

    // 18. Fetch bookmarks for a visitor/booking_id
    async getBookmarks(bookingId) {
        try {
            const response = await fetch(`/api/visitors/${bookingId}/bookmarks`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Bookmarks API failed for bookingId: ${bookingId}, using localStorage fallback.`);
            const localBookmarks = JSON.parse(localStorage.getItem(`bookmarks_${bookingId}`) || '[]');
            return localBookmarks;
        }
    },

    // 19. Toggle bookmark for a visitor
    async toggleBookmark(bookingId, bookmarkableType, bookmarkableId) {
        try {
            const response = await fetch(`/api/visitors/${bookingId}/bookmarks/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bookmarkable_type: bookmarkableType,
                    bookmarkable_id: bookmarkableId
                })
            });
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Toggle bookmark API failed for bookingId: ${bookingId}, using localStorage.`);
            let localBookmarks = JSON.parse(localStorage.getItem(`bookmarks_${bookingId}`) || '[]');
            const idx = localBookmarks.findIndex(b => b.bookmarkable_type === bookmarkableType && b.bookmarkable_id == bookmarkableId);
            let status = 'added';
            if (idx !== -1) {
                localBookmarks.splice(idx, 1);
                status = 'removed';
            } else {
                localBookmarks.push({
                    booking_id: bookingId,
                    bookmarkable_type: bookmarkableType,
                    bookmarkable_id: bookmarkableId
                });
            }
            localStorage.setItem(`bookmarks_${bookingId}`, JSON.stringify(localBookmarks));
            return { status: status, message: `Bookmark ${status} successfully` };
        }
    },

    // 20. Fetch announcements for an exhibition
    async getAnnouncements(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/announcements`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Announcements API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [
                {
                    id: 1,
                    title: 'Welcome to Global Tech Summit 2024!',
                    content: 'We are thrilled to open our doors to the tech world today. Explore 100+ booths and attend our keynote presentations starting at 10 AM.',
                    type: 'general',
                    author_name: 'Organizing Committee',
                    author_avatar: 'https://randomuser.me/api/portraits/men/3.jpg',
                    created_at: new Date().toISOString()
                },
                {
                    id: 2,
                    title: 'Keynote Session starting in 15 mins',
                    content: 'Join Dr. Alan Stone in Keynote Hall A as he discusses the future of Generative AI in robotics.',
                    type: 'alert',
                    author_name: 'Keynote Host',
                    author_avatar: 'https://randomuser.me/api/portraits/women/12.jpg',
                    created_at: new Date().toISOString()
                }
            ];
        }
    },

    // 21. Fetch FAQs for an exhibition
    async getFaqs(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/faqs`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`FAQs API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [
                { id: 1, question: 'Where is the Help Desk located?', answer: 'The Central Help Desk is situated at the main lobby entrance next to Hall 1 Registration.', icon: 'ph-question', category: 'General' },
                { id: 2, question: 'How do I connect to the free Wi-Fi?', answer: 'Connect to the network "EproExpo_FreeWiFi" and sign in using your booking ID.', icon: 'ph-wifi-high', category: 'Services' },
                { id: 3, question: 'Are food and beverages available?', answer: 'Yes, food courts are located in the passageways between Hall 1 & Hall 2, and Hall 3 & Hall 4.', icon: 'ph-bowl-food', category: 'Amenities' }
            ];
        }
    },

    // 22. Fetch Agenda Sessions for an exhibition
    async getAgenda(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/agenda`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Agenda API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [];
        }
    },

    // 23. Fetch Speakers for an exhibition
    async getSpeakers(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/speakers`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Speakers API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [];
        }
    },

    // 24. Fetch Sponsors for an exhibition
    async getSponsors(exhibitionId) {
        try {
            const response = await fetch(`${EXHIBITION_API_BASE}/${exhibitionId}/sponsors`);
            if (response.ok) {
                return await response.json();
            }
            throw new Error('Response not OK');
        } catch (e) {
            console.warn(`Sponsors API failed for exhibitionId: ${exhibitionId}, using fallback.`);
            return [];
        }
    }
};

