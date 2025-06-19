<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\AdminController; 
use App\Http\Controllers\Api\PurchaseController;// Controller utama untuk konten

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- RUTE AUTENTIKASI ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// --- RUTE KONTEN (Bisa diakses tanpa login) ---

// Mengelompokkan semua rute yang berawalan /books untuk menghindari konflik
Route::prefix('books')->group(function () {
    // Rute spesifik (tanpa parameter) harus didefinisikan di atas.
    Route::get('/popular', [ContentController::class, 'getPopularBooks']);
    Route::get('/recommendations', [ContentController::class, 'getRecommendedBooks']);
    Route::get('/new', [ContentController::class, 'getNewBooks']);
    Route::get('/trending', [ContentController::class, 'getTrendingBooks']);
    
    // Rute umum (dengan parameter) didefinisikan di bagian akhir grup.
    // Ini akan menangani URL seperti /api/books/1, /api/books/5, dll.
    Route::get('/{book}', [ContentController::class, 'show']); 
});

// Rute untuk kategori, hanya ada satu dan sudah benar
Route::get('/categories', [ContentController::class, 'getCategories']);


// --- RUTE TERPROTEKSI (Wajib login/mengirim token) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/transactions', [AdminController::class, 'getTransactions'])->name('transactions');
    Route::get('/topups', [AdminController::class, 'getTopUpRequests'])->name('topups');
    Route::patch('/topups/{top_up}/approve', [AdminController::class, 'approveTopUp'])->name('topups.approve');
    Route::patch('/topups/{top_up}/reject', [AdminController::class, 'rejectTopUp'])->name('topups.reject');
});


// --- RUTE TERPROTEKSI (UNTUK PENGGUNA YANG LOGIN) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rute baru untuk pembelian buku
    Route::post('/books/{book}/buy', [PurchaseController::class, 'buyBook']);
});
