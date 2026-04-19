@extends('layouts.blog')

@section('title', 'Blog — Where ideas find their voice')

@section('content')
{{-- Featured Posts Carousel --}}
@if($featured->isNotEmpty())
<section class="hero-featured" id="hero-carousel">
    <div class="hero-track-viewport">
        <div class="hero-track" id="hero-track">
            {{-- Slides rendered here; JS will clone first/last for infinite loop --}}
            @foreach($featured as $feat)
                <div class="hero-track-slide" data-href="{{ route('post.show', $feat) }}">
                    <div class="hero-featured-inner {{ !$feat->featured_image ? 'hero-featured-inner--text-only' : '' }}">
                        <div class="hero-featured-content">
                            <span class="hero-featured-label">Featured</span>
                            <h1><a href="{{ route('post.show', $feat) }}">{{ $feat->title }}</a></h1>
                            @if($feat->excerpt)
                                <p class="hero-featured-excerpt">{{ $feat->excerpt }}</p>
                            @endif
                            <div class="hero-featured-meta">
                                <a href="{{ route('profile.public', $feat->user->username) }}" class="author-name" style="font-weight:500;color:var(--off-black);">{{ $feat->user->name }}</a>
                                <span class="dot" style="width:3px;height:3px;border-radius:50%;background:var(--light-gray);display:inline-block;"></span>
                                <span>{{ $feat->published_at->format('M d, Y') }}</span>
                                <span class="dot" style="width:3px;height:3px;border-radius:50%;background:var(--light-gray);display:inline-block;"></span>
                                <span>{{ $feat->readingTime() }}</span>
                            </div>
                        </div>
                        @if($feat->featured_image)
                            <img src="{{ Storage::url($feat->featured_image) }}" alt="{{ $feat->title }}" class="hero-featured-image" draggable="false">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Controls: dots + arrows --}}
    @if($featured->count() > 1)
    <div class="hero-controls">
        <div class="hero-dots" id="hero-dots">
            @foreach($featured as $j => $_)
                <button class="hero-dot" data-slide="{{ $j }}" aria-label="Go to slide {{ $j + 1 }}"></button>
            @endforeach
        </div>
    </div>
    @endif
</section>

<script>
(function () {
    var total = {{ $featured->count() }};
    if (total < 2) return; // single post — no carousel needed

    var track    = document.getElementById('hero-track');
    var viewport = track.parentElement;
    var dots     = Array.from(document.querySelectorAll('.hero-dot'));
    var hero     = document.getElementById('hero-carousel');

    // ── Infinite loop: clone first & last ──────────────────────────────────
    var slides      = Array.from(track.children);
    var firstClone  = slides[0].cloneNode(true);
    var lastClone   = slides[slides.length - 1].cloneNode(true);
    firstClone.setAttribute('aria-hidden', 'true');
    lastClone.setAttribute('aria-hidden', 'true');
    track.appendChild(firstClone);   // after last  → index total+1
    track.prepend(lastClone);        // before first → index 0
    // Real slides now sit at indices 1 … total inside the track

    var realCount = total;           // number of real slides
    var pos       = 1;               // current position in extended track (1 = first real)
    var timer     = null;
    var dragging  = false;
    var dragStartX = 0;
    var dragDelta  = 0;

    function slideTo(index, animate) {
        if (animate === undefined) animate = true;
        pos = index;
        track.style.transition = animate
            ? 'transform 0.55s cubic-bezier(0.4, 0, 0.2, 1)'
            : 'none';
        track.style.transform = 'translateX(-' + (pos * 100) + '%)';
        // Only update dots for real slide positions (1..realCount)
        var realIdx = pos - 1;
        if (realIdx >= 0 && realIdx < realCount) {
            dots.forEach(function(d, i) { d.classList.toggle('active', i === realIdx); });
        }
    }

    // Guard: only react to the track's own transform transition, not child elements
    track.addEventListener('transitionend', function (e) {
        if (e.target !== track) return;
        if (e.propertyName !== 'transform') return;
        if (pos === 0) {
            // On lastClone at front — silently jump to the real last slide
            slideTo(realCount, false);
        } else if (pos === realCount + 1) {
            // On firstClone at back — silently jump to the real first slide
            slideTo(1, false);
        }
    });

    function next() { slideTo(pos + 1); }
    function prev() { slideTo(pos - 1); }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(next, 6000);
    }

    // Dot clicks
    dots.forEach(function(d, i) {
        d.addEventListener('click', function() { slideTo(i + 1); resetTimer(); });
    });

    // Pause auto-play on hover
    hero.addEventListener('mouseenter', function () { clearInterval(timer); });
    hero.addEventListener('mouseleave', resetTimer);

    // ── Mouse drag ────────────────────────────────────────────────────────
    track.addEventListener('mousedown', function (e) {
        dragging   = true;
        dragStartX = e.clientX;
        dragDelta  = 0;
        track.style.transition = 'none';
        viewport.style.cursor  = 'grabbing';
    });

    window.addEventListener('mousemove', function (e) {
        if (!dragging) return;
        dragDelta = e.clientX - dragStartX;
        track.style.transform = 'translateX(calc(-' + (pos * 100) + '% + ' + dragDelta + 'px))';
    });

    window.addEventListener('mouseup', function () {
        if (!dragging) return;
        dragging              = false;
        viewport.style.cursor = '';
        var threshold = viewport.offsetWidth * 0.15;
        if      (dragDelta < -threshold) { next(); }
        else if (dragDelta >  threshold) { prev(); }
        else    { slideTo(pos); }
        resetTimer();
    });

    // ── Touch swipe ───────────────────────────────────────────────────────
    var touchStartX = 0;

    track.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
        track.style.transition = 'none';
    }, { passive: true });

    track.addEventListener('touchmove', function (e) {
        var delta = e.touches[0].clientX - touchStartX;
        track.style.transform = 'translateX(calc(-' + (pos * 100) + '% + ' + delta + 'px))';
    }, { passive: true });

    track.addEventListener('touchend', function (e) {
        var delta     = e.changedTouches[0].clientX - touchStartX;
        var threshold = viewport.offsetWidth * 0.15;
        if      (delta < -threshold) { next(); }
        else if (delta >  threshold) { prev(); }
        else    { slideTo(pos); }
        resetTimer();
    });

    // Init — no animation, start at first real slide
    slideTo(1, false);
    resetTimer();
})();
</script>
@endif

{{-- Main Feed --}}
<div class="layout-with-sidebar">
    <div class="page-content">
        <div class="feed-header">
            <h2>Latest Stories</h2>
        </div>

        <div class="feed-grid">
            @forelse($posts as $index => $post)
                <article class="post-card {{ !$post->featured_image ? 'post-card--text-only' : '' }} animate-fade-in-up stagger-{{ ($index % 5) + 1 }}">
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
                            <span>{{ $post->likes_count }} likes</span>
                        </div>
                    </div>
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="post-card-thumbnail">
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
