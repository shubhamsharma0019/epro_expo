<style>
  #event-show-page {
    --es-violet-800: #4C1D95;
    --es-violet-700: #6D28D9;
    --es-lavender-100: #EFE9FE;
    --es-ink: #171522;
    --es-ink-soft: #6B6884;
    --es-line: #EAE6F7;
    --es-grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --es-grad-pill: linear-gradient(135deg, #7C3AED, #5B21B6);
    --es-shadow-card: 0 1px 2px rgba(23, 21, 34, 0.04), 0 16px 34px -18px rgba(76, 29, 149, 0.25);
    font-family: 'Inter', sans-serif;
    color: var(--es-ink);
    overflow-x: hidden;
  }

  #event-show-page h1,
  #event-show-page h2,
  #event-show-page h3,
  #event-show-page h4 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
  }

  #event-show-page .es-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
  }

  @media (min-width: 640px) {
    #event-show-page .es-container {
      padding: 0 32px;
    }
  }

  #event-show-page .es-hero {
    position: relative;
    background: var(--es-grad-hero);
    padding: 0 0 150px;
    overflow: hidden;
  }

  #event-show-page .es-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.22;
    mix-blend-mode: screen;
  }

  #event-show-page .es-hero::after {
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

  #event-show-page .es-hero-inner {
    position: relative;
    z-index: 2;
    padding-top: 8px;
  }

  #event-show-page .es-crumb {
    margin-top: 16px;
    font-size: 12px;
    font-weight: 600;
    color: #CBBEF2;
  }

  #event-show-page .es-crumb a {
    color: #CBBEF2;
    text-decoration: none;
  }

  #event-show-page .es-crumb a:hover {
    color: #fff;
  }

  #event-show-page .es-crumb .sep {
    margin: 0 6px;
    opacity: 0.6;
  }

  #event-show-page .es-crumb .cur {
    color: #fff;
  }

  #event-show-page .es-hero-headrow {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 28px;
    gap: 16px;
    flex-wrap: wrap;
  }

  #event-show-page .es-eyebrow-hero {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.28);
    color: #EDE6FF;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 8px 16px;
    border-radius: 999px;
  }

  #event-show-page .es-eyebrow-hero .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFB454;
  }

  #event-show-page .es-share-btn {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.28);
    color: #fff;
    font-weight: 700;
    font-size: 12.5px;
    padding: 9px 16px;
    border-radius: 999px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    backdrop-filter: blur(4px);
  }

  #event-show-page .es-hero-copy {
    margin-top: 18px;
  }

  #event-show-page .es-hero-copy h1 {
    color: #fff;
    font-size: clamp(1.75rem, 5vw, 2.625rem);
    line-height: 1.14;
    font-weight: 800;
    max-width: 700px;
  }

  #event-show-page .es-hero-meta {
    display: flex;
    gap: 18px;
    margin-top: 14px;
    flex-wrap: wrap;
  }

  #event-show-page .es-hero-meta span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #DCD3FA;
    font-size: 13px;
    font-weight: 600;
  }

  #event-show-page .es-hero-tags {
    display: flex;
    gap: 8px;
    margin-top: 16px;
    flex-wrap: wrap;
  }

  #event-show-page .es-hero-tags .tag {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.26);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 7px 14px;
    border-radius: 999px;
  }

  #event-show-page .es-hero-stats {
    display: flex;
    margin-top: 28px;
    gap: 12px;
    flex-wrap: wrap;
  }

  #event-show-page .es-hero-stat {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 16px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1 1 180px;
    min-width: 0;
  }

  #event-show-page .es-hero-stat .icn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.16);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex: none;
  }

  #event-show-page .es-hero-stat strong {
    display: block;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
  }

  #event-show-page .es-hero-stat span.sub {
    color: #CFC2F7;
    font-size: 10.5px;
    font-weight: 600;
  }

  #event-show-page .es-lift {
    margin-top: -104px;
    position: relative;
    z-index: 3;
    padding-bottom: 72px;
  }

  #event-show-page .es-tab-strip {
    display: flex;
    gap: 24px;
    margin-bottom: 0;
    border-bottom: 1px solid var(--es-line);
    overflow-x: auto;
    scrollbar-width: none;
  }

  #event-show-page .es-tab-strip::-webkit-scrollbar {
    display: none;
  }

  #event-show-page .es-tab-strip .tab {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 13.5px;
    color: var(--es-ink-soft);
    padding: 12px 2px;
    position: relative;
    cursor: pointer;
    white-space: nowrap;
    text-decoration: none;
    flex: 0 0 auto;
  }

  #event-show-page .es-tab-strip .tab.active {
    color: var(--es-violet-700);
  }

  #event-show-page .es-tab-strip .tab.active::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: -1px;
    height: 2px;
    background: var(--es-grad-pill);
    border-radius: 2px;
  }

  #event-show-page .es-body-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    margin-top: 22px;
    align-items: start;
  }

  @media (min-width: 980px) {
    #event-show-page .es-body-grid {
      grid-template-columns: 1fr 320px;
      gap: 22px;
    }
  }

  #event-show-page .es-icard {
    background: #fff;
    border: 1px solid var(--es-line);
    border-radius: 22px;
    padding: 26px 22px;
    box-shadow: var(--es-shadow-card);
  }

  @media (min-width: 640px) {
    #event-show-page .es-icard {
      padding: 30px 26px;
    }
  }

  #event-show-page .es-about-card h2 {
    font-size: 19px;
    margin-bottom: 10px;
    color: var(--es-ink);
  }

  #event-show-page .es-about-card > p {
    font-size: 13.5px;
    color: var(--es-ink-soft);
    line-height: 1.75;
    margin-bottom: 18px;
  }

  #event-show-page .es-about-list {
    display: flex;
    flex-direction: column;
    gap: 11px;
    margin-bottom: 24px;
    list-style: none;
    padding: 0;
  }

  #event-show-page .es-about-list li {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    font-size: 13px;
    color: var(--es-ink);
  }

  #event-show-page .es-about-list li .chk {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--es-lavender-100);
    color: var(--es-violet-700);
    flex: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    margin-top: 1px;
  }

  #event-show-page .es-price-row {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding-top: 20px;
    border-top: 1px solid var(--es-line);
  }

  @media (min-width: 640px) {
    #event-show-page .es-price-row {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
    }
  }

  #event-show-page .es-price-row .lbl {
    font-size: 11px;
    color: var(--es-ink-soft);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  #event-show-page .es-price-row .amt {
    font-size: clamp(1.4rem, 4vw, 1.625rem);
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    margin-top: 2px;
    color: var(--es-ink);
  }

  #event-show-page .es-cta-btn {
    background: var(--es-grad-pill);
    color: #fff;
    border: none;
    font-weight: 700;
    font-size: 13.5px;
    padding: 14px 26px;
    border-radius: 999px;
    cursor: pointer;
    box-shadow: 0 14px 26px -12px rgba(109, 40, 217, 0.55);
    width: 100%;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  @media (min-width: 640px) {
    #event-show-page .es-cta-btn {
      width: auto;
    }
  }

  #event-show-page .es-meta-card h3 {
    font-size: 15px;
    margin-bottom: 18px;
    color: var(--es-ink);
  }

  #event-show-page .es-meta-list {
    display: flex;
    flex-direction: column;
  }

  #event-show-page .es-meta-row {
    display: flex;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid var(--es-line);
    align-items: flex-start;
  }

  #event-show-page .es-meta-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  #event-show-page .es-meta-row:first-child {
    padding-top: 0;
  }

  #event-show-page .es-meta-row .icn {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--es-lavender-100);
    color: var(--es-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex: none;
  }

  #event-show-page .es-meta-row .txt span {
    display: block;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--es-ink-soft);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 2px;
  }

  #event-show-page .es-meta-row .txt strong,
  #event-show-page .es-meta-row .txt a {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--es-ink);
    line-height: 1.5;
    word-break: break-word;
  }

  #event-show-page .es-meta-row .txt a {
    color: var(--es-violet-700);
    text-decoration: none;
  }

  #event-show-page .es-meta-row .txt a:hover {
    text-decoration: underline;
  }

  #event-show-page .es-subsection {
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--es-line);
  }

  #event-show-page .es-subsection h3 {
    font-size: 18px;
    margin-bottom: 14px;
    color: var(--es-ink);
  }

  #event-show-page .es-session-row {
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-bottom: 1px solid #F1EFF7;
    padding-bottom: 14px;
    margin-bottom: 14px;
  }

  #event-show-page .es-session-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
  }

  @media (min-width: 640px) {
    #event-show-page .es-session-row {
      flex-direction: row;
      gap: 16px;
    }
  }

  #event-show-page .es-speaker-card {
    border: 1px solid #F1EFF7;
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 10px;
  }

  @media (max-width: 979px) {
    #event-show-page .es-hero {
      padding-bottom: 180px;
    }

    #event-show-page .es-lift {
      margin-top: -140px;
    }

    #event-show-page .es-hero-stats {
      flex-direction: column;
    }

    #event-show-page .es-hero-stat {
      flex: 1 1 auto;
    }
  }
</style>
