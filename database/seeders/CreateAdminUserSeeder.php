<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1️⃣ Create or find the admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@wethelink.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'Wethelink',
                'gender' => 'MALE',
                'telephone' => '+250788565520',
                'status' => 'active',
                'password' => bcrypt('password'),
            ]
        );

        // 2️⃣ Create or find Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // 3️⃣ Get all permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // 4️⃣ Assign all permissions to Admin
        $adminRole->syncPermissions($allPermissions);

        // 5️⃣ Assign Admin role to the user
        $user->assignRole($adminRole->name);

        // 6️⃣ Mark Admin role as protected (cannot be renamed/deleted)
        if (Schema::hasColumn('roles', 'is_protected')) {
            $adminRole->update(['is_protected' => true]);
        }
    }
}
