<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    use ActionLogTrait;

    public function index(Request $request)
    {
        $companies = Company::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:companies,slug',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|integer|min:0',
            'status' => ['nullable', Rule::in(['pending', 'active', 'inactive', 'blocked'])],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['status'] = $data['status'] ?? 'pending';

        $company = Company::create($data);

        Log::info('Company created', array_merge($this->actionLogContext($request), [
            'company_id' => $company->id,
            'name' => $company->name,
            'status' => $company->status,
        ]));

        return response()->json([
            'message' => 'Company created successfully',
            'company' => $company,
        ], 201);
    }

    public function show(Company $company)
    {
        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('companies', 'slug')->ignore($company->id)],
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|integer|min:0',
            'status' => ['nullable', Rule::in(['pending', 'active', 'inactive', 'blocked'])],
        ]);

        if (! isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $company->update($data);

        Log::info('Company updated', array_merge($this->actionLogContext($request), [
            'company_id' => $company->id,
            'updated' => array_keys($data),
        ]));

        return response()->json([
            'message' => 'Company updated successfully',
            'company' => $company,
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        Log::info('Company deleted', array_merge($this->actionLogContext(), [
            'company_id' => $company->id,
            'name' => $company->name,
        ]));

        return response()->json([
            'message' => 'Company deleted successfully',
        ]);
    }
}
