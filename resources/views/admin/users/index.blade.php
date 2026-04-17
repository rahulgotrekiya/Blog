@extends('layouts.admin')

@section('title', 'Manage Users')
@section('breadcrumb', 'Users')

@section('content')
<div class="adm-page-header">
    <h1 class="adm-page-title">Manage Users</h1>
</div>

<div class="adm-table-card animate-fade-in-up">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Posts</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span class="adm-avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <div>
                            <div style="font-weight:500; color:#111;">{{ $user->name }}</div>
                            <div style="font-size:12px;color:#999;">{{ '@' . $user->username }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#555; font-size:13px;">{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="adm-badge adm-badge-admin">Admin</span>
                    @else
                        <span class="adm-badge adm-badge-author">{{ ucfirst($user->role) }}</span>
                    @endif
                </td>
                <td style="color:#555;">{{ $user->posts_count }}</td>
                <td style="color:#999; font-size:13px;">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="actions">
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#c94a4a;">Delete</button>
                            </form>
                        @else
                            <span style="font-size:12px;color:#aaa;font-style:italic;">That's you</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="adm-pagination">
    {{ $users->links() }}
</div>
@endsection
