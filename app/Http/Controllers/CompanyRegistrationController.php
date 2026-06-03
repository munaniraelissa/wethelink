<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('dashboard.company-registration');
    }

    public function registerCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'email' => 'required|email|unique:companies,email',
            'telephone' => 'required|string|max:20',
            'website' => 'nullable|url',
            'tax_number' => 'nullable|string|max:50|unique:companies,tax_number',
            'registration_number' => 'nullable|string|max:50|unique:companies,registration_number',
            'industry' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = 'pending';

        $company = Company::create($validated);

        Subscription::create([
            'company_id' => $company->id,
            'subscription_package_id' => 1,
            'approval_status' => 'pending',
            'status' => 'pending',
        ]);

        return redirect()->route('login')
            ->with('success', __('subscriptions.company_registration_pending'));
    }
}
