<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// PRODUCTS
Route::get('/products',           [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search',    [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// AUTH
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login',   [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register',[AuthController::class, 'register'])->middleware('guest');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ROUTES PROTÉGÉES
Route::middleware('auth')->group(function () {

    // PANIER
    Route::get('/cart',                         [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',                    [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}/quantity',       [CartController::class, 'updateQuantity'])->name('cart.quantity');
    Route::delete('/cart/{item}',               [CartController::class, 'remove'])->name('cart.remove');

    // WISHLIST
    Route::get('/wishlist',                     [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle',             [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}',       [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/ids',                 [WishlistController::class, 'ids'])->name('wishlist.ids');

    // CHECKOUT
    Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // PROFIL
    Route::get('/profile',                  [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['put','patch'],'/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password',       [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::patch('/profile/avatar',         [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar',        [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

    // COMMANDES
    Route::view('/orders', 'account.orders')->name('orders');

    // Alias profil (compatibilité anciennes vues)
    Route::get('/profile/show', fn() => redirect()->route('profile.index'))->name('profile');

    // ÉVALUATIONS (Reviews)
    Route::post('/products/{product}/reviews',  [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}',          [ReviewController::class, 'destroy'])->name('reviews.destroy');
});