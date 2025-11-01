<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;

route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'sliders'], function () {
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/{slider}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });

    Route::group(['prefix' => 'features'], function () {
        Route::get('/', [FeatureController::class, 'index'])->name('feature.index');
        Route::get('/{feature}/edit', [FeatureController::class, 'edit'])->name('feature.edit');
        Route::put('/{feature}', [FeatureController::class, 'update'])->name('feature.update');
    });

    Route::group(['prefix' => 'about-us'], function () {
        Route::get('/', [AboutUsController::class, 'index'])->name('about.index');
        Route::get('/{about}/edit', [AboutUsController::class, 'edit'])->name('about.edit');
        Route::put('/{about}', [AboutUsController::class, 'update'])->name('about.update');
    });

    Route::group(['prefix' => 'contact-us'], function () {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
        Route::get('/{contact}', [ContactUsController::class, 'show'])->name('contact.show');
        Route::delete('/{contact}', [ContactUsController::class, 'destroy'])->name('contact.destroy');
    });

    Route::group(['prefix' => 'footer'], function () {
        Route::get('/', [FooterController::class, 'index'])->name('footer.index');
        Route::get('/{footer}/edit', [FooterController::class, 'edit'])->name('footer.edit');
        Route::put('/{footer}', [FooterController::class, 'update'])->name('footer.update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/{product}', [ProductController::class, 'show'])->name('product.show');
    });

    Route::group(['prefix' => 'coupons'], function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/', [CouponController::class, 'store'])->name('coupon.store');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    });

    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

    Route::group(['prefix' => 'users', 'middleware'=> 'can:admin'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    });

        Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/', [RoleController::class, 'store'])->name('role.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('role.update');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
