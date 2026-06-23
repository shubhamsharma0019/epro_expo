import { chromium } from 'playwright';

(async () => {
  const meetingUrl = process.argv[2] || 'https://meet.jit.si/EproExpo-6-5ae822d6';
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage({ viewport: { width: 1280, height: 720 } });
  await page.goto(meetingUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
  await page.waitForTimeout(5000);
  await page.screenshot({ path: 'storage/app/meeting-demo-screenshot.png', fullPage: false });
  const title = await page.title();
  console.log('TITLE=' + title);
  console.log('URL=' + page.url());
  console.log('SCREENSHOT=storage/app/meeting-demo-screenshot.png');
  await browser.close();
})().catch((err) => {
  console.error(err.message);
  process.exit(1);
});
