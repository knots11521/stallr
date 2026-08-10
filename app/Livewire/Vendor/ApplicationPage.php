<?php

namespace App\Livewire\Vendor;

use App\Models\VendorApplication;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApplicationPage extends Component
{
    public ?VendorApplication $application = null;


    public function mount(): void
    {
        $user = Auth::user();


        // Already a vendor
        if ($user->hasRole('Vendor')) {
            abort(403);
        }


        // Check existing application
        $this->application = VendorApplication::where('user_id', $user->id)
            ->latest()
            ->first();
    }


    public function render()
    {
        return view('livewire.vendor.application-page');
    }
}
