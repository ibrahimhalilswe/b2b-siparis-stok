<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('categories', CategoryController::class);
Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
