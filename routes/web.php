<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TopUpController;
// [PERBAIKAN] Arahkan ke controller yang benar di dalam folder Admin
use App\Http\Controllers\Admin\DashboardStatsController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Grup Rute untuk Admin Panel
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Resource routes untuk CRUD
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    
    // Rute Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
    // Rute Transaksi & Top Up
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/topups', [TopUpController::class, 'index'])->name('topups.index');
    Route::patch('/topups/{top_up}/approve', [TopUpController::class, 'approve'])->name('topups.approve');
    Route::patch('/topups/{top_up}/reject', [TopUpController::class, 'reject'])->name('topups.reject');

    // [PERBAIKAN] Rute API untuk statistik dashboard, sekarang dilayani oleh controller yang benar.
    Route::get('/api/dashboard-stats', [DashboardStatsController::class, 'index'])->name('api.dashboardStats');
});

// Rute Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';