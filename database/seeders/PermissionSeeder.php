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
            'user', 'role', 'permission', 'company', 'category', 'product', 'order', 'subscription'
        ];

        $actions = ['list', 'create', 'edit', 'delete'];

        $all = [];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $all[] = "{$module}-{$action}";
            }
        }

        // extra permissions
        $all[] = 'product-manage-media';
        $all[] = 'subscription-approve';

        foreach ($all as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // ensure Admin role exists and has all permissions
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::all());
    }
}
