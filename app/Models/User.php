<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'bio',
        'avatar',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasLiked(Post $post): bool
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }

    /** True if the user has set a password (not an OAuth-only account). */
    public function hasPassword(): bool
    {
        return !is_null($this->password);
    }

    /** True if this account was created / linked via Google OAuth. */
    public function isGoogleUser(): bool
    {
        return !is_null($this->google_id);
    }

    /**
     * Returns the correct avatar URL:
     * - Google URL (starts with http) → returned as-is
     * - Local storage path → wrapped with Storage::url()
     * - null → null
     */
    public function avatarUrl(): ?string
    {
        if (!$this->avatar) {
            return null;
        }
        if (str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }
        return \Illuminate\Support\Facades\Storage::url($this->avatar);
    }
}
