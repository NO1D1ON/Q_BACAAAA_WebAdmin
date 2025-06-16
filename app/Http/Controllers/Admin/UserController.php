<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan menggunakan model User
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan semua pengguna
    public function index()
    {
        $users = User::latest()->get(); // Mengambil data user dari tabel 'users'
        return view('admin.users.index', compact('users'));
    }

    // Mengubah status aktif/blokir pengguna
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active; // Membalik nilai boolean (true jadi false, false jadi true)
        $user->save();

        $message = $user->is_active ? 'Pengguna berhasil diaktifkan.' : 'Pengguna berhasil diblokir.';

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}