<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Order: Menyediakan data pesanan untuk grafik dan laporan PDF (Ketentuan 5 & 6).
 */
class Order extends Model
{
    protected $fillable = ['user_id', 'rincian_pesanan', 'catatan', 'total_harga', 'status'];
    use HasFactory;

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
