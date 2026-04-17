@extends('layouts.admin')

@section('title', 'Manage Posts')
@section('breadcrumb', 'Posts')

@section('content')
<div class="adm-page-header">
    <h1 class="adm-page-title">Manage Posts</h1>
</div>

<div class="adm-table-card animate-fade-in-up">
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
                    <a href="{{ route('post.show', $post) }}" style="font-weight:500; color:#111; text-decoration:none;">
                        {{ Str::limit($post->title, 45) }}
                    </a>
                </td>
                <td style="color:#666;">{{ $post->user->name }}</td>
                <td style="color:#888; font-size:13px;">{{ $post->category->name ?? '—' }}</td>
                <td>
                    <div style="display:flex;gap:4px;flex-wrap:wrap;">
                        @if($post->is_published)
                            <span class="adm-badge adm-badge-live">Published</span>
                        @else
                            <span class="adm-badge adm-badge-draft">Draft</span>
                        @endif
                        @if($post->is_featured)
                            <span class="adm-badge adm-badge-admin">Featured</span>
                        @endif
                    </div>
                </td>
                <td style="color:#999; font-size:13px;">{{ $post->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="actions">
                        <form method="POST" action="{{ route('admin.posts.toggleFeatured', $post) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="adm-btn adm-btn-outline adm-btn-sm">
                                {{ $post->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#c94a4a;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="adm-pagination">
    {{ $posts->links() }}
</div>
@endsection
