<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function createCustomer(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Customer');

        return $user;
    }

    protected function createVendor(): Vendor
    {
        $user = User::factory()->create();
        $user->assignRole('Vendor');

        return Vendor::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    protected function createApprovedProduct(Vendor $vendor, float $price = 100): Product
    {
        return Product::factory()->create([
            'vendor_id' => $vendor->id,
            'status' => 'approved',
            'stock' => 100,
            'price' => $price,
            'average_rating' => 0,
            'review_count' => 0,
        ]);
    }

    protected function createPurchase(
        User $customer,
        Product $product
    ): void {
        $order = Order::factory()->create([
            'user_id' => $customer->id,
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        $vendorOrder = VendorOrder::create([
            'order_id' => $order->id,
            'vendor_id' => $product->vendor_id,
            'status' => 'processing',
            'subtotal' => $product->price,
            'total' => $product->price,
        ]);

        OrderItem::create([
            'vendor_order_id' => $vendorOrder->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Can Review Purchased Product
    |--------------------------------------------------------------------------
    */

    public function test_customer_can_review_purchased_product(): void
    {
        $customer = $this->createCustomer();
        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor);

        $this->createPurchase($customer, $product);

        $this->actingAs($customer);

        $reviewSection = Livewire::test('products.review-section', ['product' => $product]);

        $this->assertTrue($reviewSection->get('canReview'));

        Livewire::test('products.review-form', ['product' => $product])
            ->set('rating', 5)
            ->set('title', 'Great product!')
            ->set('comment', 'Loved it.')
            ->call('submit');

        $this->assertDatabaseHas('reviews', [
            'reviewable_id' => $product->id,
            'reviewable_type' => Product::class,
            'user_id' => $customer->id,
            'rating' => 5,
            'status' => 'approved',
        ]);

        $product->refresh();
        $this->assertEquals(5.00, (float) $product->average_rating);
        $this->assertEquals(1, $product->review_count);
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Cannot Review Unpurchased Product
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_review_unpurchased_product(): void
    {
        $customer = $this->createCustomer();
        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor);

        $this->actingAs($customer);

        $reviewSection = Livewire::test('products.review-section', ['product' => $product]);

        $this->assertFalse($reviewSection->get('canReview'));
    }

    /*
    |--------------------------------------------------------------------------
    | Duplicate Review Prevented
    |--------------------------------------------------------------------------
    */

    public function test_duplicate_review_prevented(): void
    {
        $customer = $this->createCustomer();
        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor);

        $this->createPurchase($customer, $product);

        Review::create([
            'reviewable_id' => $product->id,
            'reviewable_type' => Product::class,
            'user_id' => $customer->id,
            'rating' => 4,
            'title' => 'Already reviewed',
            'comment' => 'Test',
            'status' => 'approved',
        ]);

        $this->actingAs($customer);

        Livewire::test('products.review-form', ['product' => $product])
            ->call('submit');

        $this->assertDatabaseCount('reviews', 1);
    }
}
