<?php

use App\Http\Controllers\Api\AttributesController;
use App\Http\Controllers\Api\AttributeValuesController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\ProductAttributesTemplateController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('attributes', [AttributesController::class, 'index']);
Route::get('attributes/{attribute}', [AttributesController::class, 'show']);
Route::get('attributes/{attribute}/attribute-values', [AttributesController::class, 'attributeValues']);

Route::get('attribute-values', [AttributeValuesController::class, 'index']);
Route::get('attribute-values/{attributeValue}', [AttributeValuesController::class, 'show']);

Route::get('product-attributes-templates/{productAttributesTemplate}', [ProductAttributesTemplateController::class, 'show']);

Route::get('brands', [BrandController::class, 'index']);
Route::get('brands/{brand}', [BrandController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);
    Route::post('products/upload', [ProductController::class, 'upload']);
});

Route::get('contacts', [ContactsController::class, 'index']);
