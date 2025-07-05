<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Get role IDs
        $customerRole = Role::where('name', 'customer')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $managerRole = Role::where('name', 'manager')->first();

        // Create default manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@carrental.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
            'phone' => '+1234567890',
            'address' => '123 Manager St',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'country' => 'USA',
            'is_active' => true,
        ]);

        // Create default staff
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@carrental.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id,
            'phone' => '+1234567891',
            'address' => '456 Staff Ave',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10002',
            'country' => 'USA',
            'is_active' => true,
        ]);

        // Create default customer
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role_id' => $customerRole->id,
            'phone' => '+1234567892',
            'address' => '789 Customer Blvd',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10003',
            'country' => 'USA',
            'date_of_birth' => '1990-01-01',
            'driving_license_number' => 'DL123456789',
            'driving_license_expiry' => '2025-12-31',
            'is_active' => true,
        ]);

        // Seed cars
        $this->call(CarSeeder::class);
    }
}
