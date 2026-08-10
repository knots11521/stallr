<?php

namespace App\Livewire\Checkout;

use App\Models\Product;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckoutPage extends Component
{
    public array $cart = [];

    public $items;

    public $groupedItems;

    public array $selectedItems = [];

    public float $subtotal = 0;

    public float $total = 0;

    /*
    |--------------------------------------------------------------------------
    | Stripe Payment State
    |--------------------------------------------------------------------------
    */

    public bool $paymentPrepared = false;

    public ?string $paymentClientSecret = null;

    public ?string $paymentIntentId = null;

    public function mount(
        CartService $cartService
    ): void {
        $this->items = collect();

        $this->groupedItems = collect();

        /*
        |--------------------------------------------------------------------------
        | Get Current Cart
        |--------------------------------------------------------------------------
        */

        $this->cart = $cartService->getCart();

        if (empty($this->cart)) {
            $this->redirectRoute('cart');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Checkout Items
        |--------------------------------------------------------------------------
        */

        $cartIds = collect($this->cart)
            ->pluck('product_id')
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        $this->selectedItems = collect(
            session('checkout_items', [])
        )
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->intersect($cartIds)
            ->values()
            ->all();

        if (empty($this->selectedItems)) {
            $this->addError(
                'cart',
                'Please select at least one product to checkout.'
            );

            $this->redirectRoute('cart');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Cart Only
        |--------------------------------------------------------------------------
        */

        $selectedCart = collect($this->cart)
            ->filter(function (array $cartItem) {
                return in_array(
                    (int) ($cartItem['product_id'] ?? 0),
                    $this->selectedItems,
                    true
                );
            })
            ->values();

        if ($selectedCart->isEmpty()) {
            session()->forget('checkout_items');

            $this->addError(
                'cart',
                'The selected products are no longer in your cart.'
            );

            $this->redirectRoute('cart');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Fresh Products
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->whereIn('id', $this->selectedItems)
            ->with([
                'vendor',
                'images',
            ])
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Validate Selected Products
        |--------------------------------------------------------------------------
        */

        try {
            foreach ($selectedCart as $cartItem) {
                $productId =
                    (int) ($cartItem['product_id'] ?? 0);

                $quantity =
                    (int) ($cartItem['quantity'] ?? 0);

                if (! $productId) {
                    throw ValidationException::withMessages([
                        'cart' =>
                        'Your selected products contain an invalid product.',
                    ]);
                }

                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' =>
                        'One of your selected products is no longer available.',
                    ]);
                }

                if ($product->status !== 'approved') {
                    throw ValidationException::withMessages([
                        'cart' =>
                        "{$product->name} is no longer available.",
                    ]);
                }

                if ($quantity < 1) {
                    throw ValidationException::withMessages([
                        'cart' =>
                        "Invalid quantity for {$product->name}.",
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' =>
                        "Not enough stock for {$product->name}. " .
                            "Available: {$product->stock}.",
                    ]);
                }

                if (! $product->vendor_id) {
                    throw ValidationException::withMessages([
                        'cart' =>
                        "{$product->name} is not associated with a vendor.",
                    ]);
                }
            }
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->addError(
                        'cart',
                        $message
                    );
                }
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Build Checkout Items
        |--------------------------------------------------------------------------
        */

        $this->items = $selectedCart
            ->map(function (array $cartItem) use ($products) {
                $productId =
                    (int) $cartItem['product_id'];

                $product =
                    $products->get($productId);

                if (! $product) {
                    return null;
                }

                return (object) [
                    'product' => $product,
                    'quantity' =>
                    (int) $cartItem['quantity'],
                ];
            })
            ->filter()
            ->values();

        if ($this->items->isEmpty()) {
            session()->forget('checkout_items');

            $this->addError(
                'cart',
                'Your selected products are no longer available.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Group By Vendor
        |--------------------------------------------------------------------------
        */

        $this->groupedItems = $this->items
            ->groupBy(
                fn($item) =>
                $item->product->vendor_id
            );

        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $this->subtotal = (float) $this->items->sum(
            fn($item) =>
            (float) $item->product->price
                * (int) $item->quantity
        );

        $this->total =
            $this->subtotal;
    }

    /**
     * Prepare Stripe payment and create the durable
     * pending order before payment confirmation.
     */
    public function preparePayment(
        CartService $cartService,
        StripeService $stripeService,
        OrderService $orderService
    ): void {
        $this->resetErrorBag('payment');

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Payment Preparation
        |--------------------------------------------------------------------------
        */

        if (
            $this->paymentPrepared &&
            $this->paymentIntentId
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Current Cart
        |--------------------------------------------------------------------------
        */

        $cart = collect(
            $cartService->getCart()
        );

        if ($cart->isEmpty()) {
            $this->addError(
                'payment',
                'Your cart is empty.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Selected IDs
        |--------------------------------------------------------------------------
        */

        $selectedIds = collect(
            session('checkout_items', [])
        )
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($selectedIds->isEmpty()) {
            $this->addError(
                'payment',
                'No products were selected for checkout.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Cart
        |--------------------------------------------------------------------------
        */

        $selectedCart = $cart
            ->filter(function (array $cartItem) use ($selectedIds) {
                return $selectedIds->contains(
                    (int) ($cartItem['product_id'] ?? 0)
                );
            })
            ->values();

        if ($selectedCart->isEmpty()) {
            $this->addError(
                'payment',
                'The selected products are no longer in your cart.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Fresh Products
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->whereIn(
                'id',
                $selectedIds->all()
            )
            ->with([
                'vendor',
                'images',
            ])
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Validate Again Before Payment
        |--------------------------------------------------------------------------
        */

        try {
            foreach ($selectedCart as $cartItem) {
                $productId =
                    (int) ($cartItem['product_id'] ?? 0);

                $quantity =
                    (int) ($cartItem['quantity'] ?? 0);

                $product =
                    $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'payment' =>
                        'One of the selected products is no longer available.',
                    ]);
                }

                if ($product->status !== 'approved') {
                    throw ValidationException::withMessages([
                        'payment' =>
                        "{$product->name} is no longer available.",
                    ]);
                }

                if ($quantity < 1) {
                    throw ValidationException::withMessages([
                        'payment' =>
                        "Invalid quantity for {$product->name}.",
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'payment' =>
                        "Not enough stock for {$product->name}. " .
                            "Available: {$product->stock}.",
                    ]);
                }

                if (! $product->vendor_id) {
                    throw ValidationException::withMessages([
                        'payment' =>
                        "{$product->name} is not associated with a vendor.",
                    ]);
                }
            }
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->addError(
                        'payment',
                        $message
                    );
                }
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Fresh Total
        |--------------------------------------------------------------------------
        */

        $total = 0;

        foreach ($selectedCart as $cartItem) {
            $product =
                $products->get(
                    (int) $cartItem['product_id']
                );

            $quantity =
                (int) $cartItem['quantity'];

            $total +=
                (float) $product->price
                * $quantity;
        }

        if ($total <= 0) {
            $this->addError(
                'payment',
                'Your order total must be greater than zero.'
            );

            return;
        }

        $this->subtotal =
            $total;

        $this->total =
            $total;

        /*
        |--------------------------------------------------------------------------
        | PHP Pesos -> Centavos
        |--------------------------------------------------------------------------
        */

        $amount = (int) round(
            $total * 100
        );

        /*
        |--------------------------------------------------------------------------
        | Create Stripe PaymentIntent
        |--------------------------------------------------------------------------
        */

        try {
            $paymentIntent =
                $stripeService->createPaymentIntent(
                    amount: $amount,

                    currency: 'php',

                    metadata: [
                        'user_id' =>
                        (string) Auth::id(),
                    ],
                );

            /*
            |--------------------------------------------------------------------------
            | Create Durable Pending Order
            |--------------------------------------------------------------------------
            |
            | The OrderService must snapshot the selected products,
            | quantities and prices here.
            |
            | The webhook must NOT depend on:
            |
            | - session()
            | - checkout_items
            | - the current cart
            |
            */

            $order =
                $orderService->createPendingOrder(
                    stripePaymentIntentId: $paymentIntent->id,

                    expectedAmount: $amount,

                    currency: 'PHP'
                );

            /*
            |--------------------------------------------------------------------------
            | Attach Order Information To Stripe
            |--------------------------------------------------------------------------
            */

            $stripeService->updatePaymentIntent(
                paymentIntentId: $paymentIntent->id,

                metadata: [
                    'user_id' =>
                    (string) Auth::id(),

                    'order_id' =>
                    (string) $order->id,

                    'order_number' =>
                    (string) $order->order_number,
                ],
            );
        } catch (\Throwable $exception) {
            report($exception);

            $this->addError(
                'payment',
                'Unable to prepare your payment. Please try again.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Store Payment State
        |--------------------------------------------------------------------------
        */

        $this->paymentIntentId =
            $paymentIntent->id;

        $this->paymentClientSecret =
            $paymentIntent->client_secret;

        $this->paymentPrepared =
            true;

        /*
        |--------------------------------------------------------------------------
        | Notify Stripe JavaScript
        |--------------------------------------------------------------------------
        */

        $this->dispatch(
            'stripe-payment-ready',

            clientSecret: $this->paymentClientSecret,

            returnUrl: route('checkout.success'),
        );
    }

    public function render()
    {
        return view(
            'livewire.checkout.checkout-page',
            [
                'user' => Auth::user(),
            ]
        );
    }
}
