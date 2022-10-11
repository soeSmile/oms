<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::post('/logout', [AuthController::class, 'logOut'])->name('api.logout');

    /**
     * Admin routers
     */
    Route::group(['middleware' => 'is-user:admin'], static function () {
        Route::apiResource('categories', CategoryController::class);
    });
});
