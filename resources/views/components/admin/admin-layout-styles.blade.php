<style>
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

    @media (max-width: 1023px) {
        #admin-sidebar {
            max-width: min(85vw, 320px);
        }
    }

    @media (max-width: 767px) {
        .admin-app header {
            height: auto;
            min-height: 76px;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
        }

        .admin-topbar-title {
            min-width: 0;
            flex: 1 1 auto;
        }

        .admin-topbar-title h1 {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-main-content .xl\:grid-cols-\[1\.3fr_0\.7fr\],
        .admin-main-content .xl\:grid-cols-\[1\.3fr\,0\.7fr\],
        .admin-main-content .xl\:grid-cols-2 {
            grid-template-columns: minmax(0, 1fr);
        }

        .admin-main-content .flex.items-start.justify-between.gap-4 {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-main-content .admin-table-actions {
            flex-wrap: wrap;
            justify-content: flex-start !important;
        }

        .admin-main-content .admin-table-actions > * {
            flex: 1 1 calc(50% - 0.25rem);
            justify-content: center;
        }

        .admin-main-content .admin-form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-main-content .admin-form-actions > * {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .admin-main-content .admin-table-actions > * {
            flex: 1 1 100%;
        }
    }
</style>
