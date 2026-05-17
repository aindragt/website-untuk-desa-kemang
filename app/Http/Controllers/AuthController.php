<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session('user_id')) {
            return $this->redirectByRole(session('user_role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)
                    ->where('is_active', true)
                    ->first();

        if (!$user || !$user->checkPassword($request->password)) {
            return back()
                ->with('error', 'Username atau password salah.')
                ->withInput(['username' => $request->username]);
        }

        // Simpan info user ke session
        session([
            'user_id'       => $user->id,
            'user_nama'     => $user->nama,
            'user_username' => $user->username,
            'user_role'     => $user->role,
        ]);

        // Update last login
        $user->update(['last_login_at' => now()]);

        return $this->redirectByRole($user->role);
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_nama', 'user_username', 'user_role']);
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
