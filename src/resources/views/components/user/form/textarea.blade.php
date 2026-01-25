{{-- テキストエリアコンポーネント --}}
@props([
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'rows' => 6,
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">{{ $label }}</label>
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-3.5 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none resize-none']) }}
    ></textarea>
</div>
