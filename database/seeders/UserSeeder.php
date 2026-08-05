<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),

            'avatar' => 'https://ui-avatars.com/api/?name=Admin',
            'phone' => '09000000000',
            'bio' => 'System administrator',
            'address' => 'Stallr Headquarters',
            'is_active' => true,
        ]);


        $admin->assignRole('Admin');



        // Create Vendors
        User::factory(10)
            ->create()
            ->each(function ($user, $index) {

                $user->update([
                    'name' => 'Vendor ' . ($index + 1),
                ]);

                $user->assignRole('Vendor');
            });



        // Create Customers
        User::factory(50)
            ->create()
            ->each(function ($user, $index) {

                $user->update([
                    'name' => 'Customer ' . ($index + 1),
                ]);

                $user->assignRole('Customer');
            });
    }
}
