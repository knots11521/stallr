<div>
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight
               text-stone-900 dark:text-white">
            Checkout
        </h1>

        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
            Review your order and complete your payment.
        </p>
    </div>


    {{-- ========================================================= --}}
    {{-- GENERAL CART ERROR                                         --}}
    {{-- ========================================================= --}}

    @if ($errors->has('cart'))
        <div class="rounded-[10px]
               border border-red-200
               bg-red-50
               px-4 py-3
               text-sm text-red-700
               dark:border-red-900/50
               dark:bg-red-950/30
               dark:text-red-400"
            role="alert">

            {{ $errors->first('cart') }}

        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- PAYMENT ERROR                                              --}}
    {{-- ========================================================= --}}

    @if ($errors->has('payment'))
        <div class="rounded-[10px]
               border border-red-200
               bg-red-50
               px-4 py-3
               text-sm text-red-700
               dark:border-red-900/50
               dark:bg-red-950/30
               dark:text-red-400"
            role="alert">

            {{ $errors->first('payment') }}

        </div>
    @endif


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">


        {{-- ===================================================== --}}
        {{-- LEFT COLUMN                                            --}}
        {{-- ===================================================== --}}

        <div class="space-y-6 lg:col-span-8">


            {{-- ================================================= --}}
            {{-- CUSTOMER INFORMATION                              --}}
            {{-- ================================================= --}}

            <section
                class="rounded-[10px]
                   border border-stone-200/80
                   bg-white
                   p-5
                   dark:border-stone-800/80
                   dark:bg-[#1A1A1A]">

                <div class="mb-5">

                    <h2
                        class="text-lg font-bold
                           text-stone-900
                           dark:text-white">

                        Customer Information

                    </h2>

                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                        Your account information
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Name --}}
                    <div>

                        <p class="text-xs font-medium text-stone-400">
                            Name
                        </p>

                        <p
                            class="mt-1 text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                            {{ $user->name }}

                        </p>

                    </div>


                    {{-- Email --}}
                    <div>

                        <p class="text-xs font-medium text-stone-400">
                            Email
                        </p>

                        <p
                            class="mt-1 break-all text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                            {{ $user->email }}

                        </p>

                    </div>


                    {{-- Phone --}}
                    <div class="sm:col-span-2">

                        <p class="text-xs font-medium text-stone-400">
                            Phone
                        </p>

                        <p
                            class="mt-1 text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                            {{ $user->phone ?: 'No phone number provided' }}

                        </p>

                    </div>

                </div>

            </section>


            {{-- ================================================= --}}
            {{-- SHIPPING ADDRESS                                   --}}
            {{-- ================================================= --}}

            <section
                class="rounded-[10px]
                   border border-stone-200/80
                   bg-white
                   p-5
                   dark:border-stone-800/80
                   dark:bg-[#1A1A1A]">

                <div>

                    <h2
                        class="text-lg font-bold
                           text-stone-900
                           dark:text-white">

                        Shipping Address

                    </h2>

                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                        Your main address
                    </p>

                </div>


                {{-- Main Address --}}
                <div
                    class="mt-5 rounded-[8px]
                       border border-stone-200
                       bg-stone-50
                       p-4
                       dark:border-stone-800
                       dark:bg-stone-900/50">

                    <div class="space-y-2">

                        {{-- Customer Name --}}
                        <p
                            class="text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                            {{ $user->name }}

                        </p>


                        {{-- Phone --}}
                        @if ($user->phone)
                            <p class="text-sm text-stone-600 dark:text-stone-400">

                                {{ $user->phone }}

                            </p>
                        @endif


                        {{-- Address --}}
                        @if ($user->address)
                            <div
                                class="pt-2
                                   text-sm leading-6
                                   text-stone-600
                                   dark:text-stone-400">

                                {!! nl2br(e($user->address)) !!}

                            </div>
                        @else
                            <p
                                class="pt-2 text-sm
                                   text-stone-500
                                   dark:text-stone-400">

                                No shipping address provided.

                            </p>
                        @endif

                    </div>

                </div>


                {{-- Address information note --}}
                @if (!$user->address)
                    <div
                        class="mt-3 rounded-[8px]
                           border border-amber-200
                           bg-amber-50
                           px-3 py-2.5
                           dark:border-amber-900/50
                           dark:bg-amber-950/20">

                        <p
                            class="text-xs leading-5
                               text-amber-700
                               dark:text-amber-400">

                            Please add your main address to your account
                            before placing an order.

                        </p>

                    </div>
                @endif

            </section>


            {{-- ================================================= --}}
            {{-- ORDER ITEMS                                        --}}
            {{-- ================================================= --}}

            <section
                class="rounded-[10px]
                   border border-stone-200/80
                   bg-white
                   p-5
                   dark:border-stone-800/80
                   dark:bg-[#1A1A1A]">

                <div class="mb-5">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <h2
                                class="text-lg font-bold
                                   text-stone-900
                                   dark:text-white">

                                Order Items

                            </h2>

                            <p
                                class="mt-1 text-xs
                                   text-stone-500
                                   dark:text-stone-400">

                                {{ $items->count() }}
                                {{ $items->count() === 1 ? 'item' : 'items' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- GROUP BY VENDOR                                   --}}
                {{-- ================================================= --}}

                <div class="space-y-6">

                    @foreach ($groupedItems as $vendorId => $vendorItems)
                        @php
                            $vendor = $vendorItems->first()->product->vendor;
                        @endphp

                        <div>

                            {{-- Vendor --}}
                            <div class="mb-3 flex items-center gap-2">

                                <svg class="h-4 w-4 text-[#F1641E]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 10h18M5 10v9h14v-9M7 10V7l5-4 5 4v3M9 19v-5h6v5" />

                                </svg>

                                <span
                                    class="text-sm font-bold
                                       text-stone-900
                                       dark:text-white">

                                    {{ $vendor?->store_name ?? 'Store' }}

                                </span>

                            </div>


                            {{-- Products --}}
                            <div
                                class="divide-y
                                   divide-stone-200
                                   dark:divide-stone-800">

                                @foreach ($vendorItems as $item)
                                    @php
                                        $product = $item->product;
                                        $quantity = (int) $item->quantity;
                                        $unitPrice = (float) $product->price;
                                        $itemSubtotal = $unitPrice * $quantity;
                                        $image = $product->images->first();
                                    @endphp

                                    <div wire:key="checkout-item-{{ $product->id }}"
                                        class="flex gap-4 py-4
                                           first:pt-0
                                           last:pb-0">


                                        {{-- Product Image --}}
                                        <div
                                            class="h-20 w-20 flex-shrink-0
                                               overflow-hidden
                                               rounded-[8px]
                                               bg-stone-100
                                               dark:bg-stone-800">

                                            @if ($image)
                                                @php
                                                    $imagePath = str_starts_with($image->image_path, 'storage/')
                                                        ? asset($image->image_path)
                                                        : asset('storage/' . $image->image_path);
                                                @endphp

                                                <img src="{{ $imagePath }}" alt="{{ $product->name }}"
                                                    class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full
                                                       items-center justify-center
                                                       text-stone-400">

                                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                                    </svg>

                                                </div>
                                            @endif

                                        </div>


                                        {{-- Product Details --}}
                                        <div class="min-w-0 flex-1">

                                            <div
                                                class="flex flex-col
                                                   gap-2
                                                   sm:flex-row
                                                   sm:items-start
                                                   sm:justify-between">

                                                <div class="min-w-0">

                                                    <h3
                                                        class="text-sm font-bold
                                                           text-stone-900
                                                           dark:text-white">

                                                        {{ $product->name }}

                                                    </h3>


                                                    <p
                                                        class="mt-1 text-xs
                                                           text-stone-500
                                                           dark:text-stone-400">

                                                        {{ $unitPrice >= 0 ? '₱' . number_format($unitPrice, 2) . ' each' : 'Price unavailable' }}

                                                    </p>


                                                    <div
                                                        class="mt-2 flex flex-wrap
                                                           items-center gap-2">

                                                        {{-- Quantity --}}
                                                        <span
                                                            class="rounded-full
                                                               bg-stone-100
                                                               px-2 py-1
                                                               text-[10px]
                                                               font-semibold
                                                               text-stone-600
                                                               dark:bg-stone-800
                                                               dark:text-stone-400">

                                                            Quantity: {{ $quantity }}

                                                        </span>


                                                        {{-- Stock --}}
                                                        @if ($product->stock >= $quantity)
                                                            <span
                                                                class="inline-flex
                                                                   items-center gap-1
                                                                   rounded-full
                                                                   bg-emerald-50
                                                                   px-2 py-1
                                                                   text-[10px]
                                                                   font-semibold
                                                                   text-emerald-700
                                                                   dark:bg-emerald-950/30
                                                                   dark:text-emerald-400">

                                                                <span
                                                                    class="h-1.5 w-1.5
                                                                       rounded-full
                                                                       bg-emerald-500">
                                                                </span>

                                                                In stock

                                                            </span>
                                                        @else
                                                            <span
                                                                class="rounded-full
                                                                   bg-red-50
                                                                   px-2 py-1
                                                                   text-[10px]
                                                                   font-semibold
                                                                   text-red-700
                                                                   dark:bg-red-950/30
                                                                   dark:text-red-400">

                                                                Insufficient stock

                                                            </span>
                                                        @endif

                                                    </div>

                                                </div>


                                                {{-- Item Subtotal --}}
                                                <div
                                                    class="flex-shrink-0
                                                       text-left
                                                       sm:text-right">

                                                    <p
                                                        class="text-[10px]
                                                           uppercase
                                                           tracking-wider
                                                           text-stone-400">

                                                        Item total

                                                    </p>

                                                    <p
                                                        class="mt-1 text-sm font-bold
                                                           text-[#F1641E]">

                                                        ₱{{ number_format($itemSubtotal, 2) }}

                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                </div>

            </section>


            {{-- ================================================= --}}
            {{-- PAYMENT                                            --}}
            {{-- ================================================= --}}

            <section
                class="rounded-[10px]
                   border border-stone-200/80
                   bg-white
                   p-5
                   dark:border-stone-800/80
                   dark:bg-[#1A1A1A]">

                <div>

                    <h2
                        class="text-lg font-bold
                           text-stone-900
                           dark:text-white">

                        Payment Method

                    </h2>

                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">

                        Secure payment powered by Stripe.

                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- STRIPE SECURITY INFORMATION                       --}}
                {{-- ================================================= --}}

                <div
                    class="mt-5 rounded-[8px]
                       border border-stone-200
                       bg-stone-50
                       p-4
                       dark:border-stone-800
                       dark:bg-stone-900/50">

                    <div class="flex gap-3">

                        <div
                            class="flex h-9 w-9 flex-shrink-0
                               items-center justify-center
                               rounded-full
                               bg-emerald-100
                               text-emerald-600
                               dark:bg-emerald-950/40
                               dark:text-emerald-400">

                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z" />

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9 12l2 2 4-4" />

                            </svg>

                        </div>


                        <div>

                            <p
                                class="text-sm font-semibold
                                   text-stone-900
                                   dark:text-white">

                                Secure payment

                            </p>

                            <p
                                class="mt-1 text-xs leading-5
                                   text-stone-500
                                   dark:text-stone-400">

                                Your payment information is securely processed
                                by Stripe. Your card details are never stored
                                on our server.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- STRIPE PAYMENT ELEMENT                            --}}
                {{-- ================================================= --}}

                @if ($paymentPrepared && $paymentClientSecret)
                    <div wire:key="stripe-payment-{{ $paymentIntentId }}" class="mt-5 space-y-4">

                        <div
                            class="border-t border-stone-200
                               pt-5
                               dark:border-stone-800">

                            <h3
                                class="mb-3 text-sm font-bold
                                   text-stone-900
                                   dark:text-white">

                                Payment

                            </h3>


                            {{-- ================================================= --}}
                            {{-- IMPORTANT: STRIPE MOUNTS HERE                      --}}
                            {{-- ================================================= --}}

                            <div id="payment-element" wire:ignore>
                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- PAYMENT MESSAGE                                   --}}
                        {{-- ================================================= --}}

                        <p id="payment-message" class="text-sm text-red-500">
                        </p>


                        {{-- ================================================= --}}
                        {{-- COMPLETE PAYMENT                                  --}}
                        {{-- ================================================= --}}

                        <button type="button" id="submit-payment" disabled
                            class="inline-flex w-full
                               items-center justify-center
                               gap-2
                               rounded-[10px]
                               border border-transparent
                               bg-[#F1641E]
                               px-4 py-3
                               text-sm font-bold
                               text-white
                               transition
                               hover:bg-[#d95716]
                               active:scale-[0.98]
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#F1641E]
                               focus:ring-offset-2
                               disabled:cursor-not-allowed
                               disabled:opacity-50
                               dark:focus:ring-offset-[#121212]">

                            Loading payment form...

                        </button>

                    </div>
                @endif


                {{-- ================================================= --}}
                {{-- STRIPE PAYMENT ERROR                              --}}
                {{-- ================================================= --}}

                <div id="stripe-payment-error" class="mt-3 text-sm text-red-600 dark:text-red-400">
                </div>

            </section>

        </div>


        {{-- ===================================================== --}}
        {{-- RIGHT COLUMN                                          --}}
        {{-- ===================================================== --}}

        <div class="lg:col-span-4">

            <div
                class="lg:sticky lg:top-6
                   rounded-[10px]
                   border border-stone-200/80
                   bg-white
                   p-5
                   dark:border-stone-800/80
                   dark:bg-[#1A1A1A]">


                {{-- ================================================= --}}
                {{-- ORDER SUMMARY                                      --}}
                {{-- ================================================= --}}

                <h2
                    class="text-lg font-bold
                       text-stone-900
                       dark:text-white">

                    Order Summary

                </h2>


                {{-- Items --}}
                <div class="mt-5 flex justify-between">

                    <span class="text-sm text-stone-500 dark:text-stone-400">
                        Items
                    </span>

                    <span
                        class="text-sm font-semibold
                           text-stone-900
                           dark:text-white">

                        {{ $items->count() }}

                    </span>

                </div>


                {{-- Quantity --}}
                <div class="mt-2 flex justify-between">

                    <span class="text-sm text-stone-500 dark:text-stone-400">
                        Total quantity
                    </span>

                    <span
                        class="text-sm font-semibold
                           text-stone-900
                           dark:text-white">

                        {{ $items->sum('quantity') }}

                    </span>

                </div>


                {{-- Subtotal --}}
                <div
                    class="mt-4 flex justify-between
                       border-t border-stone-200
                       pt-4
                       dark:border-stone-800">

                    <span class="text-sm text-stone-500 dark:text-stone-400">
                        Subtotal
                    </span>

                    <span
                        class="text-sm font-semibold
                           text-stone-900
                           dark:text-white">

                        ₱{{ number_format($subtotal, 2) }}

                    </span>

                </div>


                {{-- Shipping --}}
                <div class="mt-3 flex justify-between">

                    <span class="text-sm text-stone-500 dark:text-stone-400">
                        Shipping
                    </span>

                    <span
                        class="text-sm font-semibold
                           text-emerald-600
                           dark:text-emerald-400">

                        Free

                    </span>

                </div>


                {{-- Shipping method --}}
                <div
                    class="mt-3 rounded-[8px]
                       border border-stone-200
                       bg-stone-50
                       px-3 py-2.5
                       dark:border-stone-800
                       dark:bg-stone-900/50">

                    <div class="flex justify-between gap-3">

                        <span class="text-xs text-stone-500 dark:text-stone-400">
                            Shipping method
                        </span>

                        <span
                            class="text-xs font-semibold
                               text-stone-700
                               dark:text-stone-300">

                            Standard Delivery

                        </span>

                    </div>

                </div>


                {{-- Total --}}
                <div
                    class="mt-5 flex items-end justify-between
                       border-t border-stone-200
                       pt-4
                       dark:border-stone-800">

                    <span
                        class="font-bold
                           text-stone-900
                           dark:text-white">

                        Total

                    </span>

                    <span class="text-2xl font-extrabold
                           text-[#F1641E]">

                        ₱{{ number_format($total, 2) }}

                    </span>

                </div>


                {{-- ================================================= --}}
                {{-- PREPARE PAYMENT                                   --}}
                {{-- ================================================= --}}

                @if (!$paymentPrepared)
                    <button type="button" wire:click="preparePayment" wire:loading.attr="disabled"
                        wire:target="preparePayment"
                        class="mt-6 inline-flex w-full
                           items-center justify-center
                           gap-2
                           rounded-[10px]
                           border border-transparent
                           bg-[#F1641E]
                           px-4 py-3
                           text-sm font-bold
                           text-white
                           transition
                           hover:bg-[#d95716]
                           active:scale-[0.98]
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#F1641E]
                           focus:ring-offset-2
                           disabled:cursor-not-allowed
                           disabled:opacity-50
                           dark:focus:ring-offset-[#121212]">


                        {{-- Normal --}}
                        <span wire:loading.remove wire:target="preparePayment" class="inline-flex items-center gap-2">

                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.8" />

                                <path stroke-linecap="round" stroke-width="1.8" d="M3 10h18" />

                            </svg>

                            Prepare Payment

                        </span>


                        {{-- Loading --}}
                        <span wire:loading wire:target="preparePayment" class="inline-flex items-center gap-2">

                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">

                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>

                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>

                            </svg>

                            Preparing payment...

                        </span>

                    </button>
                @else
                    <div
                        class="mt-6 rounded-[8px]
                           border border-emerald-200
                           bg-emerald-50
                           px-4 py-3
                           dark:border-emerald-900/50
                           dark:bg-emerald-950/20">

                        <div class="flex gap-3">

                            <svg class="h-5 w-5 flex-shrink-0
                                   text-emerald-600
                                   dark:text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M5 12l4 4L19 6" />

                            </svg>

                            <div>

                                <p
                                    class="text-sm font-semibold
                                       text-emerald-800
                                       dark:text-emerald-300">

                                    Payment ready

                                </p>

                                <p
                                    class="mt-1 text-xs
                                       text-emerald-700
                                       dark:text-emerald-400">

                                    Your payment session has been prepared securely.

                                </p>

                            </div>

                        </div>

                    </div>
                @endif


                {{-- ================================================= --}}
                {{-- SECURITY NOTE                                     --}}
                {{-- ================================================= --}}

                <p
                    class="mt-3 text-center
                       text-[11px]
                       leading-4
                       text-stone-400">

                    By continuing, you agree to complete payment
                    for the selected items.

                </p>


            </div>

        </div>

    </div>
</div>
