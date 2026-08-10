<div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight
                   text-stone-900 dark:text-white">
            Cart
        </h1>

        <p class="text-sm text-stone-500 dark:text-stone-400 mt-1">
            Review the products you've added.
        </p>
    </div>


    @if ($items->isEmpty())

        <!-- Empty Cart -->
        <div
            class="flex flex-col items-center justify-center
                   rounded-[10px]
                   border border-dashed
                   border-stone-200
                   bg-white
                   py-12
                   text-center
                   dark:border-stone-800
                   dark:bg-[#1A1A1A]">

            <div
                class="flex h-12 w-12 items-center justify-center
                       rounded-full
                       bg-stone-100
                       dark:bg-stone-800">

                <svg class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                        d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4" />

                </svg>

            </div>


            <h2
                class="mt-4 text-sm font-semibold
                       text-stone-900
                       dark:text-white">

                Your cart is empty

            </h2>


            <p
                class="mt-1 max-w-sm text-sm
                       text-stone-500
                       dark:text-stone-400">

                Browse our products and add something you like.

            </p>


            <a href="{{ route('products.index') }}" wire:navigate
                class="mt-4 inline-flex items-center justify-center
                       rounded-[10px]
                       bg-[#F1641E]
                       px-4 py-2
                       text-sm font-semibold
                       text-white
                       transition duration-150
                       hover:bg-[#d95716]
                       focus:outline-none
                       focus:ring-2
                       focus:ring-[#F1641E]
                       focus:ring-offset-2
                       dark:focus:ring-offset-[#121212]">

                Browse products

            </a>

        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- ========================================== -->
            <!-- CART ITEMS                                  -->
            <!-- ========================================== -->

            <div class="lg:col-span-8 space-y-3">

                <!-- Selection Header -->
                <div
                    class="flex items-center justify-between
                           bg-white dark:bg-[#1A1A1A]
                           border border-stone-200/80
                           dark:border-stone-800/80
                           rounded-[10px]
                           px-4 py-3">

                    <label class="flex items-center gap-3 cursor-pointer">

                        <input type="checkbox" wire:click="toggleSelectAll" @checked($selectAll)
                            class="w-4 h-4 rounded
           border-stone-300
           dark:border-stone-600
           text-[#F1641E]
           focus:ring-[#F1641E]">
                        <span
                            class="text-sm font-semibold
                                   text-stone-700
                                   dark:text-stone-300">

                            Select all

                        </span>

                    </label>


                    <span class="text-xs text-stone-400">

                        {{ count($selectedItems) }} selected

                    </span>

                </div>


                <!-- ====================================== -->
                <!-- CART ITEM LOOP                          -->
                <!-- ====================================== -->

                @foreach ($items as $item)
                    @php
                        $product = $item['product'];
                        $image = $product->images->first();

                        $productId = (int) $product->id;
                        $quantity = (int) $item['quantity'];

                        /*
                         * Display price from the current
                         * database product, not the session
                         * cart price.
                         */
                        $currentPrice = (float) $product->price;

                        $itemSubtotal = $currentPrice * $quantity;

                        $isSelected = in_array($productId, $selectedItems);
                    @endphp


                    <div wire:key="cart-item-{{ $productId }}"
                        class="bg-white dark:bg-[#1A1A1A]
                               border
                               {{ $isSelected
                                   ? 'border-[#F1641E]/50 ring-1 ring-[#F1641E]/10'
                                   : 'border-stone-200/80 dark:border-stone-800/80' }}
                               rounded-[10px]
                               p-4
                               transition-all duration-150">

                        <div class="flex gap-3 sm:gap-4">

                            <!-- Checkbox -->
                            <div class="pt-1 flex-shrink-0">

                                <input type="checkbox" value="{{ $productId }}" wire:model.live="selectedItems"
                                    aria-label="Select {{ $product->name }}"
                                    class="w-5 h-5
                                           rounded
                                           border-stone-300
                                           dark:border-stone-600
                                           text-[#F1641E]
                                           focus:ring-[#F1641E]
                                           cursor-pointer">

                            </div>


                            <!-- Product Image -->
                            <a href="{{ route('products.show', $product->slug) }}" wire:navigate
                                class="w-24 h-24 sm:w-28 sm:h-28
                                       flex-shrink-0
                                       rounded-[10px]
                                       overflow-hidden
                                       bg-stone-100
                                       dark:bg-stone-800">

                                @if ($image)
                                    @php
                                        $imagePath = str_starts_with($image->image_path, 'storage/')
                                            ? asset($image->image_path)
                                            : asset('storage/' . $image->image_path);
                                    @endphp

                                    <img src="{{ $imagePath }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full
                                               flex items-center justify-center
                                               text-stone-400">

                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 3l18 18M10.5 6H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1.5M14 6h4a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-1.5M9 9l6 6" />

                                        </svg>

                                    </div>
                                @endif

                            </a>


                            <!-- Product Information -->
                            <div class="flex-1 min-w-0">

                                <div class="flex justify-between gap-3">

                                    <div class="min-w-0">

                                        <a href="{{ route('products.show', $product->slug) }}" wire:navigate
                                            class="font-bold text-sm sm:text-base
                                                   text-stone-900
                                                   dark:text-white
                                                   hover:text-[#F1641E]">

                                            {{ $product->name }}

                                        </a>


                                        <p
                                            class="text-xs
                                                   text-stone-500
                                                   dark:text-stone-400
                                                   mt-1">

                                            {{ $product->vendor->store_name }}

                                        </p>

                                    </div>


                                    <!-- Remove -->
                                    <button type="button" wire:click="remove({{ $productId }})"
                                        wire:loading.attr="disabled" wire:target="remove({{ $productId }})"
                                        title="Remove from cart" aria-label="Remove {{ $product->name }} from cart"
                                        class="flex-shrink-0
                                               w-8 h-8
                                               inline-flex
                                               items-center
                                               justify-center
                                               rounded-full
                                               text-stone-400
                                               hover:text-rose-500
                                               hover:bg-rose-50
                                               dark:hover:bg-rose-950/30
                                               transition-all duration-150
                                               active:scale-95
                                               disabled:opacity-50
                                               disabled:cursor-not-allowed">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 6l12 12M18 6L6 18" />

                                        </svg>

                                    </button>

                                </div>


                                <!-- Current Database Price -->
                                <div class="mt-3">

                                    <span class="text-xs text-stone-400">
                                        Current price
                                    </span>

                                    <div
                                        class="font-bold
                                               text-stone-900
                                               dark:text-white">

                                        ₱{{ number_format($currentPrice, 2) }}

                                    </div>

                                </div>


                                <!-- Quantity + Subtotal -->
                                <div
                                    class="flex flex-wrap
                                           items-center
                                           justify-between
                                           gap-3 mt-3">

                                    <!-- Quantity -->
                                    <div class="flex items-center gap-2">

                                        <!-- Minus -->
                                        <button type="button"
                                            wire:click="updateQuantity(
                                                {{ $productId }},
                                                {{ max(1, $quantity - 1) }}
                                            )"
                                            wire:loading.attr="disabled" wire:target="updateQuantity"
                                            @disabled($quantity <= 1) aria-label="Decrease quantity"
                                            class="w-8 h-8
                                                   rounded-[8px]
                                                   bg-stone-100
                                                   dark:bg-stone-800
                                                   hover:bg-stone-200
                                                   dark:hover:bg-stone-700
                                                   disabled:opacity-40
                                                   disabled:cursor-not-allowed
                                                   transition">

                                            −

                                        </button>


                                        <!-- Quantity -->
                                        <span
                                            class="w-8 text-center
                                                   text-sm font-semibold
                                                   text-stone-900
                                                   dark:text-white">

                                            {{ $quantity }}

                                        </span>


                                        <!-- Plus -->
                                        <button type="button"
                                            wire:click="updateQuantity(
                                                {{ $productId }},
                                                {{ $quantity + 1 }}
                                            )"
                                            wire:loading.attr="disabled" wire:target="updateQuantity"
                                            @disabled($quantity >= $product->stock) aria-label="Increase quantity"
                                            class="w-8 h-8
                                                   rounded-[8px]
                                                   bg-stone-100
                                                   dark:bg-stone-800
                                                   hover:bg-stone-200
                                                   dark:hover:bg-stone-700
                                                   disabled:opacity-40
                                                   disabled:cursor-not-allowed
                                                   transition">

                                            +

                                        </button>

                                    </div>


                                    <!-- Subtotal -->
                                    <div class="text-right">

                                        <span
                                            class="text-[10px]
                                                   uppercase
                                                   tracking-wider
                                                   text-stone-400">

                                            Subtotal

                                        </span>

                                        <div
                                            class="font-bold
                                                   text-[#F1641E]">

                                            ₱{{ number_format($itemSubtotal, 2) }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach


                <!-- ====================================== -->
                <!-- SELECTION ERROR                         -->
                <!-- ====================================== -->

                @if ($errors->has('selection'))
                    <p class="text-sm text-red-600 dark:text-red-400" role="alert">

                        {{ $errors->first('selection') }}

                    </p>
                @endif


                <!-- Checkout/Payment Error -->
                @if ($errors->has('payment'))
                    <p class="text-sm text-red-600 dark:text-red-400" role="alert">

                        {{ $errors->first('payment') }}

                    </p>
                @endif


                <!-- General Cart Error -->
                @if ($errors->has('cart'))
                    <p class="text-sm text-red-600 dark:text-red-400" role="alert">

                        {{ $errors->first('cart') }}

                    </p>
                @endif

            </div>


            <!-- ========================================== -->
            <!-- ORDER SUMMARY                               -->
            <!-- ========================================== -->

            <div class="lg:col-span-4">

                <div
                    class="lg:sticky lg:top-6
                           bg-white dark:bg-[#1A1A1A]
                           border border-stone-200/80
                           dark:border-stone-800/80
                           rounded-[10px]
                           p-5">

                    <h2
                        class="font-bold text-lg
                               text-stone-900
                               dark:text-white">

                        Order Summary

                    </h2>


                    <!-- Selected Items -->
                    <div class="flex justify-between mt-5">

                        <span class="text-sm text-stone-500">
                            Selected items
                        </span>

                        <span
                            class="text-sm font-semibold
                                   text-stone-900
                                   dark:text-white">

                            {{ count($selectedItems) }}

                        </span>

                    </div>


                    <!-- Subtotal -->
                    <div
                        class="flex justify-between
                               mt-3 pt-4
                               border-t
                               border-stone-200
                               dark:border-stone-800">

                        <span class="text-sm text-stone-500">
                            Subtotal
                        </span>

                        <span
                            class="font-bold
                                   text-stone-900
                                   dark:text-white">

                            ₱{{ number_format($subtotal, 2) }}

                        </span>

                    </div>


                    <!-- Shipping -->
                    <div class="flex justify-between mt-2">

                        <span class="text-sm text-stone-500">
                            Shipping
                        </span>

                        <span class="text-xs text-stone-400 text-right">
                            Calculated at checkout
                        </span>

                    </div>


                    <!-- Total -->
                    <div
                        class="flex justify-between
                               mt-4 pt-4
                               border-t
                               border-stone-200
                               dark:border-stone-800">

                        <span
                            class="font-bold
                                   text-stone-900
                                   dark:text-white">

                            Total

                        </span>

                        <span class="text-xl font-extrabold
                                   text-[#F1641E]">

                            ₱{{ number_format($subtotal, 2) }}

                        </span>

                    </div>


                    <!-- ================================== -->
                    <!-- CHECKOUT                            -->
                    <!-- ================================== -->

                    <x-primary-button type="button" wire:click="checkout" wire:loading.attr="disabled"
                        wire:target="checkout" :disabled="empty($selectedItems)"
                        class="mt-5 w-full
                               inline-flex
                               items-center
                               justify-center
                               gap-2
                               px-4 py-3
                               rounded-[10px]
                               border border-transparent
                               bg-[#F1641E]
                               text-white
                               text-sm font-bold
                               hover:bg-[#d95716]
                               active:scale-[0.98]
                               transition
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#F1641E]
                               focus:ring-offset-2
                               disabled:opacity-50
                               disabled:cursor-not-allowed
                               dark:focus:ring-offset-[#121212]">

                        <!-- Normal -->
                        <span wire:loading.remove wire:target="checkout" class="inline-flex items-center gap-1">

                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <rect x="3" y="5" width="18" height="14" rx="2" ry="2"
                                    stroke-width="1.8" />

                                <path stroke-linecap="round" stroke-width="1.8" d="M3 10h18" />

                            </svg>

                            Proceed to Checkout

                        </span>


                        <!-- Loading -->
                        <span wire:loading wire:target="checkout" class="inline-flex items-center gap-2">

                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">

                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>

                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>

                            </svg>

                            Processing...

                        </span>

                    </x-primary-button>


                    <!-- No Selection Hint -->
                    @if (empty($selectedItems))
                        <p
                            class="mt-2 text-center
                                   text-[11px]
                                   text-stone-400">

                            Select at least one product to continue.

                        </p>
                    @endif


                    {{-- Clear Cart intentionally disabled for now.
                    <button
                        type="button"
                        wire:click="clear"
                        wire:confirm="Are you sure you want to clear your cart?"
                        wire:loading.attr="disabled"
                        wire:target="clear"
                        class="mt-2 w-full
                               py-2
                               text-xs font-semibold
                               text-stone-500
                               hover:text-rose-500
                               transition">

                        Clear Cart

                    </button>
                    --}}

                </div>

            </div>

        </div>

    @endif

</div>
