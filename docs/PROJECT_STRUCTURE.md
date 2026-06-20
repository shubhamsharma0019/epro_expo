# EproExpo — Project structure & restructure report

**Date:** 2026-06-01  
**App root:** `erpoexpo/`  
**Database:** MySQL (`erpoexpo` on `127.0.0.1:3306`)

---

## 1. Old structure summary

| Area | Before |
|------|--------|
| Routes | Single large `routes/web.php` (~800+ lines) with all flows mixed |
| Admin views | Numbered prototypes `resources/views/admin/01_*.blade.php` … `42_*.blade.php` at admin root |
| Layouts | Responsive rules only ad-hoc per page |
| Database | SQLite used during development; demo data heavily in `DatabaseSeeder` |
| Route loading | All controller `use` imports in one file |

---

## 2. New structure summary

| Area | After |
|------|--------|
| Routes | `routes/web.php` loads flow modules under `routes/modules/` |
| Admin UI | Live stack: `layouts.admin` + `admin/resources/*`; legacy HTML in `admin/legacy/` |
| Shared UI | `resources/views/shared/partials/responsive-fixes.blade.php` on all main layouts |
| Database | **MySQL** default (`DB_CONNECTION=mysql`); `php artisan db:sync-sqlite-to-mysql --merge` for one-time SQLite → MySQL copy |
| Seeders | Minimal credentials only; full demo behind `APP_SEED_DEMO=true` |
| Booth logic | `app/Support/BoothFloorMap.php` for floor-plan footprints |

### Route modules (`routes/modules/`)

| File | Flow |
|------|------|
| `home.php` | Landing `/` |
| `user.php` | Visitor auth, profile, tickets |
| `exhibition.php` | Public exhibitions, visitor pavilion/hall/booth |
| `admin.php` | Admin panel (dynamic resources + legacy URL redirects) |
| `company.php` | Company auth, exhibitions, booth booking, booth setup, events |
| `event.php` | Visitor event purchase flow |

Each module file declares its own `use` imports (required by PHP).

### Views (flow-oriented)

```
resources/views/
  layouts/          # admin, company-flow, exhibition, event, frontend, user, …
  components/       # grouped: shared, company, frontend, exhibition, user
  shared/partials/  # responsive-fixes
  admin/
    legacy/         # 01–42 static prototypes (fallback via AdminContentController)
    resources/      # dynamic CRUD UI
  company/          # dashboard, booth-booking, analytics, exhibitions, …
  …                 # visitor/event blades under existing paths
```

### Controllers (namespace by role)

```
app/Http/Controllers/
  Admin/            # Dashboard, AdminContent, approvals, bookings
  Auth/             # Company + User auth
  Company/          # Booth booking, setup, enquiries, meetings
  CompanyEvent/       # Event-company flow
  Frontend/         # Visitor exhibition experience
  VisitorEvent/     # Ticket purchase
```

---

## 3. Files moved

| From | To |
|------|-----|
| `resources/views/admin/01_*.blade.php` … `42_*.blade.php` | `resources/views/admin/legacy/` (42 files) |

Route definitions were **extracted** from `web.php` into `routes/modules/*.php` (not duplicated).

---

## 4. Files renamed

None (moves only; route names and URLs unchanged).

---

## 5. Files modified (high level)

- `routes/web.php` — module loader
- `routes/modules/*.php` — per-flow routes + controller imports
- `app/Console/Commands/SyncSqliteToMysql.php` — `--merge` + `insertOrIgnore`
- `database/seeders/DatabaseSeeder.php` — demo gated by `APP_SEED_DEMO`
- `app/Http/Controllers/Admin/AdminContentController.php` — resolves `admin.legacy.*` views
- `resources/views/layouts/*.blade.php` — responsive partial include
- `.env` / `.env.example` — MySQL + `APP_SEED_DEMO`

---

## 6. New folders created

- `routes/modules/`
- `resources/views/admin/legacy/`
- `resources/views/shared/partials/`
- `docs/PROJECT_STRUCTURE.md` (this file)
- `scripts/mysql_counts.php`

---

## 7. Route files updated

- **Loader:** `routes/web.php`
- **Modules:** `home.php`, `user.php`, `exhibition.php`, `admin.php`, `company.php`, `event.php`
- **Legacy URLs:** `/admin/03_companies`, `/admin/01_login`, etc. redirect or resolve via `AdminContentController::resolveImportedPage`

Verified: `php artisan route:list` succeeds.

---

## 8. Controllers reorganized

Controllers were already grouped under `Admin/`, `Company/`, `CompanyEvent/`, `Frontend/`, `VisitorEvent/`. No breaking namespace moves in this pass; routes now reference them from module files with explicit imports.

**Support class:** `app/Support/BoothFloorMap.php` (booth graph sizing).

---

## 9. Views reorganized

- Legacy admin prototypes → `admin/legacy/`
- Dynamic admin → `admin/resources/`
- Company analytics canonical view: `company/analytics/index.blade.php`

Large-scale moves of all 600+ blades into `company/events/` etc. were **not** done in one pass to avoid breaking `@include` paths; incremental migration can follow this map.

---

## 10. Shared components created

| Asset | Purpose |
|-------|---------|
| `shared/partials/responsive-fixes.blade.php` | Global overflow, table, sidebar width safeguards |
| `layouts/admin.blade.php` | Admin shell + sidebar |
| `layouts/company-flow.blade.php` | Company flow + impersonation banner |
| `components/*` | Existing reusable header/sidebar/cards (unchanged visually) |

---

## 11. Responsive fixes done

- Shared partial on: `admin`, `company-flow`, `company`, `company-event`, `frontend`, `exhibition`, `event`, `user`, `blank` layouts
- Rules: `overflow-x: hidden`, responsive tables (`min-width` + horizontal scroll), mobile sidebar `max-width: 85vw`, word-break on table cells
- **No** color, typography, or layout redesign

---

## 12. MySQL database connection status

| Setting | Value |
|---------|--------|
| Driver | `mysql` |
| Host | `127.0.0.1:3306` |
| Database | `erpoexpo` |
| Status | **Connected** — Eloquent queries succeed |

Note: `php artisan db:show` may fail on some MariaDB builds missing `performance_schema.session_status`; use `php scripts/mysql_counts.php` instead.

---

## 13. Database tables used (core flows)

`admins`, `companies`, `exhibitions`, `pavilions`, `halls`, `booths`, `booth_sizes`, `booth_bookings`, `booth_profiles`, `booth_products`, `company_events`, `event_ticket_types`, `payments`, `users`, `visitor_pavilions`, `visitor_halls`, `visitor_exhibitors`, `ticket_tiers`, `admin_settings`, `admin_activity_logs`, … (80 tables after migrations)

---

## 14. Real data in MySQL (not seeders only)

- **Production path:** CRUD via admin/company/visitor controllers → MySQL tables.
- **Seeder:** Only default logins (`admin@example.com`, `company@example.com`, `test@example.com`) when `php artisan db:seed` runs.
- **Demo bulk data:** Only if `APP_SEED_DEMO=true` in `.env`.
- **SQLite migration:** `php artisan db:sync-sqlite-to-mysql --merge` copied historical rows without truncate.
- **Verified counts (post-sync):** admins=1, companies=1, exhibitions=3, booth_bookings=1.

---

## 15. Pages / checks tested

| Check | Result |
|-------|--------|
| `php artisan route:list` | OK |
| `php artisan optimize:clear` | OK |
| `scripts/admin_route_smoke.php` | 42 admin routes OK |
| `php artisan test --filter=CompanyBoothBooking` | 4 passed |
| `scripts/mysql_counts.php` | MySQL counts OK |

**Manual QA recommended:** company floor-plan, visitor exhibition lobby, event purchase, finance/payments admin list (same UI as before).

---

## 16. Remaining issues / follow-ups

1. **Incremental view moves** — Move blades into `company/events/`, `visitor/exhibitions/` as needed; update `@include` and `view()` paths per module.
2. **`app/Services/{Module}/`** — Extract repeated controller queries when touching those controllers.
3. **`routes/modules/_imports.php`** — Unused reference file; safe to remove or wire if you prefer central imports.
4. **`db:show` on MariaDB** — Environment-specific; not an app bug.
5. **Full responsive audit** — Per-page chart/card tweaks if any page still overflows on small devices.
6. **SQL dump import** — If you provide a `.sql` dump, import with `mysql erpoexpo < dump.sql` then run `migrate` (no `--fresh`).

---

## 17. Preservation confirmation

| Requirement | Status |
|-------------|--------|
| UI / visual identity | **Preserved** — no redesign |
| Route names & URLs | **Preserved** — modular split only |
| Dynamic data | **From MySQL** via Eloquent |
| Database records | **Not dropped/truncated** |
| Working features | Admin smoke + booth booking tests pass |

---

## Commands reference

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:list

# One-time SQLite → MySQL (non-destructive)
php artisan db:sync-sqlite-to-mysql --merge

# Local demo data only
# Set APP_SEED_DEMO=true in .env, then:
php artisan db:seed

php scripts/mysql_counts.php
php scripts/admin_route_smoke.php
```

**Default logins (after seed):** `admin@example.com` / `password`, `company@example.com` / `password`
