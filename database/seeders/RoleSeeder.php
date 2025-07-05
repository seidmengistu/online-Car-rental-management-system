<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Regular customers who can rent cars',
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Staff members who can manage bookings and cars',
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Managers with full system access and administrative privileges',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 