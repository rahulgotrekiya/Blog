@extends('layouts.blog')

@section('title', 'Manage Users — Admin')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <div class="admin-content">
        <h1>Manage Users</h1>

        <div class="data-table animate-fade-in-up">
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
                                <span class="avatar avatar-placeholder" style="width:32px;height:32px;font-size:12px;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <div>
                                    <div style="font-weight:500;">{{ $user->name }}</div>
                                    <div style="font-size:12px;color:var(--light-gray);">{{ '@'.$user->username }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->posts_count }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('admin.users.toggleRole', $user) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-outline btn-sm">
                                        {{ $user->role === 'admin' ? 'Demote' : 'Promote' }}
                                    </button>
                                </form>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger);">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
