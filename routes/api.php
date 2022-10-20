<?php

use App\Http\Controllers\Api\ApiLocaleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('/logout', [AuthController::class, 'logOut'])->name('api.logout');

    Route::get('/locales', [ApiLocaleController::class, 'getLocales'])->name('get.locales');

    Route::get('/categories/tree', [CategoryController::class, 'getTree'])->name('categories.tree');
    Route::apiResource('categories', CategoryController::class)->except('show');
});
