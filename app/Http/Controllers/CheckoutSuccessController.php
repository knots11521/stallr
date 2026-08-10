<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutSuccessController extends Controller
{
    public function __invoke(
        Request $request,
        StripeService $stripeService,
        OrderService $orderService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Get PaymentIntent ID
        |--------------------------------------------------------------------------
        */

        $paymentIntentId = $request->query('payment_intent');

        if (! $paymentIntentId) {
            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Payment information was not found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Retrieve PaymentIntent From Stripe
        |--------------------------------------------------------------------------
        */

        try {
            $paymentIntent = $stripeService->retrievePaymentIntent(
                $paymentIntentId
            );
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('cart')
                ->with(
                    'error',
                    'Unable to verify the payment.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Ownership
        |--------------------------------------------------------------------------
        |
        | The PaymentIntent metadata contains the user who
        | started the checkout.
        |
        */

        $paymentUserId = (string) (
            $paymentIntent->metadata->user_id ?? ''
        );

        if (
            $paymentUserId !==
            (string) Auth::id()
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Not Yet Succeeded
        |--------------------------------------------------------------------------
        |
        | The success URL is NOT the authoritative payment
        | confirmation. Stripe's webhook is.
        |
        */

        if ($paymentIntent->status !== 'succeeded') {
            return view(
                'checkout.success',
                [
                    'paymentIntent' => $paymentIntent,

                    'paymentSuccessful' => false,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Finalize and enter the in-app order flow
        |--------------------------------------------------------------------------
        |
        | This is a server-to-server Stripe verification; it never trusts the
        | redirect query string. The same finalizer is used by the signed
        | webhook and is idempotent, so either request can safely arrive first.
        |
        */

        try {
            $order = $orderService->finalizePaymentIntent($paymentIntent);
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('orders.index')
                ->with('error', 'Your payment succeeded, but the order is still being finalized. Please refresh My Orders shortly.');
        }

        return redirect()->route('orders.show', $order);
    }
}
