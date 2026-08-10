<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartService
{
    /**
     * Return the authenticated user's persistent cart in the shape consumed by
     * the Livewire components. Product pricing is deliberately never stored
     * here; prices are always read from products during checkout.
     */
    public function getCart(): array
    {
        if (! Auth::check()) {
            return [];
        }

        return Cart::query()
            ->firstWhere('user_id', Auth::id())
            ?->items()
            ->get(['product_id', 'quantity'])
            ->map(fn ($item) => [
                'product_id' => (int) $item->product_id,
                'quantity' => (int) $item->quantity,
            ])
            ->all() ?? [];
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $quantity = max(1, $quantity);
        $this->assertPurchasable($product, $quantity);

        $cart = $this->cart();
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $newQuantity = (int) $item->quantity + $quantity;

        $this->assertPurchasable($product, $newQuantity);

        $item->quantity = $newQuantity;
        $item->save();
    }

    public function update(Product $product, int $quantity): void
    {
        $this->assertPurchasable($product, $quantity);

        $item = $this->cart()->items()
            ->where('product_id', $product->id)
            ->first();

        if (! $item) {
            return;
        }

        $item->update(['quantity' => $quantity]);
    }

    public function remove(Product $product): void
    {
        $this->cart()->items()
            ->where('product_id', $product->id)
            ->delete();
    }

    public function clear(): void
    {
        $this->cart()->items()->delete();
    }

    public function count(): int
    {
        return collect($this->getCart())->sum('quantity');
    }

    public function has(Product $product): bool
    {
        return collect($this->getCart())->contains(
            fn (array $item) => $item['product_id'] === (int) $product->id
        );
    }

    public function quantity(Product $product): int
    {
        return (int) (collect($this->getCart())->firstWhere(
            'product_id', (int) $product->id
        )['quantity'] ?? 0);
    }

    protected function cart(): Cart
    {
        if (! Auth::check()) {
            throw ValidationException::withMessages([
                'cart' => 'You must be logged in to manage a cart.',
            ]);
        }

        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    protected function assertPurchasable(Product $product, int $quantity): void
    {
        if ($quantity < 1) {
            throw ValidationException::withMessages(['cart' => 'Quantity must be at least one.']);
        }

        if ($product->status !== 'approved' || ! $product->vendor_id) {
            throw ValidationException::withMessages(['cart' => 'This product is no longer available.']);
        }

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'cart' => "Only {$product->stock} of {$product->name} are available.",
            ]);
        }
    }
}
