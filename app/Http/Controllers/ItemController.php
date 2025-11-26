<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;  // <--- WAJIB ADA! Jangan sampai lupa import Model ini

class ItemController extends Controller
{
    /**
     * Menampilkan Data (Read)
     */
    public function index()
    {
        // Mengambil data terbaru, dipaginate 10 per halaman (Nilai Plus)
        $items = Item::latest()->paginate(10);
        
        // Mengirim data $items ke view
        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan Form Tambah (Create View)
     */
    public function create()
    {
        // Menampilkan file view form input
        return view('items.create');
    }

    /**
     * Proses Simpan Data (Create Logic)
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name'       => 'required|min:3',
            'amount'     => 'required|numeric',
            'date_input' => 'required|date',
        ]);

        // Simpan ke Database
        Item::create($request->all());

        // Redirect
        return redirect()->route('items.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Menampilkan Form Edit (Edit View)
     */
    public function edit(string $id)
    {
        // Cari data berdasarkan ID, kalau tidak ada error 404
        $item = Item::findOrFail($id);

        return view('items.edit', compact('item'));
    }

    /**
     * Proses Update Data (Update Logic)
     */
    public function update(Request $request, string $id)
    {
        // Validasi ulang
        $request->validate([
            'name'       => 'required|min:3',
            'amount'     => 'required|numeric',
            'date_input' => 'required|date',
        ]);

        $item = Item::findOrFail($id);
        
        // Update data
        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus Data (Delete Logic)
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}