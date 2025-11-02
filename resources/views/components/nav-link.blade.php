@props([
    'href',
    'route' => null,
    'overwriteClass' => false,
])

@php
    $isActive = isset($route) 
        ? request()->routeIs($route)
        : request()->is($href === '/' ? '/' : trim($href, '/').'*');
    
    $baseClasses = 'rounded-md px-3 py-2 text-sm font-medium transition-colors';
    $activeClasses = 'bg-gray-900 text-white';
    $inactiveClasses = 'text-gray-300 hover:bg-white/5 hover:text-white';
    $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
@endphp
<a href="{{ $href }}" {{ $overwriteClass ? $attributes : $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>

