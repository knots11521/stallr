<div class="max-w-7xl mx-auto space-y-8 p-4 sm:p-6">

    <!-- Top Breadcrumb & Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-xs font-medium text-stone-500 dark:text-stone-400">
                <span>Products</span>
                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-stone-800 dark:text-stone-200 font-semibold truncate max-w-[200px] sm:max-w-none">
                    {{ $product->name }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                {{ $product->name }}
            </h1>
        </div>

        <!-- Categories & Quick Badging -->
        <div class="flex flex-wrap items-center gap-2">
            @forelse ($product->categories as $category)
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 border border-stone-200/80 dark:border-stone-700/60 shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#F1641E]"></span>
                    {{ $category->name }}
                </span>
            @empty
                <span class="text-xs text-stone-400 italic">Uncategorized</span>
            @endforelse
        </div>
    </div>

    <!-- Main 2-Column Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN: Sticky Gallery & Quick Info (5 cols) -->
        <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-6">
            @if ($product->images->count())
                <!-- Alpine.js Dynamic Image Gallery -->
                <div x-data="{
                    activeSlide: 0,
                    totalSlides: {{ $product->images->count() }},
                    images: [
                        @foreach ($product->images as $image)
                                '{{ str_starts_with($image->image_path, 'storage/') ? asset($image->image_path) : asset('storage/' . $image->image_path) }}'{{ !$loop->last ? ',' : '' }} @endforeach
                    ],
                    next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides }
                }" class="space-y-3">

                    <!-- Main Stage Frame -->
                    <div
                        class="relative aspect-square rounded-2xl overflow-hidden bg-stone-100 dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 shadow-sm group">
                        <img :src="images[activeSlide]" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-all duration-300 ease-out group-hover:scale-102">

                        <!-- Hover Controls (Only if multiple images exist) -->
                        <template x-if="totalSlides > 1">
                            <div>
                                <button @click="prev()" type="button" aria-label="Previous Image"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 dark:bg-stone-900/80 hover:bg-white dark:hover:bg-stone-900 text-stone-800 dark:text-white shadow-md backdrop-blur-md flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="next()" type="button" aria-label="Next Image"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 dark:bg-stone-900/80 hover:bg-white dark:hover:bg-stone-900 text-stone-800 dark:text-white shadow-md backdrop-blur-md flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <!-- Slide Counter Badge -->
                                <div
                                    class="absolute bottom-3 right-3 px-2.5 py-1 rounded-full bg-stone-900/70 text-white text-[11px] font-medium tracking-wide backdrop-blur-xs">
                                    <span x-text="activeSlide + 1"></span> / <span x-text="totalSlides"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Scrollable Thumbnail Strip -->
                    <template x-if="totalSlides > 1">
                        <div class="flex gap-2.5 overflow-x-auto pb-1 scrollbar-none snap-x">
                            <template x-for="(image, index) in images" :key="index">
                                <button @click="activeSlide = index" type="button"
                                    :class="activeSlide === index ?
                                        'ring-2 ring-[#F1641E] ring-offset-2 dark:ring-offset-stone-950 opacity-100' :
                                        'opacity-50 hover:opacity-100'"
                                    class="relative flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border border-stone-200 dark:border-stone-800 transition-all duration-200 snap-start">
                                    <img :src="image" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
            @else
                <!-- Empty State Frame -->
                <div
                    class="w-full aspect-square flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-stone-300 dark:border-stone-800 bg-stone-50 dark:bg-stone-900/50 text-stone-400 p-6 text-center">
                    <div
                        class="w-12 h-12 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 stroke-[1.5] text-stone-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-stone-600 dark:text-stone-300">No Product Images</span>
                    <span class="text-[11px] text-stone-400 mt-0.5">Upload images to display in gallery</span>
                </div>
            @endif

            <!-- Metadata Box -->
            <div
                class="p-4 bg-white dark:bg-[#1A1A1A] rounded-xl border border-stone-200/80 dark:border-stone-800/80 text-xs space-y-2.5 shadow-xs">
                <div class="flex items-center justify-between text-stone-500 dark:text-stone-400">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Created
                    </span>
                    <span
                        class="font-semibold text-stone-800 dark:text-stone-200">{{ $product->created_at->format('M d, Y') }}</span>
                </div>
                @if ($product->approved_at)
                    <div
                        class="flex items-center justify-between text-stone-500 dark:text-stone-400 border-t border-stone-100 dark:border-stone-800/60 pt-2.5">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Approved Date
                        </span>
                        <span
                            class="font-semibold text-stone-800 dark:text-stone-200">{{ $product->approved_at->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN: Pricing, Details, Specs & Vendor (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Specifications Quick Row -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-stone-100 dark:border-stone-800">

                <!-- SKU -->
                <div
                    class="bg-stone-50 dark:bg-stone-900/60
               p-3 rounded-xl
               border border-stone-200/50 dark:border-stone-800/50">

                    <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider block">
                        SKU Code
                    </span>

                    <span class="text-xs font-bold text-stone-800 dark:text-stone-200 block truncate mt-0.5">
                        {{ $product->sku ?: 'N/A' }}
                    </span>

                </div>


                <!-- Inventory -->
                <div
                    class="bg-stone-50 dark:bg-stone-900/60
               p-3 rounded-xl
               border border-stone-200/50 dark:border-stone-800/50">

                    <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider block">
                        Inventory
                    </span>

                    <span class="text-xs font-bold text-stone-800 dark:text-stone-200 block mt-0.5">
                        {{ $product->stock }}
                        {{ Str::plural('unit', $product->stock) }}
                        available
                    </span>

                </div>

            </div>

            <!-- Purchase Actions -->
            <div
                class="bg-white dark:bg-[#1A1A1A]
           border border-stone-200/80 dark:border-stone-800/80
           rounded-2xl p-6 shadow-xs">

                {{-- OWNER --}}
                @if ($this->isOwner)

                    <div
                        class="flex items-start gap-3 p-4
                   rounded-xl
                   bg-stone-50 dark:bg-stone-900/60
                   border border-stone-200 dark:border-stone-800">

                        <div
                            class="w-9 h-9 rounded-lg
                       bg-stone-200 dark:bg-stone-800
                       flex items-center justify-center
                       flex-shrink-0">

                            <svg class="w-5 h-5 text-stone-500 dark:text-stone-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                        <div>
                            <p class="text-sm font-bold text-stone-800 dark:text-stone-200">
                                This is your product
                            </p>

                            <p class="text-xs text-stone-500 dark:text-stone-400 mt-0.5">
                                You cannot purchase your own product.
                            </p>
                        </div>

                    </div>

                    {{-- GUEST --}}
                @elseif (!auth()->check())
                    <div class="space-y-3">

                        <div>
                            <h3 class="text-sm font-bold text-stone-900 dark:text-white">
                                Interested in this product?
                            </h3>

                            <p class="text-xs text-stone-500 dark:text-stone-400 mt-1">
                                Log in to add this product to your cart or buy it now.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a href="{{ route('login') }}"
                                class="flex-1
                           inline-flex items-center justify-center gap-2
                           h-11 px-5
                           rounded-xl
                           bg-[#F1641E]
                           hover:bg-[#d95516]
                           text-white
                           text-sm font-bold
                           shadow-sm
                           transition">

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4
                               M10 17l5-5-5-5
                               M15 12H3" />

                                </svg>

                                Log In to Purchase

                            </a>

                        </div>

                    </div>

                    {{-- LOGGED-IN CUSTOMER --}}
                @else
                    @if ($product->stock > 0)
                        <div class="space-y-3">

                            {{-- Add To Cart Component --}}
                            <livewire:cart.add-to-cart :product="$product" :key="'add-to-cart-' . $product->id" />

                            {{-- Buy Now --}}
                            <button type="button" wire:click="buyNow" wire:loading.attr="disabled"
                                wire:target="buyNow"
                                class="w-full
                       h-11
                       rounded-xl
                       border border-[#F1641E]
                       text-[#F1641E]
                       hover:bg-[#F1641E]/5
                       text-sm font-bold
                       transition
                       disabled:opacity-60
                       disabled:cursor-not-allowed">

                                <span wire:loading.remove wire:target="buyNow">
                                    Buy Now
                                </span>

                                <span wire:loading wire:target="buyNow">
                                    Processing...
                                </span>

                            </button>

                        </div>
                    @else
                        <button type="button" disabled
                            class="w-full
                   h-11
                   rounded-xl
                   bg-stone-200 dark:bg-stone-800
                   text-stone-500 dark:text-stone-400
                   text-sm font-bold
                   cursor-not-allowed">

                            Out of Stock

                        </button>
                    @endif

                @endif

            </div>

            <!-- Product Description Card -->
            <div
                class="bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 rounded-2xl p-6 shadow-xs space-y-3">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-stone-400 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#F1641E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Description
                </h3>
                <p class="text-sm text-stone-600 dark:text-stone-300 leading-relaxed whitespace-pre-line">
                    {{ $product->description ?: 'No detailed description provided for this item.' }}
                </p>
            </div>

            <!-- Seller Information Card -->
            <div
                class="bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-stone-100 dark:border-stone-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#F1641E]/10 dark:bg-[#F1641E]/20 text-[#F1641E] flex items-center justify-center font-bold text-lg flex-shrink-0">
                            {{ strtoupper(substr($product->vendor->store_name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-stone-900 dark:text-white leading-tight">
                                {{ $product->vendor->store_name }}
                            </h2>
                            <span class="text-xs text-stone-400">Owned by {{ $product->vendor->user->name }}</span>
                        </div>
                    </div>
                    <span
                        class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-800 text-[11px] font-semibold text-stone-600 dark:text-stone-300">
                        Verified Store
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs">
                    @if ($product->vendor->phone)
                        <div
                            class="flex items-start gap-2.5 p-3 rounded-xl bg-stone-50 dark:bg-stone-900/40 border border-stone-200/50 dark:border-stone-800/50">
                            <svg class="w-4 h-4 text-stone-400 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <span class="text-stone-400 block font-medium">Contact Phone</span>
                                <span class="font-bold text-stone-800 dark:text-stone-200 mt-0.5 block">
                                    {{ $product->vendor->phone }}
                                </span>
                            </div>
                        </div>
                    @endif

                    @if ($product->vendor->address)
                        <div
                            class="flex items-start gap-2.5 p-3 rounded-xl bg-stone-50 dark:bg-stone-900/40 border border-stone-200/50 dark:border-stone-800/50">
                            <svg class="w-4 h-4 text-stone-400 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <span class="text-stone-400 block font-medium">Location</span>
                                <span class="font-bold text-stone-800 dark:text-stone-200 mt-0.5 block truncate">
                                    {{ $product->vendor->address }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
