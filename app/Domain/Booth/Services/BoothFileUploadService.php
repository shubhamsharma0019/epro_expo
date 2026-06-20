<?php

namespace App\Domain\Booth\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BoothFileUploadService
{
    public function upload(UploadedFile $file, int $bookingId, string $section, ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $file->store("booth-setups/{$bookingId}/{$section}", 'public');
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function size(?UploadedFile $file): ?int
    {
        return $file ? $file->getSize() : null;
    }

    public function extension(?UploadedFile $file): ?string
    {
        return $file ? strtolower($file->getClientOriginalExtension()) : null;
    }
}
