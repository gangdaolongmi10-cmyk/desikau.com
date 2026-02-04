@props([
    'categories' => collect(),
])

<section class="mb-10">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold flex items-center gap-2">
            <i data-lucide="filter" class="w-5 h-5 text-indigo-600"></i>
            カテゴリーで探す
        </h3>
    </div>
    <div class="flex space-x-4 overflow-x-auto no-scrollbar pb-2">
        <x-user.category-button>すべて</x-user.category-button>
        @foreach ($categories as $category)
            <x-user.category-button :slug="$category->slug">
                {{ $category->name }}
            </x-user.category-button>
        @endforeach
    </div>
</section>