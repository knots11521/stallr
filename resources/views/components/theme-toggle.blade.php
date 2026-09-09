@props([
    'class' => '',
])

<button x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    init() {
        this.sync();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => this.sync());
        window.addEventListener('storage', (e) => { if (e.key === 'theme') this.sync(); });
        window.addEventListener('theme-changed', () => this.sync());
    },
    sync() {
        this.isDark = document.documentElement.classList.contains('dark');
    },
    toggleTheme() {
        var nowDark = !document.documentElement.classList.contains('dark');
        if (nowDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
        this.isDark = nowDark;
        // Dispatch with STRING detail for Filament compatibility
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: nowDark ? 'dark' : 'light' }));
    }
}" @click="toggleTheme()" type="button"
    class="theme-toggle flex items-center justify-center w-9 h-9 rounded-[10px] bg-white dark:bg-[#1A1A1A] border border-stone-200/80 dark:border-stone-800 text-stone-500 hover:text-stone-800 dark:text-stone-400 dark:hover:text-stone-200 hover:bg-stone-50 dark:hover:bg-stone-800 transition duration-150 shadow-2xs {{ $class }}"
    :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'">

    <!-- Sun Icon (shown when dark mode is active) -->
    <svg x-show="isDark" x-cloak class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>

    <!-- Moon Icon (shown when light mode is active) -->
    <svg x-show="!isDark" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
</button>
