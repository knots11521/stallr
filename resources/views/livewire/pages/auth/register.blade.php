<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $user->assignRole('Customer');
        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full">

    <!-- Card Header / Brand -->
    <div class="text-center mb-6">
        <a href="/" wire:navigate
            class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary text-white shadow-lg mb-4">
            <x-application-logo class="w-full h-full scale-150 fill-current" />
        </a>
        <h2 class="text-xl font-bold text-main tracking-tight">
            {{ __('Create an account') }}
        </h2>
        <p class="text-xs text-muted mt-1">
            {{ __('Enter your details below to get started') }}
        </p>
    </div>

    <form wire:submit="register" class="space-y-4">

        <!-- Full Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-xs font-semibold text-main" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input wire:model="name" id="name"
                    class="block w-full pl-9 pr-3 py-2.5 text-sm rounded-[10px] bg-surface border-border focus:border-primary text-main placeholder-muted transition duration-150"
                    type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-danger" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-semibold text-main" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input wire:model="email" id="email"
                    class="block w-full pl-9 pr-3 py-2.5 text-sm rounded-[10px] bg-surface border-border focus:border-primary text-main placeholder-muted transition duration-150"
                    type="email" name="email" required autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-danger" />
        </div>

        <!-- Password (With Alpine Show/Hide Toggle) -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-main" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <x-text-input wire:model="password" id="password" ::type="showPassword ? 'text' : 'password'"
                    class="block w-full pl-9 pr-10 py-2.5 text-sm rounded-[10px] bg-surface border-border focus:border-primary text-main placeholder-muted transition duration-150"
                    name="password" required autocomplete="new-password" placeholder="••••••••" />

                <!-- Password Visibility Toggle Button -->
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-muted hover:text-main transition">
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 014.122-.863c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.499 4.142m-5.877-5.877a3 3 0 10-4.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-danger" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showConfirmPassword: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-main" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <x-text-input wire:model="password_confirmation" id="password_confirmation" ::type="showConfirmPassword ? 'text' : 'password'"
                    class="block w-full pl-9 pr-10 py-2.5 text-sm rounded-[10px] bg-surface border-border focus:border-primary text-main placeholder-muted transition duration-150"
                    name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

                <!-- Password Visibility Toggle Button -->
                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-muted hover:text-main transition">
                    <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showConfirmPassword" x-cloak class="w-4 h-4 text-primary" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 014.122-.863c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.499 4.142m-5.877-5.877a3 3 0 10-4.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-danger" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 py-2.5 px-4 text-sm font-semibold rounded-[10px] bg-primary text-white shadow-md hover:shadow-none transition duration-150 active:scale-[0.99]">
                <span>{{ __('Register') }}</span>
                <svg wire:loading.remove wire:target="register" class="w-4 h-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                <svg wire:loading wire:target="register" class="animate-spin w-4 h-4 text-white" fill="none"
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

    <!-- Footer Login CTA -->
    <div class="mt-6 text-center text-xs text-muted border-t border-border pt-4">
        {{ __('Already registered?') }}
        <a href="{{ route('login') }}" wire:navigate class="font-semibold text-primary hover:underline ml-0.5">
            {{ __('Log in to your account') }}
        </a>
    </div>
</div>
