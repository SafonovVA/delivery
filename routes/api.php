<?php

use App\Http\Controllers\Api\CourierController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class)->except('destroy');
Route::get('couriers', CourierController::class);
Route::get('orders/{courierId}/history', [OrderController::class, 'history']);
