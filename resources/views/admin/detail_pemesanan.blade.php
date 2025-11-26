@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <a href="{{ route('admin.peminjaman.index') }}" class="text-gray-500 hover:text-gray-900 mb-4 inline-block">
        &larr; Kembali ke Daftar
    </a>

    <div class="flex flex-col lg:flex-row gap-8">

        <div class="w-full lg:w-1/3">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Peminjam</h2>

                <div class="mb-4">
                    <label class="text-xs text-gray-500 uppercase">Nama Peminjam</label>
                    <p class="font-bold text-lg">{{ $data->peminjam->nama_peminjam }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-500 uppercase">Username</label>
                    <p class="font-medium text-gray-700">{{ $data->peminjam->user_peminjam }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-500 uppercase">Tanggal Ambil</label>
                    <p class="font-bold text-teal-700">{{ \Carbon\Carbon::parse($data->tgl_ambil)->format('d F Y') }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-500 uppercase">Status Saat Ini</label>
                    <div class="mt-1">
                        <span class="px-3 py-1 rounded text-sm font-bold bg-gray-200 text-gray-800">
                            {{ $data->status_pinjam }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="bg-teal-900 px-6 py-4">
                    <h2 class="text-white text-lg font-bold">Daftar Buku Pesanan</h2>
                </div>

                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-100 text-gray-600 border-b">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs uppercase">Judul Buku</th>
                            <th class="px-5 py-3 text-left text-xs uppercase">Pengarang</th>
                            <th class="px-5 py-3 text-center text-xs uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data->buku as $buku)
                        <tr class="border-b">
                            <td class="px-5 py-4 font-bold text-gray-800">{{ $buku->judul_buku }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $buku->nama_pengarang }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($data->status_pinjam == 'Diproses')
                                <form action="{{ route('admin.peminjaman.remove_book', ['kode' => $data->kode_pinjam, 'id_buku' => $buku->id_buku]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus buku ini dari pesanan?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-bold text-xs underline">
                                        Hapus
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs italic">Locked</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-gray-500">
                                Tidak ada buku dalam pesanan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Tindakan Persetujuan</h2>

                @if($data->status_pinjam == 'Diproses')
                    <div class="flex flex-col md:flex-row gap-6 items-start">

                        <div class="w-full md:w-1/3 bg-red-50 p-4 rounded border border-red-100">
                            <h3 class="font-bold text-red-800 mb-2">Tolak Pesanan</h3>
                            <p class="text-xs text-red-600 mb-4">Jika data tidak valid.</p>
                            <form action="{{ route('admin.peminjaman.update_status', ['kode' => $data->kode_pinjam]) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Ditolak">
                                <button class="w-full bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">TOLAK</button>
                            </form>
                        </div>

                        <div class="w-full md:w-2/3 bg-lime-50 p-4 rounded border border-lime-100">
                            <h3 class="font-bold text-teal-900 mb-2">Setujui & Atur Jadwal</h3>
                            <p class="text-xs text-teal-700 mb-4">Tentukan kapan buku ini harus dikembalikan.</p>

                            <form action="{{ route('admin.peminjaman.update_status', ['kode' => $data->kode_pinjam]) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Disetujui">

                                <div class="flex flex-col md:flex-row gap-4 items-end">
                                    <div class="flex-1 w-full">
                                        <label class="block text-xs font-bold text-teal-800 mb-1">Batas Wajib Kembali</label>
                                        <input type="date" name="tgl_wajibkembali" min="{{ $data->tgl_ambil }}" class="w-full border border-lime-500 px-3 py-2 rounded focus:ring-2 focus:ring-lime-500" required>
                                    </div>
                                    <button class="bg-lime-500 text-white px-6 py-2 rounded font-bold hover:bg-lime-600 w-full md:w-auto">
                                        SETUJUI
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded text-center text-gray-500">
                        Status pesanan ini adalah <strong>{{ $data->status_pinjam }}</strong>. Tidak ada tindakan diperlukan.
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection