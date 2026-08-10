<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'order_number' => 'STL-TEST-' . fake()->unique()->numerify('######'),

            'status' => 'pending',

            'payment_status' => 'pending',

            'subtotal' => 100.00,

            'total' => 100.00,

            'currency' => 'PHP',

            'stripe_payment_intent_id' => null,

            'paid_at' => null,
        ];
    }
}
