@extends('layouts.blog')

@section('title', 'Message — Admin')
@section('hide_footer', true)

@section('content')
<div class="admin-layout">
    {{-- Admin Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Admin Content --}}
    <div class="admin-content">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('admin.messages.index') }}" class="nav-link" style="font-size: 14px; padding: 0; margin-bottom: 16px; display: inline-flex;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                <span>Back to Messages</span>
            </a>

            <div style="display: grid; grid-template-columns: 1fr auto; gap: 24px; align-items: start; margin-bottom: 24px;">
                <div>
                    <h1 style="margin: 0;">{{ $message->subject }}</h1>
                </div>
                <div class="actions">
                    <form method="POST" action="{{ route('admin.messages.markAsRead', $message) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline btn-sm">
                            {{ $message->is_read ? 'Mark Unread' : 'Mark as Read' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--danger);">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Message Details --}}
        <div class="data-table animate-fade-in-up" style="margin-bottom: 32px;">
            <div style="padding: 24px; border-bottom: 1px solid var(--lighter-gray);">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 24px;">
                    <div>
                        <div style="color: var(--medium-gray); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">From</div>
                        <div style="font-weight: 500; font-size: 15px;">{{ $message->name }}</div>
                        <div style="font-size: 14px; color: var(--medium-gray); margin-top: 4px;">{{ $message->email }}</div>
                    </div>
                    <div>
                        <div style="color: var(--medium-gray); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Date</div>
                        <div style="font-weight: 500; font-size: 15px;">{{ $message->created_at->format('M d, Y') }}</div>
                        <div style="font-size: 14px; color: var(--medium-gray); margin-top: 4px;">{{ $message->created_at->format('g:i A') }}</div>
                    </div>
                </div>

                <div>
                    <div style="color: var(--medium-gray); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Status</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        @if($message->is_read)
                            <span class="badge badge-published">Read</span>
                        @else
                            <span class="badge badge-draft">Unread</span>
                        @endif
                        @if($message->replied_at)
                            <span class="badge" style="background: #eef5ff; color: #1a56db; border: 1px solid #c3d9ff;">
                                ✉ Email Sent {{ $message->replied_at->format('M d, Y \a\t g:i A') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="padding: 24px;">
                <div style="color: var(--medium-gray); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Message</div>
                <div style="line-height: 1.8; color: var(--off-black); white-space: pre-wrap; font-size: 15px;">{{ $message->message }}</div>
            </div>
        </div>

        {{-- Admin Reply --}}
        <div class="data-table animate-fade-in-up">
            <div style="padding: 24px;">
                <h2 style="margin-top: 0; margin-bottom: 8px; font-size: 18px; font-weight: 600;">
                    {{ $message->replied_at ? 'Re-send Reply via Email' : 'Send Reply via Email' }}
                </h2>
                <p style="font-size: 13px; color: var(--medium-gray); margin-bottom: 24px;">
                    Your reply will be sent to <strong>{{ $message->email }}</strong> via email.
                    @if($message->replied_at)
                        A previous reply was sent on <strong>{{ $message->replied_at->format('M d, Y \a\t g:i A') }}</strong>.
                    @endif
                </p>

                @if ($message->replied_message)
                    <div style="background: var(--off-white); border-left: 3px solid var(--accent); padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
                        <div style="color: var(--medium-gray); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Previously Sent Reply</div>
                        <div style="line-height: 1.8; color: var(--off-black); white-space: pre-wrap; font-size: 15px;">{{ $message->replied_message }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
                    @csrf
                    <div class="form-group">
                        <label for="replied_message" class="form-label">{{ $message->replied_message ? 'Updated Reply (will be re-emailed)' : 'Reply Message' }}</label>
                        <textarea name="replied_message" id="replied_message" class="form-textarea" placeholder="Type your reply here..." required>{{ old('replied_message', $message->replied_message) }}</textarea>
                        @error('replied_message')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark">
                        {{ $message->replied_at ? '📨 Re-send Reply Email' : '📨 Send Reply Email' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
