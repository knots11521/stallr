<div>
    {{-- ==================================================================== --}}
    {{-- MAIN CONTAINER                                                       --}}
    {{-- ==================================================================== --}}

    {{-- [CHECKPOINT 1]: PAGE HEADER --}}

    <div class="mb-8">

        <h1 class="text-2xl font-bold text-stone-900 dark:text-white">
            My Orders
        </h1>

        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
            View your previous orders, payment status, and order details.
        </p>
    </div>

    {{-- ==================================================================== --}}
    {{-- ORDERS LIST                                                          --}}
    {{-- ==================================================================== --}}

    <div class="space-y-4">

        @forelse ($orders as $order)

            {{-- ============================================================ --}}
            {{-- SINGLE ORDER CARD                                             --}}
            {{-- ============================================================ --}}

            <div
                class="overflow-hidden rounded-[14px]
               border border-stone-200
               bg-white
               dark:border-stone-800
               dark:bg-[#1A1A1A]">


                {{-- ======================================================== --}}
                {{-- ORDER HEADER                                              --}}
                {{-- ======================================================== --}}

                <div
                    class="flex flex-col gap-3
                   border-b border-stone-100
                   px-5 py-4
                   dark:border-stone-800
                   sm:flex-row
                   sm:items-center
                   sm:justify-between">

                    {{-- Order Identification --}}
                    <div>

                        <p
                            class="text-sm font-bold
                           text-stone-900
                           dark:text-white">

                            #{{ $order->order_number }}

                        </p>

                        <p
                            class="mt-1 text-xs
                           text-stone-500
                           dark:text-stone-400">

                            Placed {{ $order->created_at->format('M d, Y \a\t h:i A') }}

                        </p>

                    </div>


                    {{-- Status Badges --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Payment Status --}}
                        @if ($order->payment_status === 'paid')
                            <span
                                class="inline-flex items-center gap-1.5
                               rounded-full
                               bg-emerald-50
                               px-2.5 py-1
                               text-xs font-semibold
                               text-emerald-700
                               dark:bg-emerald-950/30
                               dark:text-emerald-400">

                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                   bg-emerald-500">
                                </span>

                                Paid

                            </span>
                        @elseif ($order->payment_status === 'failed')
                            <span
                                class="inline-flex items-center gap-1.5
                               rounded-full
                               bg-red-50
                               px-2.5 py-1
                               text-xs font-semibold
                               text-red-700
                               dark:bg-red-950/30
                               dark:text-red-400">

                                <span class="h-1.5 w-1.5 rounded-full
                                   bg-red-500">
                                </span>

                                Payment Failed

                            </span>
                        @elseif ($order->payment_status === 'pending')
                            <span
                                class="inline-flex items-center gap-1.5
                               rounded-full
                               bg-amber-50
                               px-2.5 py-1
                               text-xs font-semibold
                               text-amber-700
                               dark:bg-amber-950/30
                               dark:text-amber-400">

                                <span class="h-1.5 w-1.5 rounded-full
                                   bg-amber-500">
                                </span>

                                Payment Pending

                            </span>
                        @else
                            <span
                                class="inline-flex items-center
                               rounded-full
                               bg-stone-100
                               px-2.5 py-1
                               text-xs font-semibold
                               text-stone-600
                               dark:bg-stone-800
                               dark:text-stone-300">

                                {{ ucfirst($order->payment_status) }}

                            </span>
                        @endif


                        {{-- Order Status --}}
                        <span
                            class="inline-flex items-center
                           rounded-full
                           bg-stone-100
                           px-2.5 py-1
                           text-xs font-semibold
                           text-stone-600
                           dark:bg-stone-800
                           dark:text-stone-300">

                            {{ ucfirst($order->status) }}

                        </span>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ORDER BODY                                                 --}}
                {{-- ======================================================== --}}

                <div class="px-5 py-5">


                    {{-- ==================================================== --}}
                    {{-- CUSTOMER / SHIPPING INFORMATION                      --}}
                    {{-- ==================================================== --}}

                    <div class="grid grid-cols-1 gap-5
                       md:grid-cols-2">


                        {{-- Customer --}}
                        <div>

                            <p
                                class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                                Customer

                            </p>

                            <p
                                class="mt-1 text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                                {{ $order->user?->name ?? 'Customer' }}

                            </p>

                            @if ($order->user?->email)
                                <p
                                    class="mt-1 break-all
                                   text-xs
                                   text-stone-500
                                   dark:text-stone-400">

                                    {{ $order->user->email }}

                                </p>
                            @endif

                        </div>


                        {{-- Shipping Address --}}
                        <div>

                            <p
                                class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                                Shipping Address

                            </p>

                            @if ($order->user?->address)
                                <p
                                    class="mt-1 text-sm
                                   leading-5
                                   text-stone-600
                                   dark:text-stone-400">

                                    {!! nl2br(e($order->user->address)) !!}

                                </p>

                                @if ($order->user?->phone)
                                    <p
                                        class="mt-1 text-xs
                                       text-stone-500
                                       dark:text-stone-400">

                                        {{ $order->user->phone }}

                                    </p>
                                @endif
                            @else
                                <p
                                    class="mt-1 text-sm
                                   text-stone-500
                                   dark:text-stone-400">

                                    No address provided.

                                </p>
                            @endif

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- ORDER SUMMARY                                          --}}
                    {{-- ==================================================== --}}

                    <div
                        class="mt-5
                       rounded-[10px]
                       border border-stone-200
                       bg-stone-50
                       p-4
                       dark:border-stone-800
                       dark:bg-stone-900/50">

                        <div
                            class="grid grid-cols-2
                           gap-4
                           sm:grid-cols-4">


                            {{-- Items --}}
                            <div>

                                <p
                                    class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-wider
                                   text-stone-400">

                                    Items

                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold
                                   text-stone-900
                                   dark:text-white">

                                    {{ $order->vendorOrders->sum(fn($vendorOrder) => $vendorOrder->items->sum('quantity')) }}

                                </p>

                            </div>


                            {{-- Subtotal --}}
                            <div>

                                <p
                                    class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-wider
                                   text-stone-400">

                                    Subtotal

                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold
                                   text-stone-900
                                   dark:text-white">

                                    ₱{{ number_format((float) $order->subtotal, 2) }}

                                </p>

                            </div>


                            {{-- Shipping --}}
                            <div>

                                <p
                                    class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-wider
                                   text-stone-400">

                                    Shipping

                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold
                                   text-emerald-600
                                   dark:text-emerald-400">

                                    Free

                                </p>

                            </div>


                            {{-- Total --}}
                            <div>

                                <p
                                    class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-wider
                                   text-stone-400">

                                    Total

                                </p>

                                <p
                                    class="mt-1 text-lg font-extrabold
                                   text-[#F1641E]">

                                    ₱{{ number_format((float) $order->total, 2) }}

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- PAYMENT INFORMATION                                   --}}
                    {{-- ==================================================== --}}

                    <div
                        class="mt-4 flex flex-col
                       gap-2
                       text-xs
                       sm:flex-row
                       sm:items-center
                       sm:justify-between">

                        <div class="text-stone-500 dark:text-stone-400">

                            <span class="font-medium text-stone-600 dark:text-stone-300">
                                Payment:
                            </span>

                            Stripe

                            @if ($order->paid_at)
                                <span class="mx-1">
                                    •
                                </span>

                                Paid {{ $order->paid_at->format('M d, Y h:i A') }}
                            @endif

                        </div>


                        {{-- Currency --}}
                        <div class="text-stone-400">

                            Currency:
                            {{ strtoupper($order->currency ?? 'PHP') }}

                        </div>

                    </div>


                    {{-- ==================================================== --}}
                    {{-- ACTIONS                                                --}}
                    {{-- ==================================================== --}}

                    <div
                        class="mt-5 flex
                       justify-end
                       border-t border-stone-100
                       pt-4
                       dark:border-stone-800">

                        <x-primary-button :href="route('orders.show', $order)" wire:navigate
                            class="px-4 py-2.5
                           text-sm font-bold
                           normal-case
                           tracking-normal">

                            View Order

                        </x-primary-button>

                    </div>

                </div>

            </div>

        @empty

            {{-- ============================================================ --}}
            {{-- EMPTY STATE                                                   --}}
            {{-- ============================================================ --}}

            <div
                class="rounded-[14px]
               border border-stone-200
               bg-white
               px-6 py-12
               text-center
               dark:border-stone-800
               dark:bg-[#1A1A1A]">

                {{-- Empty Icon --}}
                <div
                    class="mx-auto flex h-12 w-12
                   items-center justify-center
                   rounded-full
                   bg-stone-100
                   dark:bg-stone-800">

                    <svg class="h-6 w-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 011.414.586L19 8.586A2 2 0 0119.586 10V19a2 2 0 01-2 2z" />

                    </svg>

                </div>


                {{-- Empty Text --}}
                <h2 class="mt-4 text-sm font-bold
                   text-stone-900
                   dark:text-white">

                    No orders yet

                </h2>

                <p class="mt-1 text-xs
                   text-stone-500
                   dark:text-stone-400">

                    Your completed purchases will appear here.

                </p>


                {{-- CTA Button --}}
                <x-primary-button :href="route('products.index')" wire:navigate
                    class="mt-5 px-4 py-2.5
                   text-sm font-bold
                   normal-case
                   tracking-normal">

                    Start Shopping

                </x-primary-button>

            </div>

        @endforelse
        ```

    </div>

    {{-- ==================================================================== --}}
    {{-- PAGINATION                                                           --}}
    {{-- ==================================================================== --}}

    @if ($orders->hasPages())
        ```
        <div class="mt-6">

            {{ $orders->links() }}

        </div>
    @endif

</div>
