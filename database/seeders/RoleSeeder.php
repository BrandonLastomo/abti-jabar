<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        Role::findOrCreate('user', 'web');
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('superadmin', 'web');

        // Create default superadmin account
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@abtijabar.or.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
            ]
        );
        $superadmin->assignRole('superadmin');

        // Create default admin account for testing
        $admin = User::firstOrCreate(
            ['email' => 'admin@abtijabar.or.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole('admin');
    }
}
