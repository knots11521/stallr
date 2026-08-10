<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class ProductShow extends Component
{
    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * Determine whether the logged-in user owns this product.
     */
    public function getIsOwnerProperty(): bool
    {
        return auth()->check()
            && $this->product->vendor
            && $this->product->vendor->user_id === auth()->id();
    }

    /**
     * Buy this product immediately.
     */
    public function buyNow(): void
    {
        // Guest users
        if (! auth()->check()) {
            $this->redirectRoute('login', navigate: true);

            return;
        }

        // Product owner cannot purchase their own product.
        if ($this->isOwner) {
            session()->flash(
                'error',
                'You cannot purchase your own product.'
            );

            return;
        }

        // Check stock.
        if ($this->product->stock <= 0) {
            session()->flash(
                'error',
                'This product is out of stock.'
            );

            return;
        }

        // For now, add one item to cart.
        app(CartService::class)->add(
            $this->product->loadMissing('images'),
            1
        );

        // Checkout accepts an explicit cart selection. Buy now should only
        // check out this product, even when the customer has other cart items.
        session()->put('checkout_items', [(int) $this->product->id]);

        // Go directly to checkout.
        $this->redirectRoute(
            'checkout',
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.products.product-show');
    }
}
