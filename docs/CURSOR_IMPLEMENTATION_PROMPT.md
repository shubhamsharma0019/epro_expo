# ErpoExpo — Cursor Implementation Prompt

Copy everything below the line into Cursor when running a full implementation pass.

---

Work only on the required functionality. Do not change UI design, navigation, existing flow, page layout, styling, colors, routes structure, or make any page static. Keep all current dynamic data working.

## Tasks

### 1. Admin Approval Before Exhibition Goes Live
- Add/verify admin approval flow before any exhibition/event becomes live or published.
- Company should be able to create/submit exhibition/event.
- Exhibition/event should stay in pending/review status until admin approves it.
- Only after admin approval should it become live/published.
- Add proper backend validation and database status handling.
- Do not break existing company, visitor, exhibition, or admin flow.

### 2. Event Publish Control
- Add admin-side publish/unpublish control for events/exhibitions.
- Publishing should only be allowed after admin approval.
- If rejected/unpublished, it should not appear as live to visitors/companies where live events are shown.
- Keep existing UI same; only add required buttons/controls if missing.

### 3. Zoom Meeting Setup
- Add meeting setup option using Zoom meeting details.
- Admin/company should be able to add Zoom meeting link, meeting ID, passcode, date, time, and agenda where meeting scheduling already exists or is required.
- Store this data dynamically in database.
- Show meeting details only in the relevant meeting/detail pages.
- Do not make meeting data static or hardcoded.

### 4. Exhibition Type Selection Bug
- Currently, whenever booth booking happens, only one exhibition type is getting booked, especially "Global Tech Expo".
- Fix this bug completely.
- A company should not be forced to book only one fixed exhibition type.
- Add proper dynamic exhibition type selection option during booth booking.
- Company should be able to select different exhibition types based on available exhibitions/types.
- Selected exhibition type must be saved correctly in database with booth booking.
- Booking listing/detail pages should show the correct selected exhibition type.
- Do not hardcode "Global Tech Expo".
- Check frontend form, backend request, controller, model relationship, database column, and booking save logic.

### 5. Admin Sidebar Fix
- Admin sidebar is currently looking broken/weird in some places.
- Fix sidebar alignment, spacing, menu grouping, active states, icons, responsiveness, overflow issues, width issues, collapsing behavior, and visual consistency.
- Ensure all admin menu items are properly visible and organized.
- Remove unnecessary scrolling caused by sidebar layout issues.
- Fix any text wrapping, icon misalignment, menu overlap, or spacing issues.
- Sidebar should look professional and enterprise-grade.
- Do NOT redesign the admin panel.
- Do NOT change navigation structure.
- Do NOT change menu names unless necessary.
- Only fix UI/UX issues, alignment problems, responsiveness, and broken layouts.

### 6. Database & Backend
- Use existing database structure if possible.
- If required, create proper migrations for missing fields like approval_status, publish_status, zoom_meeting_link, meeting_id, passcode, meeting_time, exhibition_type_id, etc.
- Do not use seeders for dynamic data.
- Keep relationships clean between Exhibition, ExhibitionType, BoothBooking, Company, Event, and Meeting if these models already exist.
- Do not remove existing data or break existing tables.

### 7. Project Safety Rules (Very Important)
- Do not change UI unnecessarily.
- Do not change navigation.
- Do not change existing page flow.
- Do not make any page static.
- Do not remove any existing feature.
- Do not overwrite working company/visitor/admin flows.
- Make changes only where required.
- Maintain existing frontend and backend architecture.
- Preserve all current APIs, routes, and database relationships unless fixes are required.
- Ensure mobile responsiveness remains intact.
- Ensure all pages continue to work dynamically.

### 8. Final Verification
Before finishing:
- Check admin flow.
- Check company flow.
- Check exhibition flow.
- Check booth booking flow.
- Check event publish flow.
- Check meeting scheduling flow.
- Check sidebar responsiveness.
- Check database save/update operations.
- Verify no hardcoded exhibition selection exists.

### 9. Admin Full Management Sync & Dynamic Website
- Sync admin panel with the complete website flow.
- Admin should be able to manage all important website data dynamically.
- Any change made by admin must reflect on the public website automatically.
- Do not keep website content hardcoded/static if it should be manageable from admin.

### 10. Fully Dynamic Home Page
- Make the website home page fully dynamic from database/admin panel.
- Admin should be able to manage home page sections such as:
  - Hero/banner content
  - Featured exhibitions/events
  - Exhibition categories/types
  - Upcoming events
  - Companies/exhibitors
  - Booth/pavilion highlights
  - Statistics/counts
  - Testimonials
  - Partners/sponsors
  - FAQs
  - Contact/details/footer content
- Existing home page UI design must remain same.
- Only replace static/hardcoded content with dynamic database-driven content.
- If admin updates, adds, deletes, publishes, or unpublishes any item, the same change should show on the website home page.

### 11. Admin Control Rules
- Admin should have full control to create, edit, delete, approve, publish, unpublish, and manage website content.
- Admin changes must reflect on:
  - Website home page
  - Exhibition listing/detail pages
  - Event listing/detail pages
  - Booth booking flow
  - Company/exhibitor sections
  - Meeting/Zoom details where applicable
- Do not break company, visitor, or existing admin flow.
- Do not change UI, navigation, design, layout, or make any page static.

## Deliverables
- Implement all fixes.
- List every file modified.
- Explain each change made.
- Mention any pending issue or configuration requirement (especially Zoom integration if API credentials are required).
- Ensure project remains fully functional without breaking existing UI, navigation, or workflows.

## Expected Result
- Admin can approve exhibitions/events before they go live.
- Events can be published/unpublished by admin.
- Zoom meeting information can be managed dynamically.
- Companies can book booths under different exhibition types.
- "Global Tech Expo" is no longer hardcoded.
- Admin sidebar looks clean, aligned, responsive, and professional.
- Admin panel becomes the central control system: whatever admin manages or updates dynamically reflects on the website.
- Website home page is fully database-driven without changing the existing UI/design.
- No existing UI, navigation, or workflow is broken.
