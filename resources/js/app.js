import './bootstrap';
import './stripe/checkout';

// Initialize the theme from localStorage/system preference
function applyTheme() {
    var theme = localStorage.getItem('theme');

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else if (theme === 'light') {
        document.documentElement.classList.remove('dark');
    } else {
        // 'system' or unset: respect OS preference
        var isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', isDark);
    }
}

// Run immediately on initial page load
applyTheme();

// Re-apply theme after Livewire SPA navigation (wire:navigate)
// This ensures dark mode persists across Livewire page transitions
// without requiring a full page reload.
// Note: 'livewire:navigated' fires AFTER the DOM is updated (not 'livewire:navigation'
// which fires before the request).
document.addEventListener('livewire:navigated', () => {
    applyTheme();
    // Notify Alpine components (including theme-toggle) to re-sync their state
    window.dispatchEvent(new CustomEvent('theme-changed', { detail: 'sync' }));
});

// Handle initial Livewire load
document.addEventListener('livewire:initialized', () => {
    applyTheme();
});
