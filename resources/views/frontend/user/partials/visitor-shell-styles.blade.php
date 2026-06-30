<style>
:root{
  --ink:#1A1530;
  --ink-soft:#5B5570;
  --muted:#8A84A0;
  --ivory:#FBFAF7;
  --card:#FFFFFF;
  --line:#ECEAF5;
  --indigo:#4F2DC8;
  --violet:#8B2FD6;
  --magenta:#E0359E;
  --grad: linear-gradient(115deg, var(--indigo) 0%, var(--violet) 50%, var(--magenta) 100%);
  --grad-soft: linear-gradient(115deg, rgba(79,45,200,.07) 0%, rgba(139,47,214,.07) 50%, rgba(224,53,158,.07) 100%);
  --navy:#161038;
  --radius:16px;
  --shadow:0 10px 26px -14px rgba(40,20,90,.18);
}
*{box-sizing:border-box; margin:0; padding:0;}
body{
  font-family:'Inter',sans-serif;
  color:var(--ink);
  background:
    radial-gradient(circle at 0% 0%, rgba(79,45,200,.07), transparent 40%),
    radial-gradient(circle at 100% 0%, rgba(224,53,158,.06), transparent 40%),
    var(--ivory);
  min-height:100vh;
  padding:14px 16px;
}
body.sidebar-open{overflow:hidden;}
h1,h2,h3,.display{font-family:'Plus Jakarta Sans',sans-serif; letter-spacing:-0.01em;}
.shell{
  display:grid;
  gap:16px;
  width:100%;
  margin:0;
  align-items:stretch;
  position:relative;
}
.shell--dashboard{grid-template-columns:230px minmax(0,1fr) 250px;}
.shell--passes{grid-template-columns:230px minmax(0,1fr);}
.portal-stack{min-width:0;}

/* Desktop: main + rail behave as direct shell columns again */
@media(min-width:1101px){
  .shell--dashboard .portal-stack,
  .shell--passes .portal-stack{display:contents;}
}

/* Tablet: sidebar + stacked content */
@media(max-width:1100px) and (min-width:981px){
  .shell--dashboard{grid-template-columns:230px minmax(0,1fr);}
  .shell--dashboard .portal-stack{
    display:flex;
    flex-direction:column;
    gap:16px;
    grid-column:2;
    min-width:0;
  }
  .shell--dashboard .rail{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:14px;
  }
}

.sidebar-overlay{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(22,16,56,.48);
  z-index:999;
  backdrop-filter:blur(2px);
}
.sidebar-overlay.is-open{display:block;}

.mobile-topbar{
  display:none;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  background:var(--card);
  border:1px solid var(--line);
  border-radius:14px;
  padding:10px 12px;
  box-shadow:var(--shadow);
}
.mobile-topbar .mobile-brand{
  display:flex;
  align-items:center;
  gap:8px;
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:800;
  font-size:14px;
  color:var(--ink);
}
.mobile-topbar .mobile-brand .mark{
  width:28px; height:28px; border-radius:8px; background:var(--grad);
  display:flex; align-items:center; justify-content:center;
  color:#fff; font-size:12px;
}
.menu-toggle,
.sidebar-close{
  width:38px; height:38px; border-radius:10px;
  border:1px solid var(--line); background:#fff; color:var(--ink);
  display:inline-flex; align-items:center; justify-content:center;
  cursor:pointer; flex-shrink:0;
}
.menu-toggle:hover,
.sidebar-close:hover{background:var(--grad-soft); color:var(--violet);}

.sidebar{
  background:var(--navy);
  border-radius:20px;
  padding:22px 16px;
  display:flex;
  flex-direction:column;
  min-height:calc(100vh - 28px);
  position:relative;
  overflow:hidden;
}
.sidebar::after{
  content:""; position:absolute; width:220px; height:220px; border-radius:50%;
  background:var(--grad); opacity:.28; filter:blur(50px); top:-70px; left:-70px;
}
.sidebar-close{display:none; position:relative; z-index:2; margin:0 6px 10px auto;}
.brand{display:flex; align-items:center; gap:10px; padding:0 6px 26px; position:relative; z-index:1; flex-shrink:0;}
.brand .mark{
  width:30px; height:30px; border-radius:9px; background:var(--grad);
  display:flex; align-items:center; justify-content:center;
  color:#fff; font-weight:800; font-size:14px; font-family:'Plus Jakarta Sans';
}
.brand span{font-weight:700; font-size:15px; color:#fff;}
.brand span.expo{
  background:var(--grad); -webkit-background-clip:text; background-clip:text; color:transparent;
}
.nav{
  display:flex;
  flex-direction:column;
  gap:3px;
  position:relative;
  z-index:1;
  flex:1;
  overflow-y:auto;
}
.nav form{width:100%; margin:0;}
.nav a,
.nav .logout-btn{
  display:flex;
  align-items:center;
  gap:11px;
  padding:11px 14px;
  border-radius:11px;
  color:#B8B2D8;
  font-size:13.5px;
  font-weight:600;
  line-height:1.2;
  transition:.15s;
  text-decoration:none;
  width:100%;
  border:none;
  background:transparent;
  cursor:pointer;
  font-family:inherit;
  text-align:left;
}
.nav .ico{width:17px; height:17px; flex-shrink:0; opacity:.85; display:block;}
.nav a:hover,
.nav .logout-btn:hover{background:rgba(255,255,255,.06); color:#fff;}
.nav a.active{
  background:var(--grad);
  color:#fff;
  box-shadow:0 8px 18px -8px rgba(139,47,214,.6);
}
.sidebar .userid{
  margin-top:16px;
  flex-shrink:0;
  background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.1);
  border-radius:12px;
  padding:12px 14px;
  display:flex;
  align-items:center;
  gap:10px;
  position:relative;
  z-index:1;
}
.userid .avatar{
  width:30px; height:30px; border-radius:50%; background:var(--grad);
  display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; font-weight:700; flex-shrink:0;
}
.userid div p{font-size:12.5px; font-weight:700; color:#fff; line-height:1.3;}
.userid div span{font-size:11px; color:#9A93BE;}

.main{display:flex; flex-direction:column; gap:18px; min-width:0;}
.welcome-banner{
  background:var(--grad);
  border-radius:var(--radius);
  padding:26px 30px;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:16px;
  box-shadow:var(--shadow);
}
.welcome-banner > div:first-child{min-width:0;}
.welcome-banner h1{font-size:22px; font-weight:800;}
.welcome-banner p{font-size:13px; opacity:.9; margin-top:4px; font-weight:500;}
.welcome-banner .pill{
  background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.3);
  border-radius:999px; padding:8px 16px; font-size:12.5px; font-weight:700;
  display:flex; align-items:center; gap:7px; flex-shrink:0; white-space:nowrap;
}
.welcome-banner .pill .dot{width:7px; height:7px; border-radius:50%; background:#fff;}

/* Shared portal components (passes, halls, dashboard lists) */
.action-bar{display:flex; align-items:center; gap:10px; flex-wrap:wrap;}
.book-btn{
  background:var(--card); border:1px solid var(--line); color:var(--ink);
  font-size:13px; font-weight:700; padding:10px 18px; border-radius:999px;
  cursor:pointer; box-shadow:var(--shadow); display:inline-flex; align-items:center; gap:7px;
  text-decoration:none; justify-content:center;
}
.book-btn:hover{background:var(--grad-soft);}
.action-bar .book-btn{justify-content:flex-start;}
.toggle-row{
  display:flex; gap:0; background:#fff; width:fit-content; border-radius:999px;
  padding:4px; border:1px solid var(--line);
}
.toggle-row button{
  border:none; background:transparent; font-size:13px; font-weight:700; color:var(--ink-soft);
  padding:9px 20px; border-radius:999px; cursor:pointer; white-space:nowrap;
}
.toggle-row button.active{background:var(--grad); color:#fff; box-shadow:0 8px 18px -8px rgba(139,47,214,.5);}
.sub-toggle-row{
  display:flex; gap:0; background:#F7F6FC; width:fit-content; border-radius:999px;
  padding:4px; margin-bottom:20px;
}
.sub-toggle-row button{
  border:none; background:transparent; font-size:12.5px; font-weight:700; color:var(--ink-soft);
  padding:8px 18px; border-radius:999px; cursor:pointer;
}
.sub-toggle-row button.active{background:var(--grad); color:#fff;}
.listing-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:22px;
}
.pass-row{
  display:flex; align-items:center; gap:16px;
  background:var(--card); border:1px solid var(--line); border-radius:14px;
  padding:16px 18px; margin-bottom:12px; transition:.15s;
}
.pass-row:last-child{margin-bottom:0;}
.pass-row:hover{box-shadow:var(--shadow); border-color:transparent;}
.pass-row .ic{
  width:44px; height:44px; border-radius:12px; flex-shrink:0;
  background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center;
}
.pass-row .body{flex:1; min-width:0;}
.pass-row .body .top-line{display:flex; align-items:center; gap:9px; margin-bottom:4px; flex-wrap:wrap;}
.pass-row .badge{
  font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
  padding:3.5px 9px; border-radius:7px; flex-shrink:0;
}
.badge.upcoming{background:var(--grad-soft); color:var(--violet);}
.badge.live{background:#FDE8F3; color:#C21F86;}
.badge.completed{background:#EDEAFB; color:#5B5570;}
.pass-row .body h4{font-size:14px; font-weight:700; color:var(--ink);}
.pass-row .body .meta-line{font-size:12px; color:var(--muted); display:flex; gap:14px; flex-wrap:wrap;}
.pass-row .right{display:flex; align-items:center; gap:10px; flex-shrink:0;}
.explore-btn,
.status-confirmed{font-size:12px; font-weight:700;}
.explore-btn{
  background:var(--grad); color:#fff; font-size:12.5px;
  border:none; padding:9px 20px; border-radius:999px; cursor:pointer;
  box-shadow:0 8px 18px -8px rgba(139,47,214,.5);
  display:inline-flex; align-items:center; gap:6px; text-decoration:none;
}
.explore-btn:hover{filter:brightness(1.05);}
.status-confirmed{color:#1D9E75; display:flex; align-items:center; gap:5px;}
.icon-btn{
  width:34px; height:34px; border-radius:9px; border:1px solid var(--line); background:#fff;
  color:var(--ink-soft); display:flex; align-items:center; justify-content:center; cursor:pointer;
  text-decoration:none;
}
.icon-btn:hover{background:var(--grad-soft); color:var(--violet); border-color:transparent;}
.back-link{
  display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:700;
  color:var(--ink-soft); text-decoration:none;
}
.back-link:hover{color:var(--violet);}

@media(max-width:980px){
  body{padding:10px 12px;}
  .shell--dashboard,
  .shell--passes{grid-template-columns:1fr; gap:12px;}
  .shell--dashboard .portal-stack,
  .shell--passes .portal-stack{
    display:flex;
    flex-direction:column;
    gap:12px;
    min-width:0;
  }
  .mobile-topbar{display:flex;}
  .sidebar-close{display:inline-flex;}

  .sidebar{
    position:fixed;
    top:0; left:0; bottom:0;
    width:min(290px, 88vw);
    z-index:1000;
    min-height:100vh;
    border-radius:0 18px 18px 0;
    transform:translateX(-110%);
    transition:transform .25s ease;
    padding-top:16px;
    box-shadow:0 20px 50px rgba(22,16,56,.35);
  }
  .sidebar.is-open{transform:translateX(0);}

  .shell--dashboard .rail{grid-template-columns:1fr;}
  .welcome-banner{flex-direction:column; align-items:flex-start; padding:20px 18px;}
  .welcome-banner .pill{white-space:normal;}
  .main{gap:14px;}
}

@media(max-width:768px){
  .action-bar{flex-direction:column; align-items:stretch;}
  .action-bar .book-btn{width:100%; justify-content:center;}
  .toggle-row,
  .sub-toggle-row{width:100%;}
  .toggle-row button,
  .sub-toggle-row button{flex:1; padding-left:10px; padding-right:10px;}

  .pass-row{
    flex-direction:column;
    align-items:stretch;
    gap:12px;
    padding:14px;
  }
  .pass-row .right{
    width:100%;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:8px;
  }
  .explore-btn{width:100%; justify-content:center;}

  .listing-card{padding:16px;}
  .welcome-banner h1{font-size:20px;}
  .welcome-banner p{font-size:12.5px;}
}

@media(max-width:640px){
  body{padding:8px 10px;}
  .welcome-banner h1{font-size:18px;}
  .welcome-banner .pill{font-size:11.5px; padding:7px 12px;}
  .mobile-topbar{padding:8px 10px;}
  .menu-toggle,
  .sidebar-close{width:36px; height:36px;}
}
</style>
