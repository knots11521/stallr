<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};

?>

<nav class="w-64 min-h-screen bg-white border-r border-gray-200 flex flex-col">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b">
        <a href="{{ route('dashboard') }}" wire:navigate>
            <x-application-logo class="h-10 w-auto text-gray-800" />
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 px-4 py-6 space-y-2">

        <x-nav-link
            :href="route('dashboard')"
            :active="request()->routeIs('dashboard')"
            wire:navigate>
            Dashboard
        </x-nav-link>

        <x-nav-link
            :href="route('dashboard')"
            :active="false"
            wire:navigate>
            Products
        </x-nav-link>

        <x-nav-link
            :href="route('dashboard')"
            :active="false"
            wire:navigate>
            Orders
        </x-nav-link>

        <x-nav-link
            :href="route('dashboard')"
            :active="false"
            wire:navigate>
            Vendors
        </x-nav-link>

        <x-nav-link
            :href="route('dashboard')"
            :active="false"
            wire:navigate>
            Customers
        </x-nav-link>

        <x-nav-link
            :href="route('dashboard')"
            :active="false"
            wire:navigate>
            Reports
        </x-nav-link>

    </div>

    <!-- User -->
    <div class="border-t p-4">

        <div class="mb-4">
            <div
                class="font-semibold text-gray-900"
                x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                x-text="name"
                x-on:profile-updated.window="name = $event.detail.name"></div>

            <div class="text-sm text-gray-500">
                {{ auth()->user()->email }}
            </div>
        </div>

        <x-dropdown align="top" width="48">

            <x-slot name="trigger">
                <button
                    class="w-full flex items-center justify-between rounded-lg border px-3 py-2 hover:bg-gray-50 transition">
                    <span>Account</span>

                    <svg
                        class="h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">

                <x-dropdown-link
                    :href="route('profile')"
                    wire:navigate>
                    Profile
                </x-dropdown-link>

                <button
                    wire:click="logout"
                    class="w-full text-left">
                    <x-dropdown-link>
                        Log Out
                    </x-dropdown-link>
                </button>

            </x-slot>

        </x-dropdown>

    </div>

</nav>
