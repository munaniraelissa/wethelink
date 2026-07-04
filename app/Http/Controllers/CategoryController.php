<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()?->can('category-list'), 403);

        $query = Category::query()
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->paginate(15);
        $statuses = ['active', 'inactive'];

        return view('dashboard.categories.index', compact('categories', 'statuses'));
    }

    public function create()
    {
        abort_if(!auth()->user()?->can('category-create'), 403);

        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('dashboard.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('category-create'), 403);

        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category', 'public');
            $validated['image'] = $imagePath;
        }
        $category = Category::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', __('categories.category_created_successfully'));
    }

    public function edit(Category $category)
    {
        abort_if(!auth()->user()?->can('category-edit'), 403);

        $parentCategories = Category::query()
            ->where('id', '!=', $category->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('dashboard.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        abort_if(!auth()->user()?->can('category-edit'), 403);

        $validated = $request->validate([
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('category', 'public');
            $validated['image'] = $imagePath;
        }

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', __('categories.category_updated_successfully'));
    }

    public function destroy(Category $category)
    {
        abort_if(!auth()->user()?->can('category-delete'), 403);

        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', __('categories.category_deleted_successfully'));
    }

    private function authorizeCategory(Category $category)
    {
        return;
    }
}
