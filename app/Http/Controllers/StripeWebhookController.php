<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        OrderService $orderService
    ): Response {
        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        $webhookSecret = config('services.stripe.webhook_secret');

        if (! is_string($signature)) {
            return response('Missing Stripe signature', 400);
        }

        if (! is_string($webhookSecret) || blank($webhookSecret)) {
            logger()->critical('Stripe webhook secret is not configured.');

            return response('Webhook is not configured', 503);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Stripe Signature
        |--------------------------------------------------------------------------
        */

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );
        } catch (UnexpectedValueException $exception) {
            report($exception);

            return response(
                'Invalid payload',
                400
            );
        } catch (SignatureVerificationException $exception) {
            report($exception);

            return response(
                'Invalid signature',
                400
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Stripe Events
        |--------------------------------------------------------------------------
        */

        switch ($event->type) {
            /*
            |--------------------------------------------------------------------------
            | Payment Successful
            |--------------------------------------------------------------------------
            |
            | This is the authoritative payment confirmation.
            |
            | IMPORTANT:
            |
            | - Do NOT use Auth::user()
            | - Do NOT use session()
            | - Do NOT use session('checkout_items')
            | - Do NOT rebuild the cart
            | - Do NOT create a new order
            |
            | The PaymentIntent ID identifies the existing
            | pending order created during checkout.
            |
            */

            case 'payment_intent.succeeded':

                $paymentIntent = $event->data->object;

                try {
                    $order = $orderService->finalizePaymentIntent(
                        $paymentIntent
                    );

                    logger()->info(
                        'Stripe payment successfully finalized.',
                        [
                            'payment_intent_id' => $paymentIntent->id,

                            'order_id' => $order->id,

                            'order_number' => $order->order_number,
                        ]
                    );
                } catch (\Throwable $exception) {
                    report($exception);

                    /*
                    |--------------------------------------------------------------------------
                    | Return 500
                    |--------------------------------------------------------------------------
                    |
                    | Stripe will retry the webhook.
                    |
                    */

                    return response(
                        'Webhook processing failed',
                        500
                    );
                }

                break;

                /*
                |--------------------------------------------------------------------------
                | Payment Failed
                |--------------------------------------------------------------------------
                */

            case 'payment_intent.payment_failed':

                $paymentIntent = $event->data->object;

                $orderService->markPaymentFailed($paymentIntent->id);

                logger()->warning(
                    'Stripe payment failed.',
                    [
                        'payment_intent_id' => $paymentIntent->id,

                        'order_id' => $paymentIntent->metadata->order_id
                            ?? null,
                    ]
                );

                break;

                /*
                |--------------------------------------------------------------------------
                | Ignore Other Events
                |--------------------------------------------------------------------------
                */

            default:

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Stripe Acknowledgement
        |--------------------------------------------------------------------------
        */

        return response(
            'Webhook received',
            200
        );
    }
}
