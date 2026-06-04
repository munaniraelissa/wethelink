<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $company_id = auth()->user()->company_id;
        
        $query = Color::where('company_id', $company_id);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $colors = $query->orderBy('sort_order')->orderBy('name')->paginate(15);
        $statuses = ['active', 'inactive'];

        return view('dashboard.colors.index', compact('colors', 'statuses'));
    }

    public function create()
    {
        $company_id = auth()->user()->company_id;
        
        return view('dashboard.colors.create');
    }

    public function store(Request $request)
    {
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('colors', 'name')->where('company_id', $company_id)],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? Color::where('company_id', $company_id)->max('sort_order') + 1;

        $color = Color::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'color' => $color
            ]);
        }

        return redirect()->route('colors.index')->with('success', __('messages.color_created_successfully'));
    }

    public function edit(Color $color)
    {
        abort_if($color->company_id !== auth()->user()->company_id, 403);
        
        return view('dashboard.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        abort_if($color->company_id !== auth()->user()->company_id, 403);
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('colors', 'name')->ignore($color->id)->where('company_id', $company_id)],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $color->update($validated);

        return redirect()->route('colors.index')->with('success', __('messages.color_updated_successfully'));
    }

    public function destroy(Color $color)
    {
        abort_if($color->company_id !== auth()->user()->company_id, 403);
        
        $color->delete();

        return redirect()->route('colors.index')->with('success', __('messages.color_deleted_successfully'));
    }
}
