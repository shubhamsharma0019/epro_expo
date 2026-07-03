<style>
  #exhibition-show-page {
    --ex-violet-800: #4C1D95;
    --ex-violet-700: #6D28D9;
    --ex-lavender-100: #EFE9FE;
    --ex-ink: #171522;
    --ex-ink-soft: #6B6884;
    --ex-line: #EAE6F7;
    --ex-grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --ex-grad-pill: linear-gradient(135deg, #7C3AED, #5B21B6);
    --ex-shadow-card: 0 1px 2px rgba(23, 21, 34, 0.04), 0 16px 34px -18px rgba(76, 29, 149, 0.25);
    font-family: 'Inter', sans-serif;
    color: var(--ex-ink);
    padding-bottom: 76px;
  }

  #exhibition-show-page h1,
  #exhibition-show-page h2,
  #exhibition-show-page h3,
  #exhibition-show-page h4 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
  }

  #exhibition-show-page .ex-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
  }

  @media (min-width: 640px) {
    #exhibition-show-page .ex-container { padding: 0 32px; }
  }

  #exhibition-show-page .ex-hero {
    position: relative;
    background: var(--ex-grad-hero);
    padding: 8px 0 170px;
    overflow: hidden;
  }

  #exhibition-show-page .ex-hero::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: -260px;
    transform: translateX(-50%);
    width: min(900px, 120vw);
    height: 520px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.16), transparent 65%);
    pointer-events: none;
  }

  #exhibition-show-page .ex-hero-inner { position: relative; z-index: 2; }

  #exhibition-show-page .ex-crumb {
    margin: 16px 0 0;
    font-size: 13px;
    font-weight: 700;
    color: #DCD3FA;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }

  #exhibition-show-page .ex-crumb:hover { color: #fff; }

  #exhibition-show-page .ex-hero-split {
    display: grid;
    grid-template-columns: 1fr;
    gap: 28px;
    margin-top: 24px;
    align-items: start;
  }

  @media (min-width: 980px) {
    #exhibition-show-page .ex-hero-split { grid-template-columns: 1.05fr 0.95fr; gap: 40px; }
  }

  #exhibition-show-page .ex-hero-tags { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
  #exhibition-show-page .ex-hero-tags .tag {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.26);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 7px 14px;
    border-radius: 999px;
  }

  #exhibition-show-page .ex-hero-copy h1 {
    color: #fff;
    font-size: clamp(1.75rem, 5vw, 2.375rem);
    line-height: 1.14;
    font-weight: 800;
  }

  #exhibition-show-page .ex-hero-copy .subline {
    color: #E3D8FF;
    font-size: 15px;
    font-weight: 600;
    margin-top: 8px;
  }

  #exhibition-show-page .ex-hero-copy .subline b { color: #FFB454; font-weight: 800; }

  #exhibition-show-page .ex-hero-meta {
    display: flex;
    gap: 18px;
    margin-top: 16px;
    flex-wrap: wrap;
  }

  #exhibition-show-page .ex-hero-meta span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #DCD3FA;
    font-size: 13px;
    font-weight: 600;
  }

  #exhibition-show-page .ex-hero-copy p.desc {
    color: #CBBEF2;
    font-size: 13.5px;
    line-height: 1.7;
    margin-top: 16px;
    max-width: 480px;
  }

  #exhibition-show-page .ex-hero-cta-row { display: flex; gap: 12px; margin-top: 22px; flex-wrap: wrap; }

  #exhibition-show-page .ex-btn-white {
    background: #fff;
    color: var(--ex-violet-800);
    font-weight: 700;
    font-size: 13.5px;
    padding: 13px 24px;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }

  #exhibition-show-page .ex-btn-outline-w {
    background: transparent;
    color: #fff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 13px 24px;
    border-radius: 999px;
    border: 1.5px solid rgba(255, 255, 255, 0.45);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  #exhibition-show-page .ex-promo {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    min-height: 280px;
    background:
      linear-gradient(100deg, rgba(59, 15, 115, 0.88) 0%, rgba(76, 29, 149, 0.6) 45%, rgba(139, 92, 246, 0.35) 100%),
      repeating-linear-gradient(120deg, rgba(255, 255, 255, 0.05) 0 2px, transparent 2px 38px),
      linear-gradient(160deg, #2A0A55, #150726 70%);
    padding: 24px 26px;
    box-shadow: 0 26px 50px -18px rgba(23, 10, 46, 0.55);
  }

  #exhibition-show-page .ex-promo-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.25;
  }

  #exhibition-show-page .ex-promo-body { position: relative; z-index: 1; }
  #exhibition-show-page .ex-promo h3 { color: #fff; font-size: 22px; }
  #exhibition-show-page .ex-promo h3 b { color: #C4B5FD; font-weight: 800; }
  #exhibition-show-page .ex-promo > .ex-promo-body > p {
    color: #D9CFF6;
    font-size: 12.5px;
    line-height: 1.6;
    margin-top: 8px;
    max-width: 220px;
  }

  #exhibition-show-page .ex-promo-icons { display: flex; gap: 18px; margin-top: 22px; flex-wrap: wrap; }
  #exhibition-show-page .ex-promo-icons div { display: flex; flex-direction: column; align-items: center; gap: 6px; }
  #exhibition-show-page .ex-promo-icons .ic {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.22);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #fff;
  }
  #exhibition-show-page .ex-promo-icons span { color: #CBBEF2; font-size: 9.5px; font-weight: 700; }

  #exhibition-show-page .ex-promo-info {
    position: absolute;
    right: 18px;
    top: 18px;
    width: 172px;
    background: rgba(255, 255, 255, 0.97);
    border-radius: 16px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 11px;
    box-shadow: 0 12px 24px -8px rgba(23, 10, 46, 0.4);
    z-index: 2;
  }

  #exhibition-show-page .ex-promo-info .row span {
    display: block;
    font-size: 9px;
    font-weight: 700;
    color: var(--ex-ink-soft);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 2px;
  }

  #exhibition-show-page .ex-promo-info .row strong {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--ex-ink);
    line-height: 1.4;
    display: block;
  }

  @media (max-width: 1100px) {
    #exhibition-show-page .ex-promo-info { position: static; width: auto; margin-top: 16px; }
  }

  #exhibition-show-page .ex-stat-carousel {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 36px;
  }

  #exhibition-show-page .ex-car-arrow {
    width: 42px; height: 42px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.26);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; cursor: pointer; flex: none;
  }

  #exhibition-show-page .ex-stat-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    flex: 1;
    overflow-x: auto;
    scroll-behavior: smooth;
  }

  @media (min-width: 768px) {
    #exhibition-show-page .ex-stat-row { grid-template-columns: repeat(4, 1fr); gap: 18px; }
  }

  #exhibition-show-page .ex-stat-card {
    background: #fff;
    border: 1px solid var(--ex-line);
    border-radius: 20px;
    padding: 18px 14px;
    text-align: center;
    box-shadow: var(--ex-shadow-card);
    min-width: 140px;
  }

  #exhibition-show-page .ex-stat-card .icn {
    width: 38px; height: 38px; border-radius: 11px;
    background: var(--ex-lavender-100);
    color: var(--ex-violet-700);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; margin: 0 auto 10px;
  }

  #exhibition-show-page .ex-stat-card strong {
    display: block;
    font-size: 22px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ex-ink);
  }

  #exhibition-show-page .ex-stat-card span {
    font-size: 11px;
    color: var(--ex-ink-soft);
    font-weight: 600;
  }

  #exhibition-show-page .ex-lift { margin-top: -118px; position: relative; z-index: 3; }
  #exhibition-show-page .ex-lift-space { height: 48px; }

  #exhibition-show-page .ex-icard {
    background: #fff;
    border: 1px solid var(--ex-line);
    border-radius: 22px;
    padding: 24px 22px;
    box-shadow: var(--ex-shadow-card);
  }

  #exhibition-show-page .ex-icard h3 { font-size: 15px; margin-bottom: 16px; color: var(--ex-ink); }

  #exhibition-show-page .ex-eyebrow-sm {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--ex-lavender-100);
    color: var(--ex-violet-700);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 6px 13px;
    border-radius: 999px;
    margin-bottom: 14px;
  }

  #exhibition-show-page .ex-tab-strip {
    display: flex;
    gap: 24px;
    border-bottom: 1px solid var(--ex-line);
    overflow-x: auto;
    scrollbar-width: none;
  }

  #exhibition-show-page .ex-tab-strip::-webkit-scrollbar { display: none; }

  #exhibition-show-page .ex-tab-strip .tab {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--ex-ink-soft);
    padding: 12px 2px;
    position: relative;
    cursor: pointer;
    white-space: nowrap;
    background: none;
    border: none;
    flex: 0 0 auto;
  }

  #exhibition-show-page .ex-tab-strip .tab.active { color: var(--ex-violet-700); }

  #exhibition-show-page .ex-tab-strip .tab.active::after {
    content: "";
    position: absolute;
    left: 0; right: 0; bottom: -1px;
    height: 2px;
    background: var(--ex-grad-pill);
    border-radius: 2px;
  }

  #exhibition-show-page .ex-body-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    margin: 22px 0 20px;
    align-items: start;
  }

  @media (min-width: 980px) {
    #exhibition-show-page .ex-body-grid { grid-template-columns: 1fr 320px; gap: 22px; }
  }

  #exhibition-show-page .ex-stack { display: flex; flex-direction: column; gap: 18px; }

  #exhibition-show-page .ex-check-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  #exhibition-show-page .ex-check-list li {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    font-size: 13px;
    color: var(--ex-ink);
  }

  #exhibition-show-page .ex-check-list li .chk {
    width: 18px; height: 18px; border-radius: 50%;
    background: var(--ex-lavender-100);
    color: var(--ex-violet-700);
    flex: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; margin-top: 1px;
  }

  #exhibition-show-page .ex-about-card p {
    font-size: 13.5px;
    color: var(--ex-ink-soft);
    line-height: 1.75;
    margin: 0;
  }

  #exhibition-show-page .ex-empty-state {
    text-align: center;
    padding: 36px 10px;
    color: var(--ex-ink-soft);
    font-size: 13px;
    font-weight: 600;
  }

  #exhibition-show-page .ex-meta-list { display: flex; flex-direction: column; }
  #exhibition-show-page .ex-meta-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--ex-line);
    align-items: center;
  }

  #exhibition-show-page .ex-meta-row:last-child { border-bottom: none; padding-bottom: 0; }
  #exhibition-show-page .ex-meta-row:first-child { padding-top: 0; }
  #exhibition-show-page .ex-meta-row .lbl { font-size: 12px; color: var(--ex-ink-soft); font-weight: 600; }
  #exhibition-show-page .ex-meta-row .val {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--ex-ink);
    text-align: right;
    max-width: 170px;
    word-break: break-word;
  }

  #exhibition-show-page .ex-org-row { display: flex; align-items: center; gap: 12px; }
  #exhibition-show-page .ex-org-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--ex-grad-pill);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    overflow: hidden;
    flex: none;
  }

  #exhibition-show-page .ex-org-avatar img { width: 100%; height: 100%; object-fit: cover; }
  #exhibition-show-page .ex-org-row strong { display: block; font-size: 13.5px; }
  #exhibition-show-page .ex-org-row span { font-size: 11.5px; color: var(--ex-ink-soft); font-weight: 600; }

  #exhibition-show-page .ex-qa-btn {
    width: 100%;
    padding: 13px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 13px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-bottom: 10px;
    text-decoration: none;
  }

  #exhibition-show-page .ex-qa-btn.primary { background: var(--ex-ink); color: #fff; }
  #exhibition-show-page .ex-qa-btn.outline { background: #fff; color: var(--ex-ink); border: 1.5px solid var(--ex-line); }
  #exhibition-show-page .ex-qa-link {
    display: block;
    text-align: center;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--ex-violet-700);
    padding-top: 4px;
    background: none;
    border: none;
    cursor: pointer;
    width: 100%;
  }

  #exhibition-show-page .ex-tab-panel.hidden { display: none; }

  #exhibition-show-page .ex-company-card {
    border: 1px solid #F1EFF7;
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  @media (min-width: 640px) {
    #exhibition-show-page .ex-company-card {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
    }
  }

  #exhibition-show-page .ex-company-logo {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--ex-lavender-100);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    flex: none;
  }

  #exhibition-show-page .ex-session-row {
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-bottom: 1px solid #F1EFF7;
    padding-bottom: 14px;
    margin-bottom: 14px;
  }

  #exhibition-show-page .ex-session-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

  #exhibition-show-page .ex-speaker-card {
    border: 1px solid #F1EFF7;
    border-radius: 14px;
    padding: 16px;
    text-align: center;
  }

  #exhibition-show-page .ex-sticky-cta {
    position: fixed;
    left: 0; right: 0; bottom: 0;
    background: var(--ex-ink);
    z-index: 50;
    padding: 14px 0;
    box-shadow: 0 -12px 30px -14px rgba(23, 21, 34, 0.4);
  }

  #exhibition-show-page .ex-sticky-cta .ex-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }

  #exhibition-show-page .ex-sticky-cta .info { color: #fff; min-width: 0; }
  #exhibition-show-page .ex-sticky-cta .info strong {
    display: block;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #exhibition-show-page .ex-sticky-cta .info span {
    font-size: 11.5px;
    color: #B7B2CE;
  }

  #exhibition-show-page .ex-sticky-cta a {
    background: var(--ex-grad-pill);
    color: #fff;
    border: none;
    font-weight: 700;
    font-size: 13.5px;
    padding: 13px 26px;
    border-radius: 999px;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
  }

  @media (max-width: 979px) {
    #exhibition-show-page .ex-hero { padding-bottom: 200px; }
    #exhibition-show-page .ex-lift { margin-top: -140px; }
  }
</style>
