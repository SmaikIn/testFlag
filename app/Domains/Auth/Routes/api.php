<?php


use App\Domains\Auth\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'loginByEmail'])->name('auth.login-by-email');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
});