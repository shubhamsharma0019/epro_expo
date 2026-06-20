<?php

namespace App\Domain\Event\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Company\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExhibitionBookingController extends Controller
{
    public function services(): View
    {
        $this->ensureDefaultServices();

        $services = Service::where('status', 'active')->orderBy('id')->get();
        $selectedServices = $this->selectedServices();
        $selectedServiceIds = $selectedServices->pluck('id')->all();
        $selectedServicesCount = $selectedServices->count();
        $servicesAmount = (float) $selectedServices->sum('price');
        $detailService = $selectedServices->first() ?: $services->first();

        return view('frontend.exhibitions.booking.services', compact(
            'services',
            'selectedServices',
            'selectedServiceIds',
            'selectedServicesCount',
            'servicesAmount',
            'detailService',
        ));
    }

    public function toggleService(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
        ]);

        $service = Service::where('status', 'active')->findOrFail($validated['service_id']);
        $selectedIds = collect(session('exhibition_booking_services', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        $selectedIds = $selectedIds->contains($service->id)
            ? $selectedIds->reject(fn ($id) => $id === $service->id)->values()
            : $selectedIds->push($service->id)->unique()->values();

        session(['exhibition_booking_services' => $selectedIds->all()]);

        return redirect('/exhibitions/booking/services')
            ->with('status', $selectedIds->contains($service->id) ? 'Service selected.' : 'Service removed.');
    }

    public function review(): View
    {
        $this->ensureDefaultServices();

        $selectedServices = $this->selectedServices();
        $servicesAmount = (float) $selectedServices->sum('price');
        $boothPrice = 499.0;
        $slotPrice = 59.0;
        $taxAmount = round(($boothPrice + $slotPrice + $servicesAmount) * 0.10, 2);
        $totalAmount = $boothPrice + $slotPrice + $servicesAmount + $taxAmount;
        $selectedServicesLabel = $selectedServices->isNotEmpty()
            ? $selectedServices->pluck('title')->join(', ')
            : 'No extra services selected';

        return view('frontend.exhibitions.booking.review', compact(
            'selectedServices',
            'servicesAmount',
            'boothPrice',
            'slotPrice',
            'taxAmount',
            'totalAmount',
            'selectedServicesLabel',
        ));
    }

    private function selectedServices()
    {
        $selectedIds = collect(session('exhibition_booking_services', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($selectedIds->isEmpty()) {
            return collect();
        }

        return Service::where('status', 'active')
            ->whereIn('id', $selectedIds)
            ->orderBy('id')
            ->get();
    }

    private function ensureDefaultServices(): void
    {
        if (! Service::where('status', 'active')->exists()) {
            Service::syncDefaultCatalog();
        }
    }
}
