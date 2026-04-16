@extends('layouts.blog')

@section('title', 'Settings — Blog')

@section('content')
<div class="container page-content">
    <div class="settings-layout">
        {{-- Settings Header --}}
        <div class="settings-header animate-fade-in-up">
            <h1>Settings</h1>
            <p>Manage your account settings and preferences</p>
        </div>

        <div class="settings-grid">
            {{-- Settings Sidebar --}}
            <aside class="settings-sidebar">
                <nav class="settings-nav">
                    <a href="#profile" class="settings-nav-item active" onclick="showSection('profile', event)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Profile Information
                    </a>
                    <a href="#password" class="settings-nav-item" onclick="showSection('password', event)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Password
                    </a>
                    <a href="#account" class="settings-nav-item" onclick="showSection('account', event)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle><path d="M12 1v6m0 6v6m5.5-14.5l-4.5 4.5m0 6l4.5 4.5m6-14.5l-6 6m0 6l6 6M1 12h6m6 0h6"></path>
                        </svg>
                        Account
                    </a>
                </nav>
            </aside>

            {{-- Settings Content --}}
            <div class="settings-content">
                {{-- Profile Information Section --}}
                <section id="profile-section" class="settings-section active">
                    <div class="settings-card">
                        <h2>Profile Information</h2>
                        <p class="settings-card-description">Update your account's profile information and email address.</p>

                        <form method="POST" action="{{ route('profile.update') }}" class="settings-form" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label class="form-label">Profile Picture</label>
                                <div class="avatar-upload-container">
                                    <div class="avatar-preview">
                                        @if($user->avatarUrl())
                                            <img src="{{ $user->avatarUrl() }}" alt="Avatar" class="avatar avatar-lg" id="avatar-preview-img" referrerpolicy="no-referrer">
                                        @else
                                            <span class="avatar avatar-lg avatar-placeholder" id="avatar-preview-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="avatar-upload-controls">
                                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="avatar-input" onchange="previewAvatar(event)">
                                        <label for="avatar" class="btn btn-outline btn-sm">Choose Photo</label>
                                        <span class="form-hint">JPG, PNG, GIF or WebP. Max 2MB.</span>
                                        @if($user->isGoogleUser() && str_starts_with($user->avatar ?? '', 'http'))
                                            <span class="form-hint" style="color:#16a34a;">✓ Using your Google profile photo</span>
                                        @endif
                                    </div>
                                </div>
                                @error('avatar')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-input @error('name') error @enderror" 
                                    value="{{ old('name', $user->name) }}" 
                                    required 
                                    autofocus 
                                    autocomplete="name"
                                >
                                @error('name')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-prefix">
                                    <span>@</span>
                                    <input 
                                        type="text" 
                                        id="username" 
                                        name="username" 
                                        class="form-input @error('username') error @enderror" 
                                        value="{{ old('username', $user->username) }}" 
                                        required
                                    >
                                </div>
                                @error('username')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-input @error('email') error @enderror" 
                                    value="{{ old('email', $user->email) }}" 
                                    required 
                                    autocomplete="username"
                                >
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="alert alert-warning" style="margin-top:12px;">
                                        Your email address is unverified.
                                        <form method="POST" action="{{ route('verification.send') }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-link">Click here to re-send the verification email.</button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea 
                                    id="bio" 
                                    name="bio" 
                                    class="form-textarea @error('bio') error @enderror" 
                                    rows="4" 
                                    maxlength="160"
                                    oninput="updateBioCounter(this)"
                                    placeholder="Write a short bio about yourself..."
                                >{{ old('bio', $user->bio) }}</textarea>
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px;">
                                    <span class="form-hint">Brief description for your profile.</span>
                                    <span id="bio-counter" style="font-size:12px;color:var(--light-gray);"
                                          class="{{ strlen(old('bio', $user->bio ?? '')) > 140 ? 'text-warning' : '' }}">
                                        {{ strlen(old('bio', $user->bio ?? '')) }}/160
                                    </span>
                                </div>
                                @error('bio')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-dark">Save Changes</button>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success" style="margin-top:16px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Profile updated successfully.
                                </div>
                            @endif
                        </form>
                    </div>
                </section>

                {{-- Password Section --}}
                <section id="password-section" class="settings-section">
                    <div class="settings-card">
                        @if($user->hasPassword())
                            <h2>Update Password</h2>
                            <p class="settings-card-description">Ensure your account is using a long, random password to stay secure.</p>
                        @else
                            <h2>Set a Password</h2>
                            <p class="settings-card-description">
                                Your account is currently linked via Google. Set a password to also sign in with email and password.
                            </p>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}" class="settings-form">
                            @csrf
                            @method('put')

                            @if($user->hasPassword())
                            <div class="form-group">
                                <label for="update_password_current_password" class="form-label">Current Password</label>
                                <input
                                    type="password"
                                    id="update_password_current_password"
                                    name="current_password"
                                    class="form-input @error('current_password', 'updatePassword') error @enderror"
                                    autocomplete="current-password"
                                >
                                @error('current_password', 'updatePassword')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="update_password_password" class="form-label">New Password</label>
                                <input
                                    type="password"
                                    id="update_password_password"
                                    name="password"
                                    class="form-input @error('password', 'updatePassword') error @enderror"
                                    autocomplete="new-password"
                                >
                                @error('password', 'updatePassword')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                                <input
                                    type="password"
                                    id="update_password_password_confirmation"
                                    name="password_confirmation"
                                    class="form-input @error('password_confirmation', 'updatePassword') error @enderror"
                                    autocomplete="new-password"
                                >
                                @error('password_confirmation', 'updatePassword')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-dark">
                                    {{ $user->hasPassword() ? 'Update Password' : 'Set Password' }}
                                </button>
                            </div>

                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success" style="margin-top:16px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Password {{ $user->hasPassword() ? 'updated' : 'set' }} successfully.
                                </div>
                            @endif
                        </form>
                    </div>
                </section>

                {{-- Delete Account Section --}}
                <section id="account-section" class="settings-section">

                    {{-- Connected Accounts --}}
                    <div class="settings-card" style="margin-bottom:24px;">
                        <h2>Connected Accounts</h2>
                        <p class="settings-card-description">Manage your linked social login providers.</p>

                        @error('google_disconnect')
                            <div class="alert alert-error" style="margin-bottom:16px;">{{ $message }}</div>
                        @enderror

                        @if(session('status') === 'google-disconnected')
                            <div class="alert alert-success" style="margin-bottom:16px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Google account disconnected successfully.
                            </div>
                        @endif

                        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:16px;border:1px solid #e5e7eb;border-radius:10px;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                {{-- Google logo --}}
                                <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" fill="#FFC107"/>
                                    <path d="M6.306 14.691l6.571 4.819C14.655 15.108 19.001 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z" fill="#FF3D00"/>
                                    <path d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0124 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" fill="#4CAF50"/>
                                    <path d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" fill="#1976D2"/>
                                </svg>
                                <div>
                                    <div style="font-size:15px;font-weight:500;color:#111;">Google</div>
                                    @if($user->isGoogleUser())
                                        <div style="font-size:13px;color:#16a34a;">✓ Connected — {{ $user->email }}</div>
                                    @else
                                        <div style="font-size:13px;color:#9ca3af;">Not connected</div>
                                    @endif
                                </div>
                            </div>

                            @if($user->isGoogleUser())
                                @if($user->hasPassword())
                                    <form method="POST" action="{{ route('auth.google.disconnect') }}"
                                          onsubmit="return confirm('Disconnect Google? You will need to use your email and password to sign in.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-sm" style="color:var(--danger);border-color:var(--danger);">
                                            Disconnect
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:12px;color:#9ca3af;max-width:200px;text-align:right;">
                                        Set a password first to disconnect Google
                                    </span>
                                @endif
                            @else
                                <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline btn-sm">
                                    Connect Google
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Delete Account --}}
                    <div class="settings-card settings-card-danger">
                        <h2>Delete Account</h2>
                        <p class="settings-card-description">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

                        <button type="button" class="btn btn-danger" onclick="showDeleteModal()">Delete Account</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="hideDeleteModal()"></div>
    <div class="modal-content">
        <h2>Are you sure?</h2>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>

        <form method="POST" action="{{ route('profile.destroy') }}" style="margin-top:24px;">
            @csrf
            @method('delete')

            @if(auth()->user()->hasPassword())
            <div class="form-group">
                <label for="password" class="form-label">Please enter your password to confirm</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input @error('password', 'userDeletion') error @enderror"
                    placeholder="Enter your password"
                >
                @error('password', 'userDeletion')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            @else
            <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;padding:12px 14px;font-size:13px;color:#92400e;margin-bottom:16px;">
                ⚠️ This will permanently delete your account and all your content.
            </div>
            @endif

            <div class="modal-actions">
                <button type="button" class="btn" onclick="hideDeleteModal()">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showSection(sectionName, event) {
    event.preventDefault();
    
    // Update navigation
    document.querySelectorAll('.settings-nav-item').forEach(item => {
        item.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
    
    // Update sections
    document.querySelectorAll('.settings-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionName + '-section').classList.add('active');
}

function showDeleteModal() {
    document.getElementById('delete-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function hideDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
    }
});

// Avatar preview function
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview-img');
            const placeholder = document.getElementById('avatar-preview-placeholder');
            
            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                // Replace placeholder with actual image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Avatar';
                img.className = 'avatar avatar-lg';
                img.id = 'avatar-preview-img';
                placeholder.parentNode.replaceChild(img, placeholder);
            }
        };
        reader.readAsDataURL(file);
    }
}
// Bio character counter
function updateBioCounter(textarea) {
    const counter = document.getElementById('bio-counter');
    const len = textarea.value.length;
    counter.textContent = len + '/160';
    counter.style.color = len > 140 ? '#ef4444' : 'var(--light-gray)';
}

// Initialise counter on page load
document.addEventListener('DOMContentLoaded', function() {
    const bio = document.getElementById('bio');
    if (bio) updateBioCounter(bio);
});
</script>
@endsection
