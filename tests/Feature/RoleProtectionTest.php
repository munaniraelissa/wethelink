<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function testSuperAdminRoleCannotBeEditedOrDeleted(): void
    {
        $admin = User::create([
            'firstname' => 'System',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'telephone' => '2500000000',
            'password' => 'password123',
            'status' => 'active',
        ]);

        Permission::firstOrCreate(['name' => 'role-list']);
        Permission::firstOrCreate(['name' => 'role-edit']);
        Permission::firstOrCreate(['name' => 'role-delete']);

        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web', 'is_protected' => true]);
        $admin->syncRoles(['Super Admin']);
        $admin->givePermissionTo(['role-list', 'role-edit', 'role-delete']);

        $this->actingAs($admin);

        $editResponse = $this->get(route('roles.edit', $superAdmin));
        $editResponse->assertRedirect(route('roles.index'));
        $editResponse->assertSessionHas('warning');

        $updateResponse = $this->put(route('roles.update', $superAdmin), [
            'name' => 'Updated Super Admin',
            'permissions' => [],
        ]);
        $updateResponse->assertRedirect(route('roles.index'));
        $updateResponse->assertSessionHas('warning');

        $deleteResponse = $this->delete(route('roles.destroy', $superAdmin));
        $deleteResponse->assertRedirect(route('roles.index'));
        $deleteResponse->assertSessionHas('error');
    }
}
