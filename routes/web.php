<?php

use App\Http\Controllers\ModelTestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/{item_id}/edit-base', [ProductController::class, 'edit_base'])->middleware(['auth', 'verified'])->name('product.editbase');
Route::post('/dashboard/update-base', [ProductController::class, 'update_base'])->middleware(['auth', 'verified'])->name('product.updatebase');
// Route::get('/dashboard/edit-tier/{item_id}', [ProductController::class, 'edit_tier'])->name('product.edit_tier');
Route::post('/dashboard/update-tier', [ProductController::class, 'update_tier'])->name('product.update_tier');

Route::get('/dashboard/add-model-test', function(){
    return view('product.add-model');
})->name('addmodel');
Route::post('/dashboard/store-model-test', [ModelTestController::class, 'store_model'])->name('storemodel');

Route::get('/dashboard/{item_id}', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('product.info');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/order', [OrderController::class, 'index'])->name('order');

// routes/web.php
Route::post('/upload-image', [ModelTestController::class, 'upload'])->name('upload.image');
Route::get('/upload-image', function () {
    return view('product.image-test');
});

require __DIR__.'/auth.php';


