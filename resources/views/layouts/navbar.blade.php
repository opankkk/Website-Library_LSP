<div class="relative bg-teal-900 shadow-md z-40">
    <nav class="py-4 md:py-6">

        <div class="w-full px-4 sm:px-8 lg:px-16">

            <div class="flex items-center justify-between">

                {{-- LEFT (Logo) --}}
                <div class="flex-1">
                    {{-- Logika Link Logo: Kalau Admin ke Dashboard, Kalau Member/Tamu ke Login/Home --}}
                    <a href="{{ Auth::guard('admin')->check() ? route('admin.peminjaman.index') : route('login') }}" class="flex items-center gap-2">
                        <span class="text-white font-bold text-lg tracking-widest hover:text-lime-400 transition">
                            LIOBRARY
                        </span>
                    </a>
                </div>

                {{-- CENTER (Menu Dinamis) --}}
                <div class="hidden md:flex flex-1 justify-center">
                    <ul class="flex space-x-8 items-center">

                        @if(Auth::guard('admin')->check())
                            {{-- === MENU KHUSUS ADMIN === --}}
                            <li>
                                <a class="{{ request()->routeIs('admin.buku.*') ? 'text-lime-400 font-bold' : 'text-white font-medium' }} hover:text-lime-400 transition"
                                   href="{{ route('admin.buku.index') }}">
                                    Kelola Buku
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('admin.peminjaman.*') ? 'text-lime-400 font-bold' : 'text-white font-medium' }} hover:text-lime-400 transition"
                                   href="{{ route('admin.peminjaman.index') }}">
                                    Daftar Peminjaman
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('admin.users.*') ? 'text-lime-400 font-bold' : 'text-white font-medium' }} hover:text-lime-400 transition"
                                   href="{{ route('admin.users.index') }}">
                                    Daftar Member
                                </a>
                            </li>

                        @elseif(Auth::guard('web')->check())
                            {{-- === MENU KHUSUS MEMBER === --}}
                            <li>
                                {{-- Arahkan ke form peminjaman baru --}}
                                <a class="{{ request()->routeIs('peminjaman.create') ? 'text-lime-400 font-bold' : 'text-white font-medium' }} hover:text-lime-400 transition"
                                   href="{{ route('peminjaman.create') }}">
                                    Pinjam Buku
                                </a>
                            </li>
                            <li>
                                {{-- Arahkan ke riwayat --}}
                                <a class="{{ request()->routeIs('peminjaman.index') ? 'text-lime-400 font-bold' : 'text-white font-medium' }} hover:text-lime-400 transition"
                                   href="{{ route('peminjaman.index') }}">
                                    Riwayat Pinjam
                                </a>
                            </li>

                        @else
                            {{-- === MENU TAMU (BELUM LOGIN) === --}}
                            <li>
                                <a class="text-white font-medium hover:text-lime-400 transition" href="#">Tentang Kami</a>
                            </li>
                            <li>
                                <a class="text-white font-medium hover:text-lime-400 transition" href="#">Cara Pinjam</a>
                            </li>
                        @endif

                    </ul>
                </div>

                {{-- RIGHT (User Profile & Logout) --}}
                <div class="flex-1 flex justify-end items-center space-x-4">

                    {{-- Cek apakah ada user login (baik Admin ATAU Member) --}}
                    @if(Auth::guard('admin')->check() || Auth::guard('web')->check())
                        <div class="hidden md:flex items-center gap-4">

                            {{-- Tampilkan Nama Sesuai Role --}}
                            <div class="text-right">
                                <span class="block text-xs text-teal-200">
                                    {{ Auth::guard('admin')->check() ? 'Administrator' : 'Member' }}
                                </span>
                                <span class="block text-sm font-bold text-white">
                                    {{-- Logika Penampilan Nama --}}
                                    @if(Auth::guard('admin')->check())
                                        {{ Auth::guard('admin')->user()->nama_admin }}
                                    @else
                                        {{ Auth::user()->nama_peminjam }}
                                    @endif
                                </span>
                            </div>

                            {{-- Form Logout --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="py-2 px-4 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-full transition shadow-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Jika Belum Login --}}
                        <div class="hidden md:block">
                            <a class="inline-flex group py-2.5 px-6 text-sm font-bold text-teal-900 bg-lime-400 hover:bg-lime-300 rounded-full transition shadow-lg"
                               href="{{ route('login') }}">
                                <span>Login</span>
                            </a>
                        </div>
                    @endif

                    {{-- Mobile Menu Trigger --}}
                    <button class="md:hidden text-white hover:text-lime-500 focus:outline-none"
                            x-on:click="mobileNavOpen = !mobileNavOpen">
                        <svg width="32" height="32" fill="none" viewBox="0 0 32 32">
                            <path d="M5.2 23.2H26.8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M5.2 16H26.8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M5.2 8.8H26.8"  stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>
</div>