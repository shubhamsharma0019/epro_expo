import { chromium } from 'playwright';
import { mkdirSync } from 'fs';

const base = process.argv[2] || 'http://127.0.0.1:8000';
const outDir = 'storage/app/meeting-demo';
mkdirSync(outDir, { recursive: true });

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1366, height: 768 },
    permissions: ['microphone', 'camera'],
  });
  const page = await context.newPage();

  // 1) Company login
  await page.goto(`${base}/company/login`, { waitUntil: 'networkidle', timeout: 60000 });
  await page.fill('input[name="email"]', 'company@example.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button.btn');
  await page.waitForURL('**/company/**', { timeout: 60000 });
  await page.screenshot({ path: `${outDir}/01-company-dashboard.png` });

  // 2) Meeting details page
  await page.goto(`${base}/company/meetings/6`, { waitUntil: 'networkidle', timeout: 60000 });
  await page.screenshot({ path: `${outDir}/02-meeting-details.png`, fullPage: true });

  const joinLink = await page.locator('a:has-text("Join Video Meeting")').first().getAttribute('href')
    .catch(() => null);

  if (!joinLink) {
    console.log('ERROR=Join link not found on meeting page');
    await browser.close();
    process.exit(1);
  }

  console.log('JOIN_LINK=' + joinLink);

  // 3) Open video meeting in same tab
  await page.goto(joinLink, { waitUntil: 'domcontentloaded', timeout: 90000 });
  await page.waitForTimeout(4000);
  await page.screenshot({ path: `${outDir}/03-video-prejoin.png` });

  // 4) Enter name and join (Jitsi or Zoom web)
  const nameInput = page.locator('input[placeholder*="name" i], input[aria-label*="name" i], #inputname').first();
  if (await nameInput.count()) {
    await nameInput.fill('EproExpo Demo');
  }

  const joinBtn = page.locator('button:has-text("Join meeting"), button:has-text("Join Meeting"), button:has-text("Join")').first();
  if (await joinBtn.count()) {
    await joinBtn.click({ timeout: 10000 }).catch(() => {});
    await page.waitForTimeout(6000);
  }

  await page.screenshot({ path: `${outDir}/04-video-in-meeting.png` });
  console.log('TITLE=' + (await page.title()));
  console.log('URL=' + page.url());
  console.log('SCREENSHOTS=' + outDir);

  await browser.close();
})().catch((err) => {
  console.error('ERROR=' + err.message);
  process.exit(1);
});
