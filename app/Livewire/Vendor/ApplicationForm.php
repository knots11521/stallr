<?php

namespace App\Livewire\Vendor;

use App\Models\VendorApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ApplicationForm extends Component
{
    public string $business_name = '';

    public string $description = '';

    protected $rules = [
        'business_name' => 'required|min:3|max:255',
        'description' => 'nullable|max:500',
    ];

    public function submit(): void
    {
        $this->validate();

        $user = Auth::user();

        // Prevent duplicate applications
        if ($user->vendorApplication) {
            session()->flash(
                'error',
                'You already have a vendor application.'
            );

            return;
        }

        VendorApplication::create([
            'user_id' => $user->id,
            'store_name' => $this->business_name, // Your DB column is store_name
            'description' => $this->description,
        ]);

        session()->flash(
            'success',
            'Your vendor application has been submitted.'
        );

        $this->reset([
            'business_name',
            'description',
        ]);
    }

    public function render()
    {
        return view('livewire.vendor.application-form');
    }
}
