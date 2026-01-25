<x-user.common title="Welcome">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="relative mb-12">
            <div id="carousel" class="carousel-container flex overflow-x-auto snap-x snap-mandatory no-scrollbar rounded-2xl shadow-xl">
                <!-- Slide 1 -->
                <div class="flex-none w-full snap-start relative h-[300px] md:h-[450px] overflow-hidden bg-slate-900 group">
                    <img src="https://images.unsplash.com/photo-1614850523296-d8c1af93d400?q=80&w=1200" alt="Special Offer" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent flex flex-col justify-center p-8 md:p-16 text-white">
                        <span class="bg-indigo-500 text-[10px] uppercase font-bold px-3 py-1 rounded-full w-max mb-4">New Release</span>
                        <h2 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight">次世代グラフィック素材集<br>プロパック 2024</h2>
                        <p class="text-gray-300 mb-6 max-w-lg text-sm md:text-base">4Kテクスチャ、3Dモデル、UIキットを網羅した最高峰のクリエイター向けバンドル。期間限定 40% OFF。</p>
                        <button class="bg-white text-indigo-900 px-8 py-3 rounded-xl font-bold hover:bg-indigo-50 transition-colors w-max">今すぐチェック</button>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="flex-none w-full snap-start relative h-[300px] md:h-[450px] overflow-hidden bg-indigo-950">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=1200" alt="Tech Assets" class="absolute inset-0 w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/80 to-transparent flex flex-col justify-center p-8 md:p-16 text-white">
                        <h2 class="text-3xl md:text-5xl font-extrabold mb-4">エンジニア向け<br>プレミアム・プラグイン</h2>
                        <p class="text-gray-300 mb-6 max-w-lg">効率を最大化するVS Code拡張機能とUIコンポーネントライブラリ。あなたの開発を加速させます。</p>
                        <button class="bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-600 transition-colors w-max">詳細を見る</button>
                    </div>
                </div>
            </div>
            <!-- Carousel Controls -->
            <button onclick="scrollCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md p-2 rounded-full text-white transition-all hidden md:block">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>
            <button onclick="scrollCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md p-2 rounded-full text-white transition-all hidden md:block">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>
        </section>
        <x-user.ui.category-filter />

        <!-- Product Grid -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-900">おすすめのコンテンツ</h3>
                <div class="flex items-center space-x-2 text-sm text-indigo-600 font-semibold cursor-pointer hover:underline">
                    <span>すべて表示</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <x-user.product-card
                    image="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=500"
                    category="3D Assets"
                    title="Abstract Flow - 3D Backgrounds"
                    author="DigitalStudio Pro"
                    :price="2480"
                    slug="abstract-flow-3d-backgrounds"
                />

                <x-user.product-card
                    image="https://images.unsplash.com/photo-1587620962725-abab7fe55159?q=80&w=500"
                    category="Plugin"
                    title="DarkMagic - JS Animation Engine"
                    author="CodeWizard"
                    :price="4900"
                    slug="darkmagic-js-animation-engine"
                />

                <x-user.product-card
                    image="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=500"
                    category="E-Book"
                    title="Modern UI Design Principles"
                    author="Creative Minds"
                    :price="1800"
                    slug="modern-ui-design-principles"
                />

                <x-user.product-card
                    image="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=500"
                    category="Audio"
                    title="Lofi Beats - Creator Bundle"
                    author="SoundWave"
                    :price="3500"
                    slug="lofi-beats-creator-bundle"
                />
            </div>
        </section>
    </main>
</x-user.common>