<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    // Mirip seperti Transaction, kita matikan timestamp otomatis
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nominal',
        'status',
        'waktu_permintaan_topup',
        'waktu_validasi_topup',
    ];

    /**
     * Mendefinisikan relasi ke tabel 'users'
     * Satu TopUp hanya dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}