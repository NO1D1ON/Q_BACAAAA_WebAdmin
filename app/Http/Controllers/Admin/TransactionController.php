<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; // <-- Import model Transaction
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Menggunakan with('user') agar data pengguna ikut terambil (Eager Loading)
        $transactions = Transaction::with('user')->latest('waktu_transaksi')->get();
        
        return view('admin.transactions.index', compact('transactions'));
    }
}