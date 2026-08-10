@props(['value'])

<label
    {{ $attributes->merge([
        'class' => '
                block
                text-sm
                font-medium
                text-stone-700
                dark:text-stone-300
            ',
    ]) }}>
    {{ $value ?? $slot }}
</label>
