<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'judul_buku',
        'nama_pengarang',
        'nama_penerbit',
        'tgl_terbit',
        'is_available'
    ];

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'detail_peminjaman', 'id_buku', 'kode_pinjam');
    }
}