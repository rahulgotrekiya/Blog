<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'A modern blogging platform for writers and readers.')">

    <title>@yield('title', config('app.name', 'Blog'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="navbar-brand">Blog.</a>

            <ul class="navbar-nav">
                @auth
                    <li><a href="{{ route('post.create') }}" class="nav-link">Write</a></li>
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a></li>
                    @endif
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="nav-link" onclick="this.parentElement.classList.toggle('open')">
                            @if(auth()->user()->avatarUrl())
                                <img src="{{ auth()->user()->avatarUrl() }}" class="avatar" alt="{{ auth()->user()->name }}" referrerpolicy="no-referrer">
                            @else
                                <span class="avatar avatar-placeholder">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.public', auth()->user()->username) }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('dashboard') }}" class="dropdown-item">My Stories</a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Settings</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;font-family:var(--font-sans);font-size:14px;color:var(--medium-gray);">Sign out</button>
                            </form>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="nav-link">Sign in</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-dark btn-sm">Get started</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container" style="padding-top:16px;">
            <div class="alert alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container" style="padding-top:16px;">
            <div class="alert alert-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @hasSection('hide_footer')
    @else
        <footer class="footer">
            <div class="footer-inner">
                <span class="footer-brand">Blog.</span>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy</a></li>
                </ul>
            </div>
        </footer>
    @endif

    @yield('scripts')
</body>
</html>
