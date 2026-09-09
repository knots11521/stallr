<div>

    {{-- ==================================================================== --}}
    {{-- WELCOME HEADER                                                      --}}
    {{-- ==================================================================== --}}

    <div class="mb-8 flex flex-col gap-1">

        <h1 class="text-2xl font-bold tracking-tight text-stone-900 dark:text-white">
            Welcome back, {{ $user->name }}!
        </h1>

        <p class="text-sm text-stone-500 dark:text-stone-400">
            Here's a quick overview of your account activity and orders.
        </p>

    </div>

    {{-- ==================================================================== --}}
    {{-- USER STATS OVERVIEW                                                   --}}
    {{-- ==================================================================== --}}

    <div
        class="grid grid-cols-1
               gap-4
               sm:grid-cols-2
               lg:grid-cols-4">

        {{-- --- Total Orders --- --}}

        <div
            class="rounded-[14px]
                   border border-stone-200
                   bg-white
                   p-5
                   dark:border-stone-800
                   dark:bg-[#1A1A1A]">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-[#F1641E]/10
                           text-[#F1641E]
                           dark:bg-[#F1641E]/20">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 2h9l3 3v17H6V2zM9 9h6M9 13h6M9 17h4" />

                    </svg>

                </div>

                <div class="min-w-0 flex-1">

                    <p
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                        Total Orders

                    </p>

                    <p
                        class="mt-1 text-2xl
                               font-extrabold
                               text-stone-900
                               dark:text-white">

                        {{ $totalOrders }}

                    </p>

                </div>

            </div>

        </div>

        {{-- --- Total Spent --- --}}

        <div
            class="rounded-[14px]
                   border border-stone-200
                   bg-white
                   p-5
                   dark:border-stone-800
                   dark:bg-[#1A1A1A]">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-emerald-50
                           text-emerald-600
                           dark:bg-emerald-950/30
                           dark:text-emerald-400">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-2.8 0-5 2.2-5 5 0 .8.2 1.6.5 2.3 1.4-1.6 2.5-3.7 2.5-6.3 0-.5.1-.9.1-1.4A7.5 7.5 0 0012 2c.8 0 1.6.1 2.3.4C13.1 3.3 11 5.5 11 8c0 .3.1.6.1.8" />

                    </svg>

                </div>

                <div class="min-w-0 flex-1">

                    <p
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                        Total Spent

                    </p>

                    <p
                        class="mt-1 text-2xl
                               font-extrabold
                               text-stone-900
                               dark:text-white">

                        ₱{{ number_format((float) $totalSpent, 2) }}

                    </p>

                </div>

            </div>

        </div>

        {{-- --- Cart Items --- --}}

        <div
            class="rounded-[14px]
                   border border-stone-200
                   bg-white
                   p-5
                   dark:border-stone-800
                   dark:bg-[#1A1A1A]">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-[#F1641E]/10
                           text-[#F1641E]
                           dark:bg-[#F1641E]/20">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l2.4 12.2a2 2 0 002 1.6h7.8a2 2 0 002-1.6L21 7H6M9 21h.01M18 21h.01" />

                    </svg>

                </div>

                <div class="min-w-0 flex-1">

                    <p
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                        Cart Items

                    </p>

                    <p
                        class="mt-1 text-2xl
                               font-extrabold
                               text-stone-900
                               dark:text-white">

                        {{ $cartCount }}

                    </p>

                </div>

            </div>

        </div>

        {{-- --- Member Since --- --}}

        <div
            class="rounded-[14px]
                   border border-stone-200
                   bg-white
                   p-5
                   dark:border-stone-800
                   dark:bg-[#1A1A1A]">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-stone-100
                           text-stone-600
                           dark:bg-stone-800
                           dark:text-stone-300">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 7.5h1.5m-1.5 3h1.5m-1.5 3h1.5m-1.5 3h1.5M12 6c-3.8 0-6.5 2.7-6.5 6s2.7 6 6.5 6 6.5-2.7 6.5-6-2.7-6-6.5-6" />

                    </svg>

                </div>

                <div class="min-w-0 flex-1">

                    <p
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wider
                               text-stone-400">

                        Member Since

                    </p>

                    <p
                        class="mt-1 text-sm
                               font-semibold
                               text-stone-900
                               dark:text-white">

                        {{ $user->created_at->format('M d, Y') }}

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- ==================================================================== --}}
    {{-- VENDOR STORE STATS                                                  --}}
    {{-- ==================================================================== --}}

    @if ($vendor && $vendorStats)

        <div class="mt-6">

            <h2
                class="mb-4 text-sm font-semibold
                       uppercase
                       tracking-wider
                       text-stone-500
                       dark:text-stone-400">

                {{ $vendor->store_name }} Store Overview

            </h2>

            <div
                class="grid grid-cols-1
                       gap-4
                       sm:grid-cols-2
                       lg:grid-cols-4">

                {{-- --- Total Products --- --}}

                <div
                    class="rounded-[14px]
                           border border-stone-200
                           bg-white
                           p-5
                           dark:border-stone-800
                           dark:bg-[#1A1A1A]">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10
                                   shrink-0 items-center
                                   justify-center
                                   rounded-[10px]
                                   bg-[#F1641E]/10
                                   text-[#F1641E]
                                   dark:bg-[#F1641E]/20">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />

                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-[10px]
                                       font-semibold
                                       uppercase
                                       tracking-wider
                                       text-stone-400">

                                Total Products

                            </p>

                            <p
                                class="mt-1 text-2xl
                                       font-extrabold
                                       text-stone-900
                                       dark:text-white">

                                {{ $vendorStats['total_products'] }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- --- Pending Products --- --}}

                <div
                    class="rounded-[14px]
                           border border-stone-200
                           bg-white
                           p-5
                           dark:border-stone-800
                           dark:bg-[#1A1A1A]">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10
                                   shrink-0 items-center
                                   justify-center
                                   rounded-[10px]
                                   bg-amber-50
                                   text-amber-600
                                   dark:bg-amber-950/30
                                   dark:text-amber-400">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3" />

                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-[10px]
                                       font-semibold
                                       uppercase
                                       tracking-wider
                                       text-stone-400">

                                Pending Products

                            </p>

                            <p
                                class="mt-1 text-2xl
                                       font-extrabold
                                       text-stone-900
                                       dark:text-white">

                                {{ $vendorStats['pending_products'] }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- --- Approved Products --- --}}

                <div
                    class="rounded-[14px]
                           border border-stone-200
                           bg-white
                           p-5
                           dark:border-stone-800
                           dark:bg-[#1A1A1A]">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10
                                   shrink-0 items-center
                                   justify-center
                                   rounded-[10px]
                                   bg-emerald-50
                                   text-emerald-600
                                   dark:bg-emerald-950/30
                                   dark:text-emerald-400">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-[10px]
                                       font-semibold
                                       uppercase
                                       tracking-wider
                                       text-stone-400">

                                Approved Products

                            </p>

                            <p
                                class="mt-1 text-2xl
                                       font-extrabold
                                       text-stone-900
                                       dark:text-white">

                                {{ $vendorStats['approved_products'] }}

                            </p>

                        </div>

                    </div>

                </div>

                {{-- --- Low Stock Products --- --}}

                <div
                    class="rounded-[14px]
                           border border-stone-200
                           bg-white
                           p-5
                           dark:border-stone-800
                           dark:bg-[#1A1A1A]">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10
                                   shrink-0 items-center
                                   justify-center
                                   rounded-[10px]
                                   bg-red-50
                                   text-red-600
                                   dark:bg-red-950/30
                                   dark:text-red-400">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 10.5A7.5 7.5 0 0112 19.5a7.5 7.5 0 01-5-12" />

                            </svg>

                        </div>

                        <div class="min-w-0 flex-1">

                            <p
                                class="text-[10px]
                                       font-semibold
                                       uppercase
                                       tracking-wider
                                       text-stone-400">

                                Low Stock

                            </p>

                            <p
                                class="mt-1 text-2xl
                                       font-extrabold
                                       text-stone-900
                                       dark:text-white">

                                {{ $vendorStats['low_stock_products'] }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif

    {{-- ==================================================================== --}}
    {{-- RECENT ORDERS                                                         --}}
    {{-- ==================================================================== --}}

    <div class="mt-6">

        <div
            class="mb-4 flex
                   items-center
                   justify-between">

            <h2
                class="text-lg
                       font-bold
                       text-stone-900
                       dark:text-white">

                Recent Orders

            </h2>

            @if ($recentOrders->isNotEmpty())
                <a href="{{ route('orders.index') }}"
                   wire:navigate
                   class="text-xs font-semibold
                          text-[#F1641E]
                          hover:underline">

                    View all orders

                </a>
            @endif

        </div>

        @forelse ($recentOrders as $order)

            <div
                class="mb-3
                       rounded-[14px]
                       border border-stone-200
                       bg-white
                       p-4
                       dark:border-stone-800
                       dark:bg-[#1A1A1A]">

                <div
                    class="flex flex-col
                           gap-3
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
                                    class="h-1.5 w-1.5
                                           rounded-full
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

                                <span
                                    class="h-1.5 w-1.5
                                           rounded-full
                                           bg-red-500">

                                </span>

                                Payment Failed

                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-1.5
                                       rounded-full
                                       bg-amber-50
                                       px-2.5 py-1
                                       text-xs font-semibold
                                       text-amber-700
                                       dark:bg-amber-950/30
                                       dark:text-amber-400">

                                <span
                                    class="h-1.5 w-1.5
                                           rounded-full
                                           bg-amber-500">

                                </span>

                                Payment Pending

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

                {{-- Order Summary --}}

                <div
                    class="mt-3
                           flex
                           items-center
                           justify-between
                           gap-3">

                    <div
                        class="text-xs
                               text-stone-500
                               dark:text-stone-400">

                        {{ $order->vendorOrders->sum(fn($vendorOrder) => $vendorOrder->items->sum('quantity')) }} items

                    </div>

                    <div class="flex items-center gap-4">

                        <div class="text-right">

                            <p
                                class="text-xs
                                       text-stone-400
                                       dark:text-stone-500">

                                Total

                            </p>

                            <p
                                class="text-lg font-extrabold
                                       text-[#F1641E]">

                                ₱{{ number_format((float) $order->total, 2) }}

                            </p>

                        </div>

                        <x-primary-button :href="route('orders.show', $order)"
                            wire:navigate
                            class="px-3 py-1.5
                                   text-xs font-bold
                                   normal-case
                                   tracking-normal">

                            View

                        </x-primary-button>

                    </div>

                </div>

            </div>

        @empty

            {{-- Empty State --}}

            <div
                class="rounded-[14px]
                       border border-stone-200
                       bg-white
                       px-6 py-10
                       text-center
                       dark:border-stone-800
                       dark:bg-[#1A1A1A]">

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

                <h3
                    class="mt-4 text-sm
                           font-bold
                           text-stone-900
                           dark:text-white">

                    No orders yet

                </h3>

                <p
                    class="mt-1 text-xs
                           text-stone-500
                           dark:text-stone-400">

                    Your completed purchases will appear here.

                </p>

                <x-primary-button :href="route('products.index')"
                    wire:navigate
                    class="mt-4 px-4 py-2
                           text-sm font-bold
                           normal-case
                           tracking-normal">

                    Start Shopping

                </x-primary-button>

            </div>

        @endforelse

    </div>

    {{-- ==================================================================== --}}
    {{-- QUICK ACTIONS                                                         --}}
    {{-- ==================================================================== --}}

    <div class="mt-6">

        <h2
            class="mb-4 text-lg
                   font-bold
                   text-stone-900
                   dark:text-white">

            Quick Actions

        </h2>

        <div
            class="grid grid-cols-1
                   gap-3
                   sm:grid-cols-2
                   lg:grid-cols-4">

            <a href="{{ route('products.index') }}"
               wire:navigate
               class="flex items-center gap-3
                      rounded-[14px]
                      border border-stone-200
                      bg-white
                      px-4 py-3
                      text-left
                      transition
                      hover:bg-stone-50
                      dark:border-stone-800
                      dark:bg-[#1A1A1A]
                      dark:hover:bg-stone-800/50">

                <div
                    class="flex h-9 w-9
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-[#F1641E]/10
                           text-[#F1641E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />

                    </svg>

                </div>

                <div>

                    <p
                        class="text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                        Browse Products

                    </p>

                    <p
                        class="text-xs
                               text-stone-500
                               dark:text-stone-400">

                        Discover new products

                    </p>

                </div>

            </a>

            <a href="{{ route('cart') }}"
               wire:navigate
               class="flex items-center gap-3
                      rounded-[14px]
                      border border-stone-200
                      bg-white
                      px-4 py-3
                      text-left
                      transition
                      hover:bg-stone-50
                      dark:border-stone-800
                      dark:bg-[#1A1A1A]
                      dark:hover:bg-stone-800/50">

                <div
                    class="flex h-9 w-9
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-[#F1641E]/10
                           text-[#F1641E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l2.4 12.2a2 2 0 002 1.6h7.8a2 2 0 002-1.6L21 7H6M9 21h.01M18 21h.01" />

                    </svg>

                </div>

                <div>

                    <p
                        class="text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                        View Cart

                    </p>

                    <p
                        class="text-xs
                               text-stone-500
                               dark:text-stone-400">

                        {{ $cartCount }} item{{ $cartCount !== 1 ? 's' : '' }} in cart

                    </p>

                </div>

            </a>

            <a href="{{ route('orders.index') }}"
               wire:navigate
               class="flex items-center gap-3
                      rounded-[14px]
                      border border-stone-200
                      bg-white
                      px-4 py-3
                      text-left
                      transition
                      hover:bg-stone-50
                      dark:border-stone-800
                      dark:bg-[#1A1A1A]
                      dark:hover:bg-stone-800/50">

                <div
                    class="flex h-9 w-9
                           shrink-0 items-center
                           justify-center
                           rounded-[10px]
                           bg-[#F1641E]/10
                           text-[#F1641E]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 2h9l3 3v17H6V2zM9 9h6M9 13h6M9 17h4" />

                    </svg>

                </div>

                <div>

                    <p
                        class="text-sm font-semibold
                               text-stone-900
                               dark:text-white">

                        Order History

                    </p>

                    <p
                        class="text-xs
                               text-stone-500
                               dark:text-stone-400">

                        Track your orders

                    </p>

                </div>

            </a>

            @if ($vendor)

                <a href="{{ url('/vendor') }}"
                   wire:navigate
                   class="flex items-center gap-3
                          rounded-[14px]
                          border border-stone-200
                          bg-white
                          px-4 py-3
                          text-left
                          transition
                          hover:bg-stone-50
                          dark:border-stone-800
                          dark:bg-[#1A1A1A]
                          dark:hover:bg-stone-800/50">

                    <div
                        class="flex h-9 w-9
                               shrink-0 items-center
                               justify-center
                               rounded-[10px]
                               bg-[#F1641E]/10
                               text-[#F1641E]">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7h18M3 12h18M3 17h18" />

                        </svg>

                    </div>

                    <div>

                        <p
                            class="text-sm font-semibold
                                   text-stone-900
                                   dark:text-white">

                            Manage Store

                        </p>

                        <p
                            class="text-xs
                                   text-stone-500
                                   dark:text-stone-400">

                            {{ $vendor->store_name }}

                        </p>

                    </div>

                </a>

            @endif

        </div>

    </div>

</div>
