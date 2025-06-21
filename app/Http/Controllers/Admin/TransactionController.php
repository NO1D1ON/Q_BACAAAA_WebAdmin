<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TransactionController extends Controller
{
    public function index()
    {
        // 1. Ambil data pembelian, lalu tambahkan atribut custom
        $purchases = Transaction::with(['user', 'book'])
            ->where('status_pembayaran', 'success')
            ->get()
            ->map(function ($transaction) {
                // [PERBAIKAN] Tambahkan properti baru langsung ke objek model
                $transaction->type = 'Pembelian';
                $transaction->display_amount = -$transaction->harga_total;
                $transaction->display_date = $transaction->waktu_transaksi;
                $transaction->description = 'Pembelian: ' . ($transaction->book->title ?? 'Buku Dihapus');
                return $transaction;
            });

        // 2. Ambil data top up, lalu tambahkan atribut custom
        $topUps = TopUp::with('user')
            ->where('status', 'success')
            ->get()
            ->map(function ($topup) {
                // [PERBAIKAN] Tambahkan properti baru langsung ke objek model
                $topup->type = 'Top Up';
                $topup->display_amount = $topup->nominal;
                $topup->display_date = $topup->waktu_permintaan_topup;
                $topup->description = 'Top Up Saldo';
                return $topup;
            });

        // 3. Gabungkan kedua koleksi model Eloquent
        $allTransactions = $purchases->merge($topUps);

        // 4. Urutkan berdasarkan tanggal
        $sortedTransactions = $allTransactions->sortByDesc('display_date');

        // 5. Buat Paginator secara manual. Sekarang itemnya adalah model Eloquent yang memiliki getKey()
        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $sortedTransactions->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $paginatedTransactions = new LengthAwarePaginator(
            $currentPageItems,
            $sortedTransactions->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // 6. Kirim data Paginator ke view
        return view('admin.transactions.index', [
            'transactions' => $paginatedTransactions
        ]);
    }
}
