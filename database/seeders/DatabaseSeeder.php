<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
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
            'city' => 'New York',
            'state' => 'NY',
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
            'city' => 'New York',
            'state' => 'NY',
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
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'driving_license_number' => 'DL123456789',
            'driving_license_expiry' => now()->addYears(2)->toDateString(),
            'is_active' => true,
        ]);

        // Seed cars
        $this->call(CarSeeder::class);
    }
}
