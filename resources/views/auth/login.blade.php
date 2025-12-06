<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Sidowaras POS</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-soft: rgba(139, 92, 246, 0.1);
            --primary-glow: rgba(139, 92, 246, 0.25);
            --success: #10b981;
            --error: #ef4444;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --surface: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
            padding: 24px;
        }

        /* Animated Background */
        .bg-gradient {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(139, 92, 246, 0.15), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.1), transparent 40%),
                radial-gradient(circle at 60% 40%, rgba(59, 130, 246, 0.08), transparent 50%);
            z-index: -1;
        }

        .floating-shapes {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: float 20s ease-in-out infinite;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(124, 58, 237, 0.1));
            top: -200px;
            left: -100px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(5, 150, 105, 0.1));
            bottom: -150px;
            right: -100px;
            animation-delay: -10s;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.05));
            top: 50%;
            right: 10%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        /* Login Card */
        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(0, 0, 0, 0.03);
            animation: cardSlide 0.6s ease-out;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--success), var(--primary));
            background-size: 200% 100%;
            animation: gradient 3s ease infinite;
        }

        @keyframes cardSlide {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Header */
        .login-header { text-align: center; margin-bottom: 36px; }

        .logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px var(--primary-glow);
        }

        .logo-icon i { font-size: 36px; color: white; }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        /* Alert */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            color: var(--error);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .alert-error i { font-size: 20px; }

        /* Form */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 20px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            height: 52px;
            padding: 0 16px 0 48px;
            border: 2px solid var(--border);
            border-radius: 14px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-dark);
            background: white;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .form-input:focus + .input-icon { color: var(--primary); }

        .form-input.is-invalid { border-color: var(--error); }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .password-toggle:hover { background: #f1f5f9; color: var(--text-dark); }

        /* Remember Row */
        .remember-row {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-wrapper input { display: none; }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .checkbox-custom i { font-size: 14px; color: white; opacity: 0; transform: scale(0); transition: all 0.2s; }

        .checkbox-wrapper input:checked + .checkbox-custom {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkbox-wrapper input:checked + .checkbox-custom i { opacity: 1; transform: scale(1); }

        .checkbox-label { font-size: 0.9rem; color: var(--text-muted); }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 14px;
            color: white;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 24px var(--primary-glow);
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px var(--primary-glow);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit i { font-size: 20px; }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .login-footer span { color: var(--primary); font-weight: 600; }

        @media (max-width: 480px) {
            .login-card { padding: 36px 24px; }
            .floating-shapes { display: none; }
        }
    </style>
</head>

<body>
    <div class="bg-gradient"></div>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="material-symbols-rounded">local_pharmacy</i>
                </div>
                <h1>Selamat Datang</h1>
                <p>Masuk ke dashboard Sidowaras POS</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="material-symbols-rounded">error</i>
                    <span>Email atau password tidak valid.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" name="email" 
                               class="form-input @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="nama@email.com" 
                               required autofocus>
                        <i class="material-symbols-rounded input-icon">mail</i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" name="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <i class="material-symbols-rounded input-icon">lock</i>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="material-symbols-rounded" id="eyeIcon">visibility</i>
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <label class="checkbox-wrapper" for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkbox-custom">
                            <i class="material-symbols-rounded">check</i>
                        </span>
                        <span class="checkbox-label">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk Sekarang
                    <i class="material-symbols-rounded">arrow_forward</i>
                </button>
            </form>

            <div class="login-footer">
                © {{ now()->year }} <span>Apotek Sidowaras</span>. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordInput && eyeIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
                    passwordInput.focus();
                });
            }
        });
    </script>
</body>
</html>