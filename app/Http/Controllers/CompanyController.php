<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()?->can('company-list'), 403);

        $query = Company::withCount('locations');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('industry', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $companies = $query->latest()->paginate(15)->withQueryString();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        abort_if(!auth()->user()?->can('company-create'), 403);

        return view('companies.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('company-create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'email' => 'nullable|email|unique:companies,email',
            'telephone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'tax_number' => 'nullable|string|max:50|unique:companies,tax_number',
            'registration_number' => 'nullable|string|max:50|unique:companies,registration_number',
            'industry' => 'nullable|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,active,inactive,blocked',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        $company = Company::create($validated);

        return redirect()->route('companies.show', $company)
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        abort_if(!auth()->user()?->can('company-list'), 403);

        $company->load(['locations', 'subscriptions']);

        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        abort_if(!auth()->user()?->can('company-edit'), 403);

        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        abort_if(!auth()->user()?->can('company-edit'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,'.$company->id,
            'email' => 'nullable|email|unique:companies,email,'.$company->id,
            'telephone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tax_number' => 'nullable|string|max:50|unique:companies,tax_number,'.$company->id,
            'registration_number' => 'nullable|string|max:50|unique:companies,registration_number,'.$company->id,
            'industry' => 'nullable|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,active,inactive,blocked',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        // Regenerate slug only if name changed
        if ($validated['name'] !== $company->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $company->update($validated);

        return redirect()->route('companies.show', $company)
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        abort_if(!auth()->user()?->can('company-delete'), 403);

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
