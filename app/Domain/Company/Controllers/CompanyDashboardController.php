<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Repositories\CompanyRepository;
use App\Domain\Event\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyDashboardController extends Controller
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function index(Request $request): View|RedirectResponse
    {
        $companyId = session('company_id');

        if (! $companyId) {
            return redirect('/company/login');
        }

        $currentCompany = $this->companyRepository->findWithCount($companyId, [
            'boothBookings',
            'products',
            'companyDocuments',
            'catalogues',
            'mediaGalleries',
            'businessCards',
            'companyMeetings',
            'enquiries',
            'visitorMeetingBookings',
            'boothViews',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
        ]);

        if (! $currentCompany) {
            session()->forget('company_id');

            return redirect('/company/login');
        }

        if ($request->query('flow') === 'exhibitor') {
            session()->forget(['company_flow_context', 'company_event_flow_event_id']);
        } elseif (session('company_flow_context') === 'event_company') {
            return redirect()->route('company.event-company-flow.dashboard');
        }

        $latestBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothMeetingSlots',
            ])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->first();

        $pendingBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->latest()
            ->first();

        $recentBookings = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothMeetingSlots',
            ])
            ->latest()
            ->get();

        $availableExhibitions = Exhibition::query()
            ->whereIn('status', ['active', 'published', 'live'])
            ->whereHas('pavilions', function ($query) {
                $query->where('status', 'active')
                    ->whereHas('halls', fn ($hallQuery) => $hallQuery->where('status', 'active'));
            })
            ->orderBy('title')
            ->get(['id', 'title', 'slug']);

        $recentEnquiries = $currentCompany->enquiries()
            ->with('visitor')
            ->latest()
            ->take(5)
            ->get();

        $recentMeetings = $currentCompany->visitorMeetingBookings()
            ->with(['companyMeeting', 'visitor'])
            ->latest()
            ->take(5)
            ->get();

        $confirmedBookings = $currentCompany->boothBookings()
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->count();

        $totalSpend = (float) $currentCompany->boothBookings()->sum('total_amount');

        $performanceRange = in_array((int) $request->query('performance_range', 7), [7, 30], true)
            ? (int) $request->query('performance_range', 7)
            : 7;
        $performanceStart = Carbon::today()->subDays($performanceRange - 1);
        $viewsByDate = $currentCompany->boothViews()
            ->where(function ($query) use ($performanceStart) {
                $query->where('viewed_at', '>=', $performanceStart)
                    ->orWhere(function ($fallbackQuery) use ($performanceStart) {
                        $fallbackQuery->whereNull('viewed_at')
                            ->where('created_at', '>=', $performanceStart);
                    });
            })
            ->get()
            ->groupBy(fn ($view) => optional($view->viewed_at ?? $view->created_at)->format('Y-m-d'));

        $hasBoothProfile = (bool) $latestBooking?->boothProfile;
        $labelInterval = max(1, (int) ceil($performanceRange / 7));
        $performanceValues = collect(range(0, $performanceRange - 1))->map(function (int $offset) use ($performanceStart, $viewsByDate, $performanceRange, $labelInterval) {
            $date = $performanceStart->copy()->addDays($offset);

            return [
                'label' => $date->format('M j'),
                'value' => $viewsByDate->get($date->format('Y-m-d'), collect())->count(),
                'show_label' => $offset === 0 || $offset === ($performanceRange - 1) || $offset % $labelInterval === 0,
            ];
        });

        $maxPerformanceValue = max((int) $performanceValues->max('value'), 4);
        $pointSpacing = $performanceRange > 1 ? 660 / ($performanceRange - 1) : 0;
        $chartPoints = $performanceValues->values()->map(function (array $item, int $index) use ($maxPerformanceValue, $pointSpacing) {
            $x = 20 + ($index * $pointSpacing);
            $y = 180 - (($item['value'] / $maxPerformanceValue) * 140);

            return [
                'x' => round($x, 2),
                'y' => round($y, 2),
                'label' => $item['label'],
                'value' => $item['value'],
                'show_label' => $item['show_label'],
            ];
        });
        $lastChartX = (float) ($chartPoints->last()['x'] ?? 20);

        $performanceData = [
            'values' => $performanceValues,
            'max_value' => $maxPerformanceValue,
            'axis_labels' => collect(range(4, 0))->map(fn (int $step) => (int) round($maxPerformanceValue * $step / 4)),
            'points' => $chartPoints,
            'polyline' => $chartPoints->map(fn (array $point) => $point['x'] . ',' . $point['y'])->implode(' '),
            'polygon' => $chartPoints->map(fn (array $point) => $point['x'] . ',' . $point['y'])->implode(' ') . ' ' . $lastChartX . ',200 20,200',
            'range' => $performanceRange,
        ];

        $hasCompanyProfile = $currentCompany->isProfileComplete();
        $bookingProductsCount = (int) ($latestBooking->booth_products_count ?? 0);
        $bookingDocumentsCount = (int) ($latestBooking->booth_documents_count ?? 0);
        $bookingCataloguesCount = (int) ($latestBooking->booth_catalogues_count ?? 0);
        $bookingMediaCount = (int) ($latestBooking->booth_media_count ?? 0);
        $bookingTeamCount = (int) ($latestBooking->booth_team_members_count ?? 0);
        $bookingMeetingSlotsCount = (int) ($latestBooking->booth_meeting_slots_count ?? 0);
        $totalBoothProductsCount = (int) $currentCompany->booth_products_count;
        $totalBoothDocumentsCount = (int) $currentCompany->booth_documents_count;
        $totalBoothCataloguesCount = (int) $currentCompany->booth_catalogues_count;
        $totalBoothMediaCount = (int) $currentCompany->booth_media_count;

        $previewReady = $hasCompanyProfile
            && $hasBoothProfile
            && $bookingProductsCount > 0
            && $bookingMediaCount > 0;

        $progressPercent = 0;
        $progressPercent += $hasCompanyProfile ? 15 : 0;
        $progressPercent += $hasBoothProfile ? 15 : 0;
        $progressPercent += $bookingProductsCount > 0 ? 15 : 0;
        $progressPercent += $bookingDocumentsCount > 0 ? 10 : 0;
        $progressPercent += $bookingCataloguesCount > 0 ? 10 : 0;
        $progressPercent += $bookingMediaCount > 0 ? 10 : 0;
        $progressPercent += $bookingTeamCount > 0 ? 10 : 0;
        $progressPercent += $bookingMeetingSlotsCount > 0 ? 10 : 0;
        $progressPercent += $previewReady ? 5 : 0;

        $stats = [
            'total_bookings' => $currentCompany->booth_bookings_count,
            'confirmed_bookings' => $confirmedBookings,
            'products_count' => $totalBoothProductsCount,
            'documents_count' => $totalBoothDocumentsCount,
            'catalogues_count' => $totalBoothCataloguesCount,
            'media_count' => $totalBoothMediaCount,
            'meetings_count' => $currentCompany->visitor_meeting_bookings_count,
            'enquiries_count' => $currentCompany->enquiries_count,
            'booth_views_count' => $currentCompany->booth_views_count,
            'total_spend' => $totalSpend,
        ];

        $boothSetup = [
            'has_profile' => $hasBoothProfile,
            'profile_status' => $hasBoothProfile ? 'Completed' : 'Pending',
            'products_count' => $bookingProductsCount,
            'documents_count' => $bookingDocumentsCount,
            'catalogues_count' => $bookingCataloguesCount,
            'media_count' => $bookingMediaCount,
            'team_count' => $bookingTeamCount,
            'meetings_count' => $bookingMeetingSlotsCount,
            'preview_status' => $previewReady ? 'Ready' : 'Not Ready',
            'progress_percent' => min($progressPercent, 100),
        ];

        $hasBookedBooth = (bool) $latestBooking;

        if ($latestBooking) {
            session(['company_booth_booked' => true]);
            session(['company_booking_id' => 'BOOK-' . str_pad((string) $latestBooking->id, 5, '0', STR_PAD_LEFT)]);
        } else {
            session()->forget(['company_booth_booked', 'company_booking_id']);
        }

        return view('company.dashboard.company-dashboard', compact(
            'currentCompany',
            'stats',
            'latestBooking',
            'pendingBooking',
            'recentBookings',
            'recentEnquiries',
            'recentMeetings',
            'boothSetup',
            'hasBookedBooth',
            'performanceData',
            'performanceRange',
        ));
    }

    public function data(): JsonResponse|RedirectResponse
    {
        $companyId = session('company_id');

        if (! $companyId) {
            return redirect('/company/login');
        }

        $currentCompany = $this->companyRepository->findWithCount($companyId, [
            'boothBookings',
            'enquiries',
            'visitorMeetingBookings',
            'boothViews',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
        ]);

        if (! $currentCompany) {
            session()->forget('company_id');

            return redirect('/company/login');
        }

        $latestBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothSessions',
                'boothMeetingSlots',
            ])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->first();

        $pendingBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->latest()
            ->first();

        $dashboardBookings = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothSessions',
                'boothMeetingSlots',
            ])
            ->latest()
            ->get();

        $activeBooking = $latestBooking ?: $pendingBooking;
        $setupProgress = $latestBooking ? $this->setupProgressPercent($currentCompany, $latestBooking) : 0;
        $isBoothLive = $latestBooking && in_array($latestBooking->booth_setup_status, ['published', 'approved', 'live'], true);
        $publicBoothUrl = ($latestBooking && $latestBooking->exhibition)
            ? route('exhibitions.booths.show', [
                $latestBooking->exhibition->slug,
                \Illuminate\Support\Str::slug($latestBooking->boothProfile?->company_name ?: $currentCompany->company_name ?: $currentCompany->name),
            ])
            : null;

        return response()->json([
            'company' => [
                'name' => $currentCompany->company_name ?? $currentCompany->name ?? 'Company',
                'contact_name' => $currentCompany->contact_person_name ?? $currentCompany->owner_name ?? $currentCompany->company_name ?? $currentCompany->name ?? 'Company',
                'email' => $currentCompany->email,
                'status' => ucfirst($currentCompany->status ?? 'pending'),
            ],
            'stats' => [
                'active_bookings' => $currentCompany->boothBookings()->whereIn('booking_status', ['confirmed', 'active'])->count(),
                'setup_progress' => $setupProgress,
                'leads' => $currentCompany->enquiries_count,
                'meetings' => $currentCompany->visitor_meeting_bookings_count,
                'booth_views' => $currentCompany->booth_views_count,
                'total_spend' => (float) $currentCompany->boothBookings()->sum('total_amount'),
                'products' => (int) $currentCompany->booth_products_count,
                'documents' => (int) $currentCompany->booth_documents_count,
                'catalogues' => (int) $currentCompany->booth_catalogues_count,
                'media' => (int) $currentCompany->booth_media_count,
                'team' => (int) ($latestBooking->booth_team_members_count ?? 0),
                'sessions' => (int) ($latestBooking->booth_sessions_count ?? 0),
            ],
            'booking' => $activeBooking ? [
                'id' => 'BOOK-' . str_pad((string) $activeBooking->id, 5, '0', STR_PAD_LEFT),
                'status' => $latestBooking ? 'Approved' : 'Pending Approval',
                'exhibition' => $activeBooking->exhibition?->title,
                'pavilion' => $activeBooking->pavilion?->title,
                'hall' => $activeBooking->hall?->title,
                'booth' => $activeBooking->booth?->booth_number,
                'booth_size' => $activeBooking->boothSize?->title,
                'created_at' => optional($activeBooking->created_at)->format('M d, Y'),
                'setup_url' => $latestBooking ? route('company.booth-setup.index', $latestBooking) : null,
                'public_url' => $isBoothLive ? $publicBoothUrl : null,
                'booth_setup_status' => $latestBooking?->booth_setup_status,
                'is_live' => (bool) $isBoothLive,
            ] : null,
            'bookings' => $dashboardBookings->map(function ($booking) use ($currentCompany) {
                $isApproved = $booking->payment_status === 'paid'
                    && in_array($booking->booking_status, ['confirmed', 'active'], true)
                    && $booking->admin_status === 'approved';
                $isLive = $isApproved && in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true);
                $companyName = $booking->boothProfile?->company_name ?: $currentCompany->company_name ?: $currentCompany->name;
                $publicUrl = ($isLive && $booking->exhibition)
                    ? route('exhibitions.booths.show', [
                        $booking->exhibition->slug,
                        \Illuminate\Support\Str::slug($companyName),
                    ])
                    : null;

                return [
                    'id' => $booking->id,
                    'booking_id' => 'BOOK-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                    'exhibition' => $booking->exhibition?->title,
                    'hall' => $booking->hall?->title,
                    'booth' => $booking->booth?->booth_number,
                    'booth_size' => $booking->boothSize?->title,
                    'status' => $isLive ? 'Live' : ($isApproved ? 'Setup Available' : ucfirst(str_replace('_', ' ', $booking->admin_status ?: $booking->booking_status ?: 'pending'))),
                    'setup_url' => $isApproved ? route('company.booth-setup.index', $booking) : null,
                    'public_url' => $publicUrl,
                    'is_live' => $isLive,
                    'setup_progress' => $isApproved ? $this->setupProgressPercent($currentCompany, $booking) : 0,
                ];
            })->values(),
            'setup_steps' => [
                ['label' => 'Company Profile', 'status' => $currentCompany->isProfileComplete() ? 'Completed' : 'Pending'],
                ['label' => 'Booth Branding', 'status' => $latestBooking?->boothProfile ? 'Completed' : 'Pending'],
                ['label' => 'Products', 'status' => ($latestBooking->booth_products_count ?? 0) > 0 ? 'Completed' : 'Pending'],
                ['label' => 'Documents & Catalogues', 'status' => (($latestBooking->booth_documents_count ?? 0) + ($latestBooking->booth_catalogues_count ?? 0)) > 0 ? 'Completed' : 'Pending'],
                ['label' => 'Preview & Publish', 'status' => in_array($latestBooking?->booth_setup_status, ['ready_to_publish', 'pending_review', 'published', 'approved', 'live'], true) ? 'Completed' : 'Pending'],
            ],
            'links' => [
                'book_booth' => url('/company/exhibitions'),
                'bookings' => url('/company/bookings'),
                'enquiries' => url('/company/enquiries'),
                'analytics' => url('/company/analytics'),
                'profile' => url('/company/profile'),
                'products' => $latestBooking ? route('company.booth-setup.products.index', $latestBooking) : url('/company/exhibitions'),
                'documents' => $latestBooking ? route('company.booth-setup.documents.index', $latestBooking) : url('/company/exhibitions'),
                'meetings' => $latestBooking ? route('company.booth-setup.meetings.edit', $latestBooking) : url('/company/exhibitions'),
                'setup' => $isBoothLive && $publicBoothUrl ? $publicBoothUrl : ($latestBooking ? route('company.booth-setup.index', $latestBooking) : url('/company/exhibitions')),
                'public_booth' => $publicBoothUrl,
            ],
        ]);
    }

    public function analytics(Request $request): View|RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
    {
        $companyId = session('company_id');

        if (! $companyId) {
            return redirect('/company/login');
        }

        $currentCompany = $this->companyRepository->findWithCount($companyId, [
            'boothBookings',
            'products',
            'companyDocuments',
            'catalogues',
            'mediaGalleries',
            'businessCards',
            'companyMeetings',
            'enquiries',
            'visitorMeetingBookings',
            'boothViews',
        ]);

        if (! $currentCompany) {
            session()->forget('company_id');

            return redirect('/company/login');
        }

        $latestBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile', 'boothAnalytics'])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->first();

        // 1. Calculate Date Range
        $rangeOptions = [
            7 => 'Last 7 days',
            30 => 'Last 30 days',
            90 => 'Last 90 days',
        ];
        $selectedRange = array_key_exists((int) $request->query('range', 7), $rangeOptions)
            ? (int) $request->query('range', 7)
            : 7;
        $rangeDateLabels = collect($rangeOptions)->mapWithKeys(function (string $label, int $days) {
            $optionStart = Carbon::today()->subDays($days - 1);
            $optionEnd = Carbon::today();

            return [$days => $optionStart->format('M d') . ' - ' . $optionEnd->format('M d, Y')];
        })->all();

        $startDate = Carbon::today()->subDays($selectedRange - 1);
        $endDate = Carbon::today();
        $dateRangeStr = $startDate->format('M d') . ' - ' . $endDate->format('M d, Y');
        $dateRangeStr = $startDate->format('M d') . ' – ' . $endDate->format('M d, Y');

        $dateRangeStr = $startDate->format('M d') . ' - ' . $endDate->format('M d, Y');

        // Current period (selected range, including today)
        $currentStart = Carbon::today()->subDays($selectedRange - 1)->startOfDay();
        $currentEnd = Carbon::today()->endOfDay();

        // Previous period (same number of days before selected range)
        $previousStart = Carbon::today()->subDays(($selectedRange * 2) - 1)->startOfDay();
        $previousEnd = Carbon::today()->subDays($selectedRange)->endOfDay();

        // 2. Metrics calculation
        // A. Booth Views
        $currentBoothViews = $currentCompany->boothViews()
            ->where(function ($query) use ($currentStart, $currentEnd) {
                $query->whereBetween('viewed_at', [$currentStart, $currentEnd])
                    ->orWhere(function ($fallbackQuery) use ($currentStart, $currentEnd) {
                        $fallbackQuery->whereNull('viewed_at')
                            ->whereBetween('created_at', [$currentStart, $currentEnd]);
                    });
            })
            ->count();
        $previousBoothViews = $currentCompany->boothViews()
            ->where(function ($query) use ($previousStart, $previousEnd) {
                $query->whereBetween('viewed_at', [$previousStart, $previousEnd])
                    ->orWhere(function ($fallbackQuery) use ($previousStart, $previousEnd) {
                        $fallbackQuery->whereNull('viewed_at')
                            ->whereBetween('created_at', [$previousStart, $previousEnd]);
                    });
            })
            ->count();
        $totalBoothViews = $currentCompany->boothViews()->count();

        // B. Product Views
        $totalProductViews = $latestBooking ? (int) $latestBooking->boothProducts()->sum('views') : 0;
        $currentProductViews = $latestBooking
            ? (int) $latestBooking->boothProducts()->whereBetween('created_at', [$currentStart, $currentEnd])->sum('views')
            : 0;
        $previousProductViews = $latestBooking
            ? (int) $latestBooking->boothProducts()->whereBetween('created_at', [$previousStart, $previousEnd])->sum('views')
            : 0;

        // C. Brochure Downloads
        $totalDownloads = $latestBooking 
            ? (int) ($latestBooking->boothDocuments()->sum('downloads') + $latestBooking->boothCatalogues()->sum('downloads'))
            : 0;
        $currentDownloads = $latestBooking
            ? (int) (
                $latestBooking->boothDocuments()->whereBetween('created_at', [$currentStart, $currentEnd])->sum('downloads')
                + $latestBooking->boothCatalogues()->whereBetween('created_at', [$currentStart, $currentEnd])->sum('downloads')
            )
            : 0;
        $previousDownloads = $latestBooking
            ? (int) (
                $latestBooking->boothDocuments()->whereBetween('created_at', [$previousStart, $previousEnd])->sum('downloads')
                + $latestBooking->boothCatalogues()->whereBetween('created_at', [$previousStart, $previousEnd])->sum('downloads')
            )
            : 0;

        // D. Meeting Requests
        $currentMeetings = $currentCompany->visitorMeetingBookings()
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->count();
        $previousMeetings = $currentCompany->visitorMeetingBookings()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();
        $totalMeetings = $currentCompany->visitorMeetingBookings()->count();

        // E. Enquiries
        $currentEnquiries = $currentCompany->enquiries()
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->count();
        $previousEnquiries = $currentCompany->enquiries()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();
        $totalEnquiries = $currentCompany->enquiries()->count();

        // F. Session Attendees
        $boothAnalytics = $latestBooking?->boothAnalytics;
        $totalSessionAttendees = (int) ($boothAnalytics?->session_attendees ?? 0);
        $analyticsUpdatedAt = $boothAnalytics?->updated_at ?? $boothAnalytics?->created_at;
        $currentSessionAttendees = $analyticsUpdatedAt && $analyticsUpdatedAt->between($currentStart, $currentEnd)
            ? $totalSessionAttendees
            : 0;
        $previousSessionAttendees = $analyticsUpdatedAt && $analyticsUpdatedAt->between($previousStart, $previousEnd)
            ? $totalSessionAttendees
            : 0;

        // Calculate comparison trends
        $calcTrend = function ($current, $previous) {
            if ($previous == 0) {
                return [
                    'percent' => $current > 0 ? 100.0 : 0.0,
                    'direction' => 'up',
                    'class' => 'text-[#10B981]',
                    'icon' => 'M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25'
                ];
            }
            $diff = $current - $previous;
            $percent = round(($diff / $previous) * 100, 1);
            if ($diff >= 0) {
                return [
                    'percent' => $percent,
                    'direction' => 'up',
                    'class' => 'text-[#10B981]',
                    'icon' => 'M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25'
                ];
            } else {
                return [
                    'percent' => abs($percent),
                    'direction' => 'down',
                    'class' => 'text-[#EF4444]',
                    'icon' => 'M19.5 4.5l-15 15m0 0h11.25m-11.25 0V8.25'
                ];
            }
        };

        $boothViewsTrend = $calcTrend($currentBoothViews, $previousBoothViews);
        $productViewsTrend = $calcTrend($currentProductViews, $previousProductViews);
        $downloadsTrend = $calcTrend($currentDownloads, $previousDownloads);
        $meetingsTrend = $calcTrend($currentMeetings, $previousMeetings);
        $enquiriesTrend = $calcTrend($currentEnquiries, $previousEnquiries);
        $sessionAttendeesTrend = $calcTrend($currentSessionAttendees, $previousSessionAttendees);

        $compareLabel = 'vs ' . $previousStart->format('M j') . ' – ' . $previousEnd->format('M j');

        $compareLabel = 'vs ' . $previousStart->format('M j') . ' - ' . $previousEnd->format('M j');

        // 3. Traffic Trend Chart Data
        $viewsByDate = $currentCompany->boothViews()
            ->where(function ($query) use ($currentStart) {
                $query->where('viewed_at', '>=', $currentStart)
                    ->orWhere(function ($fallbackQuery) use ($currentStart) {
                        $fallbackQuery->whereNull('viewed_at')
                            ->where('created_at', '>=', $currentStart);
                    });
            })
            ->get()
            ->groupBy(fn ($view) => optional($view->viewed_at ?? $view->created_at)->format('Y-m-d'));

        $labelInterval = max(1, (int) ceil($selectedRange / 7));
        $performanceValues = collect(range(0, $selectedRange - 1))->map(function (int $offset) use ($currentStart, $viewsByDate, $selectedRange, $labelInterval) {
            $date = $currentStart->copy()->addDays($offset);
            return [
                'label' => $date->format('M j'),
                'date' => $date->format('Y-m-d'),
                'value' => $viewsByDate->get($date->format('Y-m-d'), collect())->count(),
                'show_label' => $offset === 0 || $offset === ($selectedRange - 1) || $offset % $labelInterval === 0,
            ];
        });

        $maxPerformanceValue = max((int) $performanceValues->max('value'), 4);
        $pointSpacing = $selectedRange > 1 ? 660 / ($selectedRange - 1) : 0;
        $chartPoints = $performanceValues->values()->map(function (array $item, int $index) use ($maxPerformanceValue, $pointSpacing) {
            $x = 20 + ($index * $pointSpacing);
            $y = 180 - (($item['value'] / $maxPerformanceValue) * 140);
            return [
                'x' => round($x, 2),
                'y' => (int) round($y),
                'label' => $item['label'],
                'value' => $item['value'],
                'show_label' => $item['show_label'],
            ];
        });

        $chartData = [
            'polyline' => $chartPoints->map(fn ($p) => $p['x'] . ',' . $p['y'])->implode(' '),
            'points' => $chartPoints,
            'max_value' => $maxPerformanceValue,
            'y_labels' => collect(range(4, 0))->map(fn (int $step) => (int) round($maxPerformanceValue * $step / 4)),
        ];

        // 4. Top Products
        $topProducts = $currentCompany->boothProducts()
            ->orderByDesc('views')
            ->latest()
            ->take(5)
            ->get();

        // 5. Lead Sources
        $sourceColors = ['#4C1D95', '#3B82F6', '#60A5FA', '#C084FC'];
        $trafficSourceQuery = function () use ($currentCompany, $currentStart, $currentEnd) {
            return $currentCompany->boothViews()
                ->where(function ($query) use ($currentStart, $currentEnd) {
                    $query->whereBetween('viewed_at', [$currentStart, $currentEnd])
                        ->orWhere(function ($fallbackQuery) use ($currentStart, $currentEnd) {
                            $fallbackQuery->whereNull('viewed_at')
                                ->whereBetween('created_at', [$currentStart, $currentEnd]);
                        });
                });
        };
        $registeredViews = (int) $trafficSourceQuery()->whereNotNull('visitor_id')->count();
        $guestViews = (int) $trafficSourceQuery()->whereNull('visitor_id')->count();
        $totalTrafficSourceViews = $registeredViews + $guestViews;
        $totalDistributed = max($totalTrafficSourceViews, 1);

        $leadSources = collect([
            ['name' => 'Registered Visitors', 'count' => $registeredViews],
            ['name' => 'Guest Visitors', 'count' => $guestViews],
        ])->map(function (array $source, int $idx) use ($sourceColors, $totalDistributed) {
            return [
                'name' => $source['name'],
                'percent' => (int) round(($source['count'] / $totalDistributed) * 100),
                'count' => $source['count'],
                'color' => $sourceColors[$idx],
            ];
        })->all();

        // 6. Recent Activities
        $recentEnquiries = $currentCompany->enquiries()
            ->latest()
            ->take(5)
            ->get();

        $recentMeetings = $currentCompany->visitorMeetingBookings()
            ->with(['companyMeeting', 'visitor'])
            ->latest()
            ->take(5)
            ->get();
        $recentBoothViews = $currentCompany->boothViews()
            ->latest()
            ->take(5)
            ->get();
        $recentProducts = $currentCompany->boothProducts()
            ->latest()
            ->take(5)
            ->get();
        $recentDocuments = $currentCompany->boothDocuments()
            ->latest()
            ->take(5)
            ->get();
        $recentCatalogues = $currentCompany->boothCatalogues()
            ->latest()
            ->take(5)
            ->get();

        $activities = collect();
        foreach ($recentEnquiries as $enquiry) {
            $activities->push([
                'title' => "New enquiry from " . ($enquiry->name ?: $enquiry->email),
                'time' => $enquiry->created_at->diffForHumans(),
                'timestamp' => $enquiry->created_at,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>',
                'bg_color' => 'bg-[#EFF6FF] text-[#1D4ED8]',
            ]);
        }
        foreach ($recentMeetings as $meeting) {
            $activities->push([
                'title' => "Meeting requested by " . ($meeting->visitor_name ?: $meeting->visitor_email),
                'time' => $meeting->created_at->diffForHumans(),
                'timestamp' => $meeting->created_at,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"></path></svg>',
                'bg_color' => 'bg-[#ECFDF5] text-[#047857]',
            ]);
        }
        foreach ($recentBoothViews as $view) {
            $activityTime = $view->viewed_at ?? $view->created_at;
            $activities->push([
                'title' => ($view->visitor_id ? 'Registered visitor' : 'Guest visitor') . ' viewed your booth',
                'time' => $activityTime->diffForHumans(),
                'timestamp' => $activityTime,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
                'bg_color' => 'bg-[#F5F3FF] text-[#6D28D9]',
            ]);
        }
        foreach ($recentProducts as $product) {
            $activities->push([
                'title' => 'Product uploaded: ' . $product->name,
                'time' => $product->created_at->diffForHumans(),
                'timestamp' => $product->created_at,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25m0-12L3 7.5m9 5.25v9M3 7.5v9l9 5.25"></path></svg>',
                'bg_color' => 'bg-[#EEF2FF] text-[#4338CA]',
            ]);
        }
        foreach ($recentDocuments as $document) {
            $activities->push([
                'title' => 'Document uploaded: ' . $document->title,
                'time' => $document->created_at->diffForHumans(),
                'timestamp' => $document->created_at,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>',
                'bg_color' => 'bg-[#FEF3C7] text-[#B45309]',
            ]);
        }
        foreach ($recentCatalogues as $catalogue) {
            $activities->push([
                'title' => 'Catalogue uploaded: ' . $catalogue->title,
                'time' => $catalogue->created_at->diffForHumans(),
                'timestamp' => $catalogue->created_at,
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25A8.966 8.966 0 0118 3.75c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path></svg>',
                'bg_color' => 'bg-[#FCE7F3] text-[#BE185D]',
            ]);
        }
        $recentActivities = $activities->sortByDesc('timestamp')->take(5)->values();

        if ($request->query('export') === 'csv') {
            $filename = 'booth-analytics-' . $currentStart->format('Y-m-d') . '-to-' . $currentEnd->format('Y-m-d') . '.csv';

            return response()->streamDownload(function () use (
                $dateRangeStr,
                $compareLabel,
                $totalBoothViews,
                $boothViewsTrend,
                $totalProductViews,
                $productViewsTrend,
                $totalDownloads,
                $downloadsTrend,
                $totalMeetings,
                $meetingsTrend,
                $totalEnquiries,
                $enquiriesTrend,
                $totalSessionAttendees,
                $sessionAttendeesTrend,
                $topProducts,
                $leadSources,
                $recentActivities
            ) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, ['Booth Analytics']);
                fputcsv($handle, ['Date Range', $dateRangeStr]);
                fputcsv($handle, ['Compare Range', $compareLabel]);
                fputcsv($handle, []);
                fputcsv($handle, ['Metric', 'Total', 'Trend Percent', 'Trend Direction']);
                fputcsv($handle, ['Booth Views', $totalBoothViews, $boothViewsTrend['percent'], $boothViewsTrend['direction']]);
                fputcsv($handle, ['Product Views', $totalProductViews, $productViewsTrend['percent'], $productViewsTrend['direction']]);
                fputcsv($handle, ['Brochure Downloads', $totalDownloads, $downloadsTrend['percent'], $downloadsTrend['direction']]);
                fputcsv($handle, ['Meeting Requests', $totalMeetings, $meetingsTrend['percent'], $meetingsTrend['direction']]);
                fputcsv($handle, ['Enquiries', $totalEnquiries, $enquiriesTrend['percent'], $enquiriesTrend['direction']]);
                fputcsv($handle, ['Session Attendees', $totalSessionAttendees, $sessionAttendeesTrend['percent'], $sessionAttendeesTrend['direction']]);

                fputcsv($handle, []);
                fputcsv($handle, ['Top Products']);
                fputcsv($handle, ['Product', 'Views']);
                foreach ($topProducts as $product) {
                    fputcsv($handle, [$product->name, $product->views]);
                }

                fputcsv($handle, []);
                fputcsv($handle, ['Traffic Sources']);
                fputcsv($handle, ['Source', 'Percent', 'Count']);
                foreach ($leadSources as $source) {
                    fputcsv($handle, [$source['name'], $source['percent'], $source['count']]);
                }

                fputcsv($handle, []);
                fputcsv($handle, ['Recent Activities']);
                fputcsv($handle, ['Activity', 'Time']);
                foreach ($recentActivities as $activity) {
                    fputcsv($handle, [$activity['title'], $activity['time']]);
                }

                fclose($handle);
            }, $filename, ['Content-Type' => 'text/csv']);
        }

        return view('company.analytics.company-analytics', compact(
            'currentCompany',
            'latestBooking',
            'rangeOptions',
            'rangeDateLabels',
            'selectedRange',
            'dateRangeStr',
            'compareLabel',
            'totalBoothViews',
            'boothViewsTrend',
            'totalProductViews',
            'productViewsTrend',
            'totalDownloads',
            'downloadsTrend',
            'totalMeetings',
            'meetingsTrend',
            'totalEnquiries',
            'enquiriesTrend',
            'totalSessionAttendees',
            'sessionAttendeesTrend',
            'chartData',
            'topProducts',
            'leadSources',
            'totalTrafficSourceViews',
            'recentActivities'
        ));
    }

    private function setupProgressPercent(Company $company, $booking): int
    {
        $progress = 0;
        $progress += $company->isProfileComplete() ? 15 : 0;
        $progress += $booking->boothProfile ? 15 : 0;
        $progress += ($booking->booth_products_count ?? 0) > 0 ? 15 : 0;
        $progress += ($booking->booth_documents_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_catalogues_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_media_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_team_members_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_meeting_slots_count ?? 0) > 0 ? 10 : 0;
        $progress += in_array($booking->booth_setup_status, ['ready_to_publish', 'pending_review', 'published', 'approved', 'live'], true) ? 5 : 0;

        return min($progress, 100);
    }
}
