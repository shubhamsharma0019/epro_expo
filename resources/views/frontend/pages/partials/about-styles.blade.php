<style>
  #about-page {
    --ap-violet-700: #6D28D9;
    --ap-violet-800: #4C1D95;
    --ap-lavender-50: #F6F3FF;
    --ap-lavender-100: #EFE9FE;
    --ap-ink: #171522;
    --ap-ink-soft: #6B6884;
    --ap-line: #EAE6F7;
    --ap-grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --ap-grad-pill: linear-gradient(135deg, #7C3AED, #5B21B6);
    --ap-shadow-card: 0 1px 2px rgba(23, 21, 34, 0.04), 0 16px 34px -18px rgba(76, 29, 149, 0.25);
    font-family: 'Inter', sans-serif;
    color: var(--ap-ink);
    overflow-x: hidden;
  }

  #about-page h1,
  #about-page h2,
  #about-page h3,
  #about-page h4 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
    color: var(--ap-ink);
  }

  #about-page .ap-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
  }

  @media (min-width: 640px) {
    #about-page .ap-container {
      padding: 0 32px;
    }
  }

  #about-page .ap-hero {
    position: relative;
    background: var(--ap-grad-hero);
    padding: 40px 0 110px;
    overflow: hidden;
  }

  #about-page .ap-hero::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: -220px;
    transform: translateX(-50%);
    width: min(900px, 120vw);
    height: 420px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.16), transparent 65%);
    pointer-events: none;
  }

  #about-page .ap-hero-inner {
    position: relative;
    z-index: 2;
  }

  #about-page .ap-eyebrow-hero {
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

  #about-page .ap-eyebrow-hero .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFB454;
  }

  #about-page .ap-hero-copy {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
  }

  #about-page .ap-hero-copy h1 {
    color: #fff;
    font-size: clamp(1.75rem, 5vw, 3rem);
    line-height: 1.12;
    font-weight: 800;
    margin-top: 18px;
  }

  #about-page .ap-hero-copy p {
    color: #DCD3FA;
    font-size: clamp(0.9rem, 2.2vw, 0.97rem);
    line-height: 1.7;
    max-width: 560px;
    margin: 16px auto 0;
  }

  #about-page .ap-hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 26px;
  }

  #about-page .ap-btn-white {
    background: #fff;
    color: var(--ap-violet-800);
    font-weight: 700;
    font-size: 14px;
    padding: 12px 22px;
    border-radius: 999px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: opacity 0.2s;
  }

  #about-page .ap-btn-white:hover {
    opacity: 0.92;
  }

  #about-page .ap-btn-outline {
    background: transparent;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 22px;
    border-radius: 999px;
    border: 1.5px solid rgba(255, 255, 255, 0.45);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background 0.2s;
  }

  #about-page .ap-btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  #about-page .ap-hero-stats {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
    flex-wrap: wrap;
  }

  #about-page .ap-hero-stat {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 16px;
    padding: 12px 16px;
    text-align: center;
    min-width: 96px;
    flex: 1 1 auto;
    max-width: 140px;
  }

  #about-page .ap-hero-stat strong {
    display: block;
    color: #fff;
    font-size: 18px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #about-page .ap-hero-stat span {
    color: #CFC2F7;
    font-size: 10.5px;
    font-weight: 600;
  }

  #about-page .ap-lift {
    margin-top: -72px;
    position: relative;
    z-index: 3;
  }

  @media (min-width: 768px) {
    #about-page .ap-lift {
      margin-top: -84px;
    }
  }

  #about-page .ap-cards-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 768px) {
    #about-page .ap-cards-row {
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
  }

  #about-page .ap-icard {
    background: #fff;
    border: 1px solid var(--ap-line);
    border-radius: 22px;
    padding: 24px 20px;
    box-shadow: var(--ap-shadow-card);
  }

  @media (min-width: 640px) {
    #about-page .ap-icard {
      padding: 28px 24px;
    }
  }

  #about-page .ap-icard .ap-icn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--ap-lavender-100);
    color: var(--ap-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 16px;
  }

  #about-page .ap-icard h3 {
    font-size: 16px;
    margin-bottom: 8px;
  }

  #about-page .ap-icard p {
    font-size: 13px;
    color: var(--ap-ink-soft);
    line-height: 1.6;
  }

  #about-page .ap-section {
    padding: 56px 0;
  }

  @media (min-width: 768px) {
    #about-page .ap-section {
      padding: 90px 0;
    }
  }

  #about-page .ap-section.tint {
    background: var(--ap-lavender-50);
  }

  #about-page .ap-eyebrow-sm {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--ap-lavender-100);
    color: var(--ap-violet-700);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 7px 14px;
    border-radius: 999px;
  }

  #about-page .ap-eyebrow-sm .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #F97316;
  }

  #about-page .ap-sec-head {
    text-align: center;
    max-width: 640px;
    margin: 0 auto 36px;
  }

  #about-page .ap-sec-head-compact {
    margin-bottom: 24px;
  }

  #about-page .ap-sec-head-compact h2 {
    font-size: clamp(1.15rem, 3.5vw, 1.375rem);
    margin-top: 0;
  }

  @media (min-width: 768px) {
    #about-page .ap-sec-head {
      margin-bottom: 46px;
    }

    #about-page .ap-sec-head-compact {
      margin-bottom: 30px;
    }
  }

  #about-page .ap-sec-head h2 {
    font-size: clamp(1.45rem, 4vw, 1.875rem);
    margin-top: 14px;
  }

  #about-page .ap-stat-strip {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid var(--ap-line);
    border-radius: 22px;
    box-shadow: var(--ap-shadow-card);
    overflow: hidden;
  }

  @media (min-width: 640px) {
    #about-page .ap-stat-strip {
      flex-direction: row;
    }
  }

  #about-page .ap-stat-cell {
    flex: 1;
    text-align: center;
    padding: 24px 10px;
    border-bottom: 1px solid var(--ap-line);
  }

  #about-page .ap-stat-cell:last-child {
    border-bottom: none;
  }

  @media (min-width: 640px) {
    #about-page .ap-stat-cell {
      padding: 28px 10px;
      border-bottom: none;
      border-right: 1px solid var(--ap-line);
    }

    #about-page .ap-stat-cell:last-child {
      border-right: none;
    }
  }

  #about-page .ap-stat-cell strong {
    display: block;
    font-size: clamp(1.25rem, 3vw, 1.5rem);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ap-violet-700);
  }

  #about-page .ap-stat-cell span {
    font-size: 11.5px;
    color: var(--ap-ink-soft);
    font-weight: 600;
  }

  #about-page .ap-journey {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  #about-page .ap-jrow {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
    align-items: start;
    background: #fff;
    border: 1px solid var(--ap-line);
    border-radius: 18px;
    padding: 20px;
    box-shadow: var(--ap-shadow-card);
  }

  @media (min-width: 640px) {
    #about-page .ap-jrow {
      grid-template-columns: 110px 1fr;
      gap: 18px;
      padding: 22px 24px;
    }
  }

  #about-page .ap-jrow .yr {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 800;
    font-size: 22px;
    color: var(--ap-violet-700);
  }

  #about-page .ap-jrow h4 {
    font-size: 15.5px;
    margin-bottom: 4px;
  }

  #about-page .ap-jrow p {
    font-size: 13px;
    color: var(--ap-ink-soft);
    line-height: 1.6;
  }

  #about-page .ap-trust-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 18px 24px;
    padding: 22px 20px;
    background: #fff;
    border: 1px solid var(--ap-line);
    border-radius: 20px;
    box-shadow: var(--ap-shadow-card);
  }

  @media (min-width: 640px) {
    #about-page .ap-trust-strip {
      justify-content: space-between;
      gap: 18px 30px;
      padding: 26px 34px;
    }
  }

  #about-page .ap-trust-strip span {
    font-weight: 700;
    color: #C9C2E8;
    font-size: 14px;
  }

  @media (min-width: 640px) {
    #about-page .ap-trust-strip span {
      font-size: 15px;
    }
  }

  #about-page .ap-bottom-cta {
    position: relative;
    background: var(--ap-grad-hero);
    border-radius: 24px 24px 0 0;
    padding: 48px 20px 64px;
    text-align: center;
    overflow: hidden;
    margin-top: 12px;
  }

  @media (min-width: 640px) {
    #about-page .ap-bottom-cta {
      border-radius: 32px 32px 0 0;
      padding: 70px 40px 90px;
    }
  }

  #about-page .ap-bottom-cta::after {
    content: "";
    position: absolute;
    left: 50%;
    top: -200px;
    transform: translateX(-50%);
    width: min(800px, 120vw);
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.14), transparent 65%);
  }

  #about-page .ap-bottom-cta .ap-eyebrow-sm {
    background: rgba(255, 255, 255, 0.14);
    color: #EDE6FF;
    position: relative;
    z-index: 1;
  }

  #about-page .ap-bottom-cta h2 {
    color: #fff;
    font-size: clamp(1.5rem, 4.5vw, 2.125rem);
    margin-top: 16px;
    position: relative;
    z-index: 1;
  }

  #about-page .ap-bottom-cta p {
    color: #DCD3FA;
    font-size: 14px;
    margin: 14px auto 0;
    max-width: 480px;
    position: relative;
    z-index: 1;
    line-height: 1.65;
  }

  #about-page .ap-bottom-cta .ap-hero-cta {
    position: relative;
    z-index: 1;
  }

  @media (max-width: 1023px) {
    #about-page .ap-hero {
      padding-top: 36px;
      padding-bottom: 88px;
    }

    #about-page .ap-hero-stats {
      flex-wrap: nowrap;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
      justify-content: flex-start;
      padding-bottom: 4px;
    }

    #about-page .ap-hero-stats::-webkit-scrollbar {
      display: none;
    }

    #about-page .ap-hero-stat {
      flex: 0 0 auto;
      min-width: 100px;
      max-width: none;
    }
  }
</style>
