<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Welcome back.</h1>
            <p class="auth-subtitle">Sign in to continue reading and writing.</p>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input" required placeholder="••••••••">
                </div>

                <div class="form-group" style="display:flex;justify-content:space-between;align-items:center;">
                    <label class="form-check" style="font-size:14px;">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:14px;color:var(--medium-gray);">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">Sign in</button>
            </form>

            <p class="auth-footer">
                No account? <a href="{{ route('register') }}">Create one</a>
            </p>

            <div style="display:flex;align-items:center;gap:12px;margin:20px 0 16px;">
                <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;">
                <span style="font-size:13px;color:var(--medium-gray);white-space:nowrap;">or continue with</span>
                <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;">
            </div>

            <a href="{{ route('auth.google.redirect') }}"
               style="display:flex;align-items:center;justify-content:center;gap:10px;
                      width:100%;padding:11px 16px;border:1.5px solid #e5e7eb;border-radius:8px;
                      background:#fff;font-size:15px;font-weight:500;color:#374151;
                      text-decoration:none;transition:background 0.15s,border-color 0.15s;"
               onmouseover="this.style.background='#f9fafb';this.style.borderColor='#d1d5db';"
               onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb';">
                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" fill="#FFC107"/>
                    <path d="M6.306 14.691l6.571 4.819C14.655 15.108 19.001 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z" fill="#FF3D00"/>
                    <path d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0124 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" fill="#4CAF50"/>
                    <path d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" fill="#1976D2"/>
                </svg>
                Sign in with Google
            </a>
        </div>
    </div>
</body>
</html>
