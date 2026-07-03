<style>
  #pricing-page {
    --pp-violet-800: #4C1D95;
    --pp-violet-700: #6D28D9;
    --pp-lavender-50: #F6F3FF;
    --pp-lavender-100: #EFE9FE;
    --pp-ink: #171522;
    --pp-ink-soft: #6B6884;
    --pp-line: #EAE6F7;
    --pp-grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --pp-grad-pill: linear-gradient(135deg, #7C3AED, #5B21B6);
    --pp-shadow-card: 0 1px 2px rgba(23, 21, 34, 0.04), 0 16px 34px -18px rgba(76, 29, 149, 0.25);
    font-family: 'Inter', sans-serif;
    color: var(--pp-ink);
    overflow-x: hidden;
  }

  #pricing-page h1,
  #pricing-page h2,
  #pricing-page h3,
  #pricing-page h4,
  #pricing-page h5 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
    color: var(--pp-ink);
  }

  #pricing-page .pp-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
  }

  @media (min-width: 640px) {
    #pricing-page .pp-container {
      padding: 0 32px;
    }
  }

  #pricing-page .pp-hero {
    position: relative;
    background: var(--pp-grad-hero);
    padding: 40px 0 110px;
    overflow: hidden;
  }

  #pricing-page .pp-hero::after {
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

  #pricing-page .pp-hero-inner {
    position: relative;
    z-index: 2;
  }

  #pricing-page .pp-eyebrow-hero {
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

  #pricing-page .pp-eyebrow-hero .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FFB454;
  }

  #pricing-page .pp-hero-copy {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
  }

  #pricing-page .pp-hero-copy h1 {
    color: #fff;
    font-size: clamp(1.75rem, 5vw, 3rem);
    line-height: 1.12;
    font-weight: 800;
    margin-top: 18px;
  }

  #pricing-page .pp-hero-copy p {
    color: #DCD3FA;
    font-size: clamp(0.9rem, 2.2vw, 0.97rem);
    line-height: 1.7;
    max-width: 560px;
    margin: 16px auto 0;
  }

  #pricing-page .pp-toggle-wrap {
    display: flex;
    justify-content: center;
    margin-top: 24px;
  }

  #pricing-page .pp-toggle-pill {
    display: inline-flex;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 999px;
    padding: 5px;
    gap: 4px;
  }

  #pricing-page .pp-toggle-pill button {
    border: none;
    background: transparent;
    padding: 9px 18px;
    border-radius: 999px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: #E4DBFF;
    cursor: pointer;
  }

  @media (min-width: 640px) {
    #pricing-page .pp-toggle-pill button {
      padding: 9px 20px;
    }
  }

  #pricing-page .pp-toggle-pill button.active {
    background: #fff;
    color: var(--pp-violet-800);
  }

  #pricing-page .pp-lift {
    margin-top: -72px;
    position: relative;
    z-index: 3;
  }

  @media (min-width: 768px) {
    #pricing-page .pp-lift {
      margin-top: -84px;
    }
  }

  #pricing-page .pp-cards-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 768px) {
    #pricing-page .pp-cards-row {
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
  }

  #pricing-page .pp-pcard {
    background: #fff;
    border: 1px solid var(--pp-line);
    border-radius: 22px;
    padding: 26px 22px;
    box-shadow: var(--pp-shadow-card);
    display: flex;
    flex-direction: column;
  }

  @media (min-width: 640px) {
    #pricing-page .pp-pcard {
      padding: 30px 26px;
    }
  }

  #pricing-page .pp-pcard.mid {
    background: var(--pp-grad-pill);
    color: #fff;
    box-shadow: 0 26px 50px -18px rgba(76, 29, 149, 0.5);
  }

  @media (min-width: 768px) {
    #pricing-page .pp-pcard.mid {
      transform: translateY(-10px);
    }
  }

  #pricing-page .pp-pcard .pp-icn {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: var(--pp-lavender-100);
    color: var(--pp-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    margin-bottom: 18px;
  }

  #pricing-page .pp-pcard.mid .pp-icn {
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
  }

  #pricing-page .pp-pcard h3 {
    font-size: 17px;
    margin-bottom: 4px;
    color: inherit;
  }

  #pricing-page .pp-pcard .pp-pdesc {
    font-size: 12.5px;
    color: var(--pp-ink-soft);
    margin-bottom: 16px;
  }

  #pricing-page .pp-pcard.mid .pp-pdesc {
    color: #E3D8FF;
  }

  #pricing-page .pp-pcard .pp-price {
    font-size: clamp(1.6rem, 4vw, 1.875rem);
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #pricing-page .pp-pcard .pp-price small {
    font-size: 12px;
    font-weight: 600;
    color: var(--pp-ink-soft);
  }

  #pricing-page .pp-pcard.mid .pp-price small {
    color: #E3D8FF;
  }

  #pricing-page .pp-pcard ul {
    margin: 18px 0 22px;
    display: flex;
    flex-direction: column;
    gap: 11px;
    list-style: none;
    padding: 0;
    flex: 1;
  }

  #pricing-page .pp-pcard li {
    display: flex;
    gap: 9px;
    align-items: flex-start;
    font-size: 12.5px;
  }

  #pricing-page .pp-pcard li .chk {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--pp-lavender-100);
    color: var(--pp-violet-700);
    flex: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9.5px;
    margin-top: 1px;
  }

  #pricing-page .pp-pcard.mid li .chk {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
  }

  #pricing-page .pp-pcard .pp-pbtn {
    width: 100%;
    padding: 12px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 13.5px;
    border: 1.5px solid var(--pp-line);
    background: #fff;
    color: var(--pp-ink);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: opacity 0.2s;
  }

  #pricing-page .pp-pcard .pp-pbtn:hover {
    opacity: 0.92;
  }

  #pricing-page .pp-pcard.mid .pp-pbtn {
    background: #fff;
    color: var(--pp-violet-700);
    border: none;
  }

  #pricing-page .pp-section {
    padding: 56px 0;
  }

  @media (min-width: 768px) {
    #pricing-page .pp-section {
      padding: 90px 0;
    }
  }

  #pricing-page .pp-section.tint {
    background: var(--pp-lavender-50);
  }

  #pricing-page .pp-eyebrow-sm {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--pp-lavender-100);
    color: var(--pp-violet-700);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 7px 14px;
    border-radius: 999px;
  }

  #pricing-page .pp-eyebrow-sm .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #F97316;
  }

  #pricing-page .pp-sec-head {
    text-align: center;
    max-width: 640px;
    margin: 0 auto 36px;
  }

  @media (min-width: 768px) {
    #pricing-page .pp-sec-head {
      margin-bottom: 46px;
    }
  }

  #pricing-page .pp-sec-head h2 {
    font-size: clamp(1.45rem, 4vw, 1.875rem);
    margin-top: 14px;
  }

  #pricing-page .pp-grid-4 {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
  }

  @media (min-width: 640px) {
    #pricing-page .pp-grid-4 {
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
  }

  @media (min-width: 980px) {
    #pricing-page .pp-grid-4 {
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }
  }

  #pricing-page .pp-icard {
    background: #fff;
    border: 1px solid var(--pp-line);
    border-radius: 22px;
    padding: 28px 24px;
    box-shadow: var(--pp-shadow-card);
    text-align: center;
  }

  #pricing-page .pp-icard .pp-icn {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--pp-lavender-100);
    color: var(--pp-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    margin: 0 auto 14px;
  }

  #pricing-page .pp-icard h4 {
    font-size: 16px;
    margin-bottom: 8px;
  }

  #pricing-page .pp-icard p {
    font-size: 13px;
    color: var(--pp-ink-soft);
    line-height: 1.6;
  }

  #pricing-page .pp-faq-wrap {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
    align-items: start;
  }

  @media (min-width: 980px) {
    #pricing-page .pp-faq-wrap {
      grid-template-columns: 0.85fr 1.15fr;
      gap: 60px;
    }
  }

  #pricing-page .pp-faq-left h2 {
    font-size: clamp(1.5rem, 4vw, 2rem);
    margin-top: 16px;
    line-height: 1.2;
  }

  #pricing-page .pp-still-card {
    background: var(--pp-lavender-50);
    border: 1px solid var(--pp-line);
    border-radius: 18px;
    padding: 24px;
    margin-top: 24px;
  }

  @media (min-width: 768px) {
    #pricing-page .pp-still-card {
      margin-top: 30px;
    }
  }

  #pricing-page .pp-still-card h4 {
    font-size: 15px;
    margin-bottom: 6px;
  }

  #pricing-page .pp-still-card p {
    font-size: 12.5px;
    color: var(--pp-ink-soft);
    margin-bottom: 16px;
    line-height: 1.55;
  }

  #pricing-page .pp-still-card .pp-row {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  @media (min-width: 480px) {
    #pricing-page .pp-still-card .pp-row {
      flex-direction: row;
    }
  }

  #pricing-page .pp-still-card input {
    flex: 1;
    border: 1px solid var(--pp-line);
    border-radius: 999px;
    padding: 11px 16px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    outline: none;
    min-width: 0;
  }

  #pricing-page .pp-still-card button {
    background: var(--pp-grad-pill);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 11px 20px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    white-space: nowrap;
  }

  #pricing-page .pp-faq-list {
    display: flex;
    flex-direction: column;
  }

  #pricing-page .pp-faq-item {
    border-bottom: 1px solid var(--pp-line);
    padding: 20px 0;
  }

  #pricing-page .pp-faq-item:first-child {
    padding-top: 0;
  }

  #pricing-page .pp-faq-q {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    cursor: pointer;
    font-weight: 700;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #pricing-page .pp-faq-q .chev {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--pp-lavender-100);
    color: var(--pp-violet-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex: none;
    transition: transform 0.25s;
  }

  #pricing-page .pp-faq-item.open .chev {
    transform: rotate(180deg);
    background: var(--pp-grad-pill);
    color: #fff;
  }

  #pricing-page .pp-faq-a {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }

  #pricing-page .pp-faq-item.open .pp-faq-a {
    max-height: 200px;
  }

  #pricing-page .pp-faq-a p {
    font-size: 13px;
    color: var(--pp-ink-soft);
    line-height: 1.65;
    padding-top: 12px;
    padding-right: 20px;
  }

  #pricing-page .pp-bottom-cta {
    position: relative;
    background: var(--pp-grad-hero);
    border-radius: 24px 24px 0 0;
    padding: 48px 20px 64px;
    text-align: center;
    overflow: hidden;
    margin-top: 12px;
  }

  @media (min-width: 640px) {
    #pricing-page .pp-bottom-cta {
      border-radius: 32px 32px 0 0;
      padding: 70px 40px 90px;
    }
  }

  #pricing-page .pp-bottom-cta::after {
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

  #pricing-page .pp-bottom-cta .pp-eyebrow-sm {
    background: rgba(255, 255, 255, 0.14);
    color: #EDE6FF;
    position: relative;
    z-index: 1;
  }

  #pricing-page .pp-bottom-cta h2 {
    color: #fff;
    font-size: clamp(1.5rem, 4.5vw, 2.125rem);
    margin-top: 16px;
    position: relative;
    z-index: 1;
  }

  #pricing-page .pp-bottom-cta p {
    color: #DCD3FA;
    font-size: 14px;
    margin: 14px auto 0;
    max-width: 480px;
    position: relative;
    z-index: 1;
    line-height: 1.65;
  }

  #pricing-page .pp-hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-top: 26px;
    position: relative;
    z-index: 1;
  }

  #pricing-page .pp-btn-white {
    background: #fff;
    color: var(--pp-violet-800);
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

  #pricing-page .pp-btn-white:hover {
    opacity: 0.92;
  }

  #pricing-page .pp-btn-outline {
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

  #pricing-page .pp-btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
  }
</style>
