<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Category: Menghubungkan tabel kategori di database (Ketentuan 3).
 */
class Category extends Model
{
    protected $fillable = ['nama_kategori'];

    // 1 Kategori memiliki banyak Menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}