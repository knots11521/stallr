<title>
    {{ $paymentSuccessful ? 'Payment Successful' : 'Payment Processing' }}
</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        darkMode: 'class'
    }
</script>

<main class="min-h-screen flex items-center justify-center px-4 py-12">

    <div
        class="w-full max-w-lg
               bg-white dark:bg-[#1A1A1A]
               border border-stone-200 dark:border-stone-800
               rounded-[16px]
               p-6 sm:p-8
               text-center
               shadow-sm dark:shadow-none">

        @if ($paymentSuccessful)
            <!-- Success Icon -->
            <div
                class="mx-auto
                       w-16 h-16
                       rounded-full
                       bg-emerald-50 dark:bg-emerald-950/30
                       border border-emerald-100 dark:border-emerald-900/40
                       flex items-center justify-center
                       text-emerald-500">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75" />

                    <circle cx="12" cy="12" r="9" />

                </svg>

            </div>


            <!-- Heading -->
            <h1
                class="mt-6
                       text-2xl sm:text-3xl
                       font-extrabold
                       tracking-tight
                       text-stone-900
                       dark:text-white">

                Payment Successful!

            </h1>


            <!-- Description -->
            <p
                class="max-w-sm mx-auto
                       mt-3
                       text-sm
                       leading-6
                       text-stone-500
                       dark:text-stone-400">

                Thank you for your order. Your payment has been
                successfully confirmed.

            </p>


            <!-- Payment Status -->
            <div
                class="mt-6
                       flex items-center justify-center gap-2
                       rounded-[10px]
                       bg-stone-50 dark:bg-stone-900/60
                       border border-stone-200 dark:border-stone-800
                       px-4 py-3">

                <span class="w-2 h-2
                           rounded-full
                           bg-emerald-500">
                </span>

                <span
                    class="text-xs
                           font-semibold
                           text-stone-600
                           dark:text-stone-300">

                    Payment confirmed

                </span>

            </div>


            <!-- Payment ID -->
            <div
                class="mt-3
                       rounded-[10px]
                       bg-stone-50 dark:bg-stone-900/40
                       border border-stone-200 dark:border-stone-800
                       px-4 py-3">

                <p
                    class="text-[10px]
                           uppercase
                           tracking-wider
                           font-bold
                           text-stone-400">

                    Payment Reference

                </p>

                <p
                    class="mt-1
                           text-xs
                           font-mono
                           break-all
                           text-stone-600
                           dark:text-stone-300">

                    {{ $paymentIntent->id }}

                </p>

            </div>


            <!-- Actions -->
            <div class="mt-6 space-y-2">

                <!-- View Orders -->
                <a href="{{ isset($order) ? route('orders.show', $order) : route('orders.index') }}"
                    class="w-full
                           inline-flex
                           items-center
                           justify-center
                           gap-2
                           rounded-[10px]
                           bg-[#F1641E]
                           hover:bg-[#d95716]
                           active:scale-[0.98]
                           text-white
                           font-bold
                           text-sm
                           px-5 py-3
                           transition">

                    <!-- Clipboard -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5h6m-7 4h8m-8 4h5m-7 7h12a2 2 0 002-2V6a2 2 0 00-2-2h-1.5a2 2 0 01-2-2h-3a2 2 0 01-2 2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                    </svg>

                    View My Orders

                </a>


                <!-- Continue Shopping -->
                <a href="{{ route('products.index') }}" wire:navigate
                    class="w-full
                           inline-flex
                           items-center
                           justify-center
                           gap-2
                           rounded-[10px]
                           border border-stone-200
                           dark:border-stone-700
                           bg-white dark:bg-transparent
                           hover:bg-stone-50
                           dark:hover:bg-stone-800
                           text-stone-700
                           dark:text-stone-300
                           font-semibold
                           text-sm
                           px-5 py-3
                           transition">

                    <!-- Shopping Bag -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l1 12H5L6 8z" />

                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8V6a3 3 0 0 1 6 0v2" />

                    </svg>

                    Continue Shopping

                </a>

            </div>


            <!-- Confirmation -->
            <p
                class="mt-5
                       text-[11px]
                       text-stone-400
                       dark:text-stone-500">

                Your payment has been confirmed.
                Your order is being processed.

            </p>
        @else
            <!-- Processing Icon -->
            <div
                class="mx-auto
                       w-16 h-16
                       rounded-full
                       bg-amber-50 dark:bg-amber-950/30
                       border border-amber-100 dark:border-amber-900/40
                       flex items-center justify-center
                       text-amber-500">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 animate-spin" fill="none" viewBox="0 0 24 24">

                    <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor"
                        stroke-width="2">
                    </circle>

                    <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 019 9h-2a7 7 0 00-7-7V3z">
                    </path>

                </svg>

            </div>


            <h1
                class="mt-6
                       text-2xl sm:text-3xl
                       font-extrabold
                       tracking-tight
                       text-stone-900
                       dark:text-white">

                Payment Processing

            </h1>


            <p
                class="max-w-sm mx-auto
                       mt-3
                       text-sm
                       leading-6
                       text-stone-500
                       dark:text-stone-400">

                Your payment has not been confirmed yet.
                Please wait while we verify the transaction.

            </p>


            <div
                class="mt-6
                       rounded-[10px]
                       bg-amber-50 dark:bg-amber-950/20
                       border border-amber-100 dark:border-amber-900/40
                       px-4 py-3">

                <p
                    class="text-xs
                           font-semibold
                           text-amber-700
                           dark:text-amber-400">

                    Payment status:

                    {{ $paymentIntent->status }}

                </p>

            </div>


            <div class="mt-6">

                <a href="{{ route('cart') }}" wire:navigate
                    class="w-full
                           inline-flex
                           items-center
                           justify-center
                           rounded-[10px]
                           border border-stone-200
                           dark:border-stone-700
                           bg-white dark:bg-transparent
                           hover:bg-stone-50
                           dark:hover:bg-stone-800
                           text-stone-700
                           dark:text-stone-300
                           font-semibold
                           text-sm
                           px-5 py-3
                           transition">

                    Return to Cart

                </a>

            </div>
        @endif

    </div>

</main>
