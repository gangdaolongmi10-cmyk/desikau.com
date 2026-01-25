{{-- ページタイトルコンポーネント --}}
@props(['title' => '', 'description' => null])

<div class="text-center mb-10">
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $title }}</h1>
    @if($description)
        <p class="text-gray-500">{{ $description }}</p>
    @endif
</div>
