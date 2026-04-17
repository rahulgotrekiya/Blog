@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="adm-page-header">
    <h1 class="adm-page-title">Dashboard</h1>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="adm-stats-grid">

    {{-- Total Users --}}
    <a href="{{ route('admin.users.index') }}" class="adm-stat-card animate-fade-in-up stagger-1">
        <div>
            <div class="adm-stat-label">Total Users</div>
            <div class="adm-stat-value">{{ number_format($stats['total_users']) }}</div>
        </div>
        <span class="adm-stat-badge green" title="New users joined in the last 7 days">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
            {{ $stats['users_this_week'] }} this week
        </span>
    </a>

    {{-- Total Posts --}}
    <a href="{{ route('admin.posts.index') }}" class="adm-stat-card animate-fade-in-up stagger-2">
        <div>
            <div class="adm-stat-label">Total Posts</div>
            <div class="adm-stat-value">{{ number_format($stats['total_posts']) }}</div>
        </div>
        <span class="adm-stat-badge blue" title="New posts in the last 7 days">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
            {{ $stats['posts_this_week'] }} this week
        </span>
    </a>

    {{-- Published --}}
    <a href="{{ route('admin.posts.index') }}" class="adm-stat-card animate-fade-in-up stagger-3">
        <div>
            <div class="adm-stat-label">Published</div>
            <div class="adm-stat-value">{{ number_format($stats['published_posts']) }}</div>
        </div>
        <span class="adm-stat-badge amber" title="Unpublished posts currently in draft">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            {{ $stats['draft_posts'] }} drafts
        </span>
    </a>

    {{-- New Messages --}}
    <a href="{{ route('admin.messages.index') }}" class="adm-stat-card animate-fade-in-up stagger-4">
        <div>
            <div class="adm-stat-label">New Messages</div>
            <div class="adm-stat-value">{{ number_format($stats['unread_messages']) }}</div>
        </div>
        @if($stats['unread_messages'] > 0)
            <span class="adm-stat-badge" style="background:#fee2e2;color:#dc2626;text-decoration:none;">unread</span>
        @else
            <span class="adm-stat-badge">all read</span>
        @endif
    </a>

</div>

{{-- ===== ACTIVITY TABLES ===== --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- Recent Posts --}}
    <div class="adm-table-card animate-fade-in-up">
        <div class="adm-table-card-header">
            <h3>Recent Posts</h3>
            <a href="{{ route('admin.posts.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">View all</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPosts as $post)
                <tr>
                    <td style="font-weight: 500; max-width: 180px;">
                        <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit($post->title, 30) }}
                        </div>
                    </td>
                    <td style="color: #666;">{{ $post->user->name }}</td>
                    <td style="color: #999; font-size: 13px; white-space: nowrap;">{{ $post->created_at->diffForHumans() }}</td>
                    <td>
                        @if($post->is_published)
                            <span class="adm-badge adm-badge-live">Live</span>
                        @else
                            <span class="adm-badge adm-badge-draft">Draft</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; color:#aaa; padding: 24px;">No posts yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Latest Users --}}
    <div class="adm-table-card animate-fade-in-up">
        <div class="adm-table-card-header">
            <h3>Latest Users</h3>
            <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">View all</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="adm-avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <span style="font-weight: 500;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color: #888; font-size: 13px;">{{ '@' .$user->username }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="adm-badge adm-badge-admin">Admin</span>
                        @else
                            <span class="adm-badge adm-badge-author">{{ ucfirst($user->role) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center; color:#aaa; padding: 24px;">No users yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
