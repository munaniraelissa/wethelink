<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyLocation;
use Illuminate\Http\Request;

class CompanyLocationController extends Controller
{
    public function index(Company $company)
    {
        $locations = $company->locations()->latest()->paginate(15);

        return view('companies.locations.index', compact('company', 'locations'));
    }

    public function create(Company $company)
    {
        return view('companies.locations.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'telephone'     => 'nullable|string|max:20',
            'manager_name'  => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'district'      => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:1000',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'is_head_office'=> 'boolean',
            'status'        => 'required|in:active,inactive',
        ]);

        $validated['company_id'] = $company->id;

        // Ensure only one head office per company
        if (!empty($validated['is_head_office'])) {
            $company->locations()->where('is_head_office', true)->update(['is_head_office' => false]);
        }

        $location = CompanyLocation::create($validated);

        return redirect()->route('companies.locations.show', [$company, $location])
            ->with('success', 'Location created successfully.');
    }

    public function show(Company $company, CompanyLocation $location)
    {
        $this->authorizeLocation($company, $location);

        return view('companies.locations.show', compact('company', 'location'));
    }

    public function edit(Company $company, CompanyLocation $location)
    {
        $this->authorizeLocation($company, $location);

        return view('companies.locations.edit', compact('company', 'location'));
    }

    public function update(Request $request, Company $company, CompanyLocation $location)
    {
        $this->authorizeLocation($company, $location);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'telephone'     => 'nullable|string|max:20',
            'manager_name'  => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'district'      => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:1000',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'is_head_office'=> 'boolean',
            'status'        => 'required|in:active,inactive',
        ]);

        // Ensure only one head office per company
        if (!empty($validated['is_head_office'])) {
            $company->locations()
                ->where('id', '!=', $location->id)
                ->where('is_head_office', true)
                ->update(['is_head_office' => false]);
        }

        $location->update($validated);

        return redirect()->route('companies.locations.show', [$company, $location])
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Company $company, CompanyLocation $location)
    {
        $this->authorizeLocation($company, $location);

        $location->delete();

        return redirect()->route('companies.locations.index', $company)
            ->with('success', 'Location deleted successfully.');
    }

    private function authorizeLocation(Company $company, CompanyLocation $location): void
    {
        if ($location->company_id !== $company->id) {
            abort(404);
        }
    }
}