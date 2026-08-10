@props(['title', 'description' => null, 'actionText' => null, 'actionUrl' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 text-center']) }}>

    {{-- Icon --}}
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-white/10">
        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4" />
        </svg>
    </div>

    {{-- Text --}}
    <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>

    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif

    {{-- Optional Action --}}
    @if ($actionText && $actionUrl)
        <a href="{{ $actionUrl }}"
            class="mt-4 inline-flex items-center justify-center rounded-[10px] bg-[#F1641E] px-4 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-[#d95716] focus:outline-none focus:ring-2 focus:ring-[#F1641E] focus:ring-offset-2">
            {{ $actionText }}
        </a>
    @endif

</div>
