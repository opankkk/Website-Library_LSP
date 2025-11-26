<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth:web')->group(function () {

    Route::resource('items', ItemController::class);
});


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function() {

    // A. DAFTAR BUKU (CRUD) -> View: admin/daftar_buku.blade.php
    Route::get('/buku', [AdminController::class, 'indexBuku'])->name('buku.index');
    Route::post('/buku', [AdminController::class, 'storeBuku'])->name('buku.store');
    Route::put('/buku/{id}', [AdminController::class, 'updateBuku'])->name('buku.update');
    Route::delete('/buku/{id}', [AdminController::class, 'destroyBuku'])->name('buku.destroy');

    // B. DAFTAR PEMINJAMAN -> View: admin/daftar_peminjaman.blade.php
    Route::get('/peminjaman', [AdminController::class, 'indexPeminjaman'])->name('peminjaman.index');

    // Aksi: Konfirmasi Pengembalian Buku (Disetujui -> Selesai)
    Route::patch('/peminjaman/{kode}/return', [AdminController::class, 'returnBook'])->name('peminjaman.return');

    // C. DETAIL PEMESANAN -> View: admin/detail_pemesanan.blade.php
    Route::get('/peminjaman/{kode}', [AdminController::class, 'showDetail'])->name('peminjaman.show');

    // Aksi: Update Status (Setujui/Tolak)
    Route::patch('/peminjaman/{kode}/status', [AdminController::class, 'updateStatus'])->name('peminjaman.update_status');

    // Aksi: Hapus Buku dari Pesanan (Jika stok kosong)
    Route::delete('/peminjaman/{kode}/buku/{id_buku}', [AdminController::class, 'removeBook'])->name('peminjaman.remove_book');

});
Route::middleware('auth:web')->group(function () {
    // Resource ini otomatis membuat route bernama 'peminjaman.index'
    Route::resource('peminjaman', PeminjamanController::class);
});