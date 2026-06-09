<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        // Role::firstOrCreate(['name' => 'buyer', 'guard_name' => 'web']);
        // Role::firstOrCreate(['name' => 'seller', 'guard_name' => 'web']);
        // Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Create test company
        $company = Company::create([
            'name' => 'Test Company Ltd',
            'slug' => 'test-company-ltd',
            'email' => 'info@testcompany.com',
            'telephone' => '+1234567890',
            'website' => 'https://testcompany.com',
            'tax_number' => 'TAX123456',
            'registration_number' => 'REG789012',
            'industry' => 'Technology',
            'credit_limit' => 50000,
            'payment_terms_days' => 30,
            'status' => 'active',
        ]);

        // Create company location
        $location = CompanyLocation::create([
            'company_id' => $company->id,
            'name' => 'Main Office',
            'email' => 'main@testcompany.com',
            'telephone' => '+1234567890',
            'manager_name' => 'John Manager',
            'country' => 'USA',
            'province' => 'California',
            'city' => 'San Francisco',
            'address' => '123 Main St, San Francisco, CA',
            'is_head_office' => true,
            'status' => 'active',
        ]);

        // Create test user
        $user = User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@wethelink.com',
            'telephone' => '+250786543210',
            'password' => Hash::make('password123'),
            'company_id' => $company->id,
            'company_location_id' => $location->id,
            'status' => 'active',
        ]);

        // Assign default role
         $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Get all permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // Assign all permissions to Admin
        $adminRole->syncPermissions($allPermissions);

        // Assign Admin role to the user
        $user->assignRole($adminRole->name);

        $this->command->info('Test data created successfully!');
        $this->command->info('Email: admin@wethelink.com');
        $this->command->info('Password: password123');
    }
}
