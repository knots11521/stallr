@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex w-full items-center rounded-lg
               bg-[#F1641E]/8
               border border-[#F1641E]/15
               px-4 py-2
               text-[#F1641E]
               backdrop-blur-sm
               hover:bg-[#F1641E]/12
               dark:bg-[#F1641E]/10
               dark:border-[#FF7A3D]/15
               dark:text-[#FF9A68]
               dark:hover:bg-[#F1641E]/15'
            : 'flex w-full items-center rounded-lg
               px-4 py-2
               text-stone-700
               hover:bg-[#F1641E]/5
               hover:text-[#F1641E]
               dark:text-stone-300
               dark:hover:bg-[#F1641E]/8
               dark:hover:text-[#FF7A3D]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
