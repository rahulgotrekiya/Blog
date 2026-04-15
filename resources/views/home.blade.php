@extends('layouts.blog')

@section('title', 'Blog — Where ideas find their voice')

@section('content')
{{-- Featured Post Hero --}}
@if($featured)
<section class="hero-featured">
    <div class="hero-featured-inner">
        <div class="hero-featured-content">
            <span class="hero-featured-label">Featured</span>
            <h1><a href="{{ route('post.show', $featured) }}">{{ $featured->title }}</a></h1>
            @if($featured->excerpt)
                <p class="hero-featured-excerpt">{{ $featured->excerpt }}</p>
            @endif
            <div class="hero-featured-meta">
                <a href="{{ route('profile.public', $featured->user->username) }}" class="author-name" style="font-weight:500;color:var(--off-black);">{{ $featured->user->name }}</a>
                <span class="dot" style="width:3px;height:3px;border-radius:50%;background:var(--light-gray);display:inline-block;"></span>
                <span>{{ $featured->published_at->format('M d, Y') }}</span>
                <span class="dot" style="width:3px;height:3px;border-radius:50%;background:var(--light-gray);display:inline-block;"></span>
                <span>{{ $featured->readingTime() }}</span>
            </div>
        </div>
        @if($featured->featured_image)
            <img src="{{ Storage::url($featured->featured_image) }}" alt="{{ $featured->title }}" class="hero-featured-image">
        @else
            <div class="hero-featured-image-placeholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
        @endif
    </div>
</section>
@endif

{{-- Main Feed --}}
<div class="layout-with-sidebar">
    <div class="page-content">
        <div class="feed-header">
            <h2>Latest Stories</h2>
        </div>

        <div class="feed-grid">
            @forelse($posts as $index => $post)
                <article class="post-card animate-fade-in-up stagger-{{ ($index % 5) + 1 }}">
                    <div class="post-card-content">
                        <div class="post-card-meta">
                            <a href="{{ route('profile.public', $post->user->username) }}" class="author-name">{{ $post->user->name }}</a>
                            <span class="dot"></span>
                            <span>{{ $post->published_at->format('M d') }}</span>
                        </div>
                        <h3><a href="{{ route('post.show', $post) }}">{{ $post->title }}</a></h3>
                        @if($post->excerpt)
                            <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                        @endif
                        <div class="post-card-footer">
                            @if($post->category)
                                <a href="{{ route('category.show', $post->category) }}" class="post-card-category">{{ $post->category->name }}</a>
                            @endif
                            <span>{{ $post->readingTime() }}</span>
                            <span>·</span>
                            <span>{{ $post->likes->count() }} likes</span>
                        </div>
                    </div>
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="post-card-thumbnail">
                    @else
                        <div class="post-card-thumbnail-placeholder"></div>
                    @endif
                </article>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">✍️</div>
                    <h3>No stories yet</h3>
                    <p>Be the first to share your thoughts with the world.</p>
                    @auth
                        <a href="{{ route('post.create') }}" class="btn btn-dark">Write your first story</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-dark">Get started</a>
                    @endauth
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-section">
            <h4>Discover Topics</h4>
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category) }}" class="sidebar-tag">{{ $category->name }}</a>
            @endforeach
        </div>
    </aside>
</div>
@endsection
