{{-- プライマリボタンコンポーネント --}}
@props([
    'type' => 'submit',
    'icon' => null,
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-[0.98] flex items-center justify-center space-x-2']) }}
>
    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    @endif
    <span>{{ $slot }}</span>
</button>
