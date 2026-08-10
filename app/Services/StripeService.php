<?php

namespace App\Services;

use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(
            config('services.stripe.secret')
        );
    }

    /**
     * Create a Stripe PaymentIntent.
     */
    public function createPaymentIntent(
        int $amount,
        string $currency = 'php',
        array $metadata = []
    ): PaymentIntent {
        return PaymentIntent::create([
            'amount' => $amount,

            'currency' => strtolower($currency),

            'automatic_payment_methods' => [
                'enabled' => true,
            ],

            'metadata' => $metadata,
        ]);
    }

    /**
     * Update an existing PaymentIntent.
     */
    public function updatePaymentIntent(
        string $paymentIntentId,
        array $metadata = []
    ): PaymentIntent {
        // stripe-php v21 exposes update as a static resource operation. Calling
        // update on a retrieved object invokes that static method with the
        // metadata array as its first argument, which Stripe then treats as the
        // PaymentIntent ID.
        return PaymentIntent::update($paymentIntentId, [
            'metadata' => $metadata,
        ]);
    }

    /**
     * Retrieve a PaymentIntent from Stripe.
     */
    public function retrievePaymentIntent(
        string $paymentIntentId
    ): PaymentIntent {
        return PaymentIntent::retrieve(
            $paymentIntentId
        );
    }
}
