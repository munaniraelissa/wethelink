<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\CompanyLocation;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVideo;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
       $company_id = auth()->user()->company_id;

        $query = Product::where('company_id', $company_id)
            ->with(['category', 'brand', 'images'])
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(15);
        $categories = Category::where('company_id', $company_id)->orderBy('name')->get();
        $brands = Brand::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];

        return view('dashboard.index', compact('products', 'categories', 'brands', 'statuses'));
    }
}
