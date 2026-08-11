<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <aside :class="sidebarCollapsed ? 'w-20' : 'w-64'"
        class="hidden md:flex flex-col h-screen bg-white dark:bg-[#1A1A1A] border-r border-stone-200/70 dark:border-stone-800/80 transition-all duration-300 ease-in-out relative z-30 shadow-2xs">

        <div class="h-16 flex items-center px-4 border-b border-stone-100 dark:border-stone-800/60 justify-between">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 overflow-hidden">
                <div
                    class="w-9 h-9 rounded-[10px] bg-[#F1641E] flex-shrink-0 flex items-center justify-center text-white shadow-md shadow-[#F1641E]/25">
                    <x-application-logo class="w-5 h-5 fill-current" />
                </div>
                <span x-show="!sidebarCollapsed" x-transition.opacity
                    class="font-bold text-base tracking-tight text-stone-900 dark:text-white whitespace-nowrap">
                    {{ config('app.name', 'App') }}
                </span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1.5">

            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate
                x-bind:title="sidebarCollapsed ? 'Dashboard' : ''" class="gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                    {{ __('Dashboard') }}
                </span>
            </x-nav-link>

            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" wire:navigate
                x-bind:title="sidebarCollapsed ? 'Products' : ''" class="gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                    {{ __('Products') }}
                </span>
            </x-nav-link>

            @auth
                <x-nav-link :href="route('cart')" :active="request()->routeIs('cart')" wire:navigate x-bind:title="sidebarCollapsed ? 'Cart' : ''"
                    class="gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l2.4 12.2a2 2 0 002 1.6h7.8a2 2 0 002-1.6L21 7H6M9 21h.01M18 21h.01" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                        {{ __('Cart') }}
                    </span>
                </x-nav-link>

                <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" wire:navigate
                    x-bind:title="sidebarCollapsed ? 'Order History' : ''" class="gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 2h9l3 3v17H6V2zM9 9h6M9 13h6M9 17h4" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                        {{ __('Order History') }}
                    </span>
                </x-nav-link>

                @if (auth()->user()->vendor)
                    <x-nav-link :href="url('/vendor')" :active="request()->is('vendor*')" wire:navigate
                        x-bind:title="sidebarCollapsed ? 'Manage Store' : ''" class="gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                            {{ __('Manage Store') }}
                        </span>
                    </x-nav-link>
                @else
                    <x-nav-link :href="route('vendor.apply')" :active="request()->routeIs('vendor.apply')" wire:navigate
                        x-bind:title="sidebarCollapsed ? 'Make A Store' : ''" class="gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate">
                            {{ __('Make A Store') }}
                        </span>
                    </x-nav-link>
                @endif
            @endauth

        </div>

        <div class="p-3 border-t border-stone-100 dark:border-stone-800/60 space-y-1">
            @auth
                <a href="{{ route('profile') }}" wire:navigate
                    class="flex items-center gap-3 p-2 rounded-[10px] hover:bg-stone-100 dark:hover:bg-stone-800/80 transition"
                    x-bind:title="sidebarCollapsed ? 'Profile Settings' : ''">
                    <div
                        class="w-8 h-8 rounded-[8px] bg-stone-100 dark:bg-stone-800 border border-stone-200/60 dark:border-stone-700 flex-shrink-0 flex items-center justify-center font-bold text-xs text-stone-700 dark:text-stone-200">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition.opacity class="truncate text-left">
                        <p class="text-xs font-semibold text-stone-800 dark:text-stone-200 truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-[10px] text-stone-400 truncate">{{ __('Settings') }}</p>
                    </div>
                </a>

                <button wire:click="logout"
                    class="w-full flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:text-rose-400 dark:hover:bg-rose-950/20 transition text-xs font-medium"
                    x-bind:title="sidebarCollapsed ? 'Log Out' : ''">
                    <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate font-semibold">
                        {{ __('Log Out') }}
                    </span>
                </button>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-[#F1641E] hover:bg-[#FFF5F0] dark:hover:bg-[#F1641E]/10 transition text-xs font-medium"
                    x-bind:title="sidebarCollapsed ? 'Log In' : ''">
                    <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate font-semibold">
                        {{ __('Log In') }}
                    </span>
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" wire:navigate
                        class="flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-[#F1641E] hover:bg-[#FFF5F0] dark:hover:bg-[#F1641E]/10 transition text-xs font-medium"
                        x-bind:title="sidebarCollapsed ? 'Register' : ''">
                        <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-transition.opacity class="truncate font-semibold">
                            {{ __('Register') }}
                        </span>
                    </a>
                @endif
            @endauth
        </div>
    </aside>

    <div x-show="mobileSidebarOpen" class="relative z-50 md:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm"></div>

        <div class="fixed inset-y-0 left-0 flex max-w-full">
            <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="w-64 bg-white dark:bg-[#1A1A1A] p-4 flex flex-col justify-between shadow-xl">
                <div>
                    <div
                        class="flex items-center justify-between pb-4 border-b border-stone-100 dark:border-stone-800">
                        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-[10px] bg-[#F1641E] flex items-center justify-center text-white">
                                <x-application-logo class="w-4 h-4 fill-current" />
                            </div>
                            <span
                                class="font-bold text-stone-900 dark:text-white">{{ config('app.name', 'App') }}</span>
                        </a>
                        <button @click="mobileSidebarOpen = false" class="text-stone-400 hover:text-stone-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate
                            class="flex flex-row items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" wire:navigate
                            class="flex flex-row items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>{{ __('Products') }}</span>
                        </x-responsive-nav-link>

                        @auth
                            <x-responsive-nav-link :href="route('cart')" :active="request()->routeIs('cart')" wire:navigate
                                class="flex flex-row items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 3h2l2.4 12.2a2 2 0 002 1.6h7.8a2 2 0 002-1.6L21 7H6M9 21h.01M18 21h.01" />
                                </svg>
                                <span>{{ __('Cart') }}</span>
                            </x-responsive-nav-link>

                            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" wire:navigate
                                class="flex flex-row items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M6 2h9l3 3v17H6V2zM9 9h6M9 13h6M9 17h4" />
                                </svg>
                                <span>{{ __('Order History') }}</span>
                            </x-responsive-nav-link>

                            @if (auth()->user()->vendor)
                                <x-responsive-nav-link :href="url('/vendor')" :active="request()->is('vendor*')" wire:navigate
                                    class="flex flex-row items-center gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                    <span>{{ __('Manage Store') }}</span>
                                </x-responsive-nav-link>
                            @else
                                <x-responsive-nav-link :href="route('vendor.apply')" :active="request()->routeIs('vendor.apply')" wire:navigate
                                    class="flex flex-row items-center gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0 text-stone-900 dark:text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>{{ __('Make A Store') }}</span>
                                </x-responsive-nav-link>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-100 dark:border-stone-800 space-y-1">
                    @auth
                        <a href="{{ route('profile') }}" wire:navigate
                            class="flex items-center gap-3 p-2 rounded-[10px] hover:bg-stone-100 dark:hover:bg-stone-800/80 transition">
                            <div
                                class="w-8 h-8 rounded-[8px] bg-stone-100 dark:bg-stone-800 border border-stone-200/60 dark:border-stone-700 flex-shrink-0 flex items-center justify-center font-bold text-xs text-stone-700 dark:text-stone-200">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="truncate text-left">
                                <p class="text-xs font-semibold text-stone-800 dark:text-stone-200 truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-[10px] text-stone-400 truncate">{{ __('Settings') }}</p>
                            </div>
                        </a>

                        <button wire:click="logout"
                            class="w-full flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:text-rose-400 dark:hover:bg-rose-950/20 transition text-xs font-medium">
                            <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <span class="truncate font-semibold">
                                {{ __('Log Out') }}
                            </span>
                        </button>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" wire:navigate
                                class="flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-[#F1641E] hover:bg-[#FFF5F0] dark:hover:bg-[#F1641E]/10 transition text-xs font-medium">
                                <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <span class="truncate font-semibold">
                                    {{ __('Log In') }}
                                </span>
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate
                                class="flex items-center gap-3 p-2 rounded-[10px] text-stone-600 dark:text-stone-400 hover:text-[#F1641E] hover:bg-[#FFF5F0] dark:hover:bg-[#F1641E]/10 transition text-xs font-medium">
                                <div class="w-8 h-8 flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span class="truncate font-semibold">
                                    {{ __('Register') }}
                                </span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
