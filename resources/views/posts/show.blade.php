@extends('layouts.blog')

@section('title', $post->title . ' — Blog')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->body), 160))

@section('content')
<article>
    {{-- Article Header --}}
    <div class="article-header">
        <h1>{{ $post->title }}</h1>
        @if($post->excerpt)
            <p class="article-excerpt">{{ $post->excerpt }}</p>
        @endif
        <div class="article-meta">
            @if($post->user->avatar)
                <img src="{{ Storage::url($post->user->avatar) }}" class="avatar avatar-lg" alt="{{ $post->user->name }}">
            @else
                <span class="avatar avatar-lg avatar-placeholder">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
            @endif
            <div class="article-meta-text">
                <a href="{{ route('profile.public', $post->user->username) }}" class="author-name">{{ $post->user->name }}</a>
                <span class="post-date">
                    {{ $post->readingTime() }} · {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                    @if($post->category)
                        · <a href="{{ route('category.show', $post->category) }}" style="color:var(--accent);">{{ $post->category->name }}</a>
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Featured Image --}}
    @if($post->featured_image)
        <div class="article-featured-image">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
        </div>
    @endif

    {{-- Article Body --}}
    <div class="article-body">
        {!! nl2br(e($post->body)) !!}
    </div>

    {{-- Likes & Actions --}}
    <div class="article-actions">
        @auth
            <button class="like-button {{ auth()->user()->hasLiked($post) ? 'liked' : '' }}" id="like-btn" data-post="{{ $post->slug }}">
                <svg viewBox="0 0 24 24" fill="{{ auth()->user()->hasLiked($post) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span id="like-count">{{ $post->likes->count() }}</span>
            </button>
        @else
            <a href="{{ route('login') }}" class="like-button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span>{{ $post->likes->count() }}</span>
            </a>
        @endauth

        @auth
            @if(auth()->id() === $post->user_id)
                <div class="flex gap-1">
                    <a href="{{ route('post.edit', $post) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('post.destroy', $post) }}" onsubmit="return confirm('Delete this story?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">Delete</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</article>

{{-- Comments Section --}}
<section class="comments-section">
    <h3>Responses ({{ $post->comments->count() }})</h3>

    @auth
        <form method="POST" action="{{ route('comment.store', $post) }}" class="comment-form">
            @csrf
            <textarea name="body" placeholder="What are your thoughts?" required class="form-textarea">{{ old('body') }}</textarea>
            @error('body') <p class="form-error">{{ $message }}</p> @enderror
            <button type="submit" class="btn btn-dark btn-sm">Respond</button>
        </form>
    @else
        <p class="text-muted mb-3"><a href="{{ route('login') }}" style="color:var(--black);font-weight:500;">Sign in</a> to leave a response.</p>
    @endauth

    @foreach($post->comments as $comment)
        <div class="comment-item">
            <div class="comment-header">
                <div class="comment-author">
                    @if($comment->user->avatar)
                        <img src="{{ Storage::url($comment->user->avatar) }}" class="avatar" alt="">
                    @else
                        <span class="avatar avatar-placeholder" style="width:28px;height:28px;font-size:12px;">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                    @endif
                    <span class="comment-author-name">{{ $comment->user->name }}</span>
                    <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                @auth
                    @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('comment.destroy', $comment) }}" onsubmit="return confirm('Delete this comment?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm" style="font-size:12px;color:var(--light-gray);">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>
            <p class="comment-body">{{ $comment->body }}</p>
        </div>
    @endforeach
</section>

{{-- Related Posts --}}
@if($relatedPosts->count())
<section class="related-posts">
    <h3>More from {{ $post->category->name ?? 'this author' }}</h3>
    <div class="related-grid">
        @foreach($relatedPosts as $related)
            <div class="related-card">
                <h4><a href="{{ route('post.show', $related) }}">{{ $related->title }}</a></h4>
                <p class="related-meta">{{ $related->readingTime() }} · {{ $related->published_at->format('M d') }}</p>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.getElementById('like-btn');
    if (!likeBtn) return;

    likeBtn.addEventListener('click', function() {
        const slug = this.dataset.post;
        fetch(`/post/${slug}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            this.classList.toggle('liked', data.liked);
            this.querySelector('svg').setAttribute('fill', data.liked ? 'currentColor' : 'none');
            document.getElementById('like-count').textContent = data.count;
        });
    });
});
</script>
@endsection
