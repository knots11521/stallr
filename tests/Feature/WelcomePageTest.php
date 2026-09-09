<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_renders_dynamic_data_and_dark_mode(): void
    {
        $electronics = Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Gizmos']);
        $fashion = Category::create(['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Threads']);

        $vendor = Vendor::factory()->create(['store_name' => 'ElectroMart', 'is_verified' => true, 'is_active' => true]);

        $product = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Wireless Headphones',
            'price' => 1299.00,
            'status' => 'approved',
            'is_featured' => true,
            'approved_at' => now(),
        ]);
        $product->images()->create(['image_path' => 'storage/products/headphones.jpg', 'sort_order' => 0]);
        $product->categories()->attach([$electronics->id, $fashion->id]);

        $second = Product::factory()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Smart Watch',
            'price' => 2499.00,
            'status' => 'approved',
            'is_featured' => true,
            'approved_at' => now(),
        ]);
        $second->categories()->attach([$electronics->id]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ElectroMart', true);
        $response->assertSee('Wireless Headphones', true);
        $response->assertSee('Smart Watch', true);
        $response->assertSee('Electronics', true);
        $response->assertSee('Fashion', true);
        $response->assertSee('2 Items', true);
        $response->assertSee('₱1,299.00', true);
        $response->assertSee('₱2,499.00', true);
        $response->assertSee('theme-toggle', true);
        $response->assertSee('localStorage.getItem', true);
        $response->assertSee('classList.add', true);
        $response->assertSee('system', true);
        $response->assertSee('dark:bg-[#1A1A1A]', true);
    }
}
