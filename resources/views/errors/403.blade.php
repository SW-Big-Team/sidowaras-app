<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Dibatasi | Sidowaras POS</title>
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
            --danger: #ef4444;
            --danger-soft: rgba(239, 68, 68, 0.1);
            --warning: #f59e0b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --surface: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fef2f2 0%, #f1f5f9 50%, #faf5ff 100%);
            position: relative;
            overflow: hidden;
            padding: 24px;
        }

        /* Background Elements */
        .bg-pattern {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(circle at 30% 30%, rgba(239, 68, 68, 0.08), transparent 40%),
                radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.08), transparent 40%);
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
            animation: float 18s ease-in-out infinite;
        }

        .shape-1 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.1));
            top: -150px;
            left: -100px;
        }

        .shape-2 {
            width: 280px;
            height: 280px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(124, 58, 237, 0.05));
            bottom: -100px;
            right: -80px;
            animation-delay: -8s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(5deg); }
        }

        /* Card */
        .error-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .error-card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.06),
                0 0 0 1px rgba(0, 0, 0, 0.02);
            animation: cardSlide 0.6s ease-out;
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--danger), var(--warning), var(--danger));
            background-size: 200% 100%;
            animation: gradient 4s ease infinite;
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

        /* Icon */
        .error-icon-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 28px;
        }

        .error-icon-bg {
            position: absolute;
            inset: 0;
            background: var(--danger-soft);
            border-radius: 50%;
            animation: pulse 3s ease-in-out infinite;
        }

        .error-icon {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--danger), #dc2626);
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .error-icon i { font-size: 48px; color: white; }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.3); opacity: 0.1; }
        }

        /* Text */
        .error-badge {
            display: inline-block;
            padding: 6px 16px;
            background: var(--danger-soft);
            color: var(--danger);
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 20px;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .error-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 32px;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 20px;
            border-radius: 14px;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary {
            background: white;
            color: var(--text-dark);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(139, 92, 246, 0.4);
        }

        .btn i { font-size: 18px; }

        /* Logout */
        @auth
        .btn-logout {
            margin-top: 12px;
            background: var(--danger-soft);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }
        @endauth

        /* Footer */
        .error-footer {
            margin-top: 36px;
            padding-top: 20px;
            border-top: 1px dashed var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .footer-brand i { color: var(--primary); font-size: 16px; }

        @media (max-width: 480px) {
            .error-card { padding: 36px 24px; }
            .btn-group { flex-direction: column; }
            .floating-shapes { display: none; }
        }
    </style>
</head>

<body>
    <div class="bg-pattern"></div>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="error-wrapper">
        <div class="error-card">
            <div class="error-icon-wrapper">
                <div class="error-icon-bg"></div>
                <div class="error-icon">
                    <i class="material-symbols-rounded">lock</i>
                </div>
            </div>

            <span class="error-badge">ERROR 403</span>
            <h1 class="error-title">Akses Dibatasi</h1>
            
            <p class="error-message">
                @if($exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    Anda tidak memiliki izin untuk mengakses halaman ini. Sistem keamanan kami membatasi akses demi keamanan data.
                @endif
            </p>

            <div class="btn-group">
                <button onclick="history.back()" class="btn btn-secondary">
                    <i class="material-symbols-rounded">arrow_back</i>
                    Kembali
                </button>
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="material-symbols-rounded">home</i>
                    Beranda
                </a>
            </div>

            @auth
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
                @csrf
                <button type="submit" class="btn btn-secondary btn-logout" style="width: 100%;">
                    <i class="material-symbols-rounded">logout</i>
                    Logout & Ganti Akun
                </button>
            </form>
            @endauth

            <div class="error-footer">
                <div class="footer-brand">
                    <i class="material-symbols-rounded">local_pharmacy</i>
                    Sidowaras POS
                </div>
                <span>Ref: {{ strtoupper(substr(uniqid(), -6)) }}</span>
            </div>
        </div>
    </div>
</body>
</html>