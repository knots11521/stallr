<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ============================================================= --}}
    {{-- SUCCESS HEADER --}}
    {{-- ============================================================= --}}

    <div class="text-center mb-10">

        {{-- Success Icon --}}
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-stone-900">
            Order Confirmed!
        </h1>

        <p class="mt-2 text-sm text-stone-500">
            Thank you for your purchase.
        </p>

        <p class="mt-1 text-sm text-stone-500">
            Your order has been successfully placed.
        </p>

    </div>


    {{-- ============================================================= --}}
    {{-- ORDER SUMMARY --}}
    {{-- ============================================================= --}}

    <div class="mb-6 rounded-[14px] border border-stone-200 bg-white overflow-hidden">

        <div class="px-6 py-5 border-b border-stone-100">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>

                    <p class="text-xs uppercase tracking-wide text-stone-400">
                        Order Number
                    </p>

                    <p class="mt-1 text-lg font-bold text-stone-900">
                        {{ $order->order_number }}
                    </p>

                </div>


                <div class="text-left sm:text-right">

                    <p class="text-xs uppercase tracking-wide text-stone-400">
                        Payment
                    </p>

                    <span
                        class="inline-flex mt-1 items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Paid
                    </span>

                </div>

            </div>

        </div>


        {{-- Order Details --}}
        <div class="px-6 py-5">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div>

                    <p class="text-xs text-stone-400">
                        Order Date
                    </p>

                    <p class="mt-1 text-sm font-medium text-stone-800">
                        {{ $order->created_at->format('M d, Y h:i A') }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-stone-400">
                        Order Status
                    </p>

                    <p class="mt-1 text-sm font-medium text-stone-800 capitalize">
                        {{ $order->status }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-stone-400">
                        Payment Status
                    </p>

                    <p class="mt-1 text-sm font-medium text-green-600 capitalize">
                        {{ $order->payment_status }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- VENDOR ORDERS --}}
    {{-- ============================================================= --}}

    <div class="space-y-6">

        @foreach ($order->vendorOrders as $vendorOrder)
            <div class="rounded-[14px] border border-stone-200 bg-white overflow-hidden">

                {{-- Vendor Header --}}
                <div class="px-6 py-4 border-b border-stone-100 bg-stone-50">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-xs uppercase tracking-wide text-stone-400">
                                Store
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-stone-900">
                                {{ $vendorOrder->vendor?->store_name ?? 'Store' }}
                            </h2>

                        </div>


                        <div class="text-right">

                            <p class="text-xs text-stone-400">
                                Status
                            </p>

                            <p class="mt-1 text-xs font-semibold text-stone-700 capitalize">
                                {{ $vendorOrder->status }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Products --}}
                <div class="divide-y divide-stone-100">

                    @foreach ($vendorOrder->items as $item)
                        <div class="px-6 py-5">

                            <div class="flex items-center justify-between gap-5">

                                {{-- Product --}}
                                <div class="min-w-0">

                                    <h3 class="text-sm font-semibold text-stone-900">
                                        {{ $item->product_name }}
                                    </h3>

                                    <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1">

                                        <p class="text-xs text-stone-500">
                                            Quantity:
                                            {{ $item->quantity }}
                                        </p>

                                        <p class="text-xs text-stone-500">
                                            ₱{{ number_format($item->unit_price, 2) }}
                                            each
                                        </p>

                                    </div>

                                </div>


                                {{-- Item Total --}}
                                <div class="text-right flex-shrink-0">

                                    <p class="text-sm font-bold text-stone-900">
                                        ₱{{ number_format($item->subtotal, 2) }}
                                    </p>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>


                {{-- Vendor Total --}}
                <div class="px-6 py-4 border-t border-stone-100">

                    <div class="flex items-center justify-between">

                        <span class="text-sm font-medium text-stone-500">
                            Store Total
                        </span>

                        <span class="text-sm font-bold text-stone-900">
                            ₱{{ number_format($vendorOrder->total, 2) }}
                        </span>

                    </div>

                </div>

            </div>
        @endforeach

    </div>


    {{-- ============================================================= --}}
    {{-- ORDER TOTAL --}}
    {{-- ============================================================= --}}

    <div class="mt-6 rounded-[14px] border border-stone-200 bg-white">

        <div class="p-6 space-y-4">

            <div class="flex items-center justify-between">

                <span class="text-sm text-stone-500">
                    Subtotal
                </span>

                <span class="text-sm font-medium text-stone-800">
                    ₱{{ number_format($order->subtotal, 2) }}
                </span>

            </div>


            <div class="flex items-center justify-between">

                <span class="text-sm text-stone-500">
                    Shipping
                </span>

                <span class="text-sm font-medium text-stone-800">
                    Free
                </span>

            </div>


            <div class="border-t border-stone-100 pt-4">

                <div class="flex items-center justify-between">

                    <span class="text-base font-bold text-stone-900">
                        Total
                    </span>

                    <span class="text-2xl font-bold text-[#F1641E]">
                        ₱{{ number_format($order->total, 2) }}
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- ACTIONS --}}
    {{-- ============================================================= --}}

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">

        <x-primary-button :href="route('orders.index')"
            class="px-6 py-3 text-sm font-bold normal-case tracking-normal">
            View My Orders
        </x-primary-button>


        <x-secondary-button :href="route('products.index')"
            class="px-6 py-3 text-sm font-bold normal-case tracking-normal">
            Continue Shopping
        </x-secondary-button>

    </div>

</div>
