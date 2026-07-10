<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk menangani proses Login & Register (Ketentuan 2 & 7).
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * pendaftaran user baru.
     */
    public function register(Request $request)
    {
        // Validasi input form pendaftaran
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // login setelah daftar
        Auth::login($user);

        // Masuk ke beranda
        return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat bergabung di Cafe Senja.');
    }

    /**
     * Memproses login user.
     */
    public function authenticate(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek email dan password cocok dengan database
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();

            // Cek role user atau admin
            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }
            
            return redirect()->intended('/');
        }

        // login gagal, muncul error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Bersihkan session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}