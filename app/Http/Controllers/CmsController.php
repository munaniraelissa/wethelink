<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function index()
    {
        // Fetch categories with product counts
        $categories = Category::withCount('products')->get();

        // Fetch featured products for "Trandy Products" section
        $trendyProducts = Product::where('is_featured', true)->with('images')->take(8)->get();

        // Fetch latest products for "Just Arrived" section
        $justArrived = Product::latest()->with('images')->take(8)->get();

        return view('cms.index', compact('categories', 'trendyProducts', 'justArrived'));
    }
}