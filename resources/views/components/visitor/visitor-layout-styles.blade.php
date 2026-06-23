<style>
    .user-app,
    .exhibition-app {
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .user-app main,
    .exhibition-app main {
        min-width: 0;
        width: 100%;
        overflow-x: hidden;
    }

    .visitor-main-content {
        min-width: 0;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    .visitor-main-content > section,
    .visitor-main-content > div {
        min-width: 0;
        max-width: 100%;
    }

    @media (max-width: 1023px) {
        #user-sidebar,
        #exhibition-sidebar {
            max-width: min(85vw, 320px);
        }

        .user-app .visitor-main-content table,
        .exhibition-app .visitor-main-content table {
            min-width: 0 !important;
            width: 100% !important;
            display: table !important;
            table-layout: auto !important;
        }
    }

    @media (max-width: 767px) {
        .user-app header,
        .exhibition-app header {
            height: auto;
            min-height: 76px;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
        }

        .visitor-topbar-title {
            min-width: 0;
            flex: 1 1 auto;
        }

        .visitor-topbar-title h1 {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .visitor-main-content .rounded-\[30px\] {
            border-radius: 1.25rem;
        }

        .visitor-main-content .rounded-\[26px\] {
            border-radius: 1.125rem;
        }

        .visitor-main-content .xl\:grid-cols-\[1\.3fr_0\.7fr\],
        .visitor-main-content .xl\:grid-cols-\[minmax\(0\,1fr\)_360px\],
        .visitor-main-content .xl\:grid-cols-\[320px_minmax\(0\,1fr\)\] {
            grid-template-columns: minmax(0, 1fr);
        }

        .visitor-main-content .lg\:grid-cols-\[1fr_260px\],
        .visitor-main-content .lg\:grid-cols-\[1fr_380px\] {
            grid-template-columns: minmax(0, 1fr);
        }

        .visitor-main-content .pass-filter-scroll {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 0.25rem;
        }

        .visitor-main-content .pass-filter-scroll::-webkit-scrollbar {
            display: none;
        }

        .visitor-main-content .pass-filter-scroll .pass-filter-btn {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        .visitor-main-content .pass-card .flex.flex-wrap.items-center.gap-2,
        .visitor-main-content .visitor-pass-actions {
            width: 100%;
        }

        .visitor-main-content .pass-card .flex.flex-wrap.items-center.gap-2 > *,
        .visitor-main-content .visitor-pass-actions > * {
            flex: 1 1 calc(50% - 0.25rem);
            justify-content: center;
        }

        .visitor-main-content .ticket-detail-row {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.25rem;
        }

        .visitor-main-content .ticket-detail-row strong {
            text-align: left;
            word-break: break-word;
        }

        .visitor-main-content #qr-modal-card {
            max-width: calc(100vw - 2rem);
        }
    }

    @media (max-width: 480px) {
        .visitor-main-content .pass-card .flex.flex-wrap.items-center.gap-2 > *,
        .visitor-main-content .visitor-pass-actions > * {
            flex: 1 1 100%;
        }
    }
</style>
