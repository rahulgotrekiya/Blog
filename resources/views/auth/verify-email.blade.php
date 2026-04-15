<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Verify your email</h1>
            <p class="auth-subtitle">
                Thanks for signing up! Please click the link in the email we sent you to verify your address.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" style="margin-bottom:20px;">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:16px;">
                @csrf
                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-lg" style="width:100%;background:transparent;border:1px solid #e5e7eb;color:var(--medium-gray);">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</body>
</html>
