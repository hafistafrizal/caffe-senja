<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Seeds data dummy Menus.
     */

    public function run(): void
    {
        Menu::firstOrCreate([
            'nama_menu' => 'Kopi Senja',
            'harga' => 15000,
            'deskripsi' => 'Kopi susu gula aren',
            'category_id' => 1
        ]);

        Menu::firstOrCreate([
            'nama_menu' => 'Matcha Latte',
            'harga' => 18000,
            'deskripsi' => 'Minuman teh hijau murni',
            'category_id' => 2
        ]);
        Menu::firstOrCreate([
            'nama_menu' => 'Americano',
            'harga' => 11000,
            'deskripsi' => 'Kopi hitam murni',
            'category_id' => 1
        ]);
    }
}
