# EproExpo Deployment (with MySQL database)

This project can be deployed on any VPS with Docker (Ubuntu recommended).

## What you need

- A VPS (Hostinger VPS, DigitalOcean, AWS EC2, etc.)
- Domain pointed to the server IP (optional but recommended)
- SSH access to the server

## Step 1 — Export your local database (on your PC)

```powershell
cd "path\to\erpoexpo"
C:\xampp\mysql\bin\mysqldump.exe -u root --databases erpoexpo > database\backups\erpoexpo_dump.sql
```

Copy `database/backups/erpoexpo_dump.sql` to the server (or commit it if small enough).

MySQL auto-imports any `.sql` file in `database/backups/` on first container start.

## Step 2 — Server setup (Ubuntu)

```bash
sudo apt update && sudo apt install -y docker.io docker-compose-plugin git
sudo usermod -aG docker $USER
newgrp docker
```

## Step 3 — Clone and configure

```bash
git clone https://github.com/shubhamsharma0019/epro_expo.git
cd epro_expo
cp deploy/env.production.example .env
nano .env
```

Set at minimum:

- `APP_URL=https://your-domain.com`
- `APP_KEY=` → run `php artisan key:generate --show` locally and paste
- `DB_PASSWORD=` → strong password
- Google / Razorpay keys if needed

## Step 4 — Deploy

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

Open: `http://YOUR_SERVER_IP`

## Step 5 — After deploy

```bash
docker compose -f docker-compose.prod.yml exec app php artisan storage:link
docker compose -f docker-compose.prod.yml logs -f app
```

## Google Meet on production

Update Google OAuth redirect URI to:

```
https://your-domain.com/setup/google-meet/callback
```

(Setup page only works when `APP_ENV=local`; for production, add credentials directly in `.env`.)

## Hostinger cPanel (without Docker)

1. Upload code to `public_html` (point document root to `/public`)
2. Create MySQL database in cPanel
3. Import `database/backups/erpoexpo_dump.sql` via phpMyAdmin
4. Copy `.env` from `deploy/env.production.example` and set DB credentials
5. Run via SSH: `php artisan migrate --force && php artisan config:cache`

## Default logins (if seeded)

- Admin: `admin@example.com` / `password`
- Company: `company@example.com` / `password`

Change passwords after going live.
