<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div
    class="min-h-screen bg-[#FDFBF7] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 text-stone-800">
    <!-- Etsy-Style Card Container -->
    <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl border border-stone-200/80 shadow-sm">

        <!-- Header -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="font-serif text-3xl font-normal text-stone-900 tracking-tight">
                Sign in
            </h1>
            <p class="mt-2 text-sm text-stone-600">
                Welcome back! Please sign in to continue.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form wire:submit="login" class="space-y-5">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email address')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="form.email" id="email"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="email" name="email" placeholder="you@example.com" required autofocus
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="form.password" id="password"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Remember Me & Forgot Password Row -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember" class="inline-flex items-center cursor-pointer">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                        class="rounded border-stone-300 text-stone-900 focus:ring-stone-900 shadow-sm transition"
                        name="remember">
                    <span class="ms-2 text-sm text-stone-600 select-none">{{ __('Stay signed in') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-stone-600 hover:text-stone-900 underline underline-offset-4 transition"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button (Etsy Signature Pill) -->
            <div class="pt-3">
                <x-primary-button
                    class="w-full justify-center py-3.5 px-6 rounded-full bg-[#F1641E] hover:bg-[#D95210] active:bg-[#C2460B] focus:ring-2 focus:ring-offset-2 focus:ring-[#F1641E] text-white font-semibold text-base transition shadow-sm border-none">
                    {{ __('Sign in') }}
                </x-primary-button>
            </div>

            <!-- New to Store / Register Link -->
            <div class="pt-6 border-t border-stone-200 text-center">
                <p class="text-sm text-stone-600">
                    New here?
                    <a class="font-semibold text-stone-900 hover:underline underline-offset-4 ms-1 transition"
                        href="{{ route('register') }}" wire:navigate>
                        {{ __('Create an account') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
