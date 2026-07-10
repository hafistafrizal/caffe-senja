<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk Admin
        User::updateOrCreate(
            ['email' => 'adminsenja@gmail.com'],
            [
                'name' => 'Admin Caffe Senja',
                'password' => Hash::make('adminsenja123'),
                'role' => 'admin',
            ]
        );

        // Data untuk User (Pelanggan)
        User::updateOrCreate(
            ['email' => 'guest@gmail.com'],
            [
                'name' => 'Guest (User)', 
                'password' => Hash::make('guest123'),
                'role' => 'user', 
            ]
        );

        User::updateOrCreate(
            ['email' => 'adel@gmail.com'],
            [
                'name' => 'Adelia Rahmawati', 
                'password' => Hash::make('adel123'),
                'role' => 'user', 
            ]
        );
    }
}