<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Middleware\EnsureTableScanned;
use Illuminate\Support\Facades\Route;

Route::get('/table/{number}', [TableController::class, 'redirect'])->name('table.redirect');

// Route::get('/scan-required', fn() => view('scan-required'))->name('scan.notice');

// Route::middleware([EnsureTableScanned::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/all-menus', [HomeController::class, 'allMenus'])->name('pages.menu.all');
    Route::get('/promo-menus', [HomeController::class, 'promoMenus'])->name('pages.menu.promo');
    Route::get('/popular-menus', [HomeController::class, 'popularMenus'])->name('pages.menu.popular');

    // nnti buat menucontroller buat show menu yang ada
    Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

    Route::get('/cart', function () {return view('pages.order.cart');})->name('show.cart');
    Route::post('/cart-add', [OrderController::class, 'addToCart'])->name('order.cart.add');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [OrderController::class, 'saveOrder'])->name('checkout.store');

    Route::get('/checkout-success', [OrderController::class, 'success'])->name('checkout.success');

    Route::get('/success', function () {return view('pages.order.success');})->name('order.success');

    Route::get('/check-order', [OrderController::class, 'check'])->name('check-order');
    Route::post('/check-order', [OrderController::class, 'show'])->name('check-order.show');

    Route::get('/order/{id}/receipt', [OrderController::class, 'downloadReceipt'])->name('order.receipt');  
// });