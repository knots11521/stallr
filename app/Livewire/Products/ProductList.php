<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public $minPrice = null;

    public $maxPrice = null;

    public string $sort = 'latest';

    public function updated($property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $products = Product::query()
            ->approved()
            ->search($this->search)
            ->priceBetween(
                $this->minPrice,
                $this->maxPrice
            )
            ->when(
                $this->category,
                fn($query) => $query->category($this->category)
            )
            ->with([
                'vendor.user',
                'categories',
                'images',
            ]);

        switch ($this->sort) {
            case 'price_low':
                $products->orderBy('price');
                break;

            case 'price_high':
                $products->orderByDesc('price');
                break;

            default:
                $products->latest();
                break;
        }

        return view('livewire.products.product-list', [
            'products' => $products->paginate(12),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
