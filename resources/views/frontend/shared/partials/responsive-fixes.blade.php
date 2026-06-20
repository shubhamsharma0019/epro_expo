<style>
    /* Minimal responsive safeguards — preserves existing design tokens */
    html, body { max-width: 100%; overflow-x: hidden; }
    *, *::before, *::after { box-sizing: border-box; }
    main, header, section, aside, .main-scrollbar, .admin-app { min-width: 0; }
    img, svg, video, canvas { max-width: 100%; height: auto; }
    input, select, textarea, button { max-width: 100%; }
    table { width: 100%; }
    .overflow-x-auto { -webkit-overflow-scrolling: touch; }
    @media (max-width: 1024px) {
        #admin-sidebar, #company-sidebar { max-width: 85vw; }
        .grid { min-width: 0; }
        
        /* Table scroll responsive enhancements */
        .overflow-x-auto, .overflow-x-visible {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .overflow-x-auto table, .overflow-x-visible table {
            min-width: 850px !important;
            width: 100% !important;
            table-layout: auto !important;
        }
        th, td {
            white-space: nowrap !important;
            padding-left: .75rem !important;
            padding-right: .75rem !important;
            font-size: 13px !important;
        }
    }
    @media (max-width: 768px) {
        th, td { white-space: normal; overflow-wrap: anywhere; word-break: break-word; }
        
        /* Compress large container padding on mobile screens */
        .px-5, .px-8, .px-10, .px-12, .px-14, .px-16, .px-20, .px-24, .px-28, .px-32, .px-36, .px-40, .px-44, .px-48, .px-52, .px-56, .px-60, .px-64, .px-72, .px-80, .px-96,
        .p-5, .p-6, .p-8, .p-10, .p-12, .p-14, .p-16, .p-20, .p-24, .p-28, .p-32, .p-36, .p-40, .p-44, .p-48, .p-52, .p-56, .p-60, .p-64, .p-72, .p-80, .p-96,
        .py-10, .py-12, .py-14, .py-16,
        .lg\:p-8, .lg\:p-12, .lg\:p-16, .lg\:p-20, .lg\:p-24, 
        section.space-y-6 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* Event details padding override on mobile/tablet */
        main.px-\[44px\] {
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        /* Ensure maximum width constraint on all page layouts */
        .max-w-\[1400px\], .max-w-\[1500px\], .max-w-\[1200px\], .max-w-\[1100px\] {
            max-width: 100% !important;
        }
    }
    @media (max-width: 640px) {
        /* Event Details page lists responsive fixes - keeps same UI alignment but prevents overflow */
        #event-venue, 
        #event-website, 
        #event-venue ~ div,
        #event-website ~ div {
            gap: 0.75rem !important;
        }
        #event-venue > .w-28, 
        #event-website > .w-28,
        #event-venue ~ div > .w-28,
        #event-website ~ div > .w-28 {
            width: 5.5rem !important;
            flex-shrink: 0 !important;
        }
        #event-venue > :last-child, 
        #event-website > :last-child,
        #event-venue ~ div > :last-child,
        #event-website ~ div > :last-child {
            min-width: 0 !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }
        #event-venue a, 
        #event-website a,
        #event-venue ~ div a,
        #event-website ~ div a {
            word-break: break-all !important;
            overflow-wrap: break-word !important;
        }
    }
    @media (max-width: 480px) {
        /* Stack homepage CTA grid buttons on narrow mobile viewports */
        main .mt-7.flex.flex-col > .grid.w-full.grid-cols-2 {
            grid-template-columns: 1fr !important;
        }
        /* Ensure exhibition card steps have enough height to prevent overlap */
        main article.relative.min-h-\[310px\] {
            min-height: 350px !important;
        }
    }
    @media (max-width: 400px) {
        /* Stat columns inside exhibition cards */
        [data-exhibition-card] .grid-cols-4 > div {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
            min-height: 48px !important;
        }
        [data-exhibition-card] .grid-cols-4 p.text-\[13px\] {
            font-size: 11px !important;
        }
        [data-exhibition-card] .grid-cols-4 p.text-\[10px\] {
            font-size: 8px !important;
        }
    }
    @media (max-width: 360px) {
        /* Stack exhibition home page benefits on very narrow screens */
        main .mt-8.grid.grid-cols-2 {
            grid-template-columns: 1fr !important;
        }
    }
</style>
