<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'vendor_id' => Vendor::factory(),

            'name' => $name,

            'slug' => fake()->unique()->slug(),

            'description' => fake()->sentence(),

            'sku' => strtoupper(fake()->unique()->bothify('SKU-####??')),

            'price' => fake()->randomFloat(2, 50, 5000),

            'stock' => fake()->numberBetween(1, 100),

            'status' => 'approved',

            'is_featured' => false,

            'approved_at' => now(),

            'approved_by' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => null,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'stock' => 0,
        ]);
    }
}
