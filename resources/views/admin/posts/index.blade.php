@extends('layouts.blog')

@section('title', 'Manage Posts — Admin')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <div class="admin-content">
        <h1>Manage Posts</h1>

        <div class="data-table animate-fade-in-up">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('post.show', $post) }}" style="font-weight:500;">{{ Str::limit($post->title, 40) }}</a>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category->name ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                @if($post->is_published)
                                    <span class="badge badge-published">Published</span>
                                @else
                                    <span class="badge badge-draft">Draft</span>
                                @endif
                                @if($post->is_featured)
                                    <span class="badge badge-featured">Featured</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('admin.posts.toggleFeatured', $post) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-outline btn-sm">
                                        {{ $post->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
