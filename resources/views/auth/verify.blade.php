<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Sidowaras</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            background: white;
            border-radius: 16px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            width: 100%;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1AB262 0%, #149451 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-container svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 12px;
        }

        .subtitle {
            font-size: 15px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #10b981;
        }

        .message-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border-left: 4px solid #1AB262;
        }

        .message-box p {
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .resend-form {
            text-align: center;
        }

        .resend-button {
            background: #1AB262;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .resend-button:hover {
            background: #149451;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 178, 98, 0.4);
        }

        .resend-button:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #1AB262;
        }

        @media (max-width: 480px) {
            .verify-container {
                padding: 32px 24px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <h1>Verify Your Email</h1>
        <p class="subtitle">We've sent a verification link to your email address</p>

        @if (session('resent'))
            <div class="alert-success">
                ✓ A fresh verification link has been sent to your email address.
            </div>
        @endif

        <div class="message-box">
            <p>Before proceeding, please check your email for a verification link. If you did not receive the email, you can request another one below.</p>
        </div>

        <form class="resend-form" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="resend-button">
                Resend Verification Email
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
    </div>
</body>
</html>
