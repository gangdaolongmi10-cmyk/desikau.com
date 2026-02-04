<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .carousel-container { scroll-behavior: smooth; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes bump {
            0% { transform: scale(1); }
            50% { transform: scale(1.4); }
            100% { transform: scale(1); }
        }
        .cart-bump { animation: bump 0.3s ease-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <x-user.header />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>
    <x-user.footer />
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Cart State
        const cartCountEl = document.getElementById('cart-count');

        /**
         * カートに商品を追加
         */
        function addToCart(productId) {
            fetch('{{ route("user.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // カート数を更新
                    cartCountEl.textContent = data.cart_count;

                    // アニメーションの追加
                    cartCountEl.classList.add('cart-bump');
                    setTimeout(() => {
                        cartCountEl.classList.remove('cart-bump');
                    }, 300);

                    // トースト通知（存在すれば）
                    if (typeof showToast === 'function') {
                        showToast(data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        /**
         * カート数を初期化
         */
        function initCartCount() {
            fetch('{{ route("user.cart.count") }}', {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                cartCountEl.textContent = data.count;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // ページ読み込み時にカート数を取得
        initCartCount();

        /**
         * お気に入りをトグル
         */
        function toggleLike(productId, button) {
            const isLiked = button.dataset.liked === 'true';
            const method = isLiked ? 'DELETE' : 'POST';
            const url = `/products/${productId}/likes`;

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (response.status === 401) {
                    // 未ログインの場合はログインページへ
                    window.location.href = '{{ route("user.login.index") }}';
                    return;
                }
                if (response.ok) {
                    // 状態を更新
                    const newLiked = !isLiked;
                    button.dataset.liked = newLiked ? 'true' : 'false';

                    // アイコンの見た目を更新
                    const icon = button.querySelector('[data-lucide="heart"]');
                    if (newLiked) {
                        icon.classList.remove('text-gray-400', 'group-hover/like:text-red-400');
                        icon.classList.add('text-red-500', 'fill-red-500');
                    } else {
                        icon.classList.remove('text-red-500', 'fill-red-500');
                        icon.classList.add('text-gray-400', 'group-hover/like:text-red-400');
                    }

                    // アニメーション
                    button.classList.add('scale-125');
                    setTimeout(() => button.classList.remove('scale-125'), 200);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Carousel Logic
        const carousel = document.getElementById('carousel');
        function scrollCarousel(direction) {
            const scrollAmount = carousel.offsetWidth;
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        // Auto Scroll Carousel
        setInterval(() => {
            if (carousel.scrollLeft + carousel.offsetWidth >= carousel.scrollWidth) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                scrollCarousel(1);
            }
        }, 5000);

        function changeImage(src) {
            const mainImg = document.getElementById('main-image');
            mainImg.classList.add('opacity-0');
            setTimeout(() => {
                mainImg.src = src;
                mainImg.classList.remove('opacity-0');
            }, 150);

            // Update thumbnail borders
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            thumbnails.forEach(btn => {
                const thumbSrc = btn.querySelector('img').src.split('?')[0];
                const mainSrc = src.split('?')[0];
                if (thumbSrc === mainSrc) {
                    btn.classList.add('border-indigo-600');
                    btn.classList.remove('border-transparent');
                } else {
                    btn.classList.remove('border-indigo-600');
                    btn.classList.add('border-transparent');
                }
            });
        }

        let isFavorite = false;
        function toggleFavorite() {
            isFavorite = !isFavorite;
            const icon = document.getElementById('fav-icon');
            if (isFavorite) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500', 'fill-current');
            } else {
                icon.classList.remove('text-red-500', 'fill-current');
                icon.classList.add('text-gray-400');
            }
        }
    </script>
</body>
</html>