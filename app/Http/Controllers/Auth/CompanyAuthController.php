<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CompanyAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.company-login');
    }

    public function showEventCompanyLogin(): View
    {
        return view('auth.company-event-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $company = Company::where('email', $credentials['email'])->first();

        if (! $company || ! Hash::check($credentials['password'], $company->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        Session::put('company_id', $company->id);
        $request->session()->save();

        return redirect('/company/dashboard');
    }

    public function loginEventCompany(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $company = Company::where('email', $credentials['email'])->first();

        if (! $company || ! Hash::check($credentials['password'], $company->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        Session::put('company_id', $company->id);
        Session::put('company_flow_context', 'event_company');
        $request->session()->save();

        return redirect('/company/event-company-flow/dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.company-register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $company = Company::create([
            'company_name' => $data['company_name'],
            'contact_person_name' => $data['contact_person_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'website' => $data['website'] ?? null,
            'industry' => $data['industry'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
            'password' => Hash::make($data['password']),
            'status' => 'approved',
        ]);

        $request->session()->regenerate();
        Session::put('company_id', $company->id);

        return redirect('/company/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Session::forget('company_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/company/login');
    }
}
