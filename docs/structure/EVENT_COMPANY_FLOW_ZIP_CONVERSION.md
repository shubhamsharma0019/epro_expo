# Event Company Flow Zip Conversion

Uploaded source:
- `event company flow.zip`

Archived source copy:
- `archive/source-assets/event-company-flow-uploaded/`

Live Laravel Blade flow:
- `resources/views/company/event-company-flow/dashboard.blade.php`
- `resources/views/company/event-company-flow/create.blade.php`
- `resources/views/company/event-company-flow/basic-details.blade.php`
- `resources/views/company/event-company-flow/branding.blade.php`
- `resources/views/company/event-company-flow/ticket-setup.blade.php`
- `resources/views/company/event-company-flow/preview.blade.php`
- `resources/views/company/event-company-flow/submit-review.blade.php`
- `resources/views/company/event-company-flow/partials/sidebar.blade.php`
- `resources/views/company/event-company-flow/partials/topbar.blade.php`

Mapping:
- `event_company_dashboard.html` -> `company.event-company-flow.dashboard`
- `create-event.html` -> `company.event-company-flow.create`
- `event-basic-details.html` -> `company.event-company-flow.basic-details`
- `event-branding.html` -> `company.event-company-flow.branding`
- `ticket-setup.html` -> `company.event-company-flow.ticket-setup`
- `event-preview.html` -> `company.event-company-flow.preview`
- `submit-review.html` -> `company.event-company-flow.submit-review`
- `sidebar.html` / `sidebar.js` -> Laravel sidebar/topbar partials

Live overwrite status:
- The uploaded zip page bodies are now used by the live company event flow Blade views.
- Laravel-safe forms were reattached for create, basic details, branding, ticket setup, and submit review.

Safety notes:
- Static zip backend/routes/models were not copied into the Laravel app.
- Static `localhost:8000` API calls were not added to live views.
- Laravel form actions, CSRF fields, named routes, controllers, and database-connected fields were preserved.
- Zip-style top navigation was added through `partials/topbar.blade.php`.
