<?php

namespace App\Domain\Event\Controllers;

use App\Http\Requests\CompanyEvent\CompanyEventBrandingRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventBranding;
use App\Domain\Event\Services\CompanyEventFileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandingController extends BaseCompanyEventController
{
    public function edit(?CompanyEvent $companyEvent = null): View
    {
        $companyEvent = $this->setupEvent($companyEvent);

        return view('backend.company.event-company-flow.branding', $this->commonData($companyEvent));
    }

    public function update(CompanyEventBrandingRequest $request, CompanyEventFileUploadService $files, ?CompanyEvent $companyEvent = null): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);
        $data = $request->validated();
        $action = $data['action'] ?? 'save';
        unset($data['action']);

        $branding = $companyEvent->branding;

        if ($action === 'reset') {
            if ($branding) {
                $files->delete($branding->logo_path);
                $files->delete($branding->banner_path);
                $files->delete($branding->brochure_path);
                $branding->delete();
            }

            return back()->with('status', 'Event company branding reset.');
        }

        foreach ([
            'logo' => ['column' => 'logo_path', 'section' => 'logo'],
            'banner' => ['column' => 'banner_path', 'section' => 'banner'],
            'brochure' => ['column' => 'brochure_path', 'section' => 'brochure'],
        ] as $field => $meta) {
            if ($request->hasFile($field)) {
                $data[$meta['column']] = $files->upload(
                    $request->file($field),
                    $companyEvent->id,
                    $meta['section'],
                    $branding?->{$meta['column']}
                );
            }

            unset($data[$field]);
        }

        if ($request->has('theme_sections')) {
            $socialLinks = is_array($branding?->social_links) ? $branding->social_links : [];
            $socialLinks['theme_sections'] = [
                'header' => $request->boolean('theme_sections.header'),
                'event_details' => $request->boolean('theme_sections.event_details'),
                'sponsors' => $request->boolean('theme_sections.sponsors'),
                'footer' => $request->boolean('theme_sections.footer'),
            ];
            $data['social_links'] = $socialLinks;
        }

        unset($data['theme_sections']);

        $data += [
            'company_id' => $this->companyId(),
            'company_event_id' => $companyEvent->id,
        ];

        CompanyEventBranding::updateOrCreate(['company_event_id' => $companyEvent->id], $data);

        if ($action === 'continue') {
            return redirect()
                ->route('company.event-company-flow.tickets', $companyEvent)
                ->with('status', 'Event branding saved.');
        }

        return back()->with('status', 'Event branding saved.');
    }
}
