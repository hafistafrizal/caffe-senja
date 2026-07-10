<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    // Membuat tabel menu (Ketentuan 1 & 3)
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('nama_menu');
        $table->integer('harga');
        $table->string('image')->nullable();
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
