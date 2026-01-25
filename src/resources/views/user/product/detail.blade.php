<x-user.common title="Welcome">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-8">
            <a href="index.html" class="hover:text-indigo-600">ストア</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="#" class="hover:text-indigo-600">3D Assets</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-gray-900 font-medium">Abstract Flow - 3D Backgrounds</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
            <!-- Product Gallery (Left) -->
            <div class="space-y-4">
                <div class="aspect-square w-full rounded-3xl overflow-hidden bg-white border border-gray-100 shadow-sm">
                    <img id="main-image" src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=1200" alt="Main Product Image" class="w-full h-full object-cover transition-opacity duration-300">
                </div>
                <!-- Thumbnails -->
                <div class="flex space-x-4 overflow-x-auto no-scrollbar py-2">
                    <button onclick="changeImage('https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=1200')" class="flex-none w-20 h-20 rounded-xl overflow-hidden border-2 border-indigo-600 transition-all thumbnail-btn">
                        <img src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=200" class="w-full h-full object-cover">
                    </button>
                    <button onclick="changeImage('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200')" class="flex-none w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-indigo-200 transition-all thumbnail-btn">
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=200" class="w-full h-full object-cover">
                    </button>
                    <button onclick="changeImage('https://images.unsplash.com/photo-1633167606207-d840b5070fc2?q=80&w=1200')" class="flex-none w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-indigo-200 transition-all thumbnail-btn">
                        <img src="https://images.unsplash.com/photo-1633167606207-d840b5070fc2?q=80&w=200" class="w-full h-full object-cover">
                    </button>
                    <button onclick="changeImage('https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=1200')" class="flex-none w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-indigo-200 transition-all thumbnail-btn">
                        <img src="https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=200" class="w-full h-full object-cover">
                    </button>
                    <button onclick="changeImage('https://images.unsplash.com/photo-1620121692029-d088224ddc74?q=80&w=1200')" class="flex-none w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-indigo-200 transition-all thumbnail-btn">
                        <img src="https://images.unsplash.com/photo-1620121692029-d088224ddc74?q=80&w=200" class="w-full h-full object-cover">
                    </button>
                </div>
            </div>

            <!-- Product Details (Right) -->
            <div class="mt-10 lg:mt-0 px-2 flex flex-col">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">3Dモデル</span>
                        <span class="bg-gray-100 text-gray-500 text-xs font-medium px-3 py-1 rounded-full">デジタル限定</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        Abstract Flow - 3D Backgrounds プロパック
                    </h1>
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <p class="text-3xl font-bold text-gray-900">¥2,480</p>
                        <span class="text-sm text-gray-400 line-through">¥4,200</span>
                        <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded">40% OFF</span>
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-8">
                        <p class="mb-4">最高品質の4K解像度でレンダリングされた、抽象的で流動的な3D背景素材セットです。ウェブサイト、モバイルアプリの背景、プレゼンテーション資料など、あらゆるクリエイティブプロジェクトに洗練された印象を与えます。</p>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>50枚の高解像度PNG画像 (4096 x 4096 px)</li>
                            <li>編集可能なCinema 4Dソースファイル同梱</li>
                            <li>商用利用可能なロイヤリティフリーライセンス</li>
                            <li>24時間の優先サポート対応</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-auto space-y-4 pt-8 border-t border-gray-100">
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center justify-center space-x-2 active:scale-[0.98]">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>カートに追加する</span>
                        </button>
                        <button id="fav-btn" onclick="toggleFavorite()" class="p-4 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all group">
                            <i data-lucide="heart" id="fav-icon" class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                        </button>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-2xl p-4 flex items-start space-x-3">
                        <i data-lucide="info" class="w-5 h-5 text-indigo-600 mt-0.5"></i>
                        <p class="text-[11px] text-indigo-800 leading-relaxed">
                            <strong>デジタルコンテンツについて:</strong> 本商品は決済完了後、即座にマイページからダウンロード可能です。物理的な発送はございません。
                        </p>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">ファイル形式</p>
                        <p class="text-sm font-semibold text-gray-700">PNG, C4D, OBJ</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">サイズ</p>
                        <p class="text-sm font-semibold text-gray-700">1.2 GB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- More Products -->
        <section class="mt-20">
            <h3 class="text-xl font-bold mb-8">こちらの関連商品もおすすめ</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="group cursor-pointer">
                    <div class="aspect-square rounded-2xl bg-gray-100 mb-3 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=400" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Neon Grid 3D Pack</h4>
                    <p class="text-xs text-gray-500">¥1,980</p>
                </div>
                <div class="group cursor-pointer">
                    <div class="aspect-square rounded-2xl bg-gray-100 mb-3 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1633167606207-d840b5070fc2?q=80&w=400" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Minimalistic Textures</h4>
                    <p class="text-xs text-gray-500">¥1,200</p>
                </div>
            </div>
        </section>
    </div>
</x-user.common>