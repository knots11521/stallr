<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewForm extends Component
{
    public Product $product;

    public int $rating = 0;

    public ?string $title = null;

    public ?string $comment = null;

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $canReview = Review::where('reviewable_id', $this->product->id)
            ->where('reviewable_type', Product::class)
            ->where('user_id', Auth::id())
            ->doesntExist();

        if (! $canReview) {
            $this->dispatch('reviewUpdated');

            return;
        }

        Review::create([
            'reviewable_id' => $this->product->id,
            'reviewable_type' => Product::class,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'title' => $this->title,
            'comment' => $this->comment,
            'status' => 'approved',
        ]);

        $this->reset(['rating', 'title', 'comment']);

        $this->dispatch('reviewUpdated');

        $this->dispatch(
            'notify',
            title: 'Review Submitted',
            message: 'Your review has been posted.',
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.products.review-form');
    }
}
