<?php

use App\Http\Controllers\Web\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('web.index');
Route::get('/login', [IndexController::class, 'login'])->name('web.login');

Route::group(['middleware' => 'auth'], static function () {
    Route::get('/oms', [IndexController::class, 'oms'])->name('web.oms');
});
