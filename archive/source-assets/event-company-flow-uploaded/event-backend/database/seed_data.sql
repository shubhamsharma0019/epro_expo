-- Disable foreign key constraints temporarily to allow clearing tables safely
PRAGMA foreign_keys = OFF;

-- Clear existing data from all tables to prevent duplicates
DELETE FROM exhibition_meetings;
DELETE FROM exhibition_visitors;
DELETE FROM exhibitors;
DELETE FROM exhibitions;
DELETE FROM bookings;
DELETE FROM tickets;
DELETE FROM events;

-- Reset SQLite primary key auto-increment sequences (optional but clean)
DELETE FROM sqlite_sequence WHERE name IN ('events', 'tickets', 'bookings', 'exhibitions', 'exhibitors', 'exhibition_visitors', 'exhibition_meetings');

-- Re-enable foreign key constraints
PRAGMA foreign_keys = ON;

-- 1. Seed Events Table
INSERT INTO events (
    id, name, category, sub_category, start_date, end_date, timezone, venue, website, description, 
    primary_color, secondary_color, accent_color, text_color, organizer_name, organizer_email, 
    organizer_phone, status, allow_group_registrations, show_remaining_tickets, waiting_list, created_at, updated_at
) VALUES 
(
    1, 'Global Tech Summit 2026', 'Technology', 'AI & Cloud', '2026-05-15', '2026-05-17', 'Asia/Kolkata', 
    'Jio World Convention Centre, Mumbai, India', 'https://globaltechsummit.com', 
    'Global Tech Summit brings together technology leaders, developers, and investors to explore emerging trends in AI, Cloud Computing, and Next-Generation Business Architectures.', 
    '#1010b9', '#3111e8', '#FF8A00', '#101828', 'Tech Events Inc.', 'organizer@techevents.com', 
    '+91 98765 43210', 'approved', 1, 1, 0, datetime('now'), datetime('now')
),
(
    2, 'Future of AI Expo', 'Artificial Intelligence', 'Machine Learning', '2026-06-10', '2026-06-12', 'Asia/Kolkata', 
    'Bengaluru Convention Centre, Bengaluru, India', 'https://futureaiexpo.com', 
    'Explore deep neural structures, machine learning platforms, and automation algorithms.', 
    '#5B32F6', '#00B894', '#FF8A00', '#0F172A', 'AI Labs Consortium', 'contact@aiexpo.com', 
    '+91 80 555 1234', 'pending', 0, 0, 1, datetime('now'), datetime('now')
),
(
    3, 'Sustainability World Expo', 'Environment', 'Green Tech', '2026-08-08', '2026-08-10', 'Asia/Kolkata', 
    'Pune International Exhibition Centre, Pune, India', 'https://sustainabilityworld.org', 
    'Innovations in green architecture, eco-friendly systems, and global sustainability standards.', 
    '#00B894', '#5B32F6', '#FF8A00', '#0F172A', 'EcoWorld Foundation', 'info@ecoworld.org', 
    '+91 20 444 5678', 'draft', 1, 0, 0, datetime('now'), datetime('now')
);

-- 2. Seed Tickets Table
INSERT INTO tickets (
    id, event_id, type, price, quantity, sales_start, sales_end, created_at, updated_at
) VALUES 
(1, 1, 'Business Pass', 1499.00, '1000', '2026-04-01', '2026-05-14', datetime('now'), datetime('now')),
(2, 1, 'VIP Access Pass', 4999.00, '200', '2026-04-01', '2026-05-14', datetime('now'), datetime('now')),
(3, 2, 'Early Bird Pass', 999.00, '300', '2026-05-01', '2026-06-01', datetime('now'), datetime('now')),
(4, 2, 'General Admission', 1999.00, 'Unlimited', '2026-05-01', '2026-06-09', datetime('now'), datetime('now'));

-- 3. Seed Bookings Table
INSERT INTO bookings (
    id, event_id, booking_id, ticket_type, amount, booking_date, attendee_name, attendee_email, checkin_status, checkin_time, created_at, updated_at
) VALUES 
(1, 1, 'EVT-260515-000123', 'Business Pass', 1499.00, 'May 10, 2026', 'John Doe', 'john.doe@example.com', 0, NULL, datetime('now'), datetime('now')),
(2, 1, 'EVT-260515-000124', 'VIP Access Pass', 4999.00, 'May 11, 2026', 'Jane Smith', 'jane.smith@example.com', 1, 'May 15, 2026 at 09:30 AM', datetime('now'), datetime('now'));

-- 4. Seed Exhibitions Table
INSERT INTO exhibitions (
    id, name, start_date, end_date, venue, description, companies_count, banner_url, created_at, updated_at
) VALUES 
(1, 'Global Tech Summit 2026', '2026-05-15', '2026-05-17', 'Jio World Convention Centre, Mumbai, India', 'Experience next-generation tech breakthroughs in enterprise systems and engineering.', 120, 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', datetime('now'), datetime('now')),
(2, 'Future of AI Expo', '2026-06-10', '2026-06-12', 'Bengaluru Convention Centre, Bengaluru, India', 'Explore deep neural structures, machine learning platforms, and automation algorithms.', 80, 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', datetime('now'), datetime('now')),
(3, 'Sustainability World Expo', '2026-08-08', '2026-08-10', 'Pune International Exhibition Centre, Pune, India', 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.', 85, 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', datetime('now'), datetime('now'));

-- 5. Seed Exhibitors Table
INSERT INTO exhibitors (
    id, exhibition_id, hall_name, booth_number, name, category, description, website, email, country, 
    rep_name, rep_title, rep_email, rep_phone, rep_img_url, logo_color, logo_text, created_at, updated_at
) VALUES 
(
    1, 1, 'Hall 1 - AI & IA', 'Booth 101', 'TechNext Solutions Pvt. Ltd.', 'AI & Automation', 
    'Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.', 
    'www.technext.com', 'info@technext.com', 'India', 'Rahul Sharma', 'Business Development Manager', 
    'rahul.sharma@technext.com', '+91 98765 43210', 'https://randomuser.me/api/portraits/men/32.jpg', 
    'bg-blue-500', 'TN', datetime('now'), datetime('now')
),
(
    2, 1, 'Hall 1 - AI & IA', 'Booth 102', 'InnovaAI Labs', 'Machine Learning', 
    'Building intelligent models for real-world impact and actionable data analytics.', 
    'www.innovaalabs.com', 'contact@innovaalabs.com', 'United States', 'Sarah Jenkins', 'Lead Data Scientist', 
    'sarah.j@innovaalabs.com', '+1 555-0198', 'https://randomuser.me/api/portraits/women/44.jpg', 
    'bg-indigo-600', 'IA', datetime('now'), datetime('now')
),
(
    3, 1, 'Hall 1 - AI & IA', 'Booth 103', 'DataMind Analytics', 'Data & Analytics', 
    'Data analytics platforms for smarter decisions and operational intelligence.', 
    'www.datamind.io', 'hello@datamind.io', 'United Kingdom', 'David Chen', 'VP of Sales', 
    'david.c@datamind.io', '+44 20 7123 4567', 'https://randomuser.me/api/portraits/men/62.jpg', 
    'bg-blue-600', 'DM', datetime('now'), datetime('now')
),
(
    4, 1, 'Hall 1 - AI & IA', 'Booth 104', 'CloudSphere Tech', 'Cloud Computing', 
    'Scalable cloud solutions for modern businesses.', 
    'www.cloudsphere.tech', 'support@cloudsphere.tech', 'Canada', 'Elena Rodriguez', 
    'Cloud Solutions Architect', 'elena.r@cloudsphere.tech', '+1 416 555 0192', 
    'https://randomuser.me/api/portraits/women/68.jpg', 'bg-[#0F172A]', 'CS', datetime('now'), datetime('now')
);

-- 6. Seed Exhibition Visitors Table
INSERT INTO exhibition_visitors (
    id, exhibition_id, booking_id, first_name, last_name, email, mobile, job_title, company, country, 
    state, city, industry, company_size, business_address, pass_type, amount, payment_status, checkin_status, checkin_time, created_at, updated_at
) VALUES 
(
    1, 1, 'EXH-260515-000001', 'Amit', 'Kumar', 'amit.kumar@example.com', '+91 99999 88888', 
    'Software Engineer', 'Infosys', 'India', 'Karnataka', 'Bengaluru', 'Information Technology', '10000+', 
    'Electronic City Phase 1, Bengaluru', 'VIP Pass', 999.00, 'completed', 1, '2026-05-15 10:15:00', datetime('now'), datetime('now')
),
(
    2, 1, 'EXH-260515-000002', 'Priya', 'Sharma', 'priya.sharma@example.com', '+91 88888 77777', 
    'Product Manager', 'Wipro', 'India', 'Maharashtra', 'Pune', 'Software Solutions', '5000-10000', 
    'Hinjewadi Phase 2, Pune', 'Standard Pass', 0.00, 'completed', 0, NULL, datetime('now'), datetime('now')
);

-- 7. Seed Exhibition Meetings Table
INSERT INTO exhibition_meetings (
    id, visitor_id, exhibitor_id, meeting_date, meeting_time, notes, status, created_at, updated_at
) VALUES 
(1, 1, 1, '2026-05-15', '11:30 AM', 'Discuss AI agent integration possibilities for enterprise dashboard.', 'accepted', datetime('now'), datetime('now')),
(2, 2, 2, '2026-05-16', '02:00 PM', 'Interested in their custom machine learning models.', 'pending', datetime('now'), datetime('now'));
