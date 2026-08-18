<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductCatalogScopeTest extends TestCase
{
    use RefreshDatabase;

    private function seedProductPermissions(): void
    {
        foreach (['product-list', 'product-create', 'product-edit', 'product-show', 'product-delete'] as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        Permission::findOrCreate('select_product_company', 'web');
    }

    public function test_product_edit_page_loads_when_opened_with_the_product_id(): void
    {
        $this->seedProductPermissions();

        $company = Company::create([
            'name' => 'Edit Company',
            'slug' => 'edit-company',
            'email' => 'edit-company@example.com',
            'telephone' => '2502222222',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'firstname' => 'Edit',
            'lastname' => 'User',
            'email' => 'edit-user@example.com',
            'telephone' => '2503333333',
            'password' => 'password123',
            'status' => 'active',
        ]);
        $user->givePermissionTo(['product-list', 'product-edit', 'product-show']);

        $category = Category::create([
            'company_id' => $company->id,
            'name' => 'Edit Category',
            'slug' => 'edit-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'name' => 'Editable Product',
            'slug' => 'editable-product',
            'sku' => 'EDIT-001',
            'price' => 100,
            'status' => 'draft',
            'quantity' => 0,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('products.edit', ['product' => $product->id]));

        $response->assertOk();
        $response->assertSee('Edit Product');
    }

    public function test_product_edit_page_deletes_selected_images_and_videos(): void
    {
        $this->seedProductPermissions();
        Storage::fake('public');

        $company = Company::create([
            'name' => 'Delete Media Company',
            'slug' => 'delete-media-company',
            'email' => 'delete-media@example.com',
            'telephone' => '2504444444',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'firstname' => 'Delete',
            'lastname' => 'Media',
            'email' => 'delete-media-user@example.com',
            'telephone' => '2505555555',
            'password' => 'password123',
            'status' => 'active',
        ]);
        $user->givePermissionTo(['product-list', 'product-edit', 'product-show']);

        $category = Category::create([
            'company_id' => $company->id,
            'name' => 'Media Category',
            'slug' => 'media-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'name' => 'Media Product',
            'slug' => 'media-product',
            'sku' => 'MEDIA-001',
            'price' => 100,
            'status' => 'draft',
            'quantity' => 0,
        ]);

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image' => 'products/image-1.jpg',
            'is_featured' => true,
            'sort_order' => 0,
        ]);

        $video = ProductVideo::create([
            'product_id' => $product->id,
            'video' => 'product_videos/video-1.mp4',
            'thumbnail' => 'product_videos/thumb-1.jpg',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('products.update', $product), [
            'name' => 'Media Product Updated',
            'price' => 120,
            'status' => 'published',
            'delete_images' => [$image->id],
            'delete_videos' => [$video->id],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('product_images', ['id' => $image->id]);
        $this->assertDatabaseMissing('product_videos', ['id' => $video->id]);
        Storage::disk('public')->assertMissing('products/image-1.jpg');
        Storage::disk('public')->assertMissing('product_videos/video-1.mp4');
        Storage::disk('public')->assertMissing('product_videos/thumb-1.jpg');
    }

    public function test_parent_category_filter_includes_child_products_but_child_filter_stays_specific(): void
    {
        $company = Company::create([
            'name' => 'Catalog Company',
            'slug' => 'catalog-company',
            'email' => 'catalog-company@example.com',
            'telephone' => '2501111111',
            'status' => 'active',
        ]);

        $parentCategory = Category::create([
            'company_id' => $company->id,
            'name' => 'Parent Category',
            'slug' => 'parent-category',
            'is_active' => true,
        ]);

        $childCategory = Category::create([
            'company_id' => $company->id,
            'parent_id' => $parentCategory->id,
            'name' => 'Child Category',
            'slug' => 'child-category',
            'is_active' => true,
        ]);

        $otherCategory = Category::create([
            'company_id' => $company->id,
            'name' => 'Other Category',
            'slug' => 'other-category',
            'is_active' => true,
        ]);

        Product::create([
            'company_id' => $company->id,
            'category_id' => $childCategory->id,
            'name' => 'Parent Child Product',
            'slug' => 'parent-child-product',
            'sku' => 'CAT-001',
            'price' => 100,
            'status' => 'published',
            'quantity' => 5,
        ]);

        Product::create([
            'company_id' => $company->id,
            'category_id' => $otherCategory->id,
            'name' => 'Other Category Product',
            'slug' => 'other-category-product',
            'sku' => 'CAT-002',
            'price' => 200,
            'status' => 'published',
            'quantity' => 8,
        ]);

        $parentResponse = $this->get(route('shop', ['category' => $parentCategory->id]));
        $parentResponse->assertOk();
        $parentResponse->assertSee('Parent Child Product');
        $parentResponse->assertDontSee('Other Category Product');

        $childResponse = $this->get(route('shop', ['category' => $childCategory->id]));
        $childResponse->assertOk();
        $childResponse->assertSee('Parent Child Product');
        $childResponse->assertDontSee('Other Category Product');
    }

    public function test_authenticated_user_can_change_password_from_profile(): void
    {
        $company = Company::create([
            'name' => 'Password Company',
            'slug' => 'password-company',
            'email' => 'password-company@example.com',
            'telephone' => '2506666666',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'firstname' => 'Password',
            'lastname' => 'User',
            'email' => 'password-user@example.com',
            'telephone' => '2507777777',
            'password' => Hash::make('old-password'),
            'status' => 'active',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('profile.password.update'), [
            'current_password' => 'old-password',
            'password' => 'NewPassword123',
            'password_confirmation' => 'NewPassword123',
        ]);

        $response->assertRedirect(route('profile'));
        $this->assertTrue(Hash::check('NewPassword123', $user->fresh()->password));
    }

    public function test_product_creation_uses_selected_company_when_user_has_permission(): void
    {
        $this->seedProductPermissions();

        $ownerCompany = Company::create([
            'name' => 'Owner Company',
            'slug' => 'owner-company',
            'email' => 'owner-company@example.com',
            'telephone' => '2508888888',
            'status' => 'active',
        ]);

        $targetCompany = Company::create([
            'name' => 'Target Company',
            'slug' => 'target-company',
            'email' => 'target-company@example.com',
            'telephone' => '2509999999',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $ownerCompany->id,
            'firstname' => 'Assign',
            'lastname' => 'User',
            'email' => 'assign-user@example.com',
            'telephone' => '2501010101',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        $category = Category::create([
            'company_id' => $ownerCompany->id,
            'name' => 'Assigned Category',
            'slug' => 'assigned-category',
            'is_active' => true,
        ]);

        $permission = Permission::findOrCreate('select_product_company', 'web');
        $user->givePermissionTo($permission);
        $user->givePermissionTo(['product-list', 'product-create', 'product-edit', 'product-show', 'product-delete']);

        $this->actingAs($user);

        $response = $this->post(route('products.store'), [
            'name' => 'Assigned Product',
            'category_id' => $category->id,
            'price' => 250,
            'status' => 'draft',
            'company_id' => $targetCompany->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('products', [
            'name' => 'Assigned Product',
            'company_id' => $targetCompany->id,
        ]);
    }

    public function test_product_create_page_shows_globally_available_catalog_items_across_companies(): void
    {
        $this->seedProductPermissions();

        $companyA = Company::create([
            'name' => 'Company A',
            'slug' => 'company-a',
            'email' => 'company-a@example.com',
            'telephone' => '2500000000',
            'status' => 'active',
        ]);

        $companyB = Company::create([
            'name' => 'Company B',
            'slug' => 'company-b',
            'email' => 'company-b@example.com',
            'telephone' => '2500000001',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $companyA->id,
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
            'telephone' => '2501111111',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $category = Category::create([
            'name' => 'Global Category',
            'slug' => 'global-category',
            'company_id' => $companyB->id,
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'Global Brand',
            'slug' => 'global-brand',
            'company_id' => $companyB->id,
            'is_active' => true,
        ]);

        $size = Size::create([
            'name' => 'Global Size',
            'code' => 'GS',
            'company_id' => $companyB->id,
            'is_active' => true,
        ]);

        $color = Color::create([
            'name' => 'Global Color',
            'code' => '#123456',
            'company_id' => $companyB->id,
            'is_active' => true,
        ]);

        $user->givePermissionTo(['product-list', 'product-create', 'product-edit', 'product-show', 'product-delete']);

        $this->actingAs($user);

        $response = $this->get(route('products.create'));

        $response->assertOk();
        $response->assertSee($category->name);
        $response->assertSee($brand->name);
        $response->assertSee($size->name);
        $response->assertSee($color->name);
    }
}
