<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorProductSeeder extends Seeder
{
    /**
     * Seed 5 vendor users (each with 10 products) + 5 customer users.
     * Idempotent: safe to run multiple times.
     */
    public function run(): void
    {
        // =========================================================
        // 5 VENDOR USERS — each gets a Vendor profile + 10 products
        // =========================================================
        $vendorFirstNames = ['Alexandra', 'Marcus', 'Sophia', 'David', 'Isabella'];
        $vendorStoreNames = [
            'Nexus Threads',
            'Pixel & Stitch',
            'Chrome & Co',
            'Velvet Circuit',
            'Quantum Goods',
        ];
        $vendorAdjectives = ['Artisan', 'Crafted', 'Bespoke', 'Curated', 'Premium'];

        $existingVendorUserCount = User::role('Vendor')
            ->where('email', 'LIKE', '%@example.com')
            ->count();

        for ($i = 0; $i < 5; $i++) {
            $firstName = $vendorFirstNames[$i];
            $vendorName = $firstName . ' ' . fake()->lastName();
            $vendorEmail = strtolower($firstName) . $i . '@example.com';

            // Idempotent: create or update user
            $user = User::updateOrCreate(
                ['email' => $vendorEmail],
                [
                    'name'              => $vendorName,
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'avatar'            => 'https://ui-avatars.com/api/?name=' . urlencode($firstName),
                    'phone'             => fake()->phoneNumber(),
                    'bio'               => fake()->sentence(8, true),
                    'address'           => fake()->address(),
                    'is_active'         => true,
                ]
            );

            if (! $user->hasRole('Vendor')) {
                $user->assignRole('Vendor');
            }

            // Idempotent: create or update vendor profile
            $vendor = Vendor::updateOrCreate(
                ['user_id' => $user->id, 'store_name' => $vendorStoreNames[$i]],
                [
                    'store_name'  => $vendorStoreNames[$i],
                    'description' => fake()->sentence(12, true),
                    'is_verified' => true,
                    'is_active'   => true,
                ]
            );

            // Create 10 approved products per vendor (only if vendor has fewer than 10)
            $existingProductCount = $vendor->products()->count();

            for ($j = 0; $j < (10 - $existingProductCount); $j++) {
                $productName = $vendorAdjectives[$j % count($vendorAdjectives)] . ' ' . fake()->unique()->word();
                $productName = ucfirst($productName) . ' ' . ($existingProductCount + $j + 1);

                Product::create([
                    'vendor_id'     => $vendor->id,
                    'name'          => $productName,
                    'slug'          => \Illuminate\Support\Str::slug($productName . '-' . $vendor->id . '-' . ($existingProductCount + $j)),
                    'description'   => fake()->sentence(15, true),
                    'sku'           => strtoupper(fake()->unique()->bothify('SKU-' . $vendor->id . '-####??')),
                    'price'         => fake()->randomFloat(2, 50, 5000),
                    'stock'         => fake()->numberBetween(1, 100),
                    'low_stock_threshold' => 10,
                    'status'        => 'approved',
                    'is_featured'   => fake()->boolean(20),
                    'approved_at'   => now(),
                    'approved_by'   => null,
                    'average_rating' => fake()->randomFloat(2, 3, 5),
                    'review_count'  => fake()->numberBetween(0, 50),
                ]);
            }
        }

        // =========================================================
        // 5 CUSTOMER USERS
        // =========================================================
        $customerFirstNames = ['Emma', 'Liam', 'Olivia', 'Noah', 'Ava'];

        for ($i = 0; $i < 5; $i++) {
            $firstName = $customerFirstNames[$i];
            $customerName = $firstName . ' ' . fake()->lastName();
            $customerEmail = strtolower($firstName) . $i . '@customer.com';

            $user = User::updateOrCreate(
                ['email' => $customerEmail],
                [
                    'name'              => $customerName,
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password'),
                    'avatar'            => 'https://ui-avatars.com/api/?name=' . urlencode($firstName),
                    'phone'             => fake()->phoneNumber(),
                    'bio'               => fake()->sentence(6, true),
                    'address'           => fake()->address(),
                    'is_active'         => true,
                ]
            );

            if (! $user->hasRole('Customer')) {
                $user->assignRole('Customer');
            }
        }

        $newVendors = User::role('Vendor')
            ->whereHas('vendor')
            ->count();

        $newProducts = Product::where('status', 'approved')->count();

        $customers = User::role('Customer')->whereDoesntHave('vendor')->count();

        $this->command->info("Seeded vendors: {$newVendors} (each with products to total {$newProducts} approved products). Customers: {$customers}.");
    }
}
