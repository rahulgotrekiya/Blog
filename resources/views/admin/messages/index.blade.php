@extends('layouts.admin')

@section('title', 'Messages')
@section('breadcrumb', 'Messages')

@section('content')
<div class="adm-page-header">
    <h1 class="adm-page-title">
        Messages
        @if($unreadCount > 0)
            <span class="adm-badge adm-badge-unread" style="font-size:13px; vertical-align:middle; margin-left:8px;">{{ $unreadCount }} unread</span>
        @endif
    </h1>
</div>

@if ($messages->isEmpty())
    <div class="adm-empty">
        <div class="adm-empty-icon">📭</div>
        <h3>No messages yet</h3>
        <p>Contact form submissions will appear here.</p>
    </div>
@else
    <div class="adm-table-card animate-fade-in-up">
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
                        <div style="font-weight: 500; color:#111;">{{ $message->name }}</div>
                        <div style="font-size: 12px; color:#999; margin-top:2px;">{{ $message->email }}</div>
                    </td>
                    <td style="color:#333;">{{ Str::limit($message->subject, 50) }}</td>
                    <td style="color:#999; font-size:13px; white-space:nowrap;">{{ $message->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
                            @if($message->is_read)
                                <span class="adm-badge adm-badge-live">Read</span>
                            @else
                                <span class="adm-badge adm-badge-draft">Unread</span>
                            @endif
                            @if($message->replied_at)
                                <span class="adm-badge adm-badge-replied" title="Email sent on {{ $message->replied_at->format('M d, Y g:i A') }}">✉ Replied</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.messages.show', $message) }}" class="adm-btn adm-btn-outline adm-btn-sm">View</a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
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
        {{ $messages->links() }}
    </div>
@endif
@endsection
