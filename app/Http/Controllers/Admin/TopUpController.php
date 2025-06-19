<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    public function index()
    {
        // --- PERBAIKAN: Pastikan 'with('user')' digunakan untuk mengambil data relasi ---
        $topUps = TopUp::with('user')->where('status', 'pending')->latest('waktu_permintaan_topup')->get();
        return view('admin.topups.index', compact('topUps'));
    }

    public function approve(TopUp $top_up)
    {
        DB::transaction(function () use ($top_up) {
            // Memuat relasi user untuk memastikan datanya ada
            $top_up->load('user');
            
            $user = $top_up->user;
            // Melakukan casting ke float untuk keamanan
            $user->increment('saldo', (float) $top_up->nominal);

            $top_up->status = 'success';
            $top_up->waktu_validasi_topup = now();
            $top_up->save();
        });

        return redirect()->route('topups.index')->with('success', 'Top-up berhasil disetujui.');
    }

    public function reject(TopUp $top_up)
    {
        $top_up->status = 'rejected';
        $top_up->waktu_validasi_topup = now();
        $top_up->save();

        return redirect()->route('topups.index')->with('success', 'Top-up berhasil ditolak.');
    }
}