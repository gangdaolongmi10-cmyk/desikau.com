{{-- 管理画面共通レイアウト --}}
@props([
    'title' => 'ダッシュボード',
])

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ config('app.name') }} 管理画面</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <x-admin.sidebar />
    <main class="lg:ml-64 min-h-screen">
        <x-admin.header :title="$title" />
        <div class="p-4 lg:p-8 space-y-8">
            {{ $slot }}
        </div>
    </main>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
