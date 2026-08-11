@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-[#F1641E] dark:text-[#FF7A3D] bg-orange-50 dark:bg-orange-950/30 focus:outline-none focus:text-[#D95616] dark:focus:text-[#FF8A52] focus:bg-orange-100 dark:focus:bg-orange-900/40 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-stone-600 dark:text-stone-400 hover:text-[#F1641E] dark:hover:text-[#FF7A3D] hover:bg-orange-50 dark:hover:bg-stone-800/60 focus:outline-none focus:text-[#F1641E] dark:focus:text-[#FF7A3D] focus:bg-orange-50 dark:focus:bg-stone-800/60 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
