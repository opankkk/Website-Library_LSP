<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;

class AdminController extends Controller
{

    public function indexBuku()
    {
        $buku = Buku::latest()->paginate(10);
        return view('admin.daftar_buku', compact('buku'));
    }

    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'nama_pengarang' => 'required',
            'nama_penerbit' => 'required',
            'tgl_terbit' => 'required|date',
        ]);

        Buku::create($request->all());
        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function updateBuku(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());
        return back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroyBuku($id)
    {
        Buku::findOrFail($id)->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }


    public function indexPeminjaman()
    {

        $peminjaman = Peminjaman::with('peminjam')
            ->orderByRaw("FIELD(status_pinjam, 'Diproses', 'Disetujui', 'Selesai', 'Ditolak')")
            ->orderBy('tgl_pesan', 'desc')
            ->paginate(10);


        return view('admin.daftar_peminjaman', compact('peminjaman'));
    }


    public function returnBook($kode_pinjam)
    {
        $data = Peminjaman::findOrFail($kode_pinjam);

        if ($data->status_pinjam == 'Disetujui') {
            $data->update([
                'status_pinjam' => 'Selesai',
                'tgl_kembali'   => now(),
                'id_admin'      => Auth::guard('admin')->id()
            ]);
            return back()->with('success', 'Buku telah dikembalikan. Transaksi SELESAI.');
        }
        return back()->with('error', 'Status tidak valid.');
    }



    public function showDetail($kode_pinjam)
    {
        $data = Peminjaman::with(['peminjam', 'buku'])->findOrFail($kode_pinjam);

        return view('admin.detail_pemesanan', compact('data'));
    }


    public function updateStatus(Request $request, $kode_pinjam)
    {
        $data = Peminjaman::findOrFail($kode_pinjam);
        $status = $request->status;


        $updateData = [
            'status_pinjam' => $status,
            'id_admin'      => Auth::guard('admin')->id(),
        ];

        if ($status == 'Disetujui') {
            $request->validate([
                'tgl_wajibkembali' => 'required|date|after:tgl_ambil',
            ]);
            $updateData['tgl_wajibkembali'] = $request->tgl_wajibkembali;
        }

        $data->update($updateData);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Status Peminjaman: ' . strtoupper($status));
    }

    public function removeBook($kode_pinjam, $id_buku)
    {
        $data = Peminjaman::findOrFail($kode_pinjam);

        $data->buku()->detach($id_buku);

        return back()->with('success', 'Buku berhasil dihapus dari pesanan ini.');
    }
    public function userIndex()
    {
        // Ambil semua data peminjam, urutkan terbaru
        $users = \App\Models\Peminjam::latest()->paginate(10);
        return view('admin.daftar_user', compact('users'));
    }

    public function userUpdateStatus($id)
    {
        $user = \App\Models\Peminjam::findOrFail($id);

        // Logic Toggle: Jika 1 jadi 0, Jika 0 jadi 1
        $user->status_peminjam = !$user->status_peminjam;
        $user->save();

        $statusText = $user->status_peminjam ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';

        return back()->with('success', "User atas nama {$user->nama_peminjam} berhasil {$statusText}.");
    }
}