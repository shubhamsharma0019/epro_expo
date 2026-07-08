<style>
  .home-footer-wrap{
    width:100%;
    max-width:1440px;
    margin:0 auto;
    background:#071044;
    color:#fff;
    padding:24px 20px;
    box-sizing:border-box;
  }
  .home-footer-wrap__inner{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    text-align:center;
  }
  .home-footer-wrap__brand{
    display:inline-flex;
    align-items:center;
    border-radius:16px;
    background:#fff;
    padding:8px 12px;
    line-height:1;
  }
  .home-footer-logo{
    display:inline-flex;
    align-items:center;
    gap:12px;
    min-width:0;
    color:#071044;
    text-decoration:none;
  }
  .home-footer-logo__mark{
    display:flex;
    width:40px;
    height:40px;
    flex:0 0 auto;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    background:linear-gradient(135deg, #071044 0%, #5b2eff 100%);
    color:#fff;
    font-size:19px;
    font-weight:800;
    line-height:1;
    box-shadow:0 14px 30px rgba(7,16,68,0.18);
  }
  .home-footer-logo__text{
    display:block;
    min-width:0;
    line-height:1;
  }
  .home-footer-logo__title{
    display:block;
    color:#071044;
    font-size:23px;
    font-weight:900;
    letter-spacing:-0.03em;
    white-space:nowrap;
  }
  .home-footer-logo__title span{
    color:#246BFF;
  }
  .home-footer-logo__subtitle{
    display:block;
    margin-top:6px;
    color:#8A94AD;
    font-size:10px;
    font-weight:800;
    letter-spacing:0.16em;
    white-space:nowrap;
  }
  .home-footer-wrap__copyright{
    margin:0;
    font-size:13px;
    font-weight:500;
    color:rgba(255,255,255,0.7);
  }
  .home-footer-wrap__links{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:center;
    gap:12px 24px;
    font-size:13px;
    font-weight:500;
    color:rgba(255,255,255,0.8);
  }
  .home-footer-wrap__links a{
    color:inherit;
    text-decoration:none;
    transition:color .2s ease;
  }
  .home-footer-wrap__links a:hover{
    color:#fff;
  }
  .home-footer-wrap__social{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
  }
  .home-footer-wrap__social a{
    display:grid;
    place-items:center;
    width:36px;
    height:36px;
    border-radius:999px;
    background:rgba(255,255,255,0.15);
    color:#fff;
    font-size:14px;
    text-decoration:none;
    transition:background-color .2s ease;
  }
  .home-footer-wrap__social a:hover{
    background:#6D28D9;
  }
  @media (min-width:640px){
    .home-footer-wrap{
      padding:24px 32px;
    }
  }
  .marketing-footer-shell{
    width:100%;
    max-width:1440px;
    margin:0 auto;
  }
  .marketing-footer-shell--edge-to-edge{
    width:100vw;
    max-width:none;
    margin-left:calc(50% - 50vw);
    margin-right:calc(50% - 50vw);
  }
  .marketing-footer-shell--edge-to-edge .home-footer-wrap{
    max-width:none;
    margin:0;
  }
  @media (min-width:1024px){
    .home-footer-wrap{
      padding:24px 40px;
    }
    .home-footer-wrap__inner{
      flex-direction:row;
      text-align:left;
      gap:24px;
    }
    .home-footer-wrap__links{
      gap:12px 36px;
    }
  }
</style>

