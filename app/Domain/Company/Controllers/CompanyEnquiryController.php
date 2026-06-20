<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Company\Repositories\CompanyRepository;
use App\Domain\Company\Requests\ReplyEnquiryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyEnquiryController extends Controller
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $enquiries = $this->companyRepository->getEnquiries($companyId);

        return view('backend.company.enquiries.index', compact('enquiries'));
    }

    public function show($id): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $enquiry = $this->companyRepository->findEnquiry($companyId, $id);

        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'open']);
        }

        return view('backend.company.enquiries.show', compact('enquiry'));
    }

    public function reply(ReplyEnquiryRequest $request, $id): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $enquiry = $this->companyRepository->findEnquiry($companyId, $id);
        $enquiry->update(['status' => 'replied']);

        return redirect()->route('company.enquiries.show', $enquiry->id)
            ->with('status', 'Your reply has been sent successfully to ' . $enquiry->name . '.');
    }
}
