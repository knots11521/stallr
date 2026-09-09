@props([
    'code' => '404',
    'title' => 'Page Not Found',
    'message' => 'The page you are looking for does not exist or has been moved.',
    'actionText' => 'Return Home',
    'actionHref' => '/',
])

<div x-data
    class="flex flex-col items-center text-center space-y-6">

    {{-- Code Display --}}
    <div class="relative">
        <span
            class="block text-[5rem] md:text-[7rem] font-extrabold text-stone-900 dark:text-stone-100 leading-none select-none">
            {{ $code }}
        </span>
        <span
            class="absolute inset-0 flex items-center justify-center text-[#F1641E] opacity-5"
            style="font-size: 10rem; font-weight: 900;">
            {{ $code }}
        </span>
    </div>

    {{-- Title --}}
    <h1
        class="text-2xl md:text-3xl font-bold text-stone-900 dark:text-white">
        {{ $title }}
    </h1>

    {{-- Message --}}
    <p
        class="max-w-md text-sm text-stone-500 dark:text-stone-400 leading-relaxed">
        {{ $message }}
    </p>

    {{-- Action Button --}}
    @if ($actionText)
        <div class="pt-2">
            <a href="{{ $actionHref }}"
                wire:navigate
                class="inline-flex items-center justify-center px-6 py-3 bg-[#F1641E] text-white font-bold text-xs uppercase tracking-widest hover:bg-[#e05a1a] transition-all duration-200"
                style="border-radius: 8px;">
                {{ $actionText }}
            </a>
        </div>
    @endif

</div>
