<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <x-primary-button
                        class="bg-blue-600 hover:bg-blue-300 active:bg-blue-700"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'display-modal')">{{ __('Info') }}
                    </x-primary-button>

                    <x-modal name="display-modal" :show="$errors->isNotEmpty()" focusable>
                        <form wire:submit="deleteUser" class="p-6">

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('User Info') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('This Modal Displays your personal information') }}
                            </p>

                            <ul class="mt-4">
                                <li x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></li>
                            </ul>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Close') }}
                                </x-secondary-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
