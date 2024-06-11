<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ExchangeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

    //ВАЛЮТЫ
    Route::prefix('currency')->group(function() {
        Route::get('get', [CurrencyController::class, 'get'])->name('currency.get');
        Route::get('id/{id}', [CurrencyController::class, 'id'])->name('currency.id');
    });

    //КУРС ВАЛЮТ
    Route::prefix('exchange')->group(function() {
        Route::get('get', [ExchangeController::class, 'get'])->name('exchange.get');
        Route::get('id/{id}', [ExchangeController::class, 'id'])->name('exchange.id');
        Route::get('id/{id}/{day}', [ExchangeController::class, 'compare'])->name('exchange.compare');
    });

});