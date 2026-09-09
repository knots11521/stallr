<div class="space-y-6">

    {{-- ==================================================================== --}}
    {{-- HEADER: Average Rating --}}
    {{-- ==================================================================== --}}

    <div class="flex items-center justify-between flex-wrap gap-3">

        <div class="flex items-center gap-4">

            {{-- Average Rating --}}
            <div class="flex items-center gap-2">

                <span class="text-2xl font-bold text-stone-900 dark:text-white">
                    {{ number_format((float) $product->average_rating, 1) }}
                </span>

                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'text-amber-400 fill-current' : 'text-stone-300 dark:text-stone-600' }}"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.917c.266-.558.945-.76 1.506-.504l.051.02 1.128.414a1 1 0 0 1 .592.592l.414 1.128a1 1 0 0 1-.504 1.297l-.051.018-1.128.414a1 1 0 0 1-1.297-.504l-.414-1.128a1 1 0 0 1 .06-1.297l.051-.018z" />
                    </svg>
                @endfor
            </div>

            <span class="text-sm text-stone-500">
                {{ $product->review_count }} review{{ $product->review_count !== 1 ? 's' : '' }}
            </span>

        </div>

        {{-- Sort Dropdown --}}
        @if ($this->reviews->isNotEmpty())
            <select wire:model.live="sortBy"
                    class="text-xs border border-stone-300 dark:border-stone-700 rounded-lg px-2.5 py-1.5 bg-white dark:bg-stone-900 text-stone-700 dark:text-stone-300 focus:outline-none focus:ring-2 focus:ring-[#F1641E]">
                <option value="newest">Newest First</option>
                <option value="highest">Highest Rated</option>
                <option value="lowest">Lowest Rated</option>
            </select>
        @endif

    </div>

    {{-- ==================================================================== --}}
    {{-- REVIEW FORM (if eligible) --}}
    {{-- ==================================================================== --}}

    @if ($this->canReview)
        <livewire:products.review-form :product="$product" :key="'review-form-' . $product->id" />
    @elseif ($this->hasPurchased && auth()->check())
        <div class="p-4 rounded-xl bg-stone-50 dark:bg-stone-900/60 border border-stone-200 dark:border-stone-800">
            <p class="text-sm text-stone-600 dark:text-stone-400">
                You have already reviewed this product.
            </p>
        </div>
    @endif

    {{-- ==================================================================== --}}
    {{-- REVIEWS LIST --}}
    {{-- ==================================================================== --}}

    @forelse ($this->reviews as $review)
        <div class="border-b border-stone-200 dark:border-stone-800 pb-5">

            <div class="flex items-start gap-3">

                {{-- User Avatar --}}
                <div class="w-9 h-9 rounded-full bg-stone-200 dark:bg-stone-800 flex items-center justify-center flex-shrink-0">
                    @if ($review->user->avatar)
                        <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}"
                             class="w-9 h-9 rounded-full object-cover">
                    @else
                        <span class="text-xs font-bold text-stone-600 dark:text-stone-400">
                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </span>
                    @endif
                </div>

                {{-- Review Content --}}
                <div class="flex-1 min-w-0">

                    <div class="flex items-center gap-2 mb-1">

                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400 fill-current' : 'text-stone-300 dark:text-stone-600' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.917c.266-.558.945-.76 1.506-.504l.051.02 1.128.414a1 1 0 0 1 .592.592l.414 1.128a1 1 0 0 1-.504 1.297l-.051.018-1.128.414a1 1 0 0 1-1.297-.504l-.414-1.128a1 1 0 0 1 .06-1.297l.051-.018z" />
                                </svg>
                            @endfor
                        </div>

                        <span class="text-xs text-stone-500 dark:text-stone-400">
                            {{ $review->user->name }}
                        </span>

                        <span class="text-xs text-stone-400 dark:text-stone-500">
                            · {{ $review->created_at->format('M d, Y') }}
                        </span>

                    </div>

                    @if ($review->title)
                        <h4 class="text-sm font-semibold text-stone-900 dark:text-white mb-1">
                            {{ $review->title }}
                        </h4>
                    @endif

                    @if ($review->comment)
                        <p class="text-sm text-stone-600 dark:text-stone-300 leading-relaxed">
                            {{ $review->comment }}
                        </p>
                    @endif

                </div>

            </div>

        </div>
    @empty

        <p class="text-sm text-stone-500 dark:text-stone-400">
            No reviews yet. Be the first to review!
        </p>

    @endforelse

    {{-- ==================================================================== --}}
    {{-- PAGINATION --}}
    {{-- ==================================================================== --}}

    @if ($this->reviews->hasPages())
        <div class="mt-4">
            {{ $this->reviews->links() }}
        </div>
    @endif

</div>
