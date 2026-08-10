<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-stone-900 dark:text-white">
                Products
            </h1>

            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400 mt-1">
                Explore items available from various store vendors.
            </p>
        </div>

        <div
            class="text-xs font-semibold text-stone-600 dark:text-stone-400
               bg-stone-100 dark:bg-stone-800/80
               px-3.5 py-2 rounded-[10px]
               border border-stone-200/70 dark:border-stone-700/60
               self-start sm:self-auto">
            Showing {{ $products->total() }}
            {{ Str::plural('product', $products->total()) }}
        </div>
    </div>


    <!-- Filters -->
    <div
        class="bg-white dark:bg-[#1A1A1A]
           border border-stone-200/80 dark:border-stone-800/80
           rounded-[10px]
           p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="sr-only">Search products</label>

                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products..."
                    class="w-full rounded-[10px]
                       border border-stone-200 dark:border-stone-700
                       bg-stone-50 dark:bg-stone-900
                       text-stone-900 dark:text-white
                       placeholder-stone-400
                       px-3 py-2.5 text-sm
                       focus:border-[#F1641E]
                       focus:ring-[#F1641E]">
            </div>


            <!-- Category -->
            <div>
                <label class="sr-only">Category</label>

                <select wire:model.live="category"
                    class="w-full rounded-[10px]
                       border border-stone-200 dark:border-stone-700
                       bg-stone-50 dark:bg-stone-900
                       text-stone-900 dark:text-white
                       px-3 py-2.5 text-sm
                       focus:border-[#F1641E]
                       focus:ring-[#F1641E]">
                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Minimum Price -->
            <div>
                <label class="sr-only">Minimum price</label>

                <input type="number" min="0" wire:model.live.debounce.500ms="minPrice" placeholder="Min price"
                    class="w-full rounded-[10px]
                       border border-stone-200 dark:border-stone-700
                       bg-stone-50 dark:bg-stone-900
                       text-stone-900 dark:text-white
                       placeholder-stone-400
                       px-3 py-2.5 text-sm
                       focus:border-[#F1641E]
                       focus:ring-[#F1641E]">
            </div>


            <!-- Maximum Price -->
            <div>
                <label class="sr-only">Maximum price</label>

                <input type="number" min="0" wire:model.live.debounce.500ms="maxPrice" placeholder="Max price"
                    class="w-full rounded-[10px]
                       border border-stone-200 dark:border-stone-700
                       bg-stone-50 dark:bg-stone-900
                       text-stone-900 dark:text-white
                       placeholder-stone-400
                       px-3 py-2.5 text-sm
                       focus:border-[#F1641E]
                       focus:ring-[#F1641E]">
            </div>
        </div>


        <!-- Sort -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-3">
            <div class="text-xs text-stone-500 dark:text-stone-400">
                Filter and sort products
            </div>

            <select wire:model.live="sort"
                class="w-full sm:w-48 rounded-[10px]
                   border border-stone-200 dark:border-stone-700
                   bg-stone-50 dark:bg-stone-900
                   text-stone-900 dark:text-white
                   px-3 py-2.5 text-sm
                   focus:border-[#F1641E]
                   focus:ring-[#F1641E]">
                <option value="latest">Newest</option>
                <option value="price_low">Lowest Price</option>
                <option value="price_high">Highest Price</option>
            </select>
        </div>
    </div>


    <!-- Product Gallery -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

        @forelse ($products as $product)

            <div wire:key="product-{{ $product->id }}"
                class="group
                   bg-white dark:bg-[#1A1A1A]
                   border border-stone-200/80 dark:border-stone-800/80
                   rounded-[10px]
                   overflow-hidden
                   flex flex-col justify-between
                   hover:border-[#F1641E]/40
                   hover:shadow-lg hover:shadow-[#F1641E]/5
                   transition-all duration-200">

                <div>

                    <!-- Product Image -->
                    <a href="{{ route('products.show', $product->slug) }}" wire:navigate
                        class="block relative aspect-square
                           bg-stone-100 dark:bg-stone-800/50
                           overflow-hidden">

                        @if ($product->images->isNotEmpty())
                            @php
                                $image = $product->images->first();

                                $imagePath = str_starts_with($image->image_path, 'storage/')
                                    ? asset($image->image_path)
                                    : asset('storage/' . $image->image_path);
                            @endphp

                            <img src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy"
                                class="w-full h-full object-cover
                                   group-hover:scale-105
                                   transition-transform duration-300 ease-out">
                        @else
                            <div
                                class="w-full h-full
                                   flex flex-col items-center justify-center
                                   text-stone-400 dark:text-stone-600">
                                <svg class="w-10 h-10 stroke-[1.5]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>

                                <span class="text-[11px] font-medium mt-1.5">
                                    No preview
                                </span>
                            </div>
                        @endif


                        <!-- Stock Badge -->
                        <div class="absolute top-2.5 right-2.5">

                            @if ($product->stock > 10)
                                <span
                                    class="px-2 py-0.5
                                       text-[10px] font-semibold
                                       rounded-[8px]
                                       bg-emerald-500/90 text-white
                                       backdrop-blur-xs shadow-xs">
                                    In Stock ({{ $product->stock }})
                                </span>
                            @elseif ($product->stock > 0)
                                <span
                                    class="px-2 py-0.5
                                       text-[10px] font-semibold
                                       rounded-[8px]
                                       bg-amber-500/90 text-white
                                       backdrop-blur-xs shadow-xs">
                                    Low Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span
                                    class="px-2 py-0.5
                                       text-[10px] font-semibold
                                       rounded-[8px]
                                       bg-rose-500/90 text-white
                                       backdrop-blur-xs shadow-xs">
                                    Out of Stock
                                </span>
                            @endif

                        </div>

                    </a>


                    <!-- Product Information -->
                    <div class="p-4 space-y-2">

                        <!-- Vendor -->
                        @if ($product->vendor)
                            <div
                                class="flex items-center gap-1.5
                                   text-xs text-stone-500 dark:text-stone-400">
                                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>

                                <span class="truncate font-medium">
                                    {{ $product->vendor->store_name }}
                                </span>
                            </div>
                        @endif


                        <!-- Product Name -->
                        <a href="{{ route('products.show', $product->slug) }}" wire:navigate class="block">
                            <h2
                                class="font-semibold text-base
                                   text-stone-900 dark:text-white
                                   group-hover:text-[#F1641E]
                                   transition-colors
                                   line-clamp-1">
                                {{ $product->name }}
                            </h2>
                        </a>


                        <!-- Categories -->
                        @if ($product->categories->isNotEmpty())
                            <div class="flex flex-wrap gap-1">

                                @foreach ($product->categories->take(2) as $category)
                                    <span
                                        class="text-[10px]
                                           px-2 py-0.5
                                           rounded-full
                                           bg-stone-100 dark:bg-stone-800
                                           text-stone-500 dark:text-stone-400">
                                        {{ $category->name }}
                                    </span>
                                @endforeach

                            </div>
                        @endif


                        <!-- Description -->
                        @if ($product->description)
                            <p
                                class="text-xs
                                   text-stone-500 dark:text-stone-400
                                   line-clamp-2
                                   leading-relaxed">
                                {{ $product->description }}
                            </p>
                        @endif

                    </div>

                </div>


                <!-- Price & Purchase Footer -->
                <div
                    class="px-4 pb-4 pt-3
                       border-t border-stone-100
                       dark:border-stone-800/60
                       mt-2 space-y-3">

                    <!-- Price + View Product -->
                    <div class="flex items-end justify-between gap-3">

                        <div>
                            <span
                                class="text-[10px]
                                   font-semibold
                                   text-stone-400
                                   uppercase
                                   tracking-wider
                                   block">
                                Price
                            </span>

                            <span
                                class="text-lg font-bold
                                   text-stone-900 dark:text-white">
                                ₱{{ number_format($product->price, 2) }}
                            </span>
                        </div>


                        <!-- View Product -->
                        <a href="{{ route('products.show', $product->slug) }}" wire:navigate title="View product"
                            aria-label="View {{ $product->name }}"
                            class="inline-flex items-center justify-center
                               w-9 h-9
                               rounded-[10px]
                               bg-stone-100 dark:bg-stone-800/80
                               text-stone-700 dark:text-stone-300
                               hover:bg-[#F1641E]
                               hover:text-white
                               transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                    </div>


                    <!-- Purchase Action -->
                    @if (auth()->check() && $product->vendor && $product->vendor->user_id === auth()->id())
                        <div
                            class="w-full h-10
                               rounded-[10px]
                               flex items-center justify-center
                               bg-stone-100 dark:bg-stone-800
                               text-stone-400 dark:text-stone-500
                               text-xs font-semibold">
                            Your Product
                        </div>
                    @else
                        <livewire:cart.add-to-cart :product="$product" :key="'add-to-cart-' . $product->id" />
                    @endif

                </div>

            </div>

        @empty

            <!-- Empty State -->
            <div
                class="col-span-full
                   py-16 text-center
                   bg-white dark:bg-[#1A1A1A]
                   border border-dashed
                   border-stone-200 dark:border-stone-800
                   rounded-[10px]">

                <div
                    class="w-12 h-12 mx-auto
                       rounded-[10px]
                       bg-stone-100 dark:bg-stone-800
                       flex items-center justify-center
                       text-stone-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>

                <h3 class="text-base font-semibold
                       text-stone-900 dark:text-white">
                    No products available
                </h3>

                <p
                    class="text-xs
                       text-stone-500 dark:text-stone-400
                       mt-1">
                    Try changing your search or filters.
                </p>

            </div>

        @endforelse

    </div>


    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif

    <!-- Floating Cart FAB -->
    @auth
        <div x-data="{ cartCount: {{ app(\App\Services\CartService::class)->count() }} }" x-on:cart-updated.window="cartCount = $event.detail.count"
            class="fixed bottom-6 right-6 z-50">

            <a href="{{ route('cart') }}" wire:navigate aria-label="View cart" title="View Cart"
                class="relative
                   flex items-center justify-center
                   w-14 h-14
                   rounded-full
                   bg-[#F1641E]
                   text-white
                   shadow-lg shadow-[#F1641E]/25
                   hover:bg-[#d95516]
                   hover:shadow-xl hover:shadow-[#F1641E]/30
                   hover:-translate-y-0.5
                   active:scale-95
                   transition-all duration-200">

                <!-- Cart Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.2 1.6a1 1 0 0 0 .8 1.6h10.9M9 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                </svg>

                <!-- Cart Count -->
                <span x-show="cartCount > 0" x-text="cartCount" x-cloak x-transition.scale.origin.top.right
                    class="absolute
                       -top-1
                       -right-1
                       min-w-5
                       h-5
                       px-1
                       rounded-full
                       bg-stone-900
                       dark:bg-white
                       text-white
                       dark:text-stone-900
                       text-[10px]
                       font-bold
                       leading-none
                       flex items-center justify-center
                       border-2
                       border-white
                       dark:border-[#1A1A1A]"></span>

            </a>

        </div>
    @endauth
</div>
