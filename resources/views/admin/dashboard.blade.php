@extends('layouts.blog')

@section('title', 'Admin Dashboard — Blog')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    {{-- Admin Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Admin Content --}}
    <div class="admin-content">
        <h1>Dashboard</h1>

        {{-- Stats Grid --}}
        <div class="stats-grid">
            <div class="stat-card animate-fade-in-up stagger-1">
                <h3>Total Users</h3>
                <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            </div>
            <div class="stat-card animate-fade-in-up stagger-2">
                <h3>Total Posts</h3>
                <div class="stat-value">{{ number_format($stats['total_posts']) }}</div>
            </div>
            <div class="stat-card animate-fade-in-up stagger-3">
                <h3>Published</h3>
                <div class="stat-value">{{ number_format($stats['published_posts']) }}</div>
            </div>
            <div class="stat-card animate-fade-in-up stagger-4">
                <h3>Comments</h3>
                <div class="stat-value">{{ number_format($stats['total_comments']) }}</div>
            </div>
            <div class="stat-card animate-fade-in-up stagger-5">
                <h3>Categories</h3>
                <div class="stat-value">{{ number_format($stats['total_categories']) }}</div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            {{-- Recent Posts --}}
            <div class="data-table animate-fade-in-up">
                <div style="padding:16px;border-bottom:1px solid var(--lighter-gray);">
                    <h3 style="font-size:14px;font-weight:600;">Recent Posts</h3>
                </div>
                <table>
                    <tbody>
                        @foreach($recentPosts as $post)
                        <tr>
                            <td>
                                <div style="font-weight:500;">{{ Str::limit($post->title, 35) }}</div>
                                <div style="font-size:12px;color:var(--light-gray);">by {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge badge-published">Live</span>
                                @else
                                    <span class="badge badge-draft">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Recent Users --}}
            <div class="data-table animate-fade-in-up">
                <div style="padding:16px;border-bottom:1px solid var(--lighter-gray);">
                    <h3 style="font-size:14px;font-weight:600;">Recent Users</h3>
                </div>
                <table>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <span class="avatar avatar-placeholder" style="width:28px;height:28px;font-size:11px;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    <div>
                                        <div style="font-weight:500;">{{ $user->name }}</div>
                                        <div style="font-size:12px;color:var(--light-gray);">{{ '@'.$user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
