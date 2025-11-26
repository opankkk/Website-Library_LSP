@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Anggota</h1>
            <p class="text-gray-500 text-sm">Kelola status aktif member perpustakaan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead class="bg-teal-900 text-white">
                <tr>
                    <th class="px-5 py-3 text-left text-sm font-bold uppercase tracking-wider">Foto</th>
                    <th class="px-5 py-3 text-left text-sm font-bold uppercase tracking-wider">Data Diri</th>
                    <th class="px-5 py-3 text-center text-sm font-bold uppercase tracking-wider">Tgl Daftar</th>
                    <th class="px-5 py-3 text-center text-sm font-bold uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-center text-sm font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50 transition {{ $user->status_peminjam ? '' : 'bg-red-50' }}">

                    {{-- KOLOM 1: FOTO --}}
                    <td class="px-5 py-4 align-middle">
                        <div class="flex-shrink-0 w-12 h-12">
                            @if($user->foto_peminjam)
                                <img class="w-full h-full rounded-full object-cover border-2 border-gray-200"
                                     src="{{ asset('uploads/members/' . $user->foto_peminjam) }}"
                                     alt="Foto User">
                            @else
                                <div class="w-full h-full rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold">
                                    {{ substr($user->nama_peminjam, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </td>

                    {{-- KOLOM 2: DATA DIRI --}}
                    <td class="px-5 py-4 align-middle">
                        <p class="text-gray-900 font-bold whitespace-no-wrap">
                            {{ $user->nama_peminjam }}
                        </p>
                        <p class="text-gray-500 text-xs">
                            Username: <span class="font-mono text-teal-700">{{ $user->user_peminjam }}</span>
                        </p>
                    </td>

                    {{-- KOLOM 3: TGL DAFTAR --}}
                    <td class="px-5 py-4 text-center align-middle text-sm">
                        {{ \Carbon\Carbon::parse($user->tgl_daftar)->format('d M Y') }}
                    </td>

                    {{-- KOLOM 4: STATUS --}}
                    <td class="px-5 py-4 text-center align-middle">
                        @if($user->status_peminjam)
                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative text-xs">AKTIF</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                <span class="relative text-xs">NONAKTIF</span>
                            </span>
                        @endif
                    </td>

                    {{-- KOLOM 5: AKSI (TOGGLE) --}}
                    <td class="px-5 py-4 text-center align-middle">
                        <form action="{{ route('admin.users.status', $user->id_peminjam) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            @if($user->status_peminjam)
                                {{-- Tombol Matikan --}}
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded border border-red-300 text-xs font-bold transition" onclick="return confirm('Nonaktifkan member ini? Mereka tidak akan bisa login.')">
                                    Nonaktifkan
                                </button>
                            @else
                                {{-- Tombol Hidupkan --}}
                                <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded border border-green-300 text-xs font-bold transition" onclick="return confirm('Aktifkan kembali member ini?')">
                                    Aktifkan
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-gray-50 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection