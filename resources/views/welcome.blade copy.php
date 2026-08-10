<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stallR — Curated Fashion & Homemade Drip</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts (Plus Jakarta Sans & Instrument Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    borderRadius: {
                        'none': '0px',
                        'sm': '5px',
                        'DEFAULT': '5px',
                        'md': '5px',
                        'lg': '5px',
                        'xl': '5px',
                        '2xl': '5px',
                        '3xl': '5px',
                        'full': '5px', // Override full to strictly enforce 5px everywhere
                    },
                    colors: {
                        brand: {
                            orange: '#F15A24', // Etsy-inspired vibrant orange
                            cream: '#FAF7F2', // Soft background tint
                            dark: '#18181B', // Deep Charcoal
                            lavender: '#E8E0FF', // Trendy accent
                            sage: '#E2EBD8', // Soft Gen-Z pastel
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-brand-cream text-brand-dark font-sans antialiased selection:bg-brand-orange selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-brand-dark text-brand-cream px-4 py-2 text-center text-xs font-semibold tracking-wider uppercase">
        ⚡ Drop 004 is Live! Upcycled streetwear, hand-knit fits & rare thrift finds.
    </div>

    <!-- Navigation Header -->
    <nav class="sticky top-0 z-50 bg-brand-cream/80 backdrop-blur-md border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-1.5 group">
                <span
                    class="text-3xl font-extrabold tracking-tight font-sans group-hover:text-brand-orange transition-colors">
                    stall<span class="text-brand-orange">R</span>
                </span>
                <span class="inline-block w-2 h-2 rounded-[5px] bg-brand-orange animate-ping"></span>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-lg relative">
                <input type="text" placeholder="Search hand-made drip, vintage Y2K, crochet..."
                    class="w-full bg-white border border-stone-300 rounded-[5px] py-2.5 pl-5 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent shadow-sm placeholder:text-stone-400">
                <button
                    class="absolute right-1.5 top-1.5 bottom-1.5 bg-brand-orange hover:bg-orange-600 text-white px-4 rounded-[5px] flex items-center justify-center transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 text-sm font-semibold">
                <a href="#" class="hidden sm:inline-block hover:text-brand-orange transition">Start a Stall</a>
                <a href="#" class="hidden sm:inline-block hover:text-brand-orange transition">Sign In</a>

                <!-- Bag / Cart -->
                <button
                    class="relative p-2.5 bg-white border border-stone-200 rounded-[5px] hover:border-brand-orange transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span
                        class="absolute -top-1.5 -right-1.5 bg-brand-orange text-white text-[10px] font-extrabold w-5 h-5 rounded-[5px] flex items-center justify-center border border-brand-cream">3</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <!-- Hero Left Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-[5px] bg-brand-lavender text-stone-900 text-xs font-bold uppercase tracking-wider">
                        <span>✨ Not your boring mall brand</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.08]">
                        Where independent creators drop <span
                            class="font-serif italic font-normal text-brand-orange">iconic</span> style.
                    </h1>

                    <p class="text-lg text-stone-600 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        The marketplace for Gen-Z designers, thrift curators, and craft makers. Buy one-of-a-kind fits
                        or open your own digital stall in minutes.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#explore"
                            class="w-full sm:w-auto px-8 py-4 bg-brand-orange hover:bg-orange-600 text-white font-bold rounded-[5px] shadow-lg shadow-brand-orange/25 transition transform hover:-translate-y-0.5 text-center">
                            Explore Drops
                        </a>
                        <a href="#sell"
                            class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-stone-50 text-brand-dark font-bold rounded-[5px] border border-stone-300 shadow-sm transition text-center">
                            Open Your Stall
                        </a>
                    </div>

                    <!-- Micro Social Proof -->
                    <div
                        class="pt-6 flex items-center justify-center lg:justify-start gap-6 text-stone-500 text-sm font-medium">
                        <div class="flex -space-x-1.5">
                            <img class="inline-block h-8 w-8 rounded-[5px] ring-2 ring-brand-cream object-cover"
                                src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80"
                                alt="User Avatar">
                            <img class="inline-block h-8 w-8 rounded-[5px] ring-2 ring-brand-cream object-cover"
                                src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=120&q=80"
                                alt="User Avatar">
                            <img class="inline-block h-8 w-8 rounded-[5px] ring-2 ring-brand-cream object-cover"
                                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80"
                                alt="User Avatar">
                        </div>
                        <span>Join <strong>12,000+</strong> indie creators & buyers</span>
                    </div>
                </div>

                <!-- Hero Right Grid (Visual Showcases) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">

                        <!-- Main Card -->
                        <div
                            class="bg-white p-4 rounded-[5px] border border-stone-200 shadow-xl rotate-1 hover:rotate-0 transition duration-300">
                            <div class="relative aspect-[4/5] rounded-[5px] overflow-hidden bg-stone-100">
                                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80"
                                    alt="Fashion Fit" class="object-cover w-full h-full">
                                <span
                                    class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-[5px] text-xs font-bold text-brand-dark shadow-sm">
                                    ★ 4.9 Seller
                                </span>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-brand-dark">Patchwork Denim Jacket</h3>
                                    <p class="text-xs text-stone-500 font-medium">Stall: <span
                                            class="underline text-stone-800">@StudioKiki</span></p>
                                </div>
                                <span class="text-xl font-extrabold text-brand-orange">$110</span>
                            </div>
                        </div>

                        <!-- Badge Overlay -->
                        <div
                            class="absolute -bottom-6 -left-6 bg-brand-sage text-stone-900 p-4 rounded-[5px] border border-stone-300/60 shadow-lg hidden sm:block -rotate-3">
                            <p class="text-xs font-bold uppercase tracking-wider text-stone-600">Daily Highlight</p>
                            <p class="text-sm font-extrabold">100% Upcycled Materials</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Trending Categories -->
    <section class="py-12 border-y border-stone-200 bg-white/50 dark:border-stone-800 dark:bg-[#121212]/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-stone-900 dark:text-white">
                        Explore Categories
                    </h2>

                    <p class="text-sm text-stone-500 dark:text-stone-400 font-medium">
                        Curated aesthetic feeds updated live
                    </p>
                </div>

                <a href="{{ route('products.index') }}" wire:navigate
                    class="text-sm font-bold text-[#F1641E] hover:underline">
                    View All →
                </a>

            </div>

            <!-- Categories -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">

                @forelse ($categories as $category)
                    @php
                        $icon = match ($category->slug) {
                            'clothing', 'apparel', 'fashion' => 'solar:t-shirt-linear',

                            'shoes', 'footwear' => 'solar:running-round-linear',

                            'bags', 'handbags', 'accessories' => 'solar:bag-3-linear',

                            'jewelry', 'jewellery' => 'solar:gem-linear',

                            'electronics', 'gadgets' => 'solar:smartphone-linear',

                            'home', 'home-decor', 'furniture' => 'solar:home-2-linear',

                            'beauty', 'cosmetics', 'skincare' => 'solar:cosmetic-linear',

                            'food', 'groceries' => 'solar:chef-hat-linear',

                            'books', 'book' => 'solar:book-2-linear',

                            'art', 'art-prints' => 'solar:palette-linear',

                            'toys', 'games' => 'solar:gamepad-linear',

                            'sports', 'fitness' => 'solar:football-linear',

                            'pets', 'pet-supplies' => 'solar:bone-linear',

                            default => 'solar:shop-linear',
                        };
                    @endphp

                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" wire:navigate
                        class="group p-4 rounded-[5px]
                   bg-white dark:bg-[#1A1A1A]
                   border border-stone-200 dark:border-stone-800
                   text-center
                   hover:border-[#F1641E]
                   hover:shadow-md
                   transition">

                        <!-- Category Icon -->
                        <div
                            class="w-12 h-12 mx-auto mb-3
                       rounded-[5px]
                       bg-orange-100 dark:bg-orange-950/30
                       flex items-center justify-center
                       text-[#F1641E]
                       group-hover:scale-105
                       transition">

                            <iconify-icon icon="{{ $icon }}" width="26" height="26">
                            </iconify-icon>

                        </div>

                        <!-- Category Name -->
                        <span
                            class="text-xs font-bold tracking-tight
                       block
                       text-stone-900 dark:text-white
                       group-hover:text-[#F1641E]
                       transition-colors">

                            {{ $category->name }}

                        </span>

                    </a>

                @empty

                    <div class="col-span-full text-center py-8 text-sm text-stone-500">
                        No categories available.
                    </div>
                @endforelse

            </div>

        </div>
    </section>

    <!-- Product Feed Section -->
    <section id="explore" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-brand-orange text-xs font-bold uppercase tracking-wider">Fresh From The
                        Stalls</span>
                    <h2 class="text-3xl font-extrabold tracking-tight">Today's Trending Drops</h2>
                </div>

                <!-- Filter Buttons -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                    <button class="px-4 py-2 bg-brand-dark text-white text-xs font-bold rounded-[5px]">All
                        Items</button>
                    <button
                        class="px-4 py-2 bg-white border border-stone-200 text-stone-600 hover:border-stone-400 text-xs font-bold rounded-[5px]">Handmade</button>
                    <button
                        class="px-4 py-2 bg-white border border-stone-200 text-stone-600 hover:border-stone-400 text-xs font-bold rounded-[5px]">Vintage
                        Finds</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Product 1 -->
                <div
                    class="group bg-white rounded-[5px] p-3 border border-stone-200 hover:border-stone-300 hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative aspect-square rounded-[5px] overflow-hidden bg-stone-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&w=600&q=80"
                            class="object-cover w-full h-full group-hover:scale-105 transition duration-500"
                            alt="Crochet Star Beanie">
                        <button
                            class="absolute top-2.5 right-2.5 p-2 bg-white/80 backdrop-blur-md rounded-[5px] text-stone-700 hover:text-brand-orange transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3
                                    class="font-bold text-sm text-brand-dark group-hover:text-brand-orange transition line-clamp-1">
                                    Crochet Star Beanie</h3>
                                <span class="font-extrabold text-sm">$32</span>
                            </div>
                            <p class="text-xs text-stone-500">Stall: <span
                                    class="font-medium text-stone-800">@loop_studio</span></p>
                        </div>
                        <div
                            class="mt-3 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px] text-stone-500">
                            <span>Only 1 left</span>
                            <span class="text-amber-600 font-semibold">★ 5.0 (42)</span>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div
                    class="group bg-white rounded-[5px] p-3 border border-stone-200 hover:border-stone-300 hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative aspect-square rounded-[5px] overflow-hidden bg-stone-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?auto=format&fit=crop&w=600&q=80"
                            class="object-cover w-full h-full group-hover:scale-105 transition duration-500"
                            alt="Chunky Sneakers">
                        <button
                            class="absolute top-2.5 right-2.5 p-2 bg-white/80 backdrop-blur-md rounded-[5px] text-stone-700 hover:text-brand-orange transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3
                                    class="font-bold text-sm text-brand-dark group-hover:text-brand-orange transition line-clamp-1">
                                    Retro Y2K Chunky Sneakers</h3>
                                <span class="font-extrabold text-sm">$88</span>
                            </div>
                            <p class="text-xs text-stone-500">Stall: <span
                                    class="font-medium text-stone-800">@retroVault</span></p>
                        </div>
                        <div
                            class="mt-3 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px] text-stone-500">
                            <span>Thrift Find</span>
                            <span class="text-amber-600 font-semibold">★ 4.8 (118)</span>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div
                    class="group bg-white rounded-[5px] p-3 border border-stone-200 hover:border-stone-300 hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative aspect-square rounded-[5px] overflow-hidden bg-stone-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1611591475155-4282fc289e84?auto=format&fit=crop&w=600&q=80"
                            class="object-cover w-full h-full group-hover:scale-105 transition duration-500"
                            alt="Silver Chain">
                        <button
                            class="absolute top-2.5 right-2.5 p-2 bg-white/80 backdrop-blur-md rounded-[5px] text-stone-700 hover:text-brand-orange transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3
                                    class="font-bold text-sm text-brand-dark group-hover:text-brand-orange transition line-clamp-1">
                                    Silver Charm Layered Chain</h3>
                                <span class="font-extrabold text-sm">$24</span>
                            </div>
                            <p class="text-xs text-stone-500">Stall: <span
                                    class="font-medium text-stone-800">@metal_crafts</span></p>
                        </div>
                        <div
                            class="mt-3 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px] text-stone-500">
                            <span>Handmade</span>
                            <span class="text-amber-600 font-semibold">★ 4.9 (89)</span>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div
                    class="group bg-white rounded-[5px] p-3 border border-stone-200 hover:border-stone-300 hover:shadow-xl transition duration-300 flex flex-col">
                    <div class="relative aspect-square rounded-[5px] overflow-hidden bg-stone-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=600&q=80"
                            class="object-cover w-full h-full group-hover:scale-105 transition duration-500"
                            alt="Acid Wash Tee">
                        <button
                            class="absolute top-2.5 right-2.5 p-2 bg-white/80 backdrop-blur-md rounded-[5px] text-stone-700 hover:text-brand-orange transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3
                                    class="font-bold text-sm text-brand-dark group-hover:text-brand-orange transition line-clamp-1">
                                    Acid Wash Heavy Tee</h3>
                                <span class="font-extrabold text-sm">$45</span>
                            </div>
                            <p class="text-xs text-stone-500">Stall: <span
                                    class="font-medium text-stone-800">@raw_prints</span></p>
                        </div>
                        <div
                            class="mt-3 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px] text-stone-500">
                            <span>Pre-order</span>
                            <span class="text-amber-600 font-semibold">★ 5.0 (15)</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Seller CTA (Open Your Stall) -->
    <section id="sell" class="py-16 bg-brand-dark text-brand-cream relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <div class="space-y-6">
                    <span
                        class="bg-brand-orange text-white text-xs font-extrabold uppercase tracking-widest px-3 py-1 rounded-[5px]">For
                        Creators & Curators</span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        Turn your closet or craft into a <span
                            class="font-serif italic text-brand-orange">thriving</span> stall.
                    </h2>
                    <p class="text-stone-300 font-medium leading-relaxed">
                        No complicated setup fees. Direct payouts, built-in Gen-Z buyer audience, and instant storefront
                        customization.
                    </p>

                    <ul class="space-y-3 font-semibold text-sm">
                        <li class="flex items-center gap-3">
                            <span
                                class="w-5 h-5 rounded-[5px] bg-brand-orange/20 text-brand-orange flex items-center justify-center text-xs">✓</span>
                            0% upfront listing fees for your first 20 items
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="w-5 h-5 rounded-[5px] bg-brand-orange/20 text-brand-orange flex items-center justify-center text-xs">✓</span>
                            Instant Instagram & TikTok shop integrations
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="w-5 h-5 rounded-[5px] bg-brand-orange/20 text-brand-orange flex items-center justify-center text-xs">✓</span>
                            Direct buyer chat & offer negotiation system
                        </li>
                    </ul>

                    <div class="pt-4">
                        <a href="#"
                            class="inline-block px-8 py-4 bg-brand-orange hover:bg-orange-600 text-white font-extrabold rounded-[5px] transition shadow-lg">
                            Claim Your @Stall Name
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <!-- Glassmorphism Card Feature -->
                    <div class="bg-white/10 backdrop-blur-lg border border-white/10 p-6 rounded-[5px] space-y-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-[5px] bg-brand-orange flex items-center justify-center text-xl font-bold">
                                ✨</div>
                            <div>
                                <h4 class="font-bold text-white text-lg">"Made $2.4k in my first month."</h4>
                                <p class="text-stone-400 text-xs">@miao_crochets — Crochet Maker</p>
                            </div>
                        </div>
                        <p class="text-stone-300 text-sm leading-relaxed">
                            "The stallR community actually cares about handmade craft instead of cheap fast fashion. The
                            vibe here is unbeatable."
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-cream border-t border-stone-200 py-12 text-sm text-stone-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h4 class="font-bold text-brand-dark mb-4">Shop</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-brand-orange">All Drops</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Handmade Fits</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Thrift & Y2K</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Accessories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-brand-dark mb-4">Sell</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-brand-orange">Open a Stall</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Seller Handbook</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Community Rules</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-brand-dark mb-4">About</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-brand-orange">Our Story</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Sustainability</a></li>
                        <li><a href="#" class="hover:text-brand-orange">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-brand-dark mb-4">Stay in the loop</h4>
                    <p class="text-xs text-stone-500 mb-3">No spam, just secret drop alerts.</p>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Your email..."
                            class="bg-white border border-stone-300 rounded-[5px] px-4 py-2 text-xs w-full focus:outline-none focus:ring-1 focus:ring-brand-orange">
                        <button
                            class="bg-brand-dark text-white text-xs font-bold px-4 py-2 rounded-[5px] hover:bg-stone-800">Join</button>
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col sm:flex-row items-center justify-between pt-8 border-t border-stone-200 text-xs text-stone-500">
                <p>© 2026 stallR Inc. All rights reserved.</p>
                <div class="flex gap-6 mt-4 sm:mt-0">
                    <a href="#" class="hover:underline">Privacy</a>
                    <a href="#" class="hover:underline">Terms</a>
                    <a href="#" class="hover:underline">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
