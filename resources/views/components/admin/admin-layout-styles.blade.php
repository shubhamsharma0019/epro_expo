<style>
    .admin-app {
        overflow-x: hidden;
    }

    .admin-app main {
        min-width: 0;
        width: 100%;
        overflow-x: hidden;
    }

    .admin-main-content {
        min-width: 0;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    .admin-page-title {
        font-size: clamp(1.35rem, 2.4vw, 1.75rem);
        line-height: 1.2;
    }

    .admin-page-description {
        font-size: clamp(0.8125rem, 1.6vw, 0.875rem);
    }

    .admin-stat-value {
        font-size: clamp(1.35rem, 2.5vw, 1.75rem);
        line-height: 1.1;
    }

    .admin-mobile-card {
        border-radius: 1rem;
        background: #fff;
    }

    .admin-mobile-card + .admin-mobile-card {
        margin-top: 0.75rem;
    }

    .admin-action-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-action-row > form,
    .admin-action-row > a,
    .admin-action-row > button {
        flex: 1 1 auto;
        min-width: max(5.5rem, 30%);
    }

    .admin-action-row .inline-flex {
        width: 100%;
        justify-content: center;
    }

    @media (min-width: 1024px) {
        .admin-action-row--desktop {
            flex-wrap: nowrap;
            justify-content: flex-end;
        }

        .admin-action-row--desktop > form,
        .admin-action-row--desktop > a,
        .admin-action-row--desktop > button {
            flex: 0 0 auto;
            min-width: 0;
            width: auto;
        }

        .admin-action-row--desktop .inline-flex {
            width: auto;
        }
    }

    @media (max-width: 1023px) {
        #admin-sidebar {
            max-width: min(85vw, 320px);
        }

        .admin-topbar-search--desktop {
            display: none !important;
        }
    }

    @media (min-width: 1024px) {
        .admin-topbar-search--mobile {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        .admin-app header.admin-topbar {
            height: auto;
            min-height: 4.75rem;
        }

        .admin-main-content .xl\:grid-cols-\[1\.3fr_0\.7fr\],
        .admin-main-content .xl\:grid-cols-2,
        .admin-main-content .lg\:grid-cols-2 {
            grid-template-columns: minmax(0, 1fr);
        }

        .admin-main-content .flex.items-start.justify-between.gap-4,
        .admin-main-content .flex.items-center.justify-between.gap-4 {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-main-content .admin-form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-main-content .admin-form-actions > * {
            width: 100%;
            justify-content: center;
        }

        .admin-hero-banner h2 {
            font-size: 1.4rem !important;
        }

        .admin-chart-bars {
            gap: 0.35rem !important;
            overflow-x: auto;
            padding-bottom: 0.25rem;
        }

        .admin-chart-bars > * {
            min-width: 2rem;
        }
    }

    @media (max-width: 639px) {
        .admin-topbar-profile {
            display: none !important;
        }

        .admin-page-section {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    .admin-table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .admin-table-scroll table {
        width: 100%;
        min-width: 56rem;
    }

    .admin-pagination {
        overflow-x: auto;
    }

    .admin-pagination nav {
        min-width: max-content;
    }
</style>
