<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    // Kredensial admin disimpan di .env agar mudah diganti
    // ADMIN_USERNAME=admin
    // ADMIN_PASSWORD=kemang2025

    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $validUser = $request->username === config('admin.username', env('ADMIN_USERNAME', 'admin'));
        $validPass = $request->password === config('admin.password', env('ADMIN_PASSWORD', 'kemang2025'));

        if ($validUser && $validPass) {
            session([
                'admin_logged_in' => true,
                'admin_username'  => $request->username,
            ]);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang di Panel Admin Desa Kemang!');
        }

        return back()->with('error', 'Username atau password salah.')->withInput(['username' => $request->username]);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_username']);
        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
