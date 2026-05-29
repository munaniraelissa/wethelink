<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'user', 'role', 'permission', 'company', 'category', 'product', 'order'
        ];

        $actions = ['list', 'create', 'edit', 'delete'];

        $all = [];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $all[] = "{$module}-{$action}";
            }
        }

        // extra product media permission
        $all[] = 'product-manage-media';

        foreach ($all as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // ensure Admin role exists and has all permissions
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::all());
    }
}
