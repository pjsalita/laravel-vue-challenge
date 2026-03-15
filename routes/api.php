<?php

use App\Http\Controllers\Api\CoffeeMachineController;
use Illuminate\Support\Facades\Route;

Route::prefix('machine')->group(function () {
    Route::get('status', [CoffeeMachineController::class, 'status']);
    Route::get('drinks', [CoffeeMachineController::class, 'drinks']);

    Route::post('fill/{type}', [CoffeeMachineController::class, 'fill']);
    Route::post('brew/{slug}', [CoffeeMachineController::class, 'brew']);
    Route::post('empty/{type}', [CoffeeMachineController::class, 'empty']);
});
