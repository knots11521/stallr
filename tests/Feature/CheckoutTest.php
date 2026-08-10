<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Stripe\PaymentIntent;
use Tests\TestCase;

class CheckoutTest extends TestCase
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

    protected function createVendor(): Vendor
    {
        return Vendor::factory()->create();
    }

    protected function createApprovedProduct(
        int $vendorId,
        int $stock = 10,
        float $price = 100
    ): Product {
        return Product::factory()->create([
            'status' => 'approved',
            'vendor_id' => $vendorId,
            'stock' => $stock,
            'price' => $price,
        ]);
    }

    protected function addToCart(
        User $customer,
        Product $product,
        int $quantity
    ): Cart {
        $cart = Cart::firstOrCreate([
            'user_id' => $customer->id,
        ]);

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        return $cart;
    }

    protected function createPaymentIntent(
        string $paymentIntentId,
        int $amount,
        int $orderId,
        int $userId
    ): PaymentIntent {
        return PaymentIntent::constructFrom([
            'id' => $paymentIntentId,
            'amount' => $amount,
            'currency' => 'php',
            'status' => 'succeeded',
            'metadata' => [
                'order_id' => (string) $orderId,
                'user_id' => (string) $userId,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Stock
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_purchase_more_than_available_stock(): void
    {
        $customer = $this->createCustomer();

        $vendor = $this->createVendor();

        $product = $this->createApprovedProduct(
            vendorId: $vendor->id,
            stock: 5,
            price: 100
        );

        $this->addToCart(
            customer: $customer,
            product: $product,
            quantity: 6
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $product->id,
            ],
        ]);

        $service = app(OrderService::class);

        $this->expectException(ValidationException::class);

        $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_stock_fail',
            expectedAmount: 60000,
            currency: 'PHP'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Successful Purchase Decreases Stock
    |--------------------------------------------------------------------------
    */

    public function test_stock_decreases_after_successful_purchase(): void
    {
        $customer = $this->createCustomer();

        $vendor = $this->createVendor();

        $product = $this->createApprovedProduct(
            vendorId: $vendor->id,
            stock: 10,
            price: 100
        );

        $this->addToCart(
            customer: $customer,
            product: $product,
            quantity: 3
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $product->id,
            ],
        ]);

        $service = app(OrderService::class);

        /*
         * ₱100 × 3 = ₱300
         * Stripe amount uses centavos:
         * ₱300 × 100 = 30000
         */

        $order = $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_success',
            expectedAmount: 30000,
            currency: 'PHP'
        );

        $paymentIntent = $this->createPaymentIntent(
            paymentIntentId: 'pi_test_success',
            amount: 30000,
            orderId: $order->id,
            userId: $customer->id
        );

        $service->finalizePaymentIntent($paymentIntent);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | One Cart Can Contain Multiple Vendors
    |--------------------------------------------------------------------------
    */

    public function test_one_cart_can_contain_products_from_multiple_vendors(): void
    {
        $customer = $this->createCustomer();

        $vendorOne = $this->createVendor();
        $vendorTwo = $this->createVendor();

        $vendorOneProduct = $this->createApprovedProduct(
            vendorId: $vendorOne->id,
            stock: 10,
            price: 100
        );

        $vendorTwoProduct = $this->createApprovedProduct(
            vendorId: $vendorTwo->id,
            stock: 10,
            price: 200
        );

        $this->addToCart(
            customer: $customer,
            product: $vendorOneProduct,
            quantity: 1
        );

        $this->addToCart(
            customer: $customer,
            product: $vendorTwoProduct,
            quantity: 1
        );

        $cart = Cart::where('user_id', $customer->id)
            ->with('items')
            ->firstOrFail();

        $this->assertCount(2, $cart->items);

        $this->assertTrue(
            $cart->items->contains(
                fn($item) => $item->product_id === $vendorOneProduct->id
            )
        );

        $this->assertTrue(
            $cart->items->contains(
                fn($item) => $item->product_id === $vendorTwoProduct->id
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | One Order
    |--------------------------------------------------------------------------
    */

    public function test_one_checkout_creates_one_order(): void
    {
        $customer = $this->createCustomer();

        $vendorOne = $this->createVendor();
        $vendorTwo = $this->createVendor();

        $productA = $this->createApprovedProduct(
            vendorId: $vendorOne->id,
            stock: 10,
            price: 100
        );

        $productB = $this->createApprovedProduct(
            vendorId: $vendorTwo->id,
            stock: 10,
            price: 200
        );

        $this->addToCart(
            customer: $customer,
            product: $productA,
            quantity: 1
        );

        $this->addToCart(
            customer: $customer,
            product: $productB,
            quantity: 1
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $productA->id,
                $productB->id,
            ],
        ]);

        $service = app(OrderService::class);

        $order = $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_multi_vendor',
            expectedAmount: 30000,
            currency: 'PHP'
        );

        $this->assertDatabaseCount('orders', 1);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $customer->id,
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Multiple Vendor Orders
    |--------------------------------------------------------------------------
    */

    public function test_multiple_vendor_orders_are_created(): void
    {
        $customer = $this->createCustomer();

        $vendorOne = $this->createVendor();
        $vendorTwo = $this->createVendor();

        $productA = $this->createApprovedProduct(
            vendorId: $vendorOne->id,
            stock: 10,
            price: 100
        );

        $productB = $this->createApprovedProduct(
            vendorId: $vendorTwo->id,
            stock: 10,
            price: 200
        );

        $this->addToCart(
            customer: $customer,
            product: $productA,
            quantity: 1
        );

        $this->addToCart(
            customer: $customer,
            product: $productB,
            quantity: 1
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $productA->id,
                $productB->id,
            ],
        ]);

        $service = app(OrderService::class);

        $order = $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_vendor_orders',
            expectedAmount: 30000,
            currency: 'PHP'
        );

        $this->assertDatabaseCount('vendor_orders', 2);

        $this->assertDatabaseHas('vendor_orders', [
            'order_id' => $order->id,
            'vendor_id' => $vendorOne->id,
        ]);

        $this->assertDatabaseHas('vendor_orders', [
            'order_id' => $order->id,
            'vendor_id' => $vendorTwo->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Correct Items Belong To Correct Vendor
    |--------------------------------------------------------------------------
    */

    public function test_correct_items_belong_to_each_vendor_order(): void
    {
        $customer = $this->createCustomer();

        $vendorOne = $this->createVendor();
        $vendorTwo = $this->createVendor();

        $productA = $this->createApprovedProduct(
            vendorId: $vendorOne->id,
            stock: 10,
            price: 100
        );

        $productB = $this->createApprovedProduct(
            vendorId: $vendorTwo->id,
            stock: 10,
            price: 200
        );

        $productC = $this->createApprovedProduct(
            vendorId: $vendorOne->id,
            stock: 10,
            price: 50
        );

        $this->addToCart(
            $customer,
            $productA,
            1
        );

        $this->addToCart(
            $customer,
            $productB,
            1
        );

        $this->addToCart(
            $customer,
            $productC,
            1
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $productA->id,
                $productB->id,
                $productC->id,
            ],
        ]);

        $service = app(OrderService::class);

        $order = $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_correct_items',
            expectedAmount: 35000,
            currency: 'PHP'
        );

        $vendorOrders = $order->vendorOrders()
            ->with('items')
            ->get();

        $vendorOneOrder = $vendorOrders->firstWhere(
            'vendor_id',
            $vendorOne->id
        );

        $vendorTwoOrder = $vendorOrders->firstWhere(
            'vendor_id',
            $vendorTwo->id
        );

        $this->assertNotNull($vendorOneOrder);
        $this->assertNotNull($vendorTwoOrder);

        $this->assertCount(2, $vendorOneOrder->items);
        $this->assertCount(1, $vendorTwoOrder->items);

        $this->assertTrue(
            $vendorOneOrder->items->contains(
                fn($item) => $item->product_id === $productA->id
            )
        );

        $this->assertTrue(
            $vendorOneOrder->items->contains(
                fn($item) => $item->product_id === $productC->id
            )
        );

        $this->assertTrue(
            $vendorTwoOrder->items->contains(
                fn($item) => $item->product_id === $productB->id
            )
        );

        $this->assertFalse(
            $vendorOneOrder->items->contains(
                fn($item) => $item->product_id === $productB->id
            )
        );

        $this->assertFalse(
            $vendorTwoOrder->items->contains(
                fn($item) => $item->product_id === $productA->id
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Security - Order Ownership
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $customerA = $this->createCustomer();
        $customerB = $this->createCustomer();

        $this->actingAs($customerA);

        $order = \App\Models\Order::factory()->create([
            'user_id' => $customerB->id,
        ]);

        $response = $this->get(
            route('orders.show', $order)
        );

        $response->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | Security - Cart Ownership
    |--------------------------------------------------------------------------
    */

    public function test_customer_cannot_modify_another_customers_cart(): void
    {
        $customerA = $this->createCustomer();
        $customerB = $this->createCustomer();

        $vendor = $this->createVendor();

        $product = $this->createApprovedProduct(
            vendorId: $vendor->id,
            stock: 10
        );

        $cartB = $this->addToCart(
            customer: $customerB,
            product: $product,
            quantity: 2
        );

        $this->actingAs($customerA);

        /*
         * CartService never accepts a cart ID.
         * It always obtains the cart through Auth::id().
         *
         * Therefore customer A can only modify A's cart.
         */

        $service = app(\App\Services\CartService::class);

        $service->remove($product);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cartB->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Security - Price Tampering
    |--------------------------------------------------------------------------
    */

    public function test_browser_cannot_manipulate_product_price(): void
    {
        $customer = $this->createCustomer();

        $vendor = $this->createVendor();

        $product = $this->createApprovedProduct(
            vendorId: $vendor->id,
            stock: 10,
            price: 1000
        );

        $this->addToCart(
            customer: $customer,
            product: $product,
            quantity: 1
        );

        $this->actingAs($customer);

        session([
            'checkout_items' => [
                $product->id,
            ],
        ]);

        $service = app(OrderService::class);

        /*
         * The browser supposedly tries to pay ₱1.
         *
         * But the database price is ₱1,000.
         *
         * ₱1 = 100 centavos.
         */

        $this->expectException(ValidationException::class);

        $service->createPendingOrder(
            stripePaymentIntentId: 'pi_test_price_tampering',
            expectedAmount: 100,
            currency: 'PHP'
        );
    }
}
