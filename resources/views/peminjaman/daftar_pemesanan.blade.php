@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-teal-900">Riwayat Peminjaman</h1>
                <p class="text-gray-600">Daftar buku yang sedang dan pernah Anda pinjam.</p>
            </div>
            <a href="{{ route('peminjaman.create') }}" class="bg-lime-500 hover:bg-lime-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transition flex items-center">
                <span class="text-xl mr-2">+</span> Pinjam Buku Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-teal-900 text-white">
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase tracking-wider">Info Pesanan</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase tracking-wider">Buku (Kode & Judul)</th>
                            <th class="px-5 py-3 text-center text-sm font-semibold uppercase tracking-wider">Jadwal</th>
                            <th class="px-5 py-3 text-center text-sm font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($peminjaman as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">

                            <td class="px-5 py-4 align-top">
                                <div class="font-bold text-teal-800 text-lg">#{{ $item->kode_pinjam }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Dipesan: <span class="font-medium">{{ \Carbon\Carbon::parse($item->tgl_pesan)->format('d/m/Y') }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="flex flex-col gap-2">
                                    @foreach($item->buku as $buku)
                                        <div class="flex items-center gap-3">
                                            <span class="flex-shrink-0 px-2 py-1 rounded bg-gray-100 border border-gray-300 text-gray-600 text-xs font-mono font-bold">
                                                BK-{{ $buku->id_buku }}
                                            </span>

                                            <span class="text-sm font-semibold text-gray-800">
                                                {{ $buku->judul_buku }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-5 py-4 text-center align-top">
                                <div class="text-sm font-bold text-gray-800">
                                    Ambil: {{ \Carbon\Carbon::parse($item->tgl_ambil)->format('d/m/Y') }}
                                </div>

                                @if($item->tgl_wajibkembali)
                                    <div class="mt-2 text-sm font-bold text-red-600 border-t border-dashed border-gray-300 pt-1">
                                        Kembali: {{ \Carbon\Carbon::parse($item->tgl_wajibkembali)->format('d/m/Y') }}
                                    </div>
                                @else
                                    <div class="mt-2 text-xs text-gray-400 italic">
                                        (Menunggu Admin)
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center align-top">
                                @php
                                    $statusClass = match($item->status_pinjam) {
                                        'Diproses'  => 'bg-yellow-100 text-yellow-800 border border-yellow-200', // KUNING
                                        'Disetujui' => 'bg-green-100 text-green-800 border border-green-200',   // HIJAU
                                        'Ditolak'   => 'bg-red-100 text-red-800 border border-red-200',       // MERAH
                                        'Selesai'   => 'bg-gray-100 text-gray-800 border border-gray-200',    // ABU
                                        default     => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                    {{ $item->status_pinjam }}
                                </span>
                            </td>

                            {{-- KOLOM 5: Aksi --}}
                            <td class="px-5 py-4 text-center align-top">
                                @if($item->status_pinjam == 'Diproses')
                                    <form action="{{ route('peminjaman.destroy', $item->kode_pinjam) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1 rounded text-xs font-bold border border-red-200 transition">
                                            Batalkan
                                        </button>
                                    </form>
                                @elseif($item->status_pinjam == 'Disetujui')
                                    <span class="text-xs text-teal-600 font-medium italic">Silakan ambil buku</span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <p>Belum ada riwayat peminjaman.</p>
                                    <a href="{{ route('peminjaman.create') }}" class="mt-2 text-lime-600 hover:underline text-sm font-bold">Mulai Pinjam Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50 border-t">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</div>
@endsection