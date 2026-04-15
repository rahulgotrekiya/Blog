@extends('layouts.blog')

@section('title', 'My Stories — Blog')

@section('content')
<div class="container page-content">
    <div class="dashboard-header">
        <h1>Your Stories</h1>
        <a href="{{ route('post.create') }}" class="btn btn-dark btn-sm">Write a story</a>
    </div>

    @forelse($posts as $post)
        <div class="post-card animate-fade-in-up">
            <div class="post-card-content">
                <h3>
                    <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                </h3>
                @if($post->excerpt)
                    <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                @endif
                <div class="post-card-footer">
                    @if($post->is_published)
                        <span class="badge badge-published">Published</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                    @if($post->category)
                        <a href="{{ route('category.show', $post->category) }}" class="post-card-category">{{ $post->category->name }}</a>
                    @endif
                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                    <span style="margin-left:auto;display:flex;gap:8px;">
                        <a href="{{ route('post.edit', $post) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <form method="POST" action="{{ route('post.destroy', $post) }}" onsubmit="return confirm('Delete this story?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">Delete</button>
                        </form>
                    </span>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <h3>No stories yet</h3>
            <p>Write your first story and share it with the world.</p>
            <a href="{{ route('post.create') }}" class="btn btn-dark">Write a story</a>
        </div>
    @endforelse

    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
</div>
@endsection
