<style>
  .home-brand{
    display:flex; align-items:center; gap:12px;
    min-width:0; text-decoration:none; color:inherit;
  }
  .home-brand__mark{
    flex:none;
    display:flex; align-items:center; justify-content:center;
    font-weight:700; line-height:1; color:#fff;
    background:linear-gradient(135deg, #071044 0%, #5b2eff 100%);
    box-shadow:0 14px 30px rgba(7,16,68,0.18);
  }
  .home-brand__copy{ min-width:0; line-height:1; }
  .home-brand__title{
    display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
    font-weight:800; letter-spacing:-0.035em; color:#071044;
  }
  .home-brand__accent{ color:#246BFF; }
  .home-brand__subtitle{
    display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
    margin-top:4px; font-weight:800; text-transform:uppercase;
    letter-spacing:0.16em; color:#8A94AD;
  }

  .home-brand--header .home-brand__mark{
    width:44px; height:44px; border-radius:16px; font-size:20px;
  }
  .home-brand--header .home-brand__title{ font-size:24px; }
  .home-brand--header .home-brand__subtitle{ font-size:10px; }

  .home-brand--footer .home-brand__mark{
    width:40px; height:40px; border-radius:14px; font-size:19px;
  }
  .home-brand--footer .home-brand__title{ font-size:23px; }
  .home-brand--footer .home-brand__subtitle{ font-size:10px; }

  .footer-brand-shell{
    display:inline-flex; background:#fff; border-radius:16px;
    padding:8px 12px;
  }

  @media (min-width:640px){
    .home-brand--header .home-brand__mark{
      width:54px; height:54px; border-radius:18px; font-size:24px;
    }
    .home-brand--header .home-brand__title{ font-size:30px; }
    .home-brand--header .home-brand__subtitle{ font-size:12px; }
  }
</style>
