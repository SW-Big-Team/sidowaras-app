<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | Sidowaras POS</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        :root {
            /* Brand Colors */
            --primary: #1AB262;
            --primary-dark: #148F4E;
            --primary-soft: rgba(26, 178, 98, 0.1);
            --accent: #3B82F6; /* Blue accent for "Lost/Sky" feel */
            
            /* UI Colors */
            --bg-gradient-1: #f0fdf4;
            --bg-gradient-2: #eff6ff; /* Slight blue tint for 404 */
            
            --surface: rgba(255, 255, 255, 0.85);
            --surface-border: rgba(255, 255, 255, 0.9);
            
            --text-main: #0F172A;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            
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
            background: radial-gradient(circle at top right, var(--bg-gradient-1), transparent 60%),
                        radial-gradient(circle at bottom left, var(--bg-gradient-2), transparent 60%),
                        #f8fafc;
            overflow: hidden;
            color: var(--text-main);
            position: relative;
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
        .blob-1 { width: 350px; height: 350px; background: #bbf7d0; top: -50px; right: -50px; }
        .blob-2 { width: 300px; height: 300px; background: #bfdbfe; bottom: -50px; left: -50px; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(30px, 50px) rotate(10deg); }
        }

        /* Main Container */
        .container {
            width: 100%;
            max-width: 480px;
            padding: 24px;
            perspective: 1000px;
        }

        .card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--surface-border);
            border-radius: 32px;
            padding: 48px 32px;
            text-align: center;
            box-shadow: var(--shadow-xl);
            animation: cardEnter 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
            position: relative;
            overflow: hidden;
        }

        /* Top Gradient Line */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
        }

        @keyframes cardEnter {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Illustration Area */
        .illustration {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 32px;
            display: grid;
            place-items: center;
        }

        .illustration-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            background: var(--primary-soft);
            border-radius: 50%;
            animation: radar 3s infinite ease-out;
        }
        
        .illustration-circle::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border: 2px solid var(--primary);
            border-radius: 50%;
            opacity: 0.1;
            animation: radar 3s infinite ease-out 1s;
        }

        .illustration-icon {
            font-size: 64px;
            color: var(--primary);
            position: relative;
            z-index: 2;
        }

        @keyframes radar {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* Text Content */
        .status-code {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 12px;
            display: inline-block;
            padding: 6px 12px;
            background: var(--primary-soft);
            border-radius: 100px;
        }

        h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.2;
            background: linear-gradient(135deg, var(--text-main), #475569);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            color: var(--text-muted);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* Buttons Group */
        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 24px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 8px;
            cursor: pointer;
            flex: 1;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(26, 178, 98, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(26, 178, 98, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--text-main);
            border: 1px solid #E2E8F0;
        }

        .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            transform: translateY(-2px);
        }

        .btn .icon {
            font-size: 20px;
        }

        /* Footer Info */
        .footer-info {
            margin-top: 48px;
            padding-top: 24px;
            border-top: 1px dashed #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-light);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .actions {
                flex-direction: column-reverse;
            }
            .btn {
                width: 100%;
            }
            .card {
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container">
        <div class="card">
            <div class="illustration">
                <div class="illustration-circle"></div>
                <span class="material-symbols-rounded illustration-icon">
                    wrong_location
                </span>
            </div>

            <div class="status-code">Error 404</div>
            <h1>Halaman Tidak Ditemukan</h1>
            
            <p>
                Maaf, kami tidak dapat menemukan halaman yang Anda cari. Halaman mungkin telah dipindahkan, dihapus, atau link yang Anda tuju salah.
            </p>

            <div class="actions">
                <button onclick="history.back()" class="btn btn-secondary">
                    <span class="material-symbols-rounded icon">arrow_back</span>
                    Kembali
                </button>
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <span class="material-symbols-rounded icon">home</span>
                    Beranda
                </a>
            </div>

            <div class="footer-info">
                <div class="footer-brand">
                    <span class="material-symbols-rounded" style="font-size: 16px; color: var(--primary);">local_pharmacy</span>
                    Sidowaras POS
                </div>
                <div>Ref ID: {{ uniqid() }}</div>
            </div>
        </div>
    </div>
</body>
</html>