<?php

namespace App\Livewire\Vendor;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApplicationPage extends Component
{
    public function mount(): void
    {
        if (Auth::user()->hasRole('Vendor')) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.vendor.application-page');
    }
}
