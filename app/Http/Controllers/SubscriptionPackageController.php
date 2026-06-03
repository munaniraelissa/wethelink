<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubscriptionPackageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         abort_if(!auth()->user()->can('subscription-list'), 403);
    //         return $next($request);
    //     });
    // }

    public function index(Request $request)
    {
        $query = SubscriptionPackage::orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $packages = $query->paginate(15);
        $statuses = ['active', 'inactive', 'archived'];

        return view('dashboard.subscription-packages.index', compact('packages', 'statuses'));
    }

    public function create()
    {
        abort_if(!auth()->user()->can('subscription-create'), 403);

        $modules = ['user', 'role', 'company', 'category', 'product', 'order'];
        $statuses = ['active', 'inactive', 'archived'];

        return view('dashboard.subscription-packages.create', compact('modules', 'statuses'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('subscription-create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_packages,name',
            'slug' => 'nullable|string|max:255|unique:subscription_packages,slug',
            'description' => 'nullable|string',
            'pricing_monthly' => 'required|numeric|min:0',
            'pricing_yearly' => 'required|numeric|min:0',
            'max_locations' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:1',
            'billing_cycle_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'status' => 'required|in:active,inactive,archived',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['features'] = $validated['features'] ?? [];

        SubscriptionPackage::create($validated);

        return redirect()->route('subscription-packages.index')
            ->with('success', __('subscriptions.package_created'));
    }

    public function show(SubscriptionPackage $subscriptionPackage)
    {
        return view('dashboard.subscription-packages.show', compact('subscriptionPackage'));
    }

    public function edit(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(!auth()->user()->can('subscription-edit'), 403);

        $modules = ['user', 'role', 'company', 'category', 'product', 'order'];
        $statuses = ['active', 'inactive', 'archived'];

        return view('dashboard.subscription-packages.edit', compact('subscriptionPackage', 'modules', 'statuses'));
    }

    public function update(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        abort_if(!auth()->user()->can('subscription-edit'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subscription_packages', 'name')->ignore($subscriptionPackage->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('subscription_packages', 'slug')->ignore($subscriptionPackage->id)],
            'description' => 'nullable|string',
            'pricing_monthly' => 'required|numeric|min:0',
            'pricing_yearly' => 'required|numeric|min:0',
            'max_locations' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:1',
            'billing_cycle_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'status' => 'required|in:active,inactive,archived',
        ]);

        if (!isset($validated['slug']) && isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['features'] = $validated['features'] ?? [];

        $subscriptionPackage->update($validated);

        return redirect()->route('subscription-packages.show', $subscriptionPackage)
            ->with('success', __('subscriptions.package_updated'));
    }

    public function destroy(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(!auth()->user()->can('subscription-delete'), 403);

        if ($subscriptionPackage->subscriptions()->exists()) {
            return redirect()->back()
                ->with('error', __('subscriptions.cannot_delete_package_in_use'));
        }

        $subscriptionPackage->delete();

        return redirect()->route('subscription-packages.index')
            ->with('success', __('subscriptions.package_deleted'));
    }
}
