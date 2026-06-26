<style>
    .visitor-flow-page {
        --vf-navy: #071044;
        --vf-muted: #5A6480;
        --vf-border: #E7EAF3;
        --vf-purple: #3723db;
        width: 100%;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        box-sizing: border-box;
    }
    .visitor-flow-hero {
        border-radius: 1rem;
        border: 1px solid var(--vf-border);
        background: #fff;
        padding: 1.25rem 1.25rem;
        box-shadow: 0 14px 34px rgba(7, 16, 68, 0.07);
    }
    @media (min-width: 640px) {
        .visitor-flow-hero { padding: 1.5rem 2rem; }
    }
    .visitor-flow-hero h1 {
        margin-top: 0.75rem;
        font-size: clamp(1.5rem, 4.5vw, 2.5rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--vf-navy);
        line-height: 1.15;
        word-break: break-word;
    }
    .visitor-flow-hero p {
        margin-top: 0.75rem;
        max-width: 46rem;
        font-size: clamp(0.875rem, 2.5vw, 1rem);
        line-height: 1.75;
        font-weight: 500;
        color: var(--vf-muted);
    }
    .visitor-flow-card {
        border-radius: 1rem;
        border: 1px solid var(--vf-border);
        background: #fff;
        padding: 1rem 1.125rem;
        box-shadow: 0 8px 22px rgba(7, 16, 68, 0.05);
        min-width: 0;
    }
    @media (min-width: 640px) {
        .visitor-flow-card { padding: 1.25rem 1.5rem; }
    }
    .visitor-flow-empty {
        border-radius: 1rem;
        border: 1px dashed var(--vf-border);
        background: #FBFAFF;
        padding: 2rem 1rem;
        text-align: center;
    }
    @media (min-width: 640px) {
        .visitor-flow-empty { padding: 2.5rem 1.5rem; }
    }
    .visitor-flow-btn,
    .visitor-flow-page a.inline-flex,
    .visitor-flow-page button.inline-flex {
        min-height: 2.75rem;
        touch-action: manipulation;
    }
    .visitor-flow-scroll-tabs {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .visitor-flow-scroll-tabs::-webkit-scrollbar { display: none; }
    .visitor-flow-media img,
    .visitor-flow-media video {
        max-width: 100%;
        height: auto;
    }
    .visitor-flow-grid-safe {
        min-width: 0;
        width: 100%;
        max-width: 100%;
    }

    .visitor-flow-page .grid,
    .visitor-flow-page .flex {
        min-width: 0;
    }

    .visitor-flow-page table {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 1023px) {
        .visitor-flow-page table {
            min-width: 0 !important;
            display: table !important;
            table-layout: auto !important;
        }
    }

    @media (max-width: 767px) {
        .visitor-flow-page .xl\:grid-cols-\[minmax\(0\,1fr\)_310px\],
        .visitor-flow-page .xl\:grid-cols-\[minmax\(0\,1fr\)_380px\],
        .visitor-flow-page .xl\:grid-cols-\[minmax\(0\,1fr\)_360px\],
        .visitor-flow-page .lg\:grid-cols-\[minmax\(0\,1fr\)_420px\],
        .visitor-flow-page .lg\:grid-cols-\[1fr_420px\],
        .visitor-flow-page .lg\:grid-cols-\[1fr_390px\],
        .visitor-flow-page .lg\:grid-cols-\[330px_minmax\(0\,1fr\)] {
            grid-template-columns: minmax(0, 1fr);
        }

        .visitor-flow-page .xl\:grid-cols-5,
        .visitor-flow-page .xl\:grid-cols-4,
        .visitor-flow-page .xl\:grid-cols-3,
        .visitor-flow-page .lg\:grid-cols-3 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .visitor-flow-page .lg\:grid-cols-\[1fr_420px\].p-6,
        .visitor-flow-page .lg\:grid-cols-\[1fr_420px\].lg\:p-8 {
            padding: 1.25rem;
        }

        .visitor-flow-page h1.text-\[38px\],
        .visitor-flow-page h1.text-\[52px\] {
            font-size: clamp(1.75rem, 7vw, 2.375rem) !important;
            line-height: 1.15 !important;
        }

        .visitor-flow-page .chat-compose-form {
            flex-direction: column;
            align-items: stretch;
        }

        .visitor-flow-page .chat-compose-form button {
            width: 100%;
        }

        .visitor-flow-page .meeting-card-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .visitor-flow-page .meeting-card-actions > * {
            width: 100%;
            justify-content: center;
        }

        .visitor-flow-page .company-card-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .visitor-flow-page .company-card-actions > a,
        .visitor-flow-page .company-card-actions > button {
            width: 100%;
            justify-content: center;
        }

        .visitor-flow-page .company-card-actions > button {
            width: 100%;
        }

        .visitor-flow-page .floor-map-scroll {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
        }
    }

    .visitor-flow-page .floor-map-scroll {
        overflow-y: visible;
    }

    .visitor-flow-page .floor-map-canvas {
        position: relative;
        width: 720px;
        height: 380px;
        min-height: 380px;
        overflow: visible;
    }
</style>
