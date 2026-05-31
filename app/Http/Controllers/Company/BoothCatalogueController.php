<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests\Company\BoothCatalogueRequest;
use App\Models\BoothBooking;
use App\Models\BoothCatalogue;
use App\Services\Company\BoothFileUploadService;
use App\Services\Company\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothCatalogueController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.catalogues', $this->commonData($booking, $steps) + ['catalogues' => $booking->boothCatalogues()->latest()->get()]);
    }
    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }
    public function show(BoothBooking $booking, BoothCatalogue $catalogue, BoothSetupStepService $steps): View { return $this->edit($booking, $catalogue, $steps); }
    public function store(BoothCatalogueRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->safe()->except(['file', 'cover_image']);
        $data['file_path'] = $files->upload($request->file('file'), $booking->id, 'catalogues');
        $data['file_size'] = $files->size($request->file('file'));
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $files->upload($request->file('cover_image'), $booking->id, 'catalogues');
        }
        BoothCatalogue::create($data + ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id]);
        $steps->markStepCompleted($booking, 'catalogues');
        return back()->with('status', 'Catalogue saved.');
    }
    public function edit(BoothBooking $booking, BoothCatalogue $catalogue, BoothSetupStepService $steps): View
    {
        abort_unless($catalogue->company_id === (int) session('company_id') && $catalogue->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.catalogues', $this->commonData($booking, $steps) + ['catalogue' => $catalogue, 'catalogues' => $booking->boothCatalogues()->latest()->get()]);
    }
    public function update(BoothCatalogueRequest $request, BoothBooking $booking, BoothCatalogue $catalogue, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($catalogue->company_id === (int) session('company_id') && $catalogue->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $data = $request->safe()->except(['file', 'cover_image']);
        if ($request->hasFile('file')) {
            $data['file_path'] = $files->upload($request->file('file'), $booking->id, 'catalogues', $catalogue->file_path);
            $data['file_size'] = $files->size($request->file('file'));
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $files->upload($request->file('cover_image'), $booking->id, 'catalogues', $catalogue->cover_image);
        }
        $catalogue->update($data);
        $steps->markStepCompleted($booking, 'catalogues');
        return back()->with('status', 'Catalogue updated.');
    }
    public function destroy(BoothBooking $booking, BoothCatalogue $catalogue, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($catalogue->company_id === (int) session('company_id') && $catalogue->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $files->delete($catalogue->file_path);
        $files->delete($catalogue->cover_image);
        $catalogue->delete();
        $booking->boothCatalogues()->exists() ? $steps->markStepCompleted($booking, 'catalogues') : $steps->markStepPending($booking, 'catalogues');
        return back()->with('status', 'Catalogue deleted.');
    }
}
