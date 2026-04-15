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
                                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/gif" class="avatar-input" onchange="previewAvatar(event)">
                                        <label for="avatar" class="btn btn-outline btn-sm">Choose Photo</label>
                                        <span class="form-hint">JPG, PNG or GIF. Max 2MB.</span>
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
                                    placeholder="Write a short bio about yourself..."
                                >{{ old('bio', $user->bio) }}</textarea>
                                <span class="form-hint">Brief description for your profile. Maximum 160 characters.</span>
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
</script>
@endsection
