@extends('layouts.blog')

@section('title', $category->name . ' — Blog')

@section('content')
<div class="container page-content">
    <div class="feed-header animate-fade-in-up">
        <h2>{{ $category->name }}</h2>
        <span class="text-muted">{{ $posts->total() }} {{ Str::plural('story', $posts->total()) }}</span>
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
                <div class="empty-state-icon">📂</div>
                <h3>No stories in this category</h3>
                <p>Check back later for new content.</p>
                <a href="{{ route('home') }}" class="btn btn-dark btn-sm">Back to Home</a>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
</div>
@endsection
