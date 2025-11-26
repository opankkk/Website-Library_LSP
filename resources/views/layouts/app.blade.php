<!DOCTYPE html>
<html lang="id">
<head>
    <title>Perpustakaan Arcadia - Drive Thru System</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&amp;display=swap" rel="stylesheet"/>

    {{-- Menggunakan CDN agar aman saat ujian jika npm error --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    {{-- Tetap keep vite jika environment mendukung --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-figtree">

    {{-- State Global untuk Mobile Menu --}}
    <div x-data="{ mobileNavOpen: false }">

        @include('layouts.navbar')

        {{-- Content Utama --}}
        <main>
            @yield("content")
        </main>

        {{-- MOBILE MENU DRAWER (Tampil saat tombol burger diklik) --}}
        <div x-show="mobileNavOpen"
             x-transition
             class="md:hidden fixed inset-0 z-50 bg-teal-900/95 text-white p-8 flex flex-col space-y-4">

             {{-- Tombol Close --}}
             <button @click="mobileNavOpen = false" class="self-end mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>

             @auth
                {{-- Menu Mobile: Jika Login --}}
                <div class="border-b border-teal-700 pb-4 mb-4">
                    <p class="text-lime-400 text-sm">Halo, {{ Auth::user()->nama_peminjam }}</p>
                </div>
                <a href="{{ route('items.index') }}" class="text-xl font-medium hover:text-lime-400">Koleksi Buku</a>
                <a href="#" class="text-xl font-medium hover:text-lime-400">Riwayat Peminjaman</a>

                {{-- Logout Mobile --}}
                <form action="{{ route('logout') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 py-3 rounded text-center font-bold">Logout</button>
                </form>
             @else
                {{-- Menu Mobile: Jika Belum Login --}}
                <a href="{{ route('login') }}" class="text-xl font-medium hover:text-lime-400">Login</a>
                <a href="#" class="text-xl font-medium hover:text-lime-400">Daftar Member</a>
             @endauth
        </div>
    </div>
</body>
</html>