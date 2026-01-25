{{-- 区切り線コンポーネント --}}
@props(['text' => 'または'])

<div class="relative my-8">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-100"></div>
    </div>
    <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-white px-4 text-gray-400 tracking-wider font-medium">{{ $text }}</span>
    </div>
</div>
