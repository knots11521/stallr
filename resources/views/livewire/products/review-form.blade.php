<div class="rounded-[14px] border border-stone-200 dark:border-stone-800 bg-white dark:bg-[#1A1A1A] p-6 shadow-xs">

    <h2 class="text-lg font-bold text-stone-900 dark:text-white mb-4">
        Write a Review
    </h2>

    <form wire:submit="submit" class="space-y-4">

        {{-- Rating --}}
        <div>
            <label class="block text-xs font-semibold text-stone-500 dark:text-stone-400 mb-2">
                Rating *
            </label>

            <div class="flex items-center gap-1.5">
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $filled = $rating >= $i;
                    @endphp
                    <button type="button"
                            wire:click="$set('rating', {{ $i }})"
                            class="focus:outline-none">
                        <svg class="w-6 h-6 transition-colors {{ $filled ? 'text-amber-400 fill-current' : 'text-stone-300 dark:text-stone-600 hover:text-amber-300' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.917c.266-.558.945-.76 1.506-.504l.051.02 1.128.414a1 1 0 0 1 .592.592l.414 1.128a1 1 0 0 1-.504 1.297l-.051.018-1.128.414a1 1 0 0 1-1.297-.504l-.414-1.128a1 1 0 0 1 .06-1.297l.051-.018z" />
                        </svg>
                    </button>
                @endfor
            </div>

            @error('rating')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Title --}}
        <div>
            <label for="review-title" class="block text-xs font-semibold text-stone-500 dark:text-stone-400 mb-1.5">
                Title (Optional)
            </label>

            <input type="text" id="review-title" wire:model="title"
                   class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-xl bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-200 focus:outline-none focus:ring-2 focus:ring-[#F1641E]"
                   placeholder="Summarize your experience">

            @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Comment --}}
        <div>
            <label for="review-comment" class="block text-xs font-semibold text-stone-500 dark:text-stone-400 mb-1.5">
                Your Review (Optional)
            </label>

            <textarea id="review-comment" wire:model="comment" rows="4"
                      class="w-full px-3 py-2 text-sm border border-stone-300 dark:border-stone-700 rounded-xl bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-200 focus:outline-none focus:ring-2 focus:ring-[#F1641E]"
                      placeholder="Tell us about your experience with this product..."></textarea>

            @error('comment')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-5 py-2.5 bg-[#F1641E] hover:bg-[#d95516] text-white text-sm font-bold rounded-xl transition">
                Submit Review
            </button>
        </div>

    </form>

</div>
