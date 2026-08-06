<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component {
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

<div
    class="min-h-screen bg-[#FDFBF7] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 text-stone-800">
    <!-- Etsy-Style Card Container -->
    <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl border border-stone-200/80 shadow-sm">

        <!-- Header -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="font-serif text-3xl font-normal text-stone-900 tracking-tight">
                Create your account
            </h1>
            <p class="mt-2 text-sm text-stone-600">
                Registration is quick, easy, and opens up a world of unique finds.
            </p>
        </div>

        <form wire:submit="register" class="space-y-5">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('First name / Display name')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="name" id="name"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="text" name="name" placeholder="e.g. Jane Doe" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email address')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="email" id="email"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="email" name="email" placeholder="you@example.com" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="password" id="password"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="password" name="password" placeholder="At least 8 characters" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                    class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-1" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation"
                    class="block w-full rounded-xl border-stone-300 focus:border-stone-900 focus:ring-stone-900 text-stone-900 text-sm py-3 px-4 shadow-none transition"
                    type="password" name="password_confirmation" placeholder="Re-enter password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <!-- Submit Button (Etsy Signature Pill) -->
            <div class="pt-3">
                <x-primary-button
                    class="w-full justify-center py-3.5 px-6 rounded-full bg-[#F1641E] hover:bg-[#D95210] active:bg-[#C2460B] focus:ring-2 focus:ring-offset-2 focus:ring-[#F1641E] text-white font-semibold text-base transition shadow-sm border-none">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <!-- Terms Footer Note -->
            <p class="text-[11px] text-stone-500 text-center leading-relaxed mt-2">
                By clicking Register, you agree to our Terms of Use and Privacy Policy.
            </p>

            <!-- Already Registered Link -->
            <div class="pt-4 border-t border-stone-200 text-center">
                <p class="text-sm text-stone-600">
                    Already have an account?
                    <a class="font-semibold text-stone-900 hover:underline underline-offset-4 ms-1 transition"
                        href="{{ route('login') }}" wire:navigate>
                        {{ __('Sign in') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
