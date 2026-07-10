<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate([
            'nama_kategori' => 'Coffee'
        ]);

        Category::firstOrCreate([
            'nama_kategori' => 'Non-Coffee'
        ]);
    }
}
