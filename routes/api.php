<?php

use App\Http\Controllers\AdministrationControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/test', [AdministrationControllers::class, 'test']);
    Route::get('/customer', [AdministrationControllers::class, 'getCustomers']);
    Route::get('/item', [AdministrationControllers::class, 'getItem']);
    Route::get('/transactions', [AdministrationControllers::class, 'dataTransaction']);
    Route::post('/transaction', [AdministrationControllers::class, 'storeJsonTransaction']);
});

Route::get('/transactions', [AdministrationControllers::class, 'dataTransaction']);
