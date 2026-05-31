<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyEnquiryController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $enquiries = Enquiry::where('company_id', $companyId)
            ->latest()
            ->get();

        return view('company.enquiries.index', compact('enquiries'));
    }

    public function show($id): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $enquiry = Enquiry::where('company_id', $companyId)->findOrFail($id);

        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'open']);
        }

        return view('company.enquiries.show', compact('enquiry'));
    }

    public function reply(Request $request, $id): RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $request->validate([
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ]);

        $enquiry = Enquiry::where('company_id', $companyId)->findOrFail($id);
        $enquiry->update(['status' => 'replied']);

        return redirect()->route('company.enquiries.show', $enquiry->id)
            ->with('status', 'Your reply has been sent successfully to ' . $enquiry->name . '.');
    }
}
