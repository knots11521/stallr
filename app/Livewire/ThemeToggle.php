<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public bool $darkMode = false;

    public function mount(): void
    {
        $this->darkMode = session('theme', 'light') === 'dark';
    }

    public function toggleTheme(): void
    {
        $this->darkMode = !$this->darkMode;
        session(['theme' => $this->darkMode ? 'dark' : 'light']);

        // Dispatch an event to Alpine so the HTML class toggles instantly in JS
        $this->dispatch('theme-changed', dark: $this->darkMode);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
