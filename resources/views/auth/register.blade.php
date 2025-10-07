<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Registrasi | Sidowaras</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --background: #f3f5f7;
            --card-bg: #ffffff;
            --text: #1a1c1e;
            --muted: #6b7176;
            --border: #e2e6ea;
            --primary: #1AB262;
            --primary-hover: #149451;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 0% 100%, rgba(26, 178, 98, 0.08), transparent 45%),
                radial-gradient(circle at 100% 0%, rgba(26, 178, 98, 0.08), transparent 55%),
                var(--background);
            font-family: 'Inter', sans-serif;
            color: var(--text);
            padding: 24px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(26, 178, 98, 0.12);
            display: grid;
            place-items: center;
            font-weight: 600;
            color: var(--primary);
        }

        .brand-text {
            font-size: 20px;
            font-weight: 600;
        }

        .auth-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(20, 23, 28, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
        }

        .auth-card h1 {
            margin: 0 0 12px;
            font-size: 28px;
            font-weight: 600;
        }

        .auth-card p {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 15px;
        }

        .alert {
            background: rgba(221, 72, 72, 0.12);
            border: 1px solid rgba(221, 72, 72, 0.3);
            color: #b32131;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
        }

        .form-control {
            height: 48px;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 0 16px;
            font-size: 15px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(26, 178, 98, 0.7);
            box-shadow: 0 0 0 4px rgba(26, 178, 98, 0.12);
        }

        .invalid-feedback {
            color: #b32131;
            font-size: 13px;
        }

        .primary-btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 16px;
            background: var(--primary);
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
            margin-top: 8px;
        }

        .primary-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .primary-btn:active {
            transform: translateY(0);
        }

        .support-text {
            margin-top: 24px;
            font-size: 13px;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 520px) {
            body {
                padding: 16px;
            }

            .auth-card {
                padding: 28px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="brand">
            <div class="brand-logo">SW</div>
            <div class="brand-text">Sidowaras POS</div>
        </div>
        <div class="auth-card">
            <h1>Buat akun baru</h1>
            <p>Registrasikan karyawan baru dengan memasukkan data yang valid.</p>

            @if ($errors->any())
                <div class="alert">
                    {{ __('Pastikan seluruh bidang diisi dengan benar dan password minimal 8 karakter.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                </div>

                <button type="submit" class="primary-btn">Daftarkan akun</button>
            </form>

            <div class="support-text">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Masuk</a>
            </div>
        </div>
    </div>
</body>

</html>
