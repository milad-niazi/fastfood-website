<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactUsController;

Route::get('/', function () {
    return view('home.index');
})->name('home.index');


Route::get('/about-us', function () {
    return view('about');
})->name('about-us');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact-us');

Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
    Route::post('/', [ContactUsController::class, 'store'])->name('contact.store');
});

route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');


route::get('/menu', [ProductController::class, 'menu'])->name('product.menu');



route::middleware('guest')->group(function () {
    route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
    route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    route::post('/check-otp', [AuthController::class, 'checkOtp'])->name('auth.checkOtp');
    route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');
});

route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');


route::prefix('profile')->middleware('auth')->group(function () {
    route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    route::PUT('/{user}', [ProfileController::class, 'update'])->name('profile.update');

    route::get('/addresses', [ProfileController::class, 'addresses'])->name('profile.address');
    route::get('/addresses/create', [ProfileController::class, 'addressCreate'])->name('profile.address.create');
    route::post('/addresses/create', [ProfileController::class, 'addressStore'])->name('profile.address.store');
    route::get('/addresses/{address}/edit', [ProfileController::class, 'addressEdit'])->name('profile.address.edit');
    route::PUT('/addresses/{address}', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');

    route::get('/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    route::get('/orders', [ProfileController::class, 'orders'])->name('profile.order');
    route::get('/transactions', [ProfileController::class, 'transactions'])->name('profile.transactions');

    route::get('/remove-from-wishlist', [ProfileController::class, 'removeFromWishlist'])->name('profile.wishlist.remove');
});

route::get('profile/add-to-wishlist', [ProfileController::class, 'addToWishlist'])->name('profile.wishlist.add');



route::prefix('cart')->middleware('auth')->group(function () {
    route::get('/', [CartController::class, 'index'])->name('cart.index');
    route::get('/increment', [CartController::class, 'increment'])->name('cart.increment');
    route::get('/decrement', [CartController::class, 'decrement'])->name('cart.decrement');
    route::get('/add', [CartController::class, 'add'])->name('cart.add');
    route::get('/remove', [CartController::class, 'remove'])->name('cart.remove');
    route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    route::get('/check-coupon', [CartController::class, 'checkCoupon'])->name('cart.checkCoupon');
});

route::prefix('payment')->middleware('auth')->group(function () {
    route::post('/send', [PaymentController::class, 'send'])->name('payment.send');
    route::get('/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    route::get('/status', [PaymentController::class, 'status'])->name('payment.status');
});
