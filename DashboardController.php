<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $users = User::latest()->take(5)->get(); // Fetch the 5 most recent users
        $products = Product::latest()->take(5)->get(); // Fetch the 5 most recent products

        return view('dashboard.index', compact('users', 'products'));
    }
}
