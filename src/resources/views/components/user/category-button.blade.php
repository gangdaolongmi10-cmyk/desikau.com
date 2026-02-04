{{-- カテゴリボタンコンポーネント --}}
@props([
    'slug' => null,
])

@php
    // 現在のクエリパラメータからcategoryを取得
    $currentCategory = request()->query('category');

    // slugがnullの場合は「すべて」ボタン（カテゴリ絞り込み解除）
    $isActive = $slug === null ? $currentCategory === null : $currentCategory === $slug;

    // URLを構築（既存のクエリパラメータを保持しつつcategoryを変更）
    if ($slug === null) {
        // 「すべて」の場合はcategoryパラメータを削除
        $url = request()->fullUrlWithoutQuery('category');
    } else {
        // カテゴリ指定の場合はcategoryパラメータを追加/更新
        $url = request()->fullUrlWithQuery(['category' => $slug]);
    }

    $baseClasses = 'category-pill inline-block px-5 py-2 rounded-full border text-sm font-semibold transition-all';
    $activeClasses = 'bg-indigo-600 text-white border-indigo-600';
    $inactiveClasses = 'border-gray-200 bg-white hover:border-indigo-600 hover:text-indigo-600';
    $classes = $baseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses);
@endphp

<a
    href="{{ $url }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</a>
