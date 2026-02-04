<?php

/**
 * ユーザー向けサイトのルート定義
 * サブドメイン: desikau.local
 */

use App\Http\Controllers\User\AnnouncementController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DownloadController;
use App\Http\Controllers\User\EmailVerificationController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InquiryController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProductLikeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PurchaseFlowController;
use App\Http\Controllers\User\PurchaseHistoryController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\SellerController;
use App\Http\Controllers\User\SellerRegisterController;
use App\Http\Controllers\User\StaticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webhook（CSRF除外）
|--------------------------------------------------------------------------
*/
Route::post('/stripe/webhook', [PurchaseFlowController::class, 'webhook'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| メール認証（Laravelが期待するルート名のためプレフィックスなし）
|--------------------------------------------------------------------------
*/
Route::prefix('email')->middleware('auth')->controller(EmailVerificationController::class)->group(function () {
    Route::get('/verify', 'notice')->name('verification.notice');
    Route::get('/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verification.verify');
    Route::post('/verification-notification', 'resend')->middleware('throttle:6,1')->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| ユーザー向けルート
|--------------------------------------------------------------------------
*/
Route::name('user.')->group(function () {
    // トップページ
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    /*
    |--------------------------------------------------------------------------
    | ゲスト専用（ログイン中はアクセス不可）
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        // ログイン
        Route::controller(LoginController::class)->prefix('login')->name('login.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'login')->name('login');
        });

        // 新規登録
        Route::controller(RegisterController::class)->prefix('register')->name('register.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'register')->name('register');
        });
    });

    // ログアウト（認証状態に関わらずアクセス可能）
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

    /*
    |--------------------------------------------------------------------------
    | 認証必須
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        // 購入履歴
        Route::controller(PurchaseHistoryController::class)->prefix('purchase-history')->name('purchase-history.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order}/receipt', 'receipt')->name('receipt');
        });

        // ダウンロード
        Route::get('/download/{product}', [DownloadController::class, 'download'])->name('download');

        // プロフィール
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/password', 'changePassword')->name('changePassword');
            Route::delete('/', 'destroy')->name('destroy');
        });

        // いいね一覧
        Route::get('/likes', [LikeController::class, 'index'])->name('like.index');

        // 購入フロー
        Route::controller(PurchaseFlowController::class)->prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', 'checkout')->name('index');
            Route::post('/session', 'createSession')->name('session');
            Route::get('/success', 'success')->name('success');
            Route::get('/cancel', 'cancel')->name('cancel');
        });

        // いいね・レビュー（商品関連）
        Route::prefix('products/{product}')->group(function () {
            // いいね
            Route::controller(ProductLikeController::class)->name('product.like.')->group(function () {
                Route::post('/likes', 'store')->name('store');
                Route::delete('/likes', 'destroy')->name('destroy');
            });

            // レビュー
            Route::controller(ReviewController::class)->name('product.review.')->group(function () {
                Route::post('/reviews', 'store')->name('store');
                Route::delete('/reviews/{review}', 'destroy')->name('destroy');
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | 公開ルート（認証不要）
    |--------------------------------------------------------------------------
    */
    // カート
    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'add')->name('add');
        Route::patch('/{cartItemId}', 'update')->name('update');
        Route::delete('/{cartItemId}', 'remove')->name('remove');
        Route::delete('/', 'clear')->name('clear');
        Route::get('/count', 'count')->name('count');
    });

    // 出品者
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::controller(SellerRegisterController::class)->prefix('register')->name('register.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'register')->name('register');
        });
        Route::get('/{seller:slug}', [SellerController::class, 'detail'])->name('detail');
    });

    // 問い合わせ
    Route::controller(InquiryController::class)->prefix('inquiry')->name('inquiry.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    // よくある質問
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

    // お知らせ
    Route::controller(AnnouncementController::class)->prefix('announcement')->name('announcement.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{announcement}', 'show')->name('show');
    });

    // 商品
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'detail')->name('detail');
    });

    // 静的ページ
    Route::get('/static/{slug}', [StaticController::class, 'index'])->name('static.index');
});
