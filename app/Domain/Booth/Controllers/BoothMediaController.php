<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothMediaRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMedia;
use App\Domain\Booth\Services\BoothFileUploadService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BoothMediaController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);

        return view('company.booth-setup.media', $this->mediaPageData($booking, $steps));
    }

    /** @return array<string, mixed> */
    private function mediaPageData(BoothBooking $booking, BoothSetupStepService $steps, ?BoothMedia $mediaItem = null): array
    {
        $mediaItems = $booking->boothMedia()->active()->latest()->get();
        $used = (int) $mediaItems->sum('file_size');

        return $this->commonData($booking, $steps) + [
            'mediaItem' => $mediaItem,
            'mediaItems' => $mediaItems,
            'mediaCounts' => BoothMedia::countByType($mediaItems),
            'storageUsagePercent' => min(100, (int) round($used / (100 * 1024 * 1024) * 100)),
        ];
    }
    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }
    public function show(BoothBooking $booking, BoothMedia $medium, BoothSetupStepService $steps): View { return $this->edit($booking, $medium, $steps); }
    public function store(BoothMediaRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->safe()->except(['file', 'files', 'thumbnail']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $files->upload($request->file('thumbnail'), $booking->id, 'media');
        }

        $uploadedFiles = collect($request->file('files', []));
        if ($request->hasFile('file')) {
            $uploadedFiles->push($request->file('file'));
        }

        if ($uploadedFiles->isEmpty()) {
            BoothMedia::create($data + [
                'company_id' => $booking->company_id,
                'booth_booking_id' => $booking->id,
                'title' => $data['title'] ?? 'Video Link',
                'file_path' => '',
                'file_size' => null,
            ]);
        } else {
            $uploadedFiles->values()->each(function (UploadedFile $file, int $index) use ($booking, $data, $files, $uploadedFiles) {
                $fileData = $data;
                $fileData['file_path'] = $files->upload($file, $booking->id, 'media');
                $fileData['file_size'] = $files->size($file);
                $fileData['type'] = $this->mediaTypeFromFile($file, $fileData['type'] ?? 'image');

                if ($uploadedFiles->count() > 1) {
                    $fileData['title'] = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        ->replace(['-', '_'], ' ')
                        ->title()
                        ->toString() ?: ($data['title'] . ' ' . ($index + 1));
                    $fileData['sort_order'] = (int) ($data['sort_order'] ?? 0) + $index;
                } elseif (blank($fileData['title'] ?? null)) {
                    $fileData['title'] = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        ->replace(['-', '_'], ' ')
                        ->title()
                        ->toString();
                }

                BoothMedia::create($fileData + [
                    'company_id' => $booking->company_id,
                    'booth_booking_id' => $booking->id,
                ]);
            });
        }

        $steps->markStepCompleted($booking, 'media');
        return back()->with('status', $uploadedFiles->count() > 1 ? 'Media files saved.' : 'Media saved.');
    }
    public function edit(BoothBooking $booking, BoothMedia $medium, BoothSetupStepService $steps): View
    {
        abort_unless($medium->company_id === (int) session('company_id') && $medium->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.media', $this->mediaPageData($booking, $steps, $medium));
    }
    public function update(BoothMediaRequest $request, BoothBooking $booking, BoothMedia $medium, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($medium->company_id === (int) session('company_id') && $medium->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $data = $request->safe()->except(['file', 'files', 'thumbnail']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $files->upload($file, $booking->id, 'media', $medium->file_path);
            $data['file_size'] = $files->size($file);
            $data['type'] = $this->mediaTypeFromFile($file, $data['type'] ?? $medium->type);
            if (blank($data['title'] ?? null)) {
                $data['title'] = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    ->replace(['-', '_'], ' ')
                    ->title()
                    ->toString();
            }
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $files->upload($request->file('thumbnail'), $booking->id, 'media', $medium->thumbnail);
        }
        $medium->update($data);
        $steps->markStepCompleted($booking, 'media');
        return back()->with('status', 'Media updated.');
    }
    public function destroy(BoothBooking $booking, BoothMedia $medium, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($medium->company_id === (int) session('company_id') && $medium->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $files->delete($medium->file_path);
        $files->delete($medium->thumbnail);
        $medium->delete();
        $booking->boothMedia()->exists() ? $steps->markStepCompleted($booking, 'media') : $steps->markStepPending($booking, 'media');
        return back()->with('status', 'Media deleted.');
    }

    private function mediaTypeFromFile(UploadedFile $file, string $fallback): string
    {
        $mime = (string) $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());

        return match (true) {
            str_starts_with($mime, 'image/') => 'image',
            str_starts_with($mime, 'video/') => 'video',
            $extension === 'pdf' => 'document',
            default => $fallback,
        };
    }
}
