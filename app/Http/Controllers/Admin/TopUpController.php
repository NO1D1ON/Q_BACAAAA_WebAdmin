<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    public function index()
    {
        // [PERBAIKAN] Gunakan latest() dengan nama kolom kustom Anda
        $topUps = TopUp::with('user')
                      ->where('status', 'pending')
                      ->latest('waktu_permintaan_topup') // <-- Mengurutkan berdasarkan waktu permintaan
                      ->paginate(10);
                      
        return view('admin.topups.index', compact('topUps'));
    }

    public function approve(TopUp $top_up)
    {
        DB::transaction(function () use ($top_up) {
            $user = $top_up->user;
            $user->increment('saldo', (float) $top_up->nominal);

            // [PERBAIKAN] Update status dan waktu validasi
            $top_up->update([
                'status' => 'success',
                'waktu_validasi_topup' => now() // Mengisi waktu validasi saat ini
            ]);
        });

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil disetujui.');
    }

    public function reject(TopUp $top_up)
    {
        // [PERBAIKAN] Update status dan waktu validasi
        $top_up->update([
            'status' => 'rejected',
            'waktu_validasi_topup' => now() // Mengisi waktu validasi saat ini
        ]);

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil ditolak.');
    }
}
