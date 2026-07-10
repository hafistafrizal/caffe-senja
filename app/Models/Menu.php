<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Menu: Menghubungkan tabel menu dan mendefinisikan relasinya (Ketentuan 3).
 */
class Menu extends Model
{
    // Tambahkan 'category_id' ke dalam fillable
    protected $fillable = ['category_id', 'nama_menu', 'harga', 'deskripsi', 'image'];

    // 1 Menu dimiliki oleh 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}