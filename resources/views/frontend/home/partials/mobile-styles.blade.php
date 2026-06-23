<style>
    #home-page {
        overflow-x: hidden;
    }

    #home-page main,
    #home-page section,
    #home-page aside {
        min-width: 0;
    }

    @media (max-width: 1023px) {
        #home-page .home-hero {
            min-height: 0;
        }

        #home-page .home-hero-overlay-desktop {
            display: none;
        }

        #home-page .home-hero-overlay-mobile {
            display: block;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.96) 0%,
                rgba(255, 255, 255, 0.92) 42%,
                rgba(255, 255, 255, 0.78) 68%,
                rgba(255, 255, 255, 1) 100%
            );
        }

        #home-page .home-hero-image-mobile {
            height: 220px;
            opacity: 0.28;
        }

        #home-page .home-hero-title {
            font-size: clamp(1.85rem, 8vw, 2.75rem);
            line-height: 1.08;
            letter-spacing: -0.03em;
        }

        #home-page .home-hero-copy {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        #home-page section#features,
        #home-page section#exhibitions,
        #home-page section.bg-white.px-4.pb-4 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        #home-page .home-pills-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        #home-page .home-pills-wrap::-webkit-scrollbar {
            display: none;
        }

        #home-page .home-pills-grid {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            min-width: max-content;
            padding-bottom: 0.25rem;
        }

        #home-page .home-pills-grid > div {
            flex: 0 0 auto;
            width: 5.5rem;
            padding: 0.65rem 0.35rem;
            border-radius: 0.75rem;
            background: #fff;
            border: 1px solid #eef0f7;
        }

        #home-page .home-feature-card {
            min-height: 0;
        }

        #home-page .home-steps-panel {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        #home-page .home-tab-row {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 0.5rem;
            padding-bottom: 0.25rem;
        }

        #home-page .home-tab-row::-webkit-scrollbar {
            display: none;
        }

        #home-page .home-tab-row .tab-btn {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        #home-page .home-partners-row {
            gap: 1rem 1.25rem;
            font-size: 1rem;
        }

        #home-page .home-cta-benefits {
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        #home-page .home-footer-wrap {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media (max-width: 639px) {
        #home-page .home-hero-actions > .grid {
            grid-template-columns: 1fr;
        }

        #home-page .home-hero-image-mobile {
            height: 190px;
        }

        #home-page .home-features-grid {
            grid-template-columns: 1fr;
        }

        #home-page .home-step-item {
            grid-template-columns: 52px 1fr;
            gap: 0.85rem;
        }

        #home-page .home-step-icon {
            width: 52px;
            height: 52px;
            font-size: 1.15rem;
        }

        #home-page .home-booth-actions {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 399px) {
        #home-page .home-hero-title {
            font-size: 1.65rem;
        }

        #home-page .home-hero-actions a {
            padding-left: 1rem;
            padding-right: 1rem;
            font-size: 0.9rem;
        }
    }

    @media (min-width: 1024px) {
        #home-page .home-steps-panel .absolute.border-l-2 {
            display: block;
        }

        #home-page .home-step-item {
            grid-template-columns: 64px 1fr;
        }
    }
</style>
