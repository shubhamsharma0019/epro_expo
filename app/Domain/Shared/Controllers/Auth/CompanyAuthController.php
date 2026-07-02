<?php

namespace App\Domain\Shared\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Company\Models\Company;
use App\Domain\Shared\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompanyAuthController extends Controller
{
    public function showLogin(Request $request): RedirectResponse|\Illuminate\View\View
    {
        Session::forget('company_flow_context');

        if ($request->session()->has('company_id')) {
            return redirect()->route('company.dashboard');
        }

        return view('frontend.auth.company-login');
    }

    public function showEventCompanyLogin(Request $request): RedirectResponse|\Illuminate\View\View
    {
        if ($request->session()->has('company_id') && Session::get('company_flow_context') === 'event_company') {
            return redirect()->route('company.event-company-flow.dashboard');
        }

        if ($request->session()->has('company_id')) {
            Session::forget(['company_id', 'company_name', 'company_booth_booking', 'company_event_flow_event_id']);
        }

        Session::put('company_flow_context', 'event_company');

        return view('frontend.auth.company-event-login');
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

        $this->ensureUserRecordForCompany($company);

        $request->session()->regenerate();
        Session::put('company_id', $company->id);
        Session::forget('company_flow_context');
        Session::forget('company_event_flow_event_id');
        Session::forget('activeExhibitionSlug');
        Session::forget('selected_visitor_booking_id');
        Session::forget('visitor_pass_active');
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

        if (($company->account_type ?? 'exhibitor') !== 'event') {
            $company->forceFill(['account_type' => 'event'])->save();
        }

        $this->ensureUserRecordForCompany($company);

        $request->session()->regenerate();
        Session::put('company_id', $company->id);
        Session::put('company_flow_context', 'event_company');
        Session::forget('company_event_flow_event_id');
        Session::forget('activeExhibitionSlug');
        Session::forget('selected_visitor_booking_id');
        Session::forget('visitor_pass_active');
        $request->session()->save();

        return redirect('/company/event-company-flow/dashboard');
    }

    public function showRegister(Request $request): RedirectResponse|\Illuminate\View\View
    {
        $flowContext = $request->query('flow') === 'event_company' ? 'event_company' : null;

        if ($flowContext === 'event_company') {
            Session::put('company_flow_context', 'event_company');
        } else {
            Session::forget('company_flow_context');
        }

        if ($request->session()->has('company_id')) {
            if ($flowContext === 'event_company') {
                return redirect()->route('company.event-company-flow.dashboard');
            }
            return redirect()->route('company.dashboard');
        }

        return view('frontend.auth.company-register', compact('flowContext'));
    }

    public function showEventCompanyRegister(Request $request): RedirectResponse|\Illuminate\View\View
    {
        if ($request->session()->has('company_id') && Session::get('company_flow_context') === 'event_company') {
            return redirect()->route('company.event-company-flow.dashboard');
        }

        if ($request->session()->has('company_id')) {
            Session::forget(['company_id', 'company_name', 'company_booth_booking', 'company_event_flow_event_id']);
        }

        Session::put('company_flow_context', 'event_company');

        return view('frontend.auth.company-register', ['flowContext' => 'event_company']);
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
        $isEventCompanyRegister = $request->input('flow_context') === 'event_company'
            || $request->routeIs('company.event-company.register.store')
            || str_contains((string) $request->headers->get('referer'), '/company/event-company/register')
            || str_contains($request->path(), 'company/event-company/register');
        $flowContext = $isEventCompanyRegister ? 'event_company' : null;

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
            'account_type' => $flowContext === 'event_company' ? 'event' : 'exhibitor',
        ]);

        $this->ensureUserRecordForCompany($company);

        $request->session()->regenerate();
        Session::put('company_id', $company->id);
        Session::forget('company_flow_context');
        Session::forget('company_event_flow_event_id');
        Session::forget('activeExhibitionSlug');
        Session::forget('selected_visitor_booking_id');
        Session::forget('visitor_pass_active');
        if ($flowContext === 'event_company') {
            Session::put('company_flow_context', 'event_company');
            $request->session()->save();

            return redirect()->route('company.event-company-flow.dashboard');
        }

        Session::forget('company_flow_context');
        $request->session()->save();

        return redirect('/company/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Session::forget('company_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/company/login');
    }

    private function ensureUserRecordForCompany(Company $company): void
    {
        if ($company->user_id) {
            $user = User::find($company->user_id);
            if ($user) {
                if ($user->email !== $company->email || $user->password !== $company->password) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'name' => $company->company_name ?: $company->name ?: $company->contact_person_name,
                            'email' => $company->email,
                            'password' => $company->password,
                            'phone' => $company->phone,
                            'updated_at' => now(),
                        ]);
                }
                return;
            }
        }

        // Find by email
        $user = User::where('email', $company->email)->first();
        if ($user) {
            $company->update(['user_id' => $user->id]);
            if ($user->password !== $company->password || $user->role !== 'company') {
                $updateData = [
                    'password' => $company->password,
                    'updated_at' => now(),
                ];
                if ($user->role !== 'company' && $user->role !== 'admin') {
                    $updateData['role'] = 'company';
                }
                DB::table('users')
                    ->where('id', $user->id)
                    ->update($updateData);
            }
        } else {
            // Create user
            $userId = DB::table('users')->insertGetId([
                'name' => $company->company_name ?: $company->name ?: $company->contact_person_name,
                'email' => $company->email,
                'phone' => $company->phone,
                'password' => $company->password,
                'role' => 'company',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $company->update(['user_id' => $userId]);
        }
    }
}












