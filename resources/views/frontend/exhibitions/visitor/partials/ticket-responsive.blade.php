<style>
    html, body { overflow-x: hidden; max-width: 100%; }
    .ticket-flow-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .ticket-flow-stepper { overflow-x: auto; padding-bottom: 0.25rem; -webkit-overflow-scrolling: touch; }
    @media (min-width: 1024px) {
        #exhibition-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 260px !important;
            transform: translateX(0) !important;
            z-index: 50 !important;
        }

        body:has(#exhibition-sidebar) {
            padding-left: 260px !important;
            box-sizing: border-box !important;
        }

        body:has(#exhibition-sidebar) main {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }
    }
    @media (max-width: 1023px) {
        .ticket-flow-main { padding-left: 1rem !important; padding-right: 1rem !important; }
        .ticket-flow-two-col { flex-direction: column !important; }
        .ticket-flow-sidebar { width: 100% !important; max-width: 100% !important; }
    }
    @media (max-width: 639px) {
        .ticket-flow-main { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
        .ticket-flow-hero-img { width: 72px !important; height: 72px !important; }
        .ticket-flow-stepper .w-24 { width: 4.25rem !important; min-width: 4.25rem !important; }
        .ticket-flow-stepper .min-w-\[60px\] { min-width: 2rem !important; }
        .ticket-flow-main button,
        .ticket-flow-main a.inline-flex,
        .ticket-flow-main .ticket-flow-sidebar button {
            min-height: 44px;
        }
        .ticket-flow-two-col > * { min-width: 0; width: 100%; }
    }
</style>
