<style>
    .company-app {
        overflow-x: hidden;
    }

    .company-app .company-main-content,
    .company-event-flow-main {
        min-width: 0;
        width: 100%;
        max-width: 100%;
    }

    .company-page-title {
        font-size: clamp(1.45rem, 4vw, 2.125rem);
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .company-page-subtitle {
        font-size: clamp(0.875rem, 2vw, 1rem);
        line-height: 1.6;
    }

    .company-stat-value {
        font-size: clamp(1.35rem, 3vw, 1.875rem);
        line-height: 1.1;
    }

    .company-table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .company-table-scroll table {
        width: 100%;
        min-width: 42rem;
    }

    .company-mobile-card {
        border-radius: 0.875rem;
        background: #fff;
    }

    .company-mobile-card + .company-mobile-card {
        margin-top: 0.75rem;
    }

    .company-filter-tabs {
        display: flex;
        gap: 0;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .company-filter-tabs::-webkit-scrollbar {
        display: none;
    }

    .company-filter-tabs > * {
        flex: 0 0 auto;
        white-space: nowrap;
    }

    .company-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    @media (max-width: 767px) {
        .company-app header {
            height: auto;
            min-height: 4.5rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .company-form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .company-form-actions > *,
        .company-form-actions .inline-flex,
        .company-form-actions button,
        .company-form-actions a {
            width: 100%;
            justify-content: center;
        }

        .company-main-content .flex.items-start.justify-between.gap-4,
        .company-main-content .flex.items-center.justify-between.gap-4,
        .company-event-flow-main .flex.items-start.justify-between.gap-4,
        .company-event-flow-main .flex.items-center.justify-between.gap-4 {
            flex-direction: column;
            align-items: stretch;
        }

        .company-main-content .xl\:grid-cols-4,
        .company-main-content .xl\:grid-cols-5,
        .company-main-content .lg\:grid-cols-3,
        .company-event-flow-main .lg\:grid-cols-3,
        .company-event-flow-main .lg\:grid-cols-4 {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 639px) {
        .company-topbar-profile-text {
            display: none !important;
        }
    }

    @media (min-width: 1024px) {
        #company-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 280px !important;
            transform: translate(0, 0) !important;
            z-index: 40 !important;
        }

        .company-app-shell {
            margin-left: 280px !important;
            width: calc(100% - 280px) !important;
            min-width: 0 !important;
        }
    }
</style>
