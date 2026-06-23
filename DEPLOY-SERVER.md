# 24/7 Server Deploy (Railway — recommended)

Your laptop can be OFF. App runs on cloud server with MySQL database.

## Step 1 — Railway account

1. Open: https://railway.app/
2. Sign up with **GitHub** (free trial credit)

## Step 2 — New project from GitHub

1. Click **New Project**
2. Choose **Deploy from GitHub repo**
3. Select: **`shubhamsharma0019/epro_expo`**
4. Branch: **`main`**
5. Railway auto-detects `Dockerfile.production` via `railway.toml`

## Step 3 — Add MySQL database

1. In project → **+ New** → **Database** → **MySQL**
2. Click your **web service** → **Variables** → **Add Reference**
3. Add these from MySQL service:

| Variable | Reference |
|----------|-----------|
| `DB_HOST` | MySQL → MYSQLHOST |
| `DB_PORT` | MySQL → MYSQLPORT |
| `DB_DATABASE` | MySQL → MYSQLDATABASE |
| `DB_USERNAME` | MySQL → MYSQLUSER |
| `DB_PASSWORD` | MySQL → MYSQLPASSWORD |

4. Add manually:

```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
APP_SEED_BASE=false
```

5. **Generate domain:** Service → **Settings** → **Networking** → **Generate Domain**
6. Copy URL (e.g. `https://eproexpo-production.up.railway.app`) and set:

```
APP_URL=https://YOUR-RAILWAY-DOMAIN.up.railway.app
```

7. Click **Deploy** / wait for build to finish

## Step 4 — Import your local database (optional)

Export on PC:

```powershell
C:\xampp\mysql\bin\mysqldump.exe -u root erpoexpo > erpoexpo.sql
```

In Railway MySQL → **Connect** → use MySQL client or Railway CLI to import.

Or run seeders after deploy (empty DB + demo data):

```
APP_SEED_BASE=true
```

then redeploy once.

## Step 5 — Your live URL

Railway gives you a permanent link like:

```
https://eproexpo-production-xxxx.up.railway.app
```

Share this — works from anywhere, 24/7.

---

## Alternative: Render (also free tier)

1. https://dashboard.render.com/
2. **New** → **Blueprint** → connect GitHub repo
3. Render reads `render.yaml` and creates web + MySQL automatically

---

## Google Meet on production

Add in Railway/Render variables:

```
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REFRESH_TOKEN=...
```

Update Google OAuth redirect URI to your **live domain** (not localhost).

---

## Default logins (if seeded)

- Admin: `admin@example.com` / `password`
- Company: `company@example.com` / `password`

Change after going live.
