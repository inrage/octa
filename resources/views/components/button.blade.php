@props([
    'variant' => 'primary',
    'size' => 'base',
])

@php($classes = implode(' ', [
    'inline-flex items-center justify-center gap-2 font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 disabled:pointer-events-none disabled:opacity-50',
    match ($variant) {
        'outline' => 'border border-current hover:bg-black/5',
        default => 'bg-black text-white hover:bg-black/80',
    },
    match ($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-7 py-3.5 text-lg',
        default => 'px-5 py-2.5',
    },
]))

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
