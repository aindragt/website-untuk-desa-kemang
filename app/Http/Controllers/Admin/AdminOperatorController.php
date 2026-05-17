<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOperatorController extends Controller
{
    public function index()
    {
        $operators = User::where('role', 'operator')->latest()->get();
        return view('admin.operator.index', compact('operators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username|alpha_dash',
            'password' => 'required|string|min:6',
        ], [
            'username.unique'     => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash, dan underscore.',
            'password.min'        => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'password'  => $request->password,
            'role'      => 'operator',
            'is_active' => true,
        ]);

        return back()->with('success', "Akun operator \"{$request->nama}\" berhasil dibuat.");
    }

    public function resetPassword(Request $request, User $operator)
    {
        $request->validate([
            'password_baru' => 'required|string|min:6',
        ], [
            'password_baru.min' => 'Password minimal 6 karakter.',
        ]);

        $operator->update(['password' => $request->password_baru]);

        return back()->with('success', "Password operator \"{$operator->nama}\" berhasil direset.");
    }

    public function toggleActive(User $operator)
    {
        // Jangan sampai akun admin dinonaktifkan dari sini
        if ($operator->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah status akun admin.');
        }

        $operator->update(['is_active' => !$operator->is_active]);

        $status = $operator->fresh()->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun \"{$operator->nama}\" berhasil {$status}.");
    }

    public function destroy(User $operator)
    {
        if ($operator->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $nama = $operator->nama;
        $operator->delete();

        return back()->with('success', "Akun operator \"{$nama}\" berhasil dihapus.");
    }
}
