<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use App\Support\AdminAudit;
use App\Support\LiveContent;
use App\Support\WebsiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminWebsiteController extends Controller
{
    public function home(): View
    {
        $exhibitions = Schema::hasTable('exhibitions')
            ? LiveContent::exhibitionQuery()->orderBy('name')->get(['id', 'title', 'name', 'is_home_featured'])
            : collect();

        $events = Schema::hasTable('company_events')
            ? LiveContent::companyEventQuery()->orderBy('title')->get(['id', 'title', 'is_home_featured'])
            : collect();

        $companies = Schema::hasTable('companies')
            ? Company::where('status', 'approved')->orderBy('company_name')->orderBy('name')->get(['id', 'company_name', 'name', 'is_home_featured'])
            : collect();

        return view('backend.admin.website.home', [
            'hero' => WebsiteContent::hero(),
            'cta' => WebsiteContent::cta(),
            'footer' => WebsiteContent::footer(),
            'stats' => WebsiteContent::publishedItems('home', 'stat')->isNotEmpty()
                ? WebsiteContent::sectionOrDefaults('home', 'stat', [])
                : [],
            'useLiveStats' => ! WebsiteContent::publishedItems('home', 'stat')->count(),
            'partners' => WebsiteContent::sectionOrDefaults('home', 'partner', WebsiteContent::defaultPartners()),
            'features' => WebsiteContent::sectionOrDefaults('home', 'feature', WebsiteContent::defaultFeatures()),
            'exhibitions' => $exhibitions,
            'events' => $events,
            'companies' => $companies,
            'featuredExhibitionIds' => $exhibitions->where('is_home_featured', true)->pluck('id')->all(),
            'featuredEventIds' => $events->where('is_home_featured', true)->pluck('id')->all(),
            'featuredCompanyIds' => $companies->where('is_home_featured', true)->pluck('id')->all(),
        ]);
    }

    public function updateHome(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hero_title_line_1' => ['required', 'string', 'max:255'],
            'hero_title_line_2' => ['required', 'string', 'max:255'],
            'hero_title_highlight' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image_url' => ['nullable', 'string', 'max:500'],
            'cta_title' => ['required', 'string', 'max:255'],
            'cta_subtitle' => ['nullable', 'string'],
            'footer_copyright' => ['nullable', 'string', 'max:500'],
            'footer_contact_email' => ['nullable', 'email', 'max:255'],
            'footer_contact_phone' => ['nullable', 'string', 'max:50'],
            'featured_exhibitions' => ['nullable', 'array'],
            'featured_exhibitions.*' => ['integer'],
            'featured_events' => ['nullable', 'array'],
            'featured_events.*' => ['integer'],
            'featured_companies' => ['nullable', 'array'],
            'featured_companies.*' => ['integer'],
            'use_live_stats' => ['nullable', 'boolean'],
        ]);

        if (Schema::hasTable('website_content_items')) {
            $this->upsertSingleton('hero', [
                'title' => $data['hero_title_line_1'],
                'subtitle' => $data['hero_title_line_2'],
                'body' => $data['hero_subtitle'] ?? null,
                'image_url' => $data['hero_image_url'] ?? null,
                'meta' => json_encode(['title_highlight' => $data['hero_title_highlight']]),
            ]);

            $this->upsertSingleton('cta', [
                'title' => $data['cta_title'],
                'body' => $data['cta_subtitle'] ?? null,
            ]);

            $this->upsertSingleton('footer', [
                'body' => $data['footer_copyright'] ?? null,
                'meta' => json_encode([
                    'contact_email' => $data['footer_contact_email'] ?? null,
                    'contact_phone' => $data['footer_contact_phone'] ?? null,
                ]),
            ]);

            if (! $request->boolean('use_live_stats')) {
                DB::table('website_content_items')
                    ->where('page', 'home')
                    ->where('section_key', 'stat')
                    ->delete();
            }
        }

        $this->syncFeatured(Exhibition::class, 'exhibitions', $data['featured_exhibitions'] ?? []);
        $this->syncFeatured(CompanyEvent::class, 'company_events', $data['featured_events'] ?? []);
        $this->syncFeatured(Company::class, 'companies', $data['featured_companies'] ?? []);

        AdminAudit::log('website_home_updated', 'website', 'home', null, [
            'featured_exhibitions' => count($data['featured_exhibitions'] ?? []),
            'featured_events' => count($data['featured_events'] ?? []),
        ]);

        return redirect()->route('admin.website.home')->with('status', 'Website home content updated. Changes are live on the public home page.');
    }

    private function upsertSingleton(string $sectionKey, array $payload): void
    {
        $existing = DB::table('website_content_items')
            ->where('page', 'home')
            ->where('section_key', $sectionKey)
            ->first();

        $row = array_merge($payload, [
            'page' => 'home',
            'section_key' => $sectionKey,
            'status' => 'published',
            'sort_order' => 0,
            'updated_at' => now(),
        ]);

        if ($existing) {
            DB::table('website_content_items')->where('id', $existing->id)->update($row);
        } else {
            DB::table('website_content_items')->insert(array_merge($row, [
                'created_at' => now(),
            ]));
        }
    }

    private function syncFeatured(string $modelClass, string $table, array $ids): void
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'is_home_featured')) {
            return;
        }

        $modelClass::query()->update(['is_home_featured' => false]);

        if ($ids !== []) {
            $modelClass::query()->whereIn('id', $ids)->update(['is_home_featured' => true]);
        }
    }
}
