<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
 Route::apiResource('home', ProductController::class);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('store', [AuthController::class, 'product_store'])->name('store');
     Route::post('update/{id}', [AuthController::class, 'product_update'])->name('update');
      Route::get('delete/{id}', [AuthController::class, 'product_delete'])->name('delete');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
?>