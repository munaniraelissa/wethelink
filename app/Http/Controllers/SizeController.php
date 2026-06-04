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
        $company_id = auth()->user()->company_id;
        
        $query = Size::where('company_id', $company_id);

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
        $company_id = auth()->user()->company_id;
        
        return view('dashboard.sizes.create');
    }

    public function store(Request $request)
    {
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sizes', 'name')->where('company_id', $company_id)],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? Size::where('company_id', $company_id)->max('sort_order') + 1;

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
        abort_if($size->company_id !== auth()->user()->company_id, 403);
        
        return view('dashboard.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        abort_if($size->company_id !== auth()->user()->company_id, 403);
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sizes', 'name')->ignore($size->id)->where('company_id', $company_id)],
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
        abort_if($size->company_id !== auth()->user()->company_id, 403);
        
        $size->delete();

        return redirect()->route('sizes.index')->with('success', __('messages.size_deleted_successfully'));
    }
}
