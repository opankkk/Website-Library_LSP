<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id('kode_pinjam');
        $table->unsignedBigInteger('id_peminjam');
        $table->unsignedBigInteger('id_admin')->nullable();

        $table->date('tgl_pesan');
        $table->date('tgl_ambil');
        $table->date('tgl_wajibkembali')->nullable();
        $table->date('tgl_kembali')->nullable();

        $table->string('status_pinjam', 20)->default('Diproses');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};