<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;


class PeminjamanController extends Controller
{
    /**
     * Menampilkan Riwayat / Daftar Pesanan Member
     */
    public function index()
    {
        $peminjaman = Peminjaman::with('buku')
                        ->where('id_peminjam', Auth::id())
                        ->orderBy('tgl_pesan', 'desc')
                        ->paginate(10);

        // INI KUNCINYA: Memanggil resources/views/peminjaman/daftar_pemesanan.blade.php
        return view('peminjaman.daftar_pemesanan', compact('peminjaman'));
    }

    /**
     * Menampilkan Form (Pilih Buku & Tanggal)
     */
    public function create()
    {
        // Kita butuh daftar buku agar user bisa memilih
        $buku = Buku::all();

        return view('peminjaman.formulir_pemesanan', compact('buku'));
    }

    /**
     * Proses Simpan Peminjaman
     */
    public function store(Request $request)
    {
        // 1. Validasi (Hanya Tgl Ambil & Buku)
        $request->validate([
            'tgl_ambil'   => 'required|date|after_or_equal:today',
            'buku_ids'    => 'required|array|min:1',
        ]);

        // 2. Simpan Header (Tanpa tgl_wajibkembali & lama_pinjam)
        $transaksi = Peminjaman::create([
            'id_peminjam'      => Auth::id(),
            'tgl_pesan'        => now(),
            'tgl_ambil'        => $request->tgl_ambil,
            'status_pinjam'    => 'Diproses',
        ]);

        $transaksi->buku()->attach($request->buku_ids);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pesanan berhasil dibuat! Menunggu penetapan tanggal kembali oleh Admin.');
    }

    /**
     * Batalkan Pesanan (Hanya jika masih Diproses)
     */
    public function destroy($kode_pinjam)
    {
        $data = Peminjaman::where('id_peminjam', Auth::id())
                  ->where('kode_pinjam', $kode_pinjam)
                  ->firstOrFail();

        if ($data->status_pinjam !== 'Diproses') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses admin.');
        }

        // Detach (hapus relasi buku) lalu delete transaksi
        $data->buku()->detach();
        $data->delete();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}