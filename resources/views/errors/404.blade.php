<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>404 - Halaman Tidak Ditemukan | Sidowaras</title>
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
            --error: #dc3545;
            --error-light: rgba(220, 53, 69, 0.1);
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
            background: radial-gradient(circle at 0% 100%, rgba(220, 53, 69, 0.08), transparent 45%),
                radial-gradient(circle at 100% 0%, rgba(220, 53, 69, 0.08), transparent 55%),
                var(--background);
            font-family: 'Inter', sans-serif;
            color: var(--text);
            padding: 24px;
        }

        .error-wrapper {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
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

        .error-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 48px 36px;
            box-shadow: 0 20px 60px rgba(20, 23, 28, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 24px;
            background: var(--error-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--error);
        }

        .error-icon svg {
            width: 64px;
            height: 64px;
        }

        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: var(--error);
            margin: 0 0 16px;
            line-height: 1;
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 12px;
            color: var(--text);
        }

        .error-message {
            color: var(--muted);
            font-size: 15px;
            margin: 0 0 32px;
            line-height: 1.6;
        }

        .primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: 16px;
            background: var(--primary);
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .primary-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            color: #ffffff;
            text-decoration: none;
        }

        .primary-btn:active {
            transform: translateY(0);
        }

        .primary-btn svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 520px) {
            body {
                padding: 16px;
            }

            .error-card {
                padding: 36px 24px;
            }

            .error-code {
                font-size: 56px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-icon {
                width: 100px;
                height: 100px;
            }

            .error-icon svg {
                width: 52px;
                height: 52px;
            }
        }
    </style>
</head>

<body>
    <div class="error-wrapper">
        <div class="brand">
            <div class="brand-logo">SW</div>
            <div class="brand-text">Sidowaras POS</div>
        </div>
        <div class="error-card">
            <div class="error-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="error-code">404</h1>
            <h2 class="error-title">Halaman Tidak Ditemukan</h2>
            <p class="error-message">
                Maaf, halaman yang Anda cari tidak ditemukan. Silakan kembali ke beranda atau hubungi administrator jika Anda yakin ini adalah kesalahan.
            </p>
            <a href="{{ url('/') }}" class="primary-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>

</html>

