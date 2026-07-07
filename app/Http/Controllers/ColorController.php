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
        abort_if(!auth()->user()?->can('color-list'), 403);

        $query = Color::query();

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
        abort_if(!auth()->user()?->can('color-create'), 403);

        return view('dashboard.colors.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('color-create'), 403);

        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('colors', 'name')],
            'code' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['company_id'] = $company_id;
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? Color::max('sort_order') + 1;

        $color = Color::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'color' => $color
            ]);
        }

        return redirect()->route('colors.index')->with('success', __('messages.color_created_successfully'));
    }

    public function show(Color $color)
    {
        abort_if(!auth()->user()?->can('color-list'), 403);
        $this->authorizeColor($color);

        return view('dashboard.colors.show', compact('color'));
    }

    public function edit(Color $color)
    {
        abort_if(!auth()->user()?->can('color-edit'), 403);
        $this->authorizeColor($color);
        
        return view('dashboard.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        abort_if(!auth()->user()?->can('color-edit'), 403);
        $this->authorizeColor($color);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('colors', 'name')->ignore($color->id)],
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
        abort_if(!auth()->user()?->can('color-delete'), 403);
        $this->authorizeColor($color);
        
        $color->delete();

        return redirect()->route('colors.index')->with('success', __('messages.color_deleted_successfully'));
    }

    private function authorizeColor(Color $color)
    {
        return;
    }
}
