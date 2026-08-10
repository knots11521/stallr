<div>
    @if ($product->stock <= 0)

        <x-secondary-button type="button" disabled
            class="h-10 w-full rounded-[5px] px-4 py-2
           cursor-not-allowed
           disabled:bg-stone-100
           disabled:text-stone-400
           disabled:opacity-100
           dark:disabled:bg-stone-800
           dark:disabled:text-stone-500">
            Out of stock
        </x-secondary-button>
    @else
        <div class="space-y-2.5">

            <!-- Quantity Controls -->
            <div class="flex items-center gap-2">
                <!-- Decrease -->
                <x-secondary-button type="button" wire:click="decrementQuantity" wire:loading.attr="disabled"
                    wire:target="decrementQuantity,incrementQuantity,addToCart" aria-label="Decrease quantity"
                    class="h-9 w-9 px-0 text-base font-semibold disabled:cursor-not-allowed disabled:opacity-50">
                    −
                </x-secondary-button>

                <x-text-input type="number" min="1" max="{{ $product->stock }}" wire:model="quantity"
                    wire:loading.attr="disabled" wire:target="addToCart" aria-label="Quantity"
                    class="h-9 w-16 px-2 py-1 text-center text-sm font-semibold" />

                <!-- Increase -->
                <x-secondary-button type="button" wire:click="incrementQuantity" wire:loading.attr="disabled"
                    wire:target="decrementQuantity,incrementQuantity,addToCart" aria-label="Increase quantity"
                    class="h-9 w-9 px-0 text-base font-semibold disabled:cursor-not-allowed disabled:opacity-50">
                    +
                </x-secondary-button>
            </div>


            <!-- Add To Cart -->
            <x-primary-button type="button" wire:click="addToCart" wire:loading.attr="disabled" wire:target="addToCart"
                class="h-10 w-full gap-2 rounded-[5px] shadow-sm disabled:cursor-not-allowed disabled:opacity-25">
                <span wire:loading.remove wire:target="addToCart">
                    Add to cart
                </span>

                <span wire:loading wire:target="addToCart">
                    Adding…
                </span>
            </x-primary-button>

            <!-- Success Message -->
            @if (session('cart-success'))
                <p class="text-center text-xs font-medium text-emerald-600" role="status">
                    {{ session('cart-success') }}
                </p>
            @endif

            <!-- Quantity Validation Error -->
            @if ($errors->has('quantity'))
                <p class="text-center text-xs text-red-600" role="alert">
                    {{ $errors->first('quantity') }}
                </p>
            @endif

        </div>

    @endif
</div>
