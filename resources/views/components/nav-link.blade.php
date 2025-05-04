@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 border-2 border-indigo-600 rounded-md shadow-sm text-base font-bold text-black bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-base font-bold text-black bg-white hover:bg-gray-50 hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
