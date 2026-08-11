@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex w-full items-center rounded-lg bg-[#F1641E] px-4 py-2 text-white hover:bg-[#D95616] dark:bg-[#F1641E] dark:text-white dark:hover:bg-[#FF7A3D]'
            : 'flex w-full items-center rounded-lg px-4 py-2 text-stone-700 hover:bg-orange-50 hover:text-[#F1641E] dark:text-stone-300 dark:hover:bg-stone-800 dark:hover:text-[#FF7A3D]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
