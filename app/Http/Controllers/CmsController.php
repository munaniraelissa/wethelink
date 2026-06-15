<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Display the CMS landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch categories and count related products for the "Categories" section
        $categories = Category::withCount('products')->get();

        // Fetch Trendy Products and eager load relationships for the view
        $trendyProducts = Product::with(['images', 'company'])->latest()->paginate(8);

        // Fetch the 8 most recent products for the "Just Arrived" section
        $newArrivals = Product::with(['images', 'company'])->latest()->paginate(8);

        return view('cms.index', compact('categories', 'trendyProducts', 'newArrivals'));
    }

    /**
     * Display the shop page.
     *
     * @return \Illuminate\View\View
     */
    public function shop(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $query = Product::with(['images', 'company']);

        // Filter by category if provided in the URL
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by search keyword if provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->latest()->paginate(9);

        return view('cms.shop', compact('categories', 'products'));
    }

    /**
     * Display the product detail page.
     *
     * @return \Illuminate\View\View
     */
    public function detail(Product $product, Request $request)
    {
        $categories = Category::all();
        $query = Product::with(['images', 'company']);

        // Filter by category if provided in the URL
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $relatedProducts = $query->latest()->paginate(9);

        return view('cms.detail', compact('categories', 'product', 'relatedProducts'));
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        $categories = Category::all();

        return view('cms.contact', compact('categories'));
    }

    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $categories = Category::all();

        return view('cms.cart', compact('categories'));
    }

    /**
     * Display the checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $categories = Category::all();

        return view('cms.checkout', compact('categories'));
    }
}
