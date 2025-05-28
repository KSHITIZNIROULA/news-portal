@props(['variant' => 'primary'])

@php
    $classes = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'outline' => 'border border-gray-300 hover:border-blue-600 text-blue-600 hover:text-blue-700',
        'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-800'
    ][$variant] . ' px-4 py-2 rounded-md text-sm font-medium transition-colors';
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>