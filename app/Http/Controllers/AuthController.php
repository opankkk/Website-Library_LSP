<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjam;
use App\Models\Admin;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'user_peminjam' => 'required|unique:peminjam,user_peminjam',
            'password'      => 'required|min:4',
            'foto_peminjam' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Foto
        $fotoName = null;
        if ($request->hasFile('foto_peminjam')) {
            $foto = $request->file('foto_peminjam');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/members'), $fotoName);
        }

        // Simpan Data
        Peminjam::create([
            'nama_peminjam'   => $request->nama_peminjam,
            'user_peminjam'   => $request->user_peminjam,
            'password'        => Hash::make($request->password),
            'foto_peminjam'   => $fotoName,
            'tgl_daftar'      => now(),
            'status_peminjam' => 1
        ]);

        return redirect()->route('login')->with('success', 'Registrasi Berhasil! Silakan Login.');
    }

        public function login(Request $request)
        {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            // 1. LOGIN ADMIN
            if (Auth::guard('admin')->attempt(['user_admin' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->route('admin.peminjaman.index');
            }

            // 2. LOGIN MEMBER (PEMINJAM)
            if (Auth::guard('web')->attempt(['user_peminjam' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();

                // INI SUDAH BENAR MENGARAH KE DAFTAR PEMESANAN
                return redirect()->route('peminjaman.index');
            }

            return back()->with('error', 'Username atau Password salah!');
        }
        public function logout(Request $request)
        {
            if(Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
            } elseif(Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
}