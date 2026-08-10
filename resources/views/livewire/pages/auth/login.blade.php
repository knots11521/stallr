<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
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

<div class="w-full">

    <!-- Card Header / Brand -->
    <div class="text-center mb-6">
        <a href="/" wire:navigate
            class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#F1641E] text-white shadow-lg shadow-[#F1641E]/25 mb-4">
            <x-application-logo class="w-6 h-6 fill-current" />
        </a>
        <h2 class="text-xl font-bold text-stone-900 dark:text-white tracking-tight">
            {{ __('Welcome back') }}
        </h2>
        <p class="text-xs text-stone-500 dark:text-stone-400 mt-1">
            {{ __('Sign in to access your dashboard and account') }}
        </p>
    </div>

    <!-- Session Status Alert -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')"
                class="text-xs font-semibold text-stone-700 dark:text-stone-300" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input wire:model="form.email" id="email"
                    class="block w-full pl-9 pr-3 py-2.5 text-sm rounded-[10px] bg-stone-50 dark:bg-stone-900/50 border-stone-200 dark:border-stone-800 focus:border-[#F1641E] focus:ring-[#F1641E]/20 dark:text-stone-100 placeholder-stone-400 transition duration-150"
                    type="email" name="email" required autofocus autocomplete="username"
                    placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-1.5 text-xs" />
        </div>

        <!-- Password (With Alpine Show/Hide Toggle) -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')"
                class="text-xs font-semibold text-stone-700 dark:text-stone-300" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <x-text-input wire:model="form.password" id="password" ::type="showPassword ? 'text' : 'password'"
                    class="block w-full pl-9 pr-10 py-2.5 text-sm rounded-[10px] bg-stone-50 dark:bg-stone-900/50 border-stone-200 dark:border-stone-800 focus:border-[#F1641E] focus:ring-[#F1641E]/20 dark:text-stone-100 placeholder-stone-400 transition duration-150"
                    name="password" required autocomplete="current-password" placeholder="••••••••" />

                <!-- Password Visibility Toggle Button -->
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-stone-400 hover:text-stone-600 dark:hover:text-stone-200 transition">
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="w-4 h-4 text-[#F1641E]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 014.122-.863c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.499 4.142m-5.877-5.877a3 3 0 10-4.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1.5 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password Row -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-stone-300 dark:border-stone-700 text-[#F1641E] focus:ring-[#F1641E]/30 dark:bg-stone-900 transition"
                    name="remember">
                <span
                    class="ms-2 text-xs font-medium text-stone-600 dark:text-stone-400 select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-[#F1641E] hover:text-[#d85413] hover:underline transition"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 py-2.5 px-4 text-sm font-semibold rounded-[10px] bg-[#F1641E] hover:bg-[#d85413] text-white shadow-md shadow-[#F1641E]/20 hover:shadow-none focus:ring-2 focus:ring-[#F1641E]/50 transition duration-150 active:scale-[0.99]">
                <span>{{ __('Log in') }}</span>
                <svg wire:loading.remove wire:target="login" class="w-4 h-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                <svg wire:loading wire:target="login" class="animate-spin w-4 h-4 text-white" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </button>
        </div>
    </form>

    <!-- Footer Register CTA -->
    @if (Route::has('register'))
        <div
            class="mt-6 text-center text-xs text-stone-500 dark:text-stone-400 border-t border-stone-100 dark:border-stone-800/80 pt-4">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" wire:navigate
                class="font-semibold text-[#F1641E] hover:text-[#d85413] hover:underline ml-0.5">
                {{ __('Create an account') }}
            </a>
        </div>
    @endif
</div>
