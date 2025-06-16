<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Import DB facade untuk transaction

class TopUpController extends Controller
{
    public function index()
    {
        // Kita hanya tampilkan yang statusnya masih 'pending'
        $topUps = TopUp::with('user')->where('status', 'pending')->latest('waktu_permintaan_topup')->get();
        return view('admin.topups.index', compact('topUps'));
    }

    public function approve(TopUp $top_up)
    {
        // Gunakan DB Transaction untuk memastikan integritas data
        // Jika salah satu gagal, semua akan dibatalkan
        DB::transaction(function () use ($top_up) {
            // 1. Cari user yang terkait
            $user = $top_up->user;

            // 2. Tambah saldo user
            $user->increment('saldo', $top_up->nominal);

            // 3. Ubah status top-up menjadi 'success'
            $top_up->status = 'success';
            $top_up->waktu_validasi_topup = now();
            $top_up->save();
        });

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil disetujui.');
    }

    public function reject(TopUp $top_up)
    {
        $top_up->status = 'rejected';
        $top_up->waktu_validasi_topup = now();
        $top_up->save();

        return redirect()->route('admin.topups.index')->with('success', 'Top-up berhasil ditolak.');
    }
}