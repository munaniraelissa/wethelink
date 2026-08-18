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
        // Fetch the first 12 active top-level categories for the sliding category section
        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->whereIn('status', ['published', 'out_of_stock']);
            }])
            ->orderBy('name')
            ->take(12)
            ->get();

        // Rank trendy products by detail-page views and show only the top 8
        $trendyProducts = Product::query()
            ->whereIn('status', ['published', 'out_of_stock'])
            ->with(['images', 'company', 'category'])
            ->withCount('reviews')
            ->orderByDesc('views')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        // Fetch the 8 most recent products for the "Just Arrived" section
        $newArrivals = Product::query()
            ->whereIn('status', ['published', 'out_of_stock'])
            ->with(['images', 'company', 'category'])
            ->withCount('reviews')
            ->latest()
            ->take(8)
            ->get();

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
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->whereIn('status', ['published', 'out_of_stock']);
            }])
            ->with('children')
            ->get();

        $query = Product::with(['images', 'company'])
            ->whereIn('status', ['published', 'out_of_stock']);

        if ($request->filled('category')) {
            $selectedCategory = Category::with('children')->find($request->category);

            if ($selectedCategory) {
                $categoryIds = $selectedCategory->descendantIds();
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->filled('manufacturer')) {
            $query->where('company_id', $request->manufacturer);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $terms = preg_split('/\s+/', $search);
            $searchValue = strtolower($search);

            $query->where(function ($productQuery) use ($terms, $searchValue) {
                $productQuery->whereRaw('LOWER(name) LIKE ?', ['%'.$searchValue.'%'])
                    ->orWhereRaw('LOWER(sku) LIKE ?', ['%'.$searchValue.'%'])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ['%'.$searchValue.'%']);

                foreach ($terms as $term) {
                    $termValue = strtolower(trim($term));
                    if ($termValue === '') {
                        continue;
                    }

                    $productQuery->orWhereHas('category', function ($categoryQuery) use ($termValue) {
                        $categoryQuery->where('is_active', true)
                            ->whereRaw('LOWER(name) LIKE ?', ['%'.$termValue.'%']);
                    })
                    ->orWhereHas('company', function ($companyQuery) use ($termValue) {
                        $companyQuery->where('status', 'active')
                            ->whereRaw('LOWER(name) LIKE ?', ['%'.$termValue.'%']);
                    });
                }
            });
        }

        $products = $query->latest()->paginate(9);

        $searchTerm = trim((string) $request->input('search', ''));
        $searchCategories = collect();
        $searchCompanies = collect();

        if ($request->filled('search')) {
            $normalized = strtolower($searchTerm);
            $normalized = strtolower($searchTerm);

            $searchCategories = Category::query()
                ->where('is_active', true)
                ->whereRaw('LOWER(name) LIKE ?', ['%'.$normalized.'%'])
                ->orderBy('name')
                ->take(6)
                ->get();

            $searchCompanies = Company::query()
                ->where('status', 'active')
                ->whereRaw('LOWER(name) LIKE ?', ['%'.$normalized.'%'])
                ->orderBy('name')
                ->take(6)
                ->get();
        }

        $manufacturers = Company::where('status', 'active')
            ->withCount([
                'products' => function ($q) {
                    $q->whereIn('status', ['published', 'out_of_stock']);
                },
                'users',
            ])
            ->with(['products' => function ($query) {
                $query->whereIn('status', ['published', 'out_of_stock'])->with('images')->latest()->take(3);
            }, 'locations'])
            ->orderBy('name')
            ->get();

        return view('cms.shop', compact('categories', 'products', 'manufacturers', 'searchCategories', 'searchCompanies', 'searchTerm'));
    }

    public function manufacturers()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->whereIn('status', ['published', 'out_of_stock']);
            }])
            ->get();
        $manufacturers = Company::where('status', 'active')
            ->withCount([
                'products' => function ($q) {
                    $q->whereIn('status', ['published', 'out_of_stock']);
                },
                'users',
            ])
            ->with(['products' => function ($query) {
                $query->whereIn('status', ['published', 'out_of_stock'])->with('images')->latest()->take(3);
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
            'reviews.user',
        ])->where('slug', $slug)
        ->whereIn('status', ['published', 'out_of_stock'])
        ->firstOrFail();

        $product->increment('views');

        $categories = Category::where('is_active', true)->get();

        $companyProducts = Product::with(['images', 'company'])
            ->where('company_id', $product->company_id)
            ->where('id', '!=', $product->id)
            ->whereIn('status', ['published', 'out_of_stock'])
            ->latest()
            ->take(8)
            ->get();

        return view('cms.detail', compact(
            'categories',
            'product',
            'companyProducts'
        ));
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        $categories = Category::where('is_active', true)->get();

        return view('cms.contact', compact('categories'));
    }

    /**
     * Store the contact message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeContactMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            // Store the message in database
            $contactMessage = \App\Models\ContactMessage::create($validated);

            // Try to send email to admin
            try {
                $adminEmail = config('mail.from.address', 'munanira64@gmail.com');
                if ($adminEmail && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                    \Illuminate\Support\Facades\Mail::to($adminEmail)
                        ->send(new \App\Mail\ContactMessageMail($contactMessage));
                }
            } catch (\Exception $mailException) {
                // Log the email error but don't fail the request
                \Illuminate\Support\Facades\Log::error('Contact form email failed: '.$mailException->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => __('cms.contact.message_sent_successfully'),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('cms.contact.message_sent_error').' - '.$e->getMessage(),
            ], 500);
        }
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
