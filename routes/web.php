<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TopUpController;
use App\Http\Controllers\Api\DashboardStatsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// ======================================================================
// GRUP RUTE UNTUK ADMIN
// [PERBAIKAN] Prefix '/admin' dan nama 'admin.' diletakkan di grup
// agar semua rute di dalamnya otomatis mewarisi.
// ======================================================================
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rute untuk CRUD. URL-nya akan otomatis menjadi /admin/categories, /admin/books, dst.
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    
    // Rute untuk Top Up. Nama rutenya sekarang menjadi 'admin.topups.index', 'admin.topups.approve', dst.
    Route::get('/topups', [TopUpController::class, 'index'])->name('topups.index');
    Route::patch('/topups/{top_up}/approve', [TopUpController::class, 'approve'])->name('topups.approve');
    Route::patch('/topups/{top_up}/reject', [TopUpController::class, 'reject'])->name('topups.reject');

    // Rute ini seharusnya berada di api.php, tapi kita biarkan dulu agar tidak error
    Route::get('/api/dashboard-stats', [DashboardStatsController::class, 'index'])->name('api.dashboardStats');
});


// ======================================================================
// GRUP RUTE BAWAAN BREEZE
// ======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';