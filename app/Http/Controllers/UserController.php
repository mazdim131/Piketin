<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'username' => ['required', 'min:3', 'unique:ms_user,username'],
            'email' => ['required', 'email:rfc', 'unique:ms_user,email'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed', Password::min(8)->max(20)],
            'password_confirmation' => ['required'],
            'token' => ['required'],
            [
                'username.required' => 'Username wajib diisi!',
                'username.min' => 'Username minimal 3 karakter',
                'username.unique' => 'Username sudah terdaftar',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email yang diinput sudah terdaftar',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 8 karakter',
                'password.max' => 'Password maximal 20 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'token.required' => 'Token wajib diisi!',
            ],
        ]);

        $createAccount = User::create([
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'role' => 'siswa',
            'id_kelas' => null,
            'id_jadwal_piket' => null,
            'token' => $validate['token'],
        ]);

        return redirect()->route('login')->with('success', 'Berhasil membuat akun! Silahkan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login Berhasil! Selamat Datang');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function home()
    {
        return view('layouts.app');
    }

    public function attendance(Request $request) {
        $validate = $request->validate([
            'password' => ['required'],
            [
                'password.required' => 'Password wajib diisi!',
            ]
        ]);
    }
}
