@extends('layouts.blog')

@section('title', 'About — Blog')
@section('meta_description', 'Learn more about this blog platform — a college project built with Laravel.')

@section('content')
<div class="container" style="max-width:720px;margin:60px auto;padding:0 24px;">
    <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:12px;">About This Blog</h1>
    <p style="color:var(--medium-gray);font-size:1.05rem;margin-bottom:40px;">A modern blogging platform built with passion and Laravel.</p>

    <div style="border-top:1px solid var(--border);padding-top:32px;">
        <h2 style="font-size:1.2rem;font-weight:600;margin-bottom:12px;">What is this?</h2>
        <p style="line-height:1.8;color:var(--text-secondary);margin-bottom:24px;">
            This is a full-featured blog platform developed as a college project. It allows writers to create and publish articles, readers to discover and engage with content, and administrators to manage the platform.
        </p>

        <h2 style="font-size:1.2rem;font-weight:600;margin-bottom:12px;">Built with</h2>
        <ul style="line-height:2;color:var(--text-secondary);padding-left:20px;margin-bottom:24px;">
            <li>Laravel 11 — Backend framework</li>
            <li>Blade Templates — Server-side UI rendering</li>
            <li>MySQL — Database</li>
            <li>Laravel Breeze + Google OAuth — Authentication</li>
            <li>GitHub Actions — Continuous Integration</li>
        </ul>

        <h2 style="font-size:1.2rem;font-weight:600;margin-bottom:12px;">Features</h2>
        <ul style="line-height:2;color:var(--text-secondary);padding-left:20px;margin-bottom:32px;">
            <li>Author & Admin roles</li>
            <li>Post creation, editing, and publishing</li>
            <li>Categories, likes, and comments</li>
            <li>Google Sign-In support</li>
            <li>Email verification</li>
            <li>Admin panel for content management</li>
        </ul>

        <div style="background:var(--bg-secondary,#f9f9f9);border-radius:10px;padding:24px;border:1px solid var(--border);">
            <p style="margin:0;font-size:0.95rem;color:var(--medium-gray);">
                Have questions or feedback? <a href="{{ route('contact') }}" style="color:var(--accent,#111);font-weight:600;">Contact us →</a>
            </p>
        </div>
    </div>
</div>
@endsection
