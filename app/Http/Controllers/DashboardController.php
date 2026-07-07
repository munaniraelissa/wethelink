<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['company', 'roles'])->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $users = $query->take(5)->get();
        $companies = Company::latest()->take(5)->get();
        $statuses = ['pending', 'active', 'inactive', 'suspended'];
        $company_id = auth()->user()?->company_id;

        $productQuery = Product::query()->with(['category', 'brand', 'images'])->orderBy('id', 'desc');

        if ($company_id) {
            $productQuery->where('company_id', $company_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $productQuery->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $productQuery->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $productQuery->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $productQuery->where('status', $request->status);
        }

        $products = $productQuery->take(5)->get();
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];

        $metrics = [
            'productCount' => Product::count(),
            'categoryCounts' => Category::count(),
            'companies' => Company::count(),
            'active_users' => User::where('status', 'active')->count(),
        ];

        $recentActivities = collect()
            ->merge($users->map(fn (User $user) => [
                'title' => 'New user registered',
                'description' => trim("{$user->firstname} {$user->lastname}").' joined the platform.',
                'created_at' => $user->created_at,
                'icon_class' => 'bg-primary',
            ]))
            ->merge($companies->map(fn (Company $company) => [
                'title' => 'Company added',
                'description' => $company->name.' was added to the system.',
                'created_at' => $company->created_at,
                'icon_class' => 'bg-success',
            ]))
            ->merge($products->map(fn (Product $product) => [
                'title' => 'Product published',
                'description' => $product->name.' is now available in the catalog.',
                'created_at' => $product->created_at,
                'icon_class' => 'bg-warning',
            ]))
            ->merge(Order::latest()->take(5)->get()->map(fn (Order $order) => [
                'title' => 'Order received',
                'description' => 'Order #'.$order->order_number.' is now '.$order->status.'.',
                'created_at' => $order->created_at,
                'icon_class' => 'bg-info',
            ]))
            ->merge(Subscription::latest()->take(5)->get()->map(fn (Subscription $subscription) => [
                'title' => 'Subscription updated',
                'description' => 'Subscription for '.($subscription->company?->name ?? 'a company').' is '.$subscription->approval_status.'.',
                'created_at' => $subscription->created_at,
                'icon_class' => 'bg-secondary',
            ]))
            ->sortByDesc('created_at')
            ->take(4)
            ->values();

        return view('dashboard.index', compact('users', 'companies', 'statuses', 'products', 'categories', 'brands', 'metrics', 'recentActivities'));
    }
}
