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

// Rute Halaman Depan, akan langsung dialihkan ke halaman login admin
Route::get('/', function () {
    return redirect()->route('login');
});

// ======================================================================
// GRUP RUTE UNTUK ADMIN
// Semua rute di dalam grup ini aman dan hanya bisa diakses oleh admin yang sudah login.
// ======================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // PERBAIKAN: Middleware 'verified' dihapus dari sini untuk menghilangkan redirect loop.
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    // Rute untuk CRUD
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/books', BookController::class);
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/topups', [TopUpController::class, 'index'])->name('admin.topups.index');
    Route::patch('/admin/topups/{top_up}/approve', [TopUpController::class, 'approve'])->name('admin.topups.approve');
    Route::patch('/admin/topups/{top_up}/reject', [TopUpController::class, 'reject'])->name('admin.topups.reject');

    // RUTE API UNTUK DASHBOARD
    Route::get('/admin/api/dashboard-stats', [DashboardStatsController::class, 'index'])->name('admin.api.dashboardStats');
});


// ======================================================================
// GRUP RUTE BAWAAN BREEZE
// Untuk halaman profil admin yang sedang login.
// ======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// File ini berisi semua rute untuk proses otentikasi (halaman login, proses logout, dll)
require __DIR__.'/auth.php';
