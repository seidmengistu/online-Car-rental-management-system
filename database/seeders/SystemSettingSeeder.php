<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Car Rental System',
                'type' => 'string',
                'group' => 'general',
                'description' => 'The name of the website',
            ],
            [
                'key' => 'site_email',
                'value' => 'info@carrental.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Primary contact email address',
            ],
            [
                'key' => 'site_phone',
                'value' => '+251-XXX-XXXX',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Primary contact phone number',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Enable or disable maintenance mode',
            ],

            // Rental Policies
            [
                'key' => 'min_rental_days',
                'value' => '1',
                'type' => 'number',
                'group' => 'rental',
                'description' => 'Minimum number of days for a rental',
            ],
            [
                'key' => 'max_rental_days',
                'value' => '30',
                'type' => 'number',
                'group' => 'rental',
                'description' => 'Maximum number of days for a rental',
            ],
            [
                'key' => 'overdue_fee_percentage',
                'value' => '10',
                'type' => 'number',
                'group' => 'rental',
                'description' => 'Percentage fee for overdue rentals',
            ],
            [
                'key' => 'cancellation_policy',
                'value' => 'Cancellations must be made 24 hours in advance for a full refund.',
                'type' => 'string',
                'group' => 'rental',
                'description' => 'Cancellation policy text',
            ],

            // Payment Settings
            [
                'key' => 'currency',
                'value' => 'ETB',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Default currency code',
            ],
            [
                'key' => 'tax_rate',
                'value' => '15',
                'type' => 'number',
                'group' => 'payment',
                'description' => 'Tax rate percentage',
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
