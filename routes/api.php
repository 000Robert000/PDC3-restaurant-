<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProductsController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MenuProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::apiResource('products', ProductsController::class);
Route::apiResource('menus', MenusController::class);
Route::apiResource('menu_products', MenuProductsController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');