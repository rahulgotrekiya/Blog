<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Reset password</h1>
            <p class="auth-subtitle">Choose a new password for your account.</p>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input @error('email') error @enderror"
                           value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                           placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" name="password" id="password" class="form-input @error('password') error @enderror"
                           required autocomplete="new-password" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-input @error('password_confirmation') error @enderror"
                           required autocomplete="new-password" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>
