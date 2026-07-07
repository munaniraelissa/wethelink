<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Company;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AttributeManagementCrudTest extends TestCase
{
    use RefreshDatabase;

    private function makeUserWithPermissions(string ...$permissions): User
    {
        $company = Company::create([
            'name' => 'Test Company',
            'slug' => 'test-company',
            'email' => 'company@example.com',
            'telephone' => '2500000000',
            'status' => 'active',
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'user@example.com',
            'telephone' => '2500000000',
            'password' => 'password123',
            'status' => 'active',
        ]);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $user->givePermissionTo($permissions);

        return $user;
    }

    public function test_brand_store_redirects_to_index_with_success_message(): void
    {
        $user = $this->makeUserWithPermissions('brand-list', 'brand-create');
        $this->actingAs($user);

        $response = $this->post(route('brands.store'), [
            'name' => 'Acme',
            'slug' => 'acme',
            'description' => 'Sample brand',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('brands.index'));
        $response->assertSessionHas('success', 'Brand created successfully');
        $this->assertDatabaseHas('brands', ['name' => 'Acme', 'company_id' => $user->company_id]);
    }

    public function test_brand_show_route_returns_the_detail_view(): void
    {
        $user = $this->makeUserWithPermissions('brand-list');
        $this->actingAs($user);

        $brand = Brand::create([
            'company_id' => $user->company_id,
            'name' => 'Acme',
            'slug' => 'acme',
            'is_active' => true,
        ]);

        $response = $this->get(route('brands.show', $brand));

        $response->assertOk();
        $response->assertViewIs('dashboard.brands.show');
        $response->assertViewHas('brand', fn ($value) => $value->id === $brand->id);
    }

    public function test_color_store_redirects_to_index_with_success_message(): void
    {
        $user = $this->makeUserWithPermissions('color-list', 'color-create');
        $this->actingAs($user);

        $response = $this->post(route('colors.store'), [
            'name' => 'Blue',
            'code' => '#0000ff',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('colors.index'));
        $response->assertSessionHas('success', 'Color created successfully');
        $this->assertDatabaseHas('colors', ['name' => 'Blue', 'company_id' => $user->company_id]);
    }

    public function test_color_show_route_returns_the_detail_view(): void
    {
        $user = $this->makeUserWithPermissions('color-list');
        $this->actingAs($user);

        $color = Color::create([
            'company_id' => $user->company_id,
            'name' => 'Blue',
            'code' => '#0000ff',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('colors.show', $color));

        $response->assertOk();
        $response->assertViewIs('dashboard.colors.show');
        $response->assertViewHas('color', fn ($value) => $value->id === $color->id);
    }

    public function test_size_store_redirects_to_index_with_success_message(): void
    {
        $user = $this->makeUserWithPermissions('size-list', 'size-create');
        $this->actingAs($user);

        $response = $this->post(route('sizes.store'), [
            'name' => 'XL',
            'code' => 'XL',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('sizes.index'));
        $response->assertSessionHas('success', 'Size created successfully');
        $this->assertDatabaseHas('sizes', ['name' => 'XL', 'company_id' => $user->company_id]);
    }

    public function test_size_show_route_returns_the_detail_view(): void
    {
        $user = $this->makeUserWithPermissions('size-list');
        $this->actingAs($user);

        $size = Size::create([
            'company_id' => $user->company_id,
            'name' => 'XL',
            'code' => 'XL',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('sizes.show', $size));

        $response->assertOk();
        $response->assertViewIs('dashboard.sizes.show');
        $response->assertViewHas('size', fn ($value) => $value->id === $size->id);
    }
}
