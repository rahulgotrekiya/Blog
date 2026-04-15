<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirm Password — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('home') }}" style="display:block;text-align:center;margin-bottom:32px;">
                <span style="font-family:var(--font-serif);font-size:36px;font-weight:700;color:var(--black);">Blog.</span>
            </a>
            <h1>Confirm password</h1>
            <p class="auth-subtitle">
                This is a secure area. Please confirm your password before continuing.
            </p>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-input @error('password') error @enderror"
                           required autocomplete="current-password" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">
                    Confirm
                </button>
            </form>
        </div>
    </div>
</body>
</html>
