<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $primaryKey = 'kode_pinjam';

    protected $fillable = [
        'id_peminjam',
        'id_admin',
        'tgl_pesan',
        'tgl_ambil',
        'tgl_wajibkembali',
        'tgl_kembali',
        'status_pinjam'
    ];

    // Relasi ke Member
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam');
    }

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'detail_peminjaman', 'kode_pinjam', 'id_buku');
    }
}