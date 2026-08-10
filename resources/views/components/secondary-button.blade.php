@props(['href' => null])

@php
    $classes = $attributes->merge([
        'type' => 'button',
        'class' => '
                inline-flex
                items-center
                justify-center
                rounded-[5px]
                border
                border-stone-200/80
                dark:border-stone-700
                bg-white
                dark:bg-[#1A1A1A]
                px-4
                py-2
                text-xs
                font-semibold
                uppercase
                tracking-widest
                text-stone-700
                dark:text-stone-300
                shadow-2xs
                transition
                duration-150
                ease-in-out
                hover:bg-stone-50
                dark:hover:bg-stone-800
                dark:hover:text-stone-100
                focus:outline-none
                focus:ring-2
                focus:ring-offset-2
                dark:focus:ring-offset-[#121212]
                disabled:opacity-25
            ',
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $classes->except('type') }}>{{ $slot }}</a>
@else
    <button {{ $classes }}>{{ $slot }}</button>
@endif
