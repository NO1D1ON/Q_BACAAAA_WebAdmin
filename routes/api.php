<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController; // <-- Menggunakan Controller yang sudah diperbaiki
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\CollectionController; 
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute Kategori (sudah bersih dan tidak konflik)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Rute Konten (buku, search, dll)
Route::get('/books/popular', [ContentController::class, 'getPopularBooks']);
Route::get('/books/recommendations', [ContentController::class, 'getRecommendedBooks']);
Route::get('/books/new', [ContentController::class, 'getNewBooks']);
Route::get('/books/trending', [ContentController::class, 'getTrendingBooks']);
Route::get('/search', [ContentController::class, 'search']);
Route::get('/books/{book}', [ContentController::class, 'show']); // Detail satu buku


/*
|--------------------------------------------------------------------------
| RUTE TERPROTEKSI (Wajib Login dengan Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::get('/notifications', [NotificationController::class, 'index']);
    
    Route::post('/books/{book}/buy', [PurchaseController::class, 'buyBook']);
    Route::post('/books/{book}/toggle-favorite', [FavoriteController::class, 'toggle']);
    
    Route::get('/my-books', [CollectionController::class, 'purchased']);
    Route::get('/my-favorites', [CollectionController::class, 'favorites']);

    Route::post('/topup', [TopUpController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'history']);
});