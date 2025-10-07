<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Masuk | Sidowaras</title>
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
            max-width: 420px;
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
            margin-bottom: 20px;
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

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 12px 0 24px;
            font-size: 14px;
            color: var(--muted);
        }

        .remember-row label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
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
            <h1>Masuk ke akun</h1>
            <p>Akses dashboard dan administrasi Sidowaras dengan kredensial yang diberikan admin.</p>

            @if ($errors->any())
                <div class="alert">
                    {{ __('Email atau password tidak valid. Silakan coba lagi.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div style="position:relative;">
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" style="padding-right:48px; z-index:1;">
                        <button type="button" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); border:none; background:transparent; padding:6px; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:2; width:32px; height:32px; border-radius:8px; color:var(--muted);">
                            <!-- eye (visible) -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <!-- eye-off (hidden) -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.79 21.79 0 0 1 5.06-6.44"></path>
                                <path d="M3 3l18 18"></path>
                                <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12"></path>
                                <path d="M14.12 9.88A3 3 0 0 1 9.88 14.12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <script>
                    (function(){
                        var pwd = document.getElementById('password');
                        var btn = document.getElementById('togglePassword');
                        var eyeOpen = document.getElementById('eyeOpen');
                        var eyeClosed = document.getElementById('eyeClosed');

                        if (!pwd || !btn) return;

                        btn.addEventListener('click', function(){
                            var isPassword = pwd.getAttribute('type') === 'password';
                            pwd.setAttribute('type', isPassword ? 'text' : 'password');
                            eyeOpen.style.display = isPassword ? 'none' : '';
                            eyeClosed.style.display = isPassword ? '' : 'none';
                            btn.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
                            btn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
                            // keep focus on input for keyboard users
                            pwd.focus();
                        });
                    })();
                </script>

                <div class="remember-row">
                    <label for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                    <span>Hubungi admin jika lupa password</span>
                </div>

                <button type="submit" class="primary-btn">Masuk</button>
            </form>

            <div class="support-text">
                © {{ now()->year }} Sidowaras. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </div>
</body>

</html>
