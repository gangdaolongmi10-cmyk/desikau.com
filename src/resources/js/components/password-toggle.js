/**
 * パスワード表示/非表示切り替え機能
 *
 * 使用方法:
 * - パスワード入力: data-password-input
 * - トグルボタン: data-password-toggle
 * - 表示アイコン: data-password-icon-show
 * - 非表示アイコン: data-password-icon-hide
 */
$(function() {
    $(document).on('click', '[data-password-toggle]', function() {
        const $container = $(this).closest('[data-password-container]');
        const $input = $container.find('[data-password-input]');
        const $showIcon = $(this).find('[data-password-icon-show]');
        const $hideIcon = $(this).find('[data-password-icon-hide]');

        if ($input.length === 0) return;

        // パスワード表示/非表示を切り替え
        const isPassword = $input.attr('type') === 'password';
        $input.attr('type', isPassword ? 'text' : 'password');

        // アイコン切り替え
        $showIcon.toggleClass('hidden', !isPassword);
        $hideIcon.toggleClass('hidden', isPassword);
    });
});
