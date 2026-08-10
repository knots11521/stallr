<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Stripe\PaymentIntent;

class OrderService
{
    public function createPendingOrder(string $stripePaymentIntentId, int $expectedAmount, string $currency = 'PHP'): Order
    {
        $user = Auth::user();
        if (! $user) {
            throw ValidationException::withMessages(['payment' => 'You must be logged in to place an order.']);
        }

        $selectedIds = collect(session('checkout_items', []))->map(fn ($id) => (int) $id)->filter()->unique()->values();
        if ($selectedIds->isEmpty()) {
            throw ValidationException::withMessages(['payment' => 'No products were selected for checkout.']);
        }

        return DB::transaction(function () use ($user, $selectedIds, $stripePaymentIntentId, $expectedAmount, $currency) {
            $existing = Order::where('stripe_payment_intent_id', $stripePaymentIntentId)->first();
            if ($existing) {
                return $existing;
            }

            $cart = Cart::where('user_id', $user->id)->lockForUpdate()->first();
            $cartItems = $cart?->items()->whereIn('product_id', $selectedIds)->get() ?? collect();
            if ($cartItems->isEmpty() || $cartItems->count() !== $selectedIds->count()) {
                throw ValidationException::withMessages(['payment' => 'The selected products are no longer in your cart.']);
            }

            $products = Product::with('vendor')->whereIn('id', $selectedIds)->lockForUpdate()->get()->keyBy('id');
            $snapshot = $cartItems->map(function ($cartItem) use ($products) {
                $product = $products->get($cartItem->product_id);
                if (! $product || $product->status !== 'approved' || ! $product->vendor_id) {
                    throw ValidationException::withMessages(['payment' => 'One of the selected products is no longer available.']);
                }
                if ($cartItem->quantity < 1 || $product->stock < $cartItem->quantity) {
                    throw ValidationException::withMessages(['payment' => "Not enough stock for {$product->name}."]);
                }

                $unitPrice = (float) $product->price;

                return compact('product', 'unitPrice') + [
                    'quantity' => (int) $cartItem->quantity,
                    'lineTotal' => $unitPrice * (int) $cartItem->quantity,
                ];
            });

            $subtotal = (float) $snapshot->sum('lineTotal');
            if ((int) round($subtotal * 100) !== $expectedAmount) {
                throw ValidationException::withMessages(['payment' => 'The order amount has changed. Please try again.']);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'stripe_payment_intent_id' => $stripePaymentIntentId,
                'payment_status' => 'pending',
                'status' => 'pending',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'currency' => strtoupper($currency),
            ]);

            foreach ($snapshot->groupBy(fn ($item) => $item['product']->vendor_id) as $vendorId => $items) {
                $vendorSubtotal = (float) $items->sum('lineTotal');
                $vendorOrder = $order->vendorOrders()->create([
                    'vendor_id' => $vendorId,
                    'status' => 'pending',
                    'subtotal' => $vendorSubtotal,
                    'total' => $vendorSubtotal,
                ]);
                foreach ($items as $item) {
                    $vendorOrder->items()->create([
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->name,
                        'unit_price' => $item['unitPrice'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['lineTotal'],
                    ]);
                }
            }

            return $order->load('vendorOrders.items');
        });
    }

    public function finalizePaymentIntent(PaymentIntent $paymentIntent): Order
    {
        return DB::transaction(function () use ($paymentIntent) {
            $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->lockForUpdate()->first();
            if (! $order) {
                throw new \RuntimeException("Order not found for PaymentIntent: {$paymentIntent->id}");
            }
            if ($order->payment_status === 'paid') {
                return $order->load('vendorOrders.vendor', 'vendorOrders.items');
            }
            if ($paymentIntent->status !== 'succeeded' || (string) ($paymentIntent->metadata->order_id ?? '') !== (string) $order->id || (string) ($paymentIntent->metadata->user_id ?? '') !== (string) $order->user_id) {
                throw new \RuntimeException('PaymentIntent does not match its pending order.');
            }
            if ((int) $paymentIntent->amount !== (int) round((float) $order->total * 100)) {
                throw new \RuntimeException('Stripe payment amount does not match the order amount.');
            }

            $items = $order->vendorOrders()->with('items')->get()->pluck('items')->flatten();
            $products = Product::whereIn('id', $items->pluck('product_id'))->lockForUpdate()->get()->keyBy('id');
            foreach ($items as $item) {
                $product = $products->get($item->product_id);
                if (! $product || $product->stock < $item->quantity) {
                    throw new \RuntimeException("Insufficient stock for {$item->product_name}.");
                }
            }
            foreach ($items as $item) {
                $products->get($item->product_id)->decrement('stock', $item->quantity);
            }

            $order->vendorOrders()->update(['status' => 'processing']);
            $order->update(['payment_status' => 'paid', 'status' => 'processing', 'paid_at' => now()]);
            Cart::where('user_id', $order->user_id)->first()?->items()->whereIn('product_id', $items->pluck('product_id'))->delete();

            $order = $order->fresh(['vendorOrders.vendor', 'vendorOrders.items']);
            OrderPlaced::dispatch($order);

            return $order;
        });
    }

    /**
     * Keep the parent order in sync when Stripe reports a failed attempt. The
     * cart remains intact so the customer can make a new payment attempt.
     */
    public function markPaymentFailed(string $paymentIntentId): void
    {
        DB::transaction(function () use ($paymentIntentId) {
            $order = Order::where('stripe_payment_intent_id', $paymentIntentId)
                ->lockForUpdate()
                ->first();

            if ($order && $order->payment_status === 'pending') {
                $order->update(['payment_status' => 'failed']);
            }
        });
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'STL-'.now()->format('YmdHis').'-'.strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
