<style>
  .site-navbar{
    position:static;
    background:#fff;
    border-bottom:1px solid #EEF0F7;
  }
  .site-navbar__inner{
    max-width:1440px;
    margin:0 auto;
    padding:16px 16px;
    display:grid;
    grid-template-columns:1fr auto 1fr;
    align-items:center;
    gap:16px;
  }
  .site-navbar .home-brand{ justify-self:start; min-width:0; }
  .site-navbar__links{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:40px;
    justify-self:center;
    font-size:14px;
    font-weight:600;
    color:#071044;
  }
  .site-navbar__links a{
    white-space:nowrap;
    transition:color .2s;
    text-decoration:none;
    color:inherit;
  }
  .site-navbar__links a:hover,
  .site-navbar__links a.is-active{ color:#5726E8; }
  .site-navbar__actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px;
    justify-self:end;
  }
  .site-navbar__login{
    display:inline-flex;
    align-items:center;
    padding:10px 16px;
    border-radius:8px;
    border:1px solid #D8DCEB;
    font-size:14px;
    font-weight:700;
    color:#071044;
    text-decoration:none;
    white-space:nowrap;
    transition:color .2s, border-color .2s, background .2s;
  }
  .site-navbar__login:hover{
    color:#5726E8;
    border-color:#C4B5FD;
    background:#F6F3FF;
  }
  .site-navbar__get-started{ position:relative; }
  .site-navbar__get-started [data-get-started-root]{ position:relative; }
  .site-navbar__get-started [data-get-started-toggle]{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:linear-gradient(to right, #6D28D9, #4B16D8);
    color:#fff;
    font-weight:700;
    font-size:14px;
    padding:12px 24px;
    border-radius:8px;
    border:none;
    cursor:pointer;
    font-family:'Inter',sans-serif;
    line-height:1;
    white-space:nowrap;
    box-shadow:0 12px 24px rgba(91,46,255,0.26);
  }
  .site-navbar__get-started [data-get-started-toggle]:hover{ opacity:.95; }
  .site-navbar__get-started [data-get-started-chevron]{
    font-size:11px;
    opacity:.9;
    transition:transform .2s;
  }
  .site-navbar__get-started [data-get-started-chevron].rotate-180{ transform:rotate(180deg); }
  .site-navbar__menu-btn{
    display:none;
    width:44px;
    height:44px;
    border-radius:12px;
    border:1px solid #E0E4EF;
    background:#fff;
    color:#071044;
    font-size:18px;
    cursor:pointer;
    align-items:center;
    justify-content:center;
    flex:none;
  }
  .site-navbar__mobile{
    display:none;
    max-width:1440px;
    margin:0 auto;
    padding:0 16px 20px;
    border-top:1px solid #EEF0F7;
  }
  .site-navbar__mobile.open{ display:block; }
  .site-navbar__mobile a{
    display:block;
    padding:10px 0;
    font-weight:600;
    font-size:15px;
    color:#071044;
    text-decoration:none;
  }
  .site-navbar__mobile a:hover,
  .site-navbar__mobile a.is-active{ color:#5726E8; }
  .site-navbar__get-started-mobile{ margin-top:12px; }
  .site-navbar__get-started-mobile > div{
    display:grid;
    grid-template-columns:1fr;
    gap:10px;
    padding-top:8px;
  }
  .site-navbar__get-started-mobile a{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:12px 14px;
    border:1px solid #D8DCEB;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    color:#071044;
    text-decoration:none;
  }
  .site-navbar__get-started-mobile a:hover{
    border-color:#5726E8;
    color:#5726E8;
  }

  @media (min-width:640px){
    .site-navbar__inner{ padding:16px 24px; }
    .site-navbar__mobile{ padding-left:24px; padding-right:24px; }
  }
  @media (min-width:1024px){
    .site-navbar__inner{ padding:20px 32px; }
    .site-navbar__mobile{ padding-left:32px; padding-right:32px; }
  }
  @media (max-width:1023px){
    .site-navbar__inner{ grid-template-columns:1fr auto; }
    .site-navbar__links,
    .site-navbar__actions .site-navbar__get-started,
    .site-navbar__actions .site-navbar__login{ display:none; }
    .site-navbar__menu-btn{ display:inline-flex; }
  }
  @media (min-width:420px) and (max-width:1023px){
    .site-navbar__get-started-mobile > div{ grid-template-columns:1fr 1fr; }
  }
</style>
