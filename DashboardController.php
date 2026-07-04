<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()->take(5)->get();
        $products = Product::latest()->take(5)->get();
        $companies = Company::latest()->take(5)->get();
        $orders = Order::latest()->take(5)->get();
        $subscriptions = Subscription::latest()->take(5)->get();

        $metrics = [
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'orders' => Order::count(),
            'companies' => Company::count(),
            'active_users' => User::where('status', 'active')->count(),
        ];

        $recentActivities = collect()
            ->merge($users->map(fn (User $user) => [
                'title' => 'New user registered',
                'description' => trim("{$user->firstname} {$user->lastname}") . ' joined the platform.',
                'created_at' => $user->created_at,
                'icon_class' => 'bg-primary',
            ]))
            ->merge($companies->map(fn (Company $company) => [
                'title' => 'Company added',
                'description' => $company->name . ' was added to the system.',
                'created_at' => $company->created_at,
                'icon_class' => 'bg-success',
            ]))
            ->merge($products->map(fn (Product $product) => [
                'title' => 'Product published',
                'description' => $product->name . ' is now available in the catalog.',
                'created_at' => $product->created_at,
                'icon_class' => 'bg-warning',
            ]))
            ->merge($orders->map(fn (Order $order) => [
                'title' => 'Order received',
                'description' => 'Order #' . $order->order_number . ' is now ' . $order->status . '.',
                'created_at' => $order->created_at,
                'icon_class' => 'bg-info',
            ]))
            ->merge($subscriptions->map(fn (Subscription $subscription) => [
                'title' => 'Subscription updated',
                'description' => 'Subscription for ' . ($subscription->company?->name ?? 'a company') . ' is ' . $subscription->approval_status . '.',
                'created_at' => $subscription->created_at,
                'icon_class' => 'bg-secondary',
            ]))
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        return view('dashboard.index', compact('users', 'products', 'companies', 'orders', 'metrics', 'recentActivities'));
    }
}
