<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use ActionLogTrait;

    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->filled('parent_id'), fn ($query) => $query->where('parent_id', $request->parent_id))
            ->when($request->filled('is_active'), fn ($query) => $query->where('is_active', $request->is_active))
            ->with('children')
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $data['is_active'] ?? true;

        $category = Category::create($data);

        Log::info('Category created', array_merge($this->actionLogContext($request), [
            'category_id' => $category->id,
            'name' => $category->name,
        ]));

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category,
        ], 201);
    }

    public function show(Category $category)
    {
        $category->load('children', 'products');
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', Rule::notIn($category->id)],
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        Log::info('Category updated', array_merge($this->actionLogContext($request), [
            'category_id' => $category->id,
            'updated' => array_keys($data),
        ]));

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        Log::info('Category deleted', array_merge($this->actionLogContext(), [
            'category_id' => $category->id,
            'name' => $category->name,
        ]));

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
