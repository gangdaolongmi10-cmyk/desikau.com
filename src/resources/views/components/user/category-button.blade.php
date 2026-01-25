{{-- カテゴリボタンコンポーネント --}}
@props(['active' => false])

@php
$classes = $active
    ? 'flex-none px-6 py-2.5 rounded-full bg-indigo-600 text-white font-medium shadow-md'
    : 'flex-none px-6 py-2.5 rounded-full bg-white border border-gray-200 text-gray-600 font-medium hover:border-indigo-400 hover:text-indigo-600 transition-all';
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
