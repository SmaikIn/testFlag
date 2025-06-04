<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPaymentTypeController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/../app/Domains/User/Routes/api.php';
require __DIR__.'/../app/Domains/Auth/Routes/api.php';
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('product', ProductController::class);
Route::apiResource('cartItem', CartItemController::class);
Route::apiResource('orderStatus', OrderStatusController::class);
Route::apiResource('orderPaymentType',OrderPaymentTypeController::class);
Route::group(['prefix' => 'order'], function () {
    Route::post('create', [OrderController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
