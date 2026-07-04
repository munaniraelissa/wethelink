<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()?->can('brand-list'), 403);

        $query = Brand::query()
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $brands = $query->paginate(15);
        $statuses = ['active', 'inactive'];

        return view('dashboard.brands.index', compact('brands', 'statuses'));
    }

    public function create()
    {
        abort_if(!auth()->user()?->can('brand-create'), 403);

        return view('dashboard.brands.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('brand-create'), 403);

        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('brands', 'slug')],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
            $validated['logo'] = $logoPath;
        }

        $brand = Brand::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'brand' => $brand
            ]);
        }

        return redirect()->route('brands.index')
            ->with('success', __('brands.brand_created_successfully'));
    }

    public function edit(Brand $brand)
    {
        abort_if(!auth()->user()?->can('brand-edit'), 403);
        $this->authorizeBrand($brand);

        return view('dashboard.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        abort_if(!auth()->user()?->can('brand-edit'), 403);
        $this->authorizeBrand($brand);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($brand->id)],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($brand->id)],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($brand->logo) {
                \Storage::disk('public')->delete($brand->logo);
            }
            $logoPath = $request->file('logo')->store('brands', 'public');
            $validated['logo'] = $logoPath;
        }

        $brand->update($validated);

        return redirect()->route('brands.index')
            ->with('success', __('brands.brand_updated_successfully'));
    }

    public function destroy(Brand $brand)
    {
        abort_if(!auth()->user()?->can('brand-delete'), 403);
        $this->authorizeBrand($brand);

        // Delete logo
        if ($brand->logo) {
            \Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', __('brands.brand_deleted_successfully'));
    }

    private function authorizeBrand(Brand $brand)
    {
        return;
    }
}
