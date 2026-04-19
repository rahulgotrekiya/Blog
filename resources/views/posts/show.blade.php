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
            @if($post->user->avatarUrl())
                <img src="{{ $post->user->avatarUrl() }}" class="avatar avatar-lg" alt="{{ $post->user->name }}" referrerpolicy="no-referrer">
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
    @auth
        <div class="article-body">
            {!! nl2br(e($post->body)) !!}
        </div>
    @else
        {{-- Guest: faded text preview + Medium-style inline gate card --}}
        <div class="gate-wrap">
            <div class="article-body article-body--gated">
                {!! nl2br(e($post->body)) !!}
            </div>

            {{-- Inline gate card — sits below the fade, exactly like Medium --}}
            <div class="reading-gate">
                {{-- Sparkle / star icon (Medium uses a coloured star) --}}
                <div class="reading-gate-icon" aria-hidden="true">
                    <svg width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="38" cy="38" r="38" fill="#FBF0E0"/>
                        <path d="M38 16 L41.5 31.5 L57 35 L41.5 38.5 L38 54 L34.5 38.5 L19 35 L34.5 31.5 Z" fill="#F5C842"/>
                        <path d="M52 20 L53.5 25.5 L59 27 L53.5 28.5 L52 34 L50.5 28.5 L45 27 L50.5 25.5 Z" fill="#F5C842" opacity="0.7"/>
                        <path d="M24 48 L25 51.5 L28.5 52.5 L25 53.5 L24 57 L23 53.5 L19.5 52.5 L23 51.5 Z" fill="#F5C842" opacity="0.5"/>
                    </svg>
                </div>

                <h2 class="reading-gate-headline">This story is for signed-in readers.</h2>
                <p class="reading-gate-sub">Sign in to keep reading — it's free.</p>

                <div class="reading-gate-actions">
                    <a href="{{ route('login') }}"    class="reading-gate-btn reading-gate-btn--outline">Sign in</a>
                    <a href="{{ route('register') }}" class="reading-gate-btn reading-gate-btn--primary">Create free account</a>
                </div>

                <p class="reading-gate-footer">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </p>
            </div>
        </div>

        <style>
        /* ── Wrapper keeps fade + gate in the same stacking context ─── */
        .gate-wrap {
            position: relative;
        }

        /* ── Faded article preview ──────────────────────────────── */
        .article-body--gated {
            position: relative;
            max-height: 52vh;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
                    mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
        }

        /* ── Inline gate card ───────────────────────────────────── */
        .reading-gate {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 48px 32px 52px;
            margin: 0 0 48px;
        }

        .reading-gate-icon {
            margin-bottom: 24px;
        }

        .reading-gate-headline {
            font-family: var(--font-serif);
            font-size: 28px;
            font-weight: 700;
            color: var(--off-black);
            letter-spacing: -0.3px;
            margin: 0 0 10px;
            line-height: 1.2;
        }

        .reading-gate-sub {
            font-size: 16px;
            color: var(--medium-gray);
            margin: 0 0 32px;
            font-family: var(--font-sans);
        }

        .reading-gate-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .reading-gate-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 28px;
            border-radius: var(--radius-full);
            font-size: 15px;
            font-weight: 500;
            font-family: var(--font-sans);
            transition: var(--transition);
            white-space: nowrap;
            text-decoration: none;
            min-width: 160px;
        }

        .reading-gate-btn--primary {
            background: var(--off-black);
            color: var(--white);
            border: 1px solid var(--off-black);
        }

        .reading-gate-btn--primary:hover {
            background: var(--black);
            color: var(--white);
        }

        .reading-gate-btn--outline {
            background: transparent;
            color: var(--off-black);
            border: 1px solid var(--off-black);
        }

        .reading-gate-btn--outline:hover {
            background: var(--off-white);
        }

        .reading-gate-footer {
            font-size: 13px;
            color: var(--light-gray);
            margin: 0;
        }

        .reading-gate-footer a {
            color: var(--off-black);
            font-weight: 500;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        @media (max-width: 500px) {
            .reading-gate { padding: 40px 20px 44px; }
            .reading-gate-headline { font-size: 22px; }
            .reading-gate-btn { min-width: 130px; font-size: 14px; }
        }
        </style>
    @endauth



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
                    @if($comment->user->avatarUrl())
                        <img src="{{ $comment->user->avatarUrl() }}" class="avatar" alt="" referrerpolicy="no-referrer">
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
