@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-trafficsupply-blue text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 dark:focus:border-indigo-300 transition'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
