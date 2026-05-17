<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Panel Desa Kemang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a3a08 0%, #2D5016 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-wrap {
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .login-logo {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: var(--emas);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display);
            font-size: 18px; font-weight: 700;
            color: var(--hijau);
            margin: 0 auto 0.75rem;
        }
        .login-judul {
            font-family: var(--font-display);
            font-size: 1.3rem;
            color: #fff;
            margin-bottom: 0.25rem;
        }
        .login-sub {
            font-family: var(--font-ui);
            font-size: 0.78rem;
            color: rgba(255,255,255,0.55);
        }
        .login-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .login-footer {
            text-align: center;
            margin-top: 1.25rem;
        }
        .login-footer a {
            font-family: var(--font-ui);
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
        }
        .login-footer a:hover { color: var(--emas); }

        /* Info role */
        .role-info {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }
        .role-badge {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.6rem 0.75rem;
            text-align: center;
            font-family: var(--font-ui);
        }
        .role-badge__icon { font-size: 1.1rem; margin-bottom: 2px; }
        .role-badge__nama { font-size: 0.72rem; font-weight: 600; color: var(--teks); }
        .role-badge__desc { font-size: 0.65rem; color: var(--teks-muted); }
    </style>
</head>
<body>
<div class="login-wrap">

    <div class="login-header">
        <div class="login-logo">DK</div>
        <h1 class="login-judul">Panel Desa Kemang</h1>
        <p class="login-sub">Kecamatan Pangkalan Kuras · Kab. Pelalawan</p>
    </div>

    <div class="login-card">

        {{-- Info role --}}
        <div class="role-info">
            <div class="role-badge">
                <div class="role-badge__icon">👑</div>
                <div class="role-badge__nama">Administrator</div>
                <div class="role-badge__desc">Akses penuh</div>
            </div>
            <div class="role-badge">
                <div class="role-badge__icon">🖊️</div>
                <div class="role-badge__nama">Operator Desa</div>
                <div class="role-badge__desc">Akses terbatas</div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert--error" style="margin-bottom:1rem">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert--success" style="margin-bottom:1rem">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       value="{{ old('username') }}"
                       placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn--primary">
                🔐 Masuk ke Panel
            </button>
        </form>
    </div>

    <div class="login-footer">
        <a href="{{ route('home') }}">← Kembali ke website desa</a>
    </div>

</div>
</body>
</html>
