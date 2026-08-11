<a
    {{ $attributes->merge([
        'class' =>
            'block w-full px-4 py-2 text-start text-sm leading-5 text-stone-700 dark:text-stone-300 hover:bg-orange-50 hover:text-[#F1641E] dark:hover:bg-stone-800 dark:hover:text-[#FF7A3D] focus:outline-none focus:bg-orange-50 focus:text-[#F1641E] dark:focus:bg-stone-800 dark:focus:text-[#FF7A3D] transition duration-150 ease-in-out',
    ]) }}>
    {{ $slot }}
</a>
