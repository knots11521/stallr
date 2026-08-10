<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class CartPage extends Component
{
    /**
     * Product IDs currently selected for checkout.
     */
    public array $selectedItems = [];

    /**
     * Whether all cart products are selected.
     */
    public bool $selectAll = false;

    /**
     * Initialize the cart selection.
     */
    public function mount(
        CartService $cartService
    ): void {
        $cart = collect(
            $cartService->getCart()
        );

        $cartIds = $this->getCartIds($cart);

        /*
        |--------------------------------------------------------------------------
        | Restore Existing Selection
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | session()->has() distinguishes between:
        |
        | - no selection has ever been created
        | - the user intentionally selected nothing
        |
        */

        if (session()->has('checkout_items')) {
            $this->selectedItems = collect(
                session('checkout_items', [])
            )
                ->map(fn($id) => (int) $id)
                ->filter()
                ->unique()
                ->intersect($cartIds)
                ->values()
                ->all();
        } else {
            /*
            |--------------------------------------------------------------------------
            | First Visit
            |--------------------------------------------------------------------------
            |
            | Select every product by default.
            |
            */

            $this->selectedItems = $cartIds->all();

            session()->put(
                'checkout_items',
                $this->selectedItems
            );
        }

        $this->syncSelectAll($cartIds);
    }

    /**
     * Called whenever an individual checkbox changes.
     */
    public function updatedSelectedItems(): void
    {
        $cart = collect(
            app(CartService::class)->getCart()
        );

        $cartIds = $this->getCartIds($cart);

        $this->selectedItems = collect($this->selectedItems)
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->intersect($cartIds)
            ->values()
            ->all();

        $this->syncSelectAll($cartIds);

        session()->put(
            'checkout_items',
            $this->selectedItems
        );
    }

    /**
     * Select or unselect all products.
     */
    public function toggleSelectAll(
        CartService $cartService
    ): void {
        $cartIds = $this->getCartIds(
            collect($cartService->getCart())
        );

        if ($cartIds->isEmpty()) {
            $this->selectedItems = [];
            $this->selectAll = false;

            session()->put('checkout_items', []);

            return;
        }

        // If everything is currently selected, unselect everything.
        if ($this->selectAll) {
            $this->selectedItems = [];
            $this->selectAll = false;
        } else {
            // Otherwise select everything.
            $this->selectedItems = $cartIds->all();
            $this->selectAll = true;
        }

        session()->put(
            'checkout_items',
            $this->selectedItems
        );
    }

    /**
     * Update product quantity.
     */
    public function updateQuantity(
        int $productId,
        int $quantity,
        CartService $cartService
    ): void {
        $product = Product::findOrFail(
            $productId
        );

        $cartService->update(
            $product,
            $quantity
        );
    }

    /**
     * Remove product from cart.
     */
    public function remove(
        int $productId,
        CartService $cartService
    ): void {
        $product = Product::findOrFail($productId);

        $cartService->remove($product);

        // Remove the product from the selected checkout items.
        $this->selectedItems = collect($this->selectedItems)
            ->reject(fn($id) => (int) $id === $productId)
            ->values()
            ->all();

        // Get the remaining cart products.
        $cartIds = $this->getCartIds(
            collect($cartService->getCart())
        );

        // Make sure selection only contains products still in cart.
        $this->selectedItems = collect($this->selectedItems)
            ->map(fn($id) => (int) $id)
            ->intersect($cartIds)
            ->values()
            ->all();

        // Update Select All.
        $this->syncSelectAll($cartIds);

        // Persist selection.
        session()->put(
            'checkout_items',
            $this->selectedItems
        );
    }

    /**
     * Clear the entire cart.
     */
    public function clear(
        CartService $cartService
    ): void {
        $cartService->clear();

        $this->selectedItems = [];

        $this->selectAll = false;

        session()->forget(
            'checkout_items'
        );
    }

    /**
     * Proceed to checkout using ONLY selected products.
     */
    public function checkout(
        CartService $cartService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Get Current Cart
        |--------------------------------------------------------------------------
        */

        $cart = collect(
            $cartService->getCart()
        );

        $cartIds = $this->getCartIds($cart);

        /*
        |--------------------------------------------------------------------------
        | Normalize Selection
        |--------------------------------------------------------------------------
        */

        $selectedIds = collect(
            $this->selectedItems
        )
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->intersect($cartIds)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | No Selection
        |--------------------------------------------------------------------------
        */

        if ($selectedIds->isEmpty()) {
            session()->put(
                'checkout_items',
                []
            );

            $this->addError(
                'selection',
                'Please select at least one product to checkout.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Persist ONLY Selected Products
        |--------------------------------------------------------------------------
        */

        $this->selectedItems =
            $selectedIds->all();

        session()->put(
            'checkout_items',
            $this->selectedItems
        );

        /*
        |--------------------------------------------------------------------------
        | Go To Checkout
        |--------------------------------------------------------------------------
        */

        return $this->redirectRoute(
            'checkout',
            navigate: true
        );
    }

    /**
     * Render cart.
     */
    public function render(
        CartService $cartService
    ) {
        /*
        |--------------------------------------------------------------------------
        | Get Current Cart
        |--------------------------------------------------------------------------
        */

        $cart = collect(
            $cartService->getCart()
        );

        /*
        |--------------------------------------------------------------------------
        | Load Fresh Products
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->with([
                'vendor',
                'images',
            ])
            ->whereIn(
                'id',
                $cart->pluck('product_id')
            )
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Build Cart Items
        |--------------------------------------------------------------------------
        */

        $items = $cart
            ->map(function ($item) use ($products) {
                $product = $products->get(
                    (int) $item['product_id']
                );

                if (! $product) {
                    return null;
                }

                $quantity = (int) (
                    $item['quantity'] ?? 0
                );

                $currentPrice =
                    (float) $product->price;

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $currentPrice,
                    'subtotal' =>
                    $currentPrice * $quantity,
                ];
            })
            ->filter()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Calculate Selected Subtotal
        |--------------------------------------------------------------------------
        */

        $selectedIds = collect(
            $this->selectedItems
        )
            ->map(fn($id) => (int) $id);

        $subtotal = $items
            ->filter(function ($item) use ($selectedIds) {
                return $selectedIds->contains(
                    (int) $item['product']->id
                );
            })
            ->sum('subtotal');

        return view(
            'livewire.cart.cart-page',
            [
                'items' => $items,
                'subtotal' => $subtotal,
            ]
        );
    }

    /**
     * Get product IDs currently in the cart.
     */
    protected function getCartIds($cart)
    {
        return $cart
            ->pluck('product_id')
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * Synchronize the select-all checkbox state.
     */
    protected function syncSelectAll(
        $cartIds
    ): void {
        $selectedIds = collect(
            $this->selectedItems
        )
            ->map(fn($id) => (int) $id)
            ->unique();

        $this->selectAll =
            $cartIds->isNotEmpty()
            && $cartIds
            ->diff($selectedIds)
            ->isEmpty();
    }
}
