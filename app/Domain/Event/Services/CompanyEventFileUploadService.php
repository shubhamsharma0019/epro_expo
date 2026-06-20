<?php

namespace App\Domain\Event\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyEventFileUploadService
{
    public function upload(UploadedFile $file, int $companyEventId, string $section, ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $file->store("company-events/{$companyEventId}/{$section}", 'public');
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
