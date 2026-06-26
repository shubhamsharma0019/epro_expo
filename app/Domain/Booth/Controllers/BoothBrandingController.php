<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothBrandingRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothBranding;
use App\Domain\Booth\Services\BoothFileUploadService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothBrandingController extends BaseBoothSetupController
{
    public function edit(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $steps->markStepInProgress($booking, 'branding');

        return view('company.booth-setup.branding', $this->commonData($booking, $steps) + [
            'branding' => $booking->boothBranding,
        ]);
    }

    public function update(BoothBrandingRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse|JsonResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        $action = $data['action'] ?? 'save';
        unset($data['action']);
        unset($data['preset_background']);
        $existing = $booking->boothBranding;

        if ($action === 'reset') {
            if ($existing) {
                $files->delete($existing->booth_banner);
                $files->delete($existing->booth_background);
                $existing->delete();
            }

            $steps->markStepPending($booking, 'branding');

            return back()->with('status', 'Booth branding reset to default.');
        }

        foreach (['booth_banner' => 'branding', 'booth_background' => 'branding'] as $field => $section) {
            if ($request->hasFile($field)) {
                $data[$field] = $files->upload($request->file($field), $booking->id, $section, $existing?->{$field});
            }
        }

        if ($request->filled('preset_background') && !$request->hasFile('booth_background')) {
            $data['booth_background'] = $request->input('preset_background');
            if ($existing?->booth_background && !str_starts_with($existing->booth_background, 'assets/')) {
                $files->delete($existing->booth_background);
            }
        }

        $data += ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id];
        $branding = BoothBranding::updateOrCreate(['booth_booking_id' => $booking->id], $data);
        $steps->markStepCompleted($booking, 'branding');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Booth branding saved.',
                'branding_id' => $branding->id,
                'next_url' => route('company.booth-setup.products.index', $booking),
            ]);
        }

        if ($action === 'continue') {
            return redirect()
                ->route('company.booth-setup.products.index', $booking)
                ->with('status', 'Booth branding saved. Continue by adding products.');
        }

        return back()->with('status', 'Booth branding saved.');
    }
}
