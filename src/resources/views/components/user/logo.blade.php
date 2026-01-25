{{-- ロゴコンポーネント --}}
@props(['size' => 'default'])

@php
$sizes = [
    'small' => ['icon' => 'w-5 h-5', 'padding' => 'p-1', 'text' => 'text-lg'],
    'default' => ['icon' => 'w-6 h-6', 'padding' => 'p-1.5', 'text' => 'text-xl'],
    'large' => ['icon' => 'w-6 h-6', 'padding' => 'p-1.5', 'text' => 'text-2xl'],
];
$s = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="flex items-center space-x-2">
    <div class="bg-indigo-600 {{ $s['padding'] }} rounded-lg">
        <i data-lucide="layers" class="text-white {{ $s['icon'] }}"></i>
    </div>
    <span class="{{ $s['text'] }} font-bold tracking-tight">{{ config('app.name') }}</span>
</div>
