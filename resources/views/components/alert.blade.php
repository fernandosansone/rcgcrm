@props(['type' => 'info'])

@php
  $styles = match($type) {
    'success' => 'bg-green-50 border-green-100 text-green-800',
    'error'   => 'bg-red-50 border-red-100 text-red-800',
    'warning' => 'bg-amber-50 border-amber-100 text-amber-800',
    default   => 'bg-blue-50 border-blue-100 text-blue-800',
  };
@endphp

<div {{ $attributes->merge(['class' => "p-3 border rounded-xl {$styles}"]) }}>
  {{ $slot }}
</div>
