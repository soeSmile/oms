<?php

use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('web.index');
Route::get('/login', [IndexController::class, 'login'])->name('web.login');

Route::group(['middleware' => 'auth'], static function () {
    Route::get('/oms', [IndexController::class, 'oms'])->name('web.oms');
    Route::get('/oms/{any}', [IndexController::class, 'oms'])->where('any', '.*')->name('web.oms.all');

    Route::get('/product/{id}/img/{image}', [ProductController::class, 'showImage'])->name('product.image.show');
});
