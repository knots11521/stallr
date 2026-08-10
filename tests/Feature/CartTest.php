<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function createCustomer(): User
    {
        return User::factory()->create();
    }

    protected function createApprovedProduct(
        ?int $vendorId = null,
        int $stock = 10,
        float $price = 100
    ): Product {
        $vendorId ??= Vendor::factory()->create()->id;

        return Product::factory()->create([
            'status' => 'approved',
            'vendor_id' => $vendorId,
            'stock' => $stock,
            'price' => $price,
        ]);
    }

    protected function createPendingProduct(
        ?int $vendorId = null,
        int $stock = 10,
        float $price = 100
    ): Product {
        $vendorId ??= Vendor::factory()->create()->id;

        return Product::factory()->create([
            'status' => 'pending',
            'vendor_id' => $vendorId,
            'stock' => $stock,
            'price' => $price,
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }

    protected function cartFor(User $user): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Add To Cart
    |--------------------------------------------------------------------------
    */

    public function test_customer_can_add_approved_product(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createApprovedProduct(
            stock: 10
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $service->add($product);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $this->cartFor($customer)->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Pending Product
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_add_pending_product(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createPendingProduct(
            stock: 10
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $this->expectException(ValidationException::class);

        $service->add($product);

        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Increase Quantity
    |--------------------------------------------------------------------------
    */

    public function test_customer_can_increase_quantity(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createApprovedProduct(
            stock: 10
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $service->add($product, 1);

        $service->add($product, 2);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $this->cartFor($customer)->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Decrease Quantity
    |--------------------------------------------------------------------------
    */

    public function test_customer_can_decrease_quantity(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createApprovedProduct(
            stock: 10
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $service->add($product, 3);

        $service->update($product, 2);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $this->cartFor($customer)->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Item
    |--------------------------------------------------------------------------
    */

    public function test_customer_can_remove_item(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createApprovedProduct(
            stock: 10
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $service->add($product);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
        ]);

        $service->remove($product);

        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cart Total
    |--------------------------------------------------------------------------
    */

    public function test_cart_calculates_correct_total(): void
    {
        $customer = $this->createCustomer();

        $productA = $this->createApprovedProduct(
            stock: 10,
            price: 100
        );

        $productB = $this->createApprovedProduct(
            stock: 10,
            price: 50
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $service->add($productA, 2);
        $service->add($productB, 3);

        $cart = $this->cartFor($customer)->load('items.product');

        $total = $cart->items->sum(function ($item) {
            return (float) $item->product->price * $item->quantity;
        });

        $this->assertSame(350.0, $total);
    }

    /*
    |--------------------------------------------------------------------------
    | Stock Limit
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_add_more_than_available_stock(): void
    {
        $customer = $this->createCustomer();

        $product = $this->createApprovedProduct(
            stock: 5
        );

        $this->actingAs($customer);

        $service = app(CartService::class);

        $this->expectException(ValidationException::class);

        $service->add($product, 6);

        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Guest Cannot Manage Cart
    |--------------------------------------------------------------------------
    */

    public function test_guest_cannot_manage_cart(): void
    {
        $product = $this->createApprovedProduct(
            stock: 10
        );

        $service = app(CartService::class);

        $this->expectException(ValidationException::class);

        $service->add($product);
    }
}
