<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', function () {
    return view('Users',['posts'=>Post::paginate(3)]);
})->name('home');
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');;
Route::post('/register', [RegisterController::class, 'register']);


Route::get('product', [PostController::class, 'create'])->name('product');
Route::post('store', [PostController::class, 'product_store'])->name('store');
Route::get('edit/{id}', [PostController::class, 'product_edit'])->name('edit');
Route::get('delete/{id}', [PostController::class, 'product_delete'])->name('delete');
Route::post('update/{id}', [PostController::class, 'product_update'])->name('update');


