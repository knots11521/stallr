<div x-data="{
    loading: false,
    progress: 0,
    interval: null,
    start() {
        this.loading = true;
        this.progress = 10;
        clearInterval(this.interval);
        this.interval = setInterval(() => {
            if (this.progress < 90) {
                // Smart diminishing increments as it approaches 90%
                this.progress += Math.floor(Math.random() * 8) + 5;
            }
        }, 200);
    },
    finish() {
        this.progress = 100;
        setTimeout(() => {
            this.reset();
        }, 300);
    },
    reset() {
        this.loading = false;
        clearInterval(this.interval);
        setTimeout(() => { this.progress = 0; }, 200);
    }
}" x-show="loading" x-on:livewire:navigate.window="start()"
    x-on:livewire:navigated.window="finish()" x-on:keydown.escape.window="reset()"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/40 p-4 backdrop-blur-md"
    style="display: none;">

    <!-- Glassmorphic Card Container -->
    <div
        class="relative w-full max-w-sm overflow-hidden rounded-2xl border border-white/20 bg-surface/80 p-6 shadow-2xl shadow-primary/10 backdrop-blur-xl dark:border-white/10 dark:bg-slate-900/80">

        <!-- Ambient Glow Effect -->
        <div class="pointer-events-none absolute -top-12 -right-12 h-32 w-32 rounded-full bg-primary/20 blur-2xl"></div>

        <!-- Header Row -->
        <div class="relative z-10 mb-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <!-- Spinning Activity Ring -->
                <span class="relative flex h-3 w-3">
                    <span
                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex h-3 w-3 rounded-full bg-primary"></span>
                </span>
                <span
                    class="text-sm font-semibold tracking-wide text-slate-800 dark:text-slate-100">Navigating...</span>
            </div>

            <!-- Percentage Counter -->
            <span class="font-mono text-xs font-bold text-primary" x-text="`${progress}%`"></span>
        </div>

        <!-- Progress Track -->
        <div class="relative z-10 h-2.5 w-full overflow-hidden rounded-full bg-slate-200/80 dark:bg-slate-800">
            <!-- Animated Fill Bar -->
            <div class="relative h-full bg-gradient-to-r from-primary/80 to-primary transition-all duration-300 ease-out shadow-[0_0_12px_rgba(var(--color-primary),0.8)]"
                :style="`width: ${progress}%`">

                <!-- Internal Shimmer Light Beam -->
                <div
                    class="absolute inset-0 w-full animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/40 to-transparent">
                </div>
            </div>
        </div>
    </div>
</div>
