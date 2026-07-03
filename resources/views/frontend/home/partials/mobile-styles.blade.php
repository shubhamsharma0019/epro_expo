<style>
    #home-page {
        overflow-x: hidden;
    }

    #home-page .get-started-desktop [data-get-started-toggle] {
        background: var(--ink) !important;
        border-radius: 999px !important;
        box-shadow: none !important;
        padding: 11px 20px !important;
        font-size: 15px !important;
    }

    #home-page .get-started-desktop [data-get-started-panel] {
        min-width: 360px;
    }

    @media (max-width: 980px) {
        #home-page .hero-grid {
            gap: 28px;
            margin-top: 28px;
        }

        #home-page .hero-visual {
            order: -1;
        }

        #home-page .visual-card {
            aspect-ratio: 16 / 10;
        }

        #home-page .cat-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        #home-page .cat-tile {
            min-width: 0;
            padding: 16px 12px;
        }

        #home-page .trend-grid {
            grid-template-columns: 1fr;
        }

        #home-page .footer-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        #home-page .foot-links {
            gap: 14px 18px;
        }
    }

    @media (max-width: 600px) {
        #home-page .hero-copy h1 {
            font-size: 26px;
            margin-left: 0;
        }

        #home-page .hero-eyebrow {
            font-size: 10px;
            padding: 7px 12px;
        }

        #home-page .sec-headrow h2 {
            font-size: 18px;
        }

        #home-page .event-body .price-row {
            flex-direction: column;
            align-items: stretch;
        }

        #home-page .view-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
