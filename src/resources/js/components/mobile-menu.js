/**
 * スライドメニュー（ハンバーガーメニュー）の開閉機能
 *
 * 使用方法:
 * - トグルボタン: data-mobile-menu-toggle
 * - 閉じるボタン: data-mobile-menu-close
 * - メニュー本体: data-mobile-menu
 * - オーバーレイ: data-mobile-menu-overlay
 * - 開くアイコン: data-mobile-menu-icon-open
 * - 閉じるアイコン: data-mobile-menu-icon-close
 */
$(function() {
    const $toggleButton = $('[data-mobile-menu-toggle]');
    const $closeButton = $('[data-mobile-menu-close]');
    const $menu = $('[data-mobile-menu]');
    const $overlay = $('[data-mobile-menu-overlay]');
    const $iconOpen = $('[data-mobile-menu-icon-open]');
    const $iconClose = $('[data-mobile-menu-icon-close]');

    /**
     * メニューを開く
     */
    function openMenu() {
        // オーバーレイ表示
        $overlay.removeClass('hidden');

        // メニューをスライドイン
        $menu.removeClass('translate-x-full');

        // アイコン切り替え
        $iconOpen.addClass('hidden');
        $iconClose.removeClass('hidden');

        // スクロール禁止
        $('body').addClass('overflow-hidden');

        // Lucideアイコンを再初期化
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    /**
     * メニューを閉じる
     */
    function closeMenu() {
        // メニューをスライドアウト
        $menu.addClass('translate-x-full');

        // オーバーレイ非表示
        $overlay.addClass('hidden');

        // アイコン切り替え
        $iconOpen.removeClass('hidden');
        $iconClose.addClass('hidden');

        // スクロール許可
        $('body').removeClass('overflow-hidden');

        // Lucideアイコンを再初期化
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // トグルボタンクリック
    $toggleButton.on('click', function() {
        const isOpen = !$menu.hasClass('translate-x-full');

        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // 閉じるボタンクリック
    $closeButton.on('click', function() {
        closeMenu();
    });

    // オーバーレイクリックで閉じる
    $overlay.on('click', function() {
        closeMenu();
    });

    // ESCキーで閉じる
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$menu.hasClass('translate-x-full')) {
            closeMenu();
        }
    });
});
