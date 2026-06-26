<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyProfileRequest;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Repositories\CompanyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function edit(): View|RedirectResponse
    {
        $company = $this->currentCompany();

        if (! $company) {
            return redirect('/company/login');
        }

        $latestBoothProfile = $company->boothBookings()
            ->with('boothProfile')
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->latest()
            ->first()
            ?->boothProfile;

        return view('company.profile.company-profile', compact('company', 'latestBoothProfile'));
    }

    public function update(CompanyProfileRequest $request): RedirectResponse|JsonResponse
    {
        $company = $this->currentCompany();

        if (! $company) {
            return redirect('/company/login');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $this->deleteLogo($company->logo);
            $data['logo'] = 'storage/' . $request->file('logo')->store('companies/logos', 'public');
        }

        $company->update($data + [
            'name' => $data['company_name'],
            'owner_name' => $data['contact_person_name'],
        ]);

        $latestBooking = $company->boothBookings()
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->latest()
            ->first();

        if ($latestBooking) {
            $profileLogoPath = $company->logo;
            if ($profileLogoPath && str_starts_with($profileLogoPath, 'storage/')) {
                $profileLogoPath = substr($profileLogoPath, strlen('storage/'));
            }

            $latestBooking->boothProfile()->updateOrCreate(
                ['booth_booking_id' => $latestBooking->id],
                [
                    'company_id' => $company->id,
                    'company_logo' => $profileLogoPath ?: $latestBooking->boothProfile?->company_logo,
                    'company_name' => $data['company_name'],
                    'contact_person' => $data['contact_person_name'],
                    'industry' => $data['industry'] ?? null,
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'website' => $data['website'] ?? null,
                    'about_company' => $data['about'] ?? null,
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                    'country' => $data['country'] ?? null,
                    'booth_title' => $latestBooking->boothProfile?->booth_title ?: $data['company_name'],
                ]
            );
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Company profile saved.',
                'company_id' => $company->id,
            ]);
        }

        return back()->with('status', 'Company profile saved.');
    }

    private function currentCompany(): ?Company
    {
        $companyId = session('company_id');

        return $companyId ? $this->companyRepository->find($companyId) : null;
    }

    private function deleteLogo(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'storage/')) {
            return;
        }

        $storagePath = substr($path, strlen('storage/'));

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }
}
