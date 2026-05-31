<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests\Company\BoothDocumentRequest;
use App\Models\BoothBooking;
use App\Models\BoothDocument;
use App\Services\Company\BoothFileUploadService;
use App\Services\Company\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothDocumentController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.documents', $this->commonData($booking, $steps) + ['documents' => $booking->boothDocuments()->latest()->get()]);
    }

    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }

    public function show(BoothBooking $booking, BoothDocument $document, BoothSetupStepService $steps): View
    {
        return $this->edit($booking, $document, $steps);
    }

    public function store(BoothDocumentRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $file = $request->file('file');
        BoothDocument::create($request->safe()->except('file') + [
            'company_id' => $booking->company_id,
            'booth_booking_id' => $booking->id,
            'file_path' => $files->upload($file, $booking->id, 'documents'),
            'file_type' => $files->extension($file),
            'file_size' => $files->size($file),
        ]);
        $booking->boothDocuments()->where('visibility', 'public')->exists()
            ? $steps->markStepCompleted($booking, 'documents')
            : $steps->markStepInProgress($booking, 'documents');
        return back()->with('status', 'Document uploaded.');
    }

    public function edit(BoothBooking $booking, BoothDocument $document, BoothSetupStepService $steps): View
    {
        abort_unless($document->company_id === (int) session('company_id') && $document->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.documents', $this->commonData($booking, $steps) + ['document' => $document, 'documents' => $booking->boothDocuments()->latest()->get()]);
    }

    public function update(BoothDocumentRequest $request, BoothBooking $booking, BoothDocument $document, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($document->company_id === (int) session('company_id') && $document->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $data = $request->safe()->except('file');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $files->upload($file, $booking->id, 'documents', $document->file_path);
            $data['file_type'] = $files->extension($file);
            $data['file_size'] = $files->size($file);
        }
        $document->update($data);
        $booking->boothDocuments()->where('visibility', 'public')->exists()
            ? $steps->markStepCompleted($booking, 'documents')
            : $steps->markStepInProgress($booking, 'documents');
        return back()->with('status', 'Document updated.');
    }

    public function destroy(BoothBooking $booking, BoothDocument $document, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($document->company_id === (int) session('company_id') && $document->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $files->delete($document->file_path);
        $document->delete();
        $booking->boothDocuments()->where('visibility', 'public')->exists()
            ? $steps->markStepCompleted($booking, 'documents')
            : $steps->markStepPending($booking, 'documents');
        return back()->with('status', 'Document deleted.');
    }
}
