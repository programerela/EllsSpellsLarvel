@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-my-blackbg-my-blacktext-my-lilac focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!}></textarea>
