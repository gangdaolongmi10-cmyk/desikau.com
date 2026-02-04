{{-- アクティビティアイテムコンポーネント --}}
@props([
    'icon' => 'activity',
    'iconBg' => 'indigo',
    'title' => '',
    'description' => '',
    'time' => '',
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
@endphp

<div class="flex items-start space-x-4">
    <div class="p-2 {{ $iconBgClass }} rounded-full">
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    </div>
    <div>
        <p class="text-sm font-bold">{{ $title }}</p>
        <p class="text-xs text-gray-500">{{ $description }}</p>
        <p class="text-[10px] text-gray-400 mt-1">{{ $time }}</p>
    </div>
</div>
