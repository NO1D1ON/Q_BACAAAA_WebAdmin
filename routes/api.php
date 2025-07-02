<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// [PERBAIKAN #1 - WAJIB] Tambahkan import untuk NotificationController
use App\Http\Controllers\Api\NotificationController; 
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\AdminController; 
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\CollectionController; 
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK (Bisa diakses tanpa login) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('books')->group(function () {
    Route::get('/popular', [ContentController::class, 'getPopularBooks']);
    Route::get('/recommendations', [ContentController::class, 'getRecommendedBooks']);
    Route::get('/new', [ContentController::class, 'getNewBooks']);
    Route::get('/trending', [ContentController::class, 'getTrendingBooks']);
    Route::get('/{book}', [ContentController::class, 'show']); 
});

Route::get('/categories', [ContentController::class, 'getCategories']);
Route::get('/search', [ContentController::class, 'search']);
Route::get('/categories/{category}/books', [ContentController::class, 'getBooksByCategory']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// --- RUTE TERPROTEKSI (Wajib login/mengirim token) ---
// [PERBAIKAN #2 - PENYEDERHANAAN] Gabungkan semua rute pengguna yang terproteksi ke dalam satu grup
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rute notifikasi sekarang akan dikenali karena sudah di-import
    Route::get('/notifications', [NotificationController::class, 'index']);
    
    // Rute untuk pembelian buku
    Route::post('/books/{book}/buy', [PurchaseController::class, 'buyBook']);
    Route::post('/books/{book}/toggle-favorite', [FavoriteController::class, 'toggle']);
    // Rute Koleksi 
    Route::get('/my-books', [CollectionController::class, 'purchased']);
    Route::get('/my-favorites', [CollectionController::class, 'favorites']);

    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/topup', [TopUpController::class, 'store']);
});

// Rute untuk Admin (sudah benar dipisahkan dengan prefix 'admin')
Route::middleware('auth:sanctum')->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/transactions', [AdminController::class, 'getTransactions'])->name('transactions');
    // Route::get('/topups', [AdminController::class, 'getTopUpRequests'])->name('topups.index');
    Route::get('/topups', [TopUpController::class, 'index'])->name('topups.index');
    Route::patch('/topups/{top_up}/approve', [TopUpController::class, 'approve'])->name('topups.approve');
    Route::patch('/topups/{top_up}/reject', [TopUpController::class, 'reject'])->name('topups.reject');
    Route::get('/v1/transactions', [TransactionController::class, 'history'])->name('api.transactions.history');
});