<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'is_active' => true])) {
            $request->session()->regenerate();
            
            Auth::user()->update(['last_login_at' => now()]);
            
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()
            ->with('error', 'Username atau password salah, atau akun dinonaktifkan.')
            ->withInput(['username' => $request->username]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'operator' => redirect()->route('operator.dashboard'),
            default    => redirect()->route('login'),
        };
    }
}
