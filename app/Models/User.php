<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'nama', 'username', 'password', 'role', 'is_active', 'last_login_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active'     => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // -------------------------------------------------------
    // Helper role
    // -------------------------------------------------------
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function getLabelRoleAttribute(): string
    {
        return match ($this->role) {
            'admin'    => 'Administrator',
            'operator' => 'Operator Desa',
            default    => ucfirst($this->role),
        };
    }

    public function getBadgeRoleAttribute(): string
    {
        return $this->role === 'admin' ? 'badge--merah' : 'badge--hijau';
    }

    // -------------------------------------------------------
    // Password
    // -------------------------------------------------------
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }
}
