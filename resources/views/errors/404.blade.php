@extends('layouts.blog')

@section('title', '404 — Page Not Found')

@section('content')
<div style="
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px 24px;
">
    <div>
        <div style="
            font-size: 7rem;
            font-weight: 800;
            letter-spacing: -4px;
            color: var(--border, #e5e7eb);
            line-height: 1;
            margin-bottom: 24px;
            user-select: none;
        ">404</div>

        <h1 style="font-size: 1.6rem; font-weight: 700; margin-bottom: 12px;">
            Page not found
        </h1>

        <p style="color: var(--medium-gray); font-size: 1rem; max-width: 400px; margin: 0 auto 32px; line-height: 1.7;">
            The page you're looking for doesn't exist, was moved, or the link is broken.
        </p>

        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-dark">
                ← Back to Home
            </a>
            <a href="javascript:history.back()" class="btn btn-outline">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection
