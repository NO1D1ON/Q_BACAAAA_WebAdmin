<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Mengambil daftar semua transaksi.
     */
    public function getTransactions()
    {
        $transactions = Transaction::with('user:id,nama')->latest('waktu_transaksi')->get();
        return response()->json($transactions);
    }

    /**
     * Mengambil daftar permintaan top-up yang masih pending.
     */
    public function getTopUpRequests()
    {
        $topUps = TopUp::with('user:id,nama')->where('status', 'pending')->latest('waktu_permintaan_topup')->get();
        return response()->json($topUps);
    }

    /**
     * Menyetujui permintaan top-up.
     */
    public function approveTopUp(TopUp $top_up)
    {
        // Gunakan DB Transaction untuk memastikan integritas data
        DB::transaction(function () use ($top_up) {
            $user = $top_up->user;
            $user->increment('saldo', $top_up->nominal);

            $top_up->status = 'success';
            $top_up->waktu_validasi_topup = now();
            $top_up->save();
        });

        return response()->json(['message' => 'Top-up berhasil disetujui.', 'data' => $top_up]);
    }

    /**
     * Menolak permintaan top-up.
     */
    public function rejectTopUp(TopUp $top_up)
    {
        $top_up->status = 'rejected';
        $top_up->waktu_validasi_topup = now();
        $top_up->save();

        return response()->json(['message' => 'Top-up berhasil ditolak.', 'data' => $top_up]);
    }
}