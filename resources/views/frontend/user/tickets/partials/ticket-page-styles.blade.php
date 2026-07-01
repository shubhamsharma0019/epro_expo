<style>
.ticket-grid{display:grid; gap:16px; grid-template-columns:minmax(0,1fr);}
@media(min-width:1100px){.ticket-grid{grid-template-columns:minmax(0,1fr) 320px;}}
.ticket-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  overflow:hidden; box-shadow:var(--shadow);
}
.ticket-card-inner{display:grid; grid-template-columns:1fr;}
@media(min-width:900px){.ticket-card-inner{grid-template-columns:minmax(0,1fr) 260px;}}
.ticket-hero{background:var(--grad); color:#fff; padding:28px 30px;}
.ticket-hero .tag{
  display:inline-flex; padding:6px 12px; border-radius:999px;
  background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.28);
  font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
}
.ticket-hero h1{font-size:28px; font-weight:800; margin-top:18px; line-height:1.2;}
.ticket-hero p{font-size:13px; opacity:.9; margin-top:10px; max-width:520px;}
.ticket-meta{display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:10px; margin-top:22px;}
.ticket-meta .box{
  background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18);
  border-radius:12px; padding:12px;
}
.ticket-meta .box span{display:block; font-size:11px; opacity:.75;}
.ticket-meta .box strong{display:block; margin-top:4px; font-size:13px; font-weight:700;}
.ticket-qr{
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  padding:24px; text-align:center; background:#F8FAFF; border-top:1px dashed var(--line);
}
@media(min-width:900px){.ticket-qr{border-top:none; border-left:1px dashed var(--line);}}
.ticket-qr img{width:220px; height:220px; object-fit:contain;}
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
.detail-row strong{color:var(--ink); font-weight:700;}
.action-btn{
  width:100%; margin-top:10px; display:inline-flex; align-items:center; justify-content:center; gap:8px;
  padding:12px 16px; border-radius:11px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none;
}
.action-btn.primary{background:var(--grad); color:#fff; border:none; box-shadow:var(--shadow);}
.action-btn.secondary{background:#fff; color:var(--ink); border:1px solid var(--line);}
@media print{
  body{padding:0; background:#fff;}
  .sidebar,.mobile-topbar,.side-actions,.back-link{display:none !important;}
  .shell,.shell--passes{grid-template-columns:1fr !important;}
  .portal-stack{display:block !important;}
}
@media(max-width:768px){
  .ticket-meta{grid-template-columns:1fr;}
}
</style>
