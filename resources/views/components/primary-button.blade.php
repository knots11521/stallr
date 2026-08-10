@props(['href' => null])

@php
    $classes = $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex
            items-center
            justify-center
            rounded-[10px]
            border
            border-transparent
            bg-[#F1641E]
            px-4
            py-2
            text-xs
            font-semibold
            text-white
            transition
            duration-150
            ease-in-out
            hover:bg-[#d95716]
            focus:bg-[#d95716]
            focus:outline-none
            focus:ring-2
            focus:ring-[#F1641E]
            focus:ring-offset-2
            active:bg-[#c84e13]
        ',
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $classes->except('type') }}>{{ $slot }}</a>
@else
    <button {{ $classes }}>{{ $slot }}</button>
@endif
