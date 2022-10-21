<?php

use App\Http\Controllers\Api\ApiBrandController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('login', [ApiAuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('/logout', [ApiAuthController::class, 'logOut'])->name('api.logout');

    Route::get('/categories/tree', [ApiCategoryController::class, 'getTree'])->name('categories.tree');
    Route::apiResource('categories', ApiCategoryController::class)->except('show');
    Route::apiResource('brands', ApiBrandController::class)->except('show');
});
