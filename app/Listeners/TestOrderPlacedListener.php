<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class TestOrderPlacedListener
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        Log::info('OrderPlaced event fired.', [
            'order_id' => $event->order->id,
            'user_id' => $event->order->user_id,
            'total' => $event->order->total,
            'stripe_payment_intent_id' =>
            $event->order->stripe_payment_intent_id,
        ]);
    }
}
