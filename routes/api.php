<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// api v1 (old)
Route::name('api.')->group(__DIR__ . '/api/v1.php');

// api v2 (app)
Route::name('api.v2.')->prefix('v2')->group(__DIR__ . '/api/v2.php');

// api v3 (administration)
Route::name('api.v3.')->prefix('v3')->group(__DIR__ . '/api/v3.php');
