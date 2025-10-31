@php
    $defaultClasses = 'text-gray-700 dark:text-gray-200 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors';
@endphp
<a href="{{ $href }}" {{ ($overwriteClass ?? false) ? $attributes : $attributes->merge(['class' => $defaultClasses]) }}>{{ $slot }}</a>

