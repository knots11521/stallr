<div x-data="{ glitchCount: 0 }" x-init="setInterval(() => glitchCount++, 2500)"
    class="min-h-[70vh] flex flex-col items-center justify-center relative py-12">
    <!-- Background Decorator Glitch Numbers -->
    <div
        class="absolute inset-0 flex items-center justify-center pointer-events-none select-none opacity-5 z-0 overflow-hidden">
        <span class="text-[25vw] font-black brand-font tracking-tighter text-teal-400 animate-pulse">404</span>
    </div>

    <!-- Central Error Card -->
    <div class="relative z-10 max-w-2xl w-full bg-neutral-900/90 border border-teal-500/40 p-8 md:p-12 backdrop-blur-md shadow-[0_0_50px_rgba(0,128,128,0.15)] transition-all duration-300"
        style="border-radius: 5px;">

        <!-- Header Status Bar -->
        <div class="flex items-center justify-between border-b border-neutral-800 pb-4 mb-8 text-xs">
            <div class="flex items-center gap-2 text-rose-500 font-bold tracking-widest uppercase">
                <span class="w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                [STATUS: NULL_POINTER_EXCEPTION]
            </div>
            <div class="text-neutral-500 font-mono">
                ERR_CODE // 0x00000194
            </div>
        </div>

        <!-- Animated Glitch Title -->
        <div class="space-y-3 mb-8 text-center md:text-left">
            <h1
                class="brand-font text-5xl md:text-7xl font-extrabold uppercase tracking-tight text-neutral-100 animate-glitch">
                PAGE_<span class="text-teal-400">LOST</span>
            </h1>
            <p class="text-neutral-400 text-sm leading-relaxed font-mono">
                The requested item or URL sector has been dereferenced or moved to cold storage. Continue browsing or
                reset terminal link.
            </p>
        </div>

        <!-- Terminal Diagnostic Box (Interactive Accent) -->
        <div class="bg-neutral-950 border border-neutral-800 p-4 mb-8 font-mono text-xs space-y-2 text-neutral-400"
            style="border-radius: 5px;">
            <div class="flex items-center gap-2 text-teal-400">
                <span>&gt;</span>
                <span class="typing-effect">DIAGNOSTIC_TRACE:</span>
            </div>
            <div class="pl-4 text-neutral-500 space-y-1">
                <p>PATH: <span class="text-neutral-300" x-text="window.location.pathname"></span></p>
                <p>ACTION: ACCESS_DENIED</p>
                <p>RECOMMENDATION: RETURN_TO_SAFE_ZONE</p>
            </div>
        </div>

        <!-- Interactive Quick Actions Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- Primary CTA -->
            <a href="/" wire:navigate
                class="group relative inline-flex items-center justify-center px-6 py-3.5 bg-teal-500 text-black font-bold text-xs uppercase tracking-widest hover:bg-teal-400 transition-all duration-200 overflow-hidden"
                style="border-radius: 5px;">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    [REBOOT_HOME]
                </span>
            </a>

            <!-- Secondary CTA -->
            <a href="/shop" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3.5 border border-teal-500/40 text-teal-400 font-bold text-xs uppercase tracking-widest hover:bg-teal-950/40 hover:border-teal-400 transition-all duration-200"
                style="border-radius: 5px;">
                // BROWSE_CATALOG
            </a>
        </div>

    </div>

    <!-- Bottom Glitch Mode Toggle Button -->
    <div class="mt-8 z-10">
        <button @click="$dispatch('notify', 'SYSTEM_FORCE_SYNCED'); glitchCount++"
            class="text-[11px] text-neutral-500 hover:text-teal-400 uppercase tracking-widest transition-colors flex items-center gap-2">
            <span class="w-1.5 h-1.5 bg-teal-400 rounded-full"></span>
            MANUAL SYSTEM RECOVERY OVERRIDE
        </button>
    </div>
</div>
