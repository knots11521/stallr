<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Vendor\ApplicationPage;

Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get(
        '/vendor/apply',
        ApplicationPage::class
    )->name('vendor.apply');
});

require __DIR__ . '/auth.php';
