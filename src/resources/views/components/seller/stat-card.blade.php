{{-- 統計カードコンポーネント --}}
@props([
    'icon' => 'activity',
    'iconBg' => 'indigo',
    'label' => '',
    'value' => '',
    'change' => null,
    'changeType' => 'up',
])

@php
    $iconBgClasses = [
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'orange' => 'bg-orange-50 text-orange-600',
        'green' => 'bg-green-50 text-green-600',
        'red' => 'bg-red-50 text-red-600',
        'blue' => 'bg-blue-50 text-blue-600',
    ];
    $iconBgClass = $iconBgClasses[$iconBg] ?? $iconBgClasses['indigo'];

    $changeClasses = [
        'up' => 'text-green-500 bg-green-50',
        'down' => 'text-red-500 bg-red-50',
        'stable' => 'text-gray-400 bg-gray-50',
    ];
    $changeClass = $changeClasses[$changeType] ?? $changeClasses['stable'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm']) }}>
    <div class="flex items-center justify-between mb-4">
        <div class="p-2 {{ $iconBgClass }} rounded-lg">
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
        </div>
        @if ($change)
            <span class="text-[10px] font-bold {{ $changeClass }} px-2 py-1 rounded-full">{{ $change }}</span>
        @endif
    </div>
    <p class="text-sm text-gray-500 font-medium">{{ $label }}</p>
    <h3 class="text-2xl font-bold">{{ $value }}</h3>
</div>
