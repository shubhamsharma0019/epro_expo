<?php

namespace App\Domain\Booth\Models;

use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class BoothMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booth_media';
    protected $guarded = ['id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function resolvedType(): string
    {
        $type = strtolower(trim((string) $this->type));

        if ($type === '360') {
            return '360';
        }

        if (filled($this->video_url) && $this->isVideoUrl((string) $this->video_url)) {
            return 'video';
        }

        $path = strtolower((string) $this->file_path);
        if (str_ends_with($path, '.pdf')) {
            return 'document';
        }
        if (preg_match('/\.(mp4|mov|webm|m4v)$/', $path)) {
            return 'video';
        }
        if (preg_match('/\.(jpg|jpeg|png|webp|gif|svg)$/', $path)) {
            return 'image';
        }

        if (filled($this->video_url) && blank($this->file_path)) {
            return 'image';
        }

        return in_array($type, ['image', 'video', 'document', '360'], true) ? $type : 'image';
    }

    public function mediaUrl(): ?string
    {
        if (filled($this->file_path)) {
            $path = ltrim((string) $this->file_path, '/');

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        }

        return filled($this->video_url) ? (string) $this->video_url : null;
    }

    public function thumbnailUrl(): string
    {
        if (filled($this->thumbnail)) {
            $path = ltrim((string) $this->thumbnail, '/');

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        }

        if ($this->resolvedType() === 'image') {
            return $this->mediaUrl() ?: asset('assets/exhibition/images/booth_banner.png');
        }

        if ($this->resolvedType() === 'video' && filled($this->video_url)) {
            return asset('assets/exhibition/images/booth_banner.png');
        }

        if ($this->resolvedType() === 'document') {
            return asset('assets/exhibition/images/booth_banner.png');
        }

        return asset('assets/exhibition/images/booth_banner.png');
    }

    /** @return array{all: int, image: int, video: int, document: int, 360: int} */
    public static function countByType(Collection $items): array
    {
        $counts = [
            'all' => $items->count(),
            'image' => 0,
            'video' => 0,
            'document' => 0,
            '360' => 0,
        ];

        foreach ($items as $item) {
            $type = $item instanceof self ? $item->resolvedType() : 'image';
            if (array_key_exists($type, $counts)) {
                $counts[$type]++;
            }
        }

        return $counts;
    }

    private function isVideoUrl(string $url): bool
    {
        $url = strtolower($url);

        return str_contains($url, 'youtube.com')
            || str_contains($url, 'youtu.be')
            || str_contains($url, 'vimeo.com')
            || preg_match('/\.(mp4|mov|webm|m4v)(\?|$)/', $url) === 1;
    }
}
