<?php

use App\Http\Controllers\Api\V3\LanguageController;
use App\Http\Controllers\Api\V3\ProductController;
use App\Http\Controllers\Api\V3\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth required
Route::middleware(['auth:sanctum'])->group(function(){

    // Available languages
    Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::get('languages/main', [LanguageController::class, 'main'])->name('languages.main');

    // stores
    Route::post('stores/bulk/update', [StoreController::class, 'bulkUpdate'])->name('stores.bulk.update');
    Route::apiResource('stores', StoreController::class);

    // products
    Route::post('products/bulk/update', [ProductController::class, 'bulkUpdate'])->name('products.bulk.update');
    Route::apiResource('products', ProductController::class);

});
