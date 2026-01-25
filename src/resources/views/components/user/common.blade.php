<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
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
<body class="bg-gray-50 text-gray-900">
    <x-user.header />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>
    <x-user.footer />
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Cart State
        let cartItemCount = 0;
        const cartCountEl = document.getElementById('cart-count');
        const cartCountBadge = document.getElementById('cart-button');

        function addToCart() {
            cartItemCount++;
            cartCountEl.textContent = cartItemCount;

            // アニメーションの追加
            cartCountEl.classList.add('cart-bump');
            setTimeout(() => {
                cartCountEl.classList.remove('cart-bump');
            }, 300);

            // カート投入がわかるようにコンソールにも表示（開発用）
            console.log('Item added to cart. Total items:', cartItemCount);
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