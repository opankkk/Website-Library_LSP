<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Bisa jadi: Nama Siswa, Judul Buku
            $table->integer('amount');     // Bisa jadi: NIS, Stok, Harga
            $table->text('description')->nullable(); // Bisa jadi: Alamat, Sinopsis
            $table->date('date_input');    // Bisa jadi: Tanggal Lahir, Tgl Masuk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
