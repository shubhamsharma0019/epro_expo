<style>
    #company-event-dashboard .ced-page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem 1.25rem;
    }

    #company-event-dashboard .ced-page-header__copy {
        min-width: 0;
        flex: 1 1 16rem;
    }

    #company-event-dashboard .ced-create-btn {
        flex: 0 0 auto;
        width: 100%;
    }

    @media (min-width: 640px) {
        #company-event-dashboard .ced-create-btn {
            width: auto;
            margin-left: auto;
        }
    }

    #company-event-dashboard .ced-stat-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1rem;
    }

    @media (min-width: 640px) {
        #company-event-dashboard .ced-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
        }
    }

    @media (min-width: 1280px) {
        #company-event-dashboard .ced-stat-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    #company-event-dashboard .ced-stat-card {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        min-width: 0;
        height: 100%;
    }

    #company-event-dashboard .ced-stat-card__icon {
        flex-shrink: 0;
    }

    #company-event-dashboard .ced-stat-card__body {
        min-width: 0;
        flex: 1 1 auto;
    }

    #company-event-dashboard .ced-stat-label {
        white-space: normal;
        line-height: 1.35;
        word-break: break-word;
    }

    #company-event-dashboard .ced-chart-head {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    @media (min-width: 1024px) {
        #company-event-dashboard .ced-chart-head {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    #company-event-dashboard .ced-chart-legend {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        justify-content: flex-start;
        gap: 0.625rem;
    }

    @media (min-width: 640px) {
        #company-event-dashboard .ced-chart-legend {
            justify-content: flex-end;
        }
    }

    #company-event-dashboard .ced-chart-legend__item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        min-width: 0;
        flex: 1 1 9.5rem;
        max-width: 100%;
    }

    @media (min-width: 640px) {
        #company-event-dashboard .ced-chart-legend__item {
            flex: 0 1 auto;
            min-width: 8.75rem;
            max-width: 11.5rem;
        }
    }

    #company-event-dashboard .ced-performance-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1.25rem;
        align-items: stretch;
    }

    @media (min-width: 1024px) {
        #company-event-dashboard .ced-performance-grid {
            grid-template-columns: minmax(0, 2fr) minmax(260px, 1fr);
        }
    }
</style>
