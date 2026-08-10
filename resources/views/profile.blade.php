<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-stone-900 dark:text-stone-100 tracking-tight leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information Section -->
            <div
                class="p-4 sm:p-8 bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 shadow-2xs rounded-[10px] transition duration-200">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <!-- Password Update Section -->
            <div
                class="p-4 sm:p-8 bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 shadow-2xs rounded-[10px] transition duration-200">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <!-- Delete Account Section -->
            <div
                class="p-4 sm:p-8 bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800/80 shadow-2xs rounded-[10px] transition duration-200">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
