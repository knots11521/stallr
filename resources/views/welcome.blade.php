<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            500: '#f97316', // Core Vibrant Orange
                            600: '#ea580c', // Hover Deep Orange
                            700: '#c2410c',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .custom-card {
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
        }

        .custom-card:hover {
            transform: translateY(-2px);
        }
    </style>
    {{-- @vite([resources / js / app . js, resources / css / app . css]); --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2">
                <div
                    class="w-9 h-9 bg-brand-500 rounded-lg flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-brand-500/20">
                    S
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">Stallr<span
                        class="text-brand-500">.</span></span>
            </div>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#categories" class="hover:text-brand-500 transition-colors">Categories</a>
                <a href="#products" class="hover:text-brand-500 transition-colors">Trending</a>
                <a href="#how-it-works" class="hover:text-brand-500 transition-colors">How it Works</a>
                <a href="#vendors" class="hover:text-brand-500 transition-colors">Sell on Stallr</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold text-slate-700 hover:text-brand-500 px-3 py-2 transition-colors">
                    Sign In
                </a>
                <a href="{{ route('products.index') }}"
                    class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2 custom-card shadow-sm shadow-brand-500/30 transition-all">
                    Start Shopping
                </a>
            </div>
        </div>
    </header>

    <!-- 1. Hero Section -->
    <section
        class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden bg-gradient-to-b from-brand-50/50 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <!-- Text Content -->
                <div class="lg:col-span-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-bold tracking-wide uppercase mb-6">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5">="w-3.5 h-3.5"></i> The Next-Gen Marketplace
                    </div>
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        One marketplace, hundreds of <span class="text-brand-500">independent</span> sellers.
                    </h1>
                    <p class="mt-5 text-lg text-slate-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Discover unique handmade items, high-tech gear, and lifestyle goods directly from creators and
                        verified boutique vendors.
                    </p>

                    <!-- Dual CTAs -->
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('products.index') }}"
                            class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-bold px-7 py-3.5 custom-card shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2 text-base transition-all">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i> Start Shopping
                        </a>
                        <a href="#vendors"
                            class="w-full sm:w-auto bg-white hover:bg-slate-100 text-slate-700 font-bold px-7 py-3.5 custom-card border border-slate-200 shadow-sm flex items-center justify-center gap-2 text-base transition-all">
                            <i data-lucide="store" class="w-5 h-5 text-brand-500"></i> Become a Vendor
                        </a>
                    </div>
                </div>

                <!-- Visual Mockup Grid -->
                <div class="lg:col-span-6 relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="bg-white p-4 custom-card shadow-md border border-slate-100">
                                <div
                                    class="h-36 bg-orange-100 custom-card mb-3 flex items-center justify-center text-brand-500">
                                    <i data-lucide="headphones" class="w-12 h-12"></i>
                                </div>
                                <p class="text-xs font-bold text-brand-500 uppercase tracking-wider">Audio Gear</p>
                                <p class="font-bold text-slate-800 text-sm">Wireless Headphones</p>
                                <p class="text-xs text-slate-500">by SoundCraft</p>
                            </div>
                            <div class="bg-white p-4 custom-card shadow-md border border-slate-100">
                                <div
                                    class="h-28 bg-amber-100 custom-card mb-3 flex items-center justify-center text-amber-600">
                                    <i data-lucide="watch" class="w-10 h-10"></i>
                                </div>
                                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Accessories</p>
                                <p class="font-bold text-slate-800 text-sm">Minimalist Watch</p>
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div class="bg-white p-4 custom-card shadow-md border border-slate-100">
                                <div
                                    class="h-28 bg-rose-100 custom-card mb-3 flex items-center justify-center text-rose-500">
                                    <i data-lucide="shirt" class="w-10 h-10"></i>
                                </div>
                                <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Apparel</p>
                                <p class="font-bold text-slate-800 text-sm">Organic Cotton Tee</p>
                            </div>
                            <div
                                class="bg-brand-500 text-white p-5 custom-card shadow-xl flex flex-col justify-between">
                                <div>
                                    <span
                                        class="bg-white/20 text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded">Vendor
                                        Spotlight</span>
                                    <h4 class="font-bold text-lg mt-2">Ready to open shop?</h4>
                                    <p class="text-xs text-brand-100 mt-1">Join 500+ creators selling today.</p>
                                </div>
                                <div
                                    class="mt-4 pt-3 border-t border-white/20 flex items-center justify-between text-xs font-bold">
                                    <span>Learn More</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Trust / Stats Bar -->
    <section class="bg-white border-y border-slate-200/80 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900">500+</p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Verified Vendors</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900">10,000+</p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Unique Products</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900">99.4%</p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Satisfaction Rate</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-brand-500 flex items-center justify-center gap-1">
                        <i data-lucide="shield-check" class="w-7 h-7"></i> 100%
                    </p>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Secure Checkout</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Featured Categories -->
    <section id="categories" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Explore Popular Categories</h2>
                    <p class="text-slate-500 text-sm mt-1">Find high-quality goods curated from independent stores.</p>
                </div>
                <a href="#"
                    class="hidden sm:flex items-center gap-1 text-sm font-bold text-brand-500 hover:text-brand-600 transition-colors">
                    Browse All <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Category 1 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="palette" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Handmade</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">1.2k Items</p>
                </a>
                <!-- Category 2 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="laptop" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Electronics</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">850 Items</p>
                </a>
                <!-- Category 3 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="shirt" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Fashion</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">3.4k Items</p>
                </a>
                <!-- Category 4 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="armchair" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Home & Living</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">2.1k Items</p>
                </a>
                <!-- Category 5 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Beauty</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">940 Items</p>
                </a>
                <!-- Category 6 -->
                <a href="#"
                    class="bg-white p-5 custom-card border border-slate-200/60 shadow-sm text-center hover:border-brand-500 hover:shadow-md group">
                    <div
                        class="w-12 h-12 mx-auto bg-brand-50 text-brand-500 rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Art & Books</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">510 Items</p>
                </a>
            </div>
        </div>
    </section>

    <!-- 4. Featured / Trending Products -->
    <section id="products" class="py-16 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Trending Right Now</h2>
                    <p class="text-slate-500 text-sm mt-1">Handpicked quality items straight from top sellers.</p>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product Card 1 -->
                <div
                    class="bg-white custom-card border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            <span
                                class="absolute top-3 left-3 bg-brand-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">Featured</span>
                            <i data-lucide="coffee"
                                class="w-16 h-16 text-slate-300 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Ceramic Studio</span>
                                <span class="flex items-center gap-1 text-amber-500 font-bold"><i data-lucide="star"
                                        class="w-3 h-3 fill-amber-500"></i> 4.9</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">Handcrafted Clay Mug</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">Matte finish minimalist stoneware
                                coffee cup.</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-lg font-extrabold text-slate-900">$28.00</span>
                        <button
                            class="bg-brand-50 hover:bg-brand-500 text-brand-600 hover:text-white p-2 custom-card transition-colors">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div
                    class="bg-white custom-card border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            <i data-lucide="keyboard"
                                class="w-16 h-16 text-slate-300 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>KeyCraft Co.</span>
                                <span class="flex items-center gap-1 text-amber-500 font-bold"><i data-lucide="star"
                                        class="w-3 h-3 fill-amber-500"></i> 5.0</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">Custom Mechanical Keycaps</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">Custom resin artisan escape keycap set.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-lg font-extrabold text-slate-900">$45.00</span>
                        <button
                            class="bg-brand-50 hover:bg-brand-500 text-brand-600 hover:text-white p-2 custom-card transition-colors">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div
                    class="bg-white custom-card border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            <i data-lucide="backpack"
                                class="w-16 h-16 text-slate-300 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Urban Outfitters</span>
                                <span class="flex items-center gap-1 text-amber-500 font-bold"><i data-lucide="star"
                                        class="w-3 h-3 fill-amber-500"></i> 4.8</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">Canvas Travel Backpack</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">Water-resistant rugged daily commuter
                                bag.</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-lg font-extrabold text-slate-900">$89.00</span>
                        <button
                            class="bg-brand-50 hover:bg-brand-500 text-brand-600 hover:text-white p-2 custom-card transition-colors">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Card 4 -->
                <div
                    class="bg-white custom-card border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            <i data-lucide="lamp"
                                class="w-16 h-16 text-slate-300 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span>Lumina Design</span>
                                <span class="flex items-center gap-1 text-amber-500 font-bold"><i data-lucide="star"
                                        class="w-3 h-3 fill-amber-500"></i> 4.7</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">Nordic Wooden Desk Lamp</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">Warm LED lighting with dimmable
                                control.</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-lg font-extrabold text-slate-900">$64.00</span>
                        <button
                            class="bg-brand-50 hover:bg-brand-500 text-brand-600 hover:text-white p-2 custom-card transition-colors">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. How It Works (For Customers) -->
    <section id="how-it-works" class="py-16 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">How Shopping Works</h2>
            <p class="text-slate-500 text-sm mt-1 max-w-md mx-auto">Buying independent goods on Stallr is quick,
                transparent, and safe.</p>

            <div class="grid md:grid-cols-3 gap-8 mt-12">
                <!-- Step 1 -->
                <div class="bg-white p-6 custom-card border border-slate-200/60 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        1
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg">Browse & Discover</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Explore thousands of curated products from hundreds of verified independent stalls.
                    </p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white p-6 custom-card border border-slate-200/60 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        2
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg">Add to Cart</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Combine items across different sellers easily and manage your cart in one place.
                    </p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white p-6 custom-card border border-slate-200/60 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        3
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg">Checkout Securely</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pay with confidence via encrypted checkout and track your packages right to your door.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Why Sell on Stallr (For Vendors) -->
    <section id="vendors" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <div class="lg:col-span-6">
                    <span
                        class="text-brand-500 font-extrabold text-xs tracking-widest uppercase bg-brand-500/10 border border-brand-500/20 px-3 py-1 rounded-full">
                        Partner With Us
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-4 text-white">
                        Turn your craft into a thriving business.
                    </h2>
                    <p class="mt-4 text-slate-400 text-sm sm:text-base leading-relaxed">
                        Stallr gives creators and vendors all the tools needed to launch, manage, and scale a digital
                        storefront without high platform fees.
                    </p>

                    <!-- Value Props Grid -->
                    <div class="grid sm:grid-cols-2 gap-6 mt-8">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="badge-percent" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200">No Listing Fees</h4>
                                <p class="text-xs text-slate-400 mt-0.5">List unlimited items free of charge.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200">Built-In Analytics</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Track revenue, views, and order trends.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200">Reach Thousands</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Tap into an active, eager buyer base.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="package-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200">Simple Orders</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Manage stock & fulfillment hassle-free.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="#"
                            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold px-7 py-3.5 custom-card shadow-lg shadow-brand-500/20 transition-all text-sm">
                            <i data-lucide="store" class="w-4 h-4"></i> Apply to Become a Vendor
                        </a>
                    </div>
                </div>

                <!-- Vendor UI Card Preview -->
                <div class="lg:col-span-6">
                    <div class="bg-slate-800 p-6 custom-card border border-slate-700/80 shadow-2xl relative">
                        <div class="flex items-center justify-between border-b border-slate-700 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center font-bold text-white">
                                    V
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-200">Vendor Dashboard</h4>
                                    <p class="text-xs text-slate-400">Live Sales Overview</p>
                                </div>
                            </div>
                            <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-2 py-1 rounded">●
                                Active Stall</span>
                        </div>

                        <!-- Stats Row inside card -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-slate-900/60 p-4 custom-card border border-slate-700/50">
                                <p class="text-xs text-slate-400">Monthly Earnings</p>
                                <p class="text-xl font-black text-white mt-1">$4,820.50</p>
                                <p class="text-[10px] text-emerald-400 mt-1">↑ +18% vs last month</p>
                            </div>
                            <div class="bg-slate-900/60 p-4 custom-card border border-slate-700/50">
                                <p class="text-xs text-slate-400">Total Orders</p>
                                <p class="text-xl font-black text-white mt-1">142</p>
                                <p class="text-[10px] text-brand-500 mt-1">12 Pending Shipment</p>
                            </div>
                        </div>

                        <div
                            class="bg-slate-900/40 p-3 custom-card border border-slate-700/40 text-xs text-slate-300 flex items-center justify-between">
                            <span>New order received from <strong>Alex M.</strong></span>
                            <span class="text-[10px] text-slate-500">2m ago</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. Testimonials -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Loved by Buyers & Sellers</h2>
            <p class="text-slate-500 text-sm text-center mt-1">Here is what our community has to say about Stallr.</p>

            <div class="grid md:grid-cols-2 gap-8 mt-12">
                <!-- Quote 1 -->
                <div class="bg-slate-50 p-6 custom-card border border-slate-200/80">
                    <div class="flex items-center gap-1 text-amber-500 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                    </div>
                    <p class="text-slate-700 text-sm leading-relaxed italic">
                        "Stallr made starting my artisan ceramics store absurdly simple. I went from zero online
                        presence to selling out my first batch in two weeks!"
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Elena Rostova</p>
                            <p class="text-xs text-slate-500">Vendor @ ClayCraft Studio</p>
                        </div>
                        <span
                            class="text-[10px] font-bold bg-brand-100 text-brand-700 px-2 py-0.5 rounded">Vendor</span>
                    </div>
                </div>

                <!-- Quote 2 -->
                <div class="bg-slate-50 p-6 custom-card border border-slate-200/80">
                    <div class="flex items-center gap-1 text-amber-500 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                    </div>
                    <p class="text-slate-700 text-sm leading-relaxed italic">
                        "I love discovering independent creators here instead of buying mass-produced stuff. Checkout is
                        super smooth and shipping updates are accurate."
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Marcus Vance</p>
                            <p class="text-xs text-slate-500">Verified Shopper</p>
                        </div>
                        <span
                            class="text-[10px] font-bold bg-slate-200 text-slate-700 px-2 py-0.5 rounded">Customer</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Newsletter Signup CTA -->
    <section class="py-16 bg-brand-50 border-y border-brand-100">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div
                class="w-12 h-12 bg-brand-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md shadow-brand-500/20">
                <i data-lucide="bell" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Never miss a drop or vendor update</h2>
            <p class="text-slate-600 text-sm mt-2 max-w-md mx-auto">
                Subscribe to receive curated product drops, featured vendor alerts, and exclusive discounts.
            </p>

            <form class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto"
                onsubmit="event.preventDefault();">
                <input type="email" placeholder="Enter your email address"
                    class="w-full px-4 py-3 custom-card border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm bg-white">
                <button type="submit"
                    class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 custom-card shadow-sm shadow-brand-500/30 whitespace-nowrap text-sm transition-all">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- 9. Footer -->
    <footer class="bg-white py-12 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">

                <!-- Brand Info -->
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div
                            class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center text-white font-extrabold text-lg">
                            S
                        </div>
                        <span class="font-extrabold text-lg tracking-tight text-slate-900">Stallr<span
                                class="text-brand-500">.</span></span>
                    </div>
                    <p class="text-xs text-slate-500 max-w-xs leading-relaxed">
                        The multi-vendor ecosystem connecting buyers with independent artisans and boutique sellers
                        worldwide.
                    </p>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-3">Marketplace</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li><a href="#" class="hover:text-brand-500 transition-colors">All Categories</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Trending Products</a>
                        </li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Featured Vendors</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-3">Vendors</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Sell on Stallr</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Seller Handbook</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Dashboard Login</a></li>
                    </ul>
                </div>

                <!-- Links 3 -->
                <div>
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-3">Company</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li><a href="#" class="hover:text-brand-500 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

            </div>

            <div
                class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; 2026 Stallr Inc. All rights reserved.</p>

                <!-- Stack Tech Badge -->
                <div class="flex items-center gap-2">
                    <span
                        class="bg-slate-100 text-slate-600 px-2.5 py-1 custom-card font-semibold text-[11px] border border-slate-200">
                        Built with Laravel & Tailwind CSS
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
