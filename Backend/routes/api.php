<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BookController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['cors'])->group(function () {
    Route::controller(LoginController::class)->group(function() {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
});



// Route::controller(LoginController::class)->group(function() {
//     Route::post('/register', 'register');
//     Route::post('/login', 'login');
// });


Route::middleware('auth:sanctum')->group(function() {
    Route::controller(BookController::class)->group(function() {
        Route::get('/books/search', 'search');
        Route::post('/books/borrow/{id}', 'borrow');
        Route::post('/books/return/{id}', 'returnBook');
        Route::get('/books/borrowed', 'getBorrowedBooks');
    });
});







Route::middleware('auth:sanctum')->group(function() {
    // Route::post('/logout', [LoginController::class, 'logout']);

    Route::controller(TaskController::class)->group(function() {
        Route::post('/save', 'save');
        Route::get('/get', 'get');
        Route::patch('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });


    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/books', [BookController::class, 'index']);
    });

});
