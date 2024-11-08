<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect('/ingreso');
})->name('login');

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:Admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/product/{product}/favorite', [FavoriteController::class, 'add_removeFavorites'])->name('productos.add_removeFavorite');
    Route::get('/favoritos', [FavoriteController::class, 'show'])->name('favoritos');
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::get('/preference', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/historial', [CartController::class, 'historial'])->name('carrito.historial');
    Route::put('/perfil/{id}', [ProfileController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('perfil.destroy');
    Route::get('/checkout/success', [CartController::class, 'success'])->name('mercadopago.success');
    Route::get('/checkout/failed', [CartController::class, 'failed'])->name('mercadopago.failed');
    Route::get('/checkout/pending', [CartController::class, 'pending'])->name('mercadopago.pending');
});

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/clientes', ClientController::class);
    Route::resource('/dashboard/secciones', SectionController::class);
    Route::resource('/dashboard/categorias', CategoryController::class);
    Route::resource('/dashboard/discounts', DiscountController::class);
    Route::get('/dashboard/productos', [ProductController::class, 'table'])->name('productos.table');
    Route::post('/dashboard/productos', [ProductController::class, 'store'])->name('productos.store');
    Route::get('/dashboard/productos/{id}/edit', [ProductController::class, 'edit'])->name('productos.edit');
    Route::put('/dashboard/productos/{id}', [ProductController::class, 'update'])->name('productos.update');
    Route::get('/dashboard/productos/create', [ProductController::class, 'create'])->name('productos.create');
    Route::delete('/dashboard/productos/{product}', [ProductController::class, 'destroy'])->name('productos.destroy');
    Route::delete('/images/{image}', [ImagesController::class, 'destroy'])->name('images.destroy');
});

Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
Route::get('/productos/{id}', [ProductController::class, 'show'])->name('productos.show');

Route::post('/carrito/add', [CartController::class, 'add'])->name('carrito.add');
Route::delete('/carrito/remove/{product}', [CartController::class, 'remove'])->name('carrito.remove');
Route::post('/carrito/update/{product}', [CartController::class, 'update'])->name('carrito.update');
Route::post('/cart/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.applyDiscount');


Route::fallback(function () {
    return redirect('/');
});

require __DIR__ . '/auth.php';
