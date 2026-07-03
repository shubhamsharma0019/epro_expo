<style>
/* Visitor portal + dashboard mobile polish — preserves desktop layout */
html, body { max-width: 100%; overflow-x: hidden; }
.shell, .portal-stack, .main, .rail, .listing-card, .layout-card, .ticket-grid { min-width: 0; }
img, svg, video { max-width: 100%; height: auto; }

@media (max-width: 768px) {
  .tabbar { gap: 8px; }
  .tab { flex: 1 1 auto; justify-content: center; padding: 10px 12px; font-size: 12.5px; min-height: 44px; }
  .mrow {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    padding: 14px 12px;
  }
  .mrow .btn,
  .mrow .pill { width: 100%; justify-content: center; margin-left: 0; }
  .minfo h3 { font-size: 14px; }
  .profile-grid { grid-template-columns: 1fr; }
  .form-card { padding: 18px; }
  .form-card h2 { font-size: 20px; }
  .field-grid { grid-template-columns: 1fr; }
  .save-btn { width: 100%; }
  .hall-grid { grid-template-columns: repeat(4, minmax(44px, 1fr)); gap: 6px; }
  .booth { min-height: 48px; font-size: 12px; }
  .legend-row { padding: 12px 14px; }
  .browse-row .right { width: 100%; }
  .shell--dashboard .rail { display: flex; flex-direction: column; gap: 14px; }
  .ring-card { padding: 20px 16px; }
  .ticket-hero { padding: 22px 18px; }
  .ticket-hero h1 { font-size: 22px; }
  .side-card { padding: 16px; }
  .action-btn { min-height: 44px; }
}

@media (max-width: 640px) {
  .ticket-meta { grid-template-columns: 1fr 1fr; }
  .ticket-qr img { width: min(220px, 100%); height: auto; }
  .hall-grid { grid-template-columns: repeat(4, minmax(40px, 1fr)); }
  .logout-card { padding: 36px 24px; border-radius: 20px; }
}

@media (max-width: 480px) {
  .ticket-meta { grid-template-columns: 1fr; }
  .hall-grid { grid-template-columns: repeat(3, minmax(40px, 1fr)); }
  .booth.wide { grid-column: span 1; }
  .ticket-hero h1 { font-size: 20px; }
}

/* Booth hub mobile section shortcuts */
.hub-mobile-nav {
  display: none;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 4px;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.hub-mobile-nav::-webkit-scrollbar { display: none; }
.hub-mobile-nav a,
.hub-mobile-nav button {
  flex: 0 0 auto;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 14px;
  border-radius: 999px;
  border: 1px solid #e2e8f0;
  background: #fff;
  color: #475569;
  font-size: 12.5px;
  font-weight: 700;
  white-space: nowrap;
  text-decoration: none;
  min-height: 44px;
  cursor: pointer;
  font-family: inherit;
}
.hub-mobile-nav a:hover,
.hub-mobile-nav button:hover { border-color: #4c33c3; color: #4c33c3; }
@media (max-width: 1279px) {
  .hub-mobile-nav { display: flex; }
}
</style>
