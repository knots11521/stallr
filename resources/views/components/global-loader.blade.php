<div x-data="{ loading: false }" x-show="loading" x-on:livewire:navigate.window="loading = true"
    x-on:livewire:navigated.window="loading = false" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#FFFDF9]/80 backdrop-blur-sm"
    style="display:none;">

    <!-- Pulsing Heart Container -->
    <div class="relative flex items-center justify-center">
        <!-- Outer pulsing aura -->
        <div class="absolute h-16 w-16 animate-ping rounded-full bg-[#F1641E]/20"></div>

        <!-- Center Icon Box -->
        <div
            class="relative flex h-14 w-14 animate-bounce items-center justify-center rounded-full bg-[#F1641E] text-white shadow-lg shadow-[#F1641E]/30">
            <svg class="h-7 w-7 fill-current" viewBox="0 0 24 24">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        </div>
    </div>

    <!-- Small warm text below -->
    <span class="mt-4 text-xs font-medium tracking-wide text-amber-900/60 uppercase">Finding handmade goods...</span>
</div>
