<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Desa Kemang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { background: var(--hijau-tua); display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
        .login-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: var(--shadow-lg);
        }
        .login-logo {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: var(--emas);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display);
            font-size: 20px; font-weight: 700;
            color: var(--hijau);
            margin: 0 auto 1rem;
        }
        .login-title {
            text-align: center;
            font-family: var(--font-display);
            font-size: 1.25rem;
            color: var(--teks);
            margin-bottom: 0.25rem;
        }
        .login-sub {
            text-align: center;
            font-family: var(--font-ui);
            font-size: 0.78rem;
            color: var(--teks-muted);
            margin-bottom: 1.75rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">DK</div>
        <h1 class="login-title">Panel Admin</h1>
        <p class="login-sub">Desa Kemang — Kab. Pelalawan</p>

        @if(session('error'))
            <div class="alert alert--error" style="margin-bottom:1rem">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert--success" style="margin-bottom:1rem">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:1rem">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn--primary">🔐 Masuk ke Panel Admin</button>
        </form>

        <p style="text-align:center;font-family:var(--font-ui);font-size:0.75rem;color:var(--teks-muted);margin-top:1.25rem">
            <a href="{{ route('home') }}" style="color:var(--emas)">← Kembali ke website</a>
        </p>
    </div>
</body>
</html>
