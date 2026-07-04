<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'user', 'role', 'permission', 'company', 'category', 'brand', 'color', 'size', 'product', 'order', 'subscription'
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
        $all[] = 'product-show';
        $all[] = 'subscription-approve';
        $all[] = 'select_product_company';

        foreach ($all as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        if (Schema::hasColumn('roles', 'is_protected')) {
            $superAdmin->update(['is_protected' => true]);
        }
        $superAdmin->syncPermissions(Permission::all());

        $supplier = Role::firstOrCreate(['name' => 'Supplier']);
        $supplier->syncPermissions([
            'product-list',
            'product-create',
            'product-edit',
            'product-show',
            'product-delete',
            'product-manage-media',
        ]);

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(Permission::all());
    }
}
