@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"
     x-data="{
        showModal: false,
        isEdit: false,
        formAction: '',
        formMethod: 'POST',
        judul: '', pengarang: '', penerbit: '', tgl: '',
        resetForm() {
            this.judul=''; this.pengarang=''; this.penerbit=''; this.tgl='';
            this.showModal=false;
        },
        openAdd() {
            this.isEdit = false; this.formAction = '{{ route('admin.buku.store') }}';
            this.formMethod = 'POST'; this.resetForm(); this.showModal = true;
        },
        openEdit(id, judul, pengarang, penerbit, tgl) {
            this.isEdit = true;
            this.formAction = '{{ url('admin/buku') }}/' + id;
            this.formMethod = 'PUT';
            this.judul = judul; this.pengarang = pengarang;
            this.penerbit = penerbit; this.tgl = tgl;
            this.showModal = true;
        }
     }">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Buku</h1>
            <p class="text-gray-500 text-sm">Kelola koleksi perpustakaan.</p>
        </div>
        <button @click="openAdd()" class="bg-lime-500 hover:bg-lime-600 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2 transition transform hover:-translate-y-0.5">
            <span>+</span> Tambah Buku
        </button>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Buku --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead class="bg-teal-900 text-white">
                <tr>
                    <th class="px-5 py-3 text-left text-sm font-bold uppercase tracking-wider">Kode Buku</th>
                    <th class="px-5 py-3 text-left text-sm font-bold uppercase tracking-wider">Judul Buku</th>
                    <th class="px-5 py-3 text-left text-sm font-bold uppercase tracking-wider">Info Penerbitan</th>
                    <th class="px-5 py-3 text-center text-sm font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($buku as $item)
                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- KOLOM 1: KODE BUKU OTOMATIS --}}
                    <td class="px-5 py-4 align-middle">
                        <span class="inline-block px-3 py-1 rounded bg-gray-200 border border-gray-300 text-gray-700 text-xs font-mono font-bold">
                            BK-{{ $item->id_buku }}
                        </span>
                    </td>

                    {{-- KOLOM 2: JUDUL --}}
                    <td class="px-5 py-4 align-middle font-bold text-teal-900">
                        {{ $item->judul_buku }}
                    </td>

                    {{-- KOLOM 3: PENGARANG & PENERBIT --}}
                    <td class="px-5 py-4 align-middle text-sm">
                        <div class="text-gray-900 font-semibold">{{ $item->nama_pengarang }}</div>
                        <div class="text-gray-500 text-xs">
                            {{ $item->nama_penerbit }} • {{ \Carbon\Carbon::parse($item->tgl_terbit)->year }}
                        </div>
                    </td>

                    {{-- KOLOM 4: AKSI --}}
                    <td class="px-5 py-4 text-center align-middle">
                        <div class="flex justify-center gap-2">
                            <button @click="openEdit('{{$item->id_buku}}','{{addslashes($item->judul_buku)}}','{{$item->nama_pengarang}}','{{$item->nama_penerbit}}','{{$item->tgl_terbit}}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold shadow-sm transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.buku.destroy', $item->id_buku) }}" method="POST" onsubmit="return confirm('Hapus buku ini? Data peminjaman terkait mungkin akan hilang.');">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold shadow-sm transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-4 bg-gray-50 border-t">
            {{ $buku->links() }}
        </div>
    </div>

    {{-- MODAL TAMBAH/EDIT (Alpine.js) --}}
    <div x-show="showModal"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
         x-transition.opacity>

        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all scale-100" @click.stop>
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-xl font-bold text-teal-900" x-text="isEdit ? 'Edit Buku' : 'Tambah Buku Baru'"></h2>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form :action="formAction" method="POST">
                @csrf
                <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                {{-- Input Judul --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Buku</label>
                    <input type="text" name="judul_buku" x-model="judul" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-lime-500 focus:border-lime-500 outline-none transition" placeholder="Contoh: Laskar Pelangi" required>
                </div>

                {{-- Grid Pengarang & Penerbit --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pengarang</label>
                        <input type="text" name="nama_pengarang" x-model="pengarang" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-lime-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Penerbit</label>
                        <input type="text" name="nama_penerbit" x-model="penerbit" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-lime-500 outline-none transition" required>
                    </div>
                </div>

                {{-- Input Tanggal --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Terbit</label>
                    <input type="date" name="tgl_terbit" x-model="tgl" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-lime-500 outline-none transition" required>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-teal-900 hover:bg-teal-800 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection