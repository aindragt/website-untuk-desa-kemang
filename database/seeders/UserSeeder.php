<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        User::create([
            'nama'      => 'Administrator',
            'username'  => 'admin',
            'password'  => 'admin123',
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Operator desa contoh
        User::create([
            'nama'      => 'Operator Desa Kemang',
            'username'  => 'operator',
            'password'  => 'operator123',
            'role'      => 'operator',
            'is_active' => true,
        ]);
    }
}
