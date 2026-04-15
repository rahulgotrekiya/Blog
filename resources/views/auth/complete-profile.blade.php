<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Your Profile — Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .onboarding-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
            padding: 32px 16px;
        }
        .onboarding-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 48px 40px;
            width: 100%;
            max-width: 480px;
        }
        .onboarding-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e5e7eb;
        }
        .onboarding-avatar-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #111;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
        }
        .google-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
            font-weight: 500;
            margin-top: 8px;
        }
        .optional-badge {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 400;
            margin-left: 6px;
        }
        .skip-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #9ca3af;
            text-decoration: none;
        }
        .skip-link:hover { color: #6b7280; }
        .password-hint {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="onboarding-wrapper">
        <div class="onboarding-card">
            {{-- Header --}}
            <div style="text-align:center;margin-bottom:32px;">
                @if($user->avatarUrl())
                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="onboarding-avatar" style="margin:0 auto 12px;">
                @else
                    <div class="onboarding-avatar-placeholder" style="margin:0 auto 12px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h1 style="font-size:24px;font-weight:700;color:#111;margin:0 0 4px;">Welcome, {{ $user->name }}! 👋</h1>
                <p style="color:#6b7280;font-size:15px;margin:0 0 8px;">Let's finish setting up your account.</p>
                <span class="google-badge">
                    <svg width="14" height="14" viewBox="0 0 48 48" fill="none"><path d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" fill="#FFC107"/><path d="M6.306 14.691l6.571 4.819C14.655 15.108 19.001 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z" fill="#FF3D00"/><path d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0124 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" fill="#4CAF50"/><path d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" fill="#1976D2"/></svg>
                    Signed in with Google
                </span>
            </div>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('auth.complete-profile') }}">
                @csrf

                {{-- Username --}}
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-prefix">
                        <span>@</span>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-input @error('username') error @enderror"
                            value="{{ old('username', $user->username) }}"
                            required
                            autocomplete="off"
                            placeholder="your-username"
                        >
                    </div>
                    <span class="form-hint">This is your public handle on the platform.</span>
                    @error('username')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="form-group">
                    <label class="form-label" for="bio">
                        Bio <span class="optional-badge">optional</span>
                    </label>
                    <textarea
                        id="bio"
                        name="bio"
                        class="form-textarea @error('bio') error @enderror"
                        rows="2"
                        placeholder="Tell readers a little about yourself..."
                        maxlength="160"
                    >{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password (optional) --}}
                <div class="password-hint">
                    💡 <strong>Set a password</strong> to also be able to log in with your email and password. You can always do this later in Settings.
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        Password <span class="optional-badge">optional</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') error @enderror"
                        autocomplete="new-password"
                        placeholder="Leave blank to skip"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        autocomplete="new-password"
                        placeholder="Repeat password"
                    >
                </div>

                <button type="submit" class="btn btn-dark btn-lg" style="width:100%;margin-top:8px;">
                    Complete Setup
                </button>
            </form>

            <a href="{{ route('dashboard') }}" class="skip-link">Skip for now →</a>
        </div>
    </div>
</body>
</html>
