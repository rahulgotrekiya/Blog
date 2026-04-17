<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — ' . config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ========== ADMIN SHELL ========== */
        body { background: #f5f5f5; }

        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        /* -------- SIDEBAR -------- */
        .adm-sidebar {
            width: 230px;
            flex-shrink: 0;
            background: #1c1c1e;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 200;
        }

        .adm-sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .adm-sidebar-brand h2 {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.2px;
        }

        .adm-sidebar-brand p {
            font-size: 12px;
            color: #888;
            margin-top: 3px;
        }

        .adm-nav {
            list-style: none;
            padding: 16px 0;
            flex: 1;
        }

        .adm-nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            font-size: 14px;
            font-weight: 500;
            color: #888;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }

        .adm-nav-item a svg {
            flex-shrink: 0;
            opacity: 0.6;
            transition: opacity 0.15s ease;
        }

        .adm-nav-item a:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }

        .adm-nav-item a:hover svg { opacity: 1; }

        .adm-nav-item a.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left-color: #fff;
        }

        .adm-nav-item a.active svg { opacity: 1; }

        .adm-nav-divider {
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 8px 0;
        }

        .adm-back-link {
            padding: 16px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .adm-back-link a {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #666;
            transition: color 0.15s ease;
        }

        .adm-back-link a:hover { color: #aaa; }

        /* -------- MAIN AREA -------- */
        .adm-main {
            margin-left: 230px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* -------- TOP BAR -------- */
        .adm-topbar {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #ebebeb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .adm-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #888;
        }

        .adm-breadcrumb a { color: #888; }
        .adm-breadcrumb a:hover { color: #111; }

        .adm-breadcrumb-sep {
            color: #ccc;
        }

        .adm-breadcrumb-current {
            color: #111;
            font-weight: 500;
        }

        .adm-topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adm-user-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 4px 8px 4px 4px;
            border-radius: 999px;
            transition: background 0.15s ease;
            position: relative;
        }

        .adm-user-badge:hover { background: #f5f5f5; }

        .adm-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #1c1c1e;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .adm-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .adm-user-name {
            font-size: 13px;
            font-weight: 500;
            color: #111;
        }

        .adm-user-chevron {
            color: #888;
        }

        /* Dropdown from top-bar user */
        .adm-user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            min-width: 180px;
            padding: 6px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: all 0.15s ease;
            z-index: 300;
        }

        .adm-user-badge.open .adm-user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .adm-user-dropdown a,
        .adm-user-dropdown button {
            display: block;
            width: 100%;
            padding: 9px 16px;
            font-size: 13px;
            color: #333;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font-family: var(--font-sans);
            transition: background 0.1s;
        }

        .adm-user-dropdown a:hover,
        .adm-user-dropdown button:hover { background: #f5f5f5; }

        .adm-user-dropdown-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 4px 0;
        }

        .adm-user-dropdown .signout { color: #c94a4a; }

        /* -------- CONTENT AREA -------- */
        .adm-content {
            padding: 28px 32px;
            flex: 1;
        }

        /* -------- FLASH MESSAGES -------- */
        .adm-flash {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeInUp 0.3s ease-out;
        }
        .adm-flash-success {
            background: #e6f7e6;
            color: #1a8917;
            border: 1px solid #c6e6c6;
        }
        .adm-flash-error {
            background: #fdf2f2;
            color: #c94a4a;
            border: 1px solid #f5d5d5;
        }

        /* ========== DASHBOARD STAT CARDS ========== */
        .adm-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .adm-stat-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            padding: 20px 22px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .adm-stat-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .adm-stat-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 10px;
        }

        .adm-stat-value {
            font-size: 34px;
            font-weight: 700;
            color: #111;
            line-height: 1;
        }

        .adm-stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f0f0f0;
            color: #555;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .adm-stat-badge.green {
            background: #e6f7e6;
            color: #1a8917;
        }

        .adm-stat-badge.blue {
            background: #e8f0fe;
            color: #1a56db;
        }

        .adm-stat-badge.amber {
            background: #fff8e1;
            color: #b45309;
        }

        /* ========== TABLES ========== */
        .adm-table-card {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            overflow: hidden;
        }

        .adm-table-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .adm-table-card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }

        .adm-table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .adm-table-card th {
            text-align: left;
            padding: 11px 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            background: #fafafa;
            border-bottom: 1px solid #f0f0f0;
        }

        .adm-table-card td {
            padding: 13px 20px;
            font-size: 14px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
        }

        .adm-table-card tr:last-child td { border-bottom: none; }

        .adm-table-card tr:hover td { background: #fafafa; }

        .adm-table-card .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* ========== USER AVATAR CIRCLE ========== */
        .adm-avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #1c1c1e;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ========== STATUS BADGES ========== */
        .adm-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 999px;
        }

        .adm-badge-live {
            background: #dcfce7;
            color: #16a34a;
        }

        .adm-badge-draft {
            background: #fef9c3;
            color: #854d0e;
        }

        .adm-badge-admin {
            background: #1c1c1e;
            color: #fff;
        }

        .adm-badge-author {
            background: #f3f4f6;
            color: #555;
            border: 1px solid #e5e7eb;
        }

        .adm-badge-unread {
            background: #fee2e2;
            color: #dc2626;
        }

        .adm-badge-replied {
            background: #e8f0fe;
            color: #1a56db;
            border: 1px solid #c3d9ff;
        }

        /* ========== BUTTONS in admin ========== */
        .adm-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            line-height: 1;
        }

        .adm-btn-dark {
            background: #1c1c1e;
            color: #fff;
        }

        .adm-btn-dark:hover { background: #333; }

        .adm-btn-outline {
            background: transparent;
            color: #333;
            border: 1px solid #ddd;
        }

        .adm-btn-outline:hover {
            border-color: #333;
            background: #f5f5f5;
        }

        .adm-btn-ghost {
            background: transparent;
            color: #888;
            padding: 8px 12px;
        }

        .adm-btn-ghost:hover { background: #f5f5f5; color: #333; }

        .adm-btn-danger { background: #c94a4a; color: #fff; }
        .adm-btn-danger:hover { background: #b33a3a; }

        .adm-btn-sm {
            padding: 5px 12px;
            font-size: 12px;
        }

        /* ========== FORM ELEMENTS ========== */
        .adm-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .adm-form-label {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .adm-form-input,
        .adm-form-textarea,
        .adm-form-select {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: var(--font-sans);
            background: #fff;
            color: #111;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .adm-form-input:focus,
        .adm-form-textarea:focus,
        .adm-form-select:focus {
            outline: none;
            border-color: #1c1c1e;
            box-shadow: 0 0 0 2px rgba(28,28,30,0.1);
        }

        .adm-form-textarea { resize: vertical; min-height: 100px; }

        .adm-form-error {
            font-size: 12px;
            color: #c94a4a;
            font-weight: 500;
        }

        .adm-form-hint {
            font-size: 12px;
            color: #888;
        }

        /* ========== PANEL / CARD ========== */
        .adm-panel {
            background: #fff;
            border: 1px solid #ebebeb;
            border-radius: 10px;
            overflow: hidden;
        }

        .adm-panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f0f0;
        }

        .adm-panel-header h2 {
            font-size: 17px;
            font-weight: 600;
            color: #111;
        }

        .adm-panel-body { padding: 24px; }

        /* ========== PAGE TITLE ========== */
        .adm-page-title {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin-bottom: 20px;
            letter-spacing: -0.3px;
        }

        .adm-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        /* ========== PAGINATION ========== */
        .adm-pagination {
            display: flex;
            justify-content: center;
            padding: 24px 0;
        }

        .adm-pagination nav > div:first-child { display: none; }

        .adm-pagination a,
        .adm-pagination span {
            padding: 7px 13px;
            font-size: 13px;
            border: 1px solid #ddd;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.15s ease;
            color: #333;
        }

        .adm-pagination a:hover {
            background: #1c1c1e;
            color: #fff;
            border-color: #1c1c1e;
        }

        .adm-pagination span[aria-current] {
            background: #1c1c1e;
            color: #fff;
            border-color: #1c1c1e;
        }

        /* ========== EMPTY STATE ========== */
        .adm-empty {
            text-align: center;
            padding: 60px 24px;
            color: #aaa;
        }

        .adm-empty-icon {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        .adm-empty h3 {
            font-size: 18px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }

        .adm-empty p { font-size: 14px; }

        /* ========== BACK LINK ========== */
        .adm-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #888;
            margin-bottom: 20px;
            transition: color 0.15s;
        }

        .adm-back:hover { color: #111; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 900px) {
            .adm-sidebar { display: none; }
            .adm-main { margin-left: 0; }
            .adm-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
<div class="admin-shell">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="adm-sidebar">
        <div class="adm-sidebar-brand">
            <h2>Admin Panel</h2>
            <p>Manage your platform</p>
        </div>

        <ul class="adm-nav">
            <li class="adm-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="adm-nav-item">
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Posts
                </a>
            </li>
            <li class="adm-nav-item">
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    Categories
                </a>
            </li>
            <li class="adm-nav-item">
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Users
                </a>
            </li>
            <li class="adm-nav-item">
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Messages
                </a>
            </li>
        </ul>

        <div class="adm-back-link">
            <a href="{{ route('home') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Site
            </a>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="adm-main">

        {{-- TOP BAR --}}
        <header class="adm-topbar">
            <nav class="adm-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="adm-breadcrumb-sep">›</span>
                @if(View::hasSection('breadcrumb'))
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span class="adm-breadcrumb-sep">›</span>
                    <span class="adm-breadcrumb-current">@yield('breadcrumb')</span>
                @else
                    <span class="adm-breadcrumb-current">@yield('title', 'Dashboard')</span>
                @endif
            </nav>

            <div class="adm-topbar-right">
                <div class="adm-user-badge" id="adm-user-menu" onclick="this.classList.toggle('open')">
                    <div class="adm-user-avatar">
                        @auth
                            @if(auth()->user()->avatarUrl())
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" referrerpolicy="no-referrer">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        @endauth
                    </div>
                    <span class="adm-user-name">@auth{{ auth()->user()->name }}@endauth</span>
                    <svg class="adm-user-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>

                    <div class="adm-user-dropdown">
                        <a href="{{ route('profile.edit') }}">Settings</a>
                        <div class="adm-user-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="signout">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div style="padding: 16px 32px 0;">
                <div class="adm-flash adm-flash-success">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div style="padding: 16px 32px 0;">
                <div class="adm-flash adm-flash-error">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- PAGE CONTENT --}}
        <main class="adm-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Close user dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('adm-user-menu');
        if (menu && !menu.contains(e.target)) {
            menu.classList.remove('open');
        }
    });
</script>

@yield('scripts')
</body>
</html>
