@extends('layouts.app')

@section('title', 'Login - Arcadia Library')

@section('content')

<div x-data="{ showRegisterModal: {{ $errors->has('register_error') || $errors->has('nama_peminjam') ? 'true' : 'false' }} }"
     class="w-full">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <div class="hidden lg:flex lg:w-1/2 bg-teal-900 flex-col justify-between p-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="relative z-10 mt-10">
                <div class="text-lime-400 font-bold text-xl tracking-wider mb-2">ARCADIA LIBRARY</div>
                <h1 class="text-white text-5xl font-bold leading-tight">
                Administrator <br> Book Service </h1>
                <p class="text-teal-200 mt-4 text-lg max-w-md">
                    Kelola data peminjaman, persetujuan buku, dan manajemen pustaka dalam satu pintu.                </p>

                <div class="mt-8 flex gap-4">
                    <div class="bg-teal-800 p-4 rounded-lg">
                        <span class="block text-2xl font-bold text-white">24/7</span>
                        <span class="text-xs text-teal-300">Akses Online</span>
                    </div>
                    <div class="bg-teal-800 p-4 rounded-lg">
                        <span class="block text-2xl font-bold text-white">Fast</span>
                        <span class="text-xs text-teal-300">Response</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-teal-200 text-sm">
                &copy; 2025 Arcadia Admin System. Restricted Access.
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white relative">

            <div class="lg:hidden absolute top-0 left-0 w-full h-2 bg-teal-900"></div>

            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-gray-500">Silakan login (Admin / Anggota).</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border-l-4 border-red-500 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                @if(session('success'))
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 text-sm border-l-4 border-green-500 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}" class="w-full pl-10 px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-200 transition" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input type="password" name="password" class="w-full pl-10 px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-200 transition" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-teal-900 hover:bg-teal-800 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                        MASUK
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="#" @click.prevent="showRegisterModal = true" class="text-lime-600 font-bold hover:text-lime-700 hover:underline">
                            Daftar Member Baru
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL REGISTER (HANYA UNTUK MEMBER) --}}
    <div x-show="showRegisterModal"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showRegisterModal = false"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden relative transform transition-all" @click.stop>

                <div class="bg-teal-900 p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-white text-xl font-bold">Pendaftaran Anggota</h3>
                        <p class="text-teal-200 text-sm mt-1">Isi data diri Anda dengan benar</p>
                    </div>
                    <button @click="showRegisterModal = false" class="text-teal-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-8">
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border border-red-200">
                            <strong class="font-bold">Ada kesalahan input:</strong>
                            <ul class="list-disc pl-4 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Sesuai KTP" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Username</label>
                                <input type="text" name="user_peminjam" value="{{ old('user_peminjam') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Tanpa spasi" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Min. 4 karakter" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Foto Identitas</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 hover:bg-gray-50 hover:border-teal-300 rounded-lg cursor-pointer transition">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-teal-500">Pilih Foto</p>
                                    </div>
                                    <input type="file" name="foto_peminjam" class="opacity-0" required>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center">*Format: JPG/PNG, Max 2MB.</p>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="showRegisterModal = false" class="px-5 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-lime-500 hover:bg-lime-600 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection