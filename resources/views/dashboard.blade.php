<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-900 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:dashboard.dashboard-stats />
        </div>
    </div>
</x-app-layout>
