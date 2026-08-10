<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Access Forbidden // Atelier</title>

    <!-- Google Fonts: Editorial Serif + Clean Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Italiana&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Italiana', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            bg: '#FBF9F5',
                            card: '#FFFFFF',
                            text: '#222222',
                            muted: '#717171',
                            border: '#EAE6DF',
                            terra: '#C85A32',
                            'terra-soft': '#FDF4F0',
                            sage: '#2B4C3F',
                            'sage-soft': '#F0F4F2',
                        }
                    },
                    boxShadow: {
                        'soft-ui': '0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 4px 12px -2px rgba(0, 0, 0, 0.025)',
                        'soft-button': '0 4px 14px 0 rgba(43, 76, 63, 0.15)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FBF9F5;
        }

        .editorial-title {
            font-family: 'Italiana', serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-brand-bg text-brand-text antialiased min-h-screen flex items-center justify-center p-4 relative selection:bg-brand-sage-soft selection:text-brand-sage">

    <!-- Ambient Background Soft Glows -->
    <div
        class="fixed top-12 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-amber-100/40 rounded-full blur-[120px] pointer-events-none -z-10">
    </div>

    <!-- Main Container -->
    <div x-data="{ accessDenied: true }"
        class="min-h-[70vh] flex flex-col items-center justify-center relative py-12 w-full max-w-4xl">

        <!-- Background Decorator Overlay -->
        <div
            class="absolute inset-0 flex items-center justify-center pointer-events-none select-none opacity-5 z-0 overflow-hidden">
            <span class="text-[28vw] font-serif text-brand-terra">403</span>
        </div>

        <!-- Central Soft UI Card -->
        <div class="relative z-10 max-w-xl w-full bg-brand-card border border-brand-border p-8 md:p-12 shadow-soft-ui transition-all duration-300"
            style="border-radius: 10px;">

            <!-- Header Security Bar -->
            <div
                class="flex items-center justify-between border-b border-brand-border pb-5 mb-8 text-xs tracking-wider">
                <div class="flex items-center gap-2 text-brand-terra font-semibold uppercase">
                    <span class="w-2 h-2 bg-brand-terra rounded-full animate-pulse"></span>
                    Restricted Area
                </div>
                <div class="text-brand-muted font-medium">
                    ERR_403
                </div>
            </div>

            <!-- Soft Editorial Title -->
            <div class="space-y-4 mb-8 text-center md:text-left">
                <h1 class="editorial-title text-4xl md:text-5xl font-normal text-brand-text leading-tight">
                    Access <span class="italic text-brand-terra">Restricted</span>
                </h1>
                <p class="text-brand-muted text-sm leading-relaxed">
                    This collection studio requires higher authorization. You may need to log in with an elevated
                    account or request permission to view these curated designs.
                </p>
            </div>

            <!-- Soft Neo-Flat Info Box -->
            <div class="bg-brand-bg border border-brand-border p-4 mb-8 text-xs space-y-2 text-brand-muted"
                style="border-radius: 10px;">
                <div class="flex items-center gap-2 text-brand-text font-medium">
                    <svg class="w-4 h-4 text-brand-terra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>SECURITY DETAILED TRACE</span>
                </div>
                <div class="pl-6 space-y-1 font-mono text-[11px]">
                    <p>REQUESTED_PATH: <span class="text-brand-text" x-text="window.location.pathname"></span></p>
                    <p>PERMISSION: <span class="text-brand-terra font-semibold">GUEST_NOT_PERMITTED</span></p>
                </div>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Back to Shop Button -->
                <a href="/"
                    class="group inline-flex items-center justify-center px-6 py-3.5 bg-brand-sage text-white font-medium text-xs uppercase tracking-widest hover:bg-opacity-95 transition-all duration-200 shadow-soft-button"
                    style="border-radius: 10px;">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Return Home
                    </span>
                </a>

                <!-- Sign In Button -->
                <a href="/login"
                    class="inline-flex items-center justify-center px-6 py-3.5 bg-brand-bg border border-brand-border text-brand-text font-medium text-xs uppercase tracking-widest hover:border-brand-text transition-all duration-200"
                    style="border-radius: 10px;">
                    Account Sign In
                </a>
            </div>

        </div>

        <!-- Soft Interactive Request Override -->
        <div class="mt-8 z-10">
            <button @click="$dispatch('notify', 'Access request submitted to studio management.')"
                class="text-xs text-brand-muted hover:text-brand-terra tracking-wide transition-colors flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-brand-terra rounded-full"></span>
                Request Studio Access Clearance
            </button>
        </div>
    </div>

    <!-- Soft UI Toast Notification -->
    <div x-data="{ show: false, message: '' }"
        x-on:notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 4000)" x-show="show"
        x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed bottom-6 right-6 z-50 bg-white border border-brand-border text-brand-text px-5 py-4 shadow-soft-ui flex items-center gap-3"
        style="border-radius: 10px;">
        <div class="w-2 h-2 rounded-full bg-brand-sage"></div>
        <span x-text="message" class="text-xs font-medium tracking-wide"></span>
    </div>

</body>

</html>
