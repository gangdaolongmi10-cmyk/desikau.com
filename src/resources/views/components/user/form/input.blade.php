{{-- フォーム入力コンポーネント --}}
@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'icon' => null,
    'hint' => null,
    'value' => null,
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">{{ $label }}</label>
    @endif
    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-3.5 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none' . ($icon ? ' pl-11' : '')]) }}
        >
        @if($icon)
            <i data-lucide="{{ $icon }}" class="absolute left-4 top-4 text-gray-400 w-5 h-5"></i>
        @endif
    </div>
    @if($hint)
        <p class="text-[11px] text-gray-400 mt-2 ml-1">{{ $hint }}</p>
    @endif
</div>
