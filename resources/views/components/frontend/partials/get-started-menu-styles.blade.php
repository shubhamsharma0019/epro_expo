<style>
  [data-get-started-root] { position: relative; }

  [data-get-started-chevron] {
    transition: transform 0.2s;
  }

  [data-get-started-chevron].rotate-180 {
    transform: rotate(180deg);
  }

  [data-get-started-panel] {
    position: absolute;
    right: 0;
    top: calc(100% + 10px);
    z-index: 120;
    width: 420px;
    max-width: min(420px, calc(100vw - 32px));
    box-sizing: border-box;
    background: #fff;
    border: 1px solid #E7EAF3;
    border-radius: 16px;
    padding: 12px;
    box-shadow: 0 16px 40px rgba(7, 16, 68, 0.12);
  }

  [data-get-started-panel].hidden { display: none !important; }

  [data-get-started-panel] .gs-menu-grid {
    display: grid !important;
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    gap: 12px;
    width: 100%;
    min-width: 0;
  }

  [data-get-started-panel] .gs-menu-link {
    display: flex !important;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
    padding: 16px 14px;
    border: 1px solid #D8DCEB;
    border-radius: 12px;
    background: #fff;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
    color: #071044;
    text-align: center;
    text-decoration: none;
    white-space: normal;
    box-shadow: 0 1px 2px rgba(7, 16, 68, 0.04);
    transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
  }

  [data-get-started-panel] .gs-menu-link i {
    flex-shrink: 0;
    width: 1.25rem;
    font-size: 1.125rem;
    line-height: 1;
    text-align: center;
  }

  [data-get-started-panel] .gs-menu-link--wide {
    grid-column: 1 / -1;
  }

  [data-get-started-panel] .gs-menu-link:hover {
    border-color: transparent;
    background: linear-gradient(to right, #6D28D9, #4B16D8);
    color: #fff;
    box-shadow: 0 14px 30px rgba(91, 46, 255, 0.28);
  }

  [data-get-started-panel] .gs-menu-link:hover i {
    color: #fff !important;
  }
</style>
