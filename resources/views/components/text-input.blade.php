@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
            w-full
            rounded-[10px]
            border
            border-stone-200/80
            bg-white
            px-3
            py-2
            text-stone-800
            placeholder-stone-400
            shadow-2xs
            transition
            duration-150
            disabled:bg-stone-100
            disabled:opacity-50
            dark:border-stone-800
            dark:bg-[#121212]
            dark:text-stone-100
            dark:placeholder-stone-500
            dark:disabled:bg-stone-900/50
        ',
    ]) }}
>
