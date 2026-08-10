<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '404_WEAR // SYSTEM_GLITCH_FASHION' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind & Livewire Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Fira Code', monospace;
        }

        h1,
        h2,
        h3,
        .brand-font {
            font-family: 'Syne', sans-serif;
        }

        /* CRT Scanline Overlay Effect */
        .scanline-bg {
            background: linear-gradient(rgba(18, 16, 16, 0) 50%,
                    rgba(0, 0, 0, 0.35) 50%), linear-gradient(90deg,
                    rgba(255, 0, 0, 0.03),
                    rgba(0, 255, 0, 0.01),
                    rgba(0, 0, 255, 0.03));
            background-size: 100% 4px, 6px 100%;
        }

        /* Glitch Keyframes */
        @keyframes glitch-skew {
            0% {
                transform: skew(0deg);
            }

            20% {
                transform: skew(-2deg);
            }

            40% {
                transform: skew(1.5deg);
            }

            60% {
                transform: skew(-0.5deg);
            }

            80% {
                transform: skew(2deg);
            }

            100% {
                transform: skew(0deg);
            }
        }

        .animate-glitch {
            animation: glitch-skew 1s infinite linear alternate-reverse;
        }
    </style>
</head>

<body
    class="bg-neutral-950 text-neutral-100 antialiased selection:bg-teal-500 selection:text-black min-h-screen flex flex-col relative overflow-x-hidden scanline-bg">

    <!-- Ambient Neon Background Blur -->
    <div class="fixed -top-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-[120px] pointer-events-none z-0">
    </div>
    <div class="fixed -bottom-40 -right-40 w-96 h-96 bg-rose-500/10 rounded-full blur-[120px] pointer-events-none z-0">
    </div>

    <!-- Navigation Header -->
    <header x-data="{ mobileMenuOpen: false, scrolled: false }" x-on:scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-neutral-950/80 backdrop-blur-md border-teal-500/40' : 'bg-transparent border-neutral-800'"
        class="sticky top-0 z-50 border-b transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-3 h-3 bg-teal-400 animate-ping rounded-none"></div>
                <span
                    class="brand-font text-2xl font-black tracking-tighter uppercase text-neutral-100 group-hover:text-teal-400 transition-colors animate-glitch">
                    [ERR<span class="text-teal-400">//</span>404]
                </span>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-xs tracking-widest font-bold uppercase">
                <a href="#"
                    class="text-neutral-300 hover:text-teal-400 transition-colors py-1 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-teal-400 hover:after:w-full after:transition-all">
                    // NEW_DROP
                </a>
                <a href="#"
                    class="text-neutral-300 hover:text-teal-400 transition-colors py-1 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-teal-400 hover:after:w-full after:transition-all">
                    // APPAREL
                </a>
                <a href="#"
                    class="text-neutral-300 hover:text-teal-400 transition-colors py-1 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[2px] after:bg-teal-400 hover:after:w-full after:transition-all">
                    // ACCESSORIES
                </a>
                <a href="#"
                    class="text-rose-500 hover:text-rose-400 transition-colors py-1 font-extrabold animate-pulse">
                    [SYSTEM_CLEARANCE]
                </a>
            </nav>

            <!-- Actions / Cart -->
            <div class="flex items-center gap-4">
                <!-- Search Button -->
                <button class="p-2 text-neutral-400 hover:text-teal-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 0 0 114 0z" />
                    </svg>
                </button>

                <!-- Cart Button with Alpine Badge Animation -->
                <a href="#"
                    class="relative inline-flex items-center gap-2 px-4 py-2 border border-teal-500/50 bg-teal-950/20 text-teal-400 text-xs tracking-wider uppercase hover:bg-teal-400 hover:text-black transition-all duration-200"
                    style="border-radius: 5px;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>CART</span>
                    <span class="bg-teal-400 text-black px-1.5 py-0.5 text-[10px] font-bold"
                        style="border-radius: 2px;">03</span>
                </a>

                <!-- Mobile Menu Trigger -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2 text-neutral-400 hover:text-teal-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu with Alpine Slide Transition -->
        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="md:hidden bg-neutral-900 border-b border-teal-500/30 px-4 pt-4 pb-6 space-y-3">
            <a href="#"
                class="block text-sm font-bold uppercase text-neutral-200 hover:text-teal-400 py-2 border-b border-neutral-800">//
                NEW_DROP</a>
            <a href="#"
                class="block text-sm font-bold uppercase text-neutral-200 hover:text-teal-400 py-2 border-b border-neutral-800">//
                APPAREL</a>
            <a href="#"
                class="block text-sm font-bold uppercase text-neutral-200 hover:text-teal-400 py-2 border-b border-neutral-800">//
                ACCESSORIES</a>
            <a href="#" class="block text-sm font-bold uppercase text-rose-500 py-2">[SYSTEM_CLEARANCE]</a>
        </div>
    </header>

    <!-- Main Content Container with Livewire Smooth View Transitions -->
    <main class="flex-grow relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Error/Glitch Ticker Bar -->
    <div class="border-y border-neutral-800 bg-neutral-900/50 py-2 overflow-hidden whitespace-nowrap z-10">
        <div class="inline-block animate-marquee text-[11px] tracking-widest text-neutral-400 uppercase">
            <span class="text-teal-400">CRITICAL_WARNING:</span> HIGH DEMAND IN SECTOR 07 <span
                class="mx-4 text-neutral-600">///</span>
            WORLDWIDE SHIPPING AVAILABLE <span class="mx-4 text-neutral-600">///</span>
            <span class="text-rose-500">SYSTEM OVERRIDE ACTIVE</span> <span class="mx-4 text-neutral-600">///</span>
            USE CODE <span class="text-teal-400">"GLITCH10"</span> FOR 10% OFF
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-neutral-950 border-t border-neutral-800 text-neutral-500 text-xs relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <span class="brand-font text-xl font-extrabold text-neutral-200">[ERR//404]</span>
                <p class="text-neutral-400 leading-relaxed">System-generated cyber fashion and glitch aesthetic
                    streetwear designed for digital nomads.</p>
            </div>
            <div>
                <h4 class="text-teal-400 font-bold uppercase mb-4 tracking-wider">// SYSTEM_LINKS</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">DIRECTORY</a></li>
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">TRACK_PARCEL</a></li>
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">BUG_BOUNTY</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-teal-400 font-bold uppercase mb-4 tracking-wider">// LEGAL_LOGS</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">TERMS_OF_OVERRIDE</a></li>
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">PRIVACY_POLICY</a></li>
                    <li><a href="#" class="hover:text-neutral-200 transition-colors">RETURN_PROTOCOL</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-teal-400 font-bold uppercase mb-4 tracking-wider">// SUBSCRIBE_TO_TERMINAL</h4>
                <form class="space-y-2" @submit.prevent>
                    <input type="email" placeholder="ENTER_EMAIL..."
                        class="w-full bg-neutral-900 border border-neutral-800 px-3 py-2 text-neutral-200 focus:outline-none focus:border-teal-400 transition-colors placeholder:text-neutral-600"
                        style="border-radius: 5px;">
                    <button
                        class="w-full bg-teal-500 hover:bg-teal-400 text-black font-bold py-2 uppercase transition-all"
                        style="border-radius: 5px;">
                        EXECUTE
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-neutral-900 py-4 text-center text-[10px] text-neutral-600">
            &copy; {{ date('Y') }} ERR_FASHION_CORP. ALL RIGHTS RESERVED. SYSTEM STATUS: OPERATIONAL.
        </div>
    </footer>

    <!-- Global Toast Notification Component (Alpine + Livewire event driven) -->
    <div x-data="{ show: false, message: '' }"
        x-on:notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 4000)" x-show="show"
        x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-5 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-5 scale-95"
        class="fixed bottom-6 right-6 z-50 bg-neutral-900 border-l-4 border-teal-400 text-neutral-100 p-4 shadow-2xl flex items-center gap-3"
        style="border-radius: 5px;">
        <span class="text-teal-400 font-bold text-lg">[!]</span>
        <span x-text="message" class="text-xs uppercase font-mono"></span>
    </div>

    @livewireScripts
</body>

</html>
