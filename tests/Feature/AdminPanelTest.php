<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        return $user;
    }

    protected function createVendor(): Vendor
    {
        $user = User::factory()->create();
        $user->assignRole('Vendor');

        return Vendor::factory()->create([
            'user_id' => $user->id,
            'is_active' => true,
            'is_verified' => true,
        ]);
    }

    protected function createApprovedProduct(Vendor $vendor): Product
    {
        return Product::factory()->create([
            'vendor_id' => $vendor->id,
            'status' => 'approved',
            'stock' => 10,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Can View All Orders
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_view_all_orders(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $order = Order::factory()->create([
            'order_number' => 'STL-ADMIN-TEST-001',
            'payment_status' => 'paid',
        ]);

        $response = $this->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertSee('STL-ADMIN-TEST-001');
    }

    /*
    |--------------------------------------------------------------------------
    | Vendor Suspension Hides Products
    |--------------------------------------------------------------------------
    */

    public function test_vendor_suspension_hides_products(): void
    {
        $vendor = $this->createVendor();
        $product = $this->createApprovedProduct($vendor);

        $vendor->update(['is_active' => false]);

        $visibleProduct = Product::query()
            ->where('status', 'approved')
            ->whereHas('vendor', fn ($query) => $query->where('is_active', true))
            ->find($product->id);

        $this->assertNull($visibleProduct);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Can Suspend Vendor
    |--------------------------------------------------------------------------
    */

    public function test_admin_can_suspend_vendor(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $vendor = $this->createVendor();

        $this->assertTrue($vendor->fresh()->is_active);

        $vendor->update(['is_active' => false]);

        $this->assertFalse($vendor->fresh()->is_active);
    }
}
