<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Stallr') }}</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <!-- Apply the persisted theme (or OS preference) before paint to avoid FOUC -->
    <x-theme-init />

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 dark:bg-[#121212] text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <header
        class="sticky top-0 z-50 bg-white/90 dark:bg-[#1A1A1A]/90 backdrop-blur-md border-b border-slate-200/80 dark:border-stone-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2">
                <div
                    class="w-9 h-9 bg-brand-500 rounded-lg flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-brand-500/20">
                    S
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white">{{ config('app.name', 'Stallr') }}<span
                        class="text-brand-500">.</span></span>
            </div>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600 dark:text-stone-400">
                <a href="#categories"
                    class="hover:text-brand-500 transition-colors">Categories</a>
                <a href="#products"
                    class="hover:text-brand-500 transition-colors">Trending</a>
                <a href="#how-it-works"
                    class="hover:text-brand-500 transition-colors">How it Works</a>
                <a href="#vendors"
                    class="hover:text-brand-500 transition-colors">Sell on Stallr</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <x-theme-toggle />

                <a href="{{ route('login') }}" wire:navigate
                    class="text-sm font-semibold text-slate-700 dark:text-stone-300 hover:text-brand-500 px-3 py-2 transition-colors">
                    Sign In
                </a>
                <a href="{{ route('products.index') }}"
                    class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-4 py-2 rounded-[10px] shadow-sm shadow-brand-500/30 transition-all">
                    Start Shopping
                </a>
            </div>
        </div>
    </header>

    <!-- 1. Hero Section -->
    <section
        class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden bg-gradient-to-b from-brand-50/50 dark:from-brand-500/10 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <!-- Text Content -->
                <div class="lg:col-span-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 dark:bg-brand-500/20 text-brand-700 dark:text-white text-xs font-bold tracking-wide uppercase mb-6">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 mr-1"></i> The Next-Gen Marketplace
                    </div>
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                        One marketplace, hundreds of <span class="text-brand-500">independent</span> sellers.
                    </h1>
                    <p class="mt-5 text-lg text-slate-600 dark:text-stone-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Discover unique handmade items, high-tech gear, and lifestyle goods directly from creators and
                        verified boutique vendors.
                    </p>

                    <!-- Dual CTAs -->
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('products.index') }}"
                            class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-bold px-7 py-3.5 rounded-[10px] shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2 text-base transition-all">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i> Start Shopping
                        </a>
                        <a href="#vendors"
                            class="w-full sm:w-auto bg-white dark:bg-[#1A1A1A] hover:bg-slate-100 dark:hover:bg-stone-800 text-slate-700 dark:text-stone-200 font-bold px-7 py-3.5 rounded-[10px] border border-slate-200/80 dark:border-stone-800 shadow-sm flex items-center justify-center gap-2 text-base transition-all">
                            <i data-lucide="store" class="w-5 h-5 text-brand-500"></i> Become a Vendor
                        </a>
                    </div>
                </div>

                <!-- Visual Mockup Grid -->
                <div class="lg:col-span-6 relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div
                                class="bg-white dark:bg-[#1A1A1A] p-4 rounded-[10px] shadow-md border border-slate-100 dark:border-stone-800">
                                <div
                                    class="h-36 bg-orange-100 dark:bg-orange-900/40 rounded-[10px] mb-3 flex items-center justify-center text-brand-500">
                                    <i data-lucide="headphones" class="w-12 h-12"></i>
                                </div>
                                <p class="text-xs font-bold text-brand-500 uppercase tracking-wider">Audio Gear</p>
                                <p class="font-bold text-slate-800 dark:text-white text-sm">Wireless Headphones</p>
                                <p class="text-xs text-slate-500 dark:text-stone-400">by SoundCraft</p>
                            </div>
                            <div
                                class="bg-white dark:bg-[#1A1A1A] p-4 rounded-[10px] shadow-md border border-slate-100 dark:border-stone-800">
                                <div
                                    class="h-28 bg-amber-100 dark:bg-amber-900/40 rounded-[10px] mb-3 flex items-center justify-center text-amber-600 dark:text-amber-400">
                                    <i data-lucide="watch" class="w-10 h-10"></i>
                                </div>
                                <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Accessories</p>
                                <p class="font-bold text-slate-800 dark:text-white text-sm">Minimalist Watch</p>
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div
                                class="bg-white dark:bg-[#1A1A1A] p-4 rounded-[10px] shadow-md border border-slate-100 dark:border-stone-800">
                                <div
                                    class="h-28 bg-rose-100 dark:bg-rose-900/40 rounded-[10px] mb-3 flex items-center justify-center text-rose-500 dark:text-rose-400">
                                    <i data-lucide="shirt" class="w-10 h-10"></i>
                                </div>
                                <p class="text-xs font-bold text-rose-500 dark:text-rose-400 uppercase tracking-wider">Apparel</p>
                                <p class="font-bold text-slate-800 dark:text-white text-sm">Organic Cotton Tee</p>
                            </div>
                            <div
                                class="bg-brand-500 text-white p-5 rounded-[10px] shadow-xl flex flex-col justify-between">
                                <div>
                                    <span
                                        class="bg-white/20 text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded">Vendor
                                        Spotlight</span>
                                    <h4 class="font-bold text-lg mt-2">Ready to open shop?</h4>
                                    <p class="text-xs text-brand-100 mt-1">Join 500+ creators selling today.</p>
                                </div>
                                <div
                                    class="mt-4 pt-3 border-t border-white/20 dark:border-stone-800/40 flex items-center justify-between text-xs font-bold">
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
    <section class="bg-white dark:bg-[#1A1A1A] border-y border-slate-200/80 dark:border-stone-800/80 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($verifiedVendorCount) }}+</p>
                    <p class="text-xs font-semibold text-slate-500 dark:text-stone-400 uppercase tracking-wider mt-1">Verified Vendors</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($productCount) }}+</p>
                    <p class="text-xs font-semibold text-slate-500 dark:text-stone-400 uppercase tracking-wider mt-1">Unique Products</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white">99.4%</p>
                    <p class="text-xs font-semibold text-slate-500 dark:text-stone-400 uppercase tracking-wider mt-1">Satisfaction Rate</p>
                </div>
                <div class="p-2">
                    <p class="text-3xl font-extrabold text-brand-500 flex items-center justify-center gap-1">
                        <i data-lucide="shield-check" class="w-7 h-7"></i> 100%
                    </p>
                    <p class="text-xs font-semibold text-slate-500 dark:text-stone-400 uppercase tracking-wider mt-1">Secure Checkout</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Featured Categories -->
    <section id="categories" class="py-16 bg-slate-50 dark:bg-[#121212]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Explore Popular Categories</h2>
                    <p class="text-slate-500 dark:text-stone-400 text-sm mt-1">Find high-quality goods curated from independent stores.</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="hidden sm:flex items-center gap-1 text-sm font-bold text-brand-500 hover:text-brand-600 transition-colors">
                    Browse All <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $categoryIcons = [
                        'handmade' => 'palette',
                        'electronics' => 'laptop',
                        'fashion' => 'shirt',
                        'home & living' => 'armchair',
                        'home and living' => 'armchair',
                        'beauty' => 'sparkles',
                        'art & books' => 'book-open',
                        'art and books' => 'book-open',
                    ];
                @endphp

                @forelse ($categories as $category)
                    @php
                        $icon = $categoryIcons[strtolower($category->name)] ?? 'package';
                    @endphp
                    <a href="{{ route('products.index') }}"
                        class="bg-white dark:bg-[#1A1A1A] p-5 rounded-[10px] border border-slate-200/60 dark:border-stone-800 shadow-sm text-center hover:border-brand-500 hover:shadow-md group transition-colors">
                        <div
                            class="w-12 h-12 mx-auto bg-brand-50 dark:bg-brand-500/20 text-brand-500 dark:text-white rounded-lg flex items-center justify-center mb-3 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm">{{ $category->name }}</h3>
                        <p class="text-[11px] text-slate-400 dark:text-stone-500 mt-0.5">{{ $category->products_count }} {{ $category->products_count == 1 ? 'Item' : 'Items' }}</p>
                    </a>
                @empty
                    <p class="col-span-full text-sm text-slate-500 dark:text-stone-400">No categories found.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 4. Featured / Trending Products -->
    <section id="products" class="py-16 bg-white dark:bg-[#1A1A1A] border-t border-slate-200/80 dark:border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Trending Right Now</h2>
                    <p class="text-slate-500 dark:text-stone-400 text-sm mt-1">Handpicked quality items straight from top sellers.</p>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($featuredProducts as $product)
                    <div
                        class="bg-white dark:bg-[#1A1A1A] rounded-[10px] border border-slate-200/80 dark:border-stone-800 shadow-sm overflow-hidden flex flex-col justify-between group">
                        <div>
                            <div class="h-48 bg-slate-100 dark:bg-stone-800 relative overflow-hidden flex items-center justify-center">
                                <span
                                    class="absolute top-3 left-3 bg-brand-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">Featured</span>

                                @if ($product->images->isNotEmpty())
                                    @php
                                        $image = $product->images->first();

                                        $imagePath = str_starts_with($image->image_path, 'storage/')
                                            ? asset($image->image_path)
                                            : asset('storage/' . $image->image_path);
                                    @endphp

                                    <img src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-out">
                                @else
                                    <svg class="w-16 h-16 text-slate-300 dark:text-stone-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-stone-400 mb-1">
                                    <span>{{ $product->vendor->store_name ?? 'Independent Seller' }}</span>
                                    <span class="flex items-center gap-1 text-amber-500 font-bold"><i data-lucide="star"
                                            class="w-3 h-3 fill-amber-500"></i> {{ number_format((float) $product->average_rating, 1) }}</span>
                                </div>
                                <h3 class="font-bold text-slate-800 dark:text-white text-base line-clamp-1">{{ $product->name }}</h3>
                                <p class="text-xs text-slate-500 dark:text-stone-400 mt-1 line-clamp-1">
                                    {{ $product->description ?: 'Premium quality item from an independent creator.' }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="p-4 pt-0 flex items-center justify-between border-t border-slate-100 dark:border-stone-800 mt-2">
                            <span class="text-lg font-extrabold text-slate-900 dark:text-white">₱{{ number_format((float) $product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product->slug) }}" title="View {{ $product->name }}"
                                class="bg-brand-50 dark:bg-brand-500/20 hover:bg-brand-500 text-brand-600 dark:text-white p-2 rounded-[10px] transition-colors">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white dark:bg-[#1A1A1A] border border-dashed border-slate-200 dark:border-stone-800 rounded-[10px]">
                        <i data-lucide="package" class="w-12 h-12 text-slate-400 dark:text-stone-500 mx-auto mb-3"></i>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">No products yet</h3>
                        <p class="text-xs text-slate-500 dark:text-stone-400 mt-1">Check back soon for our latest curated picks.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. How It Works (For Customers) -->
    <section id="how-it-works" class="py-16 bg-slate-50 dark:bg-[#121212] border-t border-slate-200/80 dark:border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">How Shopping Works</h2>
            <p class="text-slate-500 dark:text-stone-400 text-sm mt-1 max-w-md mx-auto">Buying independent goods on Stallr is quick,
                transparent, and safe.</p>

            <div class="grid md:grid-cols-3 gap-8 mt-12">
                <!-- Step 1 -->
                <div class="bg-white dark:bg-[#1A1A1A] p-6 rounded-[10px] border border-slate-200/60 dark:border-stone-800 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        1
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Browse & Discover</h3>
                    <p class="text-xs text-slate-500 dark:text-stone-400 mt-2 leading-relaxed">
                        Explore thousands of curated products from hundreds of verified independent stalls.
                    </p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white dark:bg-[#1A1A1A] p-6 rounded-[10px] border border-slate-200/60 dark:border-stone-800 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        2
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Add to Cart</h3>
                    <p class="text-xs text-slate-500 dark:text-stone-400 mt-2 leading-relaxed">
                        Combine items across different sellers easily and manage your cart in one place.
                    </p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white dark:bg-[#1A1A1A] p-6 rounded-[10px] border border-slate-200/60 dark:border-stone-800 shadow-sm relative">
                    <div
                        class="w-12 h-12 bg-brand-500 text-white font-black text-lg rounded-full flex items-center justify-center mx-auto mb-4">
                        3
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-lg">Checkout Securely</h3>
                    <p class="text-xs text-slate-500 dark:text-stone-400 mt-2 leading-relaxed">
                        Pay with confidence via encrypted checkout and track your packages right to your door.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Why Sell on Stallr (For Vendors) -->
    <section id="vendors" class="py-20 bg-slate-900 dark:bg-stone-900 text-white relative overflow-hidden">
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
                    <p class="mt-4 text-slate-400 dark:text-stone-400 text-sm sm:text-base leading-relaxed">
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
                                <h4 class="font-bold text-sm text-slate-200 dark:text-stone-200">No Listing Fees</h4>
                                <p class="text-xs text-slate-400 dark:text-stone-400 mt-0.5">List unlimited items free of charge.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200 dark:text-stone-200">Built-In Analytics</h4>
                                <p class="text-xs text-slate-400 dark:text-stone-400 mt-0.5">Track revenue, views, and order trends.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200 dark:text-stone-200">Reach Thousands</h4>
                                <p class="text-xs text-slate-400 dark:text-stone-400 mt-0.5">Tap into an active, eager buyer base.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-brand-500/20 text-brand-500 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="package-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-200 dark:text-stone-200">Simple Orders</h4>
                                <p class="text-xs text-slate-400 dark:text-stone-400 mt-0.5">Manage stock & fulfillment hassle-free.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="#"
                            class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold px-7 py-3.5 rounded-[10px] shadow-lg shadow-brand-500/20 transition-all text-sm">
                            <i data-lucide="store" class="w-4 h-4"></i> Apply to Become a Vendor
                        </a>
                    </div>
                </div>

                <!-- Vendor UI Card Preview -->
                <div class="lg:col-span-6">
                    <div class="bg-slate-800 dark:bg-stone-900/70 p-6 rounded-[10px] border border-slate-700/80 dark:border-stone-800/60 shadow-2xl relative">
                        <div class="flex items-center justify-between border-b border-slate-700 dark:border-stone-800 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center font-bold text-white">
                                    V
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-200 dark:text-stone-200">Vendor Dashboard</h4>
                                    <p class="text-xs text-slate-400 dark:text-stone-400">Live Sales Overview</p>
                                </div>
                            </div>
                            <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-2 py-1 rounded">●
                                Active Stall</span>
                        </div>

                        <!-- Stats Row inside card -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-slate-900/60 dark:bg-stone-950/60 p-4 rounded-[10px] border border-slate-700/50 dark:border-stone-800">
                                <p class="text-xs text-slate-400 dark:text-stone-400">Monthly Earnings</p>
                                <p class="text-xl font-black text-white mt-1">$4,820.50</p>
                                <p class="text-[10px] text-emerald-400 mt-1">↑ +18% vs last month</p>
                            </div>
                            <div class="bg-slate-900/60 dark:bg-stone-950/60 p-4 rounded-[10px] border border-slate-700/50 dark:border-stone-800">
                                <p class="text-xs text-slate-400 dark:text-stone-400">Total Orders</p>
                                <p class="text-xl font-black text-white mt-1">142</p>
                                <p class="text-[10px] text-brand-500 mt-1">12 Pending Shipment</p>
                            </div>
                        </div>

                        <div
                            class="bg-slate-900/40 dark:bg-stone-950/40 p-3 rounded-[10px] border border-slate-700/40 dark:border-stone-800/40 text-xs text-slate-300 dark:text-stone-300 flex items-center justify-between">
                            <span>New order received from <strong>Alex M.</strong></span>
                            <span class="text-[10px] text-slate-500 dark:text-stone-500">2m ago</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. Testimonials -->
    <section class="py-16 bg-white dark:bg-[#1A1A1A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white text-center">Loved by Buyers & Sellers</h2>
            <p class="text-slate-500 dark:text-stone-400 text-sm text-center mt-1">Here is what our community has to say about Stallr.</p>

            <div class="grid md:grid-cols-2 gap-8 mt-12">
                <!-- Quote 1 -->
                <div class="bg-slate-50 dark:bg-[#1A1A1A] p-6 rounded-[10px] border border-slate-200/80 dark:border-stone-800">
                    <div class="flex items-center gap-1 text-amber-500 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                    </div>
                    <p class="text-slate-700 dark:text-stone-300 text-sm leading-relaxed italic">
                        "Stallr made starting my artisan ceramics store absurdly simple. I went from zero online
                        presence to selling out my first batch in two weeks!"
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-stone-800 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Elena Rostova</p>
                            <p class="text-xs text-slate-500 dark:text-stone-400">Vendor @ ClayCraft Studio</p>
                        </div>
                        <span
                            class="text-[10px] font-bold bg-brand-100 dark:bg-brand-500/20 text-brand-700 dark:text-white px-2 py-0.5 rounded">Vendor</span>
                    </div>
                </div>

                <!-- Quote 2 -->
                <div class="bg-slate-50 dark:bg-[#1A1A1A] p-6 rounded-[10px] border border-slate-200/80 dark:border-stone-800">
                    <div class="flex items-center gap-1 text-amber-500 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
                    </div>
                    <p class="text-slate-700 dark:text-stone-300 text-sm leading-relaxed italic">
                        "I love discovering independent creators here instead of buying mass-produced stuff. Checkout is
                        super smooth and shipping updates are accurate."
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-stone-800 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">Marcus Vance</p>
                            <p class="text-xs text-slate-500 dark:text-stone-400">Verified Shopper</p>
                        </div>
                        <span
                            class="text-[10px] font-bold bg-slate-200 dark:bg-stone-700 text-slate-700 dark:text-stone-300 px-2 py-0.5 rounded">Customer</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Newsletter Signup CTA -->
    <section class="py-16 bg-brand-50 dark:bg-stone-800 border-y border-brand-100 dark:border-stone-800">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div
                class="w-12 h-12 bg-brand-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md shadow-brand-500/20">
                <i data-lucide="bell" class="w-6 h-6"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Never miss a drop or vendor update</h2>
            <p class="text-slate-600 dark:text-stone-400 text-sm mt-2 max-w-md mx-auto">
                Subscribe to receive curated product drops, featured vendor alerts, and exclusive discounts.
            </p>

            <form class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto"
                onsubmit="event.preventDefault();">
                <input type="email" placeholder="Enter your email address"
                    class="w-full px-4 py-3 rounded-[10px] border border-slate-300 dark:border-stone-700 focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm bg-white dark:bg-[#1A1A1A] text-slate-900 dark:text-stone-100">
                <button type="submit"
                    class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 rounded-[10px] shadow-sm shadow-brand-500/30 whitespace-nowrap text-sm transition-all">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- 9. Footer -->
    <footer class="bg-white dark:bg-[#1A1A1A] py-12 border-t border-slate-200 dark:border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">

                <!-- Brand Info -->
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div
                            class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center text-white font-extrabold text-lg">
                            S
                        </div>
                        <span class="font-extrabold text-lg tracking-tight text-slate-900 dark:text-white">{{ config('app.name', 'Stallr') }}<span
                                class="text-brand-500">.</span></span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-stone-400 max-w-xs leading-relaxed">
                        The multi-vendor ecosystem connecting buyers with independent artisans and boutique sellers
                        worldwide.
                    </p>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">Marketplace</h4>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-stone-400">
                        <li><a href="{{ route('products.index') }}"
                                class="hover:text-brand-500 transition-colors">All Categories</a></li>
                        <li><a href="#products"
                                class="hover:text-brand-500 transition-colors">Trending Products</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Featured Vendors</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">Vendors</h4>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-stone-400">
                        <li><a href="#vendors" class="hover:text-brand-500 transition-colors">Sell on Stallr</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Seller Handbook</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-brand-500 transition-colors">Dashboard
                                Login</a></li>
                    </ul>
                </div>

                <!-- Links 3 -->
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-xs uppercase tracking-wider mb-3">Company</h4>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-stone-400">
                        <li><a href="#" class="hover:text-brand-500 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-brand-500 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

            </div>

            <div
                class="pt-8 border-t border-slate-100 dark:border-stone-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 dark:text-stone-500 gap-4">
                <p>&copy; 2026 Stallr Inc. All rights reserved.</p>

                <!-- Stack Tech Badge -->
                <div class="flex items-center gap-2">
                    <span
                        class="bg-slate-100 dark:bg-stone-800 text-slate-600 dark:text-stone-300 px-2.5 py-1 rounded-[10px] font-semibold text-[11px] border border-slate-200 dark:border-stone-700">
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

    @livewireScripts
</body>

</html>
