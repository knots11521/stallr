<div x-data="{ loading: false }" x-show="loading" x-on:livewire:navigate.window="loading = true"
    x-on:livewire:navigated.window="loading = false" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-surface/80 backdrop-blur-sm"
    style="display: none;">

    <!-- Pulsing Logo Container -->
    <div class="relative flex items-center justify-center">
        <!-- Outer pulsing aura -->
        <div class="absolute h-16 w-16 animate-ping rounded-full bg-primary/20"></div>

        {{-- <!-- Center Icon Box -->
        <div
            class="relative flex h-14 w-14 animate-bounce items-center justify-center rounded-full bg-primary text-white shadow-modal">
            <x-application-logo class="h-full w-full scale-150 fill-current text-white" />
        </div> --}}

        <div class="animate-ping items-center justify-center">
            <x-application-logo class="h-full w-full scale-100 fill-current text-white" />
        </div>
    </div>
</div>
