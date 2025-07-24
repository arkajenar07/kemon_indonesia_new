<?php

use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ModelTestController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopeeAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Tempat untuk mendaftarkan route web. Route ini menggunakan grup middleware
| "web" dan ditentukan oleh RouteServiceProvider.
|--------------------------------------------------------------------------
*/

// Redirect ke halaman login
Route::get('/', function () {
    return redirect('login');
});

// ==============================
// Pembelian
// ==============================
Route::prefix('dashboard/pembelian')->name('dashboard.')->group(function () {
    Route::get('/', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('/{pembelian_id}/show', [PembelianController::class, 'show'])->name('pembelian.show');
    Route::get('/add', [PembelianController::class, 'create'])->name('pembelian.add');
    Route::post('/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/{pembelian_id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('/{pembelian_id}/update', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::post('/{pembelian_id}/delete', [PembelianController::class, 'delete'])->name('pembelian.delete');
});

// ==============================
// Penjualan
// ==============================
Route::prefix('dashboard/penjualan')->name('dashboard.')->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualan');
    // Route::get('/add', [PenjualanController::class, 'create'])->name('pembelian.add');
    // Route::post('/store', [PenjualanController::class, 'store'])->name('pembelian.store');
    // Route::get('/{pembelian_id}/edit', [PenjualanController::class, 'edit'])->name('pembelian.edit');
    // Route::put('/{pembelian_id}/update', [PenjualanController::class, 'update'])->name('pembelian.update');
    // Route::post('/{pembelian_id}/delete', [PenjualanController::class, 'delete'])->name('pembelian.delete');
});

// ==============================
// Dashboard & Produk
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // Produk (Base)
    Route::get('/dashboard/product/add', [ProductController::class, 'add'])->name('product.add');
    Route::post('/dashboard/product/store', [ProductController::class, 'store_item'])->name('product.store');
    Route::get('/dashboard/{item_id}', [ProductController::class, 'show'])->name('product.info');
    Route::get('/dashboard/{item_id}/edit-base', [ProductController::class, 'edit_base'])->name('product.editbase');
    Route::post('/dashboard/update-base', [ProductController::class, 'update_base'])->name('product.updatebase');
    Route::post('/dashboard/{item_id}/delete', [ProductController::class, 'delete'])->name('product.delete');

    // Produk (Tier)
    Route::post('/dashboard/update-tier', [ProductController::class, 'update_tier'])->name('product.update_tier');

    // Model Test
    Route::get('/dashboard/add-model-test', fn () => view('product.add-model'))->name('addmodel');
    Route::post('/dashboard/store-model-test', [ModelTestController::class, 'store_model'])->name('storemodel');
});

// ==============================
// Order
// ==============================
Route::get('/order', [OrderController::class, 'index'])->name('order');

// ==============================
// Upload Gambar
// ==============================
Route::post('/upload-ajax', [UploadController::class, 'uploadAjax'])->name('upload-ajax');
Route::post('/upload-image', [ModelTestController::class, 'upload'])->name('upload.image');
Route::get('/upload-image', fn () => view('product.image-test'));

// ==============================
// Shopee Authentication
// ==============================
Route::get('/shopee/auth', [ShopeeAuthController::class, 'redirectToShopee']);
Route::get('/shopee/auth/callback', [ShopeeAuthController::class, 'handleCallback']);

// ==============================
// Profile (Authenticated)
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// Auth (Login/Register/etc.)
// ==============================
require __DIR__.'/auth.php';
