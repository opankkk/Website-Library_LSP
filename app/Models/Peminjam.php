<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Peminjam extends Authenticatable
{
    use Notifiable;

    protected $table = 'peminjam';
    protected $primaryKey = 'id_peminjam';

    protected $fillable = [
        'nama_peminjam',
        'user_peminjam',
        'password',
        'foto_peminjam',
        'tgl_daftar',
        'status_peminjam',
    ];


    protected $hidden = [
        'password',
    ];
}