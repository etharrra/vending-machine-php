<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiTransactionController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // Product API Routes
    Route::prefix('products')->group(function () {
        Route::middleware(['abilities:purchase:false,crud:true'])->group(function () {
            Route::get('/', [ApiProductController::class, 'apiIndex']);
            Route::get('/{id}', [ApiProductController::class, 'apiShow']);
            Route::post('/', [ApiProductController::class, 'apiStore']);
            Route::put('/{id}', [ApiProductController::class, 'apiUpdate']);
            Route::delete('/{id}', [ApiProductController::class, 'apiDestroy']);
        });

        Route::post('/{id}/purchase', [ApiProductController::class, 'apiPurchase'])->middleware(['abilities:purchase:true,crud:false']);
    });

    // Transaction API Routes
    Route::prefix('transactions')->group(function () {
        Route::middleware(['abilities:purchase:false,crud:true'])->group(function () {
            Route::get('/', [ApiTransactionController::class, 'apiIndex']);
            Route::get('/{id}', [ApiTransactionController::class, 'apiShow']);
        });
    });
});
