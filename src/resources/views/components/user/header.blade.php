<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('user.home.index') }}">
                <x-user.logo />
            </a>
            <div class="flex items-center space-x-5">
                <button id="cart-button" class="relative text-gray-600 hover:text-indigo-600 transition-colors">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full transition-all">0</span>
                </button>

                @auth
                    {{-- ログイン中 --}}
                    <div class="hidden sm:flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <form action="{{ route('user.login.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-full font-medium hover:bg-gray-300 transition-all">
                                ログアウト
                            </button>
                        </form>
                    </div>
                @else
                    {{-- 未ログイン --}}
                    <a href="{{ route('user.login.index') }}" class="hidden sm:block bg-indigo-600 text-white px-5 py-2 rounded-full font-medium hover:bg-indigo-700 transition-all shadow-sm">
                        ログイン
                    </a>
                @endauth

                <button class="md:hidden text-gray-600">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>
</header>