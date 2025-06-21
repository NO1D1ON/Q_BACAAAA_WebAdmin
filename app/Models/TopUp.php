<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    /**
     * [PERBAIKAN #1] Nonaktifkan timestamps otomatis.
     * Ini memberitahu Laravel untuk TIDAK mencari kolom 'created_at' & 'updated_at'.
     */
    public $timestamps = false;

    /**
     * [PERBAIKAN #2] Tentukan konstanta nama kolom kustom Anda.
     * Ini adalah praktik yang baik untuk menghindari salah ketik.
     */
    const CREATED_AT = 'waktu_permintaan_topup';
    const UPDATED_AT = 'waktu_validasi_topup'; // Kita anggap waktu validasi sebagai waktu update

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'nominal',
        'status',
        'waktu_permintaan_topup', // Tambahkan kolom waktu agar bisa diisi
        'waktu_validasi_topup',   // Tambahkan kolom waktu agar bisa diisi
    ];
    
    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
