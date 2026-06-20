<?php

namespace App\Domain\Company\Repositories;

use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Company\Models\CompanyDocument;

class CompanyRepository
{
    public function find(int $id): ?Company
    {
        return Company::find($id);
    }

    public function findWithCount(int $id, array $counts): ?Company
    {
        return Company::query()->withCount($counts)->find($id);
    }

    public function findByEmail(string $email): ?Company
    {
        return Company::where('email', $email)->first();
    }

    public function getEnquiries(int $companyId)
    {
        return Enquiry::where('company_id', $companyId)->latest()->get();
    }

    public function findEnquiry(int $companyId, int $id): Enquiry
    {
        return Enquiry::where('company_id', $companyId)->findOrFail($id);
    }

    public function getMeetings(int $companyId)
    {
        return CompanyMeeting::where('company_id', $companyId)
            ->with(['visitor', 'booth'])
            ->latest()
            ->get();
    }

    public function getDocuments(int $companyId)
    {
        return CompanyDocument::where('company_id', $companyId)->get();
    }
}
