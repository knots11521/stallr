<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // CREATE ADMIN
        // =========================================================

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'avatar' => 'https://ui-avatars.com/api/?name=Admin',
                'phone' => '09000000000',
                'bio' => 'System administrator',
                'address' => 'Stallr Headquarters',
                'is_active' => true,
            ]
        );

        $admin->syncRoles(['Admin']);


        // =========================================================
        // CREATE VENDORS
        // =========================================================

        User::factory(10)
            ->create()
            ->each(function ($user, $index) {
                $user->update([
                    'name' => 'Vendor ' . ($index + 1),
                ]);

                $user->assignRole('Vendor');
            });


        // =========================================================
        // CREATE CUSTOMERS
        // =========================================================

        User::factory(50)
            ->create()
            ->each(function ($user, $index) {
                $user->update([
                    'name' => 'Customer ' . ($index + 1),
                ]);

                $user->assignRole('Customer');
            });


        // =========================================================
        // CREATE NATHANIEL
        // BOTH CUSTOMER AND VENDOR
        // =========================================================

        $nathaniel = User::updateOrCreate(
            ['email' => 'nathanieldalisay06@gmail.com'],
            [
                'name' => 'Nathaniel Dalisay',
                'password' => Hash::make('password'),
                'avatar' => 'https://ui-avatars.com/api/?name=Nathaniel+Dalisay',
                'phone' => '09123456789',
                'bio' => 'Customer and Vendor account',
                'address' => 'Bacolod City',
                'is_active' => true,
            ]
        );

        // Assign BOTH roles
        $nathaniel->syncRoles([
            'Customer',
            'Vendor',
        ]);


        // =========================================================
        // CREATE NATHANIEL'S VENDOR PROFILE
        // =========================================================

        $vendor = Vendor::updateOrCreate(
            ['user_id' => $nathaniel->id],
            [
                'store_name' => "Nathaniel's Store",
                'slug' => 'nathaniells-store',
                'phone' => '09123456789',
                'address' => 'Bacolod City',
            ]
        );


        // =========================================================
        // CREATE APPROVED PRODUCTS
        // =========================================================

        Product::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'sku' => 'NATH-001',
            ],
            [
                'name' => 'Premium Wireless Headphones',
                'slug' => 'premium-wireless-headphones1',
                'price' => 1499.00,
                'stock' => 25,
                'description' => 'High-quality wireless headphones with comfortable ear cushions and long battery life.',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );


        Product::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'sku' => 'NATH-002',
            ],
            [
                'name' => 'Mechanical Gaming Keyboard',
                'slug' => 'premium-wireless-headphones2',
                'price' => 2499.00,
                'stock' => 15,
                'description' => 'RGB mechanical gaming keyboard with responsive switches and durable construction.',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );


        Product::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'sku' => 'NATH-003',
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'slug' => 'premium-wireless-headphones3',
                'price' => 899.00,
                'stock' => 30,
                'description' => 'Lightweight wireless gaming mouse with adjustable DPI and ergonomic design.',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );


        Product::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'sku' => 'NATH-004',
            ],
            [
                'name' => 'USB-C Fast Charger',
                 'slug' => 'premium-wireless-headphones4',
                'price' => 599.00,
                'stock' => 40,
                'description' => 'Compact USB-C fast charger suitable for phones, tablets, and other compatible devices.',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );


        Product::updateOrCreate(
            [
                'vendor_id' => $vendor->id,
                'sku' => 'NATH-005',
            ],
            [
                'name' => 'Laptop Stand',
                 'slug' => 'premium-wireless-headphones5',
                'price' => 799.00,
                'stock' => 20,
                'description' => 'Adjustable laptop stand designed to improve desk ergonomics and viewing height.',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );
    }
}
