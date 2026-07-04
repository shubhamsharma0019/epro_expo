<style>
    #event-home-page {
        overflow-x: hidden;
    }

    @media (max-width: 980px) {
        #event-home-page .hero-grid {
            gap: 28px;
            margin-top: 28px;
        }

        #event-home-page .hero-visual {
            order: -1;
        }

        #event-home-page .visual-card {
            aspect-ratio: 16 / 10;
        }

        #event-home-page .cat-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        #event-home-page .cat-tile {
            min-width: 0;
            padding: 16px 12px;
        }

        #event-home-page .trend-grid {
            grid-template-columns: 1fr;
        }

        #event-home-page .footer-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        #event-home-page .foot-links {
            gap: 14px 18px;
        }
    }

    @media (max-width: 600px) {
        #event-home-page .hero-copy h1 {
            font-size: 26px;
            margin-left: 0;
        }

        #event-home-page .hero-eyebrow {
            font-size: 10px;
            padding: 7px 12px;
        }

        #event-home-page .sec-headrow h2 {
            font-size: 18px;
        }

        #event-home-page .event-body .price-row {
            flex-direction: column;
            align-items: stretch;
        }

        #event-home-page .view-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
