@props([
    'message' => null,
])

<div {{ $attributes->merge(['class' => 'border-l-4 border-current bg-black/5 px-4 py-3']) }}>
    {{ $message ?? $slot }}
</div>
