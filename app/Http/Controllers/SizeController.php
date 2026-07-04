<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()?->can('size-list'), 403);

        $query = Size::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $sizes = $query->orderBy('sort_order')->orderBy('name')->paginate(15);
        $statuses = ['active', 'inactive'];

        return view('dashboard.sizes.index', compact('sizes', 'statuses'));
    }

    public function create()
    {
        abort_if(!auth()->user()?->can('size-create'), 403);

        return view('dashboard.sizes.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('size-create'), 403);

        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sizes', 'name')],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? Size::max('sort_order') + 1;

        $size = Size::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'size' => $size
            ]);
        }

        return redirect()->route('sizes.index')->with('success', __('messages.size_created_successfully'));
    }

    public function edit(Size $size)
    {
        abort_if(!auth()->user()?->can('size-edit'), 403);
        $this->authorizeSize($size);
        
        return view('dashboard.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        abort_if(!auth()->user()?->can('size-edit'), 403);
        $this->authorizeSize($size);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sizes', 'name')->ignore($size->id)],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $size->update($validated);

        return redirect()->route('sizes.index')->with('success', __('messages.size_updated_successfully'));
    }

    public function destroy(Size $size)
    {
        abort_if(!auth()->user()?->can('size-delete'), 403);
        $this->authorizeSize($size);
        
        $size->delete();

        return redirect()->route('sizes.index')->with('success', __('messages.size_deleted_successfully'));
    }

    private function authorizeSize(Size $size)
    {
        return;
    }
}
