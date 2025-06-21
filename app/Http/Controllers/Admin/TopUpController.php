<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Notification; // Pastikan import Notification ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    /**
     * Menampilkan halaman daftar permintaan top up.
     */
    public function index()
    {
        $topUps = TopUp::with('user')->where('status', 'pending')->latest('waktu_permintaan_topup')->paginate(10);
        return view('admin.topups.index', compact('topUps'));
    }

    /**
     * Menyetujui permintaan top up.
     */
    public function approve(TopUp $top_up)
    {
        // [PERBAIKAN UTAMA] Semua logika dipindahkan ke dalam transaction block
        DB::transaction(function () use ($top_up) {
            $user = $top_up->user;

            // 1. Tambah saldo pengguna
            $user->increment('saldo', (float) $top_up->nominal);

            // 2. Update status top up
            $top_up->update([
                'status' => 'success',
                'waktu_validasi_topup' => now()
            ]);

            // 3. Catat ke tabel transactions
            Transaction::create([
                'user_id' => $user->id,
                'order_id' => 'TOPUP-'.strtoupper(uniqid()), 
                'harga_total' => $top_up->nominal,
                'status_pembayaran' => 'success',
                'waktu_transaksi' => now(),
            ]);

            // 4. Buat notifikasi untuk pengguna
            Notification::create([
                'user_id' => $user->id,
                'type' => 'transaksi',
                'title' => 'Top Up Berhasil',
                'message' => 'Selamat! Top up saldo sebesar Rp ' . number_format($top_up->nominal, 0, ',', '.') . ' telah disetujui.',
                'is_read' => false,
            ]);
        });

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil disetujui.');
    }

    /**
     * Menolak permintaan top up.
     */
    public function reject(TopUp $top_up)
    {
        $top_up->update([
            'status' => 'rejected',
            'waktu_validasi_topup' => now()
        ]);
        
        // Buat juga notifikasi penolakan
        Notification::create([
            'user_id' => $top_up->user_id,
            'type' => 'transaksi',
            'title' => 'Top Up Ditolak',
            'message' => 'Maaf, permintaan top up saldo sebesar Rp ' . number_format($top_up->nominal, 0, ',', '.') . ' telah ditolak.',
            'is_read' => false,
        ]);

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil ditolak.');
    }
}
