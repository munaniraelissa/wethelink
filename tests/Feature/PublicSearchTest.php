<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_search_returns_products_matching_category_company_and_product_fields(): void
    {
        $company = Company::create([
            'name' => 'Bright Supply',
            'slug' => 'bright-supply',
            'email' => 'bright@example.com',
            'telephone' => '250700000000',
            'status' => 'active',
        ]);

        $category = Category::create([
            'company_id' => $company->id,
            'name' => 'Solar Lighting',
            'slug' => 'solar-lighting',
            'is_active' => true,
        ]);

        $product = Product::create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'name' => 'Portable Lantern',
            'slug' => 'portable-lantern',
            'sku' => 'LANT-001',
            'barcode' => 'BAR-1001',
            'price' => 15000,
            'status' => 'published',
            'quantity' => 10,
        ]);

        Review::create([
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Excellent product',
        ]);

        $response = $this->get(route('shop', ['search' => 'lighting']));

        $response->assertOk();
        $response->assertSee('Portable Lantern');
        $response->assertSee('Solar Lighting');
        $response->assertSee('Bright Supply');
        $response->assertSee('(1 Reviews)');
    }
}
