@extends('layouts.app')

@section('title', 'Formulir Peminjaman')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">

        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-teal-900 py-4 px-6 border-b border-teal-800">
                <h2 class="text-2xl font-bold text-white">Formulir Peminjaman Baru</h2>
                <p class="text-teal-200 text-sm">Pilih buku dan tentukan tanggal pengambilan drive-thru.</p>
            </div>

            <form action="{{ route('peminjaman.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- KOLOM KIRI: DATA PEMINJAM & TANGGAL --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Data Peminjaman</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Peminjam</label>
                            <input type="text" value="{{ Auth::user()->nama_peminjam }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 text-gray-500 cursor-not-allowed">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-800 mb-1">Tanggal Ambil (Rencana)</label>
                            <input type="date" name="tgl_ambil" min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-lime-500 focus:outline-none" required>
                            <p class="text-xs text-gray-500 mt-1">*Pastikan Anda bisa datang pada tanggal ini.</p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: PILIH BUKU --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. Pilih Buku</h3>

                        <div class="h-64 overflow-y-auto border border-gray-200 rounded p-2 bg-gray-50">
                            @if($buku->isEmpty())
                                <p class="text-center text-gray-500 py-4">Belum ada buku tersedia.</p>
                            @else
                                <div class="space-y-2">
                                    @foreach($buku as $item)
                                    <label class="flex items-start p-3 bg-white border border-gray-200 rounded hover:bg-lime-50 cursor-pointer transition">
                                        {{-- Checkbox Array --}}
                                        <input type="checkbox" name="buku_ids[]" value="{{ $item->id_buku }}" class="mt-1 w-4 h-4 text-lime-600 border-gray-300 rounded focus:ring-lime-500">

                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800">{{ $item->judul_buku }}</span>
                                            <span class="block text-xs text-gray-500">{{ $item->nama_pengarang }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-right">Boleh memilih lebih dari satu.</p>
                        @error('buku_ids')
                            <p class="text-red-500 text-xs mt-1 text-right">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-4">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition font-medium">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-lime-500 hover:bg-lime-600 text-white font-bold rounded shadow-lg transition transform hover:-translate-y-0.5">
                        Ajukan Peminjaman
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection