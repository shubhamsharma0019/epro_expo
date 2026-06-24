<?php

namespace App\Domain\Event\Controllers;

use App\Http\Requests\CompanyEvent\CompanyEventBasicDetailsRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Support\CompanyEventOptions;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventDraftController extends BaseCompanyEventController
{
    public function create(): View
    {
        $existingEvent = $this->findFlowEvent();
        $viewData = $existingEvent
            ? $this->commonData($existingEvent)
            : $this->placeholderCommonData();

        return view('backend.company.event-company-flow.create-event', array_merge(
            $viewData,
            [
                'eventTemplates' => $this->eventTemplates(),
                'eventCategories' => CompanyEventOptions::categories($this->companyId()),
            ]
        ));
    }

    public function store(CompanyEventBasicDetailsRequest $request): RedirectResponse
    {
        $companyEvent = $this->createDraftEvent();
        $this->saveBasicDetails($request, $companyEvent);

        return redirect()
            ->route('company.event-company-flow.basic', $companyEvent)
            ->with('status', 'Company event draft created.');
    }

    public function basic(?CompanyEvent $companyEvent = null): View
    {
        $companyEvent = $this->setupEvent($companyEvent);

        return view('backend.company.event-company-flow.basic-details', array_merge(
            $this->commonData($companyEvent),
            [
                'eventCategories' => CompanyEventOptions::categories($this->companyId()),
                'eventSubCategories' => CompanyEventOptions::subCategories(),
                'eventTimezones' => CompanyEventOptions::timezones(),
            ]
        ));
    }

    public function updateBasic(CompanyEventBasicDetailsRequest $request, ?CompanyEvent $companyEvent = null): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);
        $this->saveBasicDetails($request, $companyEvent);

        if (($request->validated()['next'] ?? 'stay') === 'branding') {
            return redirect()
                ->route('company.event-company-flow.branding', $companyEvent)
                ->with('status', 'Basic event details saved.');
        }

        return back()->with('status', 'Basic event details saved.');
    }

    private function saveBasicDetails(CompanyEventBasicDetailsRequest $request, CompanyEvent $companyEvent): void
    {
        $data = $request->validated();
        unset($data['next']);

        if (isset($data['title'])) {
            $data['slug'] = $this->uniqueSlug($data['title'], $companyEvent->id);
        }

        $data['company_id'] = $this->companyId();
        $data['status'] = $companyEvent->status === 'submitted' ? 'draft' : $companyEvent->status;

        $companyEvent->update($data);
        session(['company_event_flow_event_id' => $companyEvent->id]);
    }

    private function eventTemplates(): array
    {
        return [
            [
                'key' => 'conference',
                'badge' => 'Popular',
                'color' => '#5B32F6',
                'background' => '#F4F1FF',
                'title' => 'Tech Conference',
                'copy' => 'Ideal for keynotes, speaker panel tracks, and physical tech meetups.',
                'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8 M23 21v-2a4 4 0 0 0-3-3.87 M16 3.13a4 4 0 0 1 0 7.75',
                'values' => [
                    'title' => 'Global Innovation Summit 2026',
                    'category' => 'Technology',
                    'subCategory' => 'AI & Machine Learning',
                    'startsAt' => '2026-05-15 09:00:00',
                    'endsAt' => '2026-05-17 18:00:00',
                    'timezone' => 'Asia/Kolkata',
                    'venueName' => 'Grand Convention Center',
                    'venueAddress' => 'Bengaluru, India',
                    'city' => 'Bengaluru',
                    'country' => 'India',
                    'website' => 'https://globalinnovate.com',
                    'summary' => 'Global Innovation Summit brings together technology leaders, innovators, and investors.',
                    'description' => 'Global Innovation Summit brings together technology leaders, innovators, and investors to explore the future of AI, Cloud, and Emerging Technologies.',
                ],
            ],
            [
                'key' => 'expo',
                'badge' => '',
                'color' => '#2563EB',
                'background' => '#EFF6FF',
                'title' => 'Expo / Trade Show',
                'copy' => 'Perfect for exhibition stalls, sponsor lead capture, and vendor showcases.',
                'icon' => 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z M3.27 6.96 12 12.01l8.73-5.05 M12 22.08V12',
                'values' => [
                    'title' => 'International Manufacturing & Trade Expo 2026',
                    'category' => 'Manufacturing',
                    'subCategory' => 'Industrial Automation',
                    'startsAt' => '2026-09-10 09:00:00',
                    'endsAt' => '2026-09-13 18:00:00',
                    'timezone' => 'Asia/Kolkata',
                    'venueName' => 'Metropolitan Exhibition Center',
                    'venueAddress' => 'New Delhi, India',
                    'city' => 'New Delhi',
                    'country' => 'India',
                    'website' => 'https://infomanufacturingexpo.com',
                    'summary' => 'A physical exhibition for machinery, robotics, logistics and automation.',
                    'description' => 'The premier physical exhibition showcasing state-of-the-art machinery, robotics, logistics solutions, and automation technologies from global manufacturers.',
                ],
            ],
            [
                'key' => 'seminar',
                'badge' => '',
                'color' => '#059669',
                'background' => '#ECFDF5',
                'title' => 'Seminar / Workshop',
                'copy' => 'Designed for in-person training classes, educational courses, and workshops.',
                'icon' => 'M2 3h20v14H2z M8 21h8 M12 17v4',
                'values' => [
                    'title' => 'Hands-on UI/UX Design Boot Camp',
                    'category' => 'Education',
                    'subCategory' => 'Product Design',
                    'startsAt' => '2026-07-24 10:00:00',
                    'endsAt' => '2026-07-25 17:00:00',
                    'timezone' => 'Asia/Kolkata',
                    'venueName' => 'Creative Arts Hub',
                    'venueAddress' => 'Sector 5, Bangalore, India',
                    'city' => 'Bangalore',
                    'country' => 'India',
                    'website' => 'https://designbootcamp.in',
                    'summary' => 'An intensive in-person workshop for product design teams.',
                    'description' => 'An intensive interactive in-person workshop focusing on modern design tokens, design systems, user research frameworks, and advanced prototyping methods.',
                ],
            ],
            [
                'key' => 'networking',
                'badge' => '',
                'color' => '#EA580C',
                'background' => '#FFF7ED',
                'title' => 'Networking Event',
                'copy' => 'Focused on community dinners, local meetups, and investor-founder mixers.',
                'icon' => 'M18 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6 M6 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6 M18 22a3 3 0 1 0 0-6 3 3 0 0 0 0 6 M8.59 13.51l6.83 3.98 M15.41 6.51 8.59 10.49',
                'values' => [
                    'title' => 'Elite Founders & Investors Mixer',
                    'category' => 'Finance',
                    'subCategory' => 'Venture Capital',
                    'startsAt' => '2026-10-05 18:00:00',
                    'endsAt' => '2026-10-05 22:00:00',
                    'timezone' => 'Asia/Kolkata',
                    'venueName' => 'Skyline Lounge & Rooftop',
                    'venueAddress' => 'Mumbai, India',
                    'city' => 'Mumbai',
                    'country' => 'India',
                    'website' => 'https://foundersmixer.com',
                    'summary' => 'A premium physical networking dinner and pitch mixer.',
                    'description' => 'Connect with top-tier venture capitalists, angel investors, and high-growth startup founders during a premium physical networking dinner and pitch mixer.',
                ],
            ],
            [
                'key' => 'custom',
                'badge' => '',
                'color' => '#4B5563',
                'background' => '#F9FAFB',
                'title' => 'Custom / Blank',
                'copy' => 'Start with a blank canvas and hand-select all settings.',
                'icon' => 'M3 4h18v18H3z M16 2v4 M8 2v4 M3 10h18 M9 16l2 2 4-4',
                'values' => [
                    'title' => 'Untitled Company Event',
                    'category' => 'Technology',
                    'subCategory' => 'Other',
                    'startsAt' => '',
                    'endsAt' => '',
                    'timezone' => 'Asia/Kolkata',
                    'venueName' => '',
                    'venueAddress' => '',
                    'city' => '',
                    'country' => '',
                    'website' => '',
                    'summary' => '',
                    'description' => '',
                ],
            ],
        ];
    }
}
