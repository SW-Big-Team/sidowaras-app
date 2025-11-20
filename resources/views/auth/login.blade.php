<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | Sidowaras POS</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        :root {
            /* Brand Colors */
            --primary: #1AB262;
            --primary-dark: #148F4E;
            --primary-soft: rgba(26, 178, 98, 0.1);
            --primary-shadow: rgba(26, 178, 98, 0.25);
            
            /* UI Colors */
            --bg-gradient-1: #f0fdf4;
            --bg-gradient-2: #dcfce7;
            
            --surface: rgba(255, 255, 255, 0.85);
            --surface-border: rgba(255, 255, 255, 0.9);
            
            --text-main: #0F172A;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            --border: #E2E8F0;
            
            --error: #EF4444;
            --error-bg: #FEF2F2;
            
            --shadow-xl: 
                0 20px 25px -5px rgba(0, 0, 0, 0.05), 
                0 8px 10px -6px rgba(0, 0, 0, 0.01),
                0 0 0 1px rgba(0, 0, 0, 0.02);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top left, var(--bg-gradient-1), transparent 60%),
                        radial-gradient(circle at bottom right, var(--bg-gradient-2), transparent 60%),
                        #f8fafc;
            overflow: hidden;
            color: var(--text-main);
            position: relative;
            padding: 24px;
        }

        /* Floating Background Shapes */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: -1;
            animation: float 20s infinite alternate;
        }
        .blob-1 { width: 400px; height: 400px; background: #bbf7d0; top: -100px; left: -100px; }
        .blob-2 { width: 300px; height: 300px; background: #86efac; bottom: -50px; right: -50px; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(40px, 60px) rotate(10deg); }
        }

        /* Layout */
        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            perspective: 1000px;
        }

        .auth-card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--surface-border);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: var(--shadow-xl);
            animation: cardEnter 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
            position: relative;
            overflow: hidden;
        }

        /* Top Gradient Line */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #34d399);
        }

        @keyframes cardEnter {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container {
            width: 56px;
            height: 56px;
            background: var(--primary-soft);
            border-radius: 16px;
            display: grid;
            place-items: center;
            margin: 0 auto 16px;
            color: var(--primary);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .header p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Alert */
        .alert {
            background: var(--error-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-group {
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

        .form-control {
            width: 100%;
            height: 50px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: white;
            padding: 0 16px 0 48px; /* padding left for icon */
            font-family: inherit;
            font-size: 15px;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .form-control.is-invalid {
            border-color: var(--error);
            background-image: none; /* remove default icon */
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .invalid-feedback {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        /* Password Toggle */
        .btn-toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            border-radius: 8px;
        }
        
        .btn-toggle-password:hover {
            background: #F1F5F9;
            color: var(--text-main);
        }

        /* Checkbox */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 8px 0 24px;
            font-size: 14px;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
            user-select: none;
        }

        .custom-checkbox input {
            display: none;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            background: white;
            position: relative;
            transition: all 0.2s;
        }

        .custom-checkbox input:checked + .checkmark {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkmark::after {
            content: '✓';
            color: white;
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.2s;
            font-weight: bold;
        }

        .custom-checkbox input:checked + .checkmark::after {
            transform: translate(-50%, -50%) scale(1);
        }

        /* Button */
        .primary-btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: var(--primary);
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px var(--primary-shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .primary-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px var(--primary-shadow);
        }

        .primary-btn:active {
            transform: translateY(0);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--text-muted);
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 32px 24px;
            }
            .blob { display: none; } /* Improve performance on cheap mobile */
        }
    </style>
</head>

<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="header">
                <div class="logo-container">
                    <span class="material-symbols-rounded" style="font-size: 32px;">local_pharmacy</span>
                </div>
                <h1>Selamat Datang</h1>
                <p>Masuk ke dashboard Sidowaras POS</p>
            </div>

            @if ($errors->any())
                <div class="alert">
                    <span class="material-symbols-rounded" style="font-size: 20px;">error</span>
                    <span>Email atau password tidak valid.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">mail</span>
                        <input id="email" type="email" name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="nama@email.com" 
                               required autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="material-symbols-rounded input-icon">lock</span>
                        <input id="password" type="password" name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        
                        <button type="button" class="btn-toggle-password" id="togglePassword" title="Tampilkan password">
                            <span class="material-symbols-rounded" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-row">
                    <label class="custom-checkbox" for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span>Ingat saya</span>
                    </label>
                    </div>

                <button type="submit" class="primary-btn">
                    Masuk Sekarang
                    <span class="material-symbols-rounded">arrow_forward</span>
                </button>
            </form>

            <div class="footer">
                © {{ now()->year }} Apotek Sidowaras. 
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
                    
                    // UX: Keep focus on input
                    passwordInput.focus();
                });
            }
        });
    </script>
</body>
</html>