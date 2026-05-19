<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'bio',
        'image',
        'email',
        'website',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            if (empty($author->slug)) {
                $author->slug = Str::slug($author->name);
            }
        });
    }

    public function books(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_author')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function authoredBooks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->books();
    }

    public function getBooksCountAttribute(): int
    {
        return $this->authoredBooks()->count();
    }

    public function getAvgRatingAttribute(): float
    {
        $ratings = $this->authoredBooks()
            ->whereNotNull('rating_avg')
            ->where('rating_avg', '>', 0)
            ->pluck('rating_avg');

        if ($ratings->isEmpty()) return 0;

        return round($ratings->avg(), 1);
    }

    public function getTotalViewsAttribute(): int
    {
        return $this->authoredBooks()->sum('view_count');
    }
}
