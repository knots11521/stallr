<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vendor>
 */
class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        $storeName = fake()->unique()->company();

        return [
            'user_id' => User::factory(),
            'store_name' => $storeName,
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'logo' => null,
            'banner' => null,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'is_verified' => true,
        ];
    }
}
