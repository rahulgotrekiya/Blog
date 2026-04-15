<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join Blog — Create your account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Join Blog.</h1>
            <p class="auth-subtitle">Create an account to start writing and reading.</p>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-input" value="{{ old('username') }}" required placeholder="johndoe">
                    @error('username') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required placeholder="your@email.com">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input" required placeholder="••••••••">
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">Create account</button>
            </form>

            <p class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>
