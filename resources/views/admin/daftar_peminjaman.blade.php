@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Peminjaman Masuk</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 text-left">Kode</th>
                    <th class="px-5 py-3 text-left">Peminjam</th>
                    <th class="px-5 py-3 text-center">Tgl Ambil</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-5 py-4 font-bold text-teal-800">#{{ $item->kode_pinjam }}</td>
                    <td class="px-5 py-4">
                        <div class="font-bold">{{ $item->peminjam->nama_peminjam }}</div>
                        <div class="text-xs text-gray-500">{{ $item->peminjam->user_peminjam }}</div>
                    </td>
                    <td class="px-5 py-4 text-center">{{ \Carbon\Carbon::parse($item->tgl_ambil)->format('d M Y') }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2 py-1 rounded text-xs font-bold
                            {{ $item->status_pinjam == 'Diproses' ? 'bg-yellow-200 text-yellow-800' : '' }}
                            {{ $item->status_pinjam == 'Disetujui' ? 'bg-blue-200 text-blue-800' : '' }}
                            {{ $item->status_pinjam == 'Selesai' ? 'bg-green-200 text-green-800' : '' }}
                            {{ $item->status_pinjam == 'Ditolak' ? 'bg-red-200 text-red-800' : '' }}">
                            {{ $item->status_pinjam }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex justify-center gap-2">

                            {{-- Tombol Detail Pemesanan --}}
                            <a href="{{ route('admin.peminjaman.show', $item->kode_pinjam) }}"
                               class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-xs font-bold">
                                DETAIL
                            </a>

                            {{-- Tombol Konfirmasi Pengembalian (Muncul jika Disetujui) --}}
                            @if($item->status_pinjam == 'Disetujui')
                            <form action="{{ route('admin.peminjaman.return', $item->kode_pinjam) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?');">
                                @csrf @method('PATCH')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold">
                                    TERIMA KEMBALI
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">{{ $peminjaman->links() }}</div>
    </div>
</div>
@endsection