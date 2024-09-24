<?php

use App\Http\Controllers\AdministrationControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transaction/create', [AdministrationControllers::class, 'createTransaction'])->name('transaction.create');
Route::get('/transaction', [AdministrationControllers::class, 'showHistory'])->name('transactions.history');
Route::post('/transaction', [AdministrationControllers::class, 'storeTransaction'])->name('transactions.create');

Route::get('/transactions/history', function () {
    return view('transactions.history');
});
