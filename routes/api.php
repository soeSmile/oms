<?php

use App\Http\Controllers\Api\ApiBrandController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiProductImageController;
use App\Http\Controllers\Api\ApiUserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [ApiAuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('logout', [ApiAuthController::class, 'logOut'])->name('api.logout');

    Route::get('categories/tree', [ApiCategoryController::class, 'getTree'])->name('categories.tree');
    Route::apiResource('categories', ApiCategoryController::class)->except('show');
    Route::apiResource('brands', ApiBrandController::class)->except('show');

    Route::get('products/images/{product}', [ApiProductImageController::class, 'images'])
        ->name('products.images.index');
    Route::delete('products/images/{id}', [ApiProductImageController::class, 'destroy'])
        ->name('products.images.destroy');
    Route::post('products/images/{product}/upload', [ApiProductImageController::class, 'upload'])
        ->name('products.images.upload');
    Route::apiResource('products', ApiProductController::class);
    Route::post('users/confirm', [ApiUserController::class, 'confirm'])->name('users.confirm');
    Route::apiResource('users', ApiUserController::class);
    Route::get('events', [ApiEventController::class, 'index'])->name('events.index');
});
