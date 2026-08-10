<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class AddToCart extends Component
{
    public Product $product;

    public int $quantity = 1;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * Decrease quantity.
     */
    public function decrementQuantity(): void
    {
        $this->quantity = max(
            1,
            $this->quantity - 1
        );
    }

    /**
     * Increase quantity.
     */
    public function incrementQuantity(): void
    {
        $this->quantity = min(
            $this->product->stock,
            $this->quantity + 1
        );
    }

    /**
     * Add product to cart.
     */
    public function addToCart(
        CartService $cartService
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Normalize Quantity
        |--------------------------------------------------------------------------
        */

        $this->quantity = max(
            1,
            (int) $this->quantity
        );

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        if (! auth()->check()) {
            $this->redirectRoute(
                'login',
                navigate: true
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Get Fresh Product
        |--------------------------------------------------------------------------
        |
        | Never trust the product state that was loaded when
        | the page was first rendered.
        |
        */

        $this->product = Product::with([
            'vendor',
            'images',
        ])->findOrFail(
            $this->product->id
        );

        /*
        |--------------------------------------------------------------------------
        | Product Owner Protection
        |--------------------------------------------------------------------------
        */

        if (
            $this->product->vendor &&
            $this->product->vendor->user_id === auth()->id()
        ) {
            session()->flash(
                'error',
                'You cannot purchase your own product.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Product Availability
        |--------------------------------------------------------------------------
        */

        if ($this->product->status !== 'approved') {
            session()->flash(
                'error',
                'This product is no longer available.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Stock Check
        |--------------------------------------------------------------------------
        */

        if ($this->product->stock <= 0) {
            session()->flash(
                'error',
                'This product is out of stock.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Quantity Validation
        |--------------------------------------------------------------------------
        */

        $this->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $this->product->stock,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Add To Cart
        |--------------------------------------------------------------------------
        */

        $cartService->add(
            $this->product,
            $this->quantity
        );

        /*
        |--------------------------------------------------------------------------
        | Update Cart Indicator
        |--------------------------------------------------------------------------
        */

        $this->dispatch(
            'cart-updated',
            count: $cartService->count()
        );

        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        session()->flash(
            'cart-success',
            "{$this->product->name} added to your cart."
        );
    }

    public function render()
    {
        return view(
            'livewire.cart.add-to-cart'
        );
    }
}
