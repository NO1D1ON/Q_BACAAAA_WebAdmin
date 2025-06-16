<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TopUpController;
use App\Http\Controllers\Api\DashboardStatsController; // <-- TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

// ======================================================================
// GRUP RUTE UNTUK ADMIN
// ======================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    // Rute CRUD
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
// ======================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
