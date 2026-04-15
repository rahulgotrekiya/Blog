@extends('layouts.blog')

@section('title', $user->name . ' — Blog')

@section('content')
<div class="container page-content">
    {{-- Profile Header --}}
    <div class="profile-header animate-fade-in-up">
        <div class="profile-header-inner">
            @if($user->avatarUrl())
                <img src="{{ $user->avatarUrl() }}" class="avatar avatar-lg" alt="{{ $user->name }}" referrerpolicy="no-referrer">
            @else
                <span class="avatar avatar-lg avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            @endif
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p class="profile-username">{{ '@' . $user->username }}</p>
                @if($user->bio)
                    <p class="profile-bio">{{ $user->bio }}</p>
                @endif
                <div class="profile-stats">
                    <span><strong>{{ $posts->total() }}</strong> stories</span>
                </div>
            </div>
        </div>
    </div>

    {{-- User's Posts --}}
    <div style="margin-top:32px;">
        <div class="feed-header">
            <h2>Stories by {{ $user->name }}</h2>
        </div>

        <div class="feed-grid">
            @forelse($posts as $index => $post)
                <article class="post-card animate-fade-in-up stagger-{{ ($index % 5) + 1 }}">
                    <div class="post-card-content">
                        <div class="post-card-meta">
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
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
                    <div class="empty-state-icon">📖</div>
                    <h3>No published stories yet</h3>
                    <p>This author hasn't published any stories.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
