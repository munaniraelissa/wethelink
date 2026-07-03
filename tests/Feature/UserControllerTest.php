<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanBeCreatedWithRoleIds(): void
    {
        $admin = User::create([
            'firstname' => 'System',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'telephone' => '2500000000',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $this->actingAs($admin);

        $response = $this->post('/users', [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
            'telephone' => '2501111111',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'status' => 'active',
            'roles' => [$role->id],
        ]);

        $response->assertRedirect();

        $newUser = User::where('email', 'jane@example.com')->first();
        $this->assertNotNull($newUser);
        $this->assertTrue($newUser->hasRole($role->name));
    }
}
