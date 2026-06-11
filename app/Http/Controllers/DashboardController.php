<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyLocation;
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

        $users = $query->paginate(15);
        $companies = Company::all();
        $statuses = ['pending', 'active', 'inactive', 'suspended'];
         // Fetch the 5 most recent users
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

        return view('dashboard.index', compact('users', 'companies', 'statuses', 'products', 'categories', 'brands', 'statuses'));
    }
}
