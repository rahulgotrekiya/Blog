@extends('layouts.blog')

@section('title', 'Messages — Admin')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    {{-- Admin Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Admin Content --}}
    <div class="admin-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1>Messages</h1>
            @if($unreadCount > 0)
                <div style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px;">
                    <span style="color: var(--medium-gray);">Unread:</span>
                    <span class="badge badge-draft" style="background: #fdf2f2; color: var(--danger);">{{ $unreadCount }}</span>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($messages->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>No messages yet</h3>
                <p>Your contact form submissions will appear here.</p>
            </div>
        @else
            <div class="data-table animate-fade-in-up">
                <table>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>
                                <div style="font-weight: 500;">{{ $message->name }}</div>
                                <div style="font-size: 13px; color: var(--light-gray); margin-top: 2px;">{{ $message->email }}</div>
                            </td>
                            <td>{{ Str::limit($message->subject, 50) }}</td>
                            <td style="color: var(--light-gray);">{{ $message->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                                    @if($message->is_read)
                                        <span class="badge badge-published">Read</span>
                                    @else
                                        <span class="badge badge-draft">Unread</span>
                                    @endif
                                    @if($message->replied_at)
                                        <span class="badge" style="background: #eef5ff; color: #1a56db; border: 1px solid #c3d9ff; font-size: 11px;" title="Email sent on {{ $message->replied_at->format('M d, Y g:i A') }}">
                                            ✉ Replied
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-outline btn-sm">View</a>
                                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--danger);">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
