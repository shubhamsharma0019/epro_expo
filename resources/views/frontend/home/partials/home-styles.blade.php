<style>
  :root{
    --violet-900:#3B0F73;
    --violet-800:#4C1D95;
    --violet-700:#6D28D9;
    --violet-600:#7C3AED;
    --violet-500:#8B5CF6;
    --violet-300:#C4B5FD;
    --lavender-50:#F6F3FF;
    --lavender-100:#EFE9FE;
    --ink:#171522;
    --ink-soft:#6B6884;
    --line:#EAE6F7;
    --white:#fff;
    --grad-hero: radial-gradient(120% 90% at 15% 0%, #8B5CF6 0%, #6D28D9 42%, #4C1D95 78%, #3B0F73 100%);
    --grad-pill: linear-gradient(135deg,#7C3AED,#5B21B6);
    --shadow-card: 0 1px 2px rgba(23,21,34,0.04), 0 16px 34px -18px rgba(76,29,149,0.25);
    --shadow-nav: 0 12px 30px -10px rgba(76,29,149,0.35);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html{scroll-behavior:smooth;}
  body{ font-family:'Inter',sans-serif; color:var(--ink); background:var(--white); -webkit-font-smoothing:antialiased; }
  h1,h2,h3,h4{ font-family:'Plus Jakarta Sans',sans-serif; letter-spacing:-0.02em; color:var(--ink); }
  .container{ max-width:1160px; margin:0 auto; padding:0 32px; }
  a{ text-decoration:none; color:inherit; }
  ul{ list-style:none; }

  .hero{ position:relative; background:var(--grad-hero); padding:40px 0 200px; overflow:hidden; }
  .hero::after{
    content:""; position:absolute; left:50%; bottom:-260px; transform:translateX(-50%);
    width:900px; height:520px; border-radius:50%;
    background:radial-gradient(circle, rgba(255,255,255,0.16), transparent 65%);
    pointer-events:none;
  }
  .hero-inner{ position:relative; z-index:2; max-width:1240px; padding:0 32px; margin:0 auto; }

  .topbar{ background:#fff; border-bottom:1px solid var(--line); position:sticky; top:0; z-index:50; }
  .nav-pill{
    display:flex; align-items:center; justify-content:space-between;
    padding:12px 0; gap:16px;
  }
  .nav-links{ display:flex; align-items:center; gap:26px; font-weight:600; font-size:15.5px; color:#38354A; }
  .nav-links a:hover{ color:var(--violet-700); }
  .nav-actions{ display:flex; align-items:center; gap:12px; }
  .menu-btn{
    display:none; width:40px; height:40px; border-radius:12px; border:1px solid var(--line);
    background:#fff; color:var(--ink); font-size:20px; cursor:pointer; align-items:center; justify-content:center;
  }
  .mobile-menu{
    display:none; border-top:1px solid var(--line); padding:16px 0 20px;
  }
  .mobile-menu.open{ display:block; }
  .mobile-menu a{ display:block; padding:10px 0; font-weight:600; font-size:15px; color:#38354A; }
  .mobile-menu a:hover{ color:var(--violet-700); }
  .mobile-menu .get-started-mobile{ margin-top:12px; }

  .hero-grid{ display:grid; grid-template-columns:1.05fr 0.95fr; gap:44px; align-items:center; margin-top:50px; }
  .hero-eyebrow{
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(255,255,255,0.14); border:1px solid rgba(255,255,255,0.28);
    color:#EDE6FF; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:11.5px;
    letter-spacing:0.06em; text-transform:uppercase; padding:8px 16px; border-radius:999px;
  }
  .hero-eyebrow .dot{ width:6px; height:6px; border-radius:50%; background:#FFB454; }
  .hero-copy h1{ color:#fff; font-size:44px; line-height:1.14; font-weight:800; margin-top:18px; margin-left:-10px; }
  .hero-copy h1 .accent{ color:#C4B5FD; }
  .hero-copy p{ color:#DCD3FA; font-size:14.5px; line-height:1.75; margin-top:16px; max-width:440px; }

  .hero-visual{ position:relative; }
  .visual-card{
    position:relative; border-radius:24px; overflow:hidden; aspect-ratio:4/3;
    background:#0E0421;
    box-shadow:0 30px 60px -20px rgba(15,4,35,0.6);
  }
  .visual-card .visual-slide{
    position:absolute; inset:0; opacity:0; transition:opacity .5s ease;
  }
  .visual-card .visual-slide.active{ opacity:1; z-index:1; }
  .visual-card .visual-slide img{ width:100%; height:100%; object-fit:cover; display:block; }
  .visual-card .visual-slide-fallback{
    position:absolute; inset:0;
    background:
      radial-gradient(120% 120% at 20% 10%, rgba(139,92,246,0.55), transparent 55%),
      repeating-linear-gradient(115deg, rgba(255,255,255,0.06) 0 2px, transparent 2px 40px),
      linear-gradient(150deg,#1E0940,#0E0421 75%);
  }
  .visual-glow{ position:absolute; width:220px; height:220px; border-radius:50%; background:radial-gradient(circle, rgba(196,181,253,0.5), transparent 70%); top:20%; left:15%; filter:blur(6px); pointer-events:none; z-index:2; }
  .visual-arrow{
    position:absolute; top:50%; transform:translateY(-50%); width:38px; height:38px; border-radius:50%;
    background:rgba(255,255,255,0.16); border:1px solid rgba(255,255,255,0.28); color:#fff;
    display:flex; align-items:center; justify-content:center; font-size:15px; cursor:pointer; z-index:3;
  }
  .visual-arrow.left{ left:-18px; } .visual-arrow.right{ right:-18px; }

  .search-card{
    background:#fff; border-radius:22px; box-shadow:var(--shadow-card); padding:22px 24px;
    display:grid; grid-template-columns:1fr; gap:14px;
  }
  .search-tabs{ display:flex; gap:22px; border-bottom:1px solid var(--line); }
  .search-tabs a, .search-tabs span{
    font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; color:var(--ink-soft);
    padding-bottom:10px; position:relative; cursor:pointer;
  }
  .search-tabs .active{ color:var(--violet-700); }
  .search-tabs .active::after{
    content:""; position:absolute; left:0; right:0; bottom:-1px; height:2px;
    background:var(--grad-pill); border-radius:2px;
  }
  .search-fields{ display:grid; grid-template-columns:1.3fr 1fr 1fr 1fr auto; gap:10px; align-items:end; }
  .field label{ display:block; font-size:10.5px; font-weight:700; color:var(--ink-soft); text-transform:uppercase; letter-spacing:.04em; margin-bottom:6px; }
  .field input, .field select{
    width:100%; border:1px solid var(--line); border-radius:12px; padding:11px 12px; font-size:13px;
    font-family:'Inter',sans-serif; color:var(--ink); outline:none; background:#fff;
  }
  .search-btn{
    background:var(--grad-pill); color:#fff; border:none; font-weight:700; font-size:13px;
    padding:12px 22px; border-radius:12px; cursor:pointer; white-space:nowrap;
  }

  .lift{ margin-top:-150px; position:relative; z-index:3; }

  .section{ padding:64px 0; }
  .sec-headrow{ display:flex; justify-content:space-between; align-items:center; margin-bottom:26px; gap:16px; flex-wrap:wrap; }
  .sec-headrow h2{ font-size:21px; }
  .sec-headrow a{ font-size:12.5px; font-weight:700; color:var(--violet-700); }

  .cat-grid{ display:flex; gap:16px; flex-wrap:wrap; }
  .cat-tile{
    background:#fff; border:1px solid var(--line); border-radius:18px; padding:20px 26px; text-align:center;
    box-shadow:var(--shadow-card); min-width:120px; transition:border-color .2s;
  }
  .cat-tile:hover{ border-color:var(--violet-300); }
  .cat-tile .icn{ width:40px; height:40px; border-radius:12px; background:var(--lavender-100); color:var(--violet-700); display:flex; align-items:center; justify-content:center; font-size:18px; margin:0 auto 10px; overflow:hidden; }
  .cat-tile .icn img{ width:28px; height:28px; object-fit:contain; }
  .cat-tile span{ font-size:12.5px; font-weight:700; display:block; }

  .trend-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:20px; }
  .event-card{
    display:flex; flex-direction:column; background:#fff; border:1px solid var(--line);
    border-radius:20px; overflow:hidden; box-shadow:var(--shadow-card);
  }
  .event-img{
    position:relative; height:140px; background:#1E0940;
  }
  .event-img img{ width:100%; height:100%; object-fit:cover; display:block; }
  .event-img-fallback{
    width:100%; height:100%;
    background:
      radial-gradient(120% 120% at 15% 10%, rgba(139,92,246,0.5), transparent 55%),
      repeating-linear-gradient(115deg, rgba(255,255,255,0.06) 0 2px, transparent 2px 40px),
      linear-gradient(150deg,#1E0940,#0E0421 75%);
  }
  .live-badge{
    position:absolute; top:12px; left:12px; background:#EF4444; color:#fff; font-size:9.5px; font-weight:800;
    padding:5px 9px; border-radius:999px; display:flex; align-items:center; gap:5px; letter-spacing:.03em;
  }
  .live-badge .dot{ width:6px; height:6px; border-radius:50%; background:#fff; }
  .event-body{ padding:18px 18px 20px; display:flex; flex-direction:column; gap:8px; flex:1; }
  .event-body h3{ font-size:14.5px; line-height:1.3; }
  .event-body .meta{ display:flex; flex-direction:column; gap:5px; }
  .event-body .meta span{ font-size:11.5px; color:var(--ink-soft); font-weight:600; display:flex; align-items:center; gap:6px; }
  .event-body .price-row{ display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:6px; gap:8px; }
  .event-body .price{ font-size:16px; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; }
  .event-body .price small{ font-size:10.5px; color:var(--ink-soft); font-weight:600; }
  .view-btn{
    background:var(--grad-pill); color:#fff; border:none; font-weight:700; font-size:11.5px;
    padding:9px 16px; border-radius:999px; cursor:pointer; white-space:nowrap;
  }

  .split-grid{ display:grid; grid-template-columns:1.15fr 0.85fr; gap:22px; align-items:start; }
  .steps{ display:flex; flex-direction:column; gap:16px; }
  .step-row{ display:flex; gap:16px; align-items:flex-start; }
  .step-row .num{
    width:34px; height:34px; border-radius:10px; background:var(--grad-pill); color:#fff; font-weight:800;
    font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; display:flex; align-items:center; justify-content:center; flex:none;
  }
  .step-row h5{ font-size:14.5px; margin-bottom:3px; }
  .step-row p{ font-size:12.5px; color:var(--ink-soft); line-height:1.55; }

  .icard{ background:#fff; border:1px solid var(--line); border-radius:22px; padding:24px; box-shadow:var(--shadow-card); }
  .icard h3{ font-size:15px; margin-bottom:6px; }
  .ticket-event{ font-size:12.5px; color:var(--ink-soft); font-weight:600; margin-bottom:16px; }
  .slot-list{ display:flex; flex-direction:column; gap:10px; margin-bottom:16px; }
  .slot-row{ display:flex; justify-content:space-between; align-items:center; padding:11px 14px; border:1px solid var(--line); border-radius:12px; gap:12px; }
  .slot-row .l{ font-size:12.5px; font-weight:700; }
  .slot-row .p{ font-size:12px; color:var(--ink-soft); font-weight:600; }
  .slot-row .tag{ background:var(--lavender-100); color:var(--violet-700); font-size:10.5px; font-weight:700; padding:4px 10px; border-radius:999px; white-space:nowrap; }
  .book-btn{
    display:block; width:100%; padding:13px; border-radius:999px; background:var(--grad-pill); color:#fff;
    font-weight:700; font-size:13.5px; border:none; cursor:pointer; text-align:center;
  }

  .empty-state{
    border:1px dashed var(--line); border-radius:18px; background:var(--lavender-50);
    padding:32px 24px; text-align:center;
  }
  .empty-state p{ font-size:14px; font-weight:700; color:var(--ink); }
  .empty-state span{ display:block; margin-top:8px; font-size:12.5px; color:var(--ink-soft); font-weight:600; }

  footer{ background:var(--ink); color:#B7B2CE; padding:34px 0 22px; }
  .footer-inner{ display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; }
  .foot-links{ display:flex; gap:24px; font-size:12.5px; font-weight:600; flex-wrap:wrap; }
  .foot-links a:hover{ color:#fff; }
  .footer-brand .brand-title{ color:#fff; }
  .footer-brand .brand-subtitle{ color:#B7B2CE; }

  @media (max-width:980px){
    .hero-grid, .split-grid{ grid-template-columns:1fr; }
    .search-fields{ grid-template-columns:1fr 1fr; }
    .nav-links, .nav-actions .get-started-desktop{ display:none; }
    .menu-btn{ display:inline-flex; }
    .hero-copy h1{ font-size:30px; }
    .lift{ margin-top:-90px; }
    .hero{ padding-bottom:160px; }
    .visual-arrow.left{ left:8px; } .visual-arrow.right{ right:8px; }
  }
  @media (max-width:600px){
    .search-fields{ grid-template-columns:1fr; }
    .search-btn{ width:100%; }
    .container{ padding:0 20px; }
    .hero-inner{ padding:0 20px; }
  }
</style>
