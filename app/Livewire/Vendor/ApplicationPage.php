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


        // Already a vendor — redirect to the vendor panel instead of a hard 403.
        if ($user->hasRole('Vendor')) {
            $this->redirect('/vendor', navigate: false);

            return;
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
