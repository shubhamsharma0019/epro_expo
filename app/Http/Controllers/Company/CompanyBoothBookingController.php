<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\BoothBooking;
use App\Models\BoothBookingDay;
use App\Models\BoothBookingSummary;
use App\Models\BoothSize;
use App\Models\Company;
use App\Models\Hall;
use App\Models\Pavilion;
use App\Models\Service;
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

        $pavilions = Pavilion::query()
            ->with(['exhibition:id,title,slug,status', 'halls:id,pavilion_id,total_booths,status'])
            ->withCount(['halls', 'boothBookings'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('exhibition', function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->where('status', 'active')
            ->latest()
            ->get();

        $totalPavilions = $pavilions->count();
        $totalHalls = $pavilions->sum(function ($pavilion) {
            return $pavilion->halls_count ?: (int) $pavilion->total_halls;
        });
        $totalBooths = $pavilions->sum(function ($pavilion) {
            $actualBooths = $pavilion->halls->sum('total_booths');

            return $actualBooths ?: (int) $pavilion->total_booths;
        });

        return view('company.booth-booking.pavilions', compact(
            'pavilions',
            'search',
            'viewMode',
            'totalPavilions',
            'totalHalls',
            'totalBooths',
        ));
    }

    public function halls(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $search = trim((string) $request->query('search', ''));
        $pavilionId = $request->query('pavilion');
        $selectedPavilion = $pavilionId ? Pavilion::find($pavilionId) : null;
        $filter = in_array($request->query('filter'), ['all', 'available', 'high', 'medium'], true)
            ? $request->query('filter')
            : 'all';

        $hallsQuery = Hall::query()
            ->with('pavilion:id,title,slug,image')
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

        $isHighFootfall = function ($hall) {
            $totalBooths = (int) ($hall->total_booths ?: $hall->booths_count);

            return $totalBooths >= 300;
        };

        $halls = $allMatchingHalls
            ->when($filter === 'available', function ($halls) use ($availableBoothCount) {
                return $halls->filter(fn ($hall) => $availableBoothCount($hall) > 0);
            })
            ->when($filter === 'high', function ($halls) use ($isHighFootfall) {
                return $halls->filter(fn ($hall) => $isHighFootfall($hall));
            })
            ->when($filter === 'medium', function ($halls) use ($isHighFootfall) {
                return $halls->filter(fn ($hall) => ! $isHighFootfall($hall));
            })
            ->values();

        $allCount = $allMatchingHalls->count();
        $availableCount = $allMatchingHalls->filter(fn ($hall) => $availableBoothCount($hall) > 0)->count();
        $highFootfallCount = $allMatchingHalls->filter(fn ($hall) => $isHighFootfall($hall))->count();
        $mediumFootfallCount = $allMatchingHalls->filter(fn ($hall) => ! $isHighFootfall($hall))->count();

        return view('company.booth-booking.halls', compact(
            'halls',
            'selectedPavilion',
            'search',
            'filter',
            'allCount',
            'availableCount',
            'highFootfallCount',
            'mediumFootfallCount',
        ));
    }

    public function floorPlan(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $bookingDraft = session('company_booth_booking', []);
        $hallId = $request->query('hall') ?: ($bookingDraft['hall_id'] ?? null);
        $sizeId = $request->query('size') ?: ($bookingDraft['booth_size_id'] ?? null);
        $boothId = $request->query('booth') ?: ($bookingDraft['booth_id'] ?? null);

        $hall = Hall::query()
            ->with(['pavilion:id,title,slug,image', 'booths.boothSize'])
            ->when($hallId, function ($query) use ($hallId) {
                $query->whereKey($hallId);
            })
            ->where('status', 'active')
            ->first();

        if (! $hall) {
            return redirect('/company/booth-booking/halls')
                ->with('status', 'Please select a hall before opening the layout.');
        }

        $selectedSize = $sizeId
            ? BoothSize::where('status', 'active')->find($sizeId)
            : null;

        $booths = $hall->booths
            ->sortBy(function ($booth) {
                return str_pad((string) $booth->position_y, 4, '0', STR_PAD_LEFT)
                    . str_pad((string) $booth->position_x, 4, '0', STR_PAD_LEFT);
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
        $currentCompany = Company::find((int) session('company_id'));

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
        ));
    }

    public function selectBooth(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'booth_id' => ['required', 'integer', 'exists:booths,id'],
            'size_id' => ['nullable', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = Hall::with('pavilion')->where('status', 'active')->findOrFail($validated['hall_id']);
        $booth = $hall->booths()->findOrFail($validated['booth_id']);

        if ($booth->status !== 'available') {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $validated['size_id'] ?? null,
            ])))->with('status', 'Please select an available booth.');
        }

        $selectedSize = ! empty($validated['size_id'])
            ? BoothSize::where('status', 'active')->find($validated['size_id'])
            : $booth->boothSize;
        $selectedBooths = $this->boothFootprintForSize($hall, $booth, $selectedSize);

        if ($selectedBooths->count() < $this->boothUnitsForSize($selectedSize)) {
            return redirect('/company/booth-booking/floor-plan?' . http_build_query(array_filter([
                'hall' => $hall->id,
                'size' => $selectedSize?->id,
                'booth' => $booth->id,
            ])))->with('status', 'Not enough connected booth boxes are available for this booth size. Please choose another starting booth.');
        }

        $bookingDraft = session('company_booth_booking', []);

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'exhibition_id' => $hall->pavilion?->exhibition_id,
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
        ])));
    }

    public function sizes(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $bookingDraft = session('company_booth_booking', []);
        $hallId = $request->query('hall') ?: ($bookingDraft['hall_id'] ?? null);
        $selectedSizeId = $request->query('size') ?: ($bookingDraft['booth_size_id'] ?? null);

        $hall = $hallId
            ? Hall::with('pavilion:id,title')->find($hallId)
            : null;

        $boothSizes = BoothSize::where('status', 'active')
            ->orderBy('area')
            ->get();

        $selectedSize = $selectedSizeId
            ? $boothSizes->firstWhere('id', (int) $selectedSizeId)
            : $boothSizes->first();

        if ($hall || $selectedSize) {
            session([
                'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                    'hall_id' => $hall?->id,
                    'booth_size_id' => $selectedSize?->id,
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

        $validated = $request->validate([
            'hall_id' => ['nullable', 'integer', 'exists:halls,id'],
            'size_id' => ['required', 'integer', 'exists:booth_sizes,id'],
        ]);

        $size = BoothSize::where('status', 'active')->findOrFail($validated['size_id']);
        $hall = ! empty($validated['hall_id'])
            ? Hall::where('status', 'active')->find($validated['hall_id'])
            : null;

        $bookingDraft = session('company_booth_booking', []);
        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall?->id,
                'booth_size_id' => $size->id,
                'booth_id' => null,
                'slots' => [],
                'slots_subtotal' => 0,
            ])),
        ]);

        return redirect('/company/booth-booking/sizes?' . http_build_query(array_filter([
            'hall' => $hall?->id,
            'size' => $size->id,
        ])));
    }

    public function continueFromSizes(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'size_id' => ['required', 'integer', 'exists:booth_sizes,id'],
        ]);

        $hall = Hall::where('status', 'active')->findOrFail($validated['hall_id']);
        $size = BoothSize::where('status', 'active')->findOrFail($validated['size_id']);
        $bookingDraft = session('company_booth_booking', []);

        session([
            'company_booth_booking' => array_filter(array_merge($bookingDraft, [
                'hall_id' => $hall->id,
                'pavilion_id' => $hall->pavilion_id,
                'booth_size_id' => $size->id,
                'booth_id' => null,
                'slots' => [],
                'slots_subtotal' => 0,
            ])),
        ]);

        return redirect('/company/booth-booking/floor-plan?' . http_build_query([
            'hall' => $hall->id,
            'size' => $size->id,
        ]));
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

        return redirect('/company/booth-booking/halls' . ($hall ? '?pavilion=' . $hall->pavilion_id : ''))
            ->with('status', 'Custom booth size request noted. Please contact the event team for tailored booth options.');
    }

    public function slots(Request $request): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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
        ])))->with('status', $message);
    }

    public function selectSlot(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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
        ])));
    }

    public function continueFromSlots(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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

        return redirect('/company/booth-booking/summary');
    }

    public function summary(): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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
                ? \App\Models\Booth::find($bookingDraft['booth_id'])
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
            return redirect('/company/booth-booking/slots')
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

    public function services(): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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

        return redirect('/company/booth-booking/services')
            ->with('status', $bookingService ? 'Service removed. Total amount updated.' : 'Service added. Total amount updated.');
    }

    public function updateServiceQuantity(Request $request): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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

        return redirect('/company/booth-booking/services')
            ->with('status', 'Service quantity updated. Total amount recalculated.');
    }

    public function continueFromServices(): RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before continuing.']);
        }

        $this->recalculateBookingServices($booking);

        return redirect('/company/booth-booking/review');
    }

    public function review(): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

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

    public function payment(): View|RedirectResponse
    {
        if (! session('company_id')) {
            return redirect('/company/login');
        }

        $booking = $this->currentDraftBooking();
        if (! $booking) {
            return redirect('/company/booth-booking/summary')
                ->withErrors(['booking' => 'Please complete booth days before payment.']);
        }

        $this->recalculateBookingServices($booking);

        $booking = $booking->fresh(['pavilion', 'hall', 'booth', 'boothSize', 'days']);
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

            \App\Models\Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'booked']);

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

            \App\Models\Booth::whereIn('id', $selectedBoothIds)->update(['status' => 'booked']);

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
        $selectedBooths = $this->boothFootprintForSize($hall, $booth, $selectedSize);
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

    private function syncDraftBooking(Hall $hall, \App\Models\Booth $booth, ?BoothSize $selectedSize, $selectedSlots, array $bookingDraft): array
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
            $selectedBoothIds = $this->boothFootprintForSize($hall, $booth, $selectedSize)
                ->pluck('id')
                ->values();
        }

        return DB::transaction(function () use ($hall, $booth, $selectedSize, $selectedSlots, $bookingDraft, $boothPrice, $daysAmount, $selectedBoothIds) {
            $booking = ! empty($bookingDraft['booth_booking_id'])
                ? BoothBooking::where('company_id', (int) session('company_id'))->find($bookingDraft['booth_booking_id'])
                : null;

            if (! $booking) {
                $booking = BoothBooking::where('company_id', (int) session('company_id'))
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
        $booking = ! empty($bookingDraft['booth_booking_id'])
            ? BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days'])
                ->where('company_id', (int) session('company_id'))
                ->find($bookingDraft['booth_booking_id'])
            : null;

        return $booking ?: BoothBooking::with(['pavilion', 'hall', 'booth', 'boothSize', 'days'])
            ->where('company_id', (int) session('company_id'))
            ->where('booking_status', 'draft')
            ->latest()
            ->first();
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
        return max(1, (int) round((float) ($selectedSize?->area ?: 9) / 9));
    }

    private function boothFootprintForSize(Hall $hall, \App\Models\Booth $anchorBooth, ?BoothSize $selectedSize): \Illuminate\Support\Collection
    {
        if ($anchorBooth->status !== 'available') {
            return collect();
        }

        $selectedArea = (float) ($selectedSize?->area ?: $anchorBooth->boothSize?->area ?: 9);
        $selectedVisual = match (true) {
            $selectedArea >= 81 => ['width' => 150, 'height' => 130],
            $selectedArea >= 36 => ['width' => 120, 'height' => 110],
            $selectedArea >= 18 => ['width' => 96, 'height' => 76],
            $selectedArea >= 12 => ['width' => 72, 'height' => 56],
            default => ['width' => 48, 'height' => 44],
        };

        $selectedRectLeft = min((int) ($anchorBooth->position_x ?? 0), 700 - $selectedVisual['width']);
        $selectedRectTop = min((int) ($anchorBooth->position_y ?? 0), 350 - $selectedVisual['height']);
        $selectedRectRight = $selectedRectLeft + $selectedVisual['width'];
        $selectedRectBottom = $selectedRectTop + $selectedVisual['height'];

        return $hall->booths()
            ->where('status', 'available')
            ->get()
            ->filter(function ($booth) use ($selectedRectLeft, $selectedRectRight, $selectedRectTop, $selectedRectBottom) {
                $isCenterFeatureBooth = in_array((int) ($booth->position_y ?? 0), [122], true);
                $width = $isCenterFeatureBooth ? 86 : 48;
                $height = $isCenterFeatureBooth ? 70 : 44;
                $centerX = (int) ($booth->position_x ?? 0) + ($width / 2);
                $centerY = (int) ($booth->position_y ?? 0) + ($height / 2);

                return $centerX >= $selectedRectLeft && $centerX <= $selectedRectRight
                    && $centerY >= $selectedRectTop && $centerY <= $selectedRectBottom;
            })
            ->values();
    }

    private function bookedBoothGroupsForHall(Hall $hall, $booths): \Illuminate\Support\Collection
    {
        $bookedBoothsById = $booths
            ->where('status', 'booked')
            ->keyBy('id');

        if ($bookedBoothsById->isEmpty()) {
            return collect();
        }

        $bookings = BoothBooking::query()
            ->with(['company', 'boothProfile'])
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->where('booking_status', 'confirmed')
            ->where(function ($query) use ($bookedBoothsById) {
                $query->whereIn('booth_id', $bookedBoothsById->keys())
                    ->orWhereNotNull('selected_booth_ids');
            })
            ->get()
            ->filter(fn (BoothBooking $booking) => $booking->company_id && $booking->booth_id);

        return $bookings
            ->map(function (BoothBooking $booking) use ($bookedBoothsById) {
                $selectedIds = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id)
                    ->unique();

                $items = $selectedIds
                    ->map(function (int $boothId) use ($booking, $bookedBoothsById) {
                        $booth = $bookedBoothsById->get($boothId);
                        if (! $booth) {
                            return null;
                        }

                        $height = (int) ($booth->position_y ?? 0) === 122 ? 70 : 44;
                        $width = (int) ($booth->position_y ?? 0) === 122 ? 86 : 48;
                        $left = min((int) ($booth->position_x ?? 0), 700 - $width);
                        $top = min((int) ($booth->position_y ?? 0), 350 - $height);

                        return [
                            'booking' => $booking,
                            'booth' => $booth,
                            'left' => $left,
                            'top' => $top,
                            'right' => $left + $width,
                            'bottom' => $top + $height,
                        ];
                    })
                    ->filter()
                    ->values();

                if ($items->isEmpty()) {
                    return null;
                }

                $logo = $booking->boothProfile?->company_logo
                    ? asset('storage/' . $booking->boothProfile->company_logo)
                    : ($booking->company?->logo ? asset($booking->company->logo) : null);

                return [
                    'company_id' => $booking->company_id,
                    'company_name' => $booking->company?->company_name ?? $booking->company?->name ?? 'Booked Company',
                    'logo_url' => $logo,
                    'booth_ids' => $items->pluck('booth.id')->values()->all(),
                    'booth_numbers' => $items->pluck('booth.booth_number')->values()->all(),
                    'left' => max(min($items->min('left') - 4, 700), 0),
                    'top' => max(min($items->min('top') - 4, 350), 0),
                    'width' => min($items->max('right') - $items->min('left') + 8, 700),
                    'height' => min($items->max('bottom') - $items->min('top') + 8, 350),
                ];
            })
            ->filter()
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
}
