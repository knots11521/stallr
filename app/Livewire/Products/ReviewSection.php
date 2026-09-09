<?php

namespace App\Livewire\Products;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewSection extends Component
{
    use WithPagination;

    public Product $product;

    public string $sortBy = 'newest';

    protected $listeners = ['reviewUpdated' => '$refresh'];

    public function getReviewsProperty()
    {
        $query = $this->product->reviews()
            ->where('status', 'approved')
            ->with('user')
            ->latest();

        if ($this->sortBy === 'highest') {
            $query->orderByDesc('rating');
        } elseif ($this->sortBy === 'lowest') {
            $query->orderBy('rating');
        }

        return $query->paginate(5, pageName: 'reviews');
    }

    public function getCanReviewProperty(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        $alreadyReviewed = Review::where('reviewable_id', $this->product->id)
            ->where('reviewable_type', Product::class)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return false;
        }

        return OrderItem::where('product_id', $this->product->id)
            ->whereHas('vendorOrder.order', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('payment_status', 'paid');
            })
            ->exists();
    }

    public function getHasPurchasedProperty(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return OrderItem::where('product_id', $this->product->id)
            ->whereHas('vendorOrder.order', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('payment_status', 'paid');
            })
            ->exists();
    }

    public function render()
    {
        return view('livewire.products.review-section');
    }
}
