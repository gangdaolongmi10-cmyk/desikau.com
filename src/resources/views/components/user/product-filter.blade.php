{{-- 商品絞り込みコンポーネント --}}
@props([
    'categories' => collect(),
    'sortOptions' => [],
    'sort' => null,
    'showCategory' => true,
    'showSort' => true,
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
    {{-- カテゴリーフィルター --}}
    @if ($showCategory && $categories->isNotEmpty())
        <div class="flex flex-wrap gap-2" id="category-filters">
            <x-user.category-button>すべて</x-user.category-button>
            @foreach ($categories as $category)
                <x-user.category-button :slug="$category->slug">{{ $category->name }}</x-user.category-button>
            @endforeach
        </div>
    @elseif ($showCategory)
        <div></div>
    @endif

    {{-- ソート --}}
    @if ($showSort && !empty($sortOptions))
        <div class="flex items-center gap-2">
            <label for="sort" class="text-sm text-gray-600 whitespace-nowrap">並び替え:</label>
            <select
                id="sort"
                onchange="updateSort(this.value)"
                class="px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none cursor-pointer"
            >
                @foreach ($sortOptions as $option)
                    <option value="{{ $option->value }}" {{ $sort === $option ? 'selected' : '' }}>
                        {{ $option->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        <script>
            function updateSort(value) {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', value);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }
        </script>
    @endif
</div>
