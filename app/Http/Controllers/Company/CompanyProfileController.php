<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyProfileRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(): View|RedirectResponse
    {
        $company = $this->currentCompany();

        if (! $company) {
            return redirect('/company/login');
        }

        return view('company.profile', compact('company'));
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

        return $companyId ? Company::find($companyId) : null;
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
