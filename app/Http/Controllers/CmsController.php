<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\HomepageFeature;
use App\Models\HomepageHeroSlide;
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

        $companies = Company::where('status', 'active')->orderBy('name')->get();

        $featuredItems = HomepageFeature::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $heroSlides = HomepageHeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($featuredItems->isEmpty()) {
            $featuredItems = collect([
                [
                    'title' => 'Quality Product',
                    'icon_class' => 'fa fa-check',
                    'description' => 'Premium products with reliable quality standards.',
                ],
                [
                    'title' => 'Free Shipping',
                    'icon_class' => 'fa fa-shipping-fast',
                    'description' => 'Fast delivery across the country for every order.',
                ],
                [
                    'title' => '14-Day Return',
                    'icon_class' => 'fas fa-exchange-alt',
                    'description' => 'Easy returns within two weeks if plans change.',
                ],
                [
                    'title' => '24/7 Support',
                    'icon_class' => 'fa fa-phone-volume',
                    'description' => 'Reach our team anytime for order help and guidance.',
                ],
            ])->map(function ($item) {
                return (object) $item;
            });
        }

        return view('cms.index', compact('categories', 'trendyProducts', 'newArrivals', 'companies', 'featuredItems', 'heroSlides'));
    }

    /**
     * Display the shop page.
     *
     * @return \Illuminate\View\View
     */
    public function shop(Request $request)
    {
        $categories = Category::withCount('products')->with('children')->get();

        $query = Product::with(['images', 'company']);

        // Filter by category if provided in the URL
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by search keyword if provided
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('manufacturer')) {
            $query->where('company_id', $request->manufacturer);
        }

        $products = $query->latest()->paginate(9);
        $manufacturers = Company::where('status', 'active')
            ->withCount(['products', 'users'])
            ->with(['products' => function ($query) {
                $query->with('images')->latest()->take(3);
            }, 'locations'])
            ->orderBy('name')
            ->get();

        return view('cms.shop', compact('categories', 'products', 'manufacturers'));
    }

    public function manufacturers()
    {
        $categories = Category::withCount('products')->get();
        $manufacturers = Company::where('status', 'active')
            ->withCount(['products', 'users'])
            ->with(['products' => function ($query) {
                $query->with('images')->latest()->take(3);
            }, 'locations'])
            ->orderBy('name')
            ->get();

        return view('cms.manufacturers', compact('categories', 'manufacturers'));
    }

    /**
     * Display the product detail page.
     *
     * @return \Illuminate\View\View
     */
    public function detail($slug, Request $request)
    {
        $product = Product::with([
            'images',
            'videos',
            'company',
            'reviews.user'
        ])->where('slug', $slug)
        ->firstOrFail();

        $categories = Category::all();

        $query = Product::with(['images', 'company'])
            ->where('id', '!=', $product->id);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $relatedProducts = $query->latest()->paginate(9);

        return view('cms.detail', compact(
            'categories',
            'product',
            'relatedProducts'
        ));
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
