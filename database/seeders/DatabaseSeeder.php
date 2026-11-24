<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed administrator user and minimum 8 demonstration equipment records.
     */
    public function run(): void
    {
        // 1. Seed Administrator Account (Allows login with email or username)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Pickleball Admin',
                'email' => 'admin@pickleball.test',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Demonstration Records covering all 4 categories and both statuses
        $demonstrationRecords = [
            [
                'equipment_name' => 'Carbon Fiber Paddle',
                'category' => 'Paddles',
                'unit_price' => 89.99,
                'description' => 'Lightweight professional carbon fiber paddle with textured honeycomb polymer core.',
                'availability_status' => 'Available',
            ],
            [
                'equipment_name' => 'Fiberglass Paddle',
                'category' => 'Paddles',
                'unit_price' => 49.50,
                'description' => 'Composite fiberglass face paddle engineered for balanced power and defensive control.',
                'availability_status' => 'Available',
            ],
            [
                'equipment_name' => 'Indoor Pickleball Pack',
                'category' => 'Balls',
                'unit_price' => 14.99,
                'description' => 'Pack of 6 precision-drilled 26-hole balls designed for wooden gymnasium floors.',
                'availability_status' => 'Available',
            ],
            [
                'equipment_name' => 'Outdoor Pickleball Pack',
                'category' => 'Balls',
                'unit_price' => 18.50,
                'description' => 'Pack of 6 seamless 40-hole wind-resistant balls for asphalt and concrete courts.',
                'availability_status' => 'Unavailable',
            ],
            [
                'equipment_name' => 'Portable Pickleball Net',
                'category' => 'Nets',
                'unit_price' => 129.00,
                'description' => 'Regulation 22ft powder-coated steel frame net system with easy setup and carrying bag.',
                'availability_status' => 'Available',
            ],
            [
                'equipment_name' => 'Replacement Net',
                'category' => 'Nets',
                'unit_price' => 39.95,
                'description' => 'Heavy-duty weather-resistant polyethylene replacement netting for regulation frames.',
                'availability_status' => 'Unavailable',
            ],
            [
                'equipment_name' => 'Paddle Grip Tape',
                'category' => 'Accessories',
                'unit_price' => 7.25,
                'description' => 'Moisture-wicking, non-slip polyurethane replacement overgrip pack (3 count).',
                'availability_status' => 'Available',
            ],
            [
                'equipment_name' => 'Pickleball Equipment Bag',
                'category' => 'Accessories',
                'unit_price' => 45.00,
                'description' => 'Deluxe multi-compartment sling bag holding up to 4 paddles, ball sleeves, and shoes.',
                'availability_status' => 'Available',
            ],
        ];

        foreach ($demonstrationRecords as $record) {
            Equipment::updateOrCreate(
                ['equipment_name' => $record['equipment_name']],
                array_merge($record, ['user_id' => $admin->id])
            );
        }
    }
}