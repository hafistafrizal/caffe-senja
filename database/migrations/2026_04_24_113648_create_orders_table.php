<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * KETENTUAN 1 & 3: Database memiliki 4 tabel utama (Users, Menus, Sarans, Orders)
     * Dibuat menggunakan sistem Migration untuk struktur tabel yang rapi.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('rincian_pesanan');
            $table->text('catatan')->nullable();
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
