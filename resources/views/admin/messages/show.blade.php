@extends('layouts.admin')

@section('title', 'Message Detail')
@section('breadcrumb', 'Messages')

@section('content')

<a href="{{ route('admin.messages.index') }}" class="adm-back">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back to Messages
</a>

<div class="adm-page-header">
    <h1 class="adm-page-title">{{ $message->subject }}</h1>
    <div class="actions">
        <form method="POST" action="{{ route('admin.messages.markAsRead', $message) }}">
            @csrf @method('PATCH')
            <button type="submit" class="adm-btn adm-btn-outline adm-btn-sm">
                {{ $message->is_read ? 'Mark Unread' : 'Mark as Read' }}
            </button>
        </form>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#c94a4a;">Delete</button>
        </form>
    </div>
</div>

{{-- Message Details --}}
<div class="adm-panel animate-fade-in-up" style="margin-bottom: 20px;">
    <div class="adm-panel-body">
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; margin-bottom:24px;">
            <div>
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#888;margin-bottom:6px;">From</div>
                <div style="font-weight:500;color:#111;">{{ $message->name }}</div>
                <div style="font-size:13px;color:#888;margin-top:2px;">{{ $message->email }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#888;margin-bottom:6px;">Date</div>
                <div style="font-weight:500;color:#111;">{{ $message->created_at->format('M d, Y') }}</div>
                <div style="font-size:13px;color:#888;margin-top:2px;">{{ $message->created_at->format('g:i A') }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#888;margin-bottom:6px;">Status</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
                    @if($message->is_read)
                        <span class="adm-badge adm-badge-live">Read</span>
                    @else
                        <span class="adm-badge adm-badge-draft">Unread</span>
                    @endif
                    @if($message->replied_at)
                        <span class="adm-badge adm-badge-replied">✉ Email Sent {{ $message->replied_at->format('M d, Y \a\t g:i A') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:#888;margin-bottom:10px;">Message</div>
            <div style="line-height:1.8;color:#333;white-space:pre-wrap;font-size:15px;">{{ $message->message }}</div>
        </div>
    </div>
</div>

{{-- Admin Reply --}}
<div class="adm-panel animate-fade-in-up">
    <div class="adm-panel-header" style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h2>{{ $message->replied_at ? 'Re-send Reply via Email' : 'Send Reply via Email' }}</h2>
            <p style="font-size:13px;color:#888;margin-top:4px;">
                Reply will be emailed to <strong>{{ $message->email }}</strong>.
                @if($message->replied_at)
                    Previous reply sent on <strong>{{ $message->replied_at->format('M d, Y \a\t g:i A') }}</strong>.
                @endif
            </p>
        </div>
    </div>
    <div class="adm-panel-body">

        @if($message->replied_message)
            <div style="background:#f9f9fb;border-left:3px solid #1c1c1e;padding:14px 18px;border-radius:0 8px 8px 0;margin-bottom:20px;">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#888;margin-bottom:8px;">Previously Sent Reply</div>
                <div style="line-height:1.8;color:#333;white-space:pre-wrap;font-size:14px;">{{ $message->replied_message }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
            @csrf
            <div class="adm-form-group">
                <label for="replied_message" class="adm-form-label">
                    {{ $message->replied_message ? 'Updated Reply (will be re-emailed)' : 'Reply Message' }}
                </label>
                <textarea name="replied_message" id="replied_message" class="adm-form-textarea" rows="5" placeholder="Type your reply here..." required>{{ old('replied_message', $message->replied_message) }}</textarea>
                @error('replied_message')
                    <span class="adm-form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="adm-btn adm-btn-dark">
                {{ $message->replied_at ? '📨 Re-send Reply Email' : '📨 Send Reply Email' }}
            </button>
        </form>
    </div>
</div>

@endsection
