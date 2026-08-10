<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Prevents dark mode flicker on load -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.stripeKey = @js(config('services.stripe.key'));

        window.checkoutSuccessUrl =
            @js(route('checkout.success'));
    </script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{
    sidebarCollapsed: false,
    mobileSidebarOpen: false
}"
    class="font-['Plus_Jakarta_Sans',sans-serif] antialiased bg-[#F9F8F6] text-slate-800 dark:bg-[#121212] dark:text-slate-100 min-h-screen flex flex-col selection:bg-[#F1641E] selection:text-white">
    <x-global-loader />

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation (Only visible to authenticated users) -->
        @auth
            <livewire:layout.navigation />
        @endauth

        <!-- Main Workspace Container -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Top Navigation Header -->
            <header
                class="sticky top-0 z-20 bg-white/80 dark:bg-[#1A1A1A]/80 backdrop-blur-md border-b border-stone-200/70 dark:border-stone-800/80 px-4 sm:px-6 py-3.5 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    @auth
                        <!-- Desktop Sidebar Toggle -->
                        <button @click="sidebarCollapsed = !sidebarCollapsed"
                            class="hidden md:flex items-center justify-center w-9 h-9 rounded-[10px] text-stone-500 hover:text-stone-800 hover:bg-stone-100 dark:text-stone-400 dark:hover:text-stone-200 dark:hover:bg-stone-800 transition"
                            title="Toggle Sidebar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>

                        <!-- Mobile Menu Button -->
                        <button @click="mobileSidebarOpen = true"
                            class="md:hidden flex items-center justify-center w-9 h-9 rounded-[10px] text-stone-500 hover:bg-stone-100 dark:text-stone-400 dark:hover:bg-stone-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @else
                        <!-- Public Logo Header for Unauthenticated Visitors -->
                        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-[10px] bg-[#F1641E] flex items-center justify-center text-white shadow-md shadow-[#F1641E]/25">
                                <x-application-logo class="w-4 h-4 fill-current" />
                            </div>
                            <span class="font-bold text-base tracking-tight text-stone-900 dark:text-white">
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                    @endauth

                    <!-- Page Title Header -->
                    @if (isset($header))
                        <div class="text-base font-bold text-stone-900 dark:text-stone-100 tracking-tight ml-2">
                            {{ $header }}
                        </div>
                    @endif
                </div>

                <!-- User Top Right Controls -->
                <div class="flex items-center gap-2 sm:gap-3">

                    <!-- Tailwind v4 Compatible Toggle Button -->
                    <button x-data="{
                        isDark: document.documentElement.classList.contains('dark'),
                        toggleTheme() {
                            this.isDark = !this.isDark;
                            if (this.isDark) {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme', 'dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme', 'light');
                            }
                        }
                    }" @click="toggleTheme()" type="button"
                        class="flex items-center justify-center w-9 h-9 rounded-[10px] bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800 text-stone-500 hover:text-stone-800 dark:text-stone-400 dark:hover:text-stone-200 hover:bg-stone-50 dark:hover:bg-stone-800 transition duration-150 shadow-2xs"
                        :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'">

                        <!-- Sun Icon (Active in Dark Mode) -->
                        <svg x-show="isDark" x-cloak class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>

                        <!-- Moon Icon (Active in Light Mode) -->
                        <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Authentication Controls -->
                    @auth
                        <!-- User Profile Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center gap-2 p-1.5 rounded-[10px] bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800 shadow-2xs hover:border-[#F1641E]/40 transition duration-150">
                                    <div
                                        class="w-7 h-7 rounded-[8px] bg-[#F1641E]/10 text-[#F1641E] dark:bg-[#F1641E]/20 dark:text-[#FF7D3B] flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span
                                        class="hidden sm:inline-block text-xs font-semibold text-stone-700 dark:text-stone-200 px-1">
                                        {{ auth()->user()->name }}
                                    </span>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-stone-100 dark:border-stone-800">
                                    <p class="text-[11px] text-stone-400">Signed in as</p>
                                    <p class="text-xs font-semibold text-stone-700 dark:text-stone-300 truncate">
                                        {{ auth()->user()->email }}</p>
                                </div>

                                <x-dropdown-link :href="route('profile')" wire:navigate
                                    class="text-xs hover:bg-[#FFF5F0] dark:hover:bg-[#F1641E]/10 hover:text-[#F1641E]">
                                    {{ __('Profile Settings') }}
                                </x-dropdown-link>

                                <x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <button type="submit">
                                            Log Out
                                        </button>
                                    </form>
                                </x-dropdown-link>

                            </x-slot>
                        </x-dropdown>
                    @else
                        <!-- Guest Navigation Links -->
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" wire:navigate
                                class="text-xs font-semibold px-3 py-2 rounded-[10px] bg-[#F1641E] hover:bg-[#d85413] text-white transition shadow-2xs">
                                {{ __('Log In') }}
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate
                                class="text-xs font-semibold px-3 py-2 rounded-[10px] bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800 text-stone-700 dark:text-stone-200 hover:border-[#F1641E]/40 transition shadow-2xs">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth

                </div>
            </header>

            <!-- Page Content Body -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>

            <!-- Soft Footer -->
            <footer
                class="p-4 text-center text-xs text-stone-400 border-t border-stone-200/50 dark:border-stone-800/50">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}.
            </footer>
        </div>
    </div>

    @livewireScripts
</body>

</html>
