<?php

use App\Http\Controllers\Api\productController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('home', productController::class); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');