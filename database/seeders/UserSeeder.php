<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // ADMIN ACCOUNT
        // =========================================================

        $admin = User::updateOrCreate(
            [
                'email' => env('SEED_ADMIN_EMAIL', 'admin@example.com'),
            ],
            [
                'name' => env('SEED_ADMIN_NAME', 'Admin'),
                'password' => Hash::make(
                    env('SEED_ADMIN_PASSWORD', 'change-this-password')
                ),
                'avatar' => 'https://ui-avatars.com/api/?name=Admin',
                'phone' => '09000000000',
                'bio' => 'System administrator',
                'address' => 'Stallr Headquarters',
                'is_active' => true,
            ]
        );

        $admin->syncRoles(['Admin']);


        // =========================================================
        // YOUR ACCOUNT
        // CUSTOMER + VENDOR
        // =========================================================

        $user = User::updateOrCreate(
            [
                'email' => env(
                    'SEED_USER_EMAIL',
                    'nathanieldalisay06@gmail.com'
                ),
            ],
            [
                'name' => env(
                    'SEED_USER_NAME',
                    'Nathaniel Dalisay'
                ),
                'password' => Hash::make(
                    env('SEED_USER_PASSWORD', 'change-this-password')
                ),
                'avatar' => 'https://ui-avatars.com/api/?name=Nathaniel+Dalisay',
                'phone' => '09123456789',
                'bio' => 'Customer and Vendor account',
                'address' => 'Bacolod City',
                'is_active' => true,
            ]
        );

        $user->syncRoles([
            'Customer',
            'Vendor',
        ]);


        // =========================================================
        // TWO FAKER CUSTOMERS
        // =========================================================

        User::factory(2)
            ->create()
            ->each(function (User $fakerUser) {
                $fakerUser->assignRole('Customer');
            });
    }
}
