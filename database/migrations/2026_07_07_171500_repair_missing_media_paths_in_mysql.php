<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const DEFAULT_EXHIBITION_BANNERS = [
        'https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=1200&q=80',
        'images/exhibitions/hero-book-exhibition.png',
        'images/exhibitions/hero-pavilion-scene.png',
        'images/exhibitions/info-custom-booth.png',
    ];

    private const DEFAULT_EVENT_BANNERS = [
        'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1505373877841-8d25f0024753?auto=format&fit=crop&w=1200&q=80',
        'images/events-home/banners/animated/business-enterprise.svg',
    ];

    private const HALL_IMAGE_MAP = [
        'innovation-pavilion' => 'images/exhibitions/pavilion-innovation-card.png',
        'business-pavilion' => 'images/exhibitions/info-custom-booth.png',
        'healthcare-pavilion' => 'images/exhibitions/hero-pavilion-scene.png',
        'education-pavilion' => 'images/exhibitions/hero-book-exhibition.png',
        'sustainability-pavilion' => 'images/exhibitions/hero-pavilion-scene.png',
        'automotive-pavilion' => 'images/exhibitions/info-custom-booth.png',
    ];

    public function up(): void
    {
        $this->repairExhibitions();
        $this->repairPavilions();
        $this->repairHalls();
        $this->repairBoothBrandings();
        $this->repairBoothProfiles();
        $this->repairCompanies();
        $this->repairCompanyEventBrandings();
    }

    public function down(): void
    {
        // Non-destructive data repair migration.
    }

    private function repairExhibitions(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        $rows = DB::table('exhibitions')->select('id', 'banner_url', 'banner_image')->orderBy('id')->get();

        foreach ($rows as $index => $row) {
            $fallback = self::DEFAULT_EXHIBITION_BANNERS[$index % count(self::DEFAULT_EXHIBITION_BANNERS)];
            $bannerUrl = $this->usablePath($row->banner_url) ?: $fallback;
            $bannerImage = $this->usablePath($row->banner_image) ?: $bannerUrl;

            if ($bannerUrl !== $row->banner_url || $bannerImage !== $row->banner_image) {
                DB::table('exhibitions')->where('id', $row->id)->update([
                    'banner_url' => $bannerUrl,
                    'banner_image' => $bannerImage,
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function repairPavilions(): void
    {
        if (! Schema::hasTable('pavilions') || ! Schema::hasColumn('pavilions', 'image')) {
            return;
        }

        foreach (DB::table('pavilions')->select('id', 'image')->orderBy('id')->get() as $index => $row) {
            if ($this->usablePath($row->image)) {
                continue;
            }

            DB::table('pavilions')->where('id', $row->id)->update([
                'image' => self::DEFAULT_EXHIBITION_BANNERS[$index % count(self::DEFAULT_EXHIBITION_BANNERS)],
                'updated_at' => now(),
            ]);
        }
    }

    private function repairHalls(): void
    {
        if (! Schema::hasTable('halls') || ! Schema::hasColumn('halls', 'image')) {
            return;
        }

        foreach (DB::table('halls')->select('id', 'image')->orderBy('id')->get() as $row) {
            if ($this->usablePath($row->image)) {
                continue;
            }

            $fallback = 'images/exhibitions/hero-pavilion-scene.png';
            $image = (string) ($row->image ?? '');

            foreach (self::HALL_IMAGE_MAP as $needle => $mapped) {
                if (str_contains($image, $needle)) {
                    $fallback = $mapped;
                    break;
                }
            }

            DB::table('halls')->where('id', $row->id)->update([
                'image' => $fallback,
                'updated_at' => now(),
            ]);
        }
    }

    private function repairBoothBrandings(): void
    {
        if (! Schema::hasTable('booth_brandings') || ! Schema::hasColumn('booth_brandings', 'booth_banner')) {
            return;
        }

        $bookings = DB::table('booth_brandings')
            ->join('booth_bookings', 'booth_bookings.id', '=', 'booth_brandings.booth_booking_id')
            ->leftJoin('exhibitions', 'exhibitions.id', '=', 'booth_bookings.exhibition_id')
            ->select(
                'booth_brandings.id',
                'booth_brandings.booth_banner',
                'exhibitions.banner_url',
                'exhibitions.banner_image'
            )
            ->get();

        foreach ($bookings as $row) {
            if ($this->usablePath($row->booth_banner)) {
                continue;
            }

            $fallback = $this->usablePath($row->banner_url)
                ?: $this->usablePath($row->banner_image)
                ?: self::DEFAULT_EXHIBITION_BANNERS[0];

            DB::table('booth_brandings')->where('id', $row->id)->update([
                'booth_banner' => $fallback,
                'updated_at' => now(),
            ]);
        }
    }

    private function repairBoothProfiles(): void
    {
        if (! Schema::hasTable('booth_profiles')) {
            return;
        }

        $rows = DB::table('booth_profiles')
            ->leftJoin('booth_bookings', 'booth_bookings.id', '=', 'booth_profiles.booth_booking_id')
            ->leftJoin('exhibitions', 'exhibitions.id', '=', 'booth_bookings.exhibition_id')
            ->leftJoin('booth_brandings', 'booth_brandings.booth_booking_id', '=', 'booth_profiles.booth_booking_id')
            ->select(
                'booth_profiles.id',
                'booth_profiles.company_logo',
                'booth_profiles.booth_banner',
                'exhibitions.banner_url',
                'exhibitions.banner_image',
                'booth_brandings.booth_banner as branding_banner'
            )
            ->get();

        foreach ($rows as $row) {
            $updates = [];

            if (! $this->usablePath($row->company_logo)) {
                $updates['company_logo'] = $this->usablePath($row->branding_banner)
                    ?: $this->usablePath($row->banner_url)
                    ?: $this->usablePath($row->banner_image)
                    ?: self::DEFAULT_EXHIBITION_BANNERS[1];
            }

            if (Schema::hasColumn('booth_profiles', 'booth_banner') && ! $this->usablePath($row->booth_banner)) {
                $updates['booth_banner'] = $this->usablePath($row->branding_banner)
                    ?: $this->usablePath($row->banner_url)
                    ?: self::DEFAULT_EXHIBITION_BANNERS[0];
            }

            if ($updates !== []) {
                $updates['updated_at'] = now();
                DB::table('booth_profiles')->where('id', $row->id)->update($updates);
            }
        }
    }

    private function repairCompanies(): void
    {
        if (! Schema::hasTable('companies') || ! Schema::hasColumn('companies', 'logo')) {
            return;
        }

        foreach (DB::table('companies')->select('id', 'logo')->get() as $row) {
            if ($this->usablePath($row->logo)) {
                continue;
            }

            $profileLogo = DB::table('booth_profiles')
                ->join('booth_bookings', 'booth_bookings.id', '=', 'booth_profiles.booth_booking_id')
                ->where('booth_bookings.company_id', $row->id)
                ->whereNotNull('booth_profiles.company_logo')
                ->orderByDesc('booth_profiles.id')
                ->value('booth_profiles.company_logo');

            $fallback = $this->usablePath($profileLogo) ?: null;

            DB::table('companies')->where('id', $row->id)->update([
                'logo' => $fallback,
                'updated_at' => now(),
            ]);
        }
    }

    private function repairCompanyEventBrandings(): void
    {
        if (! Schema::hasTable('company_event_brandings')) {
            return;
        }

        foreach (DB::table('company_event_brandings')->select('id', 'banner_path', 'logo_path')->orderBy('id')->get() as $index => $row) {
            $updates = [];
            $fallback = self::DEFAULT_EVENT_BANNERS[$index % count(self::DEFAULT_EVENT_BANNERS)];

            if (Schema::hasColumn('company_event_brandings', 'banner_path') && ! $this->usablePath($row->banner_path)) {
                $updates['banner_path'] = $fallback;
            }

            if (Schema::hasColumn('company_event_brandings', 'logo_path') && ! $this->usablePath($row->logo_path)) {
                $updates['logo_path'] = $fallback;
            }

            if ($updates !== []) {
                $updates['updated_at'] = now();
                DB::table('company_event_brandings')->where('id', $row->id)->update($updates);
            }
        }
    }

    private function usablePath(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (str_starts_with($normalized, 'storage/')) {
            $normalized = substr($normalized, 8);
        }

        if (file_exists(storage_path('app/public/' . $normalized))) {
            return $path;
        }

        if (file_exists(public_path($path))) {
            return $path;
        }

        if (file_exists(public_path('storage/' . $normalized))) {
            return str_starts_with($path, 'storage/') ? $path : 'storage/' . $normalized;
        }

        return null;
    }
};
