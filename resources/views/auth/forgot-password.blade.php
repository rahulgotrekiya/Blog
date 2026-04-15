<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Forgot password?</h1>
            <p class="auth-subtitle">No problem. Enter your email and we'll send you a reset link.</p>

            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom:20px;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input @error('email') error @enderror"
                           value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">
                    Send Reset Link
                </button>
            </form>

            <p class="auth-footer">
                Remembered it? <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>
