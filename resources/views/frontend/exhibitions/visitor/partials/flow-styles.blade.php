<style>
    .visitor-flow-page {
        --vf-navy: #071044;
        --vf-muted: #5A6480;
        --vf-border: #E7EAF3;
        --vf-purple: #5b2eff;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
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
    }
</style>
