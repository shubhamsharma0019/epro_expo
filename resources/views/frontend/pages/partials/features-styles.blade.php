<style>
  #features-page {
    --hf-violet-900: #3B0F73;
    --hf-violet-800: #4C1D95;
    --hf-violet-700: #6D28D9;
    --hf-violet-600: #7C3AED;
    --hf-lavender-50: #F6F3FF;
    --hf-lavender-100: #EFE9FE;
    --hf-ink: #171522;
    --hf-ink-soft: #6B6884;
    --hf-line: #EAE6F7;
    --hf-grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --hf-grad-pill: linear-gradient(135deg, #7C3AED, #5B21B6);
    --hf-shadow-card: 0 1px 2px rgba(23, 21, 34, 0.04), 0 16px 34px -18px rgba(76, 29, 149, 0.25);
    font-family: 'Inter', sans-serif;
    color: var(--hf-ink);
  }

  #features-page h2,
  #features-page h3,
  #features-page h4,
  #features-page h5 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
    color: var(--hf-ink);
  }

  #features-page .hf-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
  }

  @media (min-width: 640px) {
    #features-page .hf-container {
      padding: 0 32px;
    }
  }

  #features-page .hf-hero {
    position: relative;
    background: var(--hf-grad-hero);
    padding: 48px 0 110px;
    overflow: hidden;
  }

  #features-page .hf-hero::after {
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

  #features-page .hf-hero-inner {
    position: relative;
    z-index: 2;
  }

  #features-page .hf-eyebrow-hero {
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

  #features-page .hf-eyebrow-hero .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFB454;
  }

  #features-page .hf-hero-copy {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
  }

  #features-page .hf-hero-copy h1,
  #features-page .hf-hero-copy h2 {
    color: #fff;
    font-size: clamp(1.75rem, 5vw, 2.75rem);
    line-height: 1.12;
    font-weight: 800;
    margin-top: 18px;
  }

  #features-page .hf-hero-copy p {
    color: #DCD3FA;
    font-size: clamp(0.9rem, 2.2vw, 0.97rem);
    line-height: 1.7;
    max-width: 560px;
    margin: 16px auto 0;
  }

  #features-page .hf-hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 26px;
  }

  #features-page .hf-btn-white {
    background: #fff;
    color: var(--hf-violet-800);
    font-weight: 700;
    font-size: 14px;
    padding: 12px 22px;
    border-radius: 999px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s;
  }

  #features-page .hf-btn-white:hover {
    opacity: 0.92;
  }

  #features-page .hf-btn-outline {
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
    transition: background 0.2s;
  }

  #features-page .hf-btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  #features-page .hf-hero-stats {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
    flex-wrap: wrap;
  }

  #features-page .hf-hero-stat {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 16px;
    padding: 12px 16px;
    text-align: center;
    min-width: 96px;
    flex: 1 1 auto;
    max-width: 140px;
    text-decoration: none;
    color: inherit;
  }

  #features-page .hf-hero-stat strong {
    display: block;
    color: #fff;
    font-size: 18px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #features-page .hf-hero-stat span {
    color: #CFC2F7;
    font-size: 10.5px;
    font-weight: 600;
  }

  #features-page .hf-lift {
    margin-top: -72px;
    position: relative;
    z-index: 3;
  }

  @media (min-width: 768px) {
    #features-page .hf-lift {
      margin-top: -84px;
    }
  }

  #features-page .hf-cards-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 768px) {
    #features-page .hf-cards-row {
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
  }

  #features-page .hf-icard {
    background: #fff;
    border: 1px solid var(--hf-line);
    border-radius: 22px;
    padding: 24px 20px;
    box-shadow: var(--hf-shadow-card);
  }

  @media (min-width: 640px) {
    #features-page .hf-icard {
      padding: 28px 24px;
    }
  }

  #features-page .hf-icard .hf-icn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--hf-lavender-100);
    color: var(--hf-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin-bottom: 16px;
  }

  #features-page .hf-icard h4 {
    font-size: 16px;
    margin-bottom: 8px;
  }

  #features-page .hf-icard p {
    font-size: 13px;
    color: var(--hf-ink-soft);
    line-height: 1.6;
  }

  #features-page .hf-section {
    padding: 56px 0;
  }

  @media (min-width: 768px) {
    #features-page .hf-section {
      padding: 90px 0;
    }
  }

  #features-page .hf-section.tint {
    background: var(--hf-lavender-50);
  }

  #features-page .hf-eyebrow-sm {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--hf-lavender-100);
    color: var(--hf-violet-700);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 7px 14px;
    border-radius: 999px;
  }

  #features-page .hf-eyebrow-sm .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #F97316;
  }

  #features-page .hf-sec-head {
    text-align: center;
    max-width: 640px;
    margin: 0 auto 36px;
  }

  @media (min-width: 768px) {
    #features-page .hf-sec-head {
      margin-bottom: 46px;
    }
  }

  #features-page .hf-sec-head h2 {
    font-size: clamp(1.45rem, 4vw, 1.875rem);
    margin-top: 14px;
  }

  #features-page .hf-sec-head p {
    color: var(--hf-ink-soft);
    font-size: 14px;
    margin-top: 12px;
    line-height: 1.7;
  }

  #features-page .hf-grid-3 {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 640px) {
    #features-page .hf-grid-3 {
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
  }

  @media (min-width: 980px) {
    #features-page .hf-grid-3 {
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
  }

  #features-page .hf-steps-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
  }

  @media (min-width: 640px) {
    #features-page .hf-steps-row {
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
  }

  @media (min-width: 980px) {
    #features-page .hf-steps-row {
      grid-template-columns: repeat(4, 1fr);
      gap: 18px;
    }
  }

  #features-page .hf-step-card {
    background: #fff;
    border: 1px solid var(--hf-line);
    border-radius: 18px;
    padding: 22px 20px;
    box-shadow: var(--hf-shadow-card);
  }

  #features-page .hf-step-card .num {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--hf-grad-pill);
    color: #fff;
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
  }

  #features-page .hf-step-card h5 {
    font-size: 14.5px;
    margin-bottom: 6px;
  }

  #features-page .hf-step-card p {
    font-size: 12px;
    color: var(--hf-ink-soft);
    line-height: 1.55;
  }

  #features-page .hf-flow-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 640px) {
    #features-page .hf-flow-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 18px;
    }
  }

  #features-page .hf-flow-card {
    background: #fff;
    border: 1px solid var(--hf-line);
    border-radius: 18px;
    padding: 22px 20px;
    box-shadow: var(--hf-shadow-card);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  #features-page .hf-flow-card .tag {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    margin-bottom: 12px;
    background: var(--hf-lavender-100);
    color: var(--hf-violet-700);
    align-self: flex-start;
  }

  #features-page .hf-flow-card h4 {
    font-size: 15px;
    margin-bottom: 6px;
  }

  #features-page .hf-flow-card p {
    font-size: 12.5px;
    color: var(--hf-ink-soft);
    line-height: 1.55;
    margin-bottom: 10px;
    flex: 1;
  }

  #features-page .hf-flow-card a {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--hf-violet-700);
    margin-top: auto;
  }

  #features-page .hf-flow-card a:hover {
    color: var(--hf-violet-800);
  }

  #features-page .hf-bottom-cta {
    position: relative;
    background: var(--hf-grad-hero);
    border-radius: 24px 24px 0 0;
    padding: 48px 20px 64px;
    text-align: center;
    overflow: hidden;
    margin-top: 12px;
  }

  @media (min-width: 640px) {
    #features-page .hf-bottom-cta {
      border-radius: 32px 32px 0 0;
      padding: 70px 40px 90px;
    }
  }

  #features-page .hf-bottom-cta::after {
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

  #features-page .hf-bottom-cta .hf-eyebrow-sm {
    background: rgba(255, 255, 255, 0.14);
    color: #EDE6FF;
    position: relative;
    z-index: 1;
  }

  #features-page .hf-bottom-cta h2 {
    color: #fff;
    font-size: clamp(1.5rem, 4.5vw, 2.125rem);
    margin-top: 16px;
    position: relative;
    z-index: 1;
  }

  #features-page .hf-bottom-cta p {
    color: #DCD3FA;
    font-size: 14px;
    margin: 14px auto 0;
    max-width: 480px;
    position: relative;
    z-index: 1;
    line-height: 1.65;
  }

  #features-page .hf-bottom-cta .hf-hero-cta {
    position: relative;
    z-index: 1;
  }

  @media (max-width: 1023px) {
    #features-page .hf-hero {
      padding-top: 36px;
      padding-bottom: 88px;
    }

    #features-page .hf-hero-stats {
      flex-wrap: nowrap;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
      justify-content: flex-start;
      padding-bottom: 4px;
    }

    #features-page .hf-hero-stats::-webkit-scrollbar {
      display: none;
    }

    #features-page .hf-hero-stat {
      flex: 0 0 auto;
      min-width: 88px;
      max-width: none;
    }
  }
</style>
