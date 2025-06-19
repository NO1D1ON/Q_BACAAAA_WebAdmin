<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'nominal',
        'status',
        'waktu_permintaan_topup',
        'waktu_validasi_topup',
    ];

    /**
     * Mendefinisikan relasi ke model User.
     * Sebuah TopUp dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}