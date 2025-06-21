<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function store(Request $request)
    {
        // Validasi ini sudah benar, ia memeriksa input 'amount' dari Flutter
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);
        
        // Ambil data user yang sedang login
        $user = $request->user();

        // Buat entri baru di tabel top_ups
        $user->topUps()->create([
            // [PERBAIKAN DI SINI]
            // Gunakan 'nominal' agar sesuai dengan nama kolom di database Anda.
            // Nilainya tetap diambil dari '$request->amount' yang dikirim Flutter.
            'nominal' => $request->amount, 
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Permintaan top up berhasil dikirim dan sedang diproses.']);
    }
}