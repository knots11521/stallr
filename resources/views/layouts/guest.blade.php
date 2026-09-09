<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <!-- Apply the persisted theme (or OS preference) before paint to avoid FOUC -->
    <x-theme-init />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 dark:text-slate-100 selection:bg-brand-500 selection:text-white">
    <!-- Theme toggle (inherits the persisted dark state across auth pages) -->
    <div class="fixed top-4 right-4 z-50">
        <x-theme-toggle />
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50 dark:bg-[#121212]">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white dark:bg-[#1A1A1A] shadow-md border border-stone-200/80 dark:border-stone-800 overflow-hidden rounded-[10px]">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot }}
            @endif
        </div>
    </div>

    @livewireScripts
</body>

</html>
