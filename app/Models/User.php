<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'role',
        'status',
        'avatar',
        'phone',
        'address',
        'bio',
        'last_login_at',
        'last_login_ip',
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
            'last_login_at' => 'datetime',
            'status' => 'boolean',
        ];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'user_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'favorites')
            ->withPivot('status')
            ->wherePivot('status', 'active');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }

    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointsTransaction::class);
    }

    public function bookDownloads(): HasMany
    {
        return $this->hasMany(BookDownload::class);
    }

    public function bookViews(): HasMany
    {
        return $this->hasMany(BookView::class);
    }

    public function bookReadProgress(): HasMany
    {
        return $this->hasMany(BookReadProgress::class);
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    public function hasPurchased(Book $book): bool
    {
        return $this->purchases()->where('book_id', $book->id)->exists();
    }

    public function hasFavorited(Book $book): bool
    {
        return $this->favorites()->where('book_id', $book->id)->where('status', 'active')->exists();
    }

    public function hasReviewed(Book $book): bool
    {
        return $this->ratings()->where('book_id', $book->id)->exists();
    }

    public function deductPoints(int $points): bool
    {
        if ($this->points >= $points) {
            $this->decrement('points', $points);
            return true;
        }
        return false;
    }

    public function addPoints(int $points): void
    {
        $this->increment('points', $points);
    }
}
