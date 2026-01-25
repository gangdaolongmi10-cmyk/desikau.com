<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- サイドバー -->
        <aside class="w-64 bg-gray-900 text-white">
            <div class="p-6">
                <h1 class="text-xl font-bold">{{ config('app.name') }}</h1>
                <p class="text-gray-400 text-sm">管理画面</p>
            </div>
            <nav class="mt-6">
                <a href="#" class="block px-6 py-3 bg-gray-800 text-white">ダッシュボード</a>
                <a href="#" class="block px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white">商品管理</a>
                <a href="#" class="block px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white">注文管理</a>
                <a href="#" class="block px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white">ユーザー管理</a>
                <a href="#" class="block px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white">設定</a>
            </nav>
        </aside>

        <!-- メインコンテンツ -->
        <main class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">ダッシュボード</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-gray-500 text-sm">本日の売上</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">¥0</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-gray-500 text-sm">本日の注文数</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-gray-500 text-sm">登録ユーザー数</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
