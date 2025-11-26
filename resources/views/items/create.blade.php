@extends('layouts.app')

@section('title', 'Tambah Data')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-teal-900 py-4 px-6">
                <h2 class="text-2xl font-bold text-white">Tambah Data Baru</h2>
            </div>
            
            <div class="p-6">
                {{-- Form mengarah ke route STORE dengan method POST --}}
                <form action="{{ route('items.store') }}" method="POST">
                    
                    {{-- WAJIB: Token keamanan untuk mencegah error 419 Page Expired --}}
                    @csrf

                    {{-- Input Nama --}}
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Item / Siswa</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama...">
                        
                        {{-- Pesan Error Validasi --}}
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grid untuk Jumlah dan Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                        
                        {{-- Input Jumlah/Amount --}}
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah / Nilai</label>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   value="{{ old('amount') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 @error('amount') border-red-500 @enderror">
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Tanggal --}}
                        <div>
                            <label for="date_input" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Input</label>
                            <input type="date" 
                                   name="date_input" 
                                   id="date_input" 
                                   value="{{ old('date_input') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 @error('date_input') border-red-500 @enderror">
                            @error('date_input')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Input Deskripsi --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500"
                                  placeholder="Keterangan tambahan...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('items.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-lime-500 text-white rounded-lg hover:bg-lime-600 transition font-bold shadow-lg">
                            Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection