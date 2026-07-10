<style>
.ticket-grid{display:grid; gap:16px; grid-template-columns:minmax(0,1fr); align-items:start;}
@media(min-width:1100px){.ticket-grid{grid-template-columns:minmax(0,1fr) 320px;}}
.ticket-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  overflow:hidden; box-shadow:var(--shadow);
}
.ticket-card-inner{display:grid; grid-template-columns:1fr; min-width:0;}
@media(min-width:900px){.ticket-card-inner{grid-template-columns:minmax(0,1fr) 260px;}}
.ticket-hero{background:var(--grad); color:#fff; padding:28px 30px; min-width:0;}
.ticket-hero .tag{
  display:inline-flex; padding:6px 12px; border-radius:999px;
  background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.28);
  font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
}
.ticket-hero h1{font-size:28px; font-weight:800; margin-top:18px; line-height:1.2; overflow-wrap:anywhere;}
.ticket-hero p{font-size:13px; opacity:.9; margin-top:10px; max-width:620px; overflow-wrap:anywhere;}
.ticket-meta{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:10px; margin-top:22px;}
.ticket-meta .box{
  background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18);
  border-radius:12px; padding:12px;
}
.ticket-meta .box span{display:block; font-size:11px; opacity:.75;}
.ticket-meta .box strong{display:block; margin-top:4px; font-size:13px; font-weight:700; overflow-wrap:anywhere;}
.ticket-qr{
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  padding:24px; text-align:center; background:#F8FAFF; border-top:1px dashed var(--line);
}
@media(min-width:900px){.ticket-qr{border-top:none; border-left:1px dashed var(--line);}}
.ticket-qr img{width:min(220px,70vw); height:auto; aspect-ratio:1; object-fit:contain;}
.ticket-qr .tid{font-size:12px; color:var(--muted); margin-top:14px; font-weight:600;}
.ticket-qr .tid strong{display:block; color:var(--ink); font-size:15px; margin-top:4px;}
.ticket-qr .ready{
  margin-top:12px; display:inline-flex; padding:6px 12px; border-radius:999px;
  background:#E9FAF1; color:#1D9E75; font-size:12px; font-weight:700;
}
.side-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:20px; box-shadow:var(--shadow);
}
.side-card h2{font-size:15px; font-weight:800; margin-bottom:14px;}
.attendee{display:flex; align-items:center; gap:12px; margin-bottom:16px;}
.attendee .av{
  width:48px; height:48px; border-radius:14px; background:var(--grad-soft); color:var(--violet);
  display:flex; align-items:center; justify-content:center; font-weight:800;
}
.attendee p{font-size:14px; font-weight:700;}
.attendee span{font-size:12px; color:var(--muted); word-break:break-all;}
.detail-row{
  display:flex; justify-content:space-between; gap:12px; padding:9px 0;
  border-top:1px solid var(--line); font-size:13px;
}
.detail-row:first-of-type{border-top:none;}
.detail-row span{color:var(--muted);}
.detail-row strong{color:var(--ink); font-weight:700; text-align:right; overflow-wrap:anywhere;}
.detail-row strong.is-positive{color:#1D9E75;}
.detail-row strong.is-neutral{color:#5f6b85;}
.action-btn{
  width:100%; margin-top:10px; display:inline-flex; align-items:center; justify-content:center; gap:8px;
  padding:12px 16px; border-radius:11px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none;
}
.action-btn.primary{background:var(--grad); color:#fff; border:none; box-shadow:var(--shadow);}
.action-btn.secondary{background:#fff; color:var(--ink); border:1px solid var(--line);}
@media print{
  @page{size:A4 portrait; margin:10mm;}
  *{-webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;}
  html,body{width:100%; margin:0 !important; padding:0 !important; background:#fff !important;}
  .sidebar,.mobile-topbar,.side-actions,.back-link,.welcome-banner{display:none !important;}
  .shell,.shell--passes{display:block !important; grid-template-columns:1fr !important; min-height:auto !important; background:#fff !important;}
  .portal-stack,.main{display:block !important; width:100% !important; max-width:none !important; margin:0 !important; padding:0 !important;}
  .ticket-grid{display:block !important; width:100% !important;}
  .ticket-card{width:100% !important; max-width:180mm !important; margin:0 auto !important; box-shadow:none !important; border:1px solid #E5E7EF !important; break-inside:avoid; page-break-inside:avoid;}
  .ticket-card-inner{grid-template-columns:minmax(0,1fr) 62mm !important;}
  .ticket-hero{padding:14mm 10mm !important; color:#fff !important;}
  .ticket-hero h1{font-size:22pt !important; line-height:1.18 !important;}
  .ticket-meta{grid-template-columns:repeat(2,minmax(0,1fr)) !important;}
  .ticket-meta .box.wide{grid-column:1 / -1;}
  .ticket-qr{border-top:0 !important; border-left:1px dashed #E5E7EF !important; padding:10mm 7mm !important;}
  .ticket-qr img{width:46mm !important; max-width:46mm !important;}
}
@media(max-width:768px){
  .ticket-grid{gap:14px;}
  .ticket-meta{grid-template-columns:repeat(2,minmax(0,1fr));}
  .ticket-hero{padding:22px 18px;}
  .ticket-hero h1{font-size:22px;}
}
@media(max-width:480px){
  .ticket-card{border-radius:16px;}
  .ticket-meta{grid-template-columns:1fr;}
  .ticket-hero h1{font-size:20px;}
}
</style>
