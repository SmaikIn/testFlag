<?php


use App\Domains\User\Http\Controllers\UserController;

Route::group(['prefix' => 'users'], function () {
    Route::post('/{user}', [UserController::class, 'create']);
    Route::put('/{user}', [UserController::class, 'update'])->middleware(['auth']);
    Route::delete('/{user}', [UserController::class, 'delete'])->middleware('auth');
});
/*Route::apiResource('/users', UserController::class)->only(['create', 'update', 'destroy']);*/