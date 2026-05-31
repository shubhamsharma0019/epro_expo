<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company Dashboard - EproExpo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { inter: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: '#071044',
                        purple: '#5b2eff',
                        blue: '#246BFF',
                        border: '#E7EAF3',
                        soft: '#F8FAFF',
                        muted: '#5A6480',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#F7F8FC] font-inter text-[#071044]">

    <div class="min-h-screen lg:flex">
        <aside class="hidden border-r border-[#E7EAF3] bg-white lg:flex lg:w-[260px] lg:shrink-0 lg:flex-col">
            <div class="flex h-[88px] items-center px-8">
                <a href="/company/dashboard" class="flex items-center gap-2" data-link="dashboard">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 via-[#5b2eff] to-[#246BFF] font-bold text-white">
                        e</div>
                    <span class="text-[25px] font-semibold tracking-[-0.04em]">epro<span
                            class="text-[#246BFF]">expo</span></span>
                </a>
            </div>

            <nav class="flex-1 space-y-1 px-5 py-4">
                <a href="/company/dashboard"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold bg-[#F4F0FF] text-[#5b2eff]">
                    <span class="text-lg">&#8962;</span>
                    Dashboard
                </a>
                <a href="event-company-flow/event_company_dashboard.html"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#128197;</span>
                    Event Company
                </a>
                <a href="/company/booth-booking/pavilions" data-link="book_booth"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9637;</span>
                    Pavilions
                </a>
                <a href="/company/booth-booking/halls"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9636;</span>
                    Halls
                </a>
                <a href="/company/booth-booking/pavilions" data-link="book_booth"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9635;</span>
                    Book Booths
                </a>
                <a href="/company/bookings" data-link="bookings"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9638;</span>
                    My Bookings
                </a>
                <a href="/company/enquiries" data-link="enquiries"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9827;</span>
                    Leads
                </a>
                <a href="/company/bookings" data-link="bookings"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9640;</span>
                    Invoices
                </a>
                <a href="/company/profile" data-link="profile"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9817;</span>
                    Profile
                </a>
                <a href="/company/meetings" data-link="meetings"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9743;</span>
                    Support
                </a>
                <a href="/company/analytics" data-link="analytics"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                    <span class="text-lg">&#9632;</span>
                    Analytics
                </a>

                <form method="POST" action="/company/logout">
                    <input type="hidden" name="_token" value=""
                        autocomplete="off"> <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-[#34405F] hover:bg-[#F8F7FF]">
                        <span class="text-lg">&rarr;</span>
                        Logout
                    </button>
                </form>
            </nav>

        </aside>

        <main class="min-w-0 flex-1">
            <header class="sticky top-0 z-20 border-b border-[#E7EAF3] bg-white/95 backdrop-blur">
                <div class="flex h-[78px] items-center justify-between px-5 sm:px-8 lg:h-[88px] lg:px-10">
                    <div class="flex items-center gap-7">
                        <button
                            class="rounded-xl border border-[#E7EAF3] bg-white px-3 py-2 text-lg lg:hidden">&#9776;</button>
                        <nav class="hidden items-center gap-8 text-xs font-semibold xl:flex">
                            <a href="/events">Explore Events</a>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth">Pavilions</a>
                            <a href="/company/booth-booking/halls">Halls</a>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth">Booths</a>
                            <a href="/company/analytics" data-link="analytics">Analytics</a>
                        </nav>
                    </div>

                    <div class="flex items-center gap-4">
                        <button class="hidden text-sm font-semibold sm:block">EN</button>
                        <button
                            class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#E7EAF3] bg-white">
                            &#128276;
                            <span
                                class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">5</span>
                        </button>
                        <a href="/company/profile" class="flex items-center gap-3" data-link="profile">
                            <img src="/assets/exhibition/images/avatar.png" alt="User"
                                class="h-11 w-11 rounded-full object-cover">
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold" data-company-contact>Company</p>
                                <p class="text-xs text-[#5A6480]" data-company-status>Exhibitor</p>
                            </div>
                            <span class="text-[#5A6480]">&#8964;</span>
                        </a>
                    </div>
                </div>
            </header>

            <section class="px-5 py-7 sm:px-8 lg:px-10">
                <div class="mx-auto max-w-[1500px] space-y-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-[32px] font-semibold leading-tight tracking-[-0.03em]">Welcome back, <span data-company-contact>Company</span>!
                            </h1>
                            <p class="mt-2 text-[15px] text-[#5A6480]">
                                Start by booking your booth for the exhibition, then complete your booth setup from this
                                dashboard.
                            </p>
                        </div>

                        <a href="/company/booth-booking/pavilions" data-link="book_booth"
                            class="inline-flex w-fit items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 py-3 text-sm font-semibold text-white shadow-sm">
                            Book Booth &rarr;
                        </a>
                    </div>

                    <div class="rounded-2xl border border-[#DCD4FF] bg-[#FBFAFF] p-5 shadow-sm" data-empty-booking-banner>
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-[18px] font-semibold">No booth booked yet</h2>
                                <p class="mt-1 text-sm text-[#34405F]">Select a pavilion, hall, booth size and complete
                                    payment to activate booth setup.</p>
                            </div>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth"
                                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 py-3 text-sm font-semibold text-white">Start
                                Booth Booking &rarr;</a>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-[#34405F]">Active Bookings</p>
                            <h3 class="mt-3 text-[30px] font-semibold" data-stat="active_bookings">0</h3>
                            <p class="mt-1 text-sm text-[#5A6480]" data-stat-label="active_bookings">No active booking</p>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth"
                                class="mt-4 inline-block text-sm font-semibold text-[#5b2eff]">Book Booth &rarr;</a>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-[#34405F]">Booth Setup Progress</p>
                            <h3 class="mt-3 text-[30px] font-semibold"><span data-stat="setup_progress">0</span>%</h3>
                            <p class="mt-1 text-sm text-[#5A6480]" data-stat-label="setup_progress">Book a booth first</p>
                            <a href="/company/booth-booking/pavilions" data-link="setup"
                                class="mt-4 inline-block text-sm font-semibold text-[#5b2eff]">Start Booking &rarr;</a>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-[#34405F]">Leads Received</p>
                            <h3 class="mt-3 text-[30px] font-semibold" data-stat="leads">0</h3>
                            <p class="mt-1 text-sm text-[#5A6480]">No leads yet</p>
                            <a href="/company/enquiries" data-link="enquiries"
                                class="mt-4 inline-block text-sm font-semibold text-[#5b2eff]">View Leads &rarr;</a>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <p class="text-sm font-semibold text-[#34405F]">Total Spend</p>
                            <h3 class="mt-3 text-[30px] font-semibold" data-money="total_spend">$0.00</h3>
                            <p class="mt-1 text-sm text-[#5A6480]">No payment yet</p>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth"
                                class="mt-4 inline-block text-sm font-semibold text-[#5b2eff]">Book Booth &rarr;</a>
                        </div>
                    </div>
                      
                    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.92fr_0.85fr]">
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <h2 class="text-[20px] font-semibold">Current Booking</h2>
                            <div class="mt-5 rounded-xl border border-dashed border-[#C9BEFF] bg-[#FBFAFF] p-6">
                                <h3 class="text-[18px] font-semibold" data-booking-title>No active booking</h3>
                                <p class="mt-2 text-sm leading-6 text-[#5A6480]" data-booking-copy>Complete the booth booking flow to see
                                    your pavilion, booth number, payment and event details here.</p>
                                <div class="mt-4 hidden space-y-2 text-sm text-[#34405F]" data-booking-details></div>
                                <a href="/company/booth-booking/pavilions" data-link="setup"
                                    class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 py-3 text-sm font-semibold text-white">Book
                                    Booth &rarr;</a>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <h2 class="text-[20px] font-semibold">Booth Setup Progress</h2>
                            <div class="mt-5 space-y-3">
                                <div
                                    class="flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-white p-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F4F6FB] text-[#5A6480]">1</span>
                                        <span class="text-sm font-semibold">Company Profile</span>
                                    </div>
                                    <span class="text-xs text-[#5A6480]" data-step-status="0">Pending</span>
                                </div>
                                <div
                                    class="flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-white p-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F4F6FB] text-[#5A6480]">2</span>
                                        <span class="text-sm font-semibold">Booth Branding</span>
                                    </div>
                                    <span class="text-xs text-[#5A6480]" data-step-status="1">Pending</span>
                                </div>
                                <div
                                    class="flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-white p-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F4F6FB] text-[#5A6480]">3</span>
                                        <span class="text-sm font-semibold">Products</span>
                                    </div>
                                    <span class="text-xs text-[#5A6480]" data-step-status="2">Pending</span>
                                </div>
                                <div
                                    class="flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-white p-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F4F6FB] text-[#5A6480]">4</span>
                                        <span class="text-sm font-semibold">Documents &amp; Catalogues</span>
                                    </div>
                                    <span class="text-xs text-[#5A6480]" data-step-status="3">Pending</span>
                                </div>
                                <div
                                    class="flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-white p-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F4F6FB] text-[#5A6480]">5</span>
                                        <span class="text-sm font-semibold">Preview &amp; Publish</span>
                                    </div>
                                    <span class="text-xs text-[#5A6480]" data-step-status="4">Pending</span>
                                </div>
                            </div>
                            <a href="/company/booth-booking/pavilions" data-link="setup"
                                data-setup-cta
                                class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 py-3 text-sm font-semibold text-white">Book
                                Booth &rarr;</a>
                        </div>

                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                            <h2 class="text-[20px] font-semibold">Quick Actions</h2>
                            <div class="mt-5 grid gap-4">
                                <a href="/company/booth-booking/pavilions" data-link="setup"
                                    class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                    <div>
                                        <h3 class="text-sm font-semibold text-[#5b2eff]" data-setup-action-title>Setup Booth</h3>
                                        <p class="mt-1 text-xs text-[#5A6480]" data-setup-action-copy>Customize your booth</p>
                                    </div>
                                    <span class="text-[#5b2eff]">&rsaquo;</span>
                                </a>
                                <a href="/company/booth-booking/pavilions" data-link="products"
                                    class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                    <div>
                                        <h3 class="text-sm font-semibold text-[#5b2eff]">Add Product</h3>
                                        <p class="mt-1 text-xs text-[#5A6480]">Showcase your products</p>
                                    </div>
                                    <span class="text-[#5b2eff]">&rsaquo;</span>
                                </a>
                                <a href="/company/booth-booking/pavilions" data-link="documents"
                                    class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                    <div>
                                        <h3 class="text-sm font-semibold text-[#5b2eff]">Upload Brochure</h3>
                                        <p class="mt-1 text-xs text-[#5A6480]">Share your documents</p>
                                    </div>
                                    <span class="text-[#5b2eff]">&rsaquo;</span>
                                </a>
                                <a href="/company/booth-booking/pavilions" data-link="meetings"
                                    class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                    <div>
                                        <h3 class="text-sm font-semibold text-[#5b2eff]">Setup Meetings</h3>
                                        <p class="mt-1 text-xs text-[#5A6480]">Manage availability</p>
                                    </div>
                                    <span class="text-[#5b2eff]">&rsaquo;</span>
                                </a>
                            <a href="/company/analytics" data-link="analytics"
                                class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                <div>
                                    <h3 class="text-sm font-semibold text-[#5b2eff]">Open Analytics</h3>
                                    <p class="mt-1 text-xs text-[#5A6480]">View booth performance</p>
                                </div>
                                <span class="text-[#5b2eff]">&rsaquo;</span>
                            </a>
                                <a href="/company/event-company-flow/dashboard"
                                    class="flex items-center justify-between rounded-2xl border border-[#E7EAF3] bg-white p-4 hover:border-[#5b2eff] hover:bg-[#FBFAFF]">
                                    <div>
                                        <h3 class="text-sm font-semibold text-[#5b2eff]">Event Company Dashboard</h3>
                                        <p class="mt-1 text-xs text-[#5A6480]">Create and manage company events</p>
                                    </div>
                                    <span class="text-[#5b2eff]">&rsaquo;</span>
                                </a>
                        </div>
                    </div>
                </div>
                    <div class="rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-[20px] font-semibold">Your Exhibition Booths</h2>
                                <p class="mt-1 text-sm text-[#5A6480]">Manage setup for every exhibition booth from one company dashboard.</p>
                            </div>
                            <a href="/company/booth-booking/pavilions" data-link="book_booth"
                                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 py-3 text-sm font-semibold text-white">Book
                                Another Booth &rarr;</a>
                        </div>
                        <div class="mt-5 grid gap-4 lg:grid-cols-2 xl:grid-cols-3" data-bookings-list>
                            <div class="rounded-xl border border-dashed border-[#D8DCEB] bg-[#FBFAFF] p-5 text-sm font-semibold text-[#5A6480]">
                                No booths booked yet.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script>
        (() => {
            const currency = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' });
            const setText = (selector, value) => {
                document.querySelectorAll(selector).forEach((node) => {
                    node.textContent = value;
                });
            };
            const setHref = (key, value) => {
                if (!value) return;
                document.querySelectorAll(`[data-link="${key}"]`).forEach((node) => {
                    node.href = value;
                });
            };
            const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]));

            fetch('/company/dashboard-data', { headers: { Accept: 'application/json' }, credentials: 'same-origin' })
                .then((response) => {
                    if (!response.ok || !response.headers.get('content-type')?.includes('application/json')) {
                        throw new Error('Dashboard data unavailable');
                    }

                    return response.json();
                })
                .then((data) => {
                    const company = data.company || {};
                    const stats = data.stats || {};
                    const booking = data.booking;

                    setText('[data-company-contact]', company.contact_name || company.name || 'Company');
                    setText('[data-company-status]', company.status || 'Exhibitor');
                    setText('[data-stat="active_bookings"]', stats.active_bookings ?? 0);
                    setText('[data-stat="setup_progress"]', stats.setup_progress ?? 0);
                    setText('[data-stat="leads"]', stats.leads ?? 0);
                    setText('[data-money="total_spend"]', currency.format(stats.total_spend || 0));
                    setText('[data-stat-label="active_bookings"]', (stats.active_bookings || 0) > 0 ? 'Active booking available' : 'No active booking');
                    setText('[data-stat-label="setup_progress"]', booking?.is_live ? 'Booth is live' : ((stats.setup_progress || 0) > 0 ? 'Booth setup in progress' : 'Book a booth first'));

                    Object.entries(data.links || {}).forEach(([key, value]) => setHref(key, value));
                    setHref('dashboard', '/company/dashboard');

                    const emptyBanner = document.querySelector('[data-empty-booking-banner]');
                    const bookingTitle = document.querySelector('[data-booking-title]');
                    const bookingCopy = document.querySelector('[data-booking-copy]');
                    const bookingDetails = document.querySelector('[data-booking-details]');
                    const bookingsList = document.querySelector('[data-bookings-list]');

                    if (booking) {
                        emptyBanner?.classList.add('hidden');
                        if (bookingTitle) bookingTitle.textContent = `${booking.exhibition || 'Current exhibition'} - Booth ${booking.booth || 'N/A'}`;
                        if (bookingCopy) bookingCopy.textContent = booking.is_live
                            ? `${booking.status || 'Live'} booking ${booking.id || ''}. Your booth is live on the website.`
                            : `${booking.status || 'Active'} booking ${booking.id || ''}. Continue setup from this dashboard.`;
                        if (booking.is_live) {
                            setText('[data-setup-cta]', 'View Live Booth ->');
                            setText('[data-setup-action-title]', 'View Live Booth');
                            setText('[data-setup-action-copy]', 'Open your published booth');
                            if (booking.public_url) {
                                setHref('setup', booking.public_url);
                                document.querySelectorAll('[data-link="setup"]').forEach((node) => {
                                    node.target = '_blank';
                                });
                            }
                        }
                        if (bookingDetails) {
                            bookingDetails.classList.remove('hidden');
                            bookingDetails.innerHTML = [
                                ['Pavilion', booking.pavilion],
                                ['Hall', booking.hall],
                                ['Booth Size', booking.booth_size],
                                ['Booked On', booking.created_at],
                            ].filter(([, value]) => value).map(([label, value]) => `<p><strong>${label}:</strong> ${value}</p>`).join('');
                        }
                    }

                    if (bookingsList && Array.isArray(data.bookings) && data.bookings.length) {
                        bookingsList.innerHTML = data.bookings.map((item) => {
                            const actionUrl = item.setup_url || item.public_url || data.links?.bookings || '/company/bookings';
                            const actionLabel = item.is_live ? 'Manage Booth' : (item.setup_url ? 'Continue Setup' : 'View Status');
                            const progress = Math.min(Number(item.setup_progress || 0), 100);
                            const liveLink = item.public_url
                                ? `<a href="${escapeHtml(item.public_url)}" target="_blank" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-[#5b2eff] px-4 text-[13px] font-semibold text-[#5b2eff]">View Live</a>`
                                : '';

                            return `
                                <article class="rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-[#071044]">${escapeHtml(item.exhibition || 'Exhibition')}</h3>
                                            <p class="mt-1 text-xs font-semibold text-[#5A6480]">${escapeHtml(item.booking_id || '')}</p>
                                        </div>
                                        <span class="rounded-md bg-white px-3 py-1 text-[11px] font-semibold text-[#5b2eff]">${escapeHtml(item.status || 'Pending')}</span>
                                    </div>
                                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs font-semibold text-[#5A6480]">
                                        <p><span class="block text-[10px] uppercase text-[#8A90A8]">Hall</span>${escapeHtml(item.hall || 'Not assigned')}</p>
                                        <p><span class="block text-[10px] uppercase text-[#8A90A8]">Booth</span>${escapeHtml(item.booth ? `Booth ${item.booth}` : 'Not assigned')}</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="mb-1 flex justify-between text-[11px] font-semibold text-[#5A6480]">
                                            <span>Setup Progress</span>
                                            <span>${progress}%</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-white">
                                            <div class="h-2 rounded-full bg-[#5b2eff]" style="width: ${progress}%"></div>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                                        <a href="${escapeHtml(actionUrl)}" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg bg-[#5b2eff] px-4 text-[13px] font-semibold text-white">${escapeHtml(actionLabel)}</a>
                                        ${liveLink}
                                    </div>
                                </article>
                            `;
                        }).join('');
                    }

                    (data.setup_steps || []).forEach((step, index) => {
                        const status = document.querySelector(`[data-step-status="${index}"]`);
                        if (!status) return;
                        status.textContent = step.status || 'Pending';
                        status.classList.toggle('text-[#059669]', step.status === 'Completed');
                    });
                })
                .catch(() => {
                    document.body.dataset.dashboardFallback = 'true';
                });
        })();
    </script>
</body>

</html>
