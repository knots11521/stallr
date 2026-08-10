<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ProductGallery extends Component
{
    public Product $product;

    public int $selectedImage = 0;

    public function mount(Product $product): void
    {
        $this->product = $product->load([
            'images',
            'categories',
            'vendor',
        ]);
    }

    public function selectImage(int $index): void
    {
        if (
            $index >= 0 &&
            $index < $this->product->images->count()
        ) {
            $this->selectedImage = $index;
        }
    }

    public function nextImage(): void
    {
        $count = $this->product->images->count();

        if ($count === 0) {
            return;
        }

        $this->selectedImage = ($this->selectedImage + 1) % $count;
    }

    public function previousImage(): void
    {
        $count = $this->product->images->count();

        if ($count === 0) {
            return;
        }

        $this->selectedImage = ($this->selectedImage - 1 + $count) % $count;
    }

    public function render()
    {
        return view('livewire.products.product-gallery');
    }
}
