<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController as CustomerAuth;
use App\Http\Controllers\Customer\HomeController as CustomerHome;
use App\Http\Controllers\Customer\ProductController as CustomerProduct;
use App\Http\Controllers\Customer\CartController as CustomerCart;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckout;
use App\Http\Controllers\Customer\WishlistController as CustomerWishlist;
use App\Http\Controllers\Customer\PageController as CustomerPage;
use App\Http\Controllers\Customer\AccountController as CustomerAccount;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\ReviewController;

Route::name('customer.')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | HOME PAGE
    |--------------------------------------------------------------------------
    */
    Route::get('/', [CustomerHome::class, 'index'])->name('home');
    Route::get('/home', [CustomerHome::class, 'index'])->name('home.index');

    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATION
    |--------------------------------------------------------------------------
    */
    // OTP Routes
    Route::post('/otp/send', [CustomerAuth::class, 'sendOtp'])->name('otp.send');
    Route::post('/otp/verify', [CustomerAuth::class, 'verifyOtp'])->name('otp.verify');

    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [CustomerAuth::class, 'loginPage'])->name('login');
        Route::post('/login', [CustomerAuth::class, 'login'])->name('login.submit');
        Route::get('/register', [CustomerAuth::class, 'registerPage'])->name('register');
        Route::post('/register', [CustomerAuth::class, 'register'])->name('register.submit');
        Route::get('/forgot-password', [CustomerAuth::class, 'showForgotPassword'])->name('forgot-password');
    });

    // Authenticated Routes
    Route::middleware('customer.auth')->group(function () {
        Route::post('/logout', [CustomerAuth::class, 'logout'])->name('logout');
        Route::get('/verify', [CustomerAuth::class, 'verifyPage'])->name('verify');
        Route::post('/verify', [CustomerAuth::class, 'verify'])->name('verify.submit');
        Route::post('/resend-otp', [CustomerAuth::class, 'resendOTP'])->name('otp.resend');
    });

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */
    Route::prefix('products')->group(function () {
        // Listing
        Route::get('/', [CustomerProduct::class, 'listing'])->name('products.index');
        Route::get('/list', [CustomerProduct::class, 'listing'])->name('products.list'); // Alias

        // Search
        Route::get('/search', [CustomerProduct::class, 'search'])->name('products.search');

        // Category
        Route::get('/category/{slug}', [CustomerProduct::class, 'category'])->name('products.category');
        Route::get('/cat/{slug}', [CustomerProduct::class, 'category'])->name('category.products'); // Alias

        // Quick View
        Route::get('/{slug}/quick-view', [CustomerProduct::class, 'quickView'])->name('products.quick-view');

        // Details
        Route::get('/{slug}', [CustomerProduct::class, 'details'])->name('products.show');
        Route::get('/details/{slug}', [CustomerProduct::class, 'details'])->name('products.details'); // Alias

        // Reviews
        Route::post('/{id}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');
    });

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CustomerCart::class, 'index'])->name('index');
        Route::get('/view', [CustomerCart::class, 'index'])->name('view'); // Changed to view for clarity

        Route::post('/add', [CustomerCart::class, 'addItem'])->name('add');
        Route::put('/update/{cartItemId}', [CustomerCart::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{cartItemId}', [CustomerCart::class, 'removeItem'])->name('remove');
        Route::post('/apply-coupon', [CustomerCart::class, 'applyCoupon'])->name('apply-coupon');
        Route::post('/remove-coupon', [CustomerCart::class, 'removeCoupon'])->name('remove-coupon');
        Route::post('/sync', [CustomerCart::class, 'syncCart'])->name('sync');
        Route::get('/summary', [CustomerCart::class, 'getCartSummary'])->name('summary');
        Route::get('/count', [CustomerCart::class, 'getCartCount'])->name('count');
        Route::delete('/clear', [CustomerCart::class, 'clearCart'])->name('clear');
    });

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['throttle:60,1'])->prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CustomerCheckout::class, 'index'])->name('index');
        Route::post('/shipping/check', [CustomerCheckout::class, 'checkShipping'])->name('shipping.check');

        Route::middleware(['customer.auth'])->group(function () {
            Route::post('/process', [CustomerCheckout::class, 'processCheckout'])->name('process');
            Route::post('/payment/callback', [CustomerCheckout::class, 'paymentCallback'])->name('payment.callback');
            Route::get('/payment/failed', [CustomerCheckout::class, 'paymentFailed'])->name('payment.failed');
            Route::get('/confirmation/{order}', [CustomerCheckout::class, 'confirmation'])->name('confirmation');
            Route::post('/buy-now', [CustomerCheckout::class, 'buyNow'])->name('buy.now');
            Route::post('/razorpay/order', [CustomerCheckout::class, 'createRazorpayOrder'])->name('razorpay.order');
            Route::post('/cod', [CustomerCheckout::class, 'processCheckout'])->name('cod');
        });

        // Public callback and webhook for Razorpay
        Route::post('/checkout/payment/callback', [CustomerCheckout::class, 'paymentCallback'])->name('customer.checkout.payment.callback');
        Route::post('/razorpay/webhook', [App\Http\Controllers\Customer\RazorpayWebhookController::class, 'handle'])->name('customer.razorpay.webhook');
        Route::get('/checkout/confirmation/{order}', [CustomerCheckout::class, 'confirmation'])->name('customer.checkout.confirmation');
    });

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['customer.auth'])->prefix('account')->name('account.')->group(function () {
        Route::get('/', [CustomerAccount::class, 'profile'])->name('index');
        Route::get('/profile', [CustomerAccount::class, 'profile'])->name('profile');
        Route::post('/profile', [CustomerAccount::class, 'updateProfile'])->name('profile.update');
        Route::get('/filter/{status}', [CustomerAccount::class, 'profile'])->name('filter');

        Route::get('/orders/{id}', [CustomerOrder::class, 'orderDetails'])->name('orders.details');
        Route::post('/orders/{id}/cancel', [CustomerOrder::class, 'cancelOrder'])->name('orders.cancel');

        //        Route::get('/addresses', [CustomerAccount::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [CustomerAccount::class, 'storeAddress'])->name('addresses.store');
        Route::put('/addresses/{id}', [CustomerAccount::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{id}', [CustomerAccount::class, 'deleteAddress'])->name('addresses.delete');
        Route::post('/addresses/{id}/set-default', [CustomerAccount::class, 'setDefaultAddress'])->name('addresses.set-default');

        Route::get('/change-password', [CustomerAccount::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [CustomerAccount::class, 'updatePassword'])->name('change-password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | WISHLIST
    |--------------------------------------------------------------------------
    */
    Route::middleware(['customer.auth'])->prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [CustomerWishlist::class, 'index'])->name('index');
        Route::post('/toggle', [CustomerWishlist::class, 'toggle'])->name('toggle');
        Route::get('/check/{productId}', [CustomerWishlist::class, 'check'])->name('check');
        Route::post('/add', [CustomerWishlist::class, 'add'])->name('add');
        Route::post('/remove', [CustomerWishlist::class, 'remove'])->name('remove');
    });

    /*
    |--------------------------------------------------------------------------
    | STATIC PAGES & FALLBACK
    |--------------------------------------------------------------------------
    */
    Route::prefix('page')->group(function () {
        Route::get('/{slug}', [CustomerPage::class, 'show'])->name('page.show');
    });
});

// File serving route for local storage files (no symlink needed)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');

// Fallback
Route::fallback(function () {
    return view('customer.errors.404');
});


// Fallback
Route::fallback(function () {
    return view('customer.errors.404');
});
