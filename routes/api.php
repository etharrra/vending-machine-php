<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Product API Routes
Route::get('/products', [ApiProductController::class, 'apiIndex']);
Route::get('/products/{id}', [ApiProductController::class, 'apiShow']);
Route::post('/products', [ApiProductController::class, 'apiStore']);
Route::put('/products/{id}', [ApiProductController::class, 'apiUpdate']);
Route::delete('/products/{id}', [ApiProductController::class, 'apiDestroy']);
Route::post('/products/{id}/purchase', [ApiProductController::class, 'apiPurchase']);

// Transaction API Routes
Route::get('/transactions', [ApiTransactionController::class, 'apiIndex']);
Route::get('/transactions/{id}', [ApiTransactionController::class, 'apiShow']);
