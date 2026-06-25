<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BookingService;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothBookingDay;
use App\Domain\Booth\Models\BoothBookingSummary;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Support\LiveContent;
use App\Domain\Company\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyBoothBookingController extends Controller
{
    public function pavilions(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $search = trim((string) $request->query('search', ''));
        $viewMode = in_array($request->query('view'), ['grid', 'list', 'compact'], true)
            ? $request->query('view')
            : 'grid';
        $selectedExhibition = $this->resolveBookingExhibition($request, false, false);

        $pavilions = Pavilion::query()
            ->with([
                'exhibition:id,title,slug,status',
                'halls' => function ($query) {
                    $query->where('status', 'active')->withCount('booths');
                }
            ])
            ->withCount([
                'halls' => function ($query) {
                    $query->where('status', 'active');
                },
                'boothBookings'
            ])
            ->when(
                $selectedExhibition,
                fn ($query) => $query->where('exhibition_id', $selectedExhibition->id),
                fn ($query) => $query->whereIn('exhibition_id', LiveContent::liveExhibitionIds())
            )
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('exhibition', function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%")
                                ->orWhere('slug', 'like', "%{$search}%");
                        });
                });
            })
            ->where('status', 'active')
            ->latest()
            ->get();

        $totalPavilions = $pavilions->count();
        $totalHalls = $pavilions->sum('halls_count');
        $totalBooths = $pavilions->sum(function ($pavilion) {
            return $pavilion->halls->sum('booths_count');
        });

        return view('company.booth-booking.pavilions', compact(
            'pavilions',
            'search',
            'viewMode',
            'totalPavilions',
            'totalHalls',
            'totalBooths',
            'selectedExhibition',
        ));
    }

    public function halls(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $search = trim((string) $request->query('search', ''));
        $pavilionId = $request->query('pavilion');
        $selectedPavilion = $pavilionId ? Pavilion::with('exhibition')->find($pavilionId) : null;
        $requestedExhibition = $this->resolveBookingExhibition($request, false, false);
        $selectedExhibition = $requestedExhibition ?: $selectedPavilion?->exhibition ?: $this->resolveBookingExhibition($request);

        if ($selectedExhibition) {
            session([
                'company_booth_booking' => array_merge(session('company_booth_booking', []), [
                    'exhibition_id' => $selectedExhibition->id,
                    'exhibition_slug' => $selectedExhibition->slug,
                ]),
            ]);
        }

        if (! $selectedExhibition) {
            return redirect()->route('company.exhibitions.index')
                ->with('status', 'Please select an exhibition to book a booth.');
        }

        if ($selectedPavilion && $selectedExhibition && (int) $selectedPavilion->exhibition_id !== (int) $selectedExhibition->id) {
            return redirect()->route('company.booth-booking.pavilions', ['exhibition' => $selectedExhibition->slug])
                ->with('status', 'Selected pavilion does not belong to this exhibition.');
        }
        $filter = in_array($request->query('filter'), ['all', 'available'], true)
            ? $request->query('filter')
            : 'all';

        $hallsQuery = Hall::query()
            ->with('pavilion:id,exhibition_id,title,slug,image')
            ->withCount([
                'booths',
                'boothBookings',
                'booths as available_booths_count' => function ($query) {
                    $query->where('status', 'available');
                },
            ])
            ->when($selectedPavilion, function ($query) use ($selectedPavilion) {
                $query->where('pavilion_id', $selectedPavilion->id);
            })
            ->when($selectedExhibition && ! $selectedPavilion, function ($query) use ($selectedExhibition) {
                $query->whereHas('pavilion', fn ($builder) => $builder->where('exhibition_id', $selectedExhibition->id));
            })
            ->when(! $selectedExhibition && ! $selectedPavilion, function ($query) {
                $query->whereHas('pavilion', fn ($builder) => $builder->whereIn('exhibition_id', LiveContent::liveExhibitionIds()));
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('total_booths', 'like', "%{$search}%")
                        ->orWhereHas('pavilion', function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%")
                                ->orWhere('slug', 'like', "%{$search}%");
                        });
                });
            })
            ->where('status', 'active')
            ->latest();

        $allMatchingHalls = $hallsQuery->get();

        $availableBoothCount = function ($hall) {
            $totalBooths = (int) ($hall->total_booths ?: $hall->booths_count);

            return $hall->available_booths_count ?: max($totalBooths - (int) $hall->booth_bookings_count, 0);
        };


        $halls = $allMatchingHalls
            ->when($filter === 'available', function ($halls) use ($availableBoothCount) {
                return $halls->filter(fn ($hall) => $availableBoothCount($hall) > 0);
            })

            ->values();

        $allCount = $allMatchingHalls->count();
        $availableCount = $allMatchingHalls->filter(fn ($hall) => $availableBoothCount($hall) > 0)->count();

        return view('company.booth-booking.halls', compact(
            'halls',
            'selectedPavilion',
            'selectedExhibition',
            'search',
            'filter',
            'allCount',
            'availableCount',
        ));
    }

    public function floorPlan(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $bookingDraft = session('company_booth_booking', []);
        $hallId = $request->query('hall') ?: ($bookingDraft['hall_id'] ?? null);
        $sizeId = $request->query('size') ?: ($bookingDraft['booth_size_id'] ?? null);
        $boothId = $request->query('booth') ?: ($bookingDraft['booth_id'] ?? null);

        $hall = Hall::query()
            ->with(['pavilion:id,exhibition_id,title,slug,image', 'booths.boothSize'])
            ->when($hallId, function ($query) use ($hallId) {
                $query->whereKey($hallId);
            })
            ->where('status', 'active')
            ->first();

        if (! $hall) {
            return redirect('/company/booth-booking/halls')
                ->with('status', 'Please select a hall before opening the layout.');
        }

        if ($redirect = $this->ensureHallMatchesBookingExhibition($hall)) {
            return $redirect;
        }

        $hall->load('booths.boothSize');
        $layoutBooths = $hall->booths
            ->sortBy(function ($booth) {
                $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
            })
            ->values();
        $occupiedBoothIds = $this->bookedBoothGroupsForHall($hall, $layoutBooths)
            ->flatMap(fn (array $group) => $group['booth_ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($occupiedBoothIds->isNotEmpty()) {
            \App\Domain\Booth\Models\Booth::whereIn('id', $occupiedBoothIds)->where('status', 'available')->update(['status' => 'booked']);
        }
        $hall->booths()
            ->when($occupiedBoothIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $occupiedBoothIds))
            ->whereIn('status', ['booked', 'reserved'])
            ->update(['status' => 'available']);
        $hall->load('booths.boothSize');

        $selectedSize = $sizeId
            ? $this->allowedBoothSizesForHall($hall)->firstWhere('id', (int) $sizeId)
            : null;

        $booths = $hall->booths
            ->sortBy(function ($booth) {
                $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
            })
            ->values();

        $selectedBooth = $boothId
            ? $booths->firstWhere('id', (int) $boothId)
            : null;

        if (! $selectedBooth) {
            $selectedBooth = $booths->first(fn ($booth) => $booth->status === 'available')
                ?? $booths->first();
        }

        $totalBooths = $booths->count();
        $availableCount = $booths->filter(fn ($booth) => $booth->status === 'available')->count();
        $bookedCount = $booths->filter(fn ($booth) => $booth->status === 'booked')->count();
        $reservedCount = $booths->filter(fn ($booth) => $booth->status === 'reserved')->count();
        $selectedCount = $selectedBooth ? 1 : 0;
        $bookedBoothGroups = $this->bookedBoothGroupsForHall($hall, $booths);
        $groupedBookedBoothIds = $bookedBoothGroups
            ->flatMap(fn (array $group) => $group['booth_ids'])
            ->unique()
            ->values()
            ->all();
        $bookedCount = count($groupedBookedBoothIds);
        $reservedCount = 0;
        $availableCount = max($totalBooths - $bookedCount, 0);
        $currentCompany = Company::find((int) session('company_id'));
        $requiredSpaces = $this->boothUnitsForSize($selectedSize);

        if (! $request->query('booth') && $selectedSize) {
            $selectedBooth = $booths
                ->sortBy(function ($booth) {
                    $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                    return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
                })
                ->where('status', 'available')
                ->reject(fn ($booth) => in_array($booth->id, $groupedBookedBoothIds, true))
                ->first(fn ($booth) => $this->boothFootprintForSize($hall, $booth, $selectedSize, $groupedBookedBoothIds)->count() >= $requiredSpaces)
                ?? $booths->first(fn ($booth) => $booth->status === 'available' && ! in_array($booth->id, $groupedBookedBoothIds, true));
        }

        $selectedFootprint = ($selectedBooth && $selectedSize && $selectedBooth->status === 'available' && ! in_array($selectedBooth->id, $groupedBookedBoothIds, true))
            ? $this->boothFootprintForSize($hall, $selectedBooth, $selectedSize, $groupedBookedBoothIds)
            : collect();
        $hasEnoughSelectedSpaces = $selectedFootprint->count() >= $requiredSpaces;
        $selectedFootprintIds = $selectedFootprint->pluck('id')->all();
        $selectedArea = (float) ($selectedSize
            ? ($selectedSize->area ?: ((float) $selectedSize->width * (float) $selectedSize->height) ?: ($requiredSpaces * 9))
            : ($selectedBooth?->boothSize?->area ?: 9));
        $selectedVisual = \App\Support\BoothFloorMap::visualForArea($selectedArea);
        $selectedSpaceBounds = \App\Support\BoothFloorMap::boundsForFootprint($selectedFootprint);
        $selectedSpaceSegments = \App\Support\BoothFloorMap::segmentsForFootprint($selectedFootprint);
        $selectedSpaceNumbers = $selectedFootprint->pluck('booth_number')->values()->all();
        $availableFootprints = $booths
            ->where('status', 'available')
            ->mapWithKeys(function ($booth) use ($hall, $selectedSize, $groupedBookedBoothIds) {
                $footprint = $this->boothFootprintForSize($hall, $booth, $selectedSize, $groupedBookedBoothIds);
                $bounds = \App\Support\BoothFloorMap::boundsForFootprint($footprint);

                return [
                    $booth->id => [
                        'ids' => $footprint->pluck('id')->values()->all(),
                        'numbers' => $footprint->pluck('booth_number')->values()->all(),
                        'left' => $bounds['left'],
                        'top' => $bounds['top'],
                        'width' => $bounds['width'],
                        'height' => $bounds['height'],
                        'segments' => \App\Support\BoothFloorMap::segmentsForFootprint($footprint),
                    ],
                ];
            });

        // Whether the selected booth size can actually fit anywhere in this hall.
        // True when no multi-unit size is chosen, or at least one available booth
        // can anchor a continuous group large enough for the required units.
        $sizeAvailableInHall = ! $selectedSize || $requiredSpaces <= 1
            ? true
            : $availableFootprints->contains(fn ($footprint) => count($footprint['ids'] ?? []) >= $requiredSpaces);

        return view('company.booth-booking.floor-plan', compact(
            'hall',
            'booths',
            'selectedBooth',
            'totalBooths',
            'availableCount',
            'bookedCount',
            'reservedCount',
            'selectedCount',
            'selectedSize',
            'bookedBoothGroups',
            'groupedBookedBoothIds',
            'currentCompany',
            'selectedFootprint',
            'selectedFootprintIds',
            'requiredSpaces',
            'hasEnoughSelectedSpaces',
            'sizeAvailableInHall',
            'selectedVisual',
            'selectedSpaceBounds',
            'selectedSpaceSegments',
            'selectedSpaceNumbers',
            'availableFootprints',
        ));
    }

    public function selectBooth(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = Hall::with('pavilion.exhibition')->where('status', 'active')->findOrFail($validated['hall_id']);
        if ($redirect = $this->ensureHallMatchesBookingExhibition($hall)) {
            return $redirect;
        }
        $booth = $hall->booths()->findOrFail($validated['booth_id']);

        if ($booth->status !== 'available') {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $validated['size_id'] ?? null,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Please select an available booth.');
        }

        $selectedSize = ! empty($validated['size_id'])
            ? $this->allowedBoothSizesForHall($hall)->firstWhere('id', (int) $validated['size_id'])
            : $booth->boothSize;

        if (! empty($validated['size_id']) && ! $selectedSize) {
            return redirect('/company/booth-booking/sizes?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Please select a booth size that is configured for this hall.');
        }

        $blockedBoothIds = $this->bookedBoothGroupsForHall($hall, $hall->booths()->with('boothSize')->get())
            ->flatMap(fn (array $group) => $group['booth_ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $selectedBooths = $this->boothFootprintForSize($hall, $booth, $selectedSize, $blockedBoothIds);

        if ($selectedBooths->count() < $this->boothUnitsForSize($selectedSize)) {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $selectedSize?->id,
                'booth' => $booth->id,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Not enough connected booth boxes are available for this booth size. Please choose another starting booth.');
        }

        $bookingDraft = session('company_booth_booking', []);

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'exhibition_slug' => $hall->pavilion?->exhibition?->slug ?: ($bookingDraft['exhibition_slug'] ?? null),
                'booth_id' => $booth->id,
                'selected_booth_ids' => $selectedBooths->pluck('id')->values()->all(),
                'booth_size_id' => $selectedSize?->id,
                'slots' => [],
                'slots_subtotal' => 0,
            ])),
        ]);

        return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
            'hall' => $hall->id,
            'booth' => $booth->id,
            'size' => $selectedSize?->id,
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])));
    }

    public function sizes(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $bookingDraft = session('company_booth_booking', []);
        $hallId = $request->query('hall') ?: ($bookingDraft['hall_id'] ?? null);
        $selectedSizeId = $request->query('size') ?: ($bookingDraft['booth_size_id'] ?? null);

        $hall = $hallId
            ? Hall::with('pavilion.exhibition')->find($hallId)
            : null;

        if ($hall && ($redirect = $this->ensureHallMatchesBookingExhibition($hall))) {
            return $redirect;
        }

        $boothSizes = $hall
            ? $this->allowedBoothSizesForHall($hall)
            : BoothSize::where('status', 'active')
                ->orderBy('area')
                ->get();

        $selectedSize = $selectedSizeId
            ? $boothSizes->firstWhere('id', (int) $selectedSizeId)
            : $boothSizes->first();

        $boothSizes = $boothSizes
            ->groupBy(fn (BoothSize $size) => \App\Support\BoothFloorMap::unitsForSize($size))
            ->map(fn ($sizes) => $selectedSize && $sizes->contains('id', $selectedSize->id) ? $selectedSize : $sizes->first())
            ->sortBy(fn (BoothSize $size) => \App\Support\BoothFloorMap::unitsForSize($size))
            ->values();

        if ($hall || $selectedSize) {
            $hallExId = $hall?->pavilion?->exhibition_id;
            $hallExSlug = $hall?->pavilion?->exhibition?->slug;
            session([
                'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                    'hall_id' => $hall?->id,
                    'booth_size_id' => $selectedSize?->id,
                    'exhibition_id' => $hallExId ?: ($bookingDraft['exhibition_id'] ?? null),
                    'exhibition_slug' => $hallExSlug ?: ($bookingDraft['exhibition_slug'] ?? null),
                ])),
            ]);
        }

        return view('company.booth-booking.sizes', compact(
            'hall',
            'boothSizes',
            'selectedSize',
        ));
    }

    public function selectSize(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['nullable', 'integer', 'exists:halls,id'],
            'size_id' => ['required', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = ! empty($validated['hall_id'])
            ? Hall::with('pavilion.exhibition')->where('status', 'active')->find($validated['hall_id'])
            : null;
        $size = $hall
            ? $this->allowedBoothSizesForHall($hall)->firstWhere('id', (int) $validated['size_id'])
            : BoothSize::where('status', 'active')->findOrFail($validated['size_id']);

        $bookingDraft = session('company_booth_booking', []);
        if ($hall) {
            if ($redirect = $this->ensureHallMatchesBookingExhibition($hall)) {
                return $redirect;
            }
        }

        if (! $size) {
            return redirect('/company/booth-booking/sizes?' . http_build_query(array_filter([
                'hall' => $hall?->id,
                'exhibition' => $hall?->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Please select a booth size that is configured for this hall.');
        }

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall?->id,
                'booth_size_id' => $size->id,
                'booth_id' => null,
                'slots' => [],
                'slots_subtotal' => 0,
                'exhibition_id' => $hall?->pavilion?->exhibition_id ?: ($bookingDraft['exhibition_id'] ?? null),
                'exhibition_slug' => $hall?->pavilion?->exhibition?->slug ?: ($bookingDraft['exhibition_slug'] ?? null),
            ])),
        ]);

        $exSlug = session('company_booth_booking.exhibition_slug');
        if ($hall) {
            $hall->loadMissing('pavilion.exhibition');
            if ($hall->pavilion?->exhibition) {
                $exSlug = $hall->pavilion->exhibition->slug;
            }
        }

        return redirect('/company/booth-booking/sizes?' . http_build_query(array_filter([
            'hall' => $hall?->id,
            'size' => $size->id,
            'exhibition' => $exSlug,
        ])));
    }

    public function continueFromSizes(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'size_id' => ['required', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = Hall::with('pavilion.exhibition')->where('status', 'active')->findOrFail($validated['hall_id']);
        if ($redirect = $this->ensureHallMatchesBookingExhibition($hall)) {
            return $redirect;
        }

        $size = $this->allowedBoothSizesForHall($hall)->firstWhere('id', (int) $validated['size_id']);
        if (! $size) {
            return redirect('/company/booth-booking/sizes?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Please select a booth size that is configured for this hall.');
        }

        $bookingDraft = session('company_booth_booking', []);

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'booth_size_id' => $size->id,
                'booth_id' => null,
                'slots' => [],
                'slots_subtotal' => 0,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'exhibition_slug' => $hall->pavilion?->exhibition?->slug,
            ])),
        ]);

        return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
            'hall' => $hall->id,
            'size' => $size->id,
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])));
    }

    public function requestCustomSize(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'hall_id' => ['nullable', 'integer', 'exists:halls,id'],
        ]);

        $hall = ! empty($validated['hall_id'])
            ? Hall::where('status', 'active')->find($validated['hall_id'])
            : null;

        session([
            'company_booth_booking' => array_filter(array_merge(session('company_booth_booking', []), [
                'hall_id' => $hall?->id,
                'custom_size_requested' => true,
            ])),
        ]);

        $exSlug = session('company_booth_booking.exhibition_slug');
        if ($hall) {
            $hall->loadMissing('pavilion.exhibition');
            if ($hall->pavilion?->exhibition) {
                $exSlug = $hall->pavilion->exhibition->slug;
            }
        }
        $queryParams = array_filter([
            'pavilion' => $hall?->pavilion_id,
            'exhibition' => $exSlug,
        ]);

        return redirect('/company/booth-booking/halls' . (!empty($queryParams) ? '?' . http_build_query($queryParams) : ''))
            ->with('status', 'Custom booth size request noted. Please contact the event team for tailored booth options.');
    }

    public function slots(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $bookingDraft = session('company_booth_booking', []);
        $hallId = $request->query('hall') ?: ($bookingDraft['hall_id'] ?? null);
        $boothId = $request->query('booth') ?: ($bookingDraft['booth_id'] ?? null);
        $sizeId = $request->query('size') ?: ($bookingDraft['booth_size_id'] ?? null);

        $hall = $hallId
            ? Hall::with('pavilion.exhibition')->find($hallId)
            : null;

        if (! $hall) {
            return redirect('/company/booth-booking/halls')
                ->with('status', 'Please select a hall before booking booth days.');
        }

        $booth = $boothId
            ? $hall->booths()->find($boothId)
            : null;

        if (! $booth || $booth->status !== 'available') {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $sizeId,
            ])))->with('status', 'Please select an available booth before booking booth days.');
        }

        if (empty($bookingDraft['booth_booking_id']) || empty($bookingDraft['slots'])) {
            $draftBooking = BoothBooking::with('days')
                ->where('company_id', (int) session('company_id'))
                ->where('booth_id', $booth->id)
                ->where('booking_status', 'draft')
                ->latest()
                ->first();

            if ($draftBooking && $draftBooking->days->isNotEmpty()) {
                $bookingDraft = array_filter(array_merge($bookingDraft, [
                    'booth_booking_id' => $draftBooking->id,
                    'hall_id' => $draftBooking->hall_id,
                    'pavilion_id' => $draftBooking->pavilion_id,
                    'exhibition_id' => $draftBooking->exhibition_id,
                    'booth_id' => $draftBooking->booth_id,
                    'selected_booth_ids' => $draftBooking->selected_booth_ids ?: [$draftBooking->booth_id],
                    'booth_size_id' => $draftBooking->booth_size_id,
                    'slots' => $draftBooking->days->sortBy('booking_date')->map(fn ($day) => [
                        'key' => $day->booking_date->toDateString() . '|full-day',
                        'date' => $day->booking_date->toDateString(),
                        'date_label' => $day->label ?: $day->booking_date->format('M d, D'),
                        'time' => 'full-day',
                        'label' => 'Full Day',
                        'price' => (float) $day->price,
                    ])->values()->all(),
                    'booking_days_count' => $draftBooking->days->count(),
                    'slots_subtotal' => $draftBooking->days->sum('price'),
                ]));
            }
        }

        $selectedSize = $sizeId
            ? BoothSize::where('status', 'active')->find($sizeId)
            : $booth->boothSize;
        $slotPrice = 1999;
        $requestedDays = (int) ($bookingDraft['booking_days_count'] ?? 0);
        $slotGroups = $this->slotGroupsForHall($hall, $slotPrice, $requestedDays > 0 ? $requestedDays : null);
        $validSlotKeys = collect($slotGroups)
            ->flatMap(fn ($group) => $group['slots'])
            ->pluck('key')
            ->all();
        $draftBookingId = $bookingDraft['booth_booking_id'] ?? null;
        $bookedDayKeys = BoothBookingDay::query()
            ->where('booth_id', $booth->id)
            ->when($draftBookingId, fn ($query) => $query->where('booth_booking_id', '!=', $draftBookingId))
            ->whereIn('booking_date', collect($slotGroups)->pluck('date')->all())
            ->pluck('booking_date')
            ->map(fn ($date) => $date . '|full-day')
            ->all();
        $selectedSlots = collect($bookingDraft['slots'] ?? [])
            ->filter(fn ($slot) => isset($slot['key'])
                && in_array($slot['key'], $validSlotKeys, true)
                && ! in_array($slot['key'], $bookedDayKeys, true))
            ->values();
        $selectedSlotKeys = $selectedSlots->pluck('key')->all();
        $slotsSubtotal = $selectedSlots->sum('price');
        $selectedDaysCount = $selectedSlots->count();
        $bookingDaysCount = max($requestedDays, $selectedDaysCount, 1);
        $bookingDraft = $this->syncDraftBooking($hall, $booth, $selectedSize, $selectedSlots, array_merge($bookingDraft, [
            'booking_days_count' => $bookingDaysCount,
        ]));

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'booth_id' => $booth->id,
                'booth_size_id' => $selectedSize?->id,
                'slot_price' => $slotPrice,
                'booking_days_count' => $bookingDaysCount,
                'booth_booking_id' => $bookingDraft['booth_booking_id'] ?? null,
                'slots' => $selectedSlots->all(),
                'slots_subtotal' => $slotsSubtotal,
            ])),
        ]);

        return view('company.booth-booking.slots', compact(
            'hall',
            'booth',
            'selectedSize',
            'slotGroups',
            'slotPrice',
            'selectedSlots',
            'selectedSlotKeys',
            'bookedDayKeys',
            'slotsSubtotal',
            'bookingDaysCount',
        ));
    }

    public function updateDays(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
            'days_count' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        $hall = Hall::with('pavilion.exhibition')->findOrFail($validated['hall_id']);
        $booth = $hall->booths()
            ->whereKey($validated['booth_id'])
            ->where('status', 'available')
            ->firstOrFail();
        $slotGroups = $this->slotGroupsForHall($hall, 1999, (int) $validated['days_count']);
        $bookedDates = BoothBookingDay::query()
            ->where('booth_id', $booth->id)
            ->whereIn('booking_date', collect($slotGroups)->pluck('date')->all())
            ->pluck('booking_date')
            ->all();
        $selectedSlots = collect($slotGroups)
            ->flatMap(fn ($group) => $group['slots'])
            ->reject(fn ($slot) => in_array($slot['date'], $bookedDates, true))
            ->values();

        $bookingDraft = array_filter(array_merge(session('company_booth_booking', []), [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'booth_id' => $booth->id,
                'booth_size_id' => $validated['size_id'] ?? null,
                'slot_price' => 1999,
                'booking_days_count' => (int) $validated['days_count'],
                'slots' => $selectedSlots->all(),
                'slots_subtotal' => $selectedSlots->sum('price'),
        ]));

        $bookingDraft = $this->syncDraftBooking(
            $hall,
            $booth,
            $validated['size_id'] ? BoothSize::find($validated['size_id']) : null,
            $selectedSlots,
            $bookingDraft
        );

        session(['company_booth_booking' => array_filter(array_merge($bookingDraft, [
            'slots' => $selectedSlots->all(),
            'slots_subtotal' => $selectedSlots->sum('price'),
        ]))]);

        $message = $selectedSlots->count() < (int) $validated['days_count']
            ? 'Some days are already booked, so only available days were selected.'
            : 'Booking days updated. Amount recalculated.';

        return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
            'hall' => $hall->id,
            'booth' => $booth->id,
            'size' => $validated['size_id'] ?? null,
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])))->with('status', $message);
    }

    public function selectSlot(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
            'slot_key' => ['required', 'string'],
        ]);

        $hall = Hall::with('pavilion.exhibition')->findOrFail($validated['hall_id']);
        $boothIsAvailableForHall = $hall->booths()
            ->whereKey($validated['booth_id'])
            ->where('status', 'available')
            ->exists();

        if (! $boothIsAvailableForHall) {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $validated['size_id'] ?? null,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->with('status', 'Please select an available booth before booking booth days.');
        }

        $bookingDraft = session('company_booth_booking', []);
        $requestedDays = (int) ($bookingDraft['booking_days_count'] ?? 0);
        $slot = collect($this->slotGroupsForHall($hall, 1999, $requestedDays > 0 ? $requestedDays : null))
            ->flatMap(fn ($group) => $group['slots'])
            ->firstWhere('key', $validated['slot_key']);

        if (! $slot) {
            return redirect()->back()->withErrors(['slot_key' => 'Selected day is not available.']);
        }

        $isDayAlreadyBooked = BoothBookingDay::query()
            ->where('booth_id', (int) $validated['booth_id'])
            ->whereDate('booking_date', $slot['date'])
            ->when($bookingDraft['booth_booking_id'] ?? null, fn ($query, $bookingId) => $query->where('booth_booking_id', '!=', $bookingId))
            ->exists();

        if ($isDayAlreadyBooked) {
            return redirect()->back()->withErrors(['slot_key' => 'This booth is already booked for the selected day.']);
        }

        $selectedSlots = collect($bookingDraft['slots'] ?? []);
        $alreadySelected = $selectedSlots->contains(fn ($item) => ($item['key'] ?? null) === $slot['key']);
        $selectedSlots = $alreadySelected
            ? $selectedSlots->reject(fn ($item) => ($item['key'] ?? null) === $slot['key'])->values()
            : $selectedSlots->push($slot)->values();

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'booth_id' => (int) $validated['booth_id'],
                'booth_size_id' => $validated['size_id'] ?? ($bookingDraft['booth_size_id'] ?? null),
                'slots' => $selectedSlots->all(),
                'booking_days_count' => max($selectedSlots->count(), 1),
                'slots_subtotal' => $selectedSlots->sum('price'),
            ])),
        ]);

        $booth = $hall->booths()->findOrFail($validated['booth_id']);
        $selectedSize = ! empty($validated['size_id']) ? BoothSize::find($validated['size_id']) : null;
        $bookingDraft = $this->syncDraftBooking($hall, $booth, $selectedSize, $selectedSlots, session('company_booth_booking', []));
        session(['company_booth_booking' => array_filter(array_merge($bookingDraft, [
            'slots' => $selectedSlots->all(),
            'booking_days_count' => max($selectedSlots->count(), 1),
            'slots_subtotal' => $selectedSlots->sum('price'),
        ]))]);

        return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
            'hall' => $hall->id,
            'booth' => $validated['booth_id'],
            'size' => $validated['size_id'] ?? null,
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])));
    }

    public function continueFromSlots(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
            'days_count' => ['nullable', 'integer', 'min:1', 'max:60'],
        ]);

        $bookingDraft = session('company_booth_booking', []);
        $draftBooking = ! empty($bookingDraft['booth_booking_id'])
            ? BoothBooking::with('days')
                ->where('company_id', (int) session('company_id'))
                ->find($bookingDraft['booth_booking_id'])
            : null;
        $hall = Hall::with('pavilion.exhibition')->findOrFail($validated['hall_id']);
        $booth = $hall->booths()->findOrFail($validated['booth_id']);
        $selectedSize = ! empty($validated['size_id']) ? BoothSize::find($validated['size_id']) : null;

        if (! empty($validated['days_count'])) {
            $slotGroups = $this->slotGroupsForHall($hall, 1999, (int) $validated['days_count']);
            $bookedDates = BoothBookingDay::query()
                ->where('booth_id', $booth->id)
                ->when($bookingDraft['booth_booking_id'] ?? null, fn ($query, $bookingId) => $query->where('booth_booking_id', '!=', $bookingId))
                ->whereIn('booking_date', collect($slotGroups)->pluck('date')->all())
                ->pluck('booking_date')
                ->all();
            $selectedSlots = collect($slotGroups)
                ->flatMap(fn ($group) => $group['slots'])
                ->reject(fn ($slot) => in_array($slot['date'], $bookedDates, true))
                ->values();
        } else {
            $selectedSlots = collect($bookingDraft['slots'] ?? []);
        }

        if ($draftBooking && $draftBooking->days->count() > $selectedSlots->count()) {
            $selectedSlots = $draftBooking->days->sortBy('booking_date')->map(fn ($day) => [
                'key' => $day->booking_date->toDateString() . '|full-day',
                'date' => $day->booking_date->toDateString(),
                'date_label' => $day->label ?: $day->booking_date->format('M d, D'),
                'time' => 'full-day',
                'label' => 'Full Day',
                'price' => (float) $day->price,
            ])->values();
        }

        if ($selectedSlots->isEmpty()) {
            return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
                'hall' => $validated['hall_id'],
                'booth' => $validated['booth_id'],
                'size' => $validated['size_id'] ?? null,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->withErrors(['slots' => 'Please select at least one day to continue.']);
        }

        $bookingDraft = $this->syncDraftBooking($hall, $booth, $selectedSize, $selectedSlots, array_filter(array_merge($bookingDraft, [
            'hall_id' => (int) $validated['hall_id'],
            'booth_id' => (int) $validated['booth_id'],
            'booth_size_id' => $validated['size_id'] ?? ($bookingDraft['booth_size_id'] ?? null),
            'booking_days_count' => ! empty($validated['days_count']) ? (int) $validated['days_count'] : max($selectedSlots->count(), 1),
            'slots_subtotal' => $selectedSlots->sum('price'),
        ])));

        session(['company_booth_booking' => array_filter(array_merge($bookingDraft, [
            'slots' => $selectedSlots->all(),
            'booking_days_count' => ! empty($validated['days_count']) ? (int) $validated['days_count'] : max($selectedSlots->count(), 1),
            'slots_subtotal' => $selectedSlots->sum('price'),
        ]))]);

        return redirect('/company/booth-booking/summary?' . http_build_query(array_filter([
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])));
    }

    public function summary(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $bookingDraft = session('company_booth_booking', []);
        $sessionSlots = collect($bookingDraft['slots'] ?? [])->filter(fn ($slot) => isset($slot['date'], $slot['price']))->values();
        $booking = ! empty($bookingDraft['booth_booking_id'])
            ? BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days'])
                ->where('company_id', (int) session('company_id'))
                ->find($bookingDraft['booth_booking_id'])
            : null;

        if ($booking && $booking->days->count() > $sessionSlots->count()) {
            $sessionSlots = $booking->days->sortBy('booking_date')->map(fn ($day) => [
                'key' => $day->booking_date->toDateString() . '|full-day',
                'date' => $day->booking_date->toDateString(),
                'date_label' => $day->label ?: $day->booking_date->format('M d, D'),
                'time' => 'full-day',
                'label' => 'Full Day',
                'price' => (float) $day->price,
            ])->values();
        }

        if ((! $booking || $booking->days->count() < $sessionSlots->count()) && $sessionSlots->isNotEmpty()) {
            $hall = ! empty($bookingDraft['hall_id'])
                ? Hall::with('pavilion.exhibition')->find($bookingDraft['hall_id'])
                : null;
            $booth = ! empty($bookingDraft['booth_id'])
                ? \App\Domain\Booth\Models\Booth::find($bookingDraft['booth_id'])
                : null;
            $selectedSize = ! empty($bookingDraft['booth_size_id'])
                ? BoothSize::find($bookingDraft['booth_size_id'])
                : null;

            if ($hall && $booth) {
                $bookingDraft = $this->syncDraftBooking($hall, $booth, $selectedSize, $sessionSlots, $bookingDraft);
                session(['company_booth_booking' => array_filter(array_merge($bookingDraft, [
                    'slots' => $sessionSlots->all(),
                    'slots_subtotal' => $sessionSlots->sum('price'),
                    'booking_days_count' => $sessionSlots->count(),
                ]))]);

                $booking = BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days'])
                    ->where('company_id', (int) session('company_id'))
                    ->find($bookingDraft['booth_booking_id'] ?? null);
            }
        }

        if (! $booking) {
            $booking = BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days'])
                ->where('company_id', (int) session('company_id'))
                ->where('booking_status', 'draft')
                ->when(! empty($bookingDraft['exhibition_id']), fn ($query) => $query->where('exhibition_id', (int) $bookingDraft['exhibition_id']))
                ->latest()
                ->first();

            if ($booking) {
                session(['company_booth_booking' => array_filter(array_merge($bookingDraft, [
                    'booth_booking_id' => $booking->id,
                    'hall_id' => $booking->hall_id,
                    'pavilion_id' => $booking->pavilion_id,
                    'exhibition_id' => $booking->exhibition_id,
                    'booth_id' => $booking->booth_id,
                    'selected_booth_ids' => $booking->selected_booth_ids ?: [$booking->booth_id],
                    'booth_size_id' => $booking->booth_size_id,
                    'slots' => $booking->days->map(fn ($day) => [
                        'key' => $day->booking_date->toDateString() . '|full-day',
                        'date' => $day->booking_date->toDateString(),
                        'date_label' => $day->label ?: $day->booking_date->format('M d, D'),
                        'time' => 'full-day',
                        'label' => 'Full Day',
                        'price' => (float) $day->price,
                    ])->values()->all(),
                    'slots_subtotal' => $booking->days->sum('price'),
                    'booking_days_count' => $booking->days->count(),
                ]))]);
            }
        }

        if (! $booking) {
            return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
                'exhibition' => session('company_booth_booking.exhibition_slug'),
            ])))
                ->withErrors(['booking' => 'Please select booth days before opening summary.']);
        }

        $selectedDays = $booking->days->sortBy('booking_date')->values();
        if ($selectedDays->isEmpty() && $sessionSlots->isNotEmpty()) {
            $selectedDays = $sessionSlots->map(fn ($slot) => (object) [
                'booking_date' => Carbon::parse($slot['date']),
                'label' => $slot['date_label'] ?? $slot['label'] ?? null,
                'price' => (float) $slot['price'],
            ])->values();
        }
        if ($selectedDays->isEmpty()) {
            return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
                'hall' => $booking->hall_id,
                'booth' => $booking->booth_id,
                'size' => $booking->booth_size_id,
                'exhibition' => $booking->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])))->withErrors(['slots' => 'Please select at least one day to continue.']);
        }

        $boothPrice = max((float) $booking->amount - (float) $selectedDays->sum('price'), 0);
        $daysAmount = (float) $selectedDays->sum('price');
        $amountToPay = (float) $booking->total_amount;
        $daysLabel = $selectedDays
            ->map(fn ($day) => $day->label ?: $day->booking_date->format('M d, D'))
            ->join(', ');
        $summary = $this->syncBookingSummary($booking, $selectedDays, $boothPrice, $daysAmount, $amountToPay);

        return view('company.booth-booking.summary', compact(
            'booking',
            'summary',
            'selectedDays',
            'boothPrice',
            'daysAmount',
            'amountToPay',
            'daysLabel',
        ));
    }

    public function customize(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before adding services.']);
        }

        $this->ensureDefaultServices();
        $this->recalculateBookingServices($booking);
        $booking = $booking->fresh(['pavilion', 'hall', 'booth', 'boothSize', 'days']);

        $services = Service::where('status', 'active')->orderBy('id')->get();
        $bookingServices = BookingService::with('service')
            ->where('booth_booking_id', $booking->id)
            ->get()
            ->keyBy('service_id');

        $brandingKeywords = ['banner', 'screen', 'video wall', 'logo', 'fascia', 'print', 'design'];
        $brandingServices = $services->filter(function (Service $service) use ($brandingKeywords) {
            $title = strtolower($service->title);

            return collect($brandingKeywords)->contains(fn (string $keyword) => str_contains($title, $keyword));
        })->values();

        if ($brandingServices->isEmpty()) {
            $brandingServices = $services->take(3)->values();
        }

        $furnitureServices = $services
            ->reject(fn (Service $service) => $brandingServices->contains('id', $service->id))
            ->take(4)
            ->values();

        $customizationTotal = (float) $bookingServices->sum('total');

        return view('company.booth-booking.customize', compact(
            'booking',
            'brandingServices',
            'furnitureServices',
            'bookingServices',
            'customizationTotal',
        ));
    }

    public function services(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before adding services.']);
        }

        $this->ensureDefaultServices();
        $this->recalculateBookingServices($booking);
        $booking = $booking->fresh(['pavilion', 'hall', 'booth', 'boothSize', 'days']);

        $services = Service::where('status', 'active')->orderBy('id')->get();
        $bookingServices = BookingService::with('service')
            ->where('booth_booking_id', $booking->id)
            ->get()
            ->keyBy('service_id');
        $selectedServicesCount = $bookingServices->count();
        $servicesAmount = (float) $bookingServices->sum('total');
        $amountToPay = (float) $booking->total_amount;

        return view('company.booth-booking.services', compact(
            'booking',
            'services',
            'bookingServices',
            'selectedServicesCount',
            'servicesAmount',
            'amountToPay',
        ));
    }

    public function toggleService(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
        ]);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before adding services.']);
        }

        $service = Service::where('status', 'active')->findOrFail($validated['service_id']);
        $bookingService = BookingService::where('booth_booking_id', $booking->id)
            ->where('service_id', $service->id)
            ->first();

        if ($bookingService) {
            $bookingService->delete();
        } else {
            BookingService::create([
                'booth_booking_id' => $booking->id,
                'service_id' => $service->id,
                'price' => $service->price,
                'quantity' => 1,
                'total' => $service->price,
            ]);
        }

        $this->recalculateBookingServices($booking);

        $returnTo = $request->input('return_to');
        $query = array_filter([
            'exhibition' => $booking->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ]);
        $redirectPath = $returnTo === 'customize'
            ? '/company/booth-booking/customize'
            : '/company/booth-booking/services';

        return redirect($redirectPath . '?' . http_build_query($query))
            ->with('status', $bookingService ? 'Service removed. Total amount updated.' : 'Service added. Total amount updated.');
    }

    public function updateServiceQuantity(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before adding services.']);
        }

        $service = Service::where('status', 'active')->findOrFail($validated['service_id']);
        BookingService::updateOrCreate(
            [
                'booth_booking_id' => $booking->id,
                'service_id' => $service->id,
            ],
            [
                'price' => $service->price,
                'quantity' => (int) $validated['quantity'],
                'total' => (float) $service->price * (int) $validated['quantity'],
            ]
        );

        $this->recalculateBookingServices($booking);

        return redirect('/company/booth-booking/services?' . http_build_query(array_filter([
            'exhibition' => $booking->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])))
            ->with('status', 'Service quantity updated. Total amount recalculated.');
    }

    public function continueFromServices(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before continuing.']);
        }

        $this->recalculateBookingServices($booking);

        return redirect('/company/booth-booking/review?' . http_build_query(array_filter([
            'exhibition' => $booking->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])));
    }

    public function review(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before reviewing your booking.']);
        }

        $this->recalculateBookingServices($booking);

        $booking = $booking->fresh(['pavilion', 'hall', 'booth', 'boothSize', 'days', 'summary']);
        $summary = $booking->summary;
        $selectedDays = $booking->days->sortBy('booking_date')->values();
        $daysAmount = (float) $selectedDays->sum('price');
        $boothPrice = max((float) $booking->amount - $daysAmount, 0);
        $servicesAmount = (float) $booking->services_amount;
        $amountToPay = (float) $booking->total_amount;
        $daysLabel = $selectedDays->map(fn ($day) => $day->label ?: $day->booking_date->format('M d, D'))->join(', ');
        $bookingServices = BookingService::with('service')
            ->where('booth_booking_id', $booking->id)
            ->get();
        $selectedServicesLabel = $bookingServices->isNotEmpty()
            ? $bookingServices->map(fn ($bookingService) => $bookingService->service?->title . ((int) $bookingService->quantity > 1 ? ' x' . $bookingService->quantity : ''))->filter()->join(', ')
            : 'No extra services selected';

        return view('company.booth-booking.review', compact(
            'booking',
            'summary',
            'selectedDays',
            'daysAmount',
            'boothPrice',
            'servicesAmount',
            'amountToPay',
            'daysLabel',
            'bookingServices',
            'selectedServicesLabel',
        ));
    }

    public function payment(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $this->resolveBookingExhibition($request);

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before payment.']);
        }

        $this->recalculateBookingServices($booking);

        $booking = $booking->fresh(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'days']);
        $selectedDays = $booking->days->sortBy('booking_date')->values();
        $daysAmount = (float) $selectedDays->sum('price');
        $boothPrice = max((float) $booking->amount - $daysAmount, 0);
        $servicesAmount = (float) $booking->services_amount;
        $amountToPay = (float) $booking->total_amount;
        $daysLabel = $selectedDays->map(fn ($day) => $day->label ?: $day->booking_date->format('M d, D'))->join(', ') ?: 'No days selected';
        $bookingServices = BookingService::with('service')
            ->where('booth_booking_id', $booking->id)
            ->get();
        $razorpayKey = config('services.razorpay.key');
        $razorpayCurrency = config('services.razorpay.currency', 'INR');
        $razorpayEnabled = filled($razorpayKey) && filled(config('services.razorpay.secret'));

        return view('company.booth-booking.payment', compact(
            'booking',
            'selectedDays',
            'daysAmount',
            'boothPrice',
            'servicesAmount',
            'amountToPay',
            'daysLabel',
            'bookingServices',
            'razorpayKey',
            'razorpayCurrency',
            'razorpayEnabled',
        ));
    }

    public function paymentSummary(): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return response()->json(['message' => 'Please complete booth booking before payment.'], 422);
        }

        $this->recalculateBookingServices($booking);
        $booking = $booking->fresh(['pavilion', 'hall', 'booth', 'boothSize', 'days']);

        return response()->json($this->paymentPayload($booking));
    }

    public function createRazorpayOrder(): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return response()->json(['message' => 'Please complete booth booking before payment.'], 422);
        }

        $this->recalculateBookingServices($booking);
        $booking->refresh();

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        $currency = config('services.razorpay.currency', 'INR');

        if (! filled($key) || ! filled($secret)) {
            return response()->json(['message' => 'Razorpay keys are not configured.'], 422);
        }

        $amountInPaise = (int) round((float) $booking->total_amount * 100);
        if ($amountInPaise < 100) {
            return response()->json(['message' => 'Payment amount must be at least INR 1.'], 422);
        }

        $response = Http::withBasicAuth($key, $secret)
            ->acceptJson()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amountInPaise,
                'currency' => $currency,
                'receipt' => 'booth_' . $booking->id . '_' . now()->format('YmdHis'),
                'notes' => [
                    'booking_id' => (string) $booking->id,
                    'company_id' => (string) $booking->company_id,
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => $response->json('error.description') ?: 'Unable to create Razorpay order.',
            ], 422);
        }

        $order = $response->json();
        $booking->update([
            'razorpay_order_id' => $order['id'] ?? null,
        ]);

        return response()->json([
            'key' => $key,
            'order_id' => $order['id'] ?? null,
            'amount' => $amountInPaise,
            'currency' => $currency,
            'name' => 'EproExpo',
            'description' => 'Booth booking #' . $booking->id,
        ]);
    }

    public function verifyRazorpayPayment(Request $request): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        $secret = config('services.razorpay.secret');
        if (! filled($secret)) {
            return response()->json(['message' => 'Razorpay secret is not configured.'], 422);
        }

        $booking = $this->currentDraftBooking();
        if (! $booking || $booking->razorpay_order_id !== $validated['razorpay_order_id']) {
            return response()->json(['message' => 'Payment order does not match this booking.'], 422);
        }

        $expectedSignature = hash_hmac(
            'sha256',
            $validated['razorpay_order_id'] . '|' . $validated['razorpay_payment_id'],
            $secret
        );

        if (! hash_equals($expectedSignature, $validated['razorpay_signature'])) {
            return response()->json(['message' => 'Payment verification failed.'], 422);
        }

        $booking = DB::transaction(function () use ($booking, $validated) {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'admin_status' => 'pending',
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'],
                'paid_at' => now(),
            ]);

            $selectedBoothIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                ->push($booking->booth_id)
                ->filter()
                ->unique()
                ->values();

            \App\Domain\Booth\Models\Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'booked']);

            $booking->load(['pavilion', 'hall', 'booth', 'boothSize', 'days']);
            $daysAmount = (float) $booking->days->sum('price');
            $boothPrice = max((float) $booking->amount - $daysAmount, 0);
            $this->syncBookingSummary($booking, $booking->days, $boothPrice, $daysAmount, (float) $booking->total_amount);

            return $booking;
        });

        session([
            'company_booth_booked' => true,
            'company_booking_id' => $booking->id,
            'company_booth_booking' => array_merge(session('company_booth_booking', []), [
                'booth_booking_id' => $booking->id,
            ]),
        ]);

        return response()->json([
            'message' => 'Payment verified successfully.',
            'redirect_url' => url('/company/booth-booking/confirmed'),
        ]);
    }

    public function continueAfterPayment(): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth booking before confirmation.']);
        }

        $booking = DB::transaction(function () use ($booking) {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'admin_status' => 'pending',
                'razorpay_payment_id' => $booking->razorpay_payment_id ?: 'manual-flow-' . now()->format('YmdHis'),
                'paid_at' => now(),
                'notes' => trim(($booking->notes ? $booking->notes . "\n" : '') . 'Temporary payment bypass used while Razorpay setup is pending.'),
            ]);

            $selectedBoothIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                ->push($booking->booth_id)
                ->filter()
                ->unique()
                ->values();

            \App\Domain\Booth\Models\Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'booked']);

            $booking->load(['pavilion', 'hall', 'booth', 'boothSize', 'days']);
            $daysAmount = (float) $booking->days->sum('price');
            $boothPrice = max((float) $booking->amount - $daysAmount, 0);
            $this->syncBookingSummary($booking, $booking->days, $boothPrice, $daysAmount, (float) $booking->total_amount);

            return $booking;
        });

        session([
            'company_booth_booked' => true,
            'company_booking_id' => $booking->id,
            'company_booth_booking' => array_merge(session('company_booth_booking', []), [
                'booth_booking_id' => $booking->id,
            ]),
        ]);

        return redirect('/company/booth-booking/confirmed');
    }

    public function requestCustomSlot(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = Hall::with('pavilion.exhibition')->findOrFail($validated['hall_id']);
        $booth = $hall->booths()->where('status', 'available')->findOrFail($validated['booth_id']);
        $selectedSize = ! empty($validated['size_id']) ? BoothSize::find($validated['size_id']) : null;
        $blockedBoothIds = $this->bookedBoothGroupsForHall($hall, $hall->booths()->with('boothSize')->get())
            ->flatMap(fn (array $group) => $group['booth_ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $selectedBooths = $this->boothFootprintForSize($hall, $booth, $selectedSize, $blockedBoothIds);

        if ($selectedBooths->count() < $this->boothUnitsForSize($selectedSize)) {
            return redirect()->route('company.booth-booking.floor-plan', [
                'hall' => $hall->id,
                'size' => $selectedSize?->id,
                'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
            ])->with('status', 'Not enough sequential booth boxes are available for this booth size. Please choose another starting booth.');
        }
        $boothPrice = (float) ($selectedSize?->price ?? $booth->price);
        $bookingDraft = session('company_booth_booking', []);
        $booking = ! empty($bookingDraft['booth_booking_id'])
            ? BoothBooking::where('company_id', (int) session('company_id'))->find($bookingDraft['booth_booking_id'])
            : null;

        $bookingData = [
            'company_id' => (int) session('company_id'),
            'exhibition_id' => (int) $hall->pavilion?->exhibition_id,
            'pavilion_id' => (int) $hall->pavilion_id,
            'hall_id' => (int) $hall->id,
            'booth_size_id' => $selectedSize?->id,
            'booth_id' => (int) $booth->id,
            'selected_booth_ids' => $selectedBooths->pluck('id')->values()->all(),
            'amount' => $boothPrice,
            'services_amount' => 0,
            'total_amount' => $boothPrice,
            'payment_status' => 'pending',
            'booking_status' => 'draft',
            'admin_status' => 'pending',
            'notes' => 'Custom booth days requested by company.',
            'submitted_at' => now(),
        ];

        if ($booking) {
            $booking->update($bookingData);
        } else {
            $booking = BoothBooking::create($bookingData);
        }

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'booth_booking_id' => $booking->id,
                'hall_id' => (int) $validated['hall_id'],
                'pavilion_id' => (int) $hall->pavilion_id,
                'exhibition_id' => (int) $hall->pavilion?->exhibition_id,
                'booth_id' => (int) $validated['booth_id'],
                'selected_booth_ids' => $selectedBooths->pluck('id')->values()->all(),
                'booth_size_id' => $validated['size_id'] ?? null,
                'custom_slot_requested' => true,
            ])),
        ]);

        return redirect('/company/booth-booking/slots?' . http_build_query(array_filter([
            'hall' => $validated['hall_id'],
            'booth' => $validated['booth_id'],
            'size' => $validated['size_id'] ?? null,
            'exhibition' => $hall->pavilion?->exhibition?->slug ?: session('company_booth_booking.exhibition_slug'),
        ])))->with('status', 'Custom day request noted. Our team will help with a longer or tailored duration.');
    }

    public function confirmed(): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $bookingDraft = session('company_booth_booking', []);
        $bookingId = $bookingDraft['booth_booking_id'] ?? session('company_booking_id');
        $booking = $bookingId
            ? BoothBooking::with(['company', 'pavilion', 'hall', 'booth', 'boothSize', 'days'])
                ->where('company_id', (int) session('company_id'))
                ->find($bookingId)
            : null;

        if (! $booking || $booking->payment_status !== 'paid' || $booking->booking_status !== 'confirmed') {
            return redirect('/company/booth-booking/payment')
                ->withErrors(['payment' => 'Please complete Razorpay payment before confirmation.']);
        }

        session([
            'company_booth_booked' => true,
            'company_booking_id' => $booking->id,
        ]);
        session()->forget('company_booth_booking');

        return view('company.booth-booking.confirmed', compact('booking'));
    }

    private function syncDraftBooking(Hall $hall, \App\Domain\Booth\Models\Booth $booth, ?BoothSize $selectedSize, $selectedSlots, array $bookingDraft): array
    {
        $selectedSlots = collect($selectedSlots)->filter(fn ($slot) => isset($slot['date'], $slot['price']))->values();

        if ($selectedSlots->isEmpty()) {
            if (! empty($bookingDraft['booth_booking_id'])) {
                BoothBooking::whereKey($bookingDraft['booth_booking_id'])
                    ->where('company_id', (int) session('company_id'))
                    ->where('booking_status', 'draft')
                    ->first()?->days()->delete();
            }

            return $bookingDraft;
        }

        $boothPrice = (float) ($selectedSize?->price ?? $booth->price);
        $daysAmount = (float) $selectedSlots->sum('price');
        $selectedBoothIds = collect($bookingDraft['selected_booth_ids'] ?? [])
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($selectedBoothIds->isEmpty()) {
            $blockedBoothIds = $this->bookedBoothGroupsForHall($hall, $hall->booths()->with('boothSize')->get())
                ->flatMap(fn (array $group) => $group['booth_ids'])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();

            $selectedBoothIds = $this->boothFootprintForSize($hall, $booth, $selectedSize, $blockedBoothIds)
                ->pluck('id')
                ->values();
        }

        return DB::transaction(function () use ($hall, $booth, $selectedSize, $selectedSlots, $bookingDraft, $boothPrice, $daysAmount, $selectedBoothIds) {
            $booking = ! empty($bookingDraft['booth_booking_id'])
                ? BoothBooking::where('company_id', (int) session('company_id'))
                    ->where('exhibition_id', (int) $hall->pavilion?->exhibition_id)
                    ->where('hall_id', (int) $hall->id)
                    ->where('booth_id', (int) $booth->id)
                    ->where('booking_status', 'draft')
                    ->find($bookingDraft['booth_booking_id'])
                : null;

            if (! $booking) {
                $booking = BoothBooking::where('company_id', (int) session('company_id'))
                    ->where('exhibition_id', (int) $hall->pavilion?->exhibition_id)
                    ->where('hall_id', (int) $hall->id)
                    ->where('booth_id', $booth->id)
                    ->where('booking_status', 'draft')
                    ->latest()
                    ->first();
            }

            $existingServicesAmount = $booking
                ? (float) BookingService::where('booth_booking_id', $booking->id)->sum('total')
                : 0;

            $bookingData = [
                'company_id' => (int) session('company_id'),
                'exhibition_id' => (int) $hall->pavilion?->exhibition_id,
                'pavilion_id' => (int) $hall->pavilion_id,
                'hall_id' => (int) $hall->id,
                'booth_size_id' => $selectedSize?->id,
                'booth_id' => (int) $booth->id,
                'selected_booth_ids' => $selectedBoothIds->all(),
                'amount' => $boothPrice + $daysAmount,
                'services_amount' => $existingServicesAmount,
                'total_amount' => $boothPrice + $daysAmount + $existingServicesAmount,
                'payment_status' => 'pending',
                'booking_status' => 'draft',
                'admin_status' => 'pending',
                'submitted_at' => now(),
            ];

            if ($booking) {
                $booking->update($bookingData);
            } else {
                $booking = BoothBooking::create($bookingData);
            }

            $booking->days()->delete();
            foreach ($selectedSlots as $slot) {
                BoothBookingDay::create([
                    'booth_booking_id' => $booking->id,
                    'booth_id' => $booth->id,
                    'booking_date' => $slot['date'],
                    'label' => $slot['date_label'] ?? $slot['label'] ?? null,
                    'price' => (float) $slot['price'],
                ]);
            }

            $booking->load(['pavilion', 'hall', 'booth', 'boothSize', 'days']);
            $this->syncBookingSummary($booking, $booking->days, $boothPrice, $daysAmount, (float) $booking->total_amount);

            return array_merge($bookingDraft, [
                'booth_booking_id' => $booking->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
                'selected_booth_ids' => $selectedBoothIds->all(),
                'slots_subtotal' => $daysAmount,
            ]);
        });
    }

    private function currentDraftBooking(): ?BoothBooking
    {
        $bookingDraft = session('company_booth_booking', []);
        $exhibitionId = (int) ($bookingDraft['exhibition_id'] ?? 0);

        $booking = ! empty($bookingDraft['booth_booking_id'])
            ? BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days', 'exhibition'])
                ->where('company_id', (int) session('company_id'))
                ->when($exhibitionId > 0, fn ($query) => $query->where('exhibition_id', $exhibitionId))
                ->find($bookingDraft['booth_booking_id'])
            : null;

        return $booking ?: BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days', 'exhibition'])
            ->where('company_id', (int) session('company_id'))
            ->where('booking_status', 'draft')
            ->when($exhibitionId > 0, fn ($query) => $query->where('exhibition_id', $exhibitionId))
            ->latest()
            ->first();
    }

    private function resolveBookingExhibition(Request $request, bool $fallbackToFirst = true, bool $includeSession = true): ?Exhibition
    {
        $requestedExhibitionKey = $request->query('exhibition') ?: $request->input('exhibition');
        $requestedExhibitionId = (int) ($request->query('exhibition_id') ?: $request->input('exhibition_id') ?: 0);
        $hasExplicitExhibition = filled($requestedExhibitionKey) || $requestedExhibitionId > 0;
        $previousExhibitionId = (int) session('company_booth_booking.exhibition_id', 0);
        $exhibitionKey = $requestedExhibitionKey;
        $exhibitionId = $requestedExhibitionId;

        if ($includeSession) {
            $exhibitionKey = $exhibitionKey ?: session('company_booth_booking.exhibition_slug');
            $exhibitionId = $exhibitionId ?: $previousExhibitionId;
        }

        $exhibition = null;
        if ($exhibitionKey) {
            $exhibition = LiveContent::exhibitionQuery()
                ->where(function ($query) use ($exhibitionKey) {
                    $query->where('slug', $exhibitionKey);
                    if (is_numeric($exhibitionKey)) {
                        $query->orWhere('id', (int) $exhibitionKey);
                    }
                })
                ->first();
        } elseif ($exhibitionId > 0) {
            $exhibition = LiveContent::exhibitionQuery()->find($exhibitionId);
        }

        if (! $exhibition && $fallbackToFirst) {
            $exhibition = LiveContent::exhibitionQuery()->first();
        }

        if ($exhibition) {
            $draft = $hasExplicitExhibition && $previousExhibitionId > 0 && $previousExhibitionId !== (int) $exhibition->id
                ? []
                : session('company_booth_booking', []);

            session([
                'company_booth_booking' => array_merge($draft, [
                    'exhibition_id' => $exhibition->id,
                    'exhibition_slug' => $exhibition->slug,
                ]),
            ]);
        }

        return $exhibition;
    }

    private function ensureHallMatchesBookingExhibition(Hall $hall): ?RedirectResponse
    {
        $expectedExhibitionId = (int) session('company_booth_booking.exhibition_id', 0);
        if ($expectedExhibitionId <= 0) {
            $hall->loadMissing('pavilion.exhibition');
            $hallExhibition = $hall->pavilion?->exhibition;
            if ($hallExhibition) {
                session([
                    'company_booth_booking' => array_merge(session('company_booth_booking', []), [
                        'exhibition_id' => $hallExhibition->id,
                        'exhibition_slug' => $hallExhibition->slug,
                    ]),
                ]);
                return null;
            }
            return redirect()->route('company.exhibitions.index')
                ->with('status', 'Please select an exhibition to book a booth.');
        }

        $hallExhibitionId = (int) $hall->pavilion?->exhibition_id;
        if ($hallExhibitionId !== $expectedExhibitionId) {
            $slug = session('company_booth_booking.exhibition_slug');

            return redirect()->route('company.booth-booking.pavilions', array_filter([
                'exhibition' => $slug,
            ]))->with('status', 'Please select a pavilion for the chosen exhibition.');
        }

        return null;
    }

    private function bookingExhibitionQueryString(): string
    {
        $slug = session('company_booth_booking.exhibition_slug');

        return $slug ? 'exhibition=' . urlencode((string) $slug) : '';
    }

    private function paymentPayload(BoothBooking $booking): array
    {
        $selectedDays = $booking->days->sortBy('booking_date')->values();
        $daysAmount = (float) $selectedDays->sum('price');
        $boothPrice = max((float) $booking->amount - $daysAmount, 0);
        $servicesAmount = (float) $booking->services_amount;
        $amountToPay = (float) $booking->total_amount;
        $bookingServicesCount = BookingService::where('booth_booking_id', $booking->id)->count();
        $selectedBoothIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
            ->push($booking->booth_id)
            ->filter()
            ->unique()
            ->values();
        $selectedBoothLabel = $selectedBoothIds->count() > 1
            ? $selectedBoothIds->count() . ' linked booths'
            : ($booking->booth ? 'Booth ' . $booking->booth->booth_number : 'Booth');

        return [
            'booking_id' => $booking->id,
            'razorpay_enabled' => filled(config('services.razorpay.key')) && filled(config('services.razorpay.secret')),
            'currency' => config('services.razorpay.currency', 'INR'),
            'summary' => [
                'pavilion' => $booking->pavilion?->title ?? 'Pavilion',
                'hall' => $booking->hall?->title ?? 'Hall',
                'booth' => $selectedBoothLabel,
                'selected_days' => $selectedDays->map(fn ($day) => $day->label ?: $day->booking_date->format('M d, D'))->join(', ') ?: 'No days selected',
                'duration' => $selectedDays->count() . ' ' . ($selectedDays->count() === 1 ? 'Day' : 'Days'),
                'services' => $bookingServicesCount . ' Selected',
            ],
            'amounts' => [
                'booth_price' => $boothPrice,
                'days_amount' => $daysAmount,
                'services_amount' => $servicesAmount,
                'amount_to_pay' => $amountToPay,
                'booth_price_display' => '₹' . number_format($boothPrice),
                'days_amount_display' => '₹' . number_format($daysAmount),
                'services_amount_display' => '₹' . number_format($servicesAmount),
                'amount_to_pay_display' => '₹' . number_format($amountToPay),
            ],
        ];
    }

    private function boothUnitsForSize(?BoothSize $selectedSize): int
    {
        return \App\Support\BoothFloorMap::unitsForSize($selectedSize);
    }

    private function boothFootprintForSize(Hall $hall, \App\Domain\Booth\Models\Booth $anchorBooth, ?BoothSize $selectedSize, array $blockedBoothIds = []): \Illuminate\Support\Collection
    {
        return \App\Support\BoothFloorMap::footprintForSize($hall, $anchorBooth, $selectedSize, $blockedBoothIds);
    }

    private function bookedBoothGroupsForHall(Hall $hall, $booths): \Illuminate\Support\Collection
    {
        $hall->loadMissing('pavilion.exhibition');

        $boothsById = $booths->keyBy('id');

        if ($boothsById->isEmpty()) {
            return collect();
        }

        return BoothBooking::query()
            ->with(['company', 'boothProfile', 'boothSize'])
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->filter(fn (BoothBooking $booking) => $booking->company_id && $booking->booth_id)
            ->map(function (BoothBooking $booking) use ($hall, $boothsById) {
                $allocatedBooths = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->filter(fn (int $id) => $boothsById->has($id))
                    ->map(fn (int $id) => $boothsById->get($id))
                    ->sortBy(function ($booth) {
                        $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                        return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
                    })
                    ->values();

                if ($allocatedBooths->isEmpty()) {
                    return null;
                }

                $items = $allocatedBooths
                    ->map(function ($booth) use ($booking) {
                        $metrics = \App\Support\BoothFloorMap::metricsForBooth($booth);

                        return [
                            'booking' => $booking,
                            'booth' => $booth,
                            'left' => $metrics['left'],
                            'top' => $metrics['top'],
                            'right' => $metrics['right'],
                            'bottom' => $metrics['bottom'],
                        ];
                    })
                    ->values();

                $profileLogo = $booking->boothProfile?->company_logo;
                $companyLogo = $booking->company?->logo;
                $logo = $profileLogo
                    ? asset(str_starts_with($profileLogo, 'storage/') ? $profileLogo : 'storage/' . $profileLogo)
                    : ($companyLogo ? asset($companyLogo) : null);

                return [
                    'company_id' => $booking->company_id,
                    'company_name' => $booking->company?->company_name ?? $booking->company?->name ?? 'Booked Company',
                    'logo_url' => $logo,
                    'booth_ids' => $items->pluck('booth.id')->values()->all(),
                    'booth_numbers' => $items->pluck('booth.booth_number')->values()->all(),
                    'segments' => \App\Support\BoothFloorMap::segmentsForFootprint($allocatedBooths),
                    'space_label' => trim(($items->count() > 1 ? $items->count() . ' spaces' : '1 space') . ' ' . ($booking->boothSize?->title ? '- ' . $booking->boothSize->title : '')),
                    'exhibition_name' => $hall->pavilion?->exhibition?->title ?? $hall->pavilion?->exhibition?->name ?? 'Exhibition',
                    'hall_name' => $hall->title,
                    'pavilion_name' => $hall->pavilion?->title ?? 'Pavilion',
                    'size_title' => $booking->boothSize?->title ?? 'Custom size',
                    'booth_count' => $items->count(),
                    'status' => ucfirst((string) ($booking->booking_status ?: 'confirmed')),
                    'contact_person' => $booking->company?->contact_person_name ?: $booking->company?->owner_name,
                    'email' => $booking->company?->email,
                    'phone' => $booking->company?->phone,
                    'website' => $booking->company?->website,
                    'category' => $booking->company?->industry,
                    'location' => trim(implode(', ', array_filter([$booking->company?->city, $booking->company?->country]))) ?: null,
                    'left' => max(min($items->min('left'), 700), 0),
                    'top' => max(min($items->min('top'), 350), 0),
                    'width' => min($items->max('right') - $items->min('left'), 700),
                    'height' => min($items->max('bottom') - $items->min('top'), 350),
                ];
            })
            ->filter()
            ->values();
    }
    private function bookedBoothIdsForHall(Hall $hall): \Illuminate\Support\Collection
    {
        return BoothBooking::query()
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->get(['booth_id', 'selected_booth_ids'])
            ->flatMap(function (BoothBooking $booking) {
                return collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id);
            })
            ->unique()
            ->values();
    }

    private function connectedBoothComponents(array $items): array
    {
        $components = [];
        $visited = [];
        $gap = 14;

        foreach ($items as $index => $item) {
            if (isset($visited[$index])) {
                continue;
            }

            $queue = [$index];
            $visited[$index] = true;
            $component = [];

            while ($queue) {
                $currentIndex = array_shift($queue);
                $current = $items[$currentIndex];
                $component[] = $current;

                foreach ($items as $nextIndex => $next) {
                    if (isset($visited[$nextIndex])) {
                        continue;
                    }

                    $horizontallyClose = $current['left'] <= $next['right'] + $gap
                        && $current['right'] + $gap >= $next['left'];
                    $verticallyClose = $current['top'] <= $next['bottom'] + $gap
                        && $current['bottom'] + $gap >= $next['top'];

                    if ($horizontallyClose && $verticallyClose) {
                        $visited[$nextIndex] = true;
                        $queue[] = $nextIndex;
                    }
                }
            }

            $components[] = $component;
        }

        return $components;
    }

    private function ensureDefaultServices(): void
    {
        Service::syncDefaultCatalog();
    }

    private function recalculateBookingServices(BoothBooking $booking): void
    {
        $bookingServices = BookingService::with('service')
            ->where('booth_booking_id', $booking->id)
            ->get();

        foreach ($bookingServices as $bookingService) {
            $price = (float) ($bookingService->service?->price ?? $bookingService->price);
            $quantity = max((int) $bookingService->quantity, 1);
            $total = $price * $quantity;

            if ((float) $bookingService->price !== $price || (int) $bookingService->quantity !== $quantity || (float) $bookingService->total !== $total) {
                $bookingService->update([
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $total,
                ]);
            }
        }

        $servicesAmount = (float) BookingService::where('booth_booking_id', $booking->id)->sum('total');
        $booking->update([
            'services_amount' => $servicesAmount,
            'total_amount' => (float) $booking->amount + $servicesAmount,
        ]);

        $booking->refresh()->load(['pavilion', 'hall', 'booth', 'boothSize', 'days']);
        $daysAmount = (float) $booking->days->sum('price');
        $boothPrice = max((float) $booking->amount - $daysAmount, 0);
        $this->syncBookingSummary($booking, $booking->days, $boothPrice, $daysAmount, (float) $booking->total_amount);
    }

    private function syncBookingSummary(BoothBooking $booking, $selectedDays, float $boothPrice, float $daysAmount, float $totalAmount): BoothBookingSummary
    {
        $booking->loadMissing(['pavilion', 'hall', 'booth', 'boothSize']);
        $selectedDays = collect($selectedDays)->values();

        return BoothBookingSummary::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $booking->company_id,
                'exhibition_id' => $booking->exhibition_id,
                'pavilion_id' => $booking->pavilion_id,
                'hall_id' => $booking->hall_id,
                'booth_id' => $booking->booth_id,
                'booth_size_id' => $booking->booth_size_id,
                'pavilion_title' => $booking->pavilion?->title,
                'hall_title' => $booking->hall?->title,
                'booth_number' => $booking->booth?->booth_number,
                'booth_size_title' => $booking->boothSize?->title,
                'selected_days_count' => $selectedDays->count(),
                'selected_days' => $selectedDays->map(function ($day) {
                    $date = $day->booking_date instanceof Carbon
                        ? $day->booking_date
                        : Carbon::parse($day->booking_date);

                    return [
                        'date' => $date->toDateString(),
                        'label' => $day->label ?: $date->format('M d, D'),
                        'price' => (float) $day->price,
                    ];
                })->all(),
                'booth_price' => $boothPrice,
                'days_amount' => $daysAmount,
                'services_amount' => (float) $booking->services_amount,
                'total_amount' => $totalAmount,
                'booking_status' => $booking->booking_status,
                'payment_status' => $booking->payment_status,
            ]
        );
    }

    private function slotGroupsForHall(Hall $hall, int $slotPrice, ?int $daysCount = null): array
    {
        $exhibition = $hall->pavilion?->exhibition;
        $startDate = Carbon::parse($exhibition?->start_date ?: now());
        $defaultEndDate = Carbon::parse($exhibition?->end_date ?: now()->addDays(2));
        $defaultDaysCount = $startDate->diffInDays($defaultEndDate) + 1;
        $effectiveDaysCount = max($daysCount ?? $defaultDaysCount, 1);
        $endDate = $startDate->copy()->addDays($effectiveDaysCount - 1);
        $period = CarbonPeriod::create($startDate, $endDate);
        return collect($period)->map(function ($date) use ($slotPrice) {
            return [
                'date' => $date->toDateString(),
                'label' => $date->format('M d, D'),
                'slots' => [[
                    'key' => $date->toDateString() . '|full-day',
                    'date' => $date->toDateString(),
                    'date_label' => $date->format('M d, D'),
                    'time' => 'full-day',
                    'label' => 'Full Day',
                    'price' => $slotPrice,
                ]],
            ];
        })->all();
    }

    private function allowedBoothSizesForHall(Hall $hall): \Illuminate\Support\Collection
    {
        return BoothSize::query()
            ->where('status', 'active')
            ->whereIn('id', function ($query) use ($hall) {
                $query->select('booth_size_id')
                    ->from('booths')
                    ->where('hall_id', $hall->id)
                    ->whereNotNull('booth_size_id')
                    ->distinct();
            })
            ->orderBy('area')
            ->get();
    }
}
