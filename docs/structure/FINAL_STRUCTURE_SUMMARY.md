# Final Structure Cleanup Summary

- Root-level helper/report clutter was moved into docs/ and tools/.
- Static/reference imported Blade files were moved out of resources/views into archive/blade-reference/.
- Source import assets from old exports/tmp folders were moved into archive/source-assets/.
- Root-level Blade component wrapper files were moved out of resources/views/components into archive/blade-reference/component-wrappers/.
- resources/views/components now contains grouped component folders only: shared, company, exhibition, frontend, and user.
- resources/views now contains only live Blade views, route compatibility wrappers, layouts, and grouped components.
- No routes/controllers/models/database/business logic were changed.

Primary analytics view:
- resources/views/company/analytics/index.blade.php

Compatibility route view:
- resources/views/company/analytics.blade.php includes company.analytics.index

Full tree map:
- docs/structure/FINAL_PROJECT_TREE_MAP.md
