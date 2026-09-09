<?php

namespace App\Observers;

use App\Models\Review;

class ReviewObserver
{
    public function created(Review $review): void
    {
        if ($this->isProduct($review)) {
            $review->reviewable->recalculateRating();
        }
    }

    public function updated(Review $review): void
    {
        if ($this->isProduct($review)) {
            $review->reviewable->recalculateRating();
        }
    }

    public function deleted(Review $review): void
    {
        if ($this->isProduct($review)) {
            $review->reviewable->recalculateRating();
        }
    }

    private function isProduct(Review $review): bool
    {
        return $review->reviewable_type === \App\Models\Product::class;
    }
}
