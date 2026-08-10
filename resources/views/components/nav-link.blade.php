@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex w-full items-center rounded-lg bg-indigo-600 px-4 py-2 text-white'
            : 'flex w-full items-center rounded-lg px-4 py-2 text-gray-700 hover:bg-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
