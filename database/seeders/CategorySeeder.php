<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Handmade', 'description' => 'Handcrafted by independent artisans'],
            ['name' => 'Electronics', 'description' => 'High-tech gear and gadgets'],
            ['name' => 'Fashion', 'description' => 'Apparel and accessories'],
            ['name' => 'Home & Living', 'description' => 'Home decor and furniture'],
            ['name' => 'Beauty', 'description' => 'Beauty and personal care'],
            ['name' => 'Art & Books', 'description' => 'Artwork and books'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'description' => $cat['description'],
            ]);
        }

        // Link categories to existing approved products (1-3 categories each)
        $categoryIds = Category::pluck('id')->toArray();

        Product::where('status', 'approved')->each(function ($product) use ($categoryIds) {
            $randomCount = rand(1, 3);
            $randomCategories = collect($categoryIds)->shuffle()->take($randomCount)->toArray();

            if (!empty($randomCategories)) {
                $product->categories()->syncWithoutDetaching($randomCategories);
            }
        });
    }
}
