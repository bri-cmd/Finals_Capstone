@props(['type' => 'info'])
@php
    $colors = [
        'success' => 'bg-green-50 text-green-500',
        'error' => 'bg-red-50 text-red-500',
    ]    
@endphp

<div {{ $attributes->merge(['class' => "flash ". ($colors[$type] ?? '')]) }}>
    {{ session('message') }}
</div>