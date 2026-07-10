<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Services\BoothAnalyticsService;
use App\Domain\Booth\Services\BoothSetupStepService;
use App\Domain\Company\Models\Enquiry;
use App\Support\MediaUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BoothPreviewController extends BaseBoothSetupController
{
    public function show(BoothBooking $booking, BoothSetupStepService $steps, BoothAnalyticsService $analyticsService): View
    {
        $booking = $this->setupBooking($booking);

        $booking->loadMissing([
            'boothProfile',
            'boothBranding',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothSessions.teamMember',
            'boothMeetingAvailability',
            'boothMeetingSlots',
            'company',
            'hall',
            'booth',
            'exhibition',
        ]);

        $profile = $booking->boothProfile;
        $branding = $booking->boothBranding;
        $company = $booking->company;
        $companyId = (int) $booking->company_id;

        $products = $booking->boothProducts
            ->where('status', 'published')
            ->sortBy([['sort_order', 'asc'], ['created_at', 'desc']])
            ->values();

        $documents = $booking->boothDocuments
            ->where('visibility', 'public')
            ->where('status', 'active')
            ->sortByDesc('created_at')
            ->values();

        $catalogues = $booking->boothCatalogues
            ->where('visibility', 'public')
            ->where('status', 'active')
            ->sortByDesc('created_at')
            ->values();

        $mediaItems = $booking->boothMedia
            ->where('status', 'active')
            ->sortBy([['sort_order', 'asc'], ['created_at', 'desc']])
            ->values();

        $teamMembers = $booking->boothTeamMembers
            ->where('status', 'active')
            ->sortByDesc('created_at')
            ->values();

        $sessions = $booking->boothSessions
            ->whereIn('status', ['upcoming', 'live'])
            ->sortBy([['session_date', 'asc'], ['start_time', 'asc']])
            ->values();

        $meetingSlots = $booking->boothMeetingSlots
            ->where('status', 'available')
            ->sortBy([['date', 'asc'], ['start_time', 'asc']])
            ->values();

        $enquiries = Enquiry::query()->where('company_id', $companyId);
        $leadStats = [
            'total' => (int) (clone $enquiries)->count(),
            'hot' => (int) (clone $enquiries)->where('status', 'hot')->count(),
            'qualified' => (int) (clone $enquiries)->where('status', 'qualified')->count(),
            'new' => (int) (clone $enquiries)->where('status', 'new')->count(),
        ];
        $analytics = $analyticsService->snapshot($booking);
        $visitorMetrics = $analyticsService->visitorMetrics($booking);
        $companyAgeYears = $company?->created_at ? max(0, now()->diffInYears($company->created_at)) : 0;
        $servedCountries = collect([$profile?->country, $company?->country])->filter()->unique()->count();

        $highlightStats = [
            'years_experience' => $profile?->years_experience ?: ($profile?->highlight_stats['years_experience'] ?? $companyAgeYears),
            'clients' => $profile?->clients_count ?: ($profile?->highlight_stats['clients'] ?? $leadStats['total']),
            'countries' => $profile?->countries_served ?: ($profile?->highlight_stats['countries'] ?? $servedCountries),
            'team_size' => $profile?->expert_team_size ?: ($profile?->highlight_stats['team_size'] ?? $teamMembers->count()),
        ];

        $companyName = $profile?->company_name ?: $company?->company_name ?: $company?->name ?: 'Your Company Name';
        $companySlug = Str::slug($companyName);
        $publicSlug = $booking->exhibition?->slug;
        $visitorPreviewUrl = $publicSlug && $companySlug
            ? route('exhibitions.visitor.companies.show', [$publicSlug, $companySlug])
            : null;

        $videoItem = $mediaItems->first(fn ($m) => $m->resolvedType() === 'video') ?: $mediaItems->first();
        $firstBrochure = $catalogues->concat($documents)->first(fn ($item) => filled($item->file_path));
        $rep = $teamMembers->first();
        $liveSession = $sessions->firstWhere('status', 'live');
        $nextSession = $liveSession ?: $sessions->first();

        $brochureCount = $documents->count() + $catalogues->count();
        $routes = fn (string $name, array $params = []) => route($name, array_merge(['booking' => $booking], $params));

        $featureCards = [
            [
                'icon' => 'fa-regular fa-building',
                'title' => 'Company Details',
                'desc' => filled($profile?->about_company)
                    ? Str::limit(trim(strip_tags($profile->about_company)), 90)
                    : 'Add your company profile, vision and team details.',
                'cta' => 'View Details',
                'url' => $routes('company.booth-setup.profile.edit'),
                'highlight' => false,
            ],
            [
                'icon' => 'fa-regular fa-file-pdf',
                'title' => 'Brochures',
                'desc' => $brochureCount > 0
                    ? $brochureCount . ' brochure' . ($brochureCount === 1 ? '' : 's') . ' available for visitors.'
                    : 'Upload company profile and product catalogues.',
                'cta' => 'Download Now',
                'url' => $routes('company.booth-setup.documents.index'),
                'highlight' => false,
            ],
            [
                'icon' => 'fa-regular fa-circle-play',
                'title' => $videoItem?->title ?: 'Company Media',
                'desc' => $videoItem?->description ?: $videoItem?->title
                    ?: ($profile?->video_url ? 'Company video is ready to watch.' : 'Add a company video for visitors.'),
                'cta' => 'Watch Now',
                'url' => $routes('company.booth-setup.media.index'),
                'highlight' => false,
            ],
            [
                'icon' => 'fa-solid fa-headset',
                'title' => 'Live Session (1 to 1)',
                'desc' => $meetingSlots->count() > 0
                    ? $meetingSlots->count() . ' meeting slots open for booking.'
                    : 'Configure 1-to-1 meeting availability for visitors.',
                'cta' => 'Request Meeting',
                'url' => $routes('company.booth-setup.meetings.edit'),
                'highlight' => true,
            ],
            [
                'icon' => 'fa-solid fa-desktop',
                'title' => 'Conference',
                'desc' => $nextSession
                    ? 'Next: ' . Str::limit($nextSession->title, 50)
                    : 'Schedule live sessions and webinars for your booth.',
                'cta' => 'View Schedule',
                'url' => $routes('company.booth-setup.sessions.index'),
                'highlight' => false,
            ],
            [
                'icon' => 'fa-solid fa-chart-column',
                'title' => 'Visitor Reporting',
                'desc' => $visitorMetrics['total'] > 0
                    ? number_format($visitorMetrics['total']) . ' total booth visits recorded.'
                    : 'Track visitor engagement and booth performance.',
                'cta' => 'View Reports',
                'url' => $routes('company.booth-setup.analytics'),
                'highlight' => false,
            ],
            [
                'icon' => 'fa-regular fa-user',
                'title' => 'Business Leads',
                'desc' => $leadStats['total'] > 0
                    ? number_format($leadStats['total']) . ' enquiries captured from visitors.'
                    : 'Capture and manage business enquiries.',
                'cta' => 'View Leads',
                'url' => route('company.enquiries.index'),
                'highlight' => false,
            ],
        ];

        return view('company.booth-setup.preview', $this->commonData($booking, $steps) + [
            'products' => $products,
            'documents' => $documents,
            'catalogues' => $catalogues,
            'mediaItems' => $mediaItems,
            'teamMembers' => $teamMembers,
            'sessions' => $sessions,
            'analytics' => $analytics,
            'highlightStats' => $highlightStats,
            'visitorPreviewUrl' => $visitorPreviewUrl,
            'featureCards' => $featureCards,
            'leadStats' => $leadStats,

            'visitorStats' => $visitorMetrics,
            'meetingSlots' => $meetingSlots,
            'meetingAvailability' => $booking->boothMeetingAvailability,
            'preview' => [
                'companyName' => $companyName,
                'welcomeHeading' => $branding?->welcome_heading ?: $profile?->welcome_text ?: $profile?->booth_title ?: 'Welcome to Our Booth',
                'tagline' => $profile?->tagline ?: $profile?->industry ?: $company?->industry,
                'aboutText' => filled($profile?->about_company)
                    ? trim(strip_tags($profile->about_company))
                    : 'Add your company overview from the profile setup page.',
                'hallName' => $booking->hall?->title ?: $booking->hall?->name ?: 'Hall',
                'boothNumber' => $booking->booth?->booth_number ?: 'N/A',
                'industry' => $profile?->industry ?: $company?->industry,
                'bannerUrl' => $branding?->booth_banner
                    ? asset('storage/' . $branding->booth_banner)
                    : ($profile?->booth_banner ? asset('storage/' . $profile->booth_banner) : asset('assets/exhibition/images/booth_banner.png')),
                'logoUrl' => $profile?->company_logo ? asset('storage/' . $profile->company_logo) : null,
                'videoUrl' => $videoItem?->mediaUrl() ?: $profile?->video_url,
                'videoTitle' => $videoItem?->title ?: ($profile?->video_url ? 'Company Video' : 'Company Media'),
                'videoThumb' => $videoItem?->thumbnailUrl(),
                'brochureHeading' => $firstBrochure ? 'Download ' . ($firstBrochure->title ?: 'Brochure') : 'Upload Brochure',
                'brochureTitle' => $firstBrochure?->title ?: 'No brochure uploaded',
                'brochureUrl' => $firstBrochure?->file_path ? MediaUrl::url($firstBrochure->file_path) : null,
                'rep' => $rep,
                'repEmail' => $rep?->email ?: $profile?->email ?: $company?->email,
                'repPhone' => $rep?->phone ?: $profile?->phone ?: $company?->phone,
                'liveSession' => $liveSession,
                'nextSession' => $nextSession,
                'sessionDateLine' => $nextSession
                    ? trim(($nextSession->session_date?->format('M d, Y') ?? '') . ' | ' . ($nextSession->start_time ? \Carbon\Carbon::parse($nextSession->start_time)->format('h:i A') . ' (IST)' : ''))
                    : null,
                'sessionDescription' => $nextSession?->description,
                'meetingSlotsText' => $meetingSlots->count() > 0
                    ? $meetingSlots->count() . ' slots available for visitors'
                    : 'Set up meeting availability for visitors',
                'ctaText' => $branding?->cta_button_text ?: $profile?->cta_text,
                'ctaLink' => $branding?->cta_button_link ?: $profile?->cta_link,
            ],
        ]);
    }

    public function markReady(BoothBooking $booking, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $booking->update(['booth_setup_status' => 'ready_to_publish']);
        $steps->markStepCompleted($booking, 'preview');

        if (request('next') === 'publish') {
            return redirect()
                ->route('company.booth-setup.publish.show', $booking)
                ->with('status', 'Preview marked as ready.');
        }

        return back()->with('status', 'Preview marked as ready.');
    }
}
